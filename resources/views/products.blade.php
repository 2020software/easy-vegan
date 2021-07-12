<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            こんにちは {{ Auth::user()->name }} さん 何を買いますか
        </h2>
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
                                <h5 class="card-title">{{ $product->product_name }}</h5>
                                <div class="price-box">
                                    @if ($product->discount_price == NULL)
                                        <span class="price">{{ $product->selling_price }}</span>
                                    @else
                                        <span class="price">{{ $product->discount_price }}</span>
                                        <strike class="price-strike">{{ $product->selling_price }}</strike>
                                    @endif
                                </div>
                                <a href="{{ route('details', $product->id) }}" class="btn btn-primary">商品を見る</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>