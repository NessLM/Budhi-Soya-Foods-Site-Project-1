<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Tambah Produk</title>

    <link rel="stylesheet" href="/assets/css/admin-dashboard.css" />
    <link rel="stylesheet" href="/assets/css/component/admin/addproduct.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>

<body>
    <x-admin.asidebar_admin></x-admin.asidebar_admin>

    <div class="dashboard-container">
    <x-admin.atopbar-admin 
        title="{{ isset($product) ? 'Edit Produk' : 'Tambah Produk' }}" 
        icon="fas fa-tags" 
    />

    @if(session('success'))
        <div id="flash-success" style="display:none;">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div id="flash-error" style="display:none;">{{ session('error') }}</div>
    @endif

    <form method="POST" 
    action="{{ isset($product) ? route('product.update', $product->id_produk) : route('addproduct.store') }}"
          enctype="multipart/form-data"
          class="form-tambah-produk" style="margin-top: 1.5rem; max-width: 600px;">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <div class="form-group">
            <label for="nama_produk" class="form-label">Nama Produk <span class="required-star">*</span></label>
            <input type="text" id="nama_produk" name="nama_produk" class="form-input"
                   placeholder="Masukkan nama produk" autocomplete="off" required
                   value="{{ old('nama_produk', $product->nama_produk ?? '') }}" />
            @error('nama_produk')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="harga" class="form-label">Harga (Rp) <span class="required-star">*</span></label>
            <input type="number" id="harga" name="harga" class="form-input" required step="0.01"
                   placeholder="Masukkan harga produk" autocomplete="off"
                   value="{{ old('harga', $product->harga ?? '') }}" />
            @error('harga')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="jumlah_produk" class="form-label">Jumlah Produk <span class="required-star">*</span></label>
            <input type="number" id="jumlah_produk" name="jumlah_produk" class="form-input" required
                   placeholder="Masukkan jumlah produk" autocomplete="off"
                   value="{{ old('jumlah_produk', $product->jumlah_produk ?? '') }}" />
            @error('jumlah_produk')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group category-group">
            <label for="kategori" class="form-label">Kategori Produk <span class="required-star">*</span></label>
            <select name="kategori" id="kategori" class="form-input" required>
                <option value="" hidden>-- Pilih Kategori --</option>
                <option value="Makanan" {{ old('kategori', $product->kategori ?? '') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                <option value="Minuman" {{ old('kategori', $product->kategori ?? '') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
            </select>
            @error('kategori')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="deskripsi" class="form-label">Deskripsi Produk <span class="required-star">*</span></label>
            <textarea id="deskripsi" name="deskripsi" class="form-textarea" rows="4"
                      placeholder="Masukkan deskripsi produk" required>{{ old('deskripsi', $product->deskripsi ?? '') }}</textarea>
            @error('deskripsi')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="foto" class="form-label">Foto Produk @if(!isset($product))<span class="required-star">*</span>@endif</label>
            <input type="file" id="foto" name="foto" class="form-input" accept="image/*"
                   @if(!isset($product)) required @endif>
        
            <div id="foto-preview"
                 style="margin-top: 12px; width: 200px; height: 200px; border: 1px solid #ccc; border-radius: 8px; overflow: hidden;">
                @if(isset($product) && $product->foto)
                    <img src="{{ asset('uploads/products/' . $product->foto) }}"
                         alt="Preview Foto"
                         style="width: 100%; height: 100%; object-fit: cover;" />
                @else
                    <span style="display: block; text-align: center; line-height: 200px; color: #999;">No Image</span>
                @endif
            </div>
            @error('foto')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" style="margin-top: 2rem;">
            @if ($mode === 'edit')
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('listproduct.index') }}" class="btn btn-secondary">Kembali</a>
            @elseif ($mode === 'create')
                <button type="submit" class="btn btn-primary">Tambah Produk</button>
            @endif
        </div>
    </form>
</div>

    

    <script src="/assets/js/addproduct.js" defer></script>
</body>

</html>