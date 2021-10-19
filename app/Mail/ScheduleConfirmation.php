<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ScheduleConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $secretary = null;
    public $schedule = null;
    public $headship = null;
    public $status = null;

    public function __construct($props)
    {
        $this->secretary = $props['secretary'];
        $this->schedule = $props['schedule'];
        $this->headship = $props['headship'];
        $this->status = $props['status'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Schedule '.$this->schedule->title.' '.$this->status)
        ->view('emails.ScheduleConfirmation', [
            'secretary' => $this->secretary,
            'headship' => $this->headship,
            'schedule' => $this->schedule,
            'status' => $this->status,
        ]);
    }
}
