<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Role::paginate(10);
        return view('admin.roles.index', compact('records'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
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
            'name'             => 'required|unique:roles',
            'display_name'     => 'required',
            'permissions_list' => 'required|array'
        ];

        $messages = [
            'name.required'              => 'Role name is required',
            'display_name.required'      => 'Enter display name',
            'permissions_list.required'  => 'You should have permission'
        ];

       $this->validate($request,$rules,$messages);

       $model = Role::create($request->all());
       $model->permissions()->attach($request->permissions_list);
       flash('Role added successfully');
       return redirect(route('roles.index'));
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
        $model = Role::findOrfail($id);
        return view('admin.roles.edit',compact('model'));
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
            'name'             => 'required|unique:roles,name,'.$id,
            'display_name'     => 'required',
            'permissions_list' => 'required|array'
        ];
        $message =[
            'name.required'              => 'name is required',
            'display_name.required'      => 'Enter display name',
            'permissions_list.required'  => 'You should have permission'
        ];
        $this->validate($request, $rules, $message);
        $record = Role::findOrfail($id);
        $record->update($request->all());
        $record->permissions()->sync($request->permissions_list);
        flash('Role Edited')->success();
        return redirect(route('roles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Role::findOrfail($id);
        $record->delete();
        flash('Deleted')->success();
        return back();
    }
}
