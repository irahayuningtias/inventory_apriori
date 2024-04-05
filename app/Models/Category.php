<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category'; //Eloquent akan membuat model category menyimpan record di tabel category
    public $timestamps = false;
    protected $primaryKey = 'id_category'; //Memanggil isi DB dengan primary key
    public $incrementing = false; //Agar Eloquent tidak menganggap kolom ID ini auto-increment
    protected $fillable = [
        'id_category',
        'category',
    ];
}
