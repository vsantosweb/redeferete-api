<?php

namespace App\Jobs;

use App\Notifications\Register\RegisterConfirmationNotification;
use App\Notifications\Register\RegisterRefusedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendMailConfirmationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public string $type, public $driver)
    {
        $this->driver = $driver;
        $this->type   = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        switch ($this->type) {
            case 'ACCEPTED':
                $this->driver->notify(
                    new RegisterConfirmationNotification(
                        $this->driver,
                        env('APP_URL_REGISTER_COMPLETE') . '?trackid=' . $this->driver->uuid
                    )
                );
                break;
            case 'REFUSED':
                Notification::route('mail', $this->driver->email)
                    ->notify(new RegisterRefusedNotification());
            default:
                // code...
                break;
        }
    }
}
