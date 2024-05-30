<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|min:1|max:5',
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                'message' => 'Rating is required',
            ]);
        } else {
            $review = Review::create([
                'product_id' => $request->product_id,
                'user_id' => auth()->user()->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            Cart::where('product_id', $request->product_id)->where('user_id', auth()->user()->id)->where('order_id', $request->order_id)
                ->update([
                    "review_id" => $review->id
                ]);
            return response()->json([
                "success" => true,
                'message' => 'Review created successfully',
                'review' => $review
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review, $id)
    {
        $review = Review::find($id);
        return response()->json([
            "success" => true,
            "data" => $review
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                'message' => 'Rating is required',
            ]);
        } else {
            $review = Review::find($id);
            $review->update([
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
            return response()->json([
                "success" => true,
                'message' => 'Review updated successfully',
                'review' => $review
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review, $id)
    {
        $review = Review::find($id);
        Cart::where('review_id', $review->id)->update([
            "review_id" => null
        ]);
        $review->delete();
        return response()->json([
            "success" => true,
            'message' => 'Review deleted successfully',
        ]);
    }
}
