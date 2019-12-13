<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Mail\Mailable;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;



use App\Models\Client;
use  App\Models\Token;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name'         => 'required',
            'email'        => 'required|email|unique:clients',
            'phone'        => 'required',
            'password'     => 'required|confirmed',
            'district_id'  => 'required'
        ]);
        if($validator->fails())
        {
            return responseJson(0, "validation fails", $validator->errors());
        }
        $request->merge(['password' => Hash::make($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = Str::random(60);
        $client->save();
        return responseJson(1, "تم التسجيل بنجاح", [
            'api_token' => $client->api_token,
            'client'    => $client
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
            $client = Client::where('email', $request->email)->first();
            if(Hash::check($request->password, $client->password))
            {
                return responseJson(1, "تم تسجيل الدخول بنجاح ", [
                    'api_token' => $client->api_token,
                    'client'    => $client
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
        $client = Client::where('email',$request->email)->first();
        if($client)
        {
            $code  = Str::random(4);
            $update= $client->update(['pin_code' => $code]);
            if($update)
            {
                // send sms
                // send email
                Mail::to($client->email)
                      ->bcc("khaledelsheikh93@gmail.com")
                      ->send(new ResetPassword($client));

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
            'email'    => 'required|email',
            'password' => 'required|confirmed',
            'pin_code' => 'required'
        ]);
        if($validation->fails())
        {
            return responseJson(0, "برجاء التأكد من البيانات");
        }
        $client = Client::where('email', $request->email)->first();
        if($client)
        {
            if($client->pin_code == $request->pin_code)
            {
                $client->update(['password'=>bcrypt($request->password)]);
                return responseJson(1, "تم تغيير الرقم السري بنجاح"); 
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
            'token' => 
            'required' 
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
