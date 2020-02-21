<?php

namespace App\Repositories;

use App\Models\Tool;

/**
 * Class ToolRepository
 *
 * @package App\Presenters
 */
class ToolRepository extends Repository
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
        $Tool = new Tool();
        if (!empty($data)) {
            $Tool = $this->assemblyWhere($Tool, $data);
        }
        return $Tool->orderBy('id')->Paginate($this->per_page);
    }

    /**
     * @param $id
     *
     * @return Tool|Tool[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return Tool::find($id);
    }

    public function create(array $save)
    {
        return Tool::create($save);
    }

    /**
     * @param array $save
     *
     * @return Tool|\Illuminate\Database\Eloquent\Model
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
        return Tool::updateOrCreate($attributes, $save);
    }

    /**
     * @param array $save
     *
     * @return Tool|\Illuminate\Database\Eloquent\Model
     */
    public function update(array $save, $id)
    {
        $attributes['updated_at'] = $save['updated_at'];
        return Tool::find($id)->update($attributes, $save);
    }

    /**
     * @param int $id
     *
     * @return int
     */
    public function destroy(int $id)
    {
        return Tool::destroy($id);
    }

}
