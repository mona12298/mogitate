<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;

class ProductController extends Controller
{
    public function index(Request $request){
        $sort = $request->input('sort', null);
        $direction = $request->input('direction', 'asc');
        $query = Product::with('seasons');
        if ($sort === 'price') {
            $query->orderBy('price', $direction);
        }
        $products = $query->simplePaginate(6);
        return view('index', compact('products', 'sort', 'direction'));
    }


    public function search(Request $request){
        $keyword = $request->input('keyword');
        $sort = 'price';
        $direction = $request->input('direction', 'asc');

        $products = Product::nameSearch($keyword)->sortable([$sort => $direction])->simplePaginate(6);
        return view('index', compact('products', 'keyword', 'direction'));
    }

    public function register(){
        return view('register');
    }

    public function store(ProductRequest $request){
        $productData = $request->only(['name', 'price', 'description']);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('public/fruits-img');
            $productData['image'] = str_replace('public/', 'storage/', $path);
        }
        $product = Product::create($productData);
        $product->seasons()->sync($request->season_id);
        return redirect('/products');
    }

    public function detail($productId){
        $product = Product::find($productId);
        $selectedSeasons = $product->seasons->pluck('id')->toArray();
        return view('detail', compact('product', 'selectedSeasons'));
    }

    public function delete($productId){
        $product = Product::findOrFail($productId);
        $product->delete();
        return redirect('/products');
    }

    public function update(ProductRequest $request, $productId){
        $product = Product::find($productId);
        $product->updateProduct($request);
        return redirect('/products');
    }

}
