<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{

    public function index()
    {
        
    }

    public function store(Request $request)
    {
        // $sent = Mail::to('teste@teste.com', 'Geovany')->queue(new ContactMail([
        //     'fromName' => "Teste",
        //     'fromEmail' => 'sendmail@moosetech.com.br',
        //     'to' => 'teste@teste.com',
        //     'subject' => 'emprestimo de livro',
        //     'name' => 'name do livro',
        //     'title' => 'titulo do livro',
        //     'loan_date' => '2024-06-10',
        //     'json' => ''
        // ]));
    }


    public function show(Contact $contact)
    {
        
    }


    public function update(Request $request, Contact $contact)
    {
        
    }

    public function destroy(Contact $contact)
    {
       
    }
}
