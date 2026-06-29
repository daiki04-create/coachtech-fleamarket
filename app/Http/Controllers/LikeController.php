<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Item;

class LikeController extends Controller
{
    public function toggle(Item $item)
    {
        $userId = auth()->id();

        Like::where('user_id', $userId)
            ->where('item_id', $item->id)
            ->delete() ?: Like::create([
                'user_id' => $userId,
                'item_id' => $item->id,
            ]);

        return back();
    }
}
