<?php

namespace App\Console\Commands;

use App\Models\Event;
use GuzzleHttp\Promise\Each;
use Illuminate\Support\Str;
use Illuminate\Console\Command;

class SendEventRemainders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-remainders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notifications to all event attendees that the event is near.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::with('attendees.user')
        ->whereBetween('start_time',[now(), now()->addDay()])->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);
        $this->info("Found {$eventCount} {$eventLabel}");

        //notify attendees of each event
        $events->each(
            fn($event) => $event->attendees->each(
                fn($attendee) => $this->info("Notifying user: {$attendee->user->id} an event will happen soon")));

        $this->info('Reminder notifications sent successfully');
    }
}
