<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $records = Payment::paginate(10);
        return view('admin.payments.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurants = Restaurant::all();
        return view('admin.payments.create', compact('restaurants'));
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
            
            'restaurant_id' => 'required',
            'paid'          => 'required',
            'notes'         => 'required'
        ];
        $message = [
            
            'restaurant_id.required' => 'please choose resturant',
            'paid.required'          => 'please insert the payments',
            'notes.required'         => 'please insert notes'
        ];
        $this->validate($request, $rules, $message);
        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        $records = $restaurant->payments()->create($request->all());
        $payment = $restaurant->payments()->sum('paid');
        $restaurant->update(['restaurant_payment' => $payment]);
        flash('your payment has been added')->success();
        return redirect(route('payments.index'));

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
        $model       = Payment::findOrfail($id);
        return view('admin.payments.edit', compact('model'));
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
        $record = Payment::findOrfail($id);
        $record->update($request->all());
        flash('Payments Edited')->success();
        return redirect(route('payments.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Payment::findOrfail($id);
        $record->delete();
        flash('Deleted')->success();
        return back();
    }
}
