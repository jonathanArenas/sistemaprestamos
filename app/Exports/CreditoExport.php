<?php

namespace App\Exports;

use App\Credito;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CreditoExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function  headings(): array{
        return [
            'num',
            'tipo de prestamo'
        ];

    }


    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Credito::select('num','interes_type')->get();
    }
}
