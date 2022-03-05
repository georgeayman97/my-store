<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //paginate cropping the data coming from database
        $products = Product::join('categories','categories.id','=','products.category_id')
        ->select([
            'products.*',
            'categories.name as category_name'
        ])
        ->withTrashed()
        ->withoutGlobalScope('active')
        ->paginate();
        // also i have func called simplePaginate just next and previous no page num
        return view('admin.products.index',[
            'products' => $products,
            'title' => 'Products List'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.products.create',[
            'categories'=> $categories,
            'product'=>new Product(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Product::validateRules());

        /*$request->merge([
            'slug' => Str::slug($request->post('name')),
        ]);*/

        // mass assignment so we need $fillable
        $product = Product::create($request->all());

        return redirect()->route('products.index')->with('success',"$product->name Created Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show',[
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        // withTrashed()  used for including soft deleted items 
        // onlyTrashed()  find just deleted items
        return view('admin.products.edit',[
            'product' => $product,
            'categories' => Category::withTrashed()->pluck('name', 'id'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate(Product::validateRules());

        //here we will handle the file to store it in a place
        if($request->hasFile('image')){
            $file = $request->file('image'); // upload file opject
            // $file->getClientOriginalName(); // returns file name
            $image_path = $file->store('/' , 'uploads');
            /* File system Disks (config/filesystem)
             local: storage/app
             public: storage/app/public
             s3: amazon Drive
             custom: define by us*/
             $request->merge([
                'image_path' => $image_path,
            ]);
        }
        
        $product->update($request->all());
        return redirect()->route('products.index')->with('success',"$product->name Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // delete image from uploads disk
        //Storage::disk('uploads')->delete($product->image_path);

        // same idea in native php
        //unlink(public_path('uploads/'. $product->image_path));

        
        return redirect()->route('products.index')->with('success',"$product->name Deleted Successfully");
    }

    public function restoreProduct(Request $request, $id = null)
    {
        if($id){
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->restore();
            return redirect()->route('products.index')->with('success',"$product->name Restored Successfully");
        }
        Product::onlyTrashed()->restore();
        return redirect()->route('products.index')->with('success',"All Products Restored Successfully");
    }

    public function forceDelete($id = null)
    {
        if($id){
            $product = Product::onlyTrashed()->findOrFail($id);
            $product->forceDelete();
            return redirect()->route('products.index')->with('success',"$product->name Deleted forever Successfully");
        }
        Product::onlyTrashed()->forceDelete();
        return redirect()->route('products.index')->with('success',"All Products Deleted forever Successfully");
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->paginate();
        

        return view('admin.products.trash',[
            'products' => $products,
            'title' => 'Trash Products',
        ]);
    }

    
}
