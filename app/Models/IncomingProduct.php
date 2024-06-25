<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomingProduct extends Model
{
    use HasFactory;

    protected $table = 'incoming_product'; //Eloquent akan membuat model product menyimpan record di tabel product
    public $timestamps = false;
    protected $primaryKey = 'id'; //Memanggil isi DB dengan primary key
    protected $fillable = [
        'incoming_code',
        'incoming_date',
    ];

    public function details()
    {
        return $this->hasMany(IncomingProductDetail::class, 'id_incoming', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'incoming_product_details');
    }
}
