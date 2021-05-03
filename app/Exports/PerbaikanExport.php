<?php

namespace App\Exports;

use App\Models\Permintaan\Perbaikan;
use Maatwebsite\Excel\Concerns\FromCollection;

class PerbaikanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Perbaikan::all();
    }
}
