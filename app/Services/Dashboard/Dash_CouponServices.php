<?php
namespace App\Services\Dashboard;
use App\Models\CoponCode;
use App\Models\Coupon;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Dash_CouponServices
{

    public function create_copon (array $input_data)
    {
        $result=[];
        $data=[];
        $status_code=200;
        $msg='';
        try{
            
          $coupon=  Coupon::create([
                'code' => $input_data['code'],
                'discount_percent' => $input_data['discount_percent']??null,
                'discount_amount' => $input_data['discount_amount']??null,
                'expires_at' => $input_data['expires_at'],
            ]);
            $msg='اضافة كوبون';
            $status_code=200;
            $data['coupon']=$coupon;
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