<?php

namespace Database\Factories;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketNoteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'author_name' => fake()->name(),
            'body' => fake()->paragraph(),
            'is_internal' => fake()->boolean(35),
        ];
    }
}
