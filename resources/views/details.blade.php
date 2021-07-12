<div class="price-box">
    @if ($product->discount_price == NULL)
        <span class="price">{{ $product->selling_price }}</span>
    @else
        <span class="price">{{ $product->discount_price }}</span>
        <strike class="price-strike">{{ $product->selling_price }}</strike>
    @endif
</div>

<div class="container">
    <div class="row">
        <div class="col-4">
            @foreach ($multiImages as $image)
            <div class="single-product-gallery-item" id="slide{{ $image->id }}">
                <img style="width: 300px; height: 300px;" class="img-responsive" src="{{ asset($image->photo_name ) }} "/>
            </div>
            @endforeach
        </div>
        <div class="col-6"></div>
    </div>
</div>