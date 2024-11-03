<?php
namespace App\Services\Website;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Common\OrderResource;
use App\Models\User;
use Exception;

class OrderServices
{
    //applay order
    public function applay_order(array $input_data)
    {
        $result=[];
        $msg='';
        $data=[];
        $status_code=200;
        $totalAmount = 0;
        try {
            DB::beginTransaction();
    
            $newOrderNumber = Order::generateOrderNumber();
            $coupon = isset($input_data['code']) ? Coupon::where('code', $input_data['code'])->first() : null;

            $order = Order::create([
                'order_number' => $newOrderNumber,
                'user_id' => Auth::user()->id,
                'status' => 'pending',
                'delivery_type' => $input_data['delivery_type'] ?? 'non_delivery',
                'copone_code' => $coupon->code
            ]);
            $data['order']=$order;

            $msg='تم الطلب يرجى الانتظار لتتم الموافقة';
            $status_code=200;
            $products = $input_data['products'];
    
            foreach ($products as $productData) {
                $product = Product::find($productData['product_id']);
    
                if ($product) {
                    if ($product->quantity >= $productData['quantity']) {
                        $quantity = $productData['quantity'];
                        $productPrice = $product->current_price;
                        $sumPrice = $productPrice * $quantity;
    
                        $totalAmount += $sumPrice;
    
                        OrderItem::create([
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'order_id' => $order->id,
                            'sum_price' => $sumPrice,
                        ]);
    
                    } else {
                      $msg='الكمية المتوفرة أقل من المطلوبة حيث يتوفر ' . $product->quantity . ' فقط.';
                      $status_code=404;
                    }
                } else {
                $msg='المنتج غير موجود';
            $status_code=404;
                        }
            }
    
            if ($coupon) {
                if ($coupon->expires_at < now()) {
                    $msg= 'الكود منتهي الصلاحية وغير صالح للخصم.';
                    $status_code=400;
                }
        
                if ($coupon->discount_percent) {
                    $totalAmount = $totalAmount * (1 - ($coupon->discount_percent / 100));
                } elseif ($coupon->discount_amount) {
                    $totalAmount = max(0, $totalAmount - $coupon->discount_amount);
                }
            }
 
          DB::commit();
          $data['totalAmount']=$totalAmount;

          
    
        }     
          catch(Exception $th)
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

//-------------------------------------------------------
  //get my orders
  public function my_orders($status)
  {
    $result=[];
        $msg='';
        $data=[];
        $status_code=200;

        $user=User::find(Auth::user()->id);

        if($user){
            $query=$user->orders()->get();
            if($query){

             if($status == 'pending'){
               $query =$query->where('status','pending');
             }elseif($status=='confirmed'){
                $query =$query->where('status','confirmed');

             }
                    $data['orders'] = $query;
                    $status_code=200;
                    $msg='عرض طلباتي';
    
                }
                else{
                    $msg='لايوجد طلبات';
                    $status_code=404;
    
                
            }
           
          
            
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