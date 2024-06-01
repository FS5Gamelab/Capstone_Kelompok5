<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index()
    {
        return view('admin.category.index', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                'errors' => $validator->errors(),
            ]);
        } else {
            $category = new Category();
            $category->category_name = $request->input('category_name');
            $category->user_id = auth()->user()->id;
            $category->save();

            $user = User::where('id', $category->user_id)->first();
            return response()->json([
                "success" => true,
                'message' => 'Category Added Successfully',
                'category' => $category,
                'user' => $user
            ]);
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json([
            "success" => true,
            "category" => $category
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                'errors' => $validator->errors(),
            ]);
        } else {
            $category = Category::find($id);
            $category->update([
                'category_name' => $request->category_name,
                'user_id' => auth()->user()->id
            ]);

            $user = User::where('id', $category->user_id)->first();
            return response()->json([
                "success" => true,
                'message' => 'Category Updated Successfully',
                'category' => $category,
                'user' => $user
            ]);
        }
    }

    public function deleted()
    {
        return view('admin.category.deleted', [
            'categories' => Category::onlyTrashed()->get()
        ]);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);
        $category->restore();
        return response()->json([
            "success" => true,
            'message' => 'Category Restored Successfully',
        ]);
    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->find($id);
        if ($category->products->count() > 0) {
            $category->products()->update([
                'category_id' => null,
            ]);
        }
        $category->forceDelete();
        return response()->json([
            "success" => true,
            'message' => 'Category Permanently Deleted Successfully',
        ]);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            "success" => true,
            'message' => 'Category Deleted Successfully',
        ]);
    }
}
