<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->q, function ($query, $q) {
            $query->where('name', 'like', '%' . $q . '%');
        })->paginate(5);

        return Inertia::render('Admin/Category/Index', [
            'categories' => $categories,
            'search' => $request->only('q'),
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
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name'
        ]);

        $category = Category::create($validated);

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Category created successfully');
        }
        else {
            return redirect()->route('category.index')->with('failed', 'Failed to create category');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validated([
            'name' => 'required|string|unique:categories,name,' . $category->id
        ]);

        $category->update($validated);

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Category updated successfully');
        }
        else {
            return redirect()->route('category.index')->with('failed', 'Failed to update category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect(route('category.index'))->with('success', 'Category has been deleted succesfully');
    }
}
