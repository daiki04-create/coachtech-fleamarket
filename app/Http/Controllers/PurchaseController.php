<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Charge;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
        
        $shipping = session('shipping_address', [
            'post_code' => $user->profile->postal_code ?? '',
            'address'   => $user->profile->address ?? '',
            'building'  => $user->profile->building ?? '',
        ]);

        return view('purchase.show', compact('item', 'shipping'));
    }

    public function store(PurchaseRequest $request, $item_id)
    {
        $validated = $request->validated();
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        DB::beginTransaction();

        try {
            $item = Item::where('id', $item_id)->lockForUpdate()->first();

            if ($item->is_sold) {
                return back()->with('error', 'この商品はすでに購入されています。');
            }

            if ($validated['payment_method'] === 'card') {
                \Stripe\PaymentIntent::create([
                    'amount'   => $item->price,
                    'currency' => 'jpy',
                    'payment_method_data' => [
                        'type' => 'card',
                        'card' => ['token' => $validated['stripeToken']],
                    ],
                    'confirm' => true,
                    'automatic_payment_methods' => [
                        'enabled' => true,
                        'allow_redirects' => 'never',
                    ],
                    'description' => '商品購入: ' . $item->name,
                ]);
            }

            Order::create([
                'user_id'        => Auth::id(),
                'item_id'        => $item->id,
                'payment_method' => $validated['payment_method'],
                'postal_code'    => $validated['post_code'], 
                'address'        => $validated['address'],
                'building'       => $validated['building'], 
            ]);

            $item->update(['is_sold' => true]);
            session()->forget('shipping_address');

            DB::commit();
            return redirect()->route('items.index')->with('success', '購入が完了しました！');

        } catch (\Stripe\Exception\CardException $e) {
            DB::rollBack();
            return back()->with('error', '決済が拒否されました: ' . $e->getError()->message);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('決済エラー: ' . $e->getMessage());
            return back()->with('error', '購入処理に失敗しました。');
        }
    }

    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();
    
        $shipping = session('shipping_address', [
            'post_code' => $user->profile->postal_code ?? '',
            'address'   => $user->profile->address ?? '',
            'building'  => $user->profile->building ?? '',
        ]);
    
    return view('purchase.address', compact('item_id', 'shipping')); 
    }

    public function updateAddress(AddressRequest $request, $item_id)
    {
        session(['shipping_address' => $request->validated()]);
        
        return redirect()->route('purchase.show', ['item_id' => $item_id]);
    }
}