<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store($postId, Request $request){
        $request->validate([
            'content' => ['required']
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => Auth::user()->id,
            'post_id' => $postId,
        ]);

        return response()->json([
            'message' => 'Comment added!'
        ]);
    }

    public function show($postId){
        $comments = Comment::where('post_id', $postId)->get();
        $commentResource = CommentResource::collection($comments);

        $comments = CommentResource::collection(Comment::all());
        return response()->json([
            'data' => $commentResource
        ]);
    }
    public function commentDetail($id){
        $comment = new CommentResource(Comment::findOrFail($id));
        return response()->json([
            'data' => $comment
        ]);
    }

    public function update($id, Request $request){
        $comment = Comment::findOrFail($id);

        if($comment->user_id != Auth::user()->id){
            return response()->json([
                'message' => 'Update failed!'
            ]);
        }

        $request->validate([
            'content' => ['required']
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return response()->json([
            'message' => 'Update success!'
        ]);
    }
    public function destroy($id){
        $comment = Comment::findOrfail($id);
        if($comment->user_id != Auth::user()->id){
            return response()->json([
                'message' => 'Delete Comment failed!'
            ]);
        }

        $comment->delete();
        return response()->json([
            'message' => 'Comment deleted!'
        ]);
    }
}
