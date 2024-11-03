<?php
namespace App\Services\Dashboard;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class Dash_orderServices
{
    public function change_status_order(array $input_data,Order $order)
    {
        $result=[];
        $data=[];
        $msg='';
        $status_code=400;
        try{

            DB::beginTransaction();
            $order=Order::where('id',$order->id)->first();
            if($order){
                $order->update([
                    'status' => $input_data['status']
                ]);

            }
            DB::commit();
            $msg='تم تغيير  الحالة';
            $status_code=200;
            $data['order']=$order;
            
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
}






?>