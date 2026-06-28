<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Request $request, $item_id)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)->where('item_id', $item_id)->first();

        $like ? $like->delete() : Like::create([
            'user_id' => $user->id,
            'item_id' => $item_id,
        ]);

        return back();
    }
}
