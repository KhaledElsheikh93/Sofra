<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Setting::paginate(10);
        return view('admin.settings.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.settings.create');
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
            'about_app'      => 'required',
            'commission'     => 'required',
            'max_credit'     => 'required',
            'app_commission' => 'required'
        ];
        $messages = [
            'about_app.required' => 'برجاء ادخال معلومات حول التطبيق',
            'commission.required'=> 'برجاء ادخال نسبة العمولة',
            'max_credit'         => 'برجاء ادخال الحد الاقصي للطلب',
            'app_commission'     => 'برجاء ادخال الحد الاقصي للعمولة المستحقة علي المطعم'
        ];
        $this->validate($request, $rules, $messages);
        $model = Setting::create($request->all());
        flash('تم ادخال اعدادت التطبيق')->success();
        return redirect(route('settings.index'));
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
        $model = Setting::findOrfail($id);
        return view('admin.settings.edit', compact('model'));
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
            'about_app'      => 'required',
            'commission'     => 'required',
            'max_credit'     => 'required',
            'app_commission' => 'required'
        ];
        $messages = [
            'about_app.required' => 'برجاء ادخال معلومات حول التطبيق',
            'commission.required'=> 'برجاء ادخال نسبة العمولة',
            'max_credit'         => 'برجاء ادخال الحد الاقصي للطلب',
            'app_commission'     => 'برجاء ادخال الحد الاقصي للعمولة المستحقة علي المطعم'
        ];
        $this->validate($request, $rules, $messages);
        $record = Setting::findOrfail($id);
        $record->update($request->all());
        flash('تم تحديث الاعدادات')->success();
        return redirect(route('settings.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Setting::findOrfail($id);
        $model->delete();
        flash('تم مسح الاعدادات')->success();
        return back(); 
    }
}
