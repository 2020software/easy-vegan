<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">お会計</h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    

                    <form action="{{ route('checkout') }}" method="POST">
                        
                    @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-xl-9">
                                    <input name="shipping_email" class="form-control" type="email" placeholder="メール">
                                    <input name="shipping_name" class="form-control" type="text" placeholder="名前">
                                    <input name="shipping_address" class="form-control" type="text" placeholder="住所">
                                    <input name="shipping_phone" class="form-control" type="number" placeholder="電話番号">
            
                                </div>
                                <div class="col-xl-3">
                                    <div class="card" style="width: 18rem;">
                                        @foreach ($carts as $item)
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $item->name }}</h5>
                                                
                                                <p class="card-text">数量({{ $item->qty }})個</p>
                                                <p class="card-text">合計金額 : {{ $cartTotal }}円</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-info">確認する</button>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>