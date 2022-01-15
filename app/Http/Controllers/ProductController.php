<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller{

    public function index(){

        $products = Product::all();
        return view('product.index', [
            'products' => $products
        ]);

    }


    public function create() :View{
        return view('product.create',[
            'page_title' => 'מוצר חדש'
        ]);
    }


    public function store(Request $request){

        $name = $request->input('product-title');
        $note = $request->input('product-notes');
        $product_data = $request->input('product-data');
        $data = null;
        if($product_data){
            foreach ($product_data as $_d){
                if(isset($_d['data-name']) && isset($_d['data-type'])){
                    $data[] = [
                        'title' => $_d['data-name'],
                        'type' => $_d['data-type']
                    ];
                }
            }
        }

        $product = Product::create([
            'name' => $name,
            'notes' => $note ?: 'n/a',
            'data' => json_encode($data)
        ]);

        return redirect()->route('product.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
