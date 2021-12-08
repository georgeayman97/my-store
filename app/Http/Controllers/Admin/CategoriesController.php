<?php

namespace App\Http\Controllers\Admin;


use index;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;

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

        //recieve session
        $success = session()->get('success');
        return view('admin.categories.index',[
            'categories' => $entries,
            'title' => 'Categories List',
            'success' => $success,
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
        $category = new Category();
        return view('admin.categories.create',compact('category','parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        //validate rules
        // $rules = [
        //     'name' => 'required|string|max:255|min:3|unique:categories',
        //     'parent_id' => 'nullable|int|exists:categories,id',
        //     'description' => 'nullable|min:10',
        //     'status' => 'required|in:active,draft',
        //     'image' => 'image|max:1024000|dimensions:min_width=300,min_height=300'
        // ];
        // /*errors if happened laravel will send auto error 
        // exception to a var called errors*/
        // // last argument in validator is my custom msgs
        // $clean = $request->validate($rules,[
        //     'name.required' => 'Category name is required',
        //     'description.min' => 'Please write more details ya ksmk',
        //     'status.required' => 'e5tar :attribute ya 5wal'
        // ]);
        // return array of all fields

        //Or this way
        //$clean = $this->validate($request,$rules);


        /* //If i wanna validate opject from file as excel but not here yet
        $date = $request->all();
        // validator opject 
        $validator = Validator::make($data,$rules);
        //validate 
        try{
        $clean = $validator->validate();
        } catch (Trowable $e){
            return redirect()->back()->withErrors($validator)->withInput();
        }*/


        /*
        $errors = $validator->errors() ==> returns errors msgs 
        $errors = $validator->failed() ==> returns which fields have errors
        */


        $request->merge([
            'slug' => Str::slug($request->name),
            'status' => 'active'
        ]);
        

        /*return single field value
        $request->description;
        $request->input('description');
        $request->get('description');
        $request->post('description');
        $request->query('description'); // ?description=value*/

        /*Method 1
        $category = new Category();
        $category->name = $request->post('name');
        $category->slug = Str::slug($request->post('name'));
        $category->parent_id = $request->post('parent_id');
        $category->description = $request->post('description');
        $category->status = $request->post('status','active');
        $category->save();*/

        


        //Method 2 Mass assignment
        // Mass Assignment: i have to add proberty in its model have all fields names i wanna create 
        Category::create($request->all());

        //Method 3 Mass assignment
        // Mass Assignment: i have to add proberty in its model have all fields names i wanna create 
        // $category = new Category([
            //     'description' => $request->post('description'),
            //     'slug' => Str::slug($request->post('name')),
            //     'name' => $request->post('name'),
            //     'status' => $request->post('status','active'),
            //     'parent_id' => $request->post('parent_id'),
            // ]);
        // $category->save();

        return redirect(route('categories.index'));
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
        //$category = Category::where('id','=',$id)->first();
        // find() func finds by default using the primary key 
        // so we have to prepare the primary key in the model

        $category = Category::find($id);
        $parents = Category::where('id','<>',$category->id)->get();

        // then we have to pass this category with this id to edit it

        return view('admin.categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        //Mass Assignment
        // update in one step but it needs mass assignment
        // Category::where('id','=',$id)->update($request->all());

        // update in two steps select then update
        $category = Category::find($id);

        // Method 2
        $category->update($request->all());

        return redirect(route('categories.index'))->with('success','category updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Method 1 (2 steps)
        // $category = Category->find($id)->delete();

        //Method 2 (1 step)
        Category::destroy($id);

        //Method 3 (1 step)
        // Category::where('id','=',$id)->delete();

        // session()->put('success','category deleted');

        // session()->flash('success','category deleted');

        return redirect(route('categories.index'))->with('success','category deleted');
    }
}
