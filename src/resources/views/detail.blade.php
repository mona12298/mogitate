@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="product">
    <form action="{{ url('/products/' . $product->id . '/update') }}" method="post">
        @method('patch')
        @csrf
        <div class="product-breadcrumb">
            <p class="product-breadcrumb__label">
                <a href="/products">商品一覧</a>>{{ $product->name }}
            </p>
        </div>
        <div class="product-info">
            <div class="product-info--left">
                <div class="product__img">
                    <img id="img-preview" src="{{ asset($product->image) }}" alt="商品画像">
                </div>
                <div class="product__file">
                    <label for="img-input" class="img-input">ファイルを選択</label>
                    <input type="file" name="image" id="img-input" class="hidden" accept="image/*">
                    <label for="img-input" id="img-label" class="product__file__label">
                    {{ basename($product->image) }}
                    </label>
                </div>
            </div>
            @if ($errors->has('image'))
                @foreach ($errors->get('image') as $error)
                    <p class="error-message">{{ $error }}</p>
                @endforeach
            @endif
            <script>
            document.getElementById('img-input').addEventListener('change', function(event) {
                if (event.target.files && event.target.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('img-preview').src = e.target.result;
                    }
                    reader.readAsDataURL(event.target.files[0]);

                    document.getElementById('img-label').innerText = event.target.files[0].name;
                }
            });

            document.getElementById('img-label').addEventListener('click', function(){
                document.getElementById('img-input').click();
            });
            </script>
            <div class="product-info--right">
                <p class="product-info__label">商品名</p>
                <input type="text" name="name" value="{{ $product['name'] }}" placeholder="商品名を入力" class="product-info__input">
                @if ($errors->has('name'))
                    @foreach ($errors->get('name') as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                @endif
                <p class="product-info__label">値段</p>
                <input type="text" name="price" value="{{ $product['price'] }}" placeholder="値段を入力" class="product-info__input">
                @if ($errors->has('price'))
                    @foreach ($errors->get('price') as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                @endif
                <p class="product-info__label">季節</p>
                <div class="product-info__set">
                    <input type="checkbox" name="season_id[]" value="1" class="product-info__set__checkbox" id="spring" {{ in_array(1, $selectedSeasons) ? 'checked' : '' }}>
                    <label for="spring">春</label>

                    <input type="checkbox" name="season_id[]" value="2" class="product-info__set__checkbox" id="summer" {{ in_array(2, $selectedSeasons) ? 'checked' : '' }}>
                    <label for="summer">夏</label>

                    <input type="checkbox" name="season_id[]" value="3" class="product-info__set__checkbox" id="fall" {{ in_array(3, $selectedSeasons) ? 'checked' : '' }}>
                    <label for="fall">秋</label>

                    <input type="checkbox" name="season_id[]" value="4" class="product-info__set__checkbox" id="winter" {{ in_array(4, $selectedSeasons) ? 'checked' : '' }}>
                    <label for="winter">冬</label>
                </div>
                @if ($errors->has('season_id'))
                    @foreach ($errors->get('season_id') as $error)
                        <p class="error-message">{{ $error }}</p>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="product-desc">
            <p class="product-info__label">商品説明</p>
            <textarea name="description" value="{{ $product['description'] }}" placeholder="商品の説明を入力">{{ $product->description }}</textarea>
            @if ($errors->has('description'))
                @foreach ($errors->get('description') as $error)
                    <p class="error-message">{{ $error }}</p>
                @endforeach
            @endif
        </div>
        <div class="product-btn">
            <a href="/products">戻る</a>
            <input type="submit"  value="変更を保存" class="product-btn__patch">
    </form>
            <form action="{{ url('/products/' . $product->id . '/delete') }}" method="post" class="trash-form">
            @method('delete')
            @csrf
            <input type="submit" class="product-btn__trashcan" value="">
            </form>
        </div>
</div>

@endsection