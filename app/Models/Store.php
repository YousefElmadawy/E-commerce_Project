<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'logo_image', 'cover_image', 'description', 'status', 'slug'
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
