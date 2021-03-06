<?php

namespace App;

use App\Product;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description'
    ];

    protected $hidden = [
    	'pivot'
    ];
    
    protected $dates = ['deleted_at'];

    public $transformer = CategoryTransformer::class;

    public function products() {
        return $this->belongsToMany(Product::class);
    }
}
