<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'parent_id', 'image', 'description', 'status', 'slug'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'Main Category'
        ]);
    }
    //locl scope  

    public function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }
    // public function scopeStatus(Builder $builder, $status)
    // {
    //     $builder->where('status', $status);
    // }
    public function scopeFilter(Builder $builder, $filters)
    {

        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('categories.name', 'LIKE', "%{$value}%");
        });

        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('categories.status', '=', $value);
        });

        /* <anthor way>
        if($filters['name'] ?? false){
            $builder->where('name', 'LIKE' , "%{$filters['name']}%" );
        }
        if($filters['status'] ?? false){
            $builder->where('status','=', $filters['status']);
        }
*/
    }

    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required', 'string', 'min:3', 'max:255',
                Rule::unique('categories', 'name')->ignore($id),
                //custom rule (1)
                function ($attribute, $value, $fails) {
                    if (strtolower($value) == 'laravel') {
                        $fails('this cat is forbidden');
                    }
                },
            ],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'image' => ['image', 'mimes:png,jpg', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'status' => 'required|in:active,archived',
        ];
    }
}
