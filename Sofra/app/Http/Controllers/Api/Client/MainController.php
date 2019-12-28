<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\City;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Setting;
use App\Models\District;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class MainController extends Controller
{
    public function cities()
    {
        $cities = City::all();
        return responseJson(1, "success", $cities);
    }


    public function districts(Request $request)
    {
        $districts = District::where(function($query) use($request){
            if($request->has('city_id'))
            {
                $query->where('city_id', $request->city_id);
            }
        })->get();
        return responseJson(1, "success", $districts);
    }


    public function settings()
    {
        $settings = Setting::all();
        return responseJson(1, "success", $settings);
    }


    public function contacts(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email'   => 'required|email',
            'name'    => 'required',
            'phone'   => 'required',
            'content' => 'required'
        ]);
        if($validation->fails())
        {
            return responseJson(0, "validation fails", $validation->errors());
        }
        $contacts = Contact::create($request->all());
        $contacts->save();
        return responseJson(1, "success", $contacts);
    }


    public function profile(Request $request)
    {
        $client = $request->user();
        return responseJson(1, "success", $client);
        
    }


    public function editProfile(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'         => 'required',
            'email'        => 'required|email',
            'phone'        => 'required',
            'password'     => 'required',
            'district_id'  => 'required'
        ]);
        if($validation->fails())
        {
            return responseJson(0, "validation error", $validation->errors());
        }
        $request->merge(['password', Hash::make($request->password)]);
        $client = Client::where('api_token', $request->api_token)->first()
        ->update($request->all());
        return responseJson(1, "updated succefully", $client); 
    }


    public function addComment(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'comment'       => 'required|string',
            'rate'          => 'required|numeric',
            'restaurant_id' => 'required|exists:restaurants,id'
        ]);
        if($validator->fails())
        {
            return responseJson(0, "برجاء التأكد من البيانات",$validator->errors());
        }
        $comment = request()->user()->reviews()->create($request->all());
        return responseJson(1, "تم اضافة تعليقك", $comment);
    }


    public function newOrder(Request $request)
    {
        $settings = Setting::find(1);

        $validator = validator()->make($request->all(),[
            'restaurant_id' => 'required|exists:restaurants,id',
            'products.*'    => 'required|exists:products,id',
            'amount'        => 'required',
            'payment_method'=> 'required|in:cash,online',
            'address'       => 'required',
        ]);
        if ($validator->fails())
        {
            return responseJson(0,$validator->errors()->first(),$validator->errors());
        }
        $restaurant = Restaurant::find($request->restaurant_id);
        if ($restaurant->state == 'closed'){
            return responseJson(0,'المطعم غير متاح فى الوقت الحالى');
        }

              // minimum charge
            
        $cost  = 0;
        $price =[];
        $i     =0;
        foreach($request->products as $product)
        {
            $product_order = Product::find($product);
            $cost += ($product_order->price * $request->amount[$i]);
            
            $price[$i] = $product_order->price;
            $i++;
    
        }

        if ($cost < $restaurant->minimum_charge)
        {
            return responseJson(0, 'ريال'.$restaurant->minimum_charge.'لا يمكن الطلب اقل من ');
        }
        
        $delivery_charge = $restaurant->delivery_charge;
        $total = $cost + $delivery_charge;
        $commission = $settings->commission * $cost;
        $net = $total - $commission ;

        $order = $request->user()->orders()->create([
            'restaurant_id' => $request->restaurant_id,
            'special_order' => $request->special_order,
            'note'         => $request->note,
            'state'         => 'pending',
            'address'       => $request->address,
            'payment_method'=> $request->payment_method,
            'cost'          => $cost,
            'total'         => $total,
            'net'           => $net,
            'commission'    => $commission,
        ]);

        
        $i = 0;
        foreach ($request->products as $pr){
            $order->products()->attach($pr,[
            'amount'=>$request->amount[$i], 
            'price'=>$price[$i] , 
            'notes'=> $request->notes[$i]
            ]);
            $i++;
        }
            $notification = $restaurant->notifications()->create([
                'title' => 'لديك طلب جديد',
                'content' => 'لديك طلب جديد من العميل'.request()->user()->name,
                'order_id' => $order->id
            ]);

            $tokens = $restaurant->tokens()->where('token', '!=', null)->pluck('token')->toArray();
            $title = $notification->title;
            $body = $notification->body;
            $order_id = [
                'order_id' => $order->id
            ];
            $send = notifyByFirebase($title, $body, $tokens, $order_id);
            $data = [
                'order' => $order->fresh()->load('products')
            ];
            return responseJson(1,'تم الطلب بنجاح',$data);
    }


    public function orderDetails(Request $request)
    {

        $details = $request->user()->orders()->where(function($query) use($request){
            if($request->order_id)
            {
                $query->where('id' , $request->order_id);
            }
        })->get();
        if(count($details))
        {
            return responseJson(1, "success", $details);
        }
        else
        {
            return responseJson(0, "الطلب غير موجود");
        }
    }


    public function acceptedOrder(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id'
        ]);
        if($validation->fails())
        {
            return responseJson(0,$validation->errors()->first(),$validation->errors());
        }
        $order = $request->user()->orders()->find($request->order_id);
        if($order)
        {
            $order->update(['state' => 'accepted']);
            return responseJson(1, "تم الموافقة علي طلبك");
        }
        return responseJson(0, "المطعم رفض طلبك");

    }


    public function deliveredOrder(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id'
        ]);
        if($validation->fails())
        {
            return responseJson(0,"بيانات الطلب غير صحيحة", $validation->errors());
        }
        $order = $request->user()->orders()->find($request->order_id);
        if($order)
        {
            $order->update(['state' => 'delivered']);
            return responseJson(1, " تم استلام الطلب");
        }
        else
        {
            return responseJson(0, "حدث خطأ ما ");
        }
    }


    public function declineOrder(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id'
        ]);
        if($validation->fails())
        {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }
        $order = $request->user()->orders()->find($request->order_id);
        if($order)
        {
            $order->update(['state' => 'rejected']);
            $restaurant  = $order->restaurant;
            $notification = $restaurant->notifications()->create([
                'title'    => 'لديك طلب اشعار جديد من العميل',
                'content'  => 'لقد تم رفض استلام الطلب من قبل العميل'.request()->user()->name,
                'order_id' => $order->id
            ]);  
            $tokens = $restaurant->tokens()->where('token', '!=', Null)->pluck('token')->toArray();
            if($tokens)
            {
                $title    = $notification->title;
                $body     = $notification->body;
                $order_id = [
                    'order_id' => $order->id
                ];
                $send = notifyByFirebase($title, $body, $tokens, $order_id);
                //dd($send);
            }
            $data = [
                'order' => $order->fresh()->load('products')
            ];
            return responseJson(1, "تم رفض استلام الطلب", $data);
        }
        return responseJson(0, " حدث خطأ ما");
    }


    public function currentOrder(Request $request)
    {
        $current_orders = $request->user()->orders()->where('state', 'accepted')->get();
        return responseJson(1, "success", $current_orders);
    }


    public function previousOrders()
    {
        $previous_orders = request()->user()->orders()->WhereIn('state',['accepted', 'rejected', 'delivered'])->
        latest()->paginate(10);
        return responseJson(1, "success", $previous_orders);
    }


    public function restaurantData(Request $request)
    {
        $restaurant = Restaurant::where(function($query) use($request){
            if($request->has('restaurant_id'))
            {
                $query->where('id', $request->restaurant_id);
            }
        })->get();
        return responseJson(1, "success", $restaurant);
    }

}
