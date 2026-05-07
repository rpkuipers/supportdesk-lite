<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Ticket;
use App\Models\TicketNote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $hardware = Category::create([
            'name' => 'Hardware',
            'description' => 'Laptops, desktops, printers en randapparatuur.',
        ]);

        $software = Category::create([
            'name' => 'Software',
            'description' => 'Applicaties, licenties en installaties.',
        ]);

        $network = Category::create([
            'name' => 'Netwerk',
            'description' => 'Wifi, bekabeling, VPN en internetverbindingen.',
        ]);

        $customerA = Customer::create([
            'name' => 'De Vries Administratie',
            'email' => 'info@devries.test',
            'phone' => '0183-123456',
            'company' => 'De Vries Administratie',
        ]);

        $customerB = Customer::create([
            'name' => 'Bakker Transport',
            'email' => 'support@bakkertransport.test',
            'phone' => '0183-654321',
            'company' => 'Bakker Transport',
        ]);

        $ticket1 = Ticket::create([
            'customer_id' => $customerA->id,
            'category_id' => $hardware->id,
            'title' => 'Laptop start niet meer op',
            'description' => 'Gebruiker meldt dat de laptop blijft hangen op een zwart scherm.',
            'status' => 'open',
            'priority' => 'high',
            'due_at' => now()->addDay(),
        ]);

        $ticket2 = Ticket::create([
            'customer_id' => $customerB->id,
            'category_id' => $network->id,
            'title' => 'VPN verbinding valt steeds weg',
            'description' => 'Tijdens thuiswerken valt de VPN-verbinding meerdere keren per uur weg.',
            'status' => 'in_progress',
            'priority' => 'normal',
            'due_at' => now()->addDays(2),
        ]);

        $ticket3 = Ticket::create([
            'customer_id' => $customerA->id,
            'category_id' => $software->id,
            'title' => 'Nieuwe gebruiker heeft Office nodig',
            'description' => 'Nieuwe medewerker moet toegang krijgen tot Microsoft Office.',
            'status' => 'resolved',
            'priority' => 'low',
            'due_at' => now()->subDay(),
            'resolved_at' => now(),
        ]);

        TicketNote::create([
            'ticket_id' => $ticket1->id,
            'author_name' => 'Ronald',
            'body' => 'Gebruiker gevraagd of de adapter getest is op een ander stopcontact.',
            'is_internal' => true,
        ]);

        TicketNote::create([
            'ticket_id' => $ticket2->id,
            'author_name' => 'Ronald',
            'body' => 'VPN-profiel gecontroleerd. Mogelijk probleem met thuisnetwerk of timeout.',
            'is_internal' => true,
        ]);

        TicketNote::create([
            'ticket_id' => $ticket3->id,
            'author_name' => 'Ronald',
            'body' => 'Licentie toegewezen en installatie-instructies gestuurd.',
            'is_internal' => false,
        ]);
    }
}