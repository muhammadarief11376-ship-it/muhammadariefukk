<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div style="font-size: 48px; margin-bottom: 16px;">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h1><?= APP_NAME ?></h1>
                <p>Silakan login untuk melanjutkan</p>
            </div>
            
            <div class="login-body">
                <?php if (isset($flash) && $flash): ?>
                    <div class="alert alert-<?= $flash['type'] ?>">
                        <i class="fas fa-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-circle' ?>"></i>
                        <?= htmlspecialchars($flash['message']) ?>
                    </div>
                <?php endif; ?>
                
                <div class="login-tabs">
                    <div class="login-tab active" onclick="switchTab('siswa')">
                        <i class="fas fa-user-graduate"></i> Siswa
                    </div>
                    <div class="login-tab" onclick="switchTab('admin')">
                        <i class="fas fa-user-shield"></i> Admin
                    </div>
                </div>
                
                <!-- Form Login Siswa -->
                <form id="form-siswa" class="login-form active" action="<?= BASE_URL ?>index.php?page=login&action=login" method="POST">
                    <input type="hidden" name="user_type" value="siswa">
                    
                    <div class="form-group">
                        <label class="form-label" for="nis">NIS (Nomor Induk Siswa)</label>
                        <input type="number" id="nis" name="nis" class="form-control" placeholder="Masukkan NIS" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password-siswa">Password</label>
                        <input type="password" id="password-siswa" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Login sebagai Siswa
                    </button>
                </form>
                
                <!-- Form Login Admin -->
                <form id="form-admin" class="login-form" action="<?= BASE_URL ?>index.php?page=login&action=login" method="POST">
                    <input type="hidden" name="user_type" value="admin">
                    
                    <div class="form-group">
                        <label class="form-label" for="username">Username</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password-admin">Password</label>
                        <input type="password" id="password-admin" name="password" class="form-control" placeholder="Masukkan password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block btn-lg">
                        <i class="fas fa-sign-in-alt"></i> Login sebagai Admin
                    </button>
                </form>
                
                <div class="mt-3 text-center text-secondary" style="font-size: 13px;">
                    <p class="mb-1"><strong>Demo Akun Siswa:</strong></p>
                    <p class="mb-2">NIS: 2024001 | Password: password</p>
                    <p class="mb-1"><strong>Demo Akun Admin:</strong></p>
                    <p>Username: admin | Password: password</p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function switchTab(type) {
            // Update tabs
            document.querySelectorAll('.login-tab').forEach(tab => tab.classList.remove('active'));
            event.target.closest('.login-tab').classList.add('active');
            
            // Update forms
            document.querySelectorAll('.login-form').forEach(form => form.classList.remove('active'));
            document.getElementById('form-' + type).classList.add('active');
        }
    </script>
</body>
</html>
