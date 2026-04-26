<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class ProductController extends Controller
{
    public function index()
    {
      $products = Product::all()->map(function ($product) {

$product->qr = QrCode::size(100)->generate(route('products.show', $product->id));

return $product;

});

return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([

'name' => 'required',

'price' => 'required|numeric'

]);

Product::create($request->all());

return redirect()->route('products.index')->with('success', 'Product created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $qr = QrCode::size(200)->generate(json_encode([

'id' => $product->id,

'name' => $product->name,

'price' => $product->price,

]));

return view('products.show', compact('product', 'qr'));


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Product $product)
    {
        $request->validate([

'name' => 'required',

'price' => 'required|numeric'

]);

$product->update($request->all());

return redirect()->route('products.index')->with('success', 'Product updated.');
    }
}
