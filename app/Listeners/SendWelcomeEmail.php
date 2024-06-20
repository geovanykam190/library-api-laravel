<?php

namespace App\Listeners;

use App\Events\BookRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
// use App\Mail\ContactMail;
use App\Jobs\ContactMailJob;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookRegistered $event): void
    {
        // $sent = Mail::to($event->loanBook->email, '')->send(new ContactMail([
        //     'fromName' => "Laravel Books",
        //     'fromEmail' => 'sendmail@moosetech.com.br',
        //     'to' => $event->loanBook->email,
        //     'subject' => 'emprestimo de livro',
        //     'name' => $event->loanBook->name,
        //     'title' => $event->loanBook->title,
        //     'loan_date' => $event->loanBook->loan_date,
        //     'json' => json_encode($event->loanBook)
        // ]));
        ContactMailJob::dispatch($event)->delay(now()->addSeconds('1'));
    }
}
