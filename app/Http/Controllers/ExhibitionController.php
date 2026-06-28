<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Category;

class ExhibitionController extends Controller
{
    public function show()
    {
    $categories = Category::all();
    return view('items.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        $file = $request->file('image');
        $filename = $file->hashName(); 
        $file->storeAs('items', $filename, 'public'); 

        $item = Item::create([
            'user_id'     => auth()->id(),
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'brand'       => $validated['brand'] ?? null,
            'description' => $validated['description'],
            'img_url'     => $filename, 
            'condition'   => $validated['condition'],
        ]);

        if (isset($validated['category'])) {
            $item->categories()->attach($validated['category']);
        }

        return redirect()->route('items.index')->with('message', '出品が完了しました！');
    }
}