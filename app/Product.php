<?php

namespace App;

use App\Category;
use App\Seller;
use App\Transaction;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    const AVAILABLE_PRODUCT = "available";
    const NOT_AVAILABLE_PRODUCT = "not available";


    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',
    ];

    protected $hidden = [
        'pivot'
    ];

    protected $dates = ['deleted_at'];

    public $transformer = ProductTransformer::class;


    public function isAvailable() {
        return $this->status == Product::AVAILABLE_PRODUCT;
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function seller() {
        return $this->belongsTo(Seller::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
