<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\RecentProductResource;
use App\Http\Resources\ProductGridsResource;
use App\Http\Resources\ProductBrandResource;

class ApiProductController extends Controller
{
    //

    //product Page
    public function product_categories()
    {
        return CategoryResource::collection(Category::with('child_cat')->where('is_parent', 1)->where('status', 'active')->orderBy('title', 'ASC')->get());
    }

    public function product_price()
    {
        return response()->json(Product::get()->max('price'), 200);
    }

    public function product_brands()
    {

        return BrandResource::collection(Brand::orderBy('title', 'ASC')->where('status', 'active')->get());
    }

    public function productBrand(Request $request)
    {
        $products = Brand::getProductByBrand($request->slug);
        if (request()->is('/product-grids')) {
            return ProductGridsResource::collection($products);
        } else {
            return ProductBrandResource::make($products);
        }
    }

    public function recent_products()
    {

        return RecentProductResource::collection(Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get());
    }

    public function productGrids()
    {
        $products = Product::query();

        if (!empty($_GET['category'])) {
            $slug = explode(',', $_GET['category']);
            // dd($slug);
            $cat_ids = Category::select('id')->whereIn('slug', $slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id', $cat_ids);
            // return $products;
        }
        if (!empty($_GET['brand'])) {
            $slugs = explode(',', $_GET['brand']);
            $brand_ids = Brand::select('id')->whereIn('slug', $slugs)->pluck('id')->toArray();
            return $brand_ids;
            $products->whereIn('brand_id', $brand_ids);
        }
        if (!empty($_GET['sortBy'])) {
            if ($_GET['sortBy'] == 'title') {
                $products = $products->where('status', 'active')->orderBy('title', 'ASC');
            }
            if ($_GET['sortBy'] == 'price') {
                $products = $products->orderBy('price', 'ASC');
            }
        }

        if (!empty($_GET['price'])) {
            $price = explode('-', $_GET['price']);
            // return $price;
            // if(isset($price[0]) && is_numeric($price[0])) $price[0]=floor(Helper::base_amount($price[0]));
            // if(isset($price[1]) && is_numeric($price[1])) $price[1]=ceil(Helper::base_amount($price[1]));

            $products->whereBetween('price', $price);
        }

        // Sort by number
        if (!empty($_GET['show'])) {
            $products = $products->where('status', 'active')->paginate($_GET['show']);
        } else {
            $products = $products->where('status', 'active')->paginate(9);
        }
        // Sort by name , price, category

        return ProductGridsResource::collection($products);
    }
}
