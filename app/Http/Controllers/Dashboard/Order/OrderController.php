<?php

namespace App\Http\Controllers\Dashboard\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Order\ChangeStatusOrderRequest;
use App\Http\Resources\Common\OrderResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Order;
use App\Services\Dashboard\Dash_orderServices;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    use ApiResponseTrait;
    public function __construct(protected Dash_orderServices $dash_order_services)
    {

    }

    public function change_status_order(ChangeStatusOrderRequest $request,Order $order)
    {
       
        $input_data=$request->validated();
        $result=$this->dash_order_services->change_status_order($input_data,$order);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['order']=new OrderResource($result_data['order']);

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);


    }
}
