<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Web\ApiFrontEndController;
use App\Http\Controllers\Api\Auth\ApiAuthController;
use App\Http\Controllers\Api\Web\ApiCartController;
use App\Http\Controllers\Api\Web\ApiSettingsController;
use App\Http\Controllers\Api\Web\ApiProductController;
use App\Http\Controllers\Api\Web\ApiCategoryController;
use App\Http\Controllers\Api\Web\ApiMessageController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/* AUTH APIS*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [ApiAuthController::class, 'login']);
    Route::post('/register', [ApiAuthController::class, 'register']);
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::post('/refresh', [ApiAuthController::class, 'refresh']);
    Route::get('/user-profile', [ApiAuthController::class, 'userProfile']);

    /* CART */
    Route::post('/addToCart', [ApiCartController::class, 'addToCart']);
    Route::post('/singleAddToCart', [ApiCartController::class, 'singleAddToCart']);
    Route::post('/cart-update', [ApiCartController::class, 'cart_update']);
    Route::delete('/cart/{id}', [ApiCartController::class, 'destroy']);
});



/* HOME APIS */
Route::get('/categories', [ApiFrontEndController::class, 'home_categories']);
Route::get('/products', [ApiFrontEndController::class, 'home_products_list']);
Route::get('/products/hot', [ApiFrontEndController::class, 'hot_items_products']);
Route::get('/products/featured', [ApiFrontEndController::class, 'home_featured_products']);
Route::get('/posts', [ApiFrontEndController::class, 'home_posts']);
Route::get('/banners', [ApiFrontEndController::class, 'home_banners']);
Route::get('/categories/list', [ApiFrontEndController::class, 'categories_list']);
Route::get('/trendy-items/categories', [ApiFrontEndController::class, 'trendy_items_categories']);
Route::get('/latest-items/products', [ApiFrontEndController::class, 'latest_items_products']);
Route::get('/product/reviews/rating/{id}', [ApiFrontEndController::class, 'product_reviews_rating']);
Route::get('/product/reviews/count/{id}', [ApiFrontEndController::class, 'product_reviews_count']);
Route::get('/settings', [ApiFrontEndController::class, 'settings']);

//About us
Route::get('/about-us', [ApiFrontEndController::class, 'aboutUs']);

//Contact us
Route::post('/contact/message', [ApiMessageController::class, 'store']);

//Product Page
Route::get('/product-categories', [ApiProductController::class, 'product_categories']);
Route::get('/product-max-price', [ApiProductController::class, 'product_price']);
Route::get('/recent-product', [ApiProductController::class, 'recent_products']);
Route::get('/product-brands', [ApiProductController::class, 'product_brands']);
Route::get('/product-brands/{slug}', [ApiProductController::class, 'productBrand']);
Route::get('/product-grids', [ApiProductController::class, 'productGrids']);

//Category Page
Route::get('/product-cat/{slug}', [ApiCategoryController::class, 'productCat']);
Route::get('/product-sub-cat/{slug}/{sub_slug}', [ApiCategoryController::class, 'productSubCat']);
Route::get('/product-detail/{slug}', [ApiCategoryController::class, 'productDetail']);
Route::get('/product/search', [ApiCategoryController::class, 'productSearch']);
