<?php

namespace App\Exports;

use App\Models\Array;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArrayExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Array::all();
    }
}
