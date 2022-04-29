<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Categories\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryRepo;
    public function __construct(CategoryRepositoryInterface $cateRepo)
    {
        $this->categoryRepo = $cateRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->categoryRepo->allRootWithChildren();
    }

    /**
     * Display the specified resource.
     * @param  Request $request
     * @param  Category  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id_slug)
    {
        $category = $this->categoryRepo->findByIdOrSlug($id_slug);
        $filterNames = ['limit', 'start', 'color', 'category', 'size', 'price_min', 'price_max'];
        return $this->categoryRepo->allProductsPage($category, $request->only($filterNames), 30);
    }
}
