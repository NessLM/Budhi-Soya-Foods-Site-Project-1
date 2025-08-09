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
        'deskripsi',
        'harga',
        'jumlah_produk',
        'kategori',
        'foto',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];



    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function averageRating()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating');
    }

    public function totalReviews()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }
}
