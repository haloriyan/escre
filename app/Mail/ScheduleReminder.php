<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user = null;
    public $schedule = null;

    public function __construct($props)
    {
        $this->user = $props['user'];
        $this->schedule = $props['schedule'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $now = Carbon::now();
        return $this->subject('Meeting '.$this->schedule->title.' akan Segera Dimulai!')
        ->view('emails.ScheduleReminder', [
            'user' => $this->user,
            'schedule' => $this->schedule
        ]);
    }
}
