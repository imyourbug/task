<?php

namespace App\Imports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TaskExport implements FromCollection
{
    public function __construct(private array $tasks)
    {
    }

    public function collection()
    {
        // dd($this->tasks);
        // return $this->tasks;
        return collect($this->tasks);
    }
}
