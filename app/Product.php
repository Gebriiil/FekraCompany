<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Favorit;
use App\Image;
class Product extends Model
{
    protected $fillable = [
        'title','desc',
    ];
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
    public function favorits()
    {
        return  $this->hasMany(Favorit::class);
    }
    public function images()
    {
    	return  $this->hasMany(Image::class);
    }
}
