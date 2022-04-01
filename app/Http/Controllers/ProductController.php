<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    public function index()
    {
        // if($request->search){
        //     return Product::where('name','Like','%'.$request->search.'%')->orderBy('id','desc')->paginate(5);
        // }
        // return Product::orderBy('id','desc')->paginate(5);

        if(request('search')){
            return Product::where('name','Like','%'.request('search').'%')->orderBy('id','desc')->paginate(10);
        }else{
            return Product::orderBy('id','desc')->paginate(15);
        }

        // return Product::when(request('search'),function($query){
        //     $query->where('name','Like','%'.request('search').'%');})
        //     ->orderBy('id','desc')->get();
            
    }

    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->only('name','price'));
        return $product;
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->only('name','price'));
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $product;
    }
}
