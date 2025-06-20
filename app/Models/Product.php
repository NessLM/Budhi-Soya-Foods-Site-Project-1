Adding relationships and casts to the Product model based on the user's request.
```
```php
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
        'stok',
        'gambar',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

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
```<?php

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
        'stok',
        'gambar',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function cartItems()
    {
        return $this->hasMany(Cart::class, 'product_id');
    }

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