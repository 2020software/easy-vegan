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
                    

                    <form action="{{ route('verification') }}" method="POST">
                        
                    @csrf
                    <strong>合計: </strong> {{ $cartTotal }} <hr>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <input name="email" class="form-control" value="{{ $data['shipping_email'] }}">
                                    <input name="name" class="form-control" value="{{ $data['shipping_name']}}">
                                    <input name="shipping_address" class="form-control" value="{{ $data['shipping_address'] }}">
                                    <input name="phone" class="form-control" value="{{ $data['shipping_phone'] }}">
                                </div>
                                
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info">確認する</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>