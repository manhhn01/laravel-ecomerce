<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory;

    protected $fillable  = ['name', 'slug', 'description'];

    protected $hidden = ['allParents', 'allChildren', 'parent_id', 'created_at', 'updated_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function publicProducts()
    {
        return $this->products()->status(1);
    }

    public function allPublicProducts()
    {
        // TODO all public
    }

    public function getAllPublicProductsAttribute()
    {
        // TODO All product
        return $this->flatAllPublicProducts($this);
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function childrenWithPublicProducts()
    {
        return $this->children()->with('publicProducts');
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function allChildrenWithPublicProducts()
    {
        return $this->childrenWithPublicProducts()->with('allChildrenWithPublicProducts');
    }

    public function allParents()
    {
        return $this->parent()->with('allParents');
    }

    public function getFlatAllParentsAttribute()
    {
        return $this->flatAllParents($this)->toArray();
    }

    public function getFlatAllChildrenAttribute()
    {
        return $this->flatAllChildren($this)->toArray();
    }

    protected function flatAllParents($category)
    {
        $categories = collect();
        if ($category->allParents) {
            $categories->prepend($category->allParents);
            $categories = $categories->merge($this->flatAllParents($category->allParents));
        }
        return $categories;
    }

    protected function flatAllChildren($category, $relation = 'allChildren')
    {
        $categories = collect();
        foreach ($category->{$relation} as $child) {
            $categories->push($child);
            if ($child->{$relation}) {
                $categories = $categories->merge($this->flatAllChildren($child));
            }
        }
        return $categories;
    }

    /**
     * @param Category $category
     * @param string $relation
     * @return Collection
     */
    public function flatAllPublicProducts($category)
    {
        // TODO
        $products = collect($category->publicProducts);
        return $childrenCategory = $this->flatAllChildren($category, 'allChildrenWithPublicProducts');
    }
}
