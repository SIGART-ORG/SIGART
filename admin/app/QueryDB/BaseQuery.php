<?php
namespace App\QueryDB;

abstract class BaseQuery
{
    abstract public function getModel();

    public function find($id)
    {
        return $this->getModel()->find($id);
    }

    public function getAll()
    {
        return $this->getModel()->all();
    }

    public function create()
    {
        return $this->getModel()->create($data);
    }

    public function update($object, $data)
    {
        $object->fill($data);
        $object->save();
        return $object;
    }
    

    public function findOrFail($id)
    {
        return $this->getModel()->findOrFail($id);
    }

    public function getPaginatedByField($field,$signo,$value,$num_per_page,$fieldOrder,$typeOrder="asc",$criterio_bd="",$buscar=""){
        return $this->getModel()->where($field, $signo, $value)
                         ->where(function($query) use($criterio_bd,$buscar){
                             if($criterio_bd!="" or $buscar!=""){
                                 $query->where($criterio_bd, 'like', '%'.$buscar.'%');
                             }
                         })
                         ->orderBy($fieldOrder, $typeOrder)
                         ->paginate($num_per_page);
    }

}