<?php

namespace App\Services;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Repositories\Interface\ProductRepositoryInterface;
use App\Repositories\Interface\CategoryRepositoryInterface;
use App\Repositories\Interface\ManufacturerRepositoryInterface;
use App\Repositories\Interface\ProductImageRepositoryInterface;

class ProductService
{
    protected $repository;
    protected $productImage;
    protected $category;
    protected $manufacturer;

    public function __construct(
        CategoryRepositoryInterface     $category,
        ProductRepositoryInterface      $repository,
        ProductImageRepositoryInterface $productImage,
        ManufacturerRepositoryInterface $manufacturer,
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
        return $this->category->getAll();
    }

    public function getAllManufacturer()
    {
        return $this->manufacturer->getAll();
    }

    public function getById($id)
    {
        return $this->repository->find($id);
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

    public function changeImageSlide($items, $id)
    {
        if (isset($items->imageSlide)) {
            $idImgs = $items->idImgSlider;
            $images = $items->imageSlide;
            foreach ($images as $key => $value) {
                $idImg = $idImgs[$key];
                if ($idImg) {
                    $data = $this->saveProductImage($value);
                    //xóa ảnh cũ trong thư mục images
                    $productImage = $this->productImage->find($idImg);
                    $deleteImage = public_path('images/' . $productImage->path);
                    unlink($deleteImage);

                    $productImage->update($data);
                } else {
                    $data = $this->saveProductImage($value);
                    $data['product_id'] = $id;
                    $this->productImage->create($data);
                }
            }
        }

        if (isset($items->idImageDelete)) {
            foreach ($items->idImageDelete as $itemDelete) {
                if ($itemDelete) {
                    $imgOld = $this->productImage->find($itemDelete);
                    $deleteImage = public_path('images/' . $imgOld->path);
                    unlink($deleteImage);
                    $this->productImage->delete($itemDelete);
                }
            }
        }
    }

    public function saveProductImage($value)
    {
        $extension = $value->getClientOriginalExtension();
        $imageName = rand(100000, 999999) . time() . '.' . $extension;
        $imagePath = $value->move(public_path('images'), $imageName);
        $data['path'] = $imagePath->getBasename();
        return $data;
    }

    public function removeImage($id)
    {
        $product = $this->getById($id);
        $imagePath = public_path('images/' . $product->image_path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    public function saveImageLocal($item)
    {
        $file = $item->file('image_path');
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '.' . $extension;
        $imagePath = $file->move(public_path('images'), $imageName);
        return $imagePath;
    }

    public function removeImagesSlide($id)
    {
        $productImages = $this->getById($id)->images;
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

    public function showProducts($request)
    {
        // kiểm tra các giá trị trả về của filter và search để lọc sản phẩm
        $querySearch = $request->input('query');
        $filterCategory = $request->input('category_id');
        $filterManufacturer = $request->input('manufacturer_id');
        $products = $this->getAll();
        if ($querySearch) {
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

    public function getRecommendedProducts($id)
    {
        $data = $this->getById($id);
        $recommendedProducts = $this->getByCategoryId($data->category_id)
            ->whereNotIn('id', explode(',', $id))
            ->take(3);
        if ($recommendedProducts->isEmpty()) {
            $recommendedProducts = $this->getByManufacturerId($data->manufacturer_id)
                ->whereNotIn('id', explode(',', $id))
                ->take(3);
        }
        return $recommendedProducts;
    }

    public function search($request)
    {
        return $this->repository->search($request);
    }

}
