<?php

namespace App\Http\Controllers\Dashboard\Blog;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Services\Dashboard\Dash_BlogServices;
use App\Http\Resources\Common\Blog\BlogResource;
use App\Http\Requests\Dashboard\Blog\BlogRequest;
use App\Http\Requests\Dashboard\Blog\UpdateBlogRequest;

class Create_BlogController extends Controller
{
    //

    use ApiResponseTrait;

    public function __construct(protected Dash_BlogServices $blog_services)
    {

    }
    // get all 
    public function get_blogs()

    {
        $result=$this->blog_services->get_blogs();
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['blogs']);
            $output['blogs'] = BlogResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];
        }
        return $this->send_response($output, $result['msg'], $result['status_code']);


    }

    
    //create 

    public function create_blog(BlogRequest $request)
    {
        $input_data=$request->validated();
        $result=$this->blog_services->create_blog($input_data);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['blog']=new BlogResource($result_data['blog']);

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);



    }
    public function get_blog(Blog $blog)
    {
        $result=$this->blog_services->get_blog( $blog);
        $output=[];
        if($result['status_code'] == 200 )
        {
            $result_data=$result['data'];
            $output['blog'] = new BlogResource($result_data['blog']);
                }
                return $this->send_response($output, $result['msg'], $result['status_code']);

    }
    //update
    public function update_blog(UpdateBlogRequest $request,Blog $blog)
    {
        $input_data=$request->validated();
        $result=$this->blog_services->update_blog($input_data,$blog);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['blog']=new BlogResource($result_data['blog']);

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);
    }
    public function Delete_Blog(Blog $blog)
    {
        $result=$this->blog_services->delete_blog( $blog);
        $output=[];
        if($result['status_code'] == 200 )
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['blogs']);
            $output['blogs'] = BlogResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];
                }
                return $this->send_response($output, $result['msg'], $result['status_code']);


    }

  
}
