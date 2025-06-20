
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - Budhi Soya Foods</title>
    <meta name="description" content="Hubungi Budhi Soya Foods untuk pertanyaan, pesanan khusus, atau konsultasi mengenai produk soya berkualitas tinggi kami.">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/contact.css">
</head>
<body>
    <x-navbar></x-navbar>
    
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Hubungi Kami</h1>
            <p>Kami siap membantu Anda dengan pertanyaan, pesanan, atau konsultasi mengenai produk soya berkualitas tinggi kami</p>
            <div class="hero-contact-info">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>+62 123 456 789</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@budhisoya.com</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Senin - Sabtu: 08:00 - 17:00</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Methods Section -->
    <section class="contact-methods">
        <div class="container">
            <h2 class="section-title">Cara Menghubungi Kami</h2>
            
            <div class="methods-grid">
                <div class="method-card">
                    <div class="method-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Telepon</h3>
                    <p>Hubungi kami langsung untuk pertanyaan cepat atau konsultasi</p>
                    <div class="method-info">
                        <strong>+62 123 456 789</strong>
                        <small>Senin - Sabtu: 08:00 - 17:00</small>
                    </div>
                    <a href="tel:+62123456789" class="method-btn">
                        <i class="fas fa-phone"></i>
                        Telepon Sekarang
                    </a>
                </div>
                
                <div class="method-card">
                    <div class="method-icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <h3>WhatsApp</h3>
                    <p>Chat dengan kami melalui WhatsApp untuk respons yang lebih cepat</p>
                    <div class="method-info">
                        <strong>+62 123 456 789</strong>
                        <small>Online 24/7</small>
                    </div>
                    <a href="https://wa.me/62123456789" class="method-btn whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        Chat WhatsApp
                    </a>
                </div>
                
                <div class="method-card">
                    <div class="method-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>Kirim email untuk pertanyaan detail atau permintaan khusus</p>
                    <div class="method-info">
                        <strong>info@budhisoya.com</strong>
                        <small>Respons dalam 24 jam</small>
                    </div>
                    <a href="mailto:info@budhisoya.com" class="method-btn">
                        <i class="fas fa-envelope"></i>
                        Kirim Email
                    </a>
                </div>
                
                <div class="method-card">
                    <div class="method-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Kunjungi Toko</h3>
                    <p>Datang langsung ke toko kami untuk pengalaman berbelanja terbaik</p>
                    <div class="method-info">
                        <strong>Jl. Contoh No. 123</strong>
                        <small>Kota, Provinsi 12345</small>
                    </div>
                    <button class="method-btn" onclick="showMap()">
                        <i class="fas fa-directions"></i>
                        Lihat Peta
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="form-grid">
                <div class="form-content">
                    <h2>Kirim Pesan</h2>
                    <p>Isi formulir di bawah ini dan kami akan menghubungi Anda dalam waktu 24 jam.</p>
                    
                    <form id="contactForm" class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">Nama Depan *</label>
                                <input type="text" id="firstName" name="firstName" required>
                                <span class="error-message" id="firstNameError"></span>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Nama Belakang *</label>
                                <input type="text" id="lastName" name="lastName" required>
                                <span class="error-message" id="lastNameError"></span>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" required>
                                <span class="error-message" id="emailError"></span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Nomor Telepon *</label>
                                <input type="tel" id="phone" name="phone" required>
                                <span class="error-message" id="phoneError"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subjek *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Pilih subjek</option>
                                <option value="produk">Pertanyaan Produk</option>
                                <option value="pesanan">Pesanan Khusus</option>
                                <option value="catering">Layanan Catering</option>
                                <option value="kemitraan">Kemitraan</option>
                                <option value="keluhan">Keluhan/Saran</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                            <span class="error-message" id="subjectError"></span>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Pesan *</label>
                            <textarea id="message" name="message" rows="6" placeholder="Tulis pesan Anda di sini..." required></textarea>
                            <span class="error-message" id="messageError"></span>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="newsletter" name="newsletter">
                                <span class="checkmark"></span>
                                Saya ingin menerima newsletter dan update produk terbaru
                            </label>
                        </div>
                        
                        <div class="form-group checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="privacy" name="privacy" required>
                                <span class="checkmark"></span>
                                Saya setuju dengan <a href="#" class="privacy-link">kebijakan privasi</a> *
                            </label>
                            <span class="error-message" id="privacyError"></span>
                        </div>
                        
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Pesan</span>
                            <div class="loading-spinner" style="display: none;"></div>
                        </button>
                    </form>
                </div>
                
                <div class="form-sidebar">
                    <div class="info-card">
                        <h3>Informasi Kontak</h3>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Alamat</strong>
                                <p>Jl. Contoh No. 123<br>Kota, Provinsi 12345</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Telepon</strong>
                                <p>+62 123 456 789</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <p>info@budhisoya.com</p>
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Jam Operasional</strong>
                                <p>Senin - Sabtu: 08:00 - 17:00<br>Minggu: Tutup</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-card">
                        <h3>Ikuti Kami</h3>
                        <div class="social-links">
                            <a href="#" class="social-link facebook">
                                <i class="fab fa-facebook-f"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="#" class="social-link instagram">
                                <i class="fab fa-instagram"></i>
                                <span>Instagram</span>
                            </a>
                            <a href="#" class="social-link whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <h2 class="section-title">Lokasi Kami</h2>
            <div class="map-container">
                <div class="map-placeholder" id="mapPlaceholder">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="map-info">
                        <h3>Budhi Soya Foods</h3>
                        <p>Jl. Contoh No. 123, Kota, Provinsi 12345</p>
                        <button class="map-btn" onclick="openGoogleMaps()">
                            <i class="fas fa-directions"></i>
                            Buka di Google Maps
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Bagaimana cara memesan produk dalam jumlah besar?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Untuk pemesanan dalam jumlah besar, Anda dapat menghubungi kami melalui WhatsApp atau telepon. Kami menyediakan harga khusus untuk pembelian grosir dan dapat mengatur pengiriman sesuai kebutuhan Anda.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Apakah ada layanan catering untuk acara?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Ya, kami melayani catering untuk berbagai acara seperti pernikahan, aqiqah, khitanan, dan acara lainnya. Hubungi kami untuk konsultasi menu dan harga yang sesuai dengan budget Anda.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Bagaimana cara memastikan produk tetap segar?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Semua produk kami dikemas dengan teknologi terkini untuk menjaga kesegaran. Untuk penyimpanan di rumah, ikuti petunjuk pada kemasan dan simpan di tempat yang sejuk dan kering.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Apakah produk Anda halal dan organik?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Semua produk kami halal dan telah tersertifikasi organik. Kami menggunakan bahan-bahan alami tanpa tambahan pengawet berbahaya dan diproduksi sesuai standar keamanan pangan.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Berapa lama waktu pengiriman?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Untuk area lokal, pengiriman biasanya 1-2 hari kerja. Untuk area luar kota, 3-5 hari kerja tergantung lokasi. Kami akan memberikan nomor resi untuk tracking pengiriman Anda.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question" onclick="toggleFAQ(this)">
                        <span>Apakah ada garansi untuk produk yang rusak?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Kami memberikan garansi 100% untuk produk yang rusak atau tidak sesuai pesanan. Hubungi kami dalam 24 jam setelah pengiriman untuk klaim penggantian atau refund.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <h3>Budhi Soya Foods</h3>
                    <p>Menyediakan produk soya berkualitas tinggi untuk gaya hidup sehat Anda. Dipercaya sejak bertahun-tahun sebagai produsen makanan sehat terbaik.</p>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                
                <div class="footer-col">
                    <h4>Hubungi Kami</h4>
                    <ul>
                        <li><a href="/contact">Formulir Kontak</a></li>
                        <li><a href="tel:+62123456789">Telepon</a></li>
                        <li><a href="mailto:info@budhisoya.com">Email</a></li>
                        <li><a href="https://wa.me/62123456789">WhatsApp</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#">Catering Acara</a></li>
                        <li><a href="#">Pesanan Khusus</a></li>
                        <li><a href="#">Konsultasi Gizi</a></li>
                        <li><a href="#">Delivery Service</a></li>
                    </ul>
                </div>
                
                <div class="footer-col">
                    <h4>Informasi</h4>
                    <div class="footer-contact">
                        <p><i class="fas fa-phone"></i> +62 123 456 789</p>
                        <p><i class="fas fa-envelope"></i> info@budhisoya.com</p>
                        <p><i class="fas fa-map-marker-alt"></i> Jl. Contoh No. 123, Kota</p>
                        <p><i class="fas fa-clock"></i> Senin - Sabtu: 08:00 - 17:00</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 Budhi Soya Foods. Semua hak dilindungi undang-undang.</p>
            </div>
        </div>
    </footer>

    <!-- Success Modal -->
    <div id="successModal" class="modal" style="display: none;">
        <div class="modal-content success">
            <div class="modal-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h3>Pesan Berhasil Dikirim!</h3>
            <p>Terima kasih telah menghubungi kami. Kami akan membalas pesan Anda dalam waktu 24 jam.</p>
            <button class="modal-btn" onclick="closeModal()">
                <i class="fas fa-times"></i>
                Tutup
            </button>
        </div>
    </div>

    <script src="/assets/js/contact.js"></script>
</body>
</html>
