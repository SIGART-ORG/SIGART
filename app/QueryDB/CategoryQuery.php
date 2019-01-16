<?php
namespace App\QueryDB;

use App\Category;

class CategoryQuery extends BaseQuery
{
    public function getModel()
    {
        return new Category();
    }

}