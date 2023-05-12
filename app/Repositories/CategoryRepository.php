<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interface\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected $category;
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

}
