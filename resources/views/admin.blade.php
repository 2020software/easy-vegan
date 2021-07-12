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
                    <div class="btn-group-vertical">
                        <div class="list-group">
                            <a href="{{ route('add-product') }}" class="list-group-item list-group-item-action">商品を追加する</a>
                            <a href="{{ route('manage-product') }}" class="list-group-item list-group-item-action">商品を管理する</a>
                            <a href="#" class="list-group-item list-group-item-action">A fourth link item</a>
                            <a href="#" class="list-group-item list-group-item-action disabled" tabindex="-1" aria-disabled="true">A disabled link item</a>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>