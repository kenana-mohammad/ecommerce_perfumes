<?php
namespace App\Services\Website;

use App\Models\Category;
use App\Models\Product;

class Web_FrontServices{

    public function get_categories()
    {
       $data=[];
       $result=[];
       $status_code=400;
       $msg='';
       $categories=Category::all();
       $data['categories'] = $categories;
       $msg=' تم استرداد جميع التصنيفات للعطور';
       $status_code=200;
       $result=[
           'data' => $data,
           'msg' => $msg,
           'status_code' => $status_code
        ];
        return $result;

    }
    //-------------------------------------------------------------
    // get all_alternatives
    public function all_alternatives($search)
    {
        $data=[];
       $result=[];
       $status_code=400;
       $msg='';
  $query = Product::query()->whereNotNull('parent_id');

  if ($search) {
      $query->where('name', 'like', '%' . $search . '%'); // إضافة شرط البحث
    
    }
  
  $all_alternatives = $query->get(); 
  
  $data['products'] = $all_alternatives;

  if ($all_alternatives->isEmpty()) {
      $msg = 'لا توجد بدائل للعطور متاحة'; // 
      $status_code=404;
  } 
    else {
        if ($search) {
            $msg = 'تم استرداد البدائل حسب البحث للعطور';
        } else {
            $msg = 'تم استرداد جميع البدائل للعطور'; 
        }
        $status_code = 200; 
           }

  


       $result=[
           'data' => $data,
           'msg' => $msg,
           'status_code' => $status_code
        ];
        return $result;
    }
    ///-------------------------------
    //get products by category

    public function get_products_by_category(Category $category,$search=null,$sort_by)
    {


        $data=[];
        $result=[];
        $status_code=400;
        $msg='';
         $query=Product::query()->where('category_id',$category->id);
         if($search)
         {
            $query->where('name', 'like', '%' . $search . '%'); // إضافة شرط البحث
        }
        if($sort_by){
            $query->orderBy('current_price',$sort_by);
        }
        $products=$query->get();
         $data['products'] = $products;
         $status_code=200;
         $msg='عرض العطور حسب التصنيف';
        $result=[
            'data' => $data,
            'msg' => $msg,
            'status_code' => $status_code
         ];
         return $result;


    }
}








?>