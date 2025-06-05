<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'produk'; // sesuaikan nama tabel kamu

    protected $primaryKey = 'id_produk';

    public $timestamps = true; // karena ada created_at dan updated_at

    protected $fillable = [
        'nama_produk',
        'harga',
        'jumlah_produk',
        'kategori',
        'deskripsi',
        'foto',
    ];
}
