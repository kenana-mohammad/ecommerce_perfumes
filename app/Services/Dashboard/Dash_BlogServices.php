<?php
namespace App\Services\Dashboard;

use Throwable;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Traits\FileStorageTrait;

class Dash_BlogServices{
    use FileStorageTrait;
    public function create_blog(array $input_data)
    {
      $data=[];
      $result=[];
      $status_code=400;
      $msg='';
      try{
         $images=[];
            if (isset($input_data['images'])) {
                foreach ($input_data['images'] as $image) {
                    $images[] = $this->storeFile($image, 'images');
               }
               }
        $blog = Blog::create([
            'title' => $input_data['title'],
            'content' => $input_data['content'],
            'main_image' =>isset($input_data['main_image'])? $this->storeFile($input_data['main_image'], 'blog'):null,
            'images'=> implode(' , ', $images)??null

            ]);
           $data['blog'] = $blog;
           $msg='تم اضافة  مدونة';
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

//---
public function get_blogs()
{
    $data=[];
    $result=[];
    $status_code=400;
    $msg='';
    $blogs=Blog::all();
    $data['blogs'] = $blogs;
    $msg=' تم استردادالمدونات للعطور';
    $status_code=200;
    $result=[
        'data' => $data,
        'msg' => $msg,
        'status_code' => $status_code
     ];
     return $result;

}
///show
public function get_blog(Blog $blog)
{
    $data=[];
    $result=[];
    $status_code=400;
    $msg='';
    $data['blog'] = $blog;
    $msg=' تم  عرض المدونة المطلوبة';
    $status_code=200;
    $result=[
        'data' => $data,
        'msg' => $msg,
        'status_code' => $status_code
     ];
     return $result;

}
//update
public function update_blog(array $input_data,Blog $blog)
{

    $result=[];
    $msg='';
    
    $data=[];
    $status_code=400;
    try{

        DB::beginTransaction();
        $newData=[];
        if (isset($input_data['images'])) {
            foreach ($input_data['images'] as $image) {
                $images[] = $this->storeFile($image, 'images');
           }
           }
        if(isset($input_data['title'])){
            $newData['title'] = $input_data['title'];
        }
        if(isset($input_data['content'])){
            $newData['content'] = $input_data['content'];
        }
        if(isset($input_data['main_image'])){
            $newData['main_image'] = $this->storeFile($input_data['main_image'], 'blog');
        }
       if (isset($input_data['images'])){
            $newData['images'] = implode(' , ', $images);
        }
        
        $blog->update($newData);
        DB::commit();
        $msg='تم التعديل';
        $status_code=200;
        $data['blog'] = $blog;
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

//delete
public function delete_blog(Blog $blog)
{

  $result=[];
  $data=[];
  $status_code=200;
  $msg='';
  if($blog)
  {
      $blog->delete();
      $blogs=Blog::all();
      $data['blogs'] = $blogs;
      $msg = 'تم حذف  بنجاح';
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