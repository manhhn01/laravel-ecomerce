<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\CategoryIndexResource;
use App\Http\Resources\Front\CategoryShowResource;
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
        return CategoryIndexResource::collection($this->categoryRepo->allRootWithChildren());
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
        $filterNames = ['color', 'category_id', 'size', 'price_min', 'price_max'];
        return new CategoryShowResource($this->categoryRepo->allProductsPage(
            $category,
            $request->only($filterNames),
            $request->query('perpage', 30),
            $request->query('sortby', 'created_at'),
            $request->query('order', 'desc')
        ));
    }
}
