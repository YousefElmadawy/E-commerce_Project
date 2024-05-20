<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

// #[ScopedBy([StoreScope::class])]

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name', 'store_id', 'image', 'description', 'status', 'slug', 'category_id',
        'price', 'compare_price', 'options', 'rating', 'featured'
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return "https://nayemdevs.com/wp-content/uploads/2020/03/default-product-image.png";
        }
        if(Str::startsWith($this->image, ['http://','https://'])){
            return $this->image;
        }
        return asset('storage/'.$this->image);
    }

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }
    // protected $globalScopes = [
    //     StoreScope::class,
    // ];

    protected static function booted()
    {
        static::addGlobalScope(new StoreScope());
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
