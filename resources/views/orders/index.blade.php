<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - Budhi Soya Foods</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .order-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-processing {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .status-shipped {
            background: #d4edda;
            color: #155724;
        }
        
        .status-delivered {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        .payment-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .payment-waiting {
            background: #d1ecf1;
            color: #0c5460;
        }
        
        .payment-verified {
            background: #d4edda;
            color: #155724;
        }
        
        .payment-rejected {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body class="bg-gray-50">
    <x-navbar></x-navbar>
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-green-800 to-green-600 py-20">
        <div class="container mx-auto px-4 text-center text-white">
            <h1 class="text-4xl font-bold mb-4">Pesanan Saya</h1>
            <p class="text-xl opacity-90">Kelola dan pantau status pesanan Anda</p>
        </div>
    </section>

    <!-- Orders Section -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="order-card">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $order->order_number }}</h3>
                                    <p class="text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <span class="status-badge status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    <span class="status-badge payment-{{ str_replace('_', '-', $order->payment_status) }}">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Informasi Pengiriman</h4>
                                    <p class="text-gray-600"><strong>Nama:</strong> {{ $order->shipping_name }}</p>
                                    <p class="text-gray-600"><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                                    <p class="text-gray-600"><strong>Provinsi:</strong> {{ $order->shipping_province }}</p>
                                    <p class="text-gray-600"><strong>Kode Pos:</strong> {{ $order->shipping_postal_code }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-2">Produk ({{ $order->orderItems->count() }} item)</h4>
                                    <div class="space-y-2">
                                        @foreach($order->orderItems->take(3) as $item)
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-600">{{ $item->product_name }} x{{ $item->quantity }}</span>
                                                <span class="font-medium">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                        @if($order->orderItems->count() > 3)
                                            <p class="text-sm text-gray-500">dan {{ $order->orderItems->count() - 3 }} produk lainnya...</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center mt-6 pt-4 border-t">
                                <div>
                                    <span class="text-2xl font-bold text-green-600">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="flex gap-3">
                                    <a href="{{ route('orders.show', $order->id) }}" 
                                       class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-eye mr-2"></i>Detail
                                    </a>
                                    @if($order->status === 'pending')
                                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors"
                                                    onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                <i class="fas fa-times mr-2"></i>Batalkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="fas fa-shopping-bag text-6xl text-gray-300 mb-6"></i>
                    <h3 class="text-2xl font-bold text-gray-600 mb-4">Belum Ada Pesanan</h3>
                    <p class="text-gray-500 mb-8">Anda belum memiliki pesanan. Mari mulai berbelanja!</p>
                    <a href="{{ route('product') }}" 
                       class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition-colors inline-flex items-center">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </section>
</body>
</html>