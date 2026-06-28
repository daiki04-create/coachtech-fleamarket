@extends('layouts.app')

@section('title', '商品の出品')

@section('content')
<style>
    .container {width: 100%;max-width: 700px;margin: 40px auto;padding: 0 20px;background: none;box-shadow: none;}
    .form-group {margin-bottom: 30px;background: transparent;padding: 0;}
    h1 { text-align: center; margin-bottom: 30px; }
    .form-group > label {font-weight: bold;font-size: 16px;margin-bottom: 15px;display: block;color: #333;}
    .image-upload-wrapper {display: flex;align-items: center;justify-content: center;width: 100%;height: 200px;border: 2px dashed #ccc;background: #fff;cursor: pointer;position: relative;overflow: hidden;}
    .image-upload-wrapper:hover {border-color: #ff4d4d;}
    .file-select-button {position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); padding: 10px 20px;border: 2px solid #ff5655;border-radius: 10px;color: #ff5655;font-weight: bold;background: #fff;z-index: 1;cursor: pointer; white-space: nowrap; }
    #preview-image {display: none;width: 100%;height: 100%;object-fit: contain;position: relative;z-index: 2;}
    .image-upload-wrapper input {display: none;}
    .image-upload-wrapper.has-image {border: none;}
    .category-group {display: flex;flex-wrap: wrap;gap: 12px;}
    .category-item {padding: 8px 16px;border: 1px solid #ff4d4d;color: #ff4d4d;border-radius: 20px;cursor: pointer;font-size: 14px;background-color: #fff;}
    .category-item:hover,input[type="checkbox"]:checked + .category-item {background-color: #ff4d4d;color: #fff;}
    input[type="checkbox"] {display: none;}
    input[type="text"],input[type="number"],select,textarea {width: 100%;padding: 12px;border: 1px solid #ccc;border-radius: 4px;box-sizing: border-box;}
    .price-input-wrapper {position: relative;}
    .price-input-wrapper::before {content: "￥";position: absolute;left: 10px;top: 50%;transform: translateY(-50%);color: #555;font-weight: bold;}
    .price-input-wrapper input {padding-left: 30px;}
    .section-title {font-size: 20px;font-weight: bold;margin: 40px 0 20px 0;padding-bottom: 15px;border-bottom: 1px solid #ccc;}
    .submit-btn {width: 100%;padding: 15px;background: #ff4d4d;color: #fff;border: none;border-radius: 4px;font-weight: bold;cursor: pointer;}
</style>

<div class="container">
    <h1>商品の出品</h1>
    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
    <label>商品画像</label>
    <label class="image-upload-wrapper" id="upload-label">
        <span class="file-select-button" id="file-label">画像を選択する</span>
        <input type="file" name="image" id="image-input" style="display:none;" required>
        <img id="preview-image" src="#" alt="プレビュー">
    </label>
</div>

        <div class="section-title">商品の詳細</div>
        <div class="form-group">
            <label>カテゴリー</label>
            <div class="category-group">
                @foreach($categories as $category)
                    <input type="checkbox" name="category[]" value="{{ $category->id }}" id="cat{{ $category->id }}">
                    <label for="cat{{ $category->id }}" class="category-item">{{ $category->name }}</label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>商品の状態</label>
            <select name="condition">
                <option value="">選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
        </div>

        <div class="section-title">商品名と説明</div>
        <div class="form-group">
            <label>商品名</label>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label>商品の説明</label>
            <textarea name="description" rows="5">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label>販売価格</label>
            <div class="price-input-wrapper">
                <input type="number" name="price" value="{{ old('price') }}">
            </div>
        </div>

        <button type="submit" class="submit-btn">出品する</button>
    </form>
</div>

<script>
    document.getElementById('image-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('preview-image');
                const btn = document.getElementById('file-label');
                const label = document.getElementById('upload-label');
                
                btn.style.display = 'none';
                
                img.src = e.target.result;
                img.style.display = 'block';
                
                label.classList.add('has-image');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection