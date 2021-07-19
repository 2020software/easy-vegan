<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            こんにちは {{ Auth::user()->name }} さん
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                            <a href="{{ route('add-product') }}" class="btn btn-info btn-lg btn-block">商品を追加する</a>
                            <a href="{{ route('manage-product') }}" class="btn btn-info btn-lg btn-block">商品を管理する</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>