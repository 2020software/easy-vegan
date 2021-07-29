<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <h5 class="title" id="product_name"><strong>{{ $product->product_name }}</strong></h5>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex flex-row">
                        @foreach ($multiImages as $image)
                        <div class="product-image" id="slide{{ $image->id }}">
                            <img style="width: 300px; height: 300px;" class="img-responsive" src="{{ asset($image->photo_name ) }} "/>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex flex-row-reverse mt-3 ">
                                <div class="flex">
                                    <div class="flex mx-8 price-box">
                                        @if ($product->discount_price == NULL)
                                            <h6>価格:</h6><span class="text-danger price">￥<strong>{{ $product->selling_price }}</strong></span>
                                        @else
                                            <h6>価格:</h6><span class="text-danger mx-2 price">￥<strong>{{ $product->discount_price }}</strong></span>
                                            <strike class="price-strike">￥{{ $product->selling_price }}</strike>
                                        @endif
                                    </div>

                                    <div class="quantity">{{ $product->product_qty }}個</div>
                                    <input type="number" class="form-control" id="quantity" value="1" min="1">
                                </div>
                        <input type="hidden" id="product_id" value="{{ $product->id }}" min="1">
                        <button type="submit" class="btn btn-primary ml-3"  onclick="addCart()" >カートに追加</button>
                    </div>
                </div>
            </div>
            <div class="card" style="margin-top: 50px">
                <div class="card-body">
                  <h5 class="card-title">{{ $product->product_name }}の説明</h5>
                  <p class="card-text">{{$product->description}}</p>
                </div>
              </div>
        </div>
    </div>

    <script type="text/javascript">

    // カート追加
    $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        })
        
        // ajax 非同期のHTTP通信を行う
        function addCart() {
            var product_name = $('#product_name').text();
            var id = $('#product_id').val();    // HTMLの value取得 value="{{ $product->id }}"
            var quantity = $('#quantity').val();    // value="1" 取得
            $.ajax({
                type: "POST",   // 使用するHTTPメソッド
                dataType: "json",
                data: {
                    quantity: quantity, product_name: product_name  // 送信するデータ
                },
                url: "/cart/" + id, // 通信先のURL
                success: function(data) {
                    alert('カートに追加しました')
                },
                error: function () {
                    alert('カートに追加できませんでした。');
                }
            })
        }

        



        
    </script>

</x-app-layout>