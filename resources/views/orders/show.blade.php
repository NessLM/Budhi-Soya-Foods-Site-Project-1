<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Budhi Soya Foods</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/orders.css') }}">
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <x-navbar></x-navbar>
    
    <!-- Hero Section -->
    <section class="hero-gradient py-16">
        <div class="container mx-auto px-4 text-center text-white">
            <div class="mb-6">
                <i class="fas fa-receipt text-5xl mb-4 opacity-90"></i>
            </div>
            <h1 class="text-4xl font-bold mb-2">Detail Pesanan</h1>
            <p class="text-xl opacity-90">Order #{{ $order->order_number }}</p>
        </div>
    </section>

    <!-- Order Details -->
    <section class="py-12">
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

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Order Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Status -->
                    <div class="info-card">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-info-circle text-green-600 mr-3"></i>
                                Status Pesanan
                            </h2>
                            <div class="flex gap-3">
                                <span class="order-status status-{{ $order->status }}">
                                    <i class="fas fa-clock mr-2"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="order-status payment-{{ $order->payment_status }}">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-receipt text-green-600 w-6 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Order Number</p>
                                        <p class="font-semibold order-number">{{ $order->order_number }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar text-green-600 w-6 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                                        <p class="font-semibold">{{ $order->created_at->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill text-green-600 w-6 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                                        <div class="price-tag text-lg">
                                            Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-box text-green-600 w-6 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Total Item</p>
                                        <p class="font-semibold">{{ $order->orderItems->sum('quantity') }} item</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="info-card">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-box text-green-600 mr-3"></i>
                            Produk yang Dipesan
                        </h2>
                        <div class="space-y-6">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between p-6 bg-gray-50 rounded-xl">
                                    <div class="flex items-center space-x-6">
                                        <div class="relative">
                                            @if($item->product && $item->product->foto)
                                                <img src="{{ asset('uploads/products/' . $item->product->foto) }}" 
                                                     alt="{{ $item->product_name }}" 
                                                     class="product-image">
                                            @else
                                                <div class="product-image bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-box text-gray-400 text-2xl"></i>
                                                </div>
                                            @endif
                                            <div class="absolute -top-3 -right-3 bg-green-500 text-white text-sm rounded-full w-8 h-8 flex items-center justify-center font-bold">
                                                {{ $item->quantity }}
                                            </div>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item->product_name }}</h3>
                                            <p class="text-gray-600 mb-1">Rp {{ number_format($item->product_price, 0, ',', '.') }} per item</p>
                                            <p class="text-sm text-gray-500">Subtotal: Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="price-tag text-xl">
                                            Rp {{ number_format($item->total_price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="info-card">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-shipping-fast text-green-600 mr-3"></i>
                            Informasi Pengiriman
                        </h2>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-user text-green-600 w-6 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Nama Penerima</p>
                                        <p class="font-semibold">{{ $order->shipping_name }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-green-600 w-6 mr-3 mt-1"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Alamat</p>
                                        <p class="font-semibold">{{ $order->shipping_address }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <i class="fas fa-map text-green-600 w-6 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Provinsi</p>
                                        <p class="font-semibold">{{ $order->shipping_province }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-mail-bulk text-green-600 w-6 mr-3"></i>
                                    <div>
                                        <p class="text-sm text-gray-500">Kode Pos</p>
                                        <p class="font-semibold">{{ $order->shipping_postal_code }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="space-y-6">
                    <!-- Payment Status -->
                    @if($order->payment_status === 'pending')
                        <div class="info-card">
                            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-credit-card text-green-600 mr-3"></i>
                                Pembayaran
                            </h3>
                            
                            <!-- Payment Methods -->
                            <div class="space-y-4">
                                <!-- QRIS Payment -->
                                <div class="border border-gray-200 rounded-xl p-6">
                                    <div class="text-center">
                                        <i class="fas fa-qrcode text-4xl text-green-600 mb-4"></i>
                                        <h5 class="font-bold text-gray-800 mb-2">QRIS</h5>
                                        <p class="text-sm text-gray-600 mb-4">Scan QRIS untuk pembayaran cepat</p>
                                        <button onclick="showQRISPayment()" 
                                                class="btn-primary w-full">
                                            <i class="fas fa-qrcode mr-2"></i>
                                            Bayar dengan QRIS
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Manual Transfer -->
                                <div class="border border-gray-200 rounded-xl p-6">
                                    <div class="text-center">
                                        <i class="fas fa-university text-4xl text-blue-600 mb-4"></i>
                                        <h5 class="font-bold text-gray-800 mb-2">Transfer Manual</h5>
                                        <p class="text-sm text-gray-600 mb-4">Transfer ke rekening bank</p>
                                        <button onclick="showManualTransfer()" 
                                                class="btn-primary w-full">
                                            <i class="fas fa-university mr-2"></i>
                                            Transfer Manual
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Manual Transfer Form -->
                        <div id="manualTransferForm" class="info-card hidden">
                            <h4 class="text-lg font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-upload mr-3"></i>
                                Upload Bukti Pembayaran
                            </h4>
                            <form id="paymentForm" action="{{ route('orders.confirmPayment', $order->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-3">Bukti Transfer *</label>
                                        <div class="upload-area" onclick="document.getElementById('payment_proof').click()">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-600">Klik untuk upload atau drag & drop</p>
                                            <p class="text-sm text-gray-500 mt-2">JPG, PNG, max 2MB</p>
                                        </div>
                                        <input type="file" id="payment_proof" name="payment_proof" 
                                               accept="image/*" class="hidden" required>
                                        <div id="file-preview" class="mt-4 hidden">
                                            <img id="preview-image" class="max-w-full h-48 object-cover rounded-lg">
                                        </div>
                                    </div>
                                    
                                    <div class="grid md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengirim *</label>
                                            <input type="text" name="account_name" required
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Bank Pengirim *</label>
                                            <input type="text" name="bank_name" required
                                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Transfer *</label>
                                        <input type="number" name="transfer_amount" value="{{ $order->total_amount }}" required
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                        <textarea name="notes" rows="3"
                                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                                    </div>
                                    
                                    <button type="submit" 
                                            class="btn-primary w-full">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Kirim Bukti Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    @elseif($order->payment_status === 'waiting_verification')
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                            <h3 class="text-lg font-bold text-blue-800 mb-3 flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                Menunggu Verifikasi
                            </h3>
                            <p class="text-blue-700">Bukti pembayaran Anda sedang diverifikasi oleh admin. Mohon tunggu konfirmasi.</p>
                            @if($order->payment_proof)
                                <div class="mt-4">
                                    <p class="text-sm text-blue-600 mb-2">Bukti pembayaran yang dikirim:</p>
                                    <img src="{{ asset('uploads/payments/' . $order->payment_proof) }}" 
                                         alt="Bukti Pembayaran" 
                                         class="max-w-full h-48 object-cover rounded-lg">
                                </div>
                            @endif
                        </div>
                    @elseif($order->payment_status === 'paid')
                        <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                            <h3 class="text-lg font-bold text-green-800 mb-3 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Pembayaran Terverifikasi
                            </h3>
                            <p class="text-green-700">Pembayaran Anda telah diverifikasi. Pesanan sedang diproses.</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    @if($order->status === 'pending')
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="btn-secondary w-full"
                                    onclick="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                <i class="fas fa-times mr-2"></i>
                                Batalkan Pesanan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- QRIS Modal -->
    <div id="qrisModal" class="qris-modal">
        <div class="qris-modal-content">
            <span class="close text-3xl font-bold text-gray-500 hover:text-gray-700 cursor-pointer float-right" onclick="closeQRISModal()">&times;</span>
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Pembayaran QRIS</h2>
            <div class="mb-8">
                <div class="bg-gray-100 p-8 rounded-xl mb-6">
                    <div class="text-center">
                        <i class="fas fa-qrcode text-8xl text-green-600 mb-6"></i>
                        <p class="text-xl font-semibold text-gray-800 mb-3">Scan QRIS Code</p>
                        <p class="text-sm text-gray-600 mb-6">Gunakan aplikasi e-wallet atau mobile banking untuk scan QRIS</p>
                        <div class="bg-white p-6 rounded-xl inline-block">
                            <div class="w-64 h-64 bg-gray-200 rounded-xl flex items-center justify-center">
                                <p class="text-gray-500 text-sm">QRIS Code akan muncul di sini</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-xl font-bold text-gray-800">Total Pembayaran</p>
                    <div class="price-tag text-3xl mt-2">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            <div class="flex space-x-4">
                <button onclick="closeQRISModal()" 
                        class="flex-1 bg-gray-500 text-white py-3 px-6 rounded-xl hover:bg-gray-600 transition-colors">
                    Tutup
                </button>
                <button onclick="confirmQRISPayment()" 
                        class="flex-1 btn-primary">
                    Konfirmasi Pembayaran
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/orders.js') }}"></script>
</body>
</html>