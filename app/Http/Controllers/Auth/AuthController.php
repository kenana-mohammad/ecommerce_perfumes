<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Auth\Web_AuthUserServices;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
 use ApiResponseTrait;
    public function __construct(protected Web_AuthUserServices $auth_user_services)
    {

    }

    //Register

    public function register_user(RegisterUserRequest $request)
    {

        $input_data=$request->validated();
        $result=$this->auth_user_services->register_user($input_data);
        $output=[];
        if($result['status_code'] == 200)
        {
            $result_data=$result['data'];
            $output['user'] = new UserResource($result_data['user']);
            $output['auth_token'] = $result_data['auth_token'];
        }
        return $this->send_response($output, $result['msg'], $result['status_code']);

    }
    //login

    public function login_user (LoginUserRequest $request)

    {
        $input_data=$request->validated();
        $result=$this->auth_user_services->login_user($input_data);
        if($result['status_code'] == 200)
        {
            $result_data=$result['data'];
            $output['user'] = new UserResource($result_data['user']);
            $output['auth_token'] = $result_data['auth_token'];
        }
        return $this->send_response($output, $result['msg'], $result['status_code']);



    }
    //logout'
    public function logout_user()
    {
        $result = $this->auth_user_services->logout_user();

        $output = [];
        if ($result['status_code'] == 200) {
            $result_data = $result['data'];
            // response data preparation:
        }

        return $this->send_response($output, $result['msg'], $result['status_code']);


    }
}
