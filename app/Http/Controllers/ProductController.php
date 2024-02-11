<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // index
    public function index()
    {
        $products = Product::paginate(10);
        $type_menu = 'dashboard';
        return view('pages.products.index', compact('products', 'type_menu'));
    }

    // create
    public function create()
    {
        $categories = DB::table('categories')->get();
        $type_menu = 'dashboard';
        return view('pages.products.create', compact('categories', 'type_menu'));
    }

    // store
    public function store(Request $request)
    {
        // validate request
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|boolean',
            'is_favorite' => 'required|boolean',
        ]);

        // store data
        $product = new Product;
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_favorite = $request->is_favorite;

        $product->save();

        // save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // show
    public function show($id)
    {
        return view('pages.products.show', ['type_menu' => 'dashboard']);
    }

    // edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        $type_menu = 'dashboard';
        return view('pages.products.edit', compact('product', 'categories', 'type_menu'));
    }

    // update
    public function update(Request $request, $id)
    {
        // validate request
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'status' => 'required|boolean',
            'is_favorite' => 'required|boolean',
        ]);

        // update data
        $product = Product::find($id);
        $product->category_id = $request->category_id;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_favorite = $request->is_favorite;

        $product->save();

        // save image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // destroy
    public function destroy($id)
    {
        // delete data
        $product = Product::find($id);
        $product->delete();

        // extract filename from category->image
        // remove storage/ part from filename if exists
        $fileName = Str::after($product->image, 'storage/');
        // check if file exists
        if (Storage::disk('public')->exists($fileName)) {
            // delete file image
            Storage::disk('public')->delete($fileName);
        }

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
