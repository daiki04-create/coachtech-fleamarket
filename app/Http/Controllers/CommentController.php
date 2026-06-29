<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest; 
use App\Models\Item;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item)
    {
        $item->comments()->create([
        'user_id' => auth()->id(),
        'comment' => $request->validated()['comment'],
        ]);

    return back()->with('message', 'コメントを投稿しました！');
    }
}
