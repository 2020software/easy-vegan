<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                こんにちは {{ Auth::user()->name }} さん 何を買いますか
            </h2>
            <div class="flex justify-end">
                <a href="{{ route('my-cart') }}" type="button" class="btn btn-outline-info">カートを見る</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row">
                        @foreach($products as $product)
                            <div class="card" style="width: 18rem;">
                                <img src="{{ asset($product->thambnail) }}" class="card-img-top">
                                <div class="card-body">
                                <a href="{{ url('products/details/'.$product->id.'/'.$product->product_slug) }}" class="card-title">{{ $product->product_name }}</a>
                                <div class="price-box">
                                    @if ($product->discount_price == NULL)
                                        <span class="price">{{ $product->selling_price }}</span>
                                    @else
                                        <span class="price">{{ $product->discount_price }}</span>
                                        <strike class="price-strike">{{ $product->selling_price }}</strike>
                                    @endif
                                </div>
                                
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</x-app-layout>