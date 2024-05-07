<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;
    protected $table = 'transaction_details'; //Eloquent akan membuat model transaction menyimpan record di tabel product
    public $timestamps = false;
    protected $primaryKey = 'id'; //Memanggil isi DB dengan primary key
    protected $fillable = [
        'id_transaction',
        'id_product',
        'quantity',
        'price',
        'subtotal',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'id_transaction', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product', 'id_product');
    }
}
