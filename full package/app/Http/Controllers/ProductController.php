<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Product;
use App\ProductCategory;

use DB;
use Log;
use Session;

class ProductController extends Controller
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
           if(Auth()->user()->hasRole('Admin')){
            $products = Product::get();
           }
           else{
            $products = Product::where('user_id',auth()->user()->id)->get();
           }
            return view('admin/settings/products/index', compact('products'));
    }

  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $productsCategories = ProductCategory::all();
        return view('admin/settings/products/create',compact('productsCategories'));
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        if ($request->hasFile('img')) {
            //store the image
            $img = $request->file('img');
            //get the path of the stores image
            $img = $img->store('products', ['disk' => 'public_uploads']);
        } else {$img ='';}
        $products= new Product();
        $products->name_en=$request->name_en;
        $products->name_ar=$request->name_ar;
        $products->price=$request->price;
        $products->dsc_en=$request->dsc_en;
        $products->dsc_ar=$request->dsc_ar;
        $products->cat_id=$request->cat_id;
        $products->img=$img;
        $products->cat_id=$request->cat_id;
        $products->user_id=\Auth::user()->id;
        $products->save();
        return redirect()->route('products.index')->with( ['msg' => 'StoredSuccessfully'] );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $Product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth()->user()->hasRole('Admin')) {
            $products = Product::where('id', '=', $id)->first();
        } else {
            $products = Product::where('id', '=', $id)->where('user_id',Auth()->user()->id)->first();
            if(!$products) {abort(401);}
        }
        $productsCategories = ProductCategory::all();
        return view('admin/settings/products/edit',compact('products','productsCategories'));
    }
        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $aby = null;
        if ($request->input('published')=='on') {$aby = Auth()->user()->id;}
        if ($request->hasFile('img')) {
            //store the image
            $img = $request->file('img');
            //get the path of the stores image
            $img = $img->store('products', ['disk' => 'public_uploads']);
            //update
            if (Auth()->user()->hasRole('Admin')) {
                $result = $product->update($request->except(['img', 'approvedby']) + ['img' => $img, 'approvedby' => $aby]);
            } else {
                $result = $product->update($request->except(['img', 'approvedby']) + ['img' => $img]);
            }

        } else {
            if (Auth()->user()->hasRole('Admin')) {
    $result = $product->update($request->except(['approvedby']) +  ['approvedby' => $aby]);
            } else {
    $result = $product->update($request->except(['approvedby']));
            }
        }

        if($result)
            return redirect()->route('products.index')->with( ['msg' => 'StoredSuccessfully'] );
        else
            return back()->withInput()->with( ['msg' => 'FailedStore'] );

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $Product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $Product)
    {
        $Product->delete();
        return response()->json(['state' => 'success'], 200);
    }

    public function publish(Request $request, $id)
    {
        $user =  $this->preProcessingCheck('manage_products_cat');
        $publish=$request->publish;
        $products=Product::where('id','=',$id)->first();
        $products->approvedby=\Auth::user()->id;
        $products->approveddate=now();
        $products->save();
        return redirect()->route('products.index');
    }

}
