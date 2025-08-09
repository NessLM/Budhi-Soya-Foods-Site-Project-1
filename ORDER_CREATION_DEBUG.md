# Order Creation Debugging Guide

## 🚨 **Problem Identified**

Error: "Terjadi kesalahan saat memproses pesanan!" saat user mencoba membuat pesanan baru.

## 🔧 **Debugging Steps Applied**

### 1. **Enhanced Logging**
```php
// Added detailed logging for debugging
Log::info('Order creation request received', [
    'user_id' => Auth::id(),
    'request_data' => $request->all(),
    'headers' => $request->headers->all()
]);
```

### 2. **Validation Error Handling**
```php
try {
    $request->validate([
        'nama_pemesan' => 'required|string|max:255',
        'alamat_lengkap' => 'required|string',
        'postal_code' => 'required|string|max:10',
        'provinsi' => 'required|string|max:100',
        'products' => 'required|array|min:1',
        'products.*.id' => 'required|exists:produk,id_produk',
        'products.*.quantity' => 'required|integer|min:1'
    ]);
} catch (\Illuminate\Validation\ValidationException $e) {
    Log::error('Validation failed', [
        'errors' => $e->errors(),
        'request_data' => $request->all()
    ]);
    return response()->json([
        'success' => false,
        'message' => 'Data tidak valid: ' . implode(', ', array_flatten($e->errors()))
    ], 422);
}
```

### 3. **Database Connection Test**
```php
// Test database connection first
DB::connection()->getPdo();

// Test if tables exist
$tables = ['orders', 'order_items', 'produk'];
foreach ($tables as $table) {
    if (!Schema::hasTable($table)) {
        throw new \Exception("Table {$table} does not exist");
    }
}
```

### 4. **Enhanced Error Handling**
```php
} catch (\Exception $e) {
    DB::rollback();
    
    Log::error('Order creation failed', [
        'user_id' => Auth::id(),
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
    
    return response()->json([
        'success' => false,
        'message' => 'Terjadi kesalahan: ' . $e->getMessage()
    ], 500);
}
```

### 5. **JavaScript Error Handling**
```javascript
.then(response => {
    clearTimeout(timeoutId);
    if (!response.ok) {
        return response.json().then(errorData => {
            throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
        });
    }
    return response.json();
})
.then(data => {
    if (data.success) {
        showNotification('Pesanan berhasil dibuat!', 'success');
        closeOrderForm();
        clearSelection();
        window.location.href = '/orders';
    } else {
        showNotification(data.message || 'Gagal membuat pesanan!', 'error');
    }
})
.catch(error => {
    clearTimeout(timeoutId);
    console.error('Error:', error);
    
    if (error.name === 'AbortError') {
        showNotification('Request timeout! Silakan coba lagi.', 'error');
    } else {
        showNotification(error.message || 'Terjadi kesalahan saat memproses pesanan!', 'error');
    }
})
```

## 🔍 **Potential Issues & Solutions**

### **Issue 1: Database Connection**
**Symptoms**: Connection timeout or database not found
**Solution**: 
- Check database configuration in `.env`
- Ensure MySQL service is running
- Verify database `budhi_soya_foods` exists

### **Issue 2: Missing Tables**
**Symptoms**: "Table does not exist" error
**Solution**:
```bash
php artisan migrate
# or manually create tables
```

### **Issue 3: Validation Errors**
**Symptoms**: "Data tidak valid" error
**Solution**:
- Check if all required fields are filled
- Verify product IDs exist in database
- Ensure quantity is positive integer

### **Issue 4: Stock Insufficient**
**Symptoms**: "Stok produk tidak mencukupi" error
**Solution**:
- Check product stock in database
- Reduce quantity or choose different products

### **Issue 5: CSRF Token**
**Symptoms**: 419 error or CSRF token missing
**Solution**:
- Ensure `<meta name="csrf-token" content="{{ csrf_token() }}">` exists in HTML
- Check if session is valid

## 📋 **Testing Checklist**

### **Pre-Test Setup**
- [ ] Database connection working
- [ ] All tables exist (orders, order_items, produk)
- [ ] Products exist in database
- [ ] User is authenticated
- [ ] CSRF token is present

### **Test Steps**
1. **Open Product Page**: `/product`
2. **Select Products**: Add products to selection
3. **Fill Order Form**: Complete all required fields
4. **Submit Order**: Click "Kirim Pesanan"
5. **Check Response**: Look for success/error message
6. **Check Logs**: Review `storage/logs/laravel.log`

### **Expected Results**
- ✅ Success: Redirect to `/orders` page
- ✅ Error: Specific error message displayed
- ✅ Logs: Detailed error information in log file

## 🛠 **Debugging Commands**

### **Check Database**
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> Schema::hasTable('orders');
>>> Schema::hasTable('order_items');
>>> Schema::hasTable('produk');
```

### **Check Products**
```bash
php artisan tinker
>>> App\Models\Product::count();
>>> App\Models\Product::first();
```

### **Check Logs**
```bash
tail -f storage/logs/laravel.log
```

## 🎯 **Next Steps**

### **If Error Persists**
1. Check `storage/logs/laravel.log` for specific error
2. Verify database schema matches models
3. Test database connection manually
4. Check if all required fields are present

### **If Error Resolved**
1. Test complete order flow
2. Verify order appears in `/orders` page
3. Check stock reduction worked
4. Test order cancellation

## 📊 **Monitoring**

### **Success Metrics**
- Order creation success rate
- Average response time
- Error frequency by type
- User completion rate

### **Error Tracking**
- Database connection errors
- Validation failures
- Stock insufficiency
- CSRF token issues

## 🚀 **Production Deployment**

### **Pre-Deployment**
- [ ] Test all error scenarios
- [ ] Verify logging is working
- [ ] Check database performance
- [ ] Test with real data

### **Post-Deployment**
- [ ] Monitor error logs
- [ ] Track order success rate
- [ ] Monitor response times
- [ ] User feedback collection

**Sistem sekarang sudah siap untuk debugging yang lebih detail!** 🔍 