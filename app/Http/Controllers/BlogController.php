<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index() {
        $blogs = Blog::latest()->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create() {
        return view('admin.blogs.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'written_by' => 'required|string|max:255',
            'date' => 'required|date',
            'details' => 'required',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);

        $slug = Str::slug($request->title, '-');

        Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'category' => $request->category,
            'image' => $imageName,
            'written_by' => $request->written_by,
            'date' => $request->date,
            'details' => $request->details,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog) {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'written_by' => 'required|string|max:255',
            'date' => 'required|date',
            'details' => 'required',
        ]);

        $imageName = $blog->image;
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
        }

        $blog->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category' => $request->category,
            'image' => $imageName,
            'written_by' => $request->written_by,
            'date' => $request->date,
            'details' => $request->details,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog) {
        if (file_exists(public_path('uploads/'.$blog->image))) {
            unlink(public_path('uploads/'.$blog->image));
        }
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function show($slug) {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        return view('blogs.show', compact('blog'));
    }
}
