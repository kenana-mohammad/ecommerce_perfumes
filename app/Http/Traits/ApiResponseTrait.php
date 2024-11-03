<?php
namespace App\Http\Traits;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponseTrait
{
    public function send_response(mixed $data, string $message, int $status_code)
    {
        $success_state = $status_code == 200 ? true : false;

        $response = [
            'success'   => $success_state,
            'data'      => $data,
            'message'   => $message
        ];

        return response()->json($response, $status_code);
    }
    protected function paginate(Collection $collection, $per_page = 10)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();

        $results = $collection->slice(($page - 1) * $per_page, $per_page)->values();

        $data = new LengthAwarePaginator($results, $collection->count(), $per_page, $page, [
            'path'  =>  LengthAwarePaginator::resolveCurrentPath(),
        ]);

        // $paginated->appends(request()->all());

        $paginated['data']    =   $data ;

        $paginated['meta']    =   [
            'total_elements'    =>  $data->total(),
            'total_pages'       =>  $data->lastPage(),
            'current_page'      =>  $data->currentPage(),
            'first_page_url'    =>  $data->url(1),
            'next_page_url'     =>  $data->nextPageUrl() === null ? '' : $data->nextPageUrl(),
            'prev_page_url'     =>  $data->previousPageUrl() === null ? '' : $data->previousPageUrl(),
            'last_page_url'     =>  $data->url($data->lastPage()),
        ];

        return $paginated;
    }


}











?>