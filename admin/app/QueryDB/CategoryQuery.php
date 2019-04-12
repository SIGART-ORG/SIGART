<?php
namespace App\QueryDB;

use App\Category;

class CategoryQuery extends BaseQuery
{
    public function getModel()
    {
        return new Category();
    }

    public function getDataByStatus($status){
        $model = $this->getModel();
        return $model::where('status', $status)
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();
    }
}