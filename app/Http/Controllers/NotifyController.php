<?php

namespace App\Http\Controllers;


use Mail;
use Carbon\Carbon;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use App\Models\Notification;
use App\Mail\ScheduleConfirmation;
use App\Mail\ScheduleReminder;
use Illuminate\Http\Request;

class NotifyController extends Controller
{
    public static function get($filter = NULL) {
        if ($filter == NULL) {
            return new Notification;
        }
        return Notification::where($filter);
    }
    public static function scheduleConfirmation($data, $status) {
        $schedule = $data->with(['connection.secretaries','connection.headships'])->first();
        $headship = $schedule->connection->secretaries;
        $secretary = $schedule->connection->headships;
        
        $sendMail = Mail::to($secretary->email)->send(new ScheduleConfirmation([
            'secretary' => $secretary,
            'headship' => $headship,
            'schedule' => $schedule,
            'status' => $status,
        ]));

        $createNotif = Notification::create([
            'user_id' => $secretary->id,
            'body' => "Schedule ".$schedule->title." ".$status." oleh ".$headship->name,
            'action' => route('user.schedule', ['id' => $schedule->id]),
        ]);
        
        return $sendMail;
    }
    public static function reminder($schedule) {
        $secretary = $schedule->connection->headships;
        $headship = $schedule->connection->secretaries;
        $date = Carbon::parse($schedule->date);

        // $secretary->webpush_data = json_decode(base64_decode($secretary->webpush_data));
        $headship->webpush_data = json_decode(base64_decode($headship->webpush_data));

        // $notifications[] = [
        //     'subscription' => Subscription::create([
        //         'endpoint' => $secretary->webpush_data->endpoint
        //     ]),
        //     'payload' => "Halo secretary"
        // ];
        $notifications[] = [
            'subscription' => Subscription::create([
                'endpoint' => $headship->webpush_data->endpoint
            ]),
            'payload' => "Halo headship"
        ];
        $webPush = new WebPush();
        foreach ($notifications as $notification) {
            $webPush->queueNotification($notification['subscription'], $notification['payload']);
        }

        // $sendMailSecretary = Mail::to($secretary->email)->send(new ScheduleReminder([
        //     'schedule' => $schedule,
        //     'user' => $secretary
        // ]));
        // $sendMailHeadship = Mail::to($headship->email)->send(new ScheduleReminder([
        //     'schedule' => $schedule,
        //     'user' => $headship
        // ]));

        $notifySecretary = Notification::create([
            'user_id' => $secretary->id,
            'body' => "Schedule Anda ".$schedule->title." akan segera dimulai pada ".$date->format('H:i'),
            'action' => route('user.schedule', ['id' => $schedule->id]),
        ]);
        $notifySecretary = Notification::create([
            'user_id' => $headship->id,
            'body' => "Schedule Anda ".$schedule->title." akan segera dimulai pada ".$date->format('H:i'),
            'action' => route('user.schedule', ['id' => $schedule->id]),
        ]);
    }
}
