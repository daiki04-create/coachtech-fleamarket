<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $tab = $request->input('tab');

        $query = Item::query();

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        if (!empty($keyword)) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        }

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                $items = collect(); 
            } else {
                $items = $query->whereHas('likes', function($q) {
                    $q->where('user_id', Auth::id());
                })->get();
            }
        } else {
            $items = $query->get();
        }

        return view('items.index', compact('items', 'keyword', 'tab'));
    }

    public function show($item_id)
    {
        $item = Item::with(['categories', 'likes', 'comments'])->findOrFail($item_id);

        return view('items.show', compact('item'));
    }

    public function comment(CommentRequest $request, $item_id)
    {
        $validated = $request->validated();

        $request->user()->comments()->create([
            'item_id' => $item_id,
            'comment' => $validated['comment'],
        ]);

        return back()->with('message', 'コメントを送信しました。');
    }
}