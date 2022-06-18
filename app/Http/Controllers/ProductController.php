<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductDestroyRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\Front\Collections\ProductPaginationCollection;
use App\Http\Resources\ProductShowResource;
use App\Models\Image;
use App\Models\Product;
use App\Repositories\Products\ProductRepositoryInterface;
use App\Repositories\ProductVariants\ProductVariantsRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $variantRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        ProductVariantsRepositoryInterface $variantRepo,
    ) {
        $this->productRepo = $productRepo;
        $this->variantRepo = $variantRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterNames = ['color', 'category_id', 'size', 'price_min', 'price_max'];
        return new ProductPaginationCollection(
            $this->productRepo->filterAndPage(
                $request->only($filterNames),
                $request->query('perpage', 30),
                $request->query('sortby', 'created_at'),
                $request->query('order', 'desc'),
                false
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $attributes = $request->all();
        $product = $this->productRepo->create($attributes);
        try {
            $this->productRepo->createVariants($product, $attributes['variants']);
            $this->productRepo->createImages($product, $attributes['images']);
        } catch (QueryException $e) {
            $product->delete();
            throw $e;
        }
        return new ProductShowResource(
            $product
                ->load('images', 'categoryWithParent', 'publicReviews.user', 'publicReviews.likes', 'variants', 'tags')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, $id_slug)
    {
        $product = $this->productRepo->findByIdOrSlug($id_slug);

        return new ProductShowResource(
            $product
                ->load('images', 'categoryWithParent', 'publicReviews.user', 'publicReviews.likes', 'variants', 'tags')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id_slug)
    {
        $product = $this->productRepo->findByIdOrSlug($id_slug);
        $attributes = $request->all();
        $product->update($attributes);
        if (isset($attributes['variants'])) {
            $this->productRepo->updateVariants($product, $attributes['variants']);
        }
        if (isset($attributes['images'])) {
            $this->productRepo->updateImages($product, $attributes['images']);
        }
        return new ProductShowResource(
            $product
                ->load('images', 'categoryWithParent', 'publicReviews.user', 'publicReviews.likes', 'variants', 'tags')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductDestroyRequest $request, $id_slug)
    {
        $product = $this->productRepo->findByIdOrSlug($id_slug);
        $product->delete();
        return new ProductPaginationCollection(
            $this->productRepo->filterAndPage([], [], [], [], false)
        );
    }
}
