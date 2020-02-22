<?php

namespace App\Repositories;


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

}
