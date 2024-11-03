<?php

namespace App\Http\Controllers\Website\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Comment\CreateCommentRequest;
use App\Http\Resources\Common\ProductResource;
use App\Http\Resources\Website\Comment\commentresource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;
use App\Services\Website\CommentServices;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //

    use ApiResponseTrait;
    public function __construct(protected CommentServices $website_comment_services )
    {

    }
    public function add_comment(CreateCommentRequest $request,Product $product)
    {
        $input_data=$request->validated();
        $result=$this->website_comment_services->add_comment($input_data,$product);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['comment']=new commentresource($result_data['comment']);
    }
    return $this->send_response($output, $result['msg'], $result['status_code']);

        
    }
    //get comments by product 

       public function get_comments(Request $request, Product $product)
    {
        $sort_by=$request->sort_by;
        $result=$this->website_comment_services->get_comments($sort_by,$product);
        $output=[];
        if($result['status_code']==200)
        {

            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['comments']);
            $output['comments'] = commentresource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];
        
        }
        return $this->send_response($output, $result['msg'], $result['status_code']);


    }



}