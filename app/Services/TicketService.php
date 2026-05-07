<?php

namespace App\Services;

use App\Enums\TicketStatus;
use App\Exceptions\TicketAlreadyResolvedException;
use App\Models\Ticket; 
use Illuminate\Support\Facades\DB;
use RuntimeException;


class TicketService
{
    public function create(array $data): Ticket
    {
        return DB::transaction(function () use ($data): Ticket {
            $ticket = Ticket::create($data);

            $ticket->notes()->create([
                'author_name' => 'System',
                'body' => 'Ticket aangemaakt.',
                'is_internal' => true,
            ]);

            return $ticket;
        });
    }

    public function resolve(Ticket $ticket, string $note = 'Ticket opgelost.'): Ticket
    {
        //een opgelost ticket kan niet opnieuw worden opgelost
        if ($ticket->status === TicketStatus::Resolved) {
            throw TicketAlreadyResolvedException::forTicket($ticket->reference);
        }

        return DB::transaction(function () use ($ticket, $note): Ticket {
            $ticket->statusHistories()->create([
                'user_id' => auth()->id(),
                'old_status' => $ticket->status->value,
                'new_status' => TicketStatus::Resolved->value
            ]);
            $ticket->update([
                'status' => TicketStatus::Resolved->value,
                'resolved_at' => now(),
            ]);

            $ticket->notes()->create([
                'user_id' => auth()->id(),
                'author_name' => auth()->user()->name,
                'body' => $note,
                'is_internal' => false,
            ]);
            return $ticket->refresh();
        });
    }

    public function reopen(Ticket $ticket): Ticket
    {
        if ($ticket->status === TicketStatus::Open){
            throw new RuntimeException('Dit ticket is al geopend.');
        }
        if ($ticket->status !== TicketStatus::Resolved) {
            throw new RuntimeException('Alleen een opgelost ticket kan worden heropend.');
        }
        
        return DB::transaction(function () use ($ticket): Ticket {
            $ticket->statusHistories()->create([
                'user_id' => auth()->id(),
                'old_status' => $ticket->status->value,
                'new_status' => TicketStatus::Open->value
            ]);    

            $ticket->update([   
                'status' => TicketStatus::Open->value,
                'resolved_at' => null,
            ]);

            $ticket->notes()->create([
                'user_id' => auth()->id(),
                'author_name' => auth()->user()->name,
                'body' => 'Ticket opnieuw geopend.',
                'is_internal' => true,
            ]);

            
            return $ticket->refresh();
        });
    }

    public function selfassign(Ticket $ticket): Ticket
    {
        return DB::transaction(function () use ($ticket): Ticket {
            $user = auth()->user();
            // Een ticket mag maar door één supportmedewerker tegelijk opgepakt worden.
            if ($ticket->assigned_to !== null) {
                throw new RuntimeException('Dit ticket is al toegewezen.');
            }    
            $ticket->statusHistories()->create([
                'user_id' => auth()->id(),
                'old_status' => $ticket->status->value,
                'new_status' => TicketStatus::InProgress->value
            ]);

            $ticket->update([
                'status' => TicketStatus::InProgress->value,
                'assigned_to' => $user->id
            ]);

            $ticket->notes()->create([
                'user_id' => auth()->id(),
                'author_name' => $user->name,
                'body' => 'Ticket opgepakt door '.$user->name.'.',
                'is_internal' => true,
            ]);
            
            

            return $ticket->refresh();
        });
    }
}
