<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/admin/addproduct.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

</head>

<body>
<div id="product-form" style="background: rgba(0, 0, 0, 0.5); height: 100%">
    <div class="add-product-form">
        <div class="card-header separator">
            <h2 class="card-title">{{ config('my_config.addProducts') }}</h2>
        </div>
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
              id="add-product-form">
            @csrf
            <div class="row input-form">
                <div class="form-group">
                    <label for="inputName">{{ config('my_config.productName') }}<span class="required">*</span></label><br>
                    <input type="text" name="name" id="inputName" class="form-control input-form-group"
                           placeholder={{ config('my_config.input') }}>
                    @error('name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputCategory">{{ config('my_config.category') }}<span class="required">*</span></label><br>
                    <select id="inputCategory" name="category_id"
                            class="form-control custom-select input-form-group">
                        <option selected="" disabled="">{{ config('my_config.selectCategory') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputManufacturer">{{ config('my_config.manufacturer') }}<span class="required">*</span></label><br>
                    <select id="inputManufacturer" name="manufacturer_id"
                            class="form-control custom-select input-form-group">
                        <option selected="" disabled="">{{ config('my_config.selectManufacturer') }}</option>
                        @foreach($manufacturers as $manufacturer)
                            <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                        @endforeach
                    </select>
                    @error('manufacturer_id')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPrice">{{ config('my_config.price') }}<span class="required">*</span></label><br>
                    <input type="text" name="price" id="inputPrice" class="form-control input-form-group"
                    >
                    @error('price')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputMessage">{{ config('my_config.outline') }}</label><br>
                    <textarea id="inputMessage" name="description" class="form-control input-form-group"
                              rows="4"></textarea>
                    @error('description')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex ">
                    <div class="custom-file" style="
                        border-radius: 10px;
                        padding-left: 20px;
                        background: #0e0e0e;
                        height: 30px;
                        width: 136px;
                        padding-top: 10px;
                    ">
                        <input type="file" class="custom-file-input" id="image" name="image_path"
                               onchange="displayImage(this)">
                        <label class="custom-file-label" for="image">{{ config('my_config.addImage') }}<span
                                class="required">*</span></label>
                    </div>
                    @error('image_path')
                    <span class="error-message" style="padding-top: 10px;">{{ $message }}</span>
                    @enderror
                    <img id="preview" style="display: none; max-width: 80%; max-height: 80px; margin-left: 30px;">
                    <script>
                        function displayImage(input) {
                            var preview = document.getElementById('preview');
                            if (input.files && input.files[0]) {
                                var reader = new FileReader();
                                reader.onload = function (e) {
                                    preview.style.display = 'block';
                                    preview.setAttribute('src', e.target.result);
                                }
                                reader.readAsDataURL(input.files[0]);
                            }
                        }
                    </script>
                </div>
                <div class="button">
                    <div class="btn-cancel form-group">
                        <a class="btn-cancel" style="text-decoration: none; line-height: 44px" href="{{ route('products.index') }}">{{ config('my_config.cancel') }}</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-submit">{{ config('my_config.outline') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>

