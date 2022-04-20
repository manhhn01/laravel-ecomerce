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
     *
     * @param  Category  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Category $category)
    {
        $category->load(['publicProducts' => function ($q) use ($request) {
            return $q->orderBy('created_at', 'desc')
                ->limit($request->query('limit') ?? 25)
                ->offset($request->query('start') ?? 0)
                ->with('publicReviews')
                ->withCount('publicReviews');
        }])->publicProducts->makeHidden(['publicReviews', 'reviews']);

        return $category;
    }
}
