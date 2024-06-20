<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

use App\Models\LoanBook;

class ContactMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $loanBook;
    private $data;
    /**
     * Create a new job instance.
     */
    public function __construct($loanBook)
    {   
        $this->data = $loanBook;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sent = Mail::to($this->data['email'], '')->send(new ContactMail([
            'fromName' => "Laravel Books",
            'fromEmail' => 'sendmail@moosetech.com.br',
            'to' => $this->data['email'],
            'subject' => 'emprestimo de livro',
            'name' => $this->data['name'],
            'title' => $this->data['title'],
            'loan_date' => $this->data['loan_date'],
            'return_date' => $this->data['return_date'],
            'status' => $this->data['status']
        ]));
    }
}
