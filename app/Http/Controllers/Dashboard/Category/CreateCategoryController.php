<?php

namespace App\Http\Controllers\Dashboard\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\Common\ProductResource;
use App\Services\Dashboard\Dash_CategoryServices;
use App\Http\Resources\Dashboard\CategoryResource;
use App\Http\Requests\Dashboard\Product\CreateProductRequest;
use App\Http\Requests\Dashboard\Category\CreateCategoryRequest;
use App\Http\Requests\Dashboard\Category\UpdateCategoryRequest;

class CreateCategoryController extends Controller
{
    //
    use ApiResponseTrait;

    public function __construct(protected Dash_CategoryServices $dash_category_services)
    {

    }
    // get all 
    public function get_categories()

    {
        $result=$this->dash_category_services->get_categories();
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['categories']);
            $output['categories'] = CategoryResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];
        }
        return $this->send_response($output, $result['msg'], $result['status_code']);


    }

    
    //create category

    public function create_category(CreateCategoryRequest $request)
    {
        $input_data=$request->validated();
        $result=$this->dash_category_services->create_category($input_data);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['category']=new CategoryResource($result_data['category']);

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);



    }
    public function create_product(CreateProductRequest $request)
    {

         $input_data=$request->validated();
         $result=$this->dash_category_services->create_product($input_data);
         $output=[];
         if($result['status_code']==200)
         {
             $result_data=$result['data'];
             $output['product']=new ProductResource($result_data['product']);
 
         }
         return $this->send_response($output, $result['msg'], $result['status_code']);
 
    }
    //update
    public function update_category(UpdateCategoryRequest $request,Category $category)
    {
        $input_data=$request->validated();
        $result=$this->dash_category_services->update_category($input_data,$category);
        $output=[];
        if($result['status_code'] == 200 )
        {
            $result_data=$result['data'];
            $output['category'] = new CategoryResource($result_data['category']);
                }
                return $this->send_response($output, $result['msg'], $result['status_code']);
    }
    //show 
    public function get_category(Category $category)
    {
        $result=$this->dash_category_services->get_category( $category);
        $output=[];
        if($result['status_code'] == 200 )
        {
            $result_data=$result['data'];
            $output['category'] = new CategoryResource($result_data['category']);
                }
                return $this->send_response($output, $result['msg'], $result['status_code']);

    }
    //delete
    public function delete_category(Category $category)
    {
        $result=$this->dash_category_services->delete_category( $category);
        $output=[];
        if($result['status_code'] == 200 )
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['categories']);
            $output['categories'] = CategoryResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];
                }
                return $this->send_response($output, $result['msg'], $result['status_code']);


    }
}
