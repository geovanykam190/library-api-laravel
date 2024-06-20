<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Models\LoanBook;
use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\ContactController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use App\Events\BookRegistered;
use App\Jobs\ContactMailJob;

class LoanBookController extends Controller
{
    public function __construct(LoanBook $loanBook, User $user, Book $book)
    {
        $this->loanBook = $loanBook;
        $this->user = $user;
        $this->book = $book;
    }

    public function index()
    {
        $loanBook = DB::table('loan_books')
        ->join('users', 'users.id', '=', 'loan_books.user_id')
        ->join('books', 'books.id', '=', 'loan_books.book_id')
        ->select('users.name', 'books.title', 'loan_books.loan_date','loan_books.return_date')
        ->get();

        if($loanBook === null)
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "no books were loaned"], 404));
        
        return response()->json(['msg' => 'success', 'return' => $loanBook], 200);    
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->loanBook->rulesStore());
    
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => $validator->errors()], 422));
        }

        $loanBook = $this->loanBook->create($request->all());

        $user = $this->user->find($loanBook->user_id);
        $loanBook->email = $user->email;
        $loanBook->name = $user->name;

        $book = $this->book->find($loanBook->book_id);
        $loanBook->title = $book->title;


        $dataBook['name'] = $loanBook->name;
        $dataBook['title'] = $loanBook->title;
        $dataBook['loan_date'] = $loanBook->loan_date;
        $dataBook['return_date'] = $loanBook->return_date;
        $dataBook['email'] = $loanBook->email;
        $dataBook['status'] = 'emprestimo';
        
        ContactMailJob::dispatch($dataBook)->delay(now()->addSeconds('1'));
        // event(new BookRegistered($loanBook));

        return response()->json(['msg' => 'success', 'return' => $loanBook], 201);
    }

    public function show($id)
    {
        $loanBook = DB::table('loan_books')
        ->join('users', 'users.id', '=', 'loan_books.user_id')
        ->join('books', 'books.id', '=', 'loan_books.book_id')
        ->select('users.name', 'books.title', 'loan_books.loan_date','loan_books.return_date')
        ->where('loan_books.id', $id)
        ->get();

        if(empty($loanBook[0]))
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "no book was loaned with this ID"], 404));
        
        return response()->json(['msg' => 'success', 'return' => $loanBook], 200);
    }

    public function update(Request $request, $id)
    {
        $loanBook = $this->loanBook->find($id);

        $validator = Validator::make($request->all(), $this->loanBook->rulesUpdate());
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => $validator->errors()], 422));
        }

        if($loanBook === null) 
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "loaned book not found to update"], 404));

        $loanBook->fill($request->all());

        if($loanBook->save()){
            $user = $this->user->find($loanBook->user_id);
            $loanBook->email = $user->email;
            $loanBook->name = $user->name;

            $book = $this->book->find($loanBook->book_id);
            $loanBook->title = $book->title;

            $dataBook['name'] = $loanBook->name;
            $dataBook['title'] = $loanBook->title;
            $dataBook['loan_date'] = $loanBook->loan_date;
            $dataBook['return_date'] = $loanBook->return_date;
            $dataBook['email'] = $loanBook->email;
            $dataBook['status'] = 'devolucao';

            ContactMailJob::dispatch($dataBook)->delay(now()->addSeconds('1'));

            return response()->json(['msg' => 'success', 'return' => $loanBook], 200);
        }
    }

    public function destroy(LoanBook $loanBook)
    {
        //
    }
}
