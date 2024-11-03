<?php

namespace App\Http\Controllers\Dashboard\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Copon\CreateCoponRequest;
use App\Http\Resources\Dashboard\Copon\CoponResource;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Dashboard\Dash_CouponServices;
use Illuminate\Http\Request;

class CreateCouponContoller extends Controller
{
    //
    use ApiResponseTrait;

    public function __construct(protected Dash_CouponServices $dash_coupon_services)
    {

    }
    public function create_coupon(CreateCoponRequest $request)
    {
        $input_data=$request->validated();
        $result=$this->dash_coupon_services->create_copon($input_data);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['coupon']=new CoponResource($result_data['coupon']);

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);


    }
}
