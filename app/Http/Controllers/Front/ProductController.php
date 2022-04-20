<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Products\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    protected $productRepo;
    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Product::with('publicReviews')
            ->status(1)
            ->orderBy('created_at', 'desc')
            ->limit($request->query('limit') ?? 25)
            ->offset($request->query('start') ?? 0)
            ->get()
            ->loadCount('publicReviews')
            ->makeHidden('reviews', 'publicReviews');
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        if ($product->status == 1)
            return $product
                ->load('images', 'category:id,parent_id,slug,name', 'brand:id,slug,name', 'publicReviews.user', 'variants.image')
                ->loadCount('publicReviews');
        else
            throw new NotFoundHttpException('Product not found');
    }
}
