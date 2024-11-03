<?php
namespace App\Services\Dashboard;

use Throwable;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\FileStorageTrait;

class Dash_CategoryServices
{
    use FileStorageTrait;

     //get all categories

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


      //create category

      public function create_category(array $input_data)
      {
        $data=[];
        $result=[];
        $status_code=400;
        $msg='';
        try{
             $category=Category::create([
                 'name' => $input_data['name']

             ]);
             $data['category'] = $category;
             $msg='تم اضافة تصنيف للعطور';
             $status_code=200;
           
        }
        catch(Throwable $th)
        {
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

      //update 

      public function update_category(array $input_data,Category $category)
      {
        $result=[];
        $data=[];
        $status_code=200;
        $msg='';
        try{
            DB::beginTransaction();
          $category->update([
                        'name' => $input_data['name'] ?? $category->name,
            ]);
            DB::commit();
            $data['category']= $category;
            $status_code=200;
            $msg='تم التعديل بنجاح';

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
      //show
      public function get_category(Category $category)
      {
        $result=[];
        $data=[];
        $status_code=200;
        $msg='';
        $data['category'] = $category;
        $status_code=200;
        $msg='تم عرض التصنيف المطلوب';


        $result=[
            'data' => $data,
            'msg' => $msg,
            'status_code' => $status_code
         ];
         return $result;


      }
      //delete
      public function delete_category(Category $category)
      {

        $result=[];
        $data=[];
        $status_code=200;
        $msg='';
        if($category)
        {
            $category->delete();
            $categories=Category::all();
            $data['categories'] = $categories;
            $msg = 'تم حذف التصنيف بنجاح';
            $status_code = 200;
        }else{
            $msg=' لا يوجد العنصر المطلوب';
            $status_code=404;
        }

        $result=[
            'data' => $data,
            'msg' => $msg,
            'status_code' => $status_code
         ];
         return $result;



      }
      
   public function create_product(array $input_data)
   {
    $result=[];
    $msg='';
    
    $data=[];
    $status_code=400;
    try{
        DB::beginTransaction();
        $product=Product::create([
           'name' => $input_data['name'],
           'description' => $input_data['description']??null,
           'volume' => $input_data['volume']??50,
           'old_price' => $input_data['old_price']??0,
           'current_price' => $input_data['current_price'],
           'quantity' => $input_data['quantity']??0,
           'category_id' => $input_data['category_id'],
           'parent_id' => $input_data['parent_id']??null,  
           'features'   => $input_data['features']??null,
           'specifications'   => $input_data['specifications']??null,
           'ingredients' => $input_data['ingredients']??null,
           'image'        => $this->storeFile($input_data['image'],'products'),
        ]);
        DB::commit();
        $data['product'] = $product;
        $msg='تم اضافة  المنتج';
        $status_code=200;
      
        

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