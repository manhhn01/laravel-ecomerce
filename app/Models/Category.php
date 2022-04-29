<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable  = ['name', 'slug', 'description'];

    protected $hidden = ['parent_id', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function publicProducts()
    {
        return $this->products()->status(1);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function childrenPublicProducts()
    {
        return $this->hasManyThrough(Product::class, self::class, 'parent_id', 'category_id');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }
}
