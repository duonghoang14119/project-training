<?php

namespace App\Repositories;

use App\Models\Manufacturer;
use App\Repositories\Interface\ManufacturerRepositoryInterface;

class ManufacturerRepository extends BaseRepository implements ManufacturerRepositoryInterface
{
    protected $manufacturer;
    public function __construct(Manufacturer $model)
    {
        parent::__construct($model);
    }

}
