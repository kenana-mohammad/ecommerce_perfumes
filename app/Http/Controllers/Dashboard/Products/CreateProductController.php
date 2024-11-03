<?php

namespace App\Http\Controllers\Dashboard\Products;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\Common\ProductResource;
use App\Http\Requests\Dashboard\Product\CreateProductRequest;
use App\Http\Requests\Dashboard\Product\UpdateProductRequest;
use App\Services\Dashboard\Dash_ProductServices;

class CreateProductController extends Controller
{
    //

    use ApiResponseTrait;
    public function __construct(protected Dash_ProductServices $dash_product_service)
    {

    }

    //get

    public function get_products(Request $request)

    {
        $search=$request->search;
        $result=$this->dash_product_service->get_products($search);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['products']);
            $output['products'] = ProductResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);

   }
//show
public function get_product(Product $product)

{
  
    $result=$this->dash_product_service->get_product($product);
    $output=[];
    if($result['status_code']==200)
    {
        $result_data=$result['data'];
        $output['product'] = new ProductResource($result_data['product']);

    }
    return $this->send_response($output, $result['msg'], $result['status_code']);

}


    
    //create product
 
     public function create_product(CreateProductRequest $request)
    {

         $input_data=$request->validated();
         $result=$this->dash_product_service->create_product($input_data);
         $output=[];
         if($result['status_code']==200)
         {
             $result_data=$result['data'];
             $output['product']=new ProductResource($result_data['product']);
 
         }
         return $this->send_response($output, $result['msg'], $result['status_code']);
 
    }

    //update

    public function update_product(UpdateProductRequest $request,Product $product)
    {
        $input_data=$request->validated();
        $result=$this->dash_product_service->update_product($input_data,$product);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['product']=new ProductResource($result_data['product']);

        }
        return $this->send_response($output, $result['msg'], $result['status_code']);
    }
    //delete
    public function delete_product(Product $product)
    {
        
        $result=$this->dash_product_service->delete_product( $product);
        $output=[];
        if($result['status_code'] == 200 )
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['products']);
            $output['products'] = ProductResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];
                }
                return $this->send_response($output, $result['msg'], $result['status_code']);


    }
}
