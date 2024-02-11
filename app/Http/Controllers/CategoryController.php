<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // index
    public function index()
    {
        $categories = Category::paginate(10);
        $type_menu = 'dashboard';
        return view('pages.categories.index', compact('categories', 'type_menu'));
    }

    // create
    public function create()
    {
        return view('pages.categories.create', ['type_menu' => 'dashboard']);
    }

    // store
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        // store data
        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        // save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    // show
    public function show($id)
    {
        return view('pages.categories.show', ['type_menu' => 'dashboard']);
    }

    // edit
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $type_menu = 'dashboard';
        return view('pages.categories.edit', compact('category', 'type_menu'));
    }

    // update
    public function update(Request $request, $id)
    {
        // validate request
        $request->validate([
            'name' => 'required',
            'image' => 'image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        ]);

        // update data
        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;

        $category->save();

        // save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/categories', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/categories/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // destroy
    public function destroy($id)
    {
        // delete data
        $category = Category::find($id);
        $category->delete();

        // extract filename from category->image
        // remove storage/ part from filename if exists
        $fileName = Str::after($category->image, 'storage/');
        // check if file exists
        if (Storage::disk('public')->exists($fileName)) {
            // delete file image
            Storage::disk('public')->delete($fileName);
        }

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
