<?php
namespace App\Services\Website;

use Auth;
use Exception;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReviewServices
{
    public function add_review(array $input_data)
    {
        $result=[];
        $msg='';
        $data=[];
        $status_code=200;

        try{
            DB::beginTransaction();
            $user=Auth('api')->user();
            $review=Review::UpdateOrcreate([
                'user_id'=> $user->id,
              'rating' => $input_data['rating'],
              'comment' => $input_data['comment']??null
            ]);
            DB::commit();
            $data['review']=$review;
            $status_code=200;
            $msg='تم اضافة تقييمك للمتجر';

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
//--------------------


 public function get_reviewes($sort_by)
 {

    $result=[];
    $msg='';
    $data=[];
    $status_code=400;
    $query=Review::query();

    
if ($sort_by ) {
    $query->orderBy('created_at', $sort_by);
} else {
    $query->orderBy('created_at', 'desc');
}
    $reviewes=$query->get();

   $data['reviewes']= $reviewes;
   $msg='عرض التقيمات';
   $status_code=200;
    $result=[
        'data' => $data,
        'msg' => $msg,
        'status_code' => $status_code
     ];
     return $result;
 




    }






}
?>