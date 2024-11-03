<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\CategoryResource;
use App\Http\Resources\Website\all_alternativesResource;
use App\Http\Resources\Website\Web_ProductResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Services\Website\Web_FrontServices;
use Illuminate\Http\Request;

class Front_Controller extends Controller
{
    //
    use ApiResponseTrait;
    public function __construct(protected Web_FrontServices $web_front_services)
    {


    }
//get all categories
    public function get_categories()

    {
        $result=$this->web_front_services->get_categories();
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['categories'] = CategoryResource::collection($result_data['categories']);
        }
        return $this->send_response($output, $result['msg'], $result['status_code']);


    }
    //جميع البدائل
      public function all_alternatives(Request $request)
      {
        $search=$request->search;
        $result=$this->web_front_services->all_alternatives($search);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['products']);
            $output['products'] = Web_ProductResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);


      }

    //----get product  by category
      

     public function get_products_by_category(Request $request,Category  $category)

     {
    
        $search=$request->search;
        $sort_by=$request->sort_by;
        $result=$this->web_front_services->get_products_by_category($category,$search,$sort_by);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['products']);
            $output['products'] = Web_ProductResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);


      

     }

}
