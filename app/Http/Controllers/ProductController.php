<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $product->reviews_count = $product->reviews()->count();
            $product->average_rating = number_format($product->reviews()->avg('rating'), 1, '.', '');
        }
        return view('admin.product.index', [
            'products' => $products,
            'categories' => Category::all(),
        ]);
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
        $validation = Validator::make($request->all(), [
            'product_name' => 'required',
            'price' => 'required',
            'description' => 'required',
            "type" => 'required',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
            'category_id' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors(),
            ]);
        } else {

            $image = $request->file('product_image');
            $extension = $image->getClientOriginalExtension();
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $imageName = now()->format('YmdHis') . '-' . $originalName . '.' . $extension;
            $product_image = $image->storeAs('uploads/product-image', $imageName, 'public');
            $product = Product::create([
                'product_name' => $request->product_name,
                "user_id" => auth()->user()->id,
                'price' => $request->price,
                'description' => $request->description,
                'type' => $request->type,
                'product_image' => $product_image,
                'category_id' => $request->category_id,
            ]);
            $category = Category::find($request->category_id);
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'category' => $category,
                'product' => $product
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $validation = Validator::make($request->all(), [
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|string|in:foods,drinks',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors(),
            ]);
        } else {
            $product = Product::find($id);
            $image = $request->file('product_image');
            $product_image = $product->product_image;
            if ($product->product_image != null) {
                if ($image) {
                    Storage::disk('public')->delete($product->product_image);
                    $extension = $image->getClientOriginalExtension();
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $imageName = now()->format('YmdHis') . '-' . $originalName . '.' . $extension;
                    $product_image = $image->storeAs('uploads/product-image', $imageName, 'public');
                }
            }
            $product->update([
                'product_name' => $request->product_name,
                'price' => $request->price,
                "user_id" => auth()->user()->id,
                'description' => $request->description,
                'type' => $request->type,
                "in_stock" => $request->in_stock,
                'product_image' => $product_image,
                'category_id' => $request->category_id,
            ]);
            $category = Category::find($request->category_id);
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'category' => $category,
                'product' => $product
            ]);
        }
    }

    public function trash()
    {
        return view('admin.product.deleted-product', [
            'products' =>  Product::onlyTrashed()->get()
        ]);
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->find($id);
        $product->restore();
        return response()->json([
            'success' => true,
            'message' => 'Product restored successfully',
        ]);
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->find($id);

        $product->forceDelete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
