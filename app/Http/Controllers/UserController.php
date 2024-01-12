<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function loggedUser(){
        $id = Auth::user()->id;
        $user = new UserResource(User::findOrFail($id));

        return response()->json([
            'data' => $user
        ]);
    }
    public function show(){
        $users = UserResource::collection(User::all());

        return response()->json([
            'data' => $users
        ]);
    }

    public function detail($id){
        $user = new UserResource(User::findOrFail($id));

        return response()->json([
            'data' => $user
        ]);
    }

    
    public function update($id, Request $request){
        if($id != Auth::user()->id){
            return response()->json([
                'message' => 'Update failed!'
            ]);
        }

        $request->validate([
            
        ]);
        
        $data = User::findOrFail($id);

        $data->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);
        return response()->json([
            'message' => 'Update success!'
        ]);
    }
    public function updatePicture($id, Request $request){
        if($id != Auth::user()->id){
            return response()->json([
                'message' => 'Update failed!'
            ]);
        }

        $request->validate([
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        
        $data = User::findOrFail($id);

        if($data->picture_path != 'pictures\profile.jpg'){
            Storage::delete($data->picture_path);
        }


        $data->update([
            'picture_path' => $request->file('picture')->store('pictures'),
        ]);

        return response()->json([
            'message' => 'Update success!'
        ]);
    }
}
