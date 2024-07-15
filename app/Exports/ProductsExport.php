<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::select('id_category', 'id_product', 'product_name', 'quantity', 'price')->get();
    }

    public function headings(): array
    {
        return [
            'Category',
            'Product Code',
            'Product Name',
            'Quantity',
            'Price',
        ];
    }
}
