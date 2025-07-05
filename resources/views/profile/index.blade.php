<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Budhi Soya Foods</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/profile.css">
</head>
<body>
    <!-- Include Navbar -->
    @include('components.navbar')

    <div class="profile-container">
        <div class="profile-header">
            <div class="container">
                <h1><i class="fas fa-user-circle"></i> Profil Saya</h1>
                <p>Kelola informasi profil dan pengaturan akun Anda</p>
            </div>
        </div>

        <div class="container">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="profile-content">
                <!-- Profile Sidebar -->
                <div class="profile-sidebar">
                    <div class="profile-card">
                        <div class="profile-avatar">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="profile-info">
                            <h3>{{ $user->full_name ?? $user->username }}</h3>
                            <p>{{ $user->email }}</p>
                            <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                <i class="fas fa-circle"></i>
                                {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>

                    <nav class="profile-nav">
                        <a href="#profile-info" class="nav-item active" data-tab="profile-info">
                            <i class="fas fa-user"></i>
                            Informasi Profil
                        </a>
                        <a href="#change-password" class="nav-item" data-tab="change-password">
                            <i class="fas fa-lock"></i>
                            Ubah Password
                        </a>
                        <a href="#addresses" class="nav-item" data-tab="addresses">
                            <i class="fas fa-map-marker-alt"></i>
                            Alamat Saya
                        </a>
                        <a href="#order-history" class="nav-item" data-tab="order-history">
                            <i class="fas fa-shopping-bag"></i>
                            Riwayat Pesanan
                        </a>
                    </nav>
                </div>

                <!-- Profile Main Content -->
                <div class="profile-main">
                    <!-- Profile Information Tab -->
                    <div id="profile-info" class="tab-content active">
                        <div class="section-header">
                            <h2><i class="fas fa-user-edit"></i> Informasi Profil</h2>
                            <p>Perbarui informasi profil Anda</p>
                        </div>

                        <form action="{{ route('profile.update') }}" method="POST" class="profile-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" value="{{ $user->username }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" value="{{ $user->email }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="full_name">Nama Lengkap</label>
                                    <input type="text" id="full_name" name="full_name" value="{{ $user->full_name }}">
                                </div>

                                <div class="form-group">
                                    <label for="phone">Nomor Telepon</label>
                                    <input type="tel" id="phone" name="phone" value="{{ $user->phone }}">
                                </div>

                                <div class="form-group">
                                    <label for="birth_date">Tanggal Lahir</label>
                                    <input type="date" id="birth_date" name="birth_date" value="{{ $user->birth_date ? $user->birth_date->format('Y-m-d') : '' }}">
                                </div>

                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select id="gender" name="gender">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Change Password Tab -->
                    <div id="change-password" class="tab-content">
                        <div class="section-header">
                            <h2><i class="fas fa-key"></i> Ubah Password</h2>
                            <p>Pastikan akun Anda menggunakan password yang kuat</p>
                        </div>

                        <form action="{{ route('profile.changePassword') }}" method="POST" class="profile-form">
                            @csrf
                            
                            <div class="form-group">
                                <label for="current_password">Password Saat Ini</label>
                                <input type="password" id="current_password" name="current_password" required>
                            </div>

                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" id="new_password" name="new_password" required>
                                <small class="form-help">Minimal 8 karakter</small>
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-lock"></i>
                                    Ubah Password
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Addresses Tab -->
                    <div id="addresses" class="tab-content">
                        <div class="section-header">
                            <h2><i class="fas fa-map-marker-alt"></i> Alamat Saya</h2>
                            <p>Kelola alamat pengiriman Anda</p>
                            <button class="btn btn-secondary" onclick="toggleAddressForm()">
                                <i class="fas fa-plus"></i>
                                Tambah Alamat
                            </button>
                        </div>

                        <!-- Add Address Form -->
                        <div id="add-address-form" class="address-form" style="display: none;">
                            <h3>Tambah Alamat Baru</h3>
                            <form action="{{ route('profile.addAddress') }}" method="POST">
                                @csrf
                                
                                <div class="form-grid">
                                    <div class="form-group">
                                        <label for="label">Label Alamat</label>
                                        <input type="text" id="label" name="label" placeholder="Rumah, Kantor, dll." required>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient_name">Nama Penerima</label>
                                        <input type="text" id="recipient_name" name="recipient_name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="phone">Nomor Telepon</label>
                                        <input type="tel" id="phone" name="phone" required>
                                    </div>

                                    <div class="form-group full-width">
                                        <label for="address">Alamat Lengkap</label>
                                        <textarea id="address" name="address" rows="3" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="city">Kota</label>
                                        <input type="text" id="city" name="city" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="province">Provinsi</label>
                                        <input type="text" id="province" name="province" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="postal_code">Kode Pos</label>
                                        <input type="text" id="postal_code" name="postal_code" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="checkbox-label">
                                            <input type="checkbox" name="is_default" value="1">
                                            <span class="checkmark"></span>
                                            Jadikan alamat utama
                                        </label>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i>
                                        Simpan Alamat
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="toggleAddressForm()">
                                        <i class="fas fa-times"></i>
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Address List -->
                        <div class="address-list">
                            @forelse($addresses as $address)
                                <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                                    <div class="address-header">
                                        <h4>{{ $address->label }}</h4>
                                        @if($address->is_default)
                                            <span class="default-badge">
                                                <i class="fas fa-star"></i>
                                                Alamat Utama
                                            </span>
                                        @endif
                                    </div>
                                    <div class="address-details">
                                        <p><strong>{{ $address->recipient_name }}</strong></p>
                                        <p><i class="fas fa-phone"></i> {{ $address->phone }}</p>
                                        <p><i class="fas fa-map-marker-alt"></i> {{ $address->address }}</p>
                                        <p>{{ $address->city }}, {{ $address->province }} {{ $address->postal_code }}</p>
                                    </div>
                                    <div class="address-actions">
                                        <form action="{{ route('profile.deleteAddress', $address->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus alamat ini?')">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h3>Belum ada alamat</h3>
                                    <p>Tambahkan alamat untuk memudahkan proses pengiriman</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Order History Tab -->
                    <div id="order-history" class="tab-content">
                        <div class="section-header">
                            <h2><i class="fas fa-shopping-bag"></i> Riwayat Pesanan</h2>
                            <p>Lihat semua pesanan yang pernah Anda buat</p>
                        </div>

                        <div class="order-list">
                            @forelse($orders as $order)
                                <div class="order-card">
                                    <div class="order-header">
                                        <div class="order-info">
                                            <h4>Pesanan #{{ $order->id }}</h4>
                                            <p class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div class="order-status">
                                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="order-items">
                                        @foreach($order->orderItems as $item)
                                            <div class="order-item">
                                                <div class="item-info">
                                                    <h5>{{ $item->product->nama_produk }}</h5>
                                                    <p>{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                                </div>
                                                <div class="item-total">
                                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <div class="order-footer">
                                        <div class="order-total">
                                            <strong>Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                        </div>
                                        <div class="order-actions">
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-eye"></i>
                                                Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <i class="fas fa-shopping-bag"></i>
                                    <h3>Belum ada pesanan</h3>
                                    <p>Mulai berbelanja untuk melihat riwayat pesanan Anda</p>
                                    <a href="{{ route('product') }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart"></i>
                                        Mulai Belanja
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/profile.js"></script>
</body>
</html>