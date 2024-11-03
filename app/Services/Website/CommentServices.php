<?php
namespace App\Services\Website;

use App\Models\User;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;
class CommentServices{

    //get comments
    public function get_comments($sort_by,Product $product)
    {
        $result=[];
        $msg='';
        $data=[];
        $status_code=400;
        $query=$product->comments();
        if($sort_by)
        {
            $query->orderBy('created_at', $sort_by);
        } else {
            $query->orderBy('created_at', 'desc');
        }
            $comments=$query->get();
        
           $data['comments']= $comments;
           $msg='عرض التعليقات الخاصة بالمنتج';
           $status_code=200;         


        $result=[
            'data' => $data,
            'msg' => $msg,
            'status_code' => $status_code
         ];
         return $result;

    }

    public function add_comment(array $input_data ,Product $product)
    {
        $result=[];
        $msg='';
        $data=[];
        $status_code=400;

     try{
        DB::beginTransaction();
        $user_id=Auth::user()->id;
        $user=User::find($user_id);
        if($user)
        {
$hasPurchased = Order::where('user_id', $user->id)
                     ->where('status', 'confirmed') 
                     ->whereHas('items', function($query) use ($product) {
                         $query->where('product_id', $product->id);
                     })
                     ->exists();            
            if($hasPurchased)
            {

              
                $comment = $product->comments()->updateOrCreate(
                    [
                        'user_id' => $user->id, 
                    ],
                    [
                        'rating' => $input_data['rating'],
                        'comment' => $input_data['comment'] ?? null,
                    ]
                );
                DB::commit();
              $data['comment'] = $comment;
             $msg='تم التعليق';
             $status_code=200;


            }
            else{
                $msg ='لا يمكنك التعليق على هذا المنتج لأنك لم تقم بشرائه.';
                $status_code = 403;
            }
            }
        
        
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
}






?>