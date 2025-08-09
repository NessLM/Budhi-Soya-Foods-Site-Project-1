<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - Budhi Soya Foods</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/orders.css') }}">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <x-navbar></x-navbar>
    
    <!-- Hero Section -->
    <section class="hero-gradient py-20">
        <div class="container mx-auto px-4 text-center text-white">
            <div class="mb-6">
                <i class="fas fa-shopping-bag text-5xl mb-4 opacity-90"></i>
            </div>
            <h1 class="text-5xl font-bold mb-4">Pesanan Saya</h1>
            <p class="text-xl opacity-90 max-w-2xl mx-auto">Kelola dan pantau status pesanan Anda dengan mudah dan real-time</p>
        </div>
    </section>

    <!-- Orders Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl mb-8 flex items-center">
                    <i class="fas fa-check-circle mr-3 text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl mb-8 flex items-center">
                    <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($orders->count() > 0)
                <div class="space-y-8">
                    @foreach($orders as $order)
                        <div class="order-card {{ $order->status === 'cancelled' ? 'cancelled' : '' }}">
                            <!-- Header -->
                            <div class="flex justify-between items-start mb-6">
                                <div class="flex items-center space-x-4">
                                    <div class="order-number">
                                        <i class="fas fa-receipt mr-2"></i>
                                        {{ $order->order_number }}
                                    </div>
                                    <div class="text-gray-500">
                                        <i class="fas fa-calendar mr-2"></i>
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <span class="status-badge status-{{ $order->status }}">
                                        <i class="fas fa-clock mr-2"></i>
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    @if($order->status !== 'cancelled')
                                        <span class="status-badge payment-{{ str_replace('_', '-', $order->payment_status) }}">
                                            <i class="fas fa-credit-card mr-2"></i>
                                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="grid lg:grid-cols-3 gap-8">
                                <!-- Shipping Info -->
                                <div class="lg:col-span-1">
                                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-shipping-fast text-green-600 mr-3"></i>
                                        Informasi Pengiriman
                                    </h4>
                                    <div class="bg-gray-50 p-4 rounded-xl">
                                        <div class="space-y-3">
                                            <div class="flex items-center">
                                                <i class="fas fa-user text-green-600 w-5 mr-3"></i>
                                                <span class="font-medium">{{ $order->shipping_name }}</span>
                                            </div>
                                            <div class="flex items-start">
                                                <i class="fas fa-map-marker-alt text-green-600 w-5 mr-3 mt-1"></i>
                                                <span class="text-gray-700">{{ $order->shipping_address }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-map text-green-600 w-5 mr-3"></i>
                                                <span class="text-gray-700">{{ $order->shipping_province }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-mail-bulk text-green-600 w-5 mr-3"></i>
                                                <span class="text-gray-700">{{ $order->shipping_postal_code }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Products -->
                                <div class="lg:col-span-2">
                                    <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                                        <i class="fas fa-box text-green-600 mr-3"></i>
                                        Produk yang Dipesan ({{ $order->orderItems->count() }} item)
                                    </h4>
                                    <div class="space-y-4">
                                        @foreach($order->orderItems as $item)
                                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                                <div class="flex items-center space-x-4">
                                                    <div class="relative">
                                                        @if($item->product && $item->product->foto)
                                                            <img src="{{ asset('uploads/products/' . $item->product->foto) }}" 
                                                                 alt="{{ $item->product_name }}" 
                                                                 class="product-image">
                                                        @else
                                                            <div class="product-image bg-gray-200 flex items-center justify-center">
                                                                <i class="fas fa-box text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                        <div class="absolute -top-2 -right-2 bg-green-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold">
                                                            {{ $item->quantity }}
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-semibold text-gray-800">{{ $item->product_name }}</h5>
                                                        <p class="text-sm text-gray-500">Rp {{ number_format($item->product_price, 0, ',', '.') }} per item</p>
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="price-tag {{ $order->status === 'cancelled' ? 'cancelled-price' : '' }}">
                                                        Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Footer -->
                            <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-200">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                                        <div class="price-tag text-lg {{ $order->status === 'cancelled' ? 'cancelled-price' : '' }}">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-4">
                                    @if($order->status !== 'cancelled')
                                        <a href="{{ route('orders.show', $order->id) }}" 
                                           class="btn-primary">
                                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                                        </a>
                                        @if($order->status === 'pending')
                                            <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn-secondary"
                                                        onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                    <i class="fas fa-times mr-2"></i>Batalkan
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <div class="flex items-center space-x-4">
                                            <span class="text-gray-500 text-sm">
                                                <i class="fas fa-info-circle mr-2"></i>
                                                Pesanan telah dibatalkan
                                            </span>
                                            <span class="text-xs text-gray-400">
                                                (Fitur hapus akan ditambahkan setelah database update)
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-12 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <div class="bg-white rounded-2xl p-12 shadow-lg max-w-md mx-auto">
                        <div class="mb-8">
                            <i class="fas fa-shopping-bag text-8xl text-gray-300"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-600 mb-4">Belum Ada Pesanan</h3>
                        <p class="text-gray-500 mb-8 leading-relaxed">Anda belum memiliki pesanan. Mari mulai berbelanja produk soya berkualitas tinggi!</p>
                        <a href="{{ route('product') }}" 
                           class="btn-primary inline-flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    
    <script src="{{ asset('assets/js/orders.js') }}"></script>
</body>
</html>