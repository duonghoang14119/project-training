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


    <link rel="stylesheet" href="{{ asset('css/admin/update.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/addproduct.css') }}">
</head>

<body>
@include('header')
<div class="home">
    @include('filter')
    <div class="content">
        <div class="update-product-page">
            <div class="form-update">
                <div class="">
                    <p>{{ config('my_config.product') }}</p>
                </div>
                <form action="{{ route('products.update',$product->id) }}" method="POST" enctype="multipart/form-data"
                      id="update-product-form" style="display: flex">
                    @csrf
                    @method('PUT')
                    <div class="row update-form">
                        <div class="form-group">
                            <label for="inputName">{{ config('my_config.productName') }} <span class="required">*</span></label><br>
                            <input type="text" name="name" id="inputName" class="form-control update-form-group"
                                   placeholder={{ config('my_config.productName') }} value="{{ $product->name }}">
                        </div>
                        @error('name')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="inputCategory">{{ config('my_config.category') }} <span class="required">*</span></label><br>
                            <select id="inputCategory" name="category_id"
                                    class="form-control custom-select update-form-group">
                                <option selected="" disabled="">{{ config('my_config.selectCategory') }}</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            @if($category->id == $product->category_id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="inputManufacturer">{{ config('my_config.manufacturer') }} <span class="required">*</span></label><br>
                            <select id="inputManufacturer" name="manufacturer_id"
                                    class="form-control custom-select update-form-group">
                                <option selected="" disabled="">{{ config('my_config.selectManufacturer') }}</option>
                                @foreach($manufacturers as $manufacturer)
                                    <option value="{{ $manufacturer->id }}"
                                            @if($manufacturer->id == $product->manufacturer_id) selected @endif>{{ $manufacturer->name }}</option>

                                @endforeach
                            </select>
                        </div>
                        @error('manufacturer_id')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="inputPrice">{{ config('my_config.price') }} <span class="required">*</span></label><br>
                            <input type="text" name="price" id="inputPrice" class="form-control update-form-group"
                                   value="{{ $product->price }}">
                        </div>
                        @error('price')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="inputMessage">{{ config('my_config.outline') }}</label><br>
                            <textarea id="inputMessage" name="description" class="form-control update-form-group"
                                      rows="3">{{ $product->description }}</textarea>
                        </div>
                        @error('description')
                        <span class="error-message">{{ $message }}</span>
                        @enderror

                        <div class="button-update">
                            <div class="form-group">
                                <a id="btn-update-cancel" class="btn-update-cancel" href="{{ route('products.index') }}">{{ config('my_config.cancel') }}</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn-update-submit">{{ config('my_config.add') }}</button>
                            </div>
                        </div>


                    </div>
                    <div class="img-update" style="padding-left: 20px;">
                        <div class="img-update-above">
                            <label for="inputPrice">{{ config('my_config.avatar') }} <span class="required">*</span></label><br>
                            <div>

                                <div class="image-container img-update-above">

                                    <img style="width: 100%; height: 100%"
                                         src="{{ asset('images/'. $product->image_path) }}" alt="" class="img-product img-update-under">
                                    <div class="btn-hide">
                                        <button class="btn-update-img">{{ config('my_config.update') }}</button>
                                        <input type="file" hidden name="image_path" value="" id="image">
                                    </div>
                                </div>
                                <div id="image-preview"></div>
                            </div>
                        </div>
                        <script>
                            // Lấy các phần tử cần xử lý
                            var img = document.querySelector('.img-product');
                            var btn = document.querySelector('.btn-update-img');
                            var input = document.querySelector('#image');

                            // Gán sự kiện click cho button
                            btn.addEventListener('click', function(e){
                                e.preventDefault();
                                input.click();
                            });

                            // Xử lý khi chọn hình ảnh
                            input.addEventListener('change', function(){
                                var reader = new FileReader();

                                reader.onload = function(e){
                                    // Cập nhật giá trị của thuộc tính src của thẻ img
                                    img.setAttribute('src', e.target.result);

                                    // Hiển thị hình ảnh đã chọn trong input
                                    input.value = e.target.result;
                                }

                                reader.readAsDataURL(this.files[0]);
                            });
                        </script>
                        <p style="margin-top: 20px">Image slide</p>
                        <div class="change_image_slide" style="display: flex; flex-wrap: wrap;">

                            @foreach($dataImages as $imgSlider)
                                <div class="slide-item box1Img">
                                    <div class="slide-item-title">Image 1</div>
                                    <div class="slide-item-img" style="">
                                        <input type="text" hidden name="idImgSlider[]" value="{{$imgSlider->id}}"
                                               id="idImage">
                                        <img src="{{ asset('images/'. $imgSlider->path) }}" alt="" class="imgElement">
                                        <div class="update_delete">
                                            <div class="btn_update_delete" onclick="image_upload(this)">Update</div>
                                            <div class="btn_update_delete" onclick="image_delete(this)">Delete</div>
                                        </div>
                                        <input type="text" name="idImageDelete[]" hidden value="" id="getIdImage">
                                        <input type="file" class="inputElement" hidden name="imageSlide[]">
                                    </div>
                                </div>
                            @endforeach

                            <div class="slide-image">

                                <div class="slide-item box2Add">
                                    <div class="slide-item-title">image 1</div>
                                    <div class="slide-item-vector addElement addImage">
                                        <div class="vector_sub">
                                            <div class="vector_padding" onclick="addElement(this)">
                                                <img src="{{ asset('images/anhnutthemmoi.png') }}">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    function loadImage(input, output) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(output).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    var appendHtml = '<div class="slide-item box1Img" hidden>';
    appendHtml += '<div class="slide-item-title">Ảnh 1</div>';
    appendHtml += '<div class="slide-item-img">';
    appendHtml += '<input type="text" hidden name="idImgSlider[]" value="" id="idImage">';
    appendHtml += '<img src="assets/images/Rectangle 195.jpg" alt="" class="imgElement">';
    appendHtml += '<div class="update_delete">';
    appendHtml += '<div class="btn_update_delete" onclick="image_upload(this)">Cập nhật</div>';
    appendHtml += '<div class="btn_update_delete" onclick="image_delete(this)">Xóa</div>';
    appendHtml += '</div>';
    appendHtml += '<input type="file" class="inputElement" hidden name="imageSlide[]">';
    appendHtml += '</div>';
    appendHtml += '</div>';


    // ============================== Phần ảnh SLIDE
    // Click thêm ảnh slide
    function addElement(addImage) {
        var slideItem = $(addImage).closest('.slide-item');
        slideItem.before(appendHtml);
        var inputElement = $(addImage).parents('.slide-image').find('.inputElement').last();
        var imgElement = $(addImage).parents('.slide-image').find('.imgElement').last();
        inputElement.click();

        inputElement.on('change', function () {
            if ($(".box1Img").length === 4 && $(".box1Img").css('display', 'block')) {
                $(".box2Add").hide();
            }

            if (this.files.length > 0) {
                $(".box1Img").show();
            }
            loadImage(this, imgElement);
        })
    }


    // Cập nhật ảnh slide
    function image_upload(update_image) {
        var slideItemImage = update_image.closest('.slide-item-img');
        var inputElement = slideItemImage.querySelector('.inputElement');

        $(inputElement).off('change').on('change', function () {
            var imgElement = slideItemImage.querySelector('.imgElement');
            loadImage(inputElement, imgElement);
        });
        inputElement.click();
    }

    // Xóa ảnh slide
    function image_delete(delete_image) {

        var idImage = $(delete_image).parents('.slide-item-img').find("#idImage").val();
        if (idImage !== "") {
            $(delete_image).parents('.slide-item-img').find("#getIdImage").attr('value', idImage);
        }

        $(delete_image).parents(".box1Img").hide();

        if ($(".box1Img").length !== 4) {
            $(".box2Add").show();
        } else {
            $(".box2Add").hide();
        }
    }
</script>

</body>
</html>
