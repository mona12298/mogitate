@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="wrap">
    <form action="/products/register" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form">
            <h2 class="content__ttl">商品登録</h2>
            <div class="form__item">
                <p class="form__item__label">
                    商品名<span class="form__item__label-required">必須</span>
                </p>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力" class="form__item__input">
                @if ($errors->has('name'))
                    @foreach ($errors->get('name') as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                @endif

            </div>
            <div class="form__item">
                <p class="form__item__label">
                    値段<span class="form__item__label-required">必須</span>
                </p>
                <input type="text" name="price" value="{{ old('price') }}" placeholder="値段を入力" class="form__item__input">
                @if ($errors->has('price'))
                    @foreach ($errors->get('price') as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <div class="form__item">
                <p class="form__item__label">
                    商品画像<span class="form__item__label-required">必須</span>
                </p>
                <img id="image-preview" src="" alt="画像プレビュー" style="max-width:374px; display:none; margin-top:10px;">
                <div class="form__item__file">
                    <label for="image-input" class="image-input">ファイルを選択</label>
                    <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
                    <label for="image-input" id="img-label" class="file-label"></label>
                </div>

                @if ($errors->has('image'))
                    @foreach ($errors->get('image') as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                @endif

                <script>
                document.getElementById("image-input").addEventListener("change", function (event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById("image-preview");
                    const label = document.getElementById("img-label");
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = "block";
                        };
                        reader.readAsDataURL(file);

                        label.textContent = file.name;
                    } else {
                        preview.src = "";
                        preview.style.display = "none";
                        label.textContent = "";
                    }
                });
                </script>


            <div class="form__item">
                <p class="form__item__label">
                    季節<span class="form__item__label-required">必須</span>
                    <span class="form__item__label-multiple">複数選択可</span>
                </p>
                <div class="form__item-set">
                    <input type="checkbox" value="1" name="season_id[]" class="form__item__checkbox" id="spring"{{ is_array(old('season_id')) && in_array(1, old('season_id')) ? 'checked' : '' }}>
                    <label for="spring">春</label>

                    <input type="checkbox" value="2" name="season_id[]" class="form__item__checkbox" id="summer"{{ is_array(old('season_id')) && in_array(2, old('season_id')) ? 'checked' : '' }}>
                    <label for="summer">夏</label>

                    <input type="checkbox" value="3" name="season_id[]" class="form__item__checkbox" id="fall"{{ is_array(old('season_id')) && in_array(3, old('season_id')) ? 'checked' : '' }}>
                    <label for="fall">秋</label>

                    <input type="checkbox" value="4" name="season_id[]" class="form__item__checkbox" id="winter"
                    {{ is_array(old('season_id')) && in_array(4, old('season_id')) ? 'checked' : '' }}>
                    <label for="winter">冬</label>
                </div>
                @if ($errors->has('season_id'))
                    @foreach ($errors->get('season_id') as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                @endif
            </div>
            <div class="form__item">
                <p class="form__item__label">
                    商品説明<span class="form__item__label-required">必須</span>
                </p>
                <textarea name="description" value="{{ old('description') }}" class="form__item__textarea" placeholder="商品の説明を入力"></textarea>
                @if ($errors->has('description'))
                    @foreach ($errors->get('description') as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="form__btn">
            <a href="/products" class="form__btn--back">戻る</a>
            <input type="submit" value="登録" class="form__btn--register">
        </div>
    </form>
</div>
@endsection