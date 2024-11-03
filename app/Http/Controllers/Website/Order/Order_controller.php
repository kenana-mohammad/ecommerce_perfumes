<?php

namespace App\Http\Controllers\Website\Order;

use App\Http\Traits\ApiResponseTrait;
use Exception;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Website\OrderServices;
use App\Http\Resources\Common\OrderResource;
use App\Http\Requests\website\CreateOrderRequest;

class Order_controller extends Controller
{
    //
    use ApiResponseTrait;
    public function __construct(protected OrderServices $auth_order_services)
    {
        
    }
    public function applay_order(CreateOrderRequest $request)
    {
       $input_data=$request->validated();
       $result=$this->auth_order_services->applay_order($input_data);
       $output=[];
       if($result['status_code']==200)
       {
           $result_data=$result['data'];
           $output['order'] = new OrderResource ($result_data['order']);
           $output['totalAmount']=$result_data['totalAmount'];
       }
       return $this->send_response($output, $result['msg'], $result['status_code']);
    }
    
    //get my order
    public function my_orders(Request $request)
    {
        $status=$request->status;
        $result=$this->auth_order_services->my_orders($status);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['orders'] =  OrderResource::collection ($result_data['orders']);
            // $output['totalAmount']=$result_data['totalAmount'];
        }
        return $this->send_response($output, $result['msg'], $result['status_code']);
   

    }
}
