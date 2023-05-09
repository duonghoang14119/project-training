<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    protected $repository;
    protected $productImage;
    protected $category;
    protected $manufacturer;

    public function __construct(
        ProductRepository $repository,
        ProductImage      $productImage,
        Category          $category,
        Manufacturer      $manufacturer
    )
    {
        $this->manufacturer = $manufacturer;
        $this->productImage = $productImage;
        $this->repository = $repository;
        $this->category = $category;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function getAllCategory()
    {
        return $this->category->all();
    }

    public function getAllManufacturer()
    {
        return $this->manufacturer->all();
    }

    public function getProductImages($id){
        return $this->productImage->where('product_id', $id)->get();
    }

    public function getById($id)
    {
        return $this->repository->getById($id);
    }

    public function create($item)
    {
        $data = [
            'name' => $item->name,
            'price' => $item->price,
            'category_id' => $item->category_id,
            'manufacturer_id' => $item->manufacturer_id,
            'description' => $item->description
        ];
        $imagePath = $this->saveImageLocal($item);
        $data['image_path'] = $imagePath->getBasename();
        return $this->repository->create($data);
    }

    public function update($id, $item)
    {
        // code trường hợp thay đổi ảnh phụ silde
        $this->changeImageSlide($item, $id);

        $data = [
            'name' => $item->name,
            'price' => $item->price,
            'category_id' => $item->category_id,
            'manufacturer_id' => $item->manufacturer_id,
            'description' => $item->description
        ];

        //code trường hợp thay đổi ảnh chính
        if (!empty($item->image_path)) {
            $this->removeImage($id);
            $imagePath = $this->saveImageLocal($item);
            $data['image_path'] = $imagePath->getBasename();
        }
        return $this->repository->update($id, $data);
    }

    public function changeImageSlide(Request $items, $id){
        // request sẽ trả về 3 trường dữ liệu dạng mảng là idImgSlider, idImageDelete, imageSlide
        // idImgSlider: hiển thị ra dữ liệu có key là số đếm từ 0, có value là id của ảnh slide đó trong trường hợp là không có sự thay đổi về ảnh hoặc update ảnh, trong trường hợp thêm mới thì value sẽ là null
        // imageSlide: hiển thị ra key là số tương ứng với những vị trí các dữ liệu ảnh trường idImgSlider có sự thay đổi và thêm mới, value sẽ là dữ liệu của ảnh được thêm mới
        // idImageDelete: hiển thị ra id của ảnh slide sẽ bị xóa

        //  kiểm tra mảng imageSlide có dữ liệu hay không nếu có thì mới có thể update hoặc thêm mới ảnh
        if (isset($items->imageSlide)){
            $idImgs = $items->idImgSlider;
            $images = $items->imageSlide;
            foreach ($images as $key => $value) {
                // lấy ra idImg từ mảng idImgSlider bằng key của mảng imageSlide
                $idImg = $idImgs[$key];

                // nếu từ key đó lấy ra được id của ảnh thì tiến hành update ảnh, nếu không lấy ra được id thì sẽ tiến hành thêm mới
                if ($idImg){
                    $file = $value;
                    $extension = $file->getClientOriginalExtension();
                    $imageName =  rand(100000, 999999). time() . '.' . $extension;
                    $imagePath = $file->move(public_path('images'), $imageName);
                    $data['path'] = $imagePath->getBasename();

                    //xóa ảnh cũ trong thư mục images
                    $imgOld = $this->productImage->findOrFail($idImg);
                    $deleteImage = public_path('images/' . $imgOld->path);
                    unlink($deleteImage);

                    $productImage = $this->productImage->findOrFail($idImg);
                    $productImage->update($data);
                } else {
                    $file = $value;
                    $extension = $file->getClientOriginalExtension();
                    $imageName =  rand(100000, 999999). time() . '.' . $extension;
                    $imagePath = $file->move(public_path('images'), $imageName);
                    $data['path'] = $imagePath->getBasename();
                    $data['product_id'] = $id;
                    $this->productImage->create($data);
                }

            }
        }

        // kiểm tra mảng idImageDelete có dữ liệu hay không
        if (isset($items->idImageDelete)) {
            foreach ($items->idImageDelete as $itemDelete) {
                // do mảng idImageDelete trả về số lượng dữ liệu tương ứng với số ảnh slide đang được lưu trong data
                // và chỉ có những ảnh bị xóa thì value mới có giá trị những ảnh không bị xóa thì value sẽ là null
                // nên ở đây cần check xem giá trị $itemDelete có tồn tại không
                if ($itemDelete) {
                    $imgOld = $this->productImage->findOrFail($itemDelete);
                    $deleteImage = public_path('images/' . $imgOld->path);
                    unlink($deleteImage);

                    $this->productImage->destroy($itemDelete);

                }
            }
        }
    }
    public function removeImage($id){
        $product = $this->getById($id);
        $imagePath = public_path('images/' . $product->image_path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    public function saveImageLocal(Request $item) {
        $file = $item->file('image_path');
        $extension = $file->getClientOriginalExtension();
        $imageName = time().'.'.$extension;
        $imagePath = $file->move(public_path('images'), $imageName);
        return $imagePath;
    }

    public function removeImagesSlide($id){
        $productImages = $this->getProductImages($id);
        foreach ($productImages as $image) {
            $imagePath = public_path('images/' . $image->path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    }
    public function delete($id)
    {
        $this->removeImage($id);
        $this->removeImagesSlide($id);
        return $this->repository->delete($id);
    }

    public function getByManufacturerId($manufacturerId)
    {
        return $this->repository->getByManufacturerId($manufacturerId);
    }

    public function getByCategoryId($categoryId)
    {
        return $this->repository->getByCategoryId($categoryId);
    }
    public function showProducts(Request $request){

        // kiểm tra các giá trị trả về của filter và search để lọc sản phẩm
        $querySearch = $request->input('query');
        $filterCategory = $request->input('category_id');
        $filterManufacturer = $request->input('manufacturer_id');
        $products = $this->getAll();
        if ($querySearch){
            $products = $this->search($querySearch);
        }
        if ($filterCategory) {
            $products = $this->getByCategoryId($filterCategory);
        }
        if ($filterManufacturer) {
            $products = $this->getByManufacturerId($filterManufacturer);
        }

        $perPage = 12;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $products->slice(($currentPage - 1) * $perPage, $perPage);
        $pagination = new LengthAwarePaginator($currentPageItems, count($products), $perPage);
        $pagination->setPath(request()->url());
        return $pagination;
    }

    public function getRecommendedProducts($id){
        $data = $this->getById($id);
        $recommendedProducts = $this->getByCategoryId($data->category_id)->whereNotIn('id', explode(',', $id))->take(3);
        if ($recommendedProducts->isEmpty()){
            $recommendedProducts = $this->getByManufacturerId($data->manufacturer_id)->whereNotIn('id', explode(',', $id))->take(3);
        }
        return $recommendedProducts;
    }

    public function search($request)
    {
        return $this->repository->search($request);
    }

}
