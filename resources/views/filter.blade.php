<head>
    <link rel="stylesheet" href="{{ asset('css/filter.css') }}">
</head>
<div class="filter">
    <div class="filter-category">
        <div class="category-big">
            <div class="filter-click-category">{{ config('my_config.category') }}</div>
            <img class="image-click" src="{{ asset('images/Rectangle 195.jpg') }}" >
        </div>
        <div class="small-category">
            <ul class="subcategory">
                <li><a href="{{ route('products.index') }}">{{ config('my_config.all') }}</a></li>
                @foreach($categories as $category)
                <li><a href="{{ route('products.index', ['category_id' => $category->id])}}">{{ $category->name }}</a></li>
                @endforeach

            </ul>
        </div>
    </div>
    <div class="filter-manufacturer">
        <div class="manufacturer-big">
            <div class="filter-click-manufacturer">{{ config('my_config.manufacturer') }}</div>
            <img class="image-click-manufacturer" src="{{ asset('images/Rectangle 195.jpg') }}" >
        </div>
        <div class="small-manufacturer">
            <ul class="submanufacturer">
                <li><a href="{{ route('products.index') }}">{{ config('my_config.all') }}</a></li>
                @foreach( $manufacturers as $manufacturer)

                <li><a href="{{ route('products.index', ['manufacturer_id' => $manufacturer->id]) }}" class="sub">{{ $manufacturer->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script src="{{ asset('./js/filter.js') }}"></script>

