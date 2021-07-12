<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            商品を管理します。
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="mt-6 col-12">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>画像</th>
                                <th>商品名</th>
                                <th>数量</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td> <img src="{{ asset($product->thambnail) }}" style="width: 50px; height: 50px;"> </td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_qty }}</td>
                                <td>
                                    <a href="{{ route('edit-product', $product->id) }}" class="btn btn-success">編集</a>
                                    <a href="{{ route('delete-product', $product->id) }}" class="btn btn-danger">削除</a>
                                </td>
                       
                            </tr>
                             @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>