<?php

namespace App\Exports;

use App\Models\Request as ProductRequest;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductRequestsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ProductRequest::all();
    }
}
