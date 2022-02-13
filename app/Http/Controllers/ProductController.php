<?php

namespace App\Http\Controllers;

use App\Models\MondayDep;
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

        $monday_watchers = MondayDep::all();

        return view('product.create',[
            'page_title' => 'מוצר חדש',
            'monday_watchers' => $monday_watchers
        ]);
    }


    public function store(Request $request){

        $name = $request->input('product-title');
        $note = $request->input('product-notes');
        $price = $request->input('price');
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
            'data' => json_encode($data),
            'price' => $price,
            'monday_watchers' => json_encode($request->input('monday_watcher'))
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


    public function edit($id){
        $product = Product::find($id);
        $monday_watchers = MondayDep::all();

        return view('product.edit', [
            'product' => $product,
            'page_title' => 'עריכת מוצר',
            'monday_watchers' => $monday_watchers,
            'selected_monday_watchers' => $product->monday_watchers ? json_decode($product->monday_watchers, true) : []
        ]);

    }

    public function update(Request $request){
        $product = Product::find($request->input('id'));

        $product->name = $request->input('product-title');
        $product->notes = $request->input('product-notes');
        $product_data = $request->input('product-data');
        $price = $request->input('price');
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
        $product->data = json_encode($data);
        $product->price = $price;
        $product->monday_watchers = json_encode($request->input('monday_watcher'));

        $product->save();

        return redirect()->route('product.index');

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
