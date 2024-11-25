<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.size.index', compact('sizes'));
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
        $request->validate([
            'name' => [
                'required',
            ],

        ]);
        if (Size::create([
            'size' => $request->name,
        ])) {

            return redirect()->back()->with('success', 'Size Added Successfully');

        }

        return redirect()->back()->with('error', 'An error occurred while saving, please try again');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
            ],

        ]);

        if (Size::where('id', $request->id)->update([
            'size' => $request->name,
        ])) {
            return redirect()->back()->with('success', 'Size Updated Successfully');

        }
        return redirect()->back()->with('error', 'An error occurred while saving, please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (Size::findOrFail($request->id)->delete()) {
            return redirect()->back()->with('success', 'Size Deleted Successfully');

        }
        return redirect()->back()->with('error', 'An error occurred while deleting, please try again');
    }
}
