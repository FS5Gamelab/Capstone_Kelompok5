<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BlogController extends Controller
{

    public function index()
    {
        return view('admin.blog.index', [
            'blogs' => \App\Models\Blog::all()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blogs'],
            'description' => ['required', 'string'],
            'blog_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                'errors' => $validator->errors(),
            ]);
        } else {
            $blog = new \App\Models\Blog();

            $image = $request->file('blog_image');
            if ($image) {
                $extension = $image->getClientOriginalExtension();
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = now()->format('YmdHis') . '-' . $originalName . '.' . $extension;
                $blog_image = $image->storeAs('uploads/blog-image', $imageName, 'public');
                $blog->blog_image = $blog_image;
            }
            $blog->title = $request->title;
            $blog->slug = $request->slug;
            $blog->description = $request->description;
            $blog->save();
            return response()->json([
                "success" => true,
                'message' => 'Blog created successfully',
                'blog' => $blog
            ]);
        }
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        return view('admin.blog.show', [
            'blog' => $blog
        ]);
    }

    public function edit($id)
    {
        $blog = Blog::find($id);
        return response()->json([
            "success" => true,
            "blog" => $blog
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:blogs,slug,' . $id],
            'description' => ['required', 'string'],
            'blog_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                'errors' => $validator->errors(),
            ]);
        } else {
            $blog = Blog::find($id);
            $image = $request->file('blog_image');
            if ($image) {
                if ($blog->blog_image) {
                    Storage::disk('public')->delete($blog->blog_image);
                }
                $extension = $image->getClientOriginalExtension();
                $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $imageName = now()->format('YmdHis') . '-' . $originalName . '.' . $extension;
                $blog_image = $image->storeAs('uploads/blog-image', $imageName, 'public');
                $blog->blog_image = $blog_image;
            }
            $blog->title = $request->title;
            $blog->slug = $request->slug;
            $blog->description = $request->description;
            $blog->save();
            return response()->json([
                "success" => true,
                'message' => 'Blog updated successfully',
                'blog' => $blog
            ]);
        }
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        if ($blog->blog_image) {
            Storage::disk('public')->delete($blog->blog_image);
        }
        $blog->delete();
        return response()->json([
            "success" => true,
            'message' => 'Blog deleted successfully',
        ]);
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Blog::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
