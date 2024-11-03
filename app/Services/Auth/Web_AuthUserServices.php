<?php
namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class Web_AuthUserServices
{
    //register

    public function register_user(array $input_data)
    {
        $result=[];
        $data=[];
        $msg='';
        $status_code=400;

        try
        {
            DB::beginTransaction();
            $user=User::create([
                'name' => $input_data['name'],
                'email' => $input_data['email'],
                'password' => $input_data['password'],
                'phone_number' => $input_data['phone_number'],
                'role'=> 'user'
            ]);
            DB::commit();
            $auth_token = JWTAuth::fromUser($user);
            $data['user'] = $user;
            $data['auth_token'] = $auth_token;
            $msg='تم اضافة حسايك ينجاح';
            $status_code=200;     
        }

 catch(Throwable $th)
        {
            DB::rollBack();

            Log::debug($th);

            $status_code = 500;
            $data = $th;
            $msg = 'error ' . $th->getMessage();

        }
        $result=[
            'data' => $data,
            'msg' => $msg,
            'status_code' => $status_code
         ];
         return $result;
    }
    //login

    public function login_user(array $input_data)
    {
        $result=[];
        $data=[];
        $msg='';
        $status_code=400;
        $credentials = [
            'email' => $input_data['email'],
            'password' => $input_data['password']
        ];
            if(!$auth_token = Auth::guard('api')->attempt($credentials))
            {
                $status_code = 404;
                $msg = 'Please Check your Username and Password';
            } else {
                $user=Auth::guard('api')->user();
                $data['user'] =$user;
                $data['auth_token'] =$auth_token;
                $status_code = 200;
                $msg = 'logged In';
            }

        $result=[
            'data' => $data,
            'msg' => $msg,
            'status_code' => $status_code
         ];
         return $result;

    }
    //logout
    public function logout_user()
    {
        $result=[];
        $data=[];
        $msg='';
        $status_code=400;

        if(Auth::guard('api')->user()){
            $user_id=Auth::guard('api')->user()->id;
            $user=User::find($user_id);
            $user->tokens()->delete();
            auth('api')->logout();

            $status_code = 200;
            $msg = "تم تسجيل الخروج بنجاح!...";
        } else {
            $status_code = 400;
            $msg = 'لايمكن التحقق من المستخدم، فشل تسجيل الخروج';
        }
        $result=[
            'data' => $data,
            'msg' => $msg,
            'status_code' => $status_code
         ];
         return $result;
    }

}






?>