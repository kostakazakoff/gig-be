<?php

namespace App\Jobs;

use App\Mail\GenericMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $email, public $message = null, public $language = 'en')
    {
        $this->language = config('app.locale', 'en') ?? $this->language;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $defaultMessage = $this->language === 'BG'
            ? 'Това е стандартно съобщение.'
            : 'This is a generic message.';

        Mail::to($this->email)->send(
            new GenericMail($this->message ?? $defaultMessage, $this->language)
        );
    }
}
