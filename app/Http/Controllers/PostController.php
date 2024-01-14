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

        $data = [
            'content' => $request->content,
            'user_id' => Auth::user()->id
        ];

        if($request->hasFile('image')){
            $data['image_path'] = $request->file('image')->store('post_images');
        }

        Post::create($data);

        return response()->json([
            'message' => 'Post added!'
        ]);
    }

    public function show(){
        $posts = PostResource::collection(Post::all());
        return response()->json([
            'data' => $posts
        ]);
    }
    public function myPost(){
        $id = Auth::user()->id;
        $post = new PostResource(Post::findOrFail($id));
        return response()->json([
            'data' => $post
        ]);
    }
    public function postDetail($id){
        $post = new PostResource(Post::findOrFail($id));
        return response()->json([
            'data' => $post
        ]);
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

        $dataRequest = [
            'content' => $request->content,
        ];
        if($request->hasFile('image')){
            $dataRequest['image_path'] = $request->file('image')->store('post_images');
        }
        
        $post->update($dataRequest);
        
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
