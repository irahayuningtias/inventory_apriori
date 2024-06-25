<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutcomingProduct extends Model
{
    use HasFactory;
    protected $table = 'outcoming_products'; //Eloquent akan membuat model transaction menyimpan record di tabel product
    public $timestamps = true;
    protected $primaryKey = 'id'; //Memanggil isi DB dengan primary key
    protected $fillable = [
        'outcoming_code',
        'outcoming_date',
    ];

    public function details()
    {
        return $this->hasMany(OutcomingProductDetail::class, 'id_outcoming', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'outcoming_product_details');
    }
}
