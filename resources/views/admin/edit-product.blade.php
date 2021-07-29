<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            何を出品しますか
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-green-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    商品を更新する
                </div>
                <form method="post" action="{{ route('update-product') }}" >
                @csrf
                    <input type="hidden" name="id" value="{{ $products->id }}">
                    <div class="form-row m-3">
                        <div class="col-12 mb-3">
                            <p class="text-pink-400">商品の名前</p>
                            <input value="{{ $products->product_name }}" name="product_name" class="block form-control form-control-lg" type="text" required>
                        </div>
                        <div class="col-3">
                            <p class="text-pink-400">商品の数量</p>
                            <input value="{{ $products->product_qty }}" name="product_qty" class="block form-control form-control-lg" type="text" >
                        </div>
                        <div class="col-3">
                            <p class="text-pink-400">商品の値段</p>
                            <input value="{{ $products->selling_price }}" name="selling_price" class="block form-control form-control-lg" type="text" >
                        </div>
                        <div class="col-3">
                            <p class="text-pink-400">商品の割引価格</p>
                            <input value="{{ $products->discount_price }}" name="discout_price" class="block form-control form-control-lg" type="text">
                        </div>
                        <div class="col-12">
                            <label for="comment">商品の説明</label>
                            <textarea name="description" class="form-control">{!! $products->description !!}</textarea>
                        </div>
                        
                    </div>
                    <div class="text-lg-right">
                        <input type="submit" class="btn btn-rounded btn-primary mr-5 mb-5" value="更新する">
                    </div>
                </form>
            </div>
        </div>

        <!-- サムネイルアップデート -->
        <div class="py-5 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('update-thambnail') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $products->id }}">
                        <input type="hidden" name="old_img" value="{{ $products->thambnail }}">
                        <div class="row row-sm">
                            <div class="col-md-3">

                                <div class="card">
                                    <img src="{{ asset( $products->thambnail ) }}" class="card-img-top" style="height: 130px; width: 280px;">
                                    <div class="card-body">
                                      <p class="card-text">
                                          <div class="form-group">
                                            画像を変更する
                                            <input type="file" name="thambnail" class="form-control-file" onchange="mainThamUrl(this)">
                                            <img src="" id="mainThmb">
                                          </div>
                                      </p>
                                    </div>
                                  </div>

                            </div>
                        </div>

                        <div class="text-lg-right">
                            <input type="submit" class="btn btn-rounded btn-primary mr-5 mb-5" value="更新する">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- マルチイメージアップデート -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('update-images') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row row-sm">
                            @foreach ($multiImgs as $multiImg)
                            <div class="col-3">

                                <div class="card">
                                    <img src="{{ asset($multiImg->photo_name) }}" class="card-img-top" style="height: 130px; width: 280px;">
                                    <div class="card-body">
                                      <a href="{{ route('delete-images',$multiImg->id) }}" class="btn btn-sm btn-danger" id="delete" >削除</a>
                                      <p class="card-text">
                                          <div class="form-group">
                                              画像を変更する
                                              <input class="form-control" type="file" name="multi_img[ {{ $multiImg->id }} ]">
                                          </div>
                                      </p>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>

                        <div class="text-lg-right">
                            <input type="submit" class="btn btn-rounded btn-primary mr-5 mb-5" value="更新する">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function mainThamUrl(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#mainThmb').attr('src', e.target.result).width(100).height(100);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }	
    </script>

<script>
 
    $(document).ready(function(){
     $('#multiImg').on('change', function(){ //on file input change
        if (window.File && window.FileReader && window.FileList && window.Blob) //check File API supported browser
        {
            var data = $(this)[0].files; //this file data
             
            $.each(data, function(index, file){ //loop though each file
                if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){ //check supported file type
                    var fRead = new FileReader(); //new filereader
                    fRead.onload = (function(file){ //trigger function on successful read
                    return function(e) {
                        var img = $('<img/>').addClass('thumb').attr('src', e.target.result) .width(100)
                    .height(100); //create image element 
                        $('#preview_img').append(img); //append image to output element
                    };
                    })(file);
                    fRead.readAsDataURL(file); //URL representing the file's data.
                }
            });
             
        }else{
            alert("Your browser doesn't support File API!"); //if File API is absent
        }
     });
    });
     
    </script>
  
</x-app-layout>