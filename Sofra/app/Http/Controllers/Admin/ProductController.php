<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Product::paginate(10);
        return view('admin.products.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurants = Restaurant::all();
        return view('admin.products.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'         => 'required',
            'price'        => 'required',
            'restaurant_id'=> 'required'
        ];
        $message = [
            'name.required'         => 'Enter product name',
            'price.required'        => 'Enter the price',
            'restaurant_id.required'=> 'Choose restaurant'
        ];
        $this->validate($request, $rules, $message);
        $records= Product::create($request->all());
        flash('Product Added')->success();
        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model      = Product::findOrfail($id);
        $restaurants= Restaurant::all();
        return view('admin.products.edit', compact(['model', 'restaurants']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name'         => 'required',
            'price'        => 'required',
            'restaurant_id'=> 'required'
        ];
        $message = [
            'name.required'         => 'Enter product name',
            'price.required'        => 'Enter the price',
            'restaurant_id.required'=> 'Choose restaurant'
        ];
        $this->validate($request, $rules, $message);

        $model = Product::findOrfail($id);
        $model->update($request->all());
        flash('Product edited')->success();
        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Product::findOrfail($id);
        $record->delete();
        flash('Deleted')->success();
        return back();
    }
}
