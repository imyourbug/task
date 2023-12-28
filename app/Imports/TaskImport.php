<?php

namespace App\Imports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TaskImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Task|null
     */
    public function model(array $row)
    {
        return new Task([
            'id_task' => $row[0],
            'name' => $row[1],
            'password' => $row[2],
            'cod' => $row[3],
            'receiver' => $row[4],
            'phone_receiver' => $row[5],
            'phone_otp' => $row[6],
            'address' => $row[7],
            'ward' => $row[8],
            'district' => $row[9],
            'province' => $row[10],
            'link' => $row[11],
            'code' => $row[12],
            'wage' => $row[13]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
