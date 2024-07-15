<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingProductDetail extends Model
{
    use HasFactory;
    protected $table = 'incoming_product_details'; //Eloquent akan membuat model transaction menyimpan record di tabel product
    public $timestamps = true;
    protected $primaryKey = 'id'; //Memanggil isi DB dengan primary key
    protected $fillable = [
        'id_incoming',
        'id_product',
        'quantity',
        'description',
        'current_qty'
    ];

    public function incomingProduct()
    {
        return $this->belongsTo(IncomingProduct::class, 'id_incoming', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
