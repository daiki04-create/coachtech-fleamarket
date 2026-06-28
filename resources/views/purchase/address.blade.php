@extends('layouts.app')

@section('content')
<style>
    .address-container { max-width: 600px; margin: 40px auto; padding: 0 20px; }
    .form-group { margin-bottom: 30px; }
    .form-group label { display: block; font-weight: bold; margin-bottom: 10px; }
    .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; }
    .update-btn { width: 100%; padding: 15px; background-color: #ff4d4d; color: #fff; border: none; font-weight: bold; cursor: pointer; border-radius: 4px; font-size: 16px; }
</style>

<div class="address-container">
    <h2 style="text-align: center; margin-bottom: 40px;">住所の変更</h2>
    
    <form action="{{ route('purchase.updateAddress', ['item_id' => $item_id]) }}" method="POST" id="address-form">
        @csrf
        
        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="post_code" id="post_code" 
                   value="{{ old('post_code', $shipping['post_code'] ?? '') }}" 
                   placeholder="123-4567" maxlength="8">
            @error('post_code') <p style="color:red; font-size:12px;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $shipping['address'] ?? '') }}">
            @error('address') <p style="color:red; font-size:12px;">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', $shipping['building'] ?? '') }}">
            @error('building') <p style="color:red; font-size:12px;">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="update-btn">更新する</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const postCodeInput = document.getElementById('post_code');
    
    postCodeInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^0-9]/g, '');
        
        if (value.length > 3) {
            value = value.substring(0, 3) + '-' + value.substring(3, 7);
        }
        
        e.target.value = value;
    });
});
</script>
@endsection