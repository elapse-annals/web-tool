<?php

namespace App\Repositories;

use App\Models\Array;

/**
 * Class ArrayRepository
 *
 * @package App\Presenters
 */
class ArrayRepository extends Repository
{
    /**
     * @var int
     */
    public $per_page = 10;

    /**
     * if this model associate other models need ->with('')
     *
     * @param array $data
     *
     * @return mixed
     */
    public function getList(array $data = [])
    {
        $Array = new Array();
        if (!empty($data)) {
            $Array = $this->assemblyWhere($Array, $data);
        }
        return $Array->orderBy('id')->Paginate($this->per_page);
    }

    /**
     * @param $id
     *
     * @return Array|Array[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return Array::find($id);
    }

    public function create(array $save)
    {
        return Array::create($save);
    }

    /**
     * @param array $save
     *
     * @return Array|\Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $save)
    {
        $attributes = [];
        if (isset($save['id'])) {
            $attributes['id'] = $save['id'];
        }
        if (isset($save['updated_at'])) {
            $attributes['updated_at'] = $save['updated_at'];
        }
        return Array::updateOrCreate($attributes, $save);
    }

    /**
     * @param array $save
     *
     * @return Array|\Illuminate\Database\Eloquent\Model
     */
    public function update(array $save, $id)
    {
        $attributes['updated_at'] = $save['updated_at'];
        return Array::find($id)->update($attributes, $save);
    }

    /**
     * @param int $id
     *
     * @return int
     */
    public function destroy(int $id)
    {
        return Array::destroy($id);
    }

}
