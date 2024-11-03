<?php
 namespace App\Services\Dashboard;

use App\Http\Traits\FileStorageTrait;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

 class Dash_ProductServices
 {
    use FileStorageTrait;

    //get all

    public function get_products($search)
    {
        $result=[];
        $msg='';
        
        $data=[];
        $status_code=400;
        if($search)
        {
            $products=Product::where('name','like', "%$search%")->get();
            $status_code=200;
            $msg='عرض  المنتجات حسب البحث بالاسم';
            $data['products']=$products;
        }
        else{
            $products=Product::all();
            $status_code=200;
            $msg='عرض حميع المنتجات';
            $data['products']=$products;

        }

        $result=[
            'data' => $data,
            'msg' => $msg,
            'status_code' => $status_code
         ];
         return $result;

    }

    //show

    public function get_product(Product $product)
    {
        $result=[];
        $msg='';
        $data=[];
        $status_code=400;
          $data['product']=$product;
          $status_code=200;
          $msg='عرض  المنتج المطلوب';
        
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
//------------------------------------
//update product 
public function update_product(array $input_data,Product $product)
{

    $result=[];
    $msg='';
    
    $data=[];
    $status_code=400;
    try{

        DB::beginTransaction();
        $newData=[];
        if(isset($input_data['name'])){
            $newData['name'] = $input_data['name'];
        }
        if(isset($input_data['description'])){
            $newData['description'] = $input_data['description'];
        }
        if(isset($input_data['volume'])){
            $newData['volume'] = $input_data['volume'];
        }
        if(isset($input_data['old_price'])){
            $newData['old_price'] = $input_data['old_price'];
        }
        if(isset($input_data['current_price'])){
            $newData['current_price'] = $input_data['current_price'];
        }
        if(isset($input_data['quantity'])){
            $newData['quantity'] = $input_data['quantity'];
        }
        if(isset($input_data['category_id'])){
            $newData['category_id'] = $input_data['category_id'];
        }
        if(isset($input_data['parent_id'])){
            $newData['parent_id'] = $input_data['parent_id'];
        }
        if(isset($input_data['image'])){
            $newData['image'] =$this->storeFile($input_data['image'],'products');
        }
        if(isset($input_data['specifications'])){
            $newData['specifications'] =$this->storeFile($input_data['specifications'],'products');
        }
        if(isset($input_data['ingredients'])){
            $newData['ingredients'] =$this->storeFile($input_data['ingredients'],'products');
        }
        if(isset($input_data['ingredients'])){
            $newData['ingredients'] =$this->storeFile($input_data['ingredients'],'products');
        }
        $product->update($newData);
        DB::commit();
        $msg='تم التعديل';
        $status_code=200;
        $data['product'] = $product;
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
//-
public function delete_product(Product $product)
{
    $result=[];
    $data=[];
    $status_code=200;
    $msg='';
    if($product)
    {
        $product->delete();
        $products=Product::all();
        $data['products'] = $products;
        $msg = 'تم حذف المنتج بنجاح';
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
 }

?>