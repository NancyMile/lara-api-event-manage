<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $events = \App\Models\Event::all();

        foreach($users as $user){

            // each user will select between 1 to 3 random events
            $eventsToAttend = $events->random(rand(1,3));

            foreach($eventsToAttend as $event)
            {
                //attendee has no factory as attendee depends on the user and the actual event
                \App\Models\Attendee::create([
                    'user_id' => $user->id,
                    'event_id' => $event->id
                ]);
            }
        }
    }
}
