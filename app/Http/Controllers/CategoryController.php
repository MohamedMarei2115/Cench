<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function getAll(){
        $categories = Category::where('status',1)->get(['id','name']);
        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $categories,
        ], 200);
    }

    public function eventDetail($id){
        $category = Category::where('id',$id)->first(['id','name']);
        return response()->json([
            'status' => 'success',
            'message' => '',
            'data' => $category,
        ], 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.category.index', compact('categories'));
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
        $request->validate([
            'name' => [
                'required',
            ],

        ]);
        if (Category::create([
            'name' => $request->name,
            'status' => $request->status == 'on' ? 1 : 0
        ])) {

            return redirect()->back()->with('success', 'Category Added Successfully');

        }

        return redirect()->back()->with('error', 'An error occurred while saving, please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
            ],

        ]);

        if (Category::where('id', $request->id)->update([
            'name' => $request->name,
            'status' => $request->status == 'on' ? 1 : 0
        ])) {
            return redirect()->back()->with('success', 'Category Updated Successfully');

        }
        return redirect()->back()->with('error', 'An error occurred while saving, please try again');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Category::findOrFail($request->id)->delete()) {
            return redirect()->back()->with('success', 'Category Deleted Successfully');

        }
        return redirect()->back()->with('error', 'An error occurred while deleting, please try again');

    }
}
