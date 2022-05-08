<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\Front\Collections\ProductPaginationCollection;
use App\Http\Resources\Front\ProductShowResource;
use App\Http\Resources\Front\ReviewResource;
use App\Models\Product;
use App\Repositories\Products\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    protected $productRepo;
    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        return new ProductPaginationCollection(Product::orderByDesc('created_at')->paginate(30));
    }

    public function search(Request $request)
    {
        if (!empty($query = $request->query('q'))) {
            $products = Product::search($query)
                ->where('status', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(30)
                ->tap(function ($products) {
                    $products
                        ->makeHidden(['reviews', 'publicReviews'])
                        ->load('variants')
                        ->loadCount('publicReviews');
                });
        }

        return new ProductPaginationCollection($products ?? (new LengthAwarePaginator([], 0, 30)));
    }

    public function show($id_slug)
    {
        $product = $this->productRepo->findByIdOrSlug($id_slug);

        if ($product->status == 1)
            return new ProductShowResource(
                $product
                    ->load('images', 'categoryWithParent', 'publicReviews.user', 'variants', 'tags')
                    ->append('relatedProducts')
            );
        else
            throw new NotFoundHttpException('Product not found');
    }

    public function likeReview(Request $request, $id_slug, $review_id)
    {
        $user = $request->user();
        /** @var \App\Models\Product */
        $product = $this->productRepo->findByIdOrSlug($id_slug);

        $product->reviews()->find($review_id)->likes();

    }

    public function storeReview(Request $request, $id_slug)
    {
        $user = $request->user();
        $product = $this->productRepo->findByIdOrSlug($id_slug);
        $attributes = $request->only(['comment', 'rating' ]);

        $attributes = array_merge($attributes, ['user_id' => $user->id]);
        $review = $product->reviews()->create($attributes);

        return new ReviewResource($review);
    }

    public function updateReview(Request $request)
    {
    }

    public function destroyReview(Request $request)
    {
    }
}
