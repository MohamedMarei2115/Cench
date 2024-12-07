<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('images')) {
            $id = $request->product_id;
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
        return redirect()->back()->with('success', 'Images Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        $gallery = ProductImage::where('product_id',$id)->get();
        return view('dashboard.product.editGallery', compact('gallery','product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        $imagePath = str_replace(url('/'), '', $image->image_path);

        if ($image->delete()) {
            $fullImagePath = public_path($imagePath);
            File::delete($fullImagePath);
            return response()->json(['success' => true, 'message' => 'Image deleted successfully!']);

        }
        return response()->json(['success' => true, 'message' => 'Error Try Later']);
    }
}
