<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryIndexResource;
use App\Http\Resources\Collections\CategoryPaginationResource;
use App\Http\Resources\Front\CategoryShowResource;
use App\Models\Category;
use App\Repositories\Categories\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $cateRepo;

    public function __construct(CategoryRepositoryInterface $cateRepo)
    {
        $this->cateRepo = $cateRepo;
    }

    public function index(Request $request)
    {
        return new CategoryPaginationResource(Category::with('parent')->paginate($request->query('perpage', 30)));
    }

    public function store(Request $request)
    {
        return Category::create($request->all());
    }

    public function show(Request $request, Category $category)
    {
        $filterNames = ['color', 'category_id', 'size', 'price_min', 'price_max'];
        return new CategoryShowResource($this->cateRepo->allProductsPage(
            $category,
            $request->only($filterNames),
            $request->query('perpage', 30),
            $request->query('sortby', 'created_at'),
            $request->query('order', 'desc'),
            false
        ));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return new CategoryIndexResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Xóa thành công'
        ]);
    }
}
