<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';
    protected $primaryKey = 'id_cart';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'product_options',
        'notes',
        'added_at',
    ];

    protected $casts = [
        'product_options' => 'array',
        'added_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Relationships
    /*
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_produk', 'id_produk');
    }
    */

    // Computed attributes
    public function getTotalHargaAttribute()
    {
        return $this->jumlah * $this->harga_satuan;
    }
}