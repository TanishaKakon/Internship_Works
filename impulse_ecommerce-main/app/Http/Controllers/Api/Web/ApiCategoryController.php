<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;

use App\Http\Resources\ProductGridsResource;
use App\Http\Resources\ProductCatsResource;
use App\Http\Resources\ProductSearchResource;
use App\Http\Resources\ProductdetailResource;

class ApiCategoryController extends Controller
{
    //

    public function productCat(Request $request){
        $products=Category::getProductByCat($request->slug);
        // return $request->slug;

        if(request()->is('/product-grids')){
            return ProductGridsResource::collection($products);
        }
        else{
            return ProductCatsResource::collection($products->products);
        }

    }

    public function productSubCat(Request $request){
        $products=Category::getProductBySubCat($request->sub_slug);
        // return $products;

        if(request()->is('/product-grids')){
            return ProductGridsResource::collection($products);
        }
        else{
            return ProductCatsResource::collection($products->sub_products);
        }

    }

    public function productSearch(Request $request){
        $products=Product::orwhere('title','like','%'.$request->search.'%')
                    ->orwhere('slug','like','%'.$request->search.'%')
                    ->orwhere('description','like','%'.$request->search.'%')
                    ->orwhere('summary','like','%'.$request->search.'%')
                    ->orwhere('price','like','%'.$request->search.'%')
                    ->orderBy('id','DESC')
                    ->paginate('9');
        return ProductSearchResource::collection($products);
    }

    public function productDetail($slug){
        $product_detail= Product::getProductBySlug($slug);
        //dd($product_detail);
        return ProductdetailResource::make($product_detail);
    }
}
