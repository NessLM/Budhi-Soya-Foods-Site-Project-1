<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan {{ $order->order_number }} - Budhi Soya Foods</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #d1ecf1; color: #0c5460; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-delivered { background: #d1ecf1; color: #0c5460; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        .payment-pending { background: #fff3cd; color: #856404; }
        .payment-waiting { background: #d1ecf1; color: #0c5460; }
        .payment-verified { background: #d4edda; color: #155724; }
        .payment-rejected { background: #f8d7da; color: #721c24; }
        
        .upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .upload-area:hover {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
        
        .upload-area.dragover {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
    </style>
</head>
<body class="bg-gray-50">
    <x-navbar></x-navbar>
    
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-green-800 to-green-600 py-16">
        <div class="container mx-auto px-4">
            <div class="flex items-center text-white mb-4">
                <a href="{{ route('orders.index') }}" class="hover:text-green-200 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold">Detail Pesanan</h1>
            </div>
            <p class="text-xl opacity-90">{{ $order->order_number }}</p>
        </div>
    </section>

    <!-- Order Details -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Order Info -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Status Card -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">{{ $order->order_number }}</h2>
                                <p class="text-gray-600">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }}</p>
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
                    </div>

                    <!-- Shipping Info -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-shipping-fast text-green-600 mr-2"></i>
                            Informasi Pengiriman
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-gray-600"><strong>Nama Penerima:</strong></p>
                                <p class="text-gray-800">{{ $order->shipping_name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600"><strong>Provinsi:</strong></p>
                                <p class="text-gray-800">{{ $order->shipping_province }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-gray-600"><strong>Alamat Lengkap:</strong></p>
                                <p class="text-gray-800">{{ $order->shipping_address }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600"><strong>Kode Pos:</strong></p>
                                <p class="text-gray-800">{{ $order->shipping_postal_code }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-box text-green-600 mr-2"></i>
                            Produk Pesanan
                        </h3>
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center justify-between border-b pb-4">
                                    <div class="flex items-center">
                                        @if($item->product && $item->product->foto)
                                            <img src="{{ asset('uploads/products/' . $item->product->foto) }}" 
                                                 alt="{{ $item->product_name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg mr-4">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg mr-4 flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $item->product_name }}</h4>
                                            <p class="text-gray-600">Rp {{ number_format($item->product_price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-green-600">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Payment & Actions -->
                <div class="space-y-6">
                    <!-- Payment Summary -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-receipt text-green-600 mr-2"></i>
                            Ringkasan Pembayaran
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="font-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim:</span>
                                <span class="font-medium">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                            <hr>
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total:</span>
                                <span class="text-green-600">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    @if($order->payment_status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-yellow-800 mb-3">
                                <i class="fas fa-info-circle mr-2"></i>
                                Instruksi Pembayaran
                            </h3>
                            <div class="text-yellow-700 space-y-2">
                                <p><strong>Transfer ke rekening:</strong></p>
                                <p>Bank BCA: 1234567890</p>
                                <p>A.n. Budhi Soya Foods</p>
                                <p class="mt-3"><strong>Jumlah Transfer:</strong></p>
                                <p class="text-xl font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Upload Payment Proof -->
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-upload text-green-600 mr-2"></i>
                                Upload Bukti Pembayaran
                            </h3>
                            <form id="paymentForm" enctype="multipart/form-data">
                                @csrf
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Transfer *</label>
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
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Bank Pengirim *</label>
                                            <input type="text" name="bank_name" required
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Transfer *</label>
                                        <input type="number" name="transfer_amount" value="{{ $order->total_amount }}" required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                        <textarea name="notes" rows="3"
                                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"></textarea>
                                    </div>
                                    
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        Kirim Bukti Pembayaran
                                    </button>
                                </div>
                            </form>
                        </div>
                    @elseif($order->payment_status === 'waiting_verification')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-blue-800 mb-3">
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
                    @elseif($order->payment_status === 'verified')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <h3 class="text-lg font-bold text-green-800 mb-3">
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
                                    class="w-full bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 transition-colors font-semibold"
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

    <script>
        // File upload preview
        document.getElementById('payment_proof').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('file-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Payment form submission
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
            submitBtn.disabled = true;
            
            fetch(`/orders/{{ $order->id }}/confirm-payment`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengirim bukti pembayaran');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    </script>
</body>
</html>