<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('supportdesk:stats', function () {
    $this->info('Open tickets: '.App\Models\Ticket::open()->count());
    $this->info('Resolved tickets: '.App\Models\Ticket::where('status', App\Enums\TicketStatus::Resolved)->count());
})->purpose('Show ticket statistics');
