<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Daftar Produk</title>

    <link rel="stylesheet" href="/assets/css/admin-dashboard.css" />
    <link rel="stylesheet" href="/assets/css/component/admin/listproduct.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <x-admin.asidebar_admin></x-admin.asidebar_admin>

    <div class="dashboard-container">
        <x-admin.atopbar-admin title="Daftar Produk" icon="fa-solid fa-boxes-stacked" />

        <div class="content">
            {{-- Notifikasi --}}
            @if(session('success'))
                <div class="alert alert-success" id="flash-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" id="flash-error">{{ session('error') }}</div>
            @endif

            <div class="product-table-container">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID Produk</th>
                            <th>Foto</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id_produk }}</td>
                                <td>
                                    @if ($product->foto)
                                        <img src="{{ asset('uploads/products/' . $product->foto) }}" alt="Foto Produk"
                                            class="product-img">
                                    @else
                                        <span style="color: #999;">Tidak Ada</span>
                                    @endif
                                </td>
                                <td>{{ $product->nama_produk }}</td>
                                <td>{{ $product->kategori }}</td>
                                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td>{{ $product->jumlah_produk }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($product->deskripsi, 50) }}</td>
                                <td>
                                    <a href="{{ route('product.edit', $product->id_produk) }}" class="btn btn-edit"><i class="fas fa-pen"></i></a>
                                    <form action="{{ route('product.destroy', $product->id_produk) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Belum ada produk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const success = document.getElementById('flash-success');
            const error = document.getElementById('flash-error');

            [success, error].forEach(el => {
                if (el) {
                    el.style.transition = 'all 0.5s';
                    el.style.opacity = 1;
                    setTimeout(() => {
                        el.style.opacity = 0;
                        el.style.display = 'none';
                    }, 4000);
                }
            });
        });
    </script>
</body>

</html>