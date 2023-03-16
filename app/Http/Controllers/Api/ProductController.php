<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');
        $price = $request->input('price');

        if ($id) {
           $product = Product::with('category','galleries')->find($id);

           if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'data produk berhasil diambil'
                );
           } else {
            return ResponseFormatter::error(
                null,
                'data produk tidak ada',
                404
            );
           }
        }

        $product = Product::with(['category', 'galleries']);

        if ($name) {
           $product->where('name', 'like', '%' . $name . '%');
        }
        if ($description) {
            $product->where('description', 'like', '%' . $description . '%');
        }
         if ($tags) {
            $product->where('tags', 'like', '%' . $tags . '%');
        }

         if ($price) {
            $product->where('price', 'like', '%' . $price . '%');
         }

         if ($categories) {
            $product->where('categories', 'like', '%' . $categories . '%');
         }

         return ResponseFormatter::success(
            $product->paginate($limit),
            'data produk berhasil diambil'
        );
    }
}
