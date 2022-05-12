<?php

namespace App\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

interface IReadOnlyRepository
{
    /**
    * @return Collection
    */
    public function fetchAll(string|int|null $paginateValue);

    /**
    * @param $id
    * @return Model
    */
    public function findById(int $id): ?Model;
}