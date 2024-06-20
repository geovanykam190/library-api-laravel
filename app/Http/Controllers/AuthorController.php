<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthorController extends Controller
{   
    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    public function index()
    {   
        $author = $this->author->all();

        if($author === null)
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "author not found"], 404));
        
        return response()->json(['msg' => 'success', 'return' => $author], 200);
    }

    public function store(Request $request)
    {   

        $validator = Validator::make($request->all(), $this->author->rules());
    
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => $validator->errors()], 422));
        }

        $author = $this->author->create($request->all());
        return response()->json(['msg' => 'success', 'return' => $author], 201);
    }

    public function show($id)
    {
       $author = $this->author->find($id);

       if($author === null)
        throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "author not found"], 404));
            
        return response()->json(['msg' => 'success', 'return' => $author], 200);
    }

    public function update(Request $request, $id)
    {
        $author = $this->author->find($id);

        if($author === null) 
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "author not found to update"], 404));

        $author->fill($request->all());

        if($author->save())
            return response()->json(['msg' => 'success', 'return' => $author], 200);
    }

    public function destroy($id)
    {
        $author = $this->author->find($id);

        if($author === null)
            throw new HttpResponseException(response()->json(['msg' => 'error', 'return' => "author not found to delete"], 404));
        

        $author->delete();
            return response()->json(['msg' => 'success', 'return' => "author deleted successfully"], 200);
    }
}
