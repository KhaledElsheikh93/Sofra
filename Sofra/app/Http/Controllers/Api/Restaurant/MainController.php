<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Models\City;
use App\Models\Offer;
use App\Models\Client;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\District;
use App\Models\Restaurant;
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


    public function addCategory(Request $request)
    {
        $validation = validator()->make($request->all(), [
           // 'name'           => 'required',
            'categories'          => 'required|array|exists:categories,id',
            
        ]);
        if($validation->fails())
        {
            return responseJson(0, "validation error", $validation->errors());
        }
        $categories = $request->user()->categories()->attach($request->categories);
        return responseJson(1, "نم اضافة الفئة التابع لها المطعم", $categories);
    }


    public function categories()
    {
        $categories = Category::all();
        return responseJson(1, "success", $categories);
    }


    public function profile(Request $request)
    {
        $client = $request->user();
        return responseJson(1, "success", $client);
        
    }


    public function editProfile(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'           => 'required',
            'email'          => 'required|email',
            'phone'          => 'required',
            'password'       => 'required',
            'district_id'    => 'required',
            'delivery_charge'=> 'required',
            'minimum_order'  => 'required',
            'contact_phone'  => 'required',
            'whats'          => 'required',
            'category_id'    => 'required'
        ]);
        if($validation->fails())
        {
            return responseJson(0, "validation error", $validation->errors());
        }
        $request->merge(['password', bcrypt($request->password)]);
        $restaurant = Restaurant::where('api_token', $request->api_token)->first()
        ->update($request->all());
        $request->user()->categories()->sync($request->categories);

        return responseJson(1, "updated succefully", [
            'restaurant' => $request->user(),
            'category'   => $request->user()->load('categories')
        ]); 
    }


    public function restaurantState(Request $request)
    {
        $validation = validate()->make($request->all(), [
            'restaurant_id' => 'required',
            'state'         => 'required|in:open,closed'
        ]);
        $restaurant_state = Restaurant::Select('state')->where('id', $request->id)->get();
        return responseJson(1, "success", $restaurant_state);
    }


    public function changeRestaurantState(Request $request)
    {
        $change_state = Restaurant::find($request->restaurant_id);
        $request->user()->update(['state'=> $request->state]);
        return responseJson(1, " تم تغييير حالة المطعم");
    }


    public function products(Request $request)
    {
        $products = $request->user()->products()->paginate(10);
        return responseJson(1, "قائمة الطعام", $products);
    }


    public function createProducts(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'        => 'required',
            'description' => 'required',
            'price'       => 'required',
            'duration'    => 'required'
        ]);
        if($validation->fails())
        {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }
        $product = Product::create($request->all());
        $product->restaurant_id = $request->user()->id;
        if($request->hasFile('image'))
        {
            $logo = $request->image;
            $logo_new_name = time(). $logo->getClientOriginalName();
            $logo->move('uploads/post', $logo_new_name);
            $product->image = 'uploads/post'. $logo_new_name;
            $product->save();
        }
        return responseJson(1, "success", $product);
    }


    public function editProducts(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name'       => 'required',
            'description'=> 'required',
            'price'      => 'required',
            'duration'   => 'required',
            'product_id' => 'required|exists:products,id'
        ]);
        if ($validator->fails()) 
        {
            return responseJson(0, $validator->errors()->first(), $validator->errors());
        }
        if($request->offering_price >= $request->price)
        {
            return responseJson(0, " برجاء مراجعة سعر العرض");
        }
        $product = $request->user()->products()->find($request->product_id);
        if($product)
        {
            $product->update($request->all());
        }
        return responseJson(1, "success", $product);
    }


    public function deleteProducts(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'id' => 'required|exists:products,id'
        ]);
        if($validation->fails())
        {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }
        $product = $request->user()->products()->find($request->id);
        if($product)
        {
            $product->delete();
        }
        return responseJson(1, "success");
    }


    public function ShowProducts(Request $request)
    {
        $products = Product::paginate(10);
        return responseJson(1, "قائمة الطعام", $products);
    }


    public function createOffer(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'         => 'required',
            'description'  => 'required',
            'start'        => 'required|date',
            'end'          => 'required|date',
        ]);
        if($validation->fails())
        {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }
        $offers = Offer::create($request->all());
        $offers->restaurant_id = request()->user()->id;
        if ($request->hasFile('image')) 
        {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/post', $logo_new_name);
            $offer->image = 'uploads/post/' . $logo_new_name;
            $offer->save();
        }
        return responseJson(1, "success", $offers);
    }


    public function updateOffers(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'name'           => 'required',
            'description'    => 'required',
            'start'          => 'required|date',
            'end'            => 'required|date',
            'restaurant_id'  => 'required|exists:restaurants,id'
        ]);
        if($validation->fails())
        {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }
        $offer = $request->user()->offers()->find($request->offer_id);
        if ( $request->hasFile('image'))
        {
            $logo = $request->image;
            $logo_new_name = time() . $logo->getClientOriginalName();
            $logo->move('uploads/post', $logo_new_name);
            $offer->image = 'uploads/post/'.$logo_new_name;
            $offer->update($request->all());
        }
        $offer->update($request->all());
        return responseJson(1, "success", $offer);
    }


    public function deleteOffers(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'offer_id' => 'required|exists:offers,id'
        ]);
        if($validation->fails())
        {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }
        $offer = $request->user()->offers()->find($request->offer_id);
        if($offer)
        {
            $offer->delete();
            return responseJson(1, "success");
        }
        return responseJson(0, "لا يوجد عرض");
       
    }


    public function orderDetails(Request $request)
    {
        $order = $request->user()->orders()->find($request->id);
        if($order)
        {
        return responseJson(1, "success", [
            'order' => $request->user()->load('order')
        ]);
        }
        return responseJson(0, "هذا المنتج غير موجود");
    }


    public function restaurantReviews(Request $request)
    {
        $request->user()->reviews()->find($request->restaurant_id);
        return responseJson(1, "success", [
            'review' => $request->user()->load('reviews')
        ]);
    }


   
    public function commission(Request $request)
    {
        $settings          = Setting::first();
        $commission        = $settings->commission * 100 . ' %';
        
        $restaurant_sales       = $request->user()->orders()->where('state', 'delivered')->sum('total');
        $app_commission         = $request->user()->orders()->where('state', 'delivered')->sum('commission');
        $restaurant_payment     = $request->user()->restaurant_payment;
        $rest_of_app_commission = $app_commission - $restaurant_payment;
               
        return responseJson(1, "تمت العملية بنجاح", compact('restaurant_sales', 'app_commission', 'restaurant_payment', 'rest_of_app_commission'));
    
    }


    public function restaurantNewOrder(Request $request)
    {
        $order = $request->user()->orders()->WhereIn('state', ['pending'])->get();
        return responseJson(1, " لديك طلب جديد", [
            'order' => $order->load('client', 'products')
        ]);
    }


    public function restaurantAcceptedOrders(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id'
        ]);
        if($validation->fails())
        {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }
        $order = $request->user()->orders()->find($request->order_id);
        if($order->state == 'pending')
        {
            $orders = $order->update([
                'state'=> 'accepted'
                ]);
            $client       = $order->client;
            
            $notification = $client->notifications()->create([
                'title'   => 'تم الموافقة علي طلبك',
                'body'    => 'تم الموافقة علي طلبك من قبل المطعم'. $request->user()->name,
                'order_id'=> $request->order_id
            ]);
            $tokens = $client->tokens()->where('token', '!=', Null)->pluck('token')->toArray();
           
            if($tokens)
            {
                $title = $notification->title;
                $body  = $notification->body;
                $data  = [
                    'order_id' => $order->id
                ];
                $send = notifyByFirebase($title, $body, $tokens, $data);
                $data = [
                    'order' => $order->fresh()->load('products')
                ];
                return responseJson(1, "تم الطلب بنجاح", [
                    'send' => $send,
                    'data' => $data
                ]);
            } 
            return responseJson(1, "تم قبول الطلب");
        }
        return responseJson(0, "لا يوجد طلبات علي قائمة الانتظار");
    }



    public function restaurantCurrentOrders(Request $request)
    {
        $order = $request->user()->orders()->WhereIn('state', ['accepted'])->get();
        return responseJson(1, "لديك طلبيات يجب تجهيزها", [
            'order' => $order->load('client', 'products')
        ]);
    }


    public function restaurantPreviousOrders(Request $request)
    {
        $order = $request->user()->orders()->WhereIn('status', ['rejected', 'delivered', 'declined'])->get();
        return responseJson(1, "طلباتك السابقة", [
            'order' => $order->load('client', 'payment_method', 'products')
        ]);
    }


    public function restaurantDeclinedOrder(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'order_id' => 'required|exists:orders,id'
        ]);
        if($validation->fails())
        {
            return responseJson(0, $validation->errors()->first(), $validation->errors());
        }
        $order = $request->user()->orders()->find($request->order_id);
        if($order->state == 'pending')
        {
            $orders = $order->update([
                'state' => 'rejected'
            ]);
            $client = $order->client;
            $notification = $client->notifications()->create([
                'title'   => 'تم رفض الطلب',
                'body'    => 'تم رفض طلب الطعام من قبل المطعم'. $request->user()->name,
                'order_id'=> $request->order_id
            ]);
            $tokens = $client->tokens()->where('token', '!=', NUll)->pluck('token')->toArray();
            if($tokens)
            {
                $title = $notification->title;
                $body  = $notification->body;
                $data  = ['order_id' => $order->id];
                $send  = notifyByFirebase($title, $body, $tokens, $data); 
            }
            $data = ['order' => $order->fresh()->load('products')];
            return responseJson(1 , "تم ارسال اشعار رفض الطلب", [
                'data' => $data,
                'send' => $send                                              
            ]);
        }
        return responseJson(0, " لا يمكن رفض ذلك الطلب");
    }


    public function deliveredOrders(Request $request)
    {
        $order = $request->user()->orders()->WhereIn('state', ['delivered'])->get();
        return responseJson(1, "الطلبات التي تم تسليمها للعملاء ", [
            'order' => $order->load('client', 'products')
        ]);
    }


    public function rejectedOrders(Request $request)
    {
        $order = $request->user()->orders()->WhereIn('state', ['rejected'])->get();
        return responseJson(1, " لديك طلب جديد", [
            'order' => $order->load('client', 'products')
        ]);
    }
}
