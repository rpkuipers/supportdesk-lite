<?php

namespace Database\Factories;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        $priority = fake()->randomElement(TicketPriority::cases());

        return [
            'customer_id' => Customer::factory(),
            'category_id' => Category::factory(),
            'title' => fake()->randomElement([
                'Laptop start niet op',
                'Geen toegang tot mailbox',
                'Printer geeft foutmelding',
                'VPN verbinding valt weg',
                'Nieuwe gebruiker heeft rechten nodig',
            ]),
            'description' => fake()->paragraph(),
            'priority' => $priority,
            'status' => fake()->randomElement(TicketStatus::cases()),
            'due_at' => now()->addHours($priority->slaHours()),
        ];
    }
}
