<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request){
        $request->validate([
            'username' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required'],
            'password_confirm' => ['required', 'same:password'],
        ]);
        
        if(User::where('email', $request->email)->exists()){
            return response()->json([
                'message' => 'Email already exist!'
            ]);
        }

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2,
            'picture_path' => 'pictures\profile.jpg',
        ]);

        return response()->json([
            'message' => 'Register success!'
        ]);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
     
        $user = User::where('email', $request->email)->first();
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json('Login failed!');
        }
     
        return response()->json([
            'message' => 'Login success!',
            'token' => $user->createToken('token_id')->plainTextToken
        ]);        
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout success!'
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
