<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\ReviewPaginationCollection;
use App\Http\Resources\Front\ReviewResource;
use App\Http\Resources\ReviewIndexResource;
use App\Http\Resources\ReviewShowResource;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        return new ReviewPaginationCollection(Review::paginate($request->query('perpage', 30)));
    }

    public function show(Review $review)
    {
        return new ReviewShowResource($review);
    }

    public function update(Request $request, Review $review)
    {
        $review->update($request->only(['status']));
        return new ReviewIndexResource($review);
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return response()->json([
            'message' => 'Xóa thành công'
        ]);
    }
}
