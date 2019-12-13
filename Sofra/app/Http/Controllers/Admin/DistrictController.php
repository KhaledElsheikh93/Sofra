<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = District::paginate(10);
        return view('admin.districts.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('admin.districts.create', compact('cities'));
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
            'name'    => 'required',
            'city_id' => 'required'
        ];
        $message = [
            'name.required'    => 'Please enter your district name',
            'city_id.required' => 'please choose city'
        ];
        $this->validate($request, $rules, $message);
        $records = District::create($request->all());
        flash('your district has been added')->success();
        return redirect(route('districts.index'));
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
        $model = District::findOrfail($id);
        $cities= City::all();
        return view('admin.districts.edit', compact(['model', 'cities']));
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
        $record = District::findOrfail($id);
        $record->update($request->all());
        flash('District Edited')->success();
        return redirect(route('districts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = District::findOrfail($id);
        $record->delete();
        flash('Deleted')->success();
        return back();
    }
}
