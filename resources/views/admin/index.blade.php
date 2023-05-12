<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/admin/success.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/addproduct.css') }}">

</head>
<body class="body-home">

    @include('header')
    <div class="home">
        @include('filter')
        <div class="content">
            <div class="above-content">
                <div class="add-product">
                    <a class="btn btn-success" style="color: #00CCFF;"
                       href="{{ route('products.create') }}">{{ config('my_config.addProducts') }}</a>
                </div>
                <div id="product-form" style="display: none;">
                    <div class="add-product-form">
                        <div class="card-header separator">
                            <p class="card-title">{{ config('my_config.addProducts') }}</p>
                            <div class="img-vector" onclick="closeForm()">
                                <img src="{{ asset('images/Vector.png') }}" alt="" class="img-vector"><br>
                            </div>
                        </div>
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                              id="add-product-form">
                            @csrf
                            <div class="row input-form">
                                <div class="form-group">
                                    <label for="inputName">{{ config('my_config.productName') }}<span
                                            class="required">*</span></label><br>
                                    <input type="text" name="name" id="inputName" class="form-control input-form-group"
                                           placeholder={{ config('my_config.input') }}>
                                </div>
                                <div class="form-group">
                                    <label for="inputCategory">{{ config('my_config.category') }}<span
                                            class="required">*</span></label><br>
                                    <select id="inputCategory" name="category_id"
                                            class="form-control custom-select input-form-group">
                                        <option selected=""
                                                disabled="">{{ config('my_config.selectCategory') }}</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputManufacturer">{{ config('my_config.manufacturer') }}<span
                                            class="required">*</span></label><br>
                                    <select id="inputManufacturer" name="manufacturer_id"
                                            class="form-control custom-select input-form-group">
                                        <option selected=""
                                                disabled="">{{ config('my_config.selectManufacturer') }}</option>
                                        @foreach($manufacturers as $manufacturer)
                                            <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="inputPrice">{{ config('my_config.price') }}<span
                                            class="required">*</span></label><br>
                                    <input type="text" name="price" id="inputPrice"
                                           class="form-control input-form-group"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="inputMessage">{{ config('my_config.outline') }}</label><br>
                                    <textarea id="inputMessage" name="description" class="form-control input-form-group"
                                              rows="4"></textarea>
                                </div>

                                <div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image_path"
                                               onchange="displayFileName()">
                                        <label class="custom-file-label" for="image">{{ config('my_config.addImage') }}
                                            <span
                                                class="required">*</span></label>
                                    </div>
                                </div>
                                <div class="button">
                                    <div class="form-group" onclick="closeForm()">
                                        <input class="btn-cancel" value={{ config('my_config.outline') }}>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit"
                                                class="btn-submit">{{ config('my_config.outline') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @include('search')
            </div>
            <div class="homepage-content">
                <div class="homepage-content-item">
                    @if($pagination->isEmpty())
                        <p>{{ config('my_config.noProduct') }}</p>
                    @else
                        @foreach($pagination as $item)
                            <div class="detail-product">
                                <img src="{{ asset('images/'. $item->image_path) }}" alt="" class="img-product"><br>
                                <div class="name-price">
                                    <a href="{{ route('products.show',$item->id) }}">{{ $item->name }}</a><br>
                                </div>

                                <div class="button-edit-product">
                                    <form action="{{ route('products.destroy', $item->id) }}" method="Post">
                                        <div style="display: inline-block;">
                                            <a id="btn-update-product" class="btn-update"
                                               href="{{ route('products.edit', $item->id) }}">{{ config('my_config.update') }}</a>
                                        </div>
                                        <div style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button id="delete-product-btn" type="submit"
                                                    class="btn-delete delete-product"
                                                    data-name="{{ $item->name }}">{{ config('my_config.delete') }}</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="pagination_manager">
                    {{ $pagination->links('custom-pagination', ['pagination' => $pagination]) }}
                </div>
            </div>

        </div>

    </div>

    @if(session()->has('success'))
        <div class="popup-success" id="popup-success">

            <div class="success-product-form">
                <div class="card-header separator">
                    <div class="success-img-vector" onclick="closeFormSuccess()">
                        <img src="{{ asset('images/Vector.png') }}" alt="" class="img-close"><br>
                    </div>
                </div>
                <div class="git-success">
                    <img src="{{ asset('images/success.png') }}" alt="" class="img-success"><br>
                    <p>More success!</p>
                </div>
            </div>
        </div>
    @endif
    @if(session()->has('successDelete'))
        <div class="popup-success" id="popup-success">

            <div class="success-product-form">
                <div class="card-header separator">
                    <div class="success-img-vector" onclick="closeFormSuccess()">
                        <img src="{{ asset('images/Vector.png') }}" alt="" class="img-close"><br>
                    </div>
                </div>
                <div class="git-success">
                    <img src="{{ asset('images/success.png') }}" alt="" class="img-success"><br>
                    <p>Delete successfully!</p>
                </div>
            </div>
        </div>
    @endif
    <script>
        function closeFormSuccess() {
            var popup = document.getElementById("popup-success");
            popup.style.display = "none";
        }
    </script>
    @if(session()->has('successUpdate'))
        <div class="popup-success" id="popup-success">

            <div class="success-product-form">
                <div class="card-header separator">
                    <div class="success-img-vector" onclick="closeFormSuccess()">
                        <img src="{{ asset('images/Vector.png') }}" alt="" class="img-close"><br>
                    </div>
                </div>
                <div class="git-success">
                    <img src="{{ asset('images/success.png') }}" alt="" class="img-success"><br>
                    <p>Update successfully!</p>
                </div>
            </div>
        </div>

        <script>
            // Set a timer for 3 seconds
            setTimeout(function () {
                // Redirect to show page with product_id from session
                window.location.href = "{{ route('products.show', session('product_id')) }}";
            }, 2000); // 3 seconds
        </script>

    @endif

    <script>
        const deleteButtons = document.querySelectorAll('.delete-product');
        deleteButtons.forEach(button => {
            button.addEventListener('click', event => {

                event.preventDefault(); // Ngăn chặn hành động mặc định của nút xóa

                // Tạo lớp nền mờ
                var overlay = document.createElement('div');
                overlay.className = 'overlay';
                document.body.appendChild(overlay);


                // Tạo popup
                var popup = document.createElement('div');
                popup.className = 'popup';
                const productName = event.target.getAttribute('data-name');
                console.log(productName);
                popup.innerHTML = `
<img src="{{ asset('images/delete.png') }}" style="padding-left: 90px;">
<p style="text-align: center">Are you sure you want to delete the product <p style="color: red; text-align: center">${productName}?</p></p>
                   <p style="color: red; text-align: center">The product will be permanently deleted</p>
                   <button class="btn-cancel-new">Cancel</button>
                   <button class="btn-confirm">Delete</button>`;

                document.body.appendChild(popup);

                // Thêm sự kiện click cho nút xác nhận
                popup.querySelector('.btn-confirm').addEventListener('click', function () {
                    event.target.closest('form').submit(); // Gửi form xóa
                    document.body.removeChild(popup); // Xóa popup
                    document.body.removeChild(overlay); // Xóa lớp nền mờ
                });

                // Thêm sự kiện click cho nút hủy
                popup.querySelector('.btn-cancel-new').addEventListener('click', function () {
                    document.body.removeChild(popup); // Xóa popup
                    document.body.removeChild(overlay); // Xóa lớp nền mờ
                });
            });
        });
    </script>
</body>
</html>
