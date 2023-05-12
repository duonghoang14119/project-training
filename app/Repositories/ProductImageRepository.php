<?php

namespace App\Repositories;

use App\Models\ProductImage;
use App\Repositories\Interface\ProductImageRepositoryInterface;

class ProductImageRepository extends BaseRepository implements ProductImageRepositoryInterface
{
    public function __construct(ProductImage $model)
    {
        parent::__construct($model);
    }
}
