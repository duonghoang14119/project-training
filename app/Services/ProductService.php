<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\ProductImage;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
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

    public function update($id)
    {
        return $this->repository->update($id);
    }

    public function saveImageLocal(Request $item) {
        $file = $item->file('image_path');
        $extension = $file->getClientOriginalExtension();
        $imageName = time().'.'.$extension;
        $imagePath = $file->move(public_path('images'), $imageName);
        return $imagePath;
    }

    public function delete($id)
    {
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

    public function search($request)
    {
        return $this->repository->search($request);
    }

}
