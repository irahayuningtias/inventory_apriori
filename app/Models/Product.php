<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product'; //Eloquent akan membuat model product menyimpan record di tabel product
    public $timestamps = false;
    protected $primaryKey = 'id_product'; //Memanggil isi DB dengan primary key
    public $incrementing = false; //Agar Eloquent tidak menganggap kolom ID ini auto-increment
    protected $fillable = [
        'id_product',
        'id_category',
        'product_name',
        'quantity',
        'price',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }
}
