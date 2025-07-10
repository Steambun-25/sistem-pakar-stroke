<!-- File: src/views/layouts/footer.php -->
<!-- Konten spesifik halaman berakhir sebelum ini -->
</main> <!-- Ini adalah tag penutup untuk <main> dari header.php -->

<footer class="main-footer">
    <div class="main-container">
        <p>&copy; <?= date('Y') ?> StrokeCare. All Rights Reserved.</p>
    </div>
</footer>

<script>
    // Meneruskan URL dasar ke JavaScript jika diperlukan
    const APP_URL = '<?= APP_URL ?>';
</script>
<script src="<?= asset('app.js') ?>"></script>
</body>
</html>
