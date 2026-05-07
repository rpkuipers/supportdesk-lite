<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Exceptions\TicketAlreadyResolvedException;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TicketController extends Controller
{
    public function __construct(private readonly TicketService $tickets)
    {
    }

    public function index(Request $request): View
    {
        return $this->ticketList($request, false);
    }

    public function myTickets(Request $request): View
    {
        return $this->ticketList($request, true);
    }

    //laten zien van de ticket lijst. $onlyMine kijkt of alleen persoonlijke tickets worden laten zien en word gevuld liggend aan of de route /tickets.index of /tickets.my word genomen
    //status en priority worden gefilterd alleen wanneer het ingevuld is, en als search is ingevuld word ook gecheckd of $includeDescription gevuld is.
    //Zo ja, zorg dan dat ook de description word doorzocht.
    public function ticketList(Request $request, bool $onlyMine): View
    {
        //dd($request->all());
        
        $tickets = Ticket::query()
            ->with(['customer', 'category', 'creator', 'assignee'])
            ->when($onlyMine, fn ($query) => $query->where('assigned_to', auth()->id()))
            ->when($request->string('status')->isNotEmpty(), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->string('priority')->isNotEmpty(), fn ($query) => $query->where('priority', $request->string('priority')))
            ->when($request->string('search')->isNotEmpty(), function ($query) use ($request) {
                $search = trim($request->input('search', ''));
                $includeDescription = $request->boolean('include_description');
                $query->where(function ($query) use ($search, $includeDescription) {
                    $query->where('title','like', "%{$search}%")
                          ->orWhere('reference','like',"%{$search}%");
                    if($includeDescription){
                        $query->orWhere('description', 'like', "%{$search}%");
                    }
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tickets.index', [
            'tickets' => $tickets,
            'statuses' => TicketStatus::cases(),
            'priorities' => TicketPriority::cases(),
            'onlyMine' => $onlyMine
        ]);
    }
    
    public function create(): View
    {
        return view('tickets.create', [
            'customers' => Customer::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'users' => user::orderBy('name')->get(),
            'priorities' => TicketPriority::cases(),
            'statuses' => TicketStatus::cases(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $priority = TicketPriority::from($validated['priority']);
        $validated['due_at'] = now()->addHours($priority->slaHours());
        $validated['status'] = TicketStatus::Open;
        $validated['created_by'] = auth()->id();

        $ticket = $this->tickets->create($validated);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket aangemaakt.');
    }

    public function show(Ticket $ticket): View
    {
        return view('tickets.show', [
            'ticket' => $ticket->load(['customer', 'category', 'notes', 'creator', 'assignee']),
        ]);
    }

    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', [
            'ticket' => $ticket,
            'customers' => Customer::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'users' => User::orderBy('name')->get(),
            'priorities' => TicketPriority::cases(),
            'statuses' => TicketStatus::cases(),
        ]);
    }

    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $validated = $this->validatedData($request, includeStatus: true);
        $ticket->update($validated);

        if ($request->filled('note')) {
            $ticket->notes()->create([
                'author_name' => $request->input('author_name', 'Support'),
                'body' => $request->string('note'),
                'is_internal' => $request->boolean('is_internal'),
            ]);
        }

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket bijgewerkt.');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket verwijderd.');
    }

    public function resolve(Request $request, Ticket $ticket): RedirectResponse
    {
        //even checken of de ticket niet al resolved is
        try {
            $this->tickets->resolve($ticket, $request->string('resolution_note', 'Ticket opgelost.'));
        } catch (TicketAlreadyResolvedException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Ticket opgelost.');
    }

    public function reopen(Ticket $ticket): RedirectResponse
    {
        $this->tickets->reopen($ticket);

        return back()->with('success', 'Ticket opnieuw geopend.');
    }

    public function selfassign(Ticket $ticket): RedirectResponse
    {
        $this->tickets->selfassign($ticket);
        
        return back()->with('success', 'Ticket opgepakt.');
    }
    
    public function addNote(Ticket $ticket, Request $request): RedirectResponse
    {
        if ($request->filled('new_note')) {
            $ticket->notes()->create([
                'author_name' => auth()->user()->name,
                'user_id' => auth()->id(),
                'body' => $request->string('new_note'),
                'is_internal' => $request->boolean('is_internal'),
            ]);
        }
        return back()->with('success', 'Notitie toegevoegd.');

    }
    private function validatedData(Request $request, bool $includeStatus = false): array
    {
        $rules = [
            'customer_id' => ['required', 'exists:customers,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'min:5', 'max:150'],
            'description' => ['required', 'string', 'min:10'],
            'priority' => ['required', Rule::enum(TicketPriority::class)],
            'assigned_to' => ['nullable', 'exists:users,id'],
        ];

        if ($includeStatus) {
            $rules['status'] = ['required', Rule::enum(TicketStatus::class)];
        }

        return $request->validate($rules);
    }
}
