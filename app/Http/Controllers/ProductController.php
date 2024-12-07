<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{


    public function getAll(){
        $products = Product::with(['stock.size', 'category'])
            ->where('status', 1)
            ->get(['id', 'name', 'details', 'imag', 'price', 'category_id'])
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'details' => $product->details,
                    'imag' => $product->imag,
                    'price' => $product->price,
                    'category_name' => $product->category->name,
                    'stock' => $product->stock->map(function ($stock) {
                        return [
                            'product_id' => $stock->product_id,
                            'price' => $stock->price,
                            'size' => $stock->size->size,
                            'size_id' => $stock->size_id,
                            'quantity' => $stock->quantity
                        ];
                    }),
                ];
            });        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $products,
        ], 200);
    }
    public function getAllInCategory($category_id){
        $products = Product::with(['stock.size', 'category'])
            ->where('category_id',$category_id)
            ->where('status', 1)
            ->get(['id', 'name', 'details', 'imag', 'price', 'category_id'])
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'details' => $product->details,
                    'imag' => $product->imag,
                    'price' => $product->price,
                    'category_name' => $product->category->name,
                    'stock' => $product->stock->map(function ($stock) {
                        return [
                            'product_id' => $stock->product_id,
                            'price' => $stock->price,
                            'size' => $stock->size->size,
                            'size_id' => $stock->size_id,
                            'quantity' => $stock->quantity
                        ];
                    }),
                ];
            });        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $products,
        ], 200);
    }

    public function index()
    {
        $products = Product::orderBy('id', 'desc')->paginate(10);
        $categories = Category::all();
        return view('dashboard.product.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if ($request->file('imag')) {
            $file = $request->file('imag');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $destinationPath = public_path('uploads/product/image');
            $file->move($destinationPath, $fileName);
            $fileUrl = url('uploads/product/image/' . $fileName);
        }




        if ($product = Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'details' => $request->detail,
            'imag' => $fileUrl,
            'price' => $request->price,
//            'size' => $request->size,
            'status' => $request->status == 'on' ? 1 : 0
        ])) {

            if ($request->hasFile('images')) {
                $id = $product->id;
                foreach ($request->file('images') as $image) {

                    $fileName = time() . '_' . $image->getClientOriginalName();

                    $destinationPath = public_path('uploads/product/gallery/'.$id);
                    $image->move($destinationPath, $fileName);
                    $fileUrl = url('uploads/product/gallery/'.$id .'/'. $fileName);
                    ProductImage::create([
                        'product_id' => $id,
                        'image_path' => $fileUrl,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Product Added Successfully');

        }

        return redirect()->back()->with('error', 'An error occurred while saving, please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($request->file('imag')) {

            $imagePath = str_replace(url('/'), '', $product->imag);

            $fullImagePath = public_path($imagePath);
            File::delete($fullImagePath);

            $file = $request->file('imag');
            $fileName = time() . '_' . $file->getClientOriginalName();

            $destinationPath = public_path('uploads/product/image');
            $file->move($destinationPath, $fileName);
            $fileUrl = url('uploads/product/image/' . $fileName);


            $product->imag = $fileUrl;
        }

        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->details = $request->details;
        $product->price = $request->price;
        $product->status = $request->status == 'on' ? 1 : 0;
//        $product->size = $request->size;

        if ($product->save()) {
            return redirect()->back()->with('success', 'Product Updated Successfully');

        }
        return redirect()->back()->with('error', 'An error occurred while saving, please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::findOrFail($request->id);

        $imagePath = str_replace(url('/'), '', $product->imag);

        if ($product->delete()) {
            $fullImagePath = public_path($imagePath);
            File::delete($fullImagePath);
            return redirect()->back()->with('success', 'Product Deleted Successfully');

        }
        return redirect()->back()->with('error', 'An error occurred while deleting, please try again');
    }
}
