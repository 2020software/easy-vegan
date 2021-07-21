<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Myカート</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table">
                        <thead>
                            <tr>
                                <th  colspan="6" class="heading-title">Myカート</th>
                            </tr>
                        </thead>
                        <tbody id="cartPage">
                            <!-- ここにアイテム表示 -->
                        </tbody>
                    </table>
                    <a href="{{ route('accounting') }}" type="button" class="btn btn-success btn-lg btn-block">会計をする</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function cart(){
            $.ajax({
                type: 'GET',
                url: '/user/get-cart-product',
                dataType:'json',
                success:function(response){
                    var rows = ""
                    $.each(response.carts, function(key,value){
                            rows += `<tr>
                                

                        <td class="col-md-2">
                            <div class="product-name">
                                <a href="#">${value.name}</a>
                            </div>

                        </td>

                        <td class="col-md-2">
                            <div class="price">
                                ${value.price}円
                            </div>
                        </td>

                        <td class="col-md-2">
                            ${value.qty}個
                        </td>

                        <td class="col-md-2">
                            合計<strong>${value.subtotal}</strong>円
                        </td>

                        <td class="col-md-1 close-btn">
                            <button type="submit" class="btn btn-danger" id="${value.rowId}" onclick="cartRemove(this.id)">削除</button>
                        </td>
                    </tr>`
                });
               
               $('#cartPage').html(rows);
            }
        })
    }
    cart();
    //  Cart remove Start 
    function cartRemove(id){
        $.ajax({
            type: 'GET',
            url: '/user/cart-remove/'+id,
            dataType:'json',
            success:function(data){
                cart();
                alert('削除しました');
            }
        });
    }
   </script>
</x-app-layout>