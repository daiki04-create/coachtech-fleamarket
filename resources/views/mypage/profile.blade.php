@extends('layouts.app')

@section('title', 'プロフィール設定')

@section('content')
<style>
    .profile-container { max-width: 600px; margin: 40px auto; }
    h1 { text-align: center; margin-bottom: 30px; }
    .form-group { margin-bottom: 25px; }
    .form-group label { display: block; margin-bottom: 10px; font-weight: bold; color: #333; }
    .profile-image-section { display: flex; align-items: center; gap: 30px; margin-bottom: 25px; }
    .image-preview-circle { width: 130px; height: 130px; border-radius: 50%; border: 1px solid #ccc; overflow: hidden; background: #eee; }
    #preview-image, #current-image { width: 100%; height: 100%; object-fit: cover; }
    .file-select-button { display: inline-block; padding: 10px 20px; border: 1px solid #ff4d4d !important; color: #ff4d4d !important; font-weight: bold !important; cursor: pointer; border-radius: 4px; background-color: #fff !important;transition: 0.3s;}
    .file-select-button:hover { background-color: #fff0f0; }
    .form-group input { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
    .submit-btn { width: 100%; padding: 15px; background: #ff4d4d; color: #fff; border: none; border-radius: 4px; font-weight: bold; cursor: pointer; }
    /* エラーメッセージ用 */
    .error-message { color: #ff4d4d; font-size: 13px; margin-top: 5px; }
</style>

<div class="profile-container">
    <h1>プロフィール設定</h1>

    @if ($errors->any())
        <div style="margin-bottom: 20px; color: #ff4d4d;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mypage.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>プロフィール画像</label>
            <div class="profile-image-section">
                <div class="image-preview-circle">
                    @if(auth()->user()->profile && auth()->user()->profile->img_url)
                        <img id="current-image" src="{{ asset('storage/' . auth()->user()->profile->img_url) }}" alt="画像">
                    @endif
                    <img id="preview-image" src="#" alt="プレビュー" style="display:none;">
                </div>

                <label class="file-select-button">
                    画像を選択する
                    <input type="file" name="img_url" id="image-input" style="display:none;" onchange="previewFile(this)">
                </label>
            </div>
            @error('img_url') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
            @error('name') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="postal_code" value="{{ old('postal_code', auth()->user()->profile?->postal_code) }}">
            @error('postal_code') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', auth()->user()->profile?->address) }}">
            @error('address') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building" value="{{ old('building', auth()->user()->profile?->building) }}">
            @error('building') <div class="error-message">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="submit-btn">更新する</button>
    </form>
</div>

<script>
    function previewFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                const preview = document.getElementById('preview-image');
                const current = document.getElementById('current-image');
                if (current) current.style.display = 'none'; 
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection