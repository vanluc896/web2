<div class="p-2 d-flex justify-content-center align-items-center gap-4"
    style="background-color: rgba(128, 128, 128, 0.37)">

    <div class="dropdown">
        <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
            Danh mục
        </button>

        <div class="dropdown-menu p-3" style="width:400px;">
            <div class="row">
                @foreach ($categories as $item)
                    <div class="col-6">
                        <a class="dropdown-item" href="{{ route('product.category', $item->slug) }}">
                            {{ $item->catename }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="dropdown">
        <button class="btn dropdown-toggle" data-bs-toggle="dropdown">
            Thương hiệu
        </button>

        <div class="dropdown-menu p-3" style="width:400px;">
            <div class="row">
                @foreach ($brands as $item)
                    <div class="col-6">
                        <a class="dropdown-item" href="{{ route('product.brand', $item->slug) }}">
                            {{ $item->brandname }}
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
