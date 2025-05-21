<?php

namespace App\Http\Controllers;


use App\Models\BookModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Pest\Laravel\json;

class BookController extends Controller
{
    public function index(){
        $books = BookModel::all();

        if ($books ->isEmpty()){
            return response() ->json([
                'success' => true,
                'message' => 'Resource data not found!'
            ]);
            }
        
    return response() ->json([
            "success" => true,
            "message" => "Get All Resource",
            "data"    => $books
        ],200);
    }

    public function store(Request $request) {
        // 1. validator
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'cover_photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'genre_id' => 'required|exists:genres,id',
            'author_id' => 'required|exists:authors,id'
        ]);
    
        // 2. check error
        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ],422);
        }
    
        // 3. upload image
        $image = $request->file('cover_photo');
        $image->store('books', 'public');
    
        // 4. insert data
        $book = BookModel::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'cover_photo' => $image->hashName(),
            'genre_id' => $request->genre_id,
            'author_id' => $request->author_id,
        ]);
    
        // 5. Response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully',
            'data' => $book
        ], 201);
    }
    


}
