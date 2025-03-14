@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="wrap">
    <form action="/products/search" method="get">
            @csrf
        <div class="content__toolbar">
            <h3 class="content__toolbar__ttl">{{ isset($keyword) ? "\"{$keyword}\"の商品一覧" : "商品一覧" }}</h3>
            <a href="/products/register" class="content__toolbar__link">+商品を追加</a>
        </div>
        <div class="content">
            <div class="content__controls">
                <div class="content__controls__search">
                    <input type="text" name="keyword" value="" placeholder="商品名で検索" class="content__controls__search--input">
                    <input type="submit" value="検索" class="content__controls__search--btn">
                </div>
                <div class="content__controls__display">
                    <p>価格順で表示</p>
                    <select name="sort_order" id="sort_order" class="content__controls__display">
                        <option value=""></option>
                        <option value="price_asc" {{ $sort === 'price' && $direction === 'asc' ? 'selected' : '' }}>価格の低い順</option>
                        <option value="price_desc" {{ $sort === 'price' && $direction === 'desc' ? 'selected' : '' }}>価格の高い順</option>
                    </select>
                </div>

                <script>
                    document.getElementById('sort_order').addEventListener('change', function () {
                        let value = this.value;
                        let url = new URL(window.location.href);

                        if (value === "price_desc") {
                            url.searchParams.set('sort', 'price');
                            url.searchParams.set('direction', 'desc');
                        } else if (value === "price_asc") {
                            url.searchParams.set('sort', 'price');
                            url.searchParams.set('direction', 'asc');
                        } else {
                            url.searchParams.delete('sort');
                            url.searchParams.delete('direction');
                        }

                        window.location.href = url.toString();
                    });
                </script>
            </div>
            <div class="content__cards">
                @foreach ($products as $product)
                <div class="card">
                    <a href="{{ url('/products/' . $product->id) }}">
                        <div class="card__img">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }} の画像 ">
                        </div>
                        <div class="card__txt">
                            <p>{{ $product->name }}</p>
                            <p>¥{{ $product->price }}</p>
                        </div>
                    </a>
                </div>
                @endforeach
                <div class="pagination">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </form>
</div>
@endsection