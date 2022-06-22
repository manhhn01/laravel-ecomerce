<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\CategoryPaginationResource;
use App\Http\Resources\Front\CategoryShowResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        return new CategoryPaginationResource(Category::paginate($request->query('perpage', 30)));
    }

    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function show(Category $category)
    {
        return new CategoryShowResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return $category;
    }

    public function destroy(Category $category)
    {
        //
    }
}
