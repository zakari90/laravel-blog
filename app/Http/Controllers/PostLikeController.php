<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Like;

class PostLikeController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'type' => 'required|in:like,dislike',
        ]);

        $isLike = $validated['type'] === 'like';
        $userId = auth()->id();

        // Check if user already liked/disliked
        $existingLike = Like::where('user_id', $userId)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            if ($existingLike->is_like === $isLike) {
                // If clicked the same option -> toggle OFF (delete)
                $existingLike->delete();
                $message = 'Reaction removed!';
            } else {
                // If clicked opposite option -> change reaction
                $existingLike->update(['is_like' => $isLike]);
                $message = 'Reaction updated!';
            }
        } else {
            // Create a new like/dislike entry
            Like::create([
                'user_id' => $userId,
                'post_id' => $post->id,
                'is_like' => $isLike,
            ]);
            $message = $isLike ? 'Post liked!' : 'Post disliked!';
        }

        return back()->with('success', $message);
    }
}
