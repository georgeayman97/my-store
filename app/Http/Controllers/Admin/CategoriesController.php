<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use index;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return collection of category model object(as array)
        // when using all() we use model directly
        $entries = Category::all();
        // SELECT * FROM categories WHERE status = 'active' here i cant use all(); we are using Query builder
        // get() returns collection and first() returns opject
        // get(['id','name']); for specific columns 
        // before get i can use orderBy('name', 'ASC') Or 'DESC' also i can use more than one orderBy followed by ->

        // SELECT * FROM categories INNER JOIN categories as parents
        // ON parents.id = categories.parent_id
        // where status = 'active'
        // ORDER BY name ASC
        // for testing replace get() with dd()
        $entries = Category::leftJoin('categories as parents','parents.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])
        ->where('categories.status','=','active')
        ->orderBy('categories.name', 'ASC')
        ->get();

        // RETURN COLLECTION OF STDOBJ
        //$entries = DB::table('categories')->where('status','=','active')->orderBy('name', 'ASC')->get();



        // return view('admin/categories/index');
        // view second argument will be array which i wanna pass
        // or can be sent using with method
        return view('admin.categories.index',[
            'categories' => $entries,
            'title' => 'Categories List',
        ]);

        // OR this way 
        
        // $categories = Category::all();
        // $title = 'Categories List';
        // return view('admin.categories.index', compact('categories','title'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all();
        return view('admin.categories.create',compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
