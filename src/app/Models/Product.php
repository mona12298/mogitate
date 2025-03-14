<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{
    use HasFactory, Sortable;

    protected $guarded = ['id'];
    public $sortable = ['price'];


    public function seasons()
    {
        return $this->belongsToMany(
            Season::class,
            'products_seasons',
            'product_id',
            'season_id'
        );
    }

    public function scopeNameSearch($query, $keyword){
        if (!empty($keyword)){
            $query->where('name', 'like', '%' . $keyword . '%');
        }
    }

    public function updateProduct($request){
        $productData = $request->only(['name', 'price', 'description']);

        if ($request->hasFile('image')) {
            if ($this->image) {
            \Storage::delete($this->image);
            }
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/fruits-img', $filename);
            $productData['image'] = str_replace('public/', 'storage/', $path);
        } else {
            $productData['image'] = $this->image;
        }
        $this->update($productData);

        if ($request->has('season_id')) {
        $this->seasons()->sync($request->season_id);
        }
    }
}
