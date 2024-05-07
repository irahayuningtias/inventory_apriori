<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction'; //Eloquent akan membuat model transaction menyimpan record di tabel product
    public $timestamps = false;
    protected $primaryKey = 'id'; //Memanggil isi DB dengan primary key
    protected $fillable = [
        'transaction_code',
        'transaction_date',
        'total_amount',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'id_transaction', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_details')->withPivot('quantity', 'price', 'subtotol');
    }
}
