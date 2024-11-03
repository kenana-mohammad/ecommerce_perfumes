<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\Blog\Create_BlogController;
use App\Http\Controllers\Dashboard\Category\CreateCategoryController;
use App\Http\Controllers\Dashboard\Coupon\CreateCouponContoller;
use App\Http\Controllers\Dashboard\Order\OrderController;
use App\Http\Controllers\Dashboard\Products\CreateProductController;
use App\Http\Controllers\Website\Comment\CommentController;
use App\Http\Controllers\Website\Front_Controller;
use App\Http\Controllers\Website\Order\Order_controller;
use App\Http\Controllers\Website\Rating\ReviewController;
use App\Http\Requests\Dashboard\Order\ChangeStatusOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Auth
Route::group(['prefix' => 'auth'],function(){
    Route::controller(AuthController::class)->group(function(){
    //register
    Route::post('register-user','register_user')->name('auth.register_user');
    Route::post('login-user','login_user')->name('auth.login_user');
   // logout
   Route::group(['middleware' => ['auth:dash']], function () {

Route::post('logout-user','logout_user')->name('auth.logout_user');
    });
});
});

Route::group(['prefix' => 'dash'],function(){
    Route::group(['middleware' => ['auth:api','CheckAdmin']], function () {

Route::controller(CreateCategoryController::class)->group(function(){
    //get all

    Route::get('category/get-categories','get_categories')->name('dash.get_categories');

    //Add category
    Route::post('category/add-category','create_category')->name('dash.add_category');
    //update
    Route::PUT('category/update-category/{category}','update_category')->name('dash.update_category');
   //show
   Route::get('category/get-category/{category}','get_category')->name('dash.get_category');
   //delete
   Route::delete('category/delete-category/{category}','delete_category')->name('dash.delete_category');
   Route::Post('product/add-product','create_product')->name('dash.create_product');

});
//-----------------------------------//


Route::controller(CreateProductController::class)->group(function(){
    //get all

    Route::get('product/get-products','get_products')->name('dash.get_products');

    //Add product
    Route::post('product/add-product','create_product')->name('dash.add_product');
    //update
    Route::PUT('product/update-product/{product}','update_product')->name('dash.update_product');
   //show
   Route::get('product/get-product/{product}','get_product')->name('dash.get_product');
   //delete
   Route::delete('product/delete-product/{product}','delete_product')->name('dash.delete_category');

});


Route::controller(CreateCouponContoller::class)->group(function(){
    //get all


    //Add product
    Route::post('coupon/add-coupon','create_coupon')->name('dash.create_coupon');

    });
    //-----------------
   // order////
   Route::controller(OrderController::class)->group(function(){
    Route::PUT('order/update-status/{order}','change_status_order')->name('dash.change_status_order');
       });
       //blog
       Route::controller(Create_BlogController::class)->group(function(){
        Route::Post('blog/add-blog','create_blog')->name('dash.create_blog');
        Route::Put('blog/update-blog/{blog}','update_blog')->name('dash.update_blog');
        Route::Delete('blog/delete-blog/{blog}','Delete_Blog')->name('dash.Delete_blog');

    });

});
});
//-----website front---------

Route::group(['prefix' => 'website'],function(){
    Route::controller(Front_Controller::class)->group(function(){
        Route::get('category/get-categories','get_categories')->name('web.get_categories');
        //all_alternatives
        Route::get('product/all-alternatives','all_alternatives')->name('web.all_alternatives');
       //get_products_by_category
       Route::get('product/get-products-by-category/{category}','get_products_by_category')->name('web.get_products_by_category');

    });
    //show blogs
    Route::controller(Create_BlogController::class)->group(function(){
        Route::get('blog/get-blogs','get_blogs')->name('web.get_blogs');
        //all_alternatives
        Route::get('blog/get-blog/{blog}','get_blog')->name('web.get_blog');
      
    });
    //order
    Route::group(['middleware' => ['auth:api']], function () {

    Route::controller(Order_controller::class)->group(function(){
        Route::get('order/get-orders','my_orders')->name('app.my_orders');

        Route::post('order/applay-order','applay_order')->name('app.applay_order');

    });
    //review 
    Route::controller(ReviewController::class)->group(function(){
        Route::post('review/add-rating','add_review')->name('app.add_review');

    });
    //comment
    Route::controller(CommentController::class)->group(function(){
        Route::post('comment/add-comment/{product}','add_comment')->name('app.add_comment');

    });
});
Route::controller(ReviewController::class)->group(function(){

//get reviews 
Route::get('review/get-reviewes','get_reviewes')->name('app.get_reviewes');


});
//get comments
Route::controller(CommentController::class)->group(function(){
    Route::get('comment/get-comments/{product}','get_comments')->name('app.get_comments');

});

});
