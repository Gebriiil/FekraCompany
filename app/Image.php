<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
class Image extends Model
{
    protected $fillable=['image'];
    public function product()
    {
    	return $this->belongsTo(Product::class);
    }
}
