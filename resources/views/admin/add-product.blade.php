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
                    商品を追加する
                </div>
                <form method="post" action="{{ route('store-product') }}" enctype="multipart/form-data" >
                @csrf
                    <div class="form-row m-3">
                        <div class="col-12 mb-3">
                            <p class="text-pink-400">商品の名前</p>
                            <input name="product_name" class="block form-control form-control-lg" type="text" required>
                        </div>
                        <div class="col-3">
                            <p class="text-pink-400">商品の数量</p>
                            <input name="product_qty" class="block form-control form-control-lg" type="text" >
                        </div>
                        <div class="col-3">
                            <p class="text-pink-400">商品の値段</p>
                            <input required="" name="selling_price" class="block form-control form-control-lg" type="text" >
                        </div>
                        <div class="col-3">
                            <p class="text-pink-400">商品の割引価格</p>
                            <input name="discout_price" class="block form-control form-control-lg" type="text">
                        </div>
                        <div class="col-12">
                            <label for="comment">商品の説明</label>
                            <textarea name="description" class="form-control" ></textarea>
                        </div>
                        <div class="form-group m-3">
                            <label class="text-pink-400" for="exampleFormControlFile1">サムネイル</label>
                            <input required type="file" name="thambnail" class="form-control-file" onchange="mainThamUrl(this)">
                            <img src="" id="mainThmb" alt="">
                        </div>
                        <div class="form-group m-3">
                            <label class="text-pink-400" for="exampleFormControlFile1">複数イメージ</label>
                            <input required id="multiImg" type="file" multiple="" name="multi_img[]" class="form-control-file">
                            <div class="row" id="preview_img"></div>
                        </div>
                        
                    </div>
                    <div class="text-lg-right">
                        <input type="submit" class="btn btn-rounded btn-primary mr-5 mb-5" value="追加する">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function mainThamUrl(input){
            if (input.files && input.files[0]) {
                var reader = new FileReader();  // FileReaderオブジェクトを使用して、ファイルを読み取り
                reader.onload = function(e){    // onloadは、ページや画像などのリソース類を読み込んでから処理を実行したいときに利用
                    $('#mainThmb').attr('src', e.target.result).width(100).height(100); // attr = 指定した属性の値を取得
                };
                reader.readAsDataURL(input.files[0]);   // ファイルオブジェクトをData URIに変換するメソッド
                // Data URIは外部データを直接ウェブページに埋め込む手法
            }
        }	
    </script>

<script type="text/javascript">
 
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