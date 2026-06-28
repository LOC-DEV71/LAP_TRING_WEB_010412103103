</div> <!-- Kết thúc .admin-layout -->
<script src="<?= asset('js/admin/admin.js') ?>?v=<?= time() ?>"></script>

<?php if (isset($_SESSION['toast'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            showToast("<?= htmlspecialchars($_SESSION['toast']['message']) ?>", "<?= htmlspecialchars($_SESSION['toast']['type']) ?>");
        });
    </script>
    <?php unset($_SESSION['toast']); ?>
<?php endif; ?>

</body>
</html>
