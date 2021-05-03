<?php

namespace App\Imports;

use App\Models\TAM\BA\RS;
use Maatwebsite\Excel\Concerns\ToModel;

class RSImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new RS([
            'nama_rs' => $row[0],
            'cabang_id' => $row[1],
        ]);
    }
}
