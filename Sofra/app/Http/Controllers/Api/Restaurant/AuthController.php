<?php

namespace App\Http\Controllers\Api\Restaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Mail\Mailable;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

use App\Models\Restaurant;
use  App\Models\Token;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name'           => 'required',
            'email'          => 'required|email|unique:restaurants',
            'phone'          => 'required',
            'password'       => 'required|confirmed',
            'district_id'    => 'required',
            'delivery_charge'=> 'required',
            'minimum_order'  => 'required',
            'contact_phone'  => 'required',
            'whats'          => 'required',
            'category_id'    => 'required'
        ]);
        if($validator->fails())
        {
            return responseJson(0, "validation fails", $validator->errors());
        }
        $request->merge(['password' => Hash::make($request->password)]);
        $restaurant = Restaurant::create($request->all());
        $restaurant->api_token = Str::random(60);
        $restaurant->save();
        return responseJson(1, "تم التسجيل بنجاح", [
            'api_token'  => $restaurant->api_token,
            'restaurant' => $restaurant
        ]);  
    }


    public function login(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required'
        ]);
        if($validation->fails())
        {
            return responseJson(0, "validation failed", $validation->errors());
        }
            $restaurant = Restaurant::where('email', $request->email)->first();
            if(Hash::check($request->password, $restaurant->password))
            {
                return responseJson(1, "تم تسجيل الدخول بنجاح ", [
                    'api_token'  => $restaurant->api_token,
                    'restaurant' => $restaurant
                ]);
            }
            else
            {
                return responseJson(0, "برجاء التأكد من البيانات واعادة المحاولة");

            } 
    }


    public function sendPinCode(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'email'    => 'required|email'
        ]);
        if($validator->fails())
        {
            $data = $validator->errors();
            return responseJson(0, $validator->errors()->first(), $data);
        }
        $restaurant = Restaurant::where('email',$request->email)->first();
        if($restaurant)
        {
            $code  = Str::random(4);
            $update= $restaurant->update(['pin_code' => $code]);
            if($update)
            {
                // send sms
                // send email
                Mail::to($restaurant->email)
                      ->bcc("khaledelsheikh93@gmail.com")
                      ->send(new ResetPassword($restaurant));

                return responseJson(1 , "برجاء فحص هاتفك");
            }
            else
            {
                return responseJson(0, "حدث خطأ، حاول مرة أخري");
            }   
        }
        else
            {
                return responseJson(0, "لا يوجد حساب مرتبط بهذا الهاتف");
            }
    }


    public function newPassword(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'email'    => 'required|eamil',
            'password' => 'required|confirmed',
            'pin_code' => 'required'
        ]);
        if($validation->fails())
        {
            return responseJson(0, "برجاء التأكد من البيانات");
        }
        $restaurant = Restaurant::where('email', $request->email)->first();
        if($restaurant)
        {
            if($restaurant->pin_code == $request->pin_code)
            {
                $restaurant->update(['password' , Hash::make($request->password)]);
                return responseJson(1, "تم تسجيل الدخول بنجاح", [           
                    'api_token'  => $restaurant->api_token,
                    'restaurant' => $restaurant
                ]); 
            }
            else
            {
                return responseJson(0, "كود الدخول غير صحيح");
            }
        }
        else
        {
            return responseJson(0, "لايوجد مستخدم مسجل بهذا البريد الالكتروني "); 
        }
    }


    public function registerToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required' 
        ]);
        if($validation->fails())
        {
            responseJson(0, "validation failed", $validation->errors());
        }
        $request->user()->tokens()->create($request->all());
        return responseJson(1, "تم التسجيل بنجاح");
    }


    public function removeToken(Request $request)
    {
        $validation = validator()->make($request->all(), [
            'token' => 'required'
        ]);
        if($validation->fails())
        {
            $data = $validation->errors();
            return responseJson(0, $validation->errors()->first(), $data);
        }
        Token::where('token', $request->token)->delete();
        return responseJson(1, "تم الحذف بنجاح");
    }



}
