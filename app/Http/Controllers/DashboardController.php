<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('dashboard.index', [
            'openCount' => Ticket::open()->count(),
            'overdueCount' => Ticket::overdue()->count(),
            'resolvedCount' => Ticket::whereNotNull('resolved_at')->count(),
            'recentTickets' => Ticket::with(['customer', 'category', 'creator', 'assignee'])->latest()->take(8)->get(),
        ]);
    }
}
