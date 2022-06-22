<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\ReviewPaginationCollection;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        return new ReviewPaginationCollection(Review::paginate($request->query('perpage', 30)));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Review $review)
    {
        //
    }

    public function update(Request $request, Review $review)
    {
        //
    }

    public function destroy(Review $review)
    {
        //
    }
}
