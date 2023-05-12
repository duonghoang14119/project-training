<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interface\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function getByManufacturerId($manufacturerId)
    {
        return $this->model->where('manufacturer_id', $manufacturerId)->get();
    }

    public function getByCategoryId($categoryId)
    {
        return $this->model->where('category_id', $categoryId)->get();
    }

    public function search($request)
    {
        $query = $request;
        $products = $this->model->where('name', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->get();
        return $products;
    }
}
