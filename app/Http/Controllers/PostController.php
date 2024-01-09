<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'content' => ['required'],
        ]);

        Post::create([
            'content' => $request->content,
            'user_id' => Auth::user()->id
        ]);
        return response()->json([
            'message' => 'Post added!'
        ]);
    }

    public function postDetail(){
        $posts = PostResource::collection(Post::all());
        return response()->json($posts);
    }
    public function show($id){
        $post = new PostResource(Post::findOrFail($id));
        return response()->json($post);
    }
    
    public function update($id, Request $request){
        $post = Post::findOrFail($id);
        if($post->user_id != Auth::user()->id){
            return response()->json([
                'message' => 'Update Post failed!'
            ]);
        }

        $request->validate([
            'content' => ['required'],
        ]);

        $post->update([
            'content' => $request->content,
        ]);
        return response()->json([
            'message' => 'Update success!'
        ]);
    }

    public function destroy($id){
        $post = Post::find($id);
        if($post->user_id != Auth::user()->id){
            return response()->json([
                'message' => 'Delete Post failed!'
            ]);
        }

        $post->delete();
        return response()->json([
            'message' => 'Post deleted!'
        ]);
    }
}
