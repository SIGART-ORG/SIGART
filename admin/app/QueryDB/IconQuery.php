<?php
namespace App\QueryDB;
use App\Icon;

class IconQuery extends BaseQuery
{
    public function getModel()
    {
        return new Icon();
    }

}