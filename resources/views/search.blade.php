<link rel="stylesheet" href="{{ asset('css/search.css') }}">
<div class="search-box">
    <script>
        function validateSearchInput() {
            var input = document.getElementsByName("query")[0];
            input.value = input.value.replace(/[^a-zA-Z0-9\s]/g, '');
        }
    </script>
    <div class="icon-search">
        <form method="GET" action="{{ route('products.index') }}">
            <div class="search-form">
                <input type="text" name="query" placeholder="Search..." oninput="validateSearchInput()">
                <div class="search-btn">
                    <button type="submit"><img src="../images/Combined Shape.png"></button>
                </div>
            </div>
        </form>
    </div>

</div>




