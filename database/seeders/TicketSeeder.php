<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Event::all() as $event) {
            $early_price = rand(10, 29);
            Ticket::create([
                'event_id' => $event->id,
                'title' => 'Early Bird Ticket',
                'amount' => 100,
                'available_from' => Carbon::parse($event->start_time)->subYear(10)->toDateString(),
                'available_to' => Carbon::parse($event->start_time)->subYear(5)->toDateString(),
                'price' => $early_price,
            ]);
            Ticket::create([
                'event_id' => $event->id,
                'title' => 'Regular Ticket',
                'amount' => 1000,
                'available_from' => Carbon::parse($event->start_time)->subYear(4)->toDateString(),
                'available_to' => Carbon::parse($event->start_time)->toDateString(),
                'price' => $early_price * 1.2,
            ]);
        }
    }
}
