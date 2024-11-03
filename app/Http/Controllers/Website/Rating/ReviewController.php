<?php

namespace App\Http\Controllers\Website\Rating;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Review\ReviewRequest;
use App\Http\Resources\Common\RatingResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Review;
use App\Services\Website\ReviewServices;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    use ApiResponseTrait;
    public function __construct(protected ReviewServices $website_review_services)
    {


    }

    public function get_reviewes(Request $request)
    {
        $sort_by=$request->sort_by;
        $result=$this->website_review_services->get_reviewes($sort_by);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $paginated = $this->paginate($result_data['reviewes']);
            $output['reviewes'] = RatingResource::collection($paginated['data']);
            $output['meta'] = $paginated['meta'];
    }
    return $this->send_response($output, $result['msg'], $result['status_code']);

}
    public function add_review(ReviewRequest $request)
    {
        $input_data=$request->validated();
        $result=$this->website_review_services->add_review($input_data);
        $output=[];
        if($result['status_code']==200)
        {
            $result_data=$result['data'];
            $output['review']=new RatingResource($result_data['review']);
    }
    return $this->send_response($output, $result['msg'], $result['status_code']);

}
}