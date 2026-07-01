<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'buy');

        if ($page === 'sell') {
            $items = $user->items ?? collect();
        } else {
            $items = ($user->orders ?? collect())->map(function($order) {
                return $order->item;
            });
        }
        
        return view('mypage.profile', compact('user', 'items', 'page'));
    }

    public function update(ProfileRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        $user->update(['name' => $data['name']]);

        $profileData = [
            'postal_code' => $data['postal_code'],
            'address'     => $data['address'],
            'building'    => $data['building'],
        ];

        if ($request->hasFile('img_url')) {
            $profileData['img_url'] = $request->file('img_url')->store('profiles', 'public');
        }

        $user->profile()->updateOrCreate(['user_id' => $user->id], $profileData);

        return redirect('/')->with('message', 'プロフィールを更新しました！');
    }

    public function showList(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page', 'sell');

        if ($page === 'sell') {
            $items = $user->items ?? collect();
        } else {
            $items = $user->orders->pluck('item')->filter()->values();
        }
        
        return view('mypage.show_list', compact('user', 'items', 'page'));
    }
}