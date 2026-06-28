@extends('layouts.app')

@section('content')
<style>
    .purchase-container { display: flex; gap: 60px; max-width: 1000px; margin: 40px auto; padding: 0 20px; align-items: flex-start; }
    .purchase-left { flex: 2; }
    .purchase-right { flex: 1; border: 1px solid #ddd; padding: 30px; border-radius: 8px; background: #fff; height: fit-content; }
    .item-img { width: 150px; height: 150px; object-fit: cover; border-radius: 4px; }
    .section-title { font-size: 18px; margin-bottom: 20px; font-weight: bold; }
    .summary-row { display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 16px; }
    .buy-btn { width: 100%; padding: 15px; background-color: #ff4d4d; color: #fff; border: none; font-weight: bold; cursor: pointer; border-radius: 4px; font-size: 16px; }
</style>

<div class="purchase-container">
    <form action="{{ route('purchase.store', $item->id) }}" method="POST" id="payment-form" style="display: contents;">
        @csrf
        
        <div class="purchase-left">
            @if ($errors->any())
                <div style="color: red; margin: 10px 0;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="hidden" name="post_code" value="{{ $shipping['post_code'] }}">
            <input type="hidden" name="address" value="{{ $shipping['address'] }}">
            <input type="hidden" name="building" value="{{ $shipping['building'] }}">

            <div style="display: flex; gap: 25px; border-bottom: 1px solid #eee; padding-bottom: 25px; margin-bottom: 30px;">
                <img src="{{ asset('storage/items/' . rawurlencode($item->img_url)) }}" alt="{{ $item->name }}" class="item-img">
                <div style="display: flex; flex-direction: column; justify-content: center;">
                    <p style="font-weight:bold; font-size: 20px; margin-bottom: 10px;">{{ $item->name }}</p>
                    <p style="font-size: 18px; color: #333;">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div style="margin: 30px 0;">
                <h3 class="section-title">支払い方法</h3>
                <select name="payment_method" id="payment_method" style="width: 100%; padding: 10px; border: 1px solid #ccc;">
                    <option value="">選択してください</option>
                    <option value="card" @if(old('payment_method') == 'card') selected @endif>カード支払い</option>
                    <option value="konbini" @if(old('payment_method') == 'konbini') selected @endif>コンビニ払い</option>
                </select>
                <div id="card-element" style="margin: 20px 0; display:none; padding: 10px; border: 1px solid #ccc;"></div>
                <div id="card-errors" style="color:red; margin-top:10px;"></div>
                <input type="hidden" name="stripeToken" id="stripeToken">
            </div>

            <div>
                <div style="display:flex; justify-content:space-between;">
                    <h3 class="section-title">配送先</h3>
                    <a href="{{ route('purchase.editAddress', $item->id) }}" style="color:#ff4d4d; text-decoration:none;">変更する</a>
                </div>
                <p>〒{{ $shipping['post_code'] }}</p>
                <p>{{ $shipping['address'] }} {{ $shipping['building'] }}</p>
            </div>
        </div>

        <div class="purchase-right">
            <div class="summary-row"><span>商品代金</span><span>¥{{ number_format($item->price) }}</span></div>
            <div class="summary-row"><span>支払い方法</span><span id="display-payment">選択してください</span></div>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
            <button type="button" id="submit-button" class="buy-btn">購入を確定する</button>
        </div>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const card = stripe.elements().create('card', { hidePostalCode: true });
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');

        document.getElementById('payment_method').addEventListener('change', function() {
            const isCard = this.value === 'card';
            document.getElementById('card-element').style.display = isCard ? 'block' : 'none';
            document.getElementById('display-payment').textContent = 
                isCard ? 'カード支払い' : (this.value === 'konbini' ? 'コンビニ払い' : '選択してください');
        });

        submitButton.addEventListener('click', async () => {
            const method = document.getElementById('payment_method').value;
            if (!method) { alert('支払い方法を選択してください'); return; }

            submitButton.disabled = true;
            submitButton.textContent = '処理中...';

            if (method === 'konbini') {
                form.submit();
            } else {
                const {token, error} = await stripe.createToken(card);
                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = '購入を確定する';
                } else {
                    document.getElementById('stripeToken').value = token.id;
                    form.submit();
                }
            }
        });
    });
</script>
@endsection