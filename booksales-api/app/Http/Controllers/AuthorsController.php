<?php

namespace App\Http\Controllers;

use App\Models\AuthorsModel; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function Pest\Laravel\json;

class AuthorsController extends Controller
{
    public function index(){
        $authors = AuthorsModel::all() ;

        if ($authors ->isEmpty()){
            return response() ->json([
                'success' => true,
                'message' => 'Resource data not found!'
            ]);
            }
        
        return response() ->json([
            "success" => true,
            "message" => "Get All Resource",
            "data"    => $authors
        ],200); 
    }
    public function store(Request $request) {
        // 1. validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'bio' => 'required|string', 
        ]);
    
        // 2. check error
        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ],422);
        }
    
        // 3. upload image
        $image = $request->file('photo');
        $image->store('authors', 'public');
    
        // 4. insert data
        $authors = AuthorsModel::create([
            'name' => $request->name,
            'photo' => $image->hashName(),
            'bio' => $request->bio,
        ]);
    
        // 5. Response
        return response()->json([
            'success' => true,
            'message' => 'Resource added successfully',
            'data' => $authors
        ], 201);
    }
}
