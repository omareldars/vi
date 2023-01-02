<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ProductCategory;
use App\Http\Requests\StoreProductCategoryRequest;
use Auth;
use DB;
use Log;
use Session;

class ProductCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  $this->preProcessingCheck('manage_products_cat');
        $productsCategories =  ProductCategory::all();
        return view('admin/settings/products_categories/index', compact('productsCategories'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user =  $this->preProcessingCheck('manage_products_cat');
        return view('admin/settings/products_categories/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductCategoryRequest $request)
    {
        $user =  $this->preProcessingCheck('manage_products_cat');
        $name_en=$request->name_en;
        $name_ar=$request->name_ar;
        $productsCategories= new ProductCategory();
        $productsCategories->name_en=$name_en;
        $productsCategories->name_ar=$name_ar;
        $productsCategories->user_id=Auth::user()->id;
        $productsCategories->save();

        return redirect()->route('productsCategories.index')->with( ['msg' => 'StoredSuccessfully'] );
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user =  $this->preProcessingCheck('manage_products_cat');
        $productsCategories= ProductCategory::where('id','=',$id)->first();
        return view('admin/settings/products_categories/edit',compact('productsCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $user =  $this->preProcessingCheck('manage_products_cat');
        $name_en=$request->name_en;
        $name_ar=$request->name_ar;
        $productsCategories= ProductCategory::where('id','=',$id)->first();
        $productsCategories->name_en=$name_en;
        $productsCategories->name_ar=$name_ar;
        $productsCategories->save();

        //$result = $productCategory->update($request->all());
        return redirect()->route('productsCategories.index')->with( ['msg' => 'StoredSuccessfully'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $ProductCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user =  $this->preProcessingCheck('manage_products_cat');
        $productsCategories= ProductCategory::where('id','=',$id)->first();
        $productsCategories->delete();
        return response()->json(['state' => 'success'], 200);
    }
}
