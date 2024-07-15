<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomingProductDetail extends Model
{
    use HasFactory;
    protected $table = 'outcoming_product_details'; //Eloquent akan membuat model transaction menyimpan record di tabel product
    public $timestamps = true;
    protected $primaryKey = 'id'; //Memanggil isi DB dengan primary key
    protected $fillable = [
        'id_outcoming',
        'id_product',
        'quantity',
        'description',
        'current_qty'
    ];

    public function outcomingProduct()
    {
        return $this->belongsTo(OutcomingProduct::class, 'id_outcoming', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
