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
        return view('admin.add-product');   // 製品追加ページへ
    }

    // 商品追加
    public function StoreProduct(Request $request)
    {
        $image = $request->file('thambnail');   // データを配列に格納
        $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // uniqidを10進数に 画像拡張子を取得
        Image::make($image)->resize(500, 500)->save('upload/products/thambnail/'.$name_gen);    // Intervention Image の make API で 新しい画像リソースを作成
        $save_url = 'upload/products/thambnail/'.$name_gen;

        // DBのカラムにname属性を指定してデータ保存
        $product_id = Product::insertGetId([    // GetId で MultiImg の product_id とつなげる
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

    // 商品管理
    public function ManageProduct()
    {
        $products = Product::latest()->get();
        return view('admin.manage-product', compact('products'));
    }

    // 商品一覧
    public function DisplayProduct()
    {
        $products = Product::latest()->get();
        return view('products.products', compact('products'));
    }

    // 商品編集
    public function EditProduct($id)
    {
        $products = Product::findOrFail($id); // 指定された商品を取り出す

        $multiImgs = MultiImg::where('product_id', $id)->get(); // 存在している'product_id' === 指定された商品の$id の複数画像編集

        return view('admin.edit-product', compact('products', 'multiImgs'));
    }

    // 商品を更新 updateで重複していても、完全に更新
    public function UpdateProduct(Request $request)
    {
        $product_id = $request->id; // name="id" 

        Product::findOrFail($product_id)->update([  // Eloquent メソッドの update で差分を見ないで更新
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
            unlink($imgDel->photo_name);    // photo_name は $uploadPath = 'upload/products/multi-image/'.$make_name;
            $make_name = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(500, 500)->save('upload/products/multi-image/'.$make_name); // フォルダ名
            $uploadPath = 'upload/products/multi-image/'.$make_name;

            MultiImg::where('id', $id)->update([    // 同じproduct_id 内の MultiImgの id カラムを取得
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
        $product = Product::findOrFail($id);    // route('delete-product', $product->id)
        unlink($product->thambnail);    //　フォルダから削除
        Product::findOrFail($id)->delete(); // DBから削除

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
        $oldimg = MultiImg::findOrFail($id);    // route('delete-images', $multiImg->id)
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
        return view('products.details', compact('product', 'multiImages')); // カート追加に使うために商品と画像を渡す
    }
}
