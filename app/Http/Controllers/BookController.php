<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookController extends Controller
{   

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function index()
    {
        $book = $this->book->with('authors')->get();

        if($book === null)
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "book not found"], 404));
        
        return response()->json(['msg' => 'success', 'return' => $book], 200);    
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->book->rulesStore());
    
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => $validator->errors()], 422));
        }

        $book = $this->book->create([
            'title' => $request->title,
            'publication_year' => $request->publication_year
        ]);

        if($book->id){
            foreach ($request->author_id as $key => $value) {
                $bookAuthors = DB::table('book_authors')
                ->insert(['book_id' => $book->id,'author_id' => $value]);
            }
        }
        return response()->json(['msg' => 'success', 'return' => $book], 201);
    }

    public function show($id)
    {
        $book = $this->book->with('authors')->find($id);
        
        if($book === null)
         throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "book not found"], 404));
             
         return response()->json(['msg' => 'success', 'return' => $book], 200);
    }

    

    public function update(Request $request, $id)
    {
        $book = $this->book->find($id);

        $validator = Validator::make($request->all(), $this->book->rulesUpdate());
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => $validator->errors()], 422));
        }

        if($book === null) 
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "book not found to update"], 404));

        $book->fill($request->all());

        if($book->save()){
            if(!empty($request->author_id)){
                $bookAuthorsDelete = DB::table('book_authors')
                ->where('book_id', $book->id)->delete();

                foreach ($request->author_id as $key => $value) {
                    $bookAuthors = DB::table('book_authors')
                    ->insert(['book_id' => $book->id,'author_id' => $value]);
                }

            }
            return response()->json(['msg' => 'success', 'return' => $book], 200);
        }
            
    }

    public function destroy($id)
    {
        $book = $this->book->find($id);

        if($book === null)
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "book not found to delete"], 404));
        
        $book->delete();
        
        return response()->json(['msg' => 'success', 'return' => "book deleted successfully"], 200);
    }
}
