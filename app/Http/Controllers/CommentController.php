<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class CommentController extends Controller
{
    public function store(Request $request, Item $item)
    {
    $request->validate(['comment' => 'required|max:255']);

    $item->comments()->create([
        'user_id' => auth()->id(),
        'comment' => $request->comment,
    ]);

    return back()->with('message', 'コメントを投稿しました！');
    }
}
