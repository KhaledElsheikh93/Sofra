<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = User::paginate(10);
        return view('admin.users.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
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
            'name'       => 'required',
            'email'      => 'required|unique:users',
            'password'   => 'required|confirmed',
            'roles_list'  => 'required'
        ];

        $messeges = [
            'name.required'      => 'please enter your name',
            'email.required'     => 'please enter valid email',
            'password.required'  => 'please enter your password',
            'roles_list.required' => 'please choose roles'
        ];
        $this->validate($request, $rules, $messeges); 
        $request->merge(['password' => Hash::make($request->password)]);
        $model = User::create($request->except('roles_list'));
        $model->roles()->attach($request->input('roles_list'));
        flash('تم اضافة المستخدم بنجاح')->success();
        return redirect(route('users.index'));

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
        $model = User::findOrfail($id);
        return view('admin.users.edit', compact('model'));
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
        $rules =[
            'name'      => 'required',
            'email'     => 'required',
            'password'  => 'required|confirmed',
            'roles_list'=> 'required|array'
        ];

        $messages = [
            'name.required'      => 'please enter your name',
            'email.required'     => 'please enter valid email',
            'password.required'  => 'please enter your password',
            'roles_list.required' => 'please choose roles'
        ];
        $this->validate($request, $rules, $messages);
        $model =User::findOrfail($id);
        $model->roles()->sync((array) $request->input('roles_list'));
        $request->merge(['passwoord' =>Hash::make($request->password)]);
        $model->update($request->all());
        flash('تم تعديل البيانات بنجاح')->success();
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = User::findOrfail($id);
        $record->delete();
        flash('Deleted')->success();
        return back();
    }
    /**
     * change user password
     */

    public function changePassword(Request $request)
    {
        //$model = User::findOrfail($id);
        return view('admin.users.reset-password');
    }


    public function changePasswordSave(Request $request)
    {
        $rules = [
            'old-password' => 'required',
            'password' => 'required|confirmed',
        ];
        $messages = [
            'old-password.required' => 'كلمة السر الحالية مطلوبة',
            'password.required' => 'كلمة السر مطلوبة',
        ];
        $this->validate($request,$rules,$messages);
        $user = Auth::user();
        if(Hash::check($request->input('old-password'), $user->password))
        {
            /**
             * the password matching 
             * */
            $user->password = bcrypt($request->input('password'));
            $user->save();
            flash()->success('تم تحديث كلمة المرور');
            return redirect('admin/users/');
        }
        else
        {
            flash()->error('كلمة المرور غير صحيحة');
            return redirect(route('users.index'));
        }
    }

}
