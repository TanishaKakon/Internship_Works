<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Post;
use App\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductReviewsResource;
use App\Http\Resources\BannerResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\SettingsResource;
use App\Http\Resources\AboutUsResource;

class ApiFrontEndController extends Controller
{

    public function home_categories()
    {

        return CategoryResource::collection(Category::where('status', 'active')->where('is_parent', 1)->orderBy('title', 'ASC')->get());
    }
    public function home_products_list()
    {

        return ProductResource::collection(Product::where('status', 'active')->orderBy('id', 'DESC')->limit(8)->get());
    }

    public function home_featured_products()
    {


        return ProductResource::collection(Product::where('status', 'active')->where('is_featured', 1)->orderBy('price', 'DESC')->limit(2)->get());
    }

    public function home_banners()
    {
        return BannerResource::collection(Banner::where('status', 'active')->limit(3)->orderBy('id', 'DESC')->get());
    }

    public function home_posts()
    {

        return PostResource::collection(Post::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get());
    }

    public function categories_list()
    {

        return CategoryResource::collection(Category::where('status', 'active')->limit(3)->get());
    }

    public function trendy_items_categories()
    {

        return CategoryResource::collection(Category::where('status', 'active')->where('is_parent', 1)->get());
    }


    public function hot_items_products()
    {

        return ProductResource::collection(Product::where('condition', 'hot')->orderBy('id', 'DESC')->limit(8)->get());
    }

    public function latest_items_products()
    {

        return ProductResource::collection(Product::where('status', 'active')->orderBy('id', 'DESC')->limit(6)->get());
    }

    public function product_reviews_rating($id)

    {
        $product = Product::find($id);

        return ProductReviewsResource::collection($product->getReview)->avg('rate');
    }


    public function product_reviews_count($id)
    {
        $product = Product::find($id);
        return ProductReviewsResource::collection($product->getReview)->count();
    }

    public function settings()
    {

        return SettingsResource::collection(Settings::all());
    }

    //aboutUs & contactUs Page
    public function aboutUs()
    {
        $about = Settings::get();
        return AboutUsResource::collection($about);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
