<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MultiImg;
use Carbon\Carbon;
use Image;

class ProductController extends Controller
{
    public function AddProduct()
    {
        return view('admin.add-product');
    }

    public function StoreProduct(Request $request)
    {
        $image = $request->file('thambnail');
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::make($image)->resize(500, 500)->save('upload/products/thambnail/'.$name_gen);
        $save_url = 'upload/products/thambnail/'.$name_gen;

        $product_id = Product::insertGetId([
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discout_price,
            'description' => $request->description,
            'thambnail' => $save_url,
            'created_at' => Carbon::now()
        ]);

        // 複数画像のアップロード
        $images = $request->file('multi_img');
        foreach ($images as $img) 
        {
            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            Image::make($img)->resize(500, 500)->save('upload/products/multi-image/'.$make_name);
    	    $uploadPath = 'upload/products/multi-image/'.$make_name;

            MultiImg::insert([
                'product_id' => $product_id,
                'photo_name' => $uploadPath,
                'created_at' => Carbon::now()
            ]);
        }

        $notification = array(
			'message' => '商品を追加しました',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
    }

    public function ManageProduct()
    {
        $products = Product::latest()->get();
        return view('admin.manage-product', compact('products'));
    }

    public function DisplayProduct()
    {
        $products = Product::latest()->get();
        return view('products.products', compact('products'));
    }

    public function EditProduct($id)
    {
        $products = Product::findOrFail($id);

        $multiImgs = MultiImg::where('product_id', $id)->get();

        return view('admin.edit-product', compact('products', 'multiImgs'));
    }

    public function UpdateProduct(Request $request)
    {
        $product_id = $request->id;

        Product::findOrFail($product_id)->update([
            'product_name' => $request->product_name,
            'product_slug' => strtolower(str_replace(' ', '-', $request->product_name)),
            'product_code' => $request->product_code,
            'product_qty' => $request->product_qty,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discout_price,
            'description' => $request->description,
            'created_at' => Carbon::now()
        ]);
        
        $notification = array(
			'message' => '商品を更新しました',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);

    }

    public function UpdateThambnail(Request $request){
        $pro_id = $request->id;
        $oldImage = $request->old_img;
        unlink($oldImage);
   
            $image = $request->file('thambnail');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(500,500)->save('upload/products/thambnail/'.$name_gen);
            $save_url = 'upload/products/thambnail/'.$name_gen;
   
           Product::findOrFail($pro_id)->update([
               'thambnail' => $save_url,
               'updated_at' => Carbon::now()
   
           ]);
   
            $notification = array(
               'message' => 'サムネイルが更新されました。',
               'alert-type' => 'info'
           );
   
           return redirect()->back()->with($notification);
   
    }

    public function UpdateImages(Request $request)
    {
        $images = $request->multi_img;

        foreach ($images as $id => $image) {
            $imgDel = MultiImg::findOrFail($id);
            unlink($imgDel->photo_name);
            $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(500, 500)->save('upload/products/multi-image/'.$make_name); // フォルダ名
            $uploadPath = 'upload/products/multi-image/'.$make_name;

            MultiImg::where('id', $id)->update([
                'photo_name' => $uploadPath,
                'updated_at' => Carbon::now()
            ]);
        }

        $notification = array(
			'message' => '画像を更新しました',
			'alert-type' => 'info'
		);

		return redirect()->back()->with($notification);
    }

    public function DeleteProduct($id)
    {
        $product = Product::findOrFail($id);
        unlink($product->thambnail);
        Product::findOrFail($id)->delete();

        $images = MultiImg::where('product_id', $id)->get();
        foreach ($images as $img) {
            unlink($img->photo_name);
            MultiImg::where('product_id', $id)->delete();
        }

        $notification = array(
			'message' => '商品を削除しました',
			'alert-type' => 'success'
		);

		return redirect()->back()->with($notification);
    }

    public function DeleteImages($id)
    {
        $oldimg = MultiImg::findOrFail($id);
        unlink($oldimg->photo_name);
        MultiImg::findOrFail($id)->delete();

        $notification = array(
			'message' => '画像を削除しました',
			'alert-type' => 'info'
		);
		return redirect()->back()->with($notification);
    }

    // 買い物セクション

    public function DetailsProduct($id, $slug)
    {
        $product = Product::findOrFail($id);
        $multiImages = MultiImg::where('product_id', $id)->get();
        return view('products.details', compact('product', 'multiImages'));
    }
}
