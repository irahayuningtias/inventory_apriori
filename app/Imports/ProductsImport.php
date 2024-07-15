<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $category = Category::where('category_name', $row['category_name'])->first();

        if ($category) {
            return new Product([
                'id_product' => $row['id_product'],
                'id_category' => $category->id_category,
                'product_name' => $row['product_name'],
                'quantity' => $row['quantity'],
                'price' => $row['price'],
            ]);
        } else {
            // Handle the case where the category is not found
            // You might want to log this or skip this entry
            return null;
        }
    }
}
