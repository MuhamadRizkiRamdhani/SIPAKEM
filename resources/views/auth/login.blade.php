<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPAKEM</title>
    <!-- Google Fonts & Simple Icons (Font Awesome) -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('auth-assets/auth.css') }}">
</head>

<body>
    <div class="container" id="mainContainer">
        <!-- LEFT PANEL: LOGIN FORM (default visible) -->
        <div class="panel panel-left">
            <div class="form-wrapper" id="loginFormWrapper">
                <h2>Login</h2>
                <form id="loginForm">
                    <div class="form-group">
                        <i class="fas fa-user"></i>
                        <!-- BACKEND: username / email -->
                        <input type="text" id="loginUsername" placeholder="Username" required autocomplete="username">
                    </div>
                    <div class="form-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="loginPassword" placeholder="Password" required
                            autocomplete="current-password">
                    </div>
                    <button type="submit" class="btn" id="signInBtn">Masuk</button>
                    <div id="loginFeedback" class="demo-message" style="display: none;"></div>
                </form>
            </div>
        </div>

        <!-- RIGHT PANEL: WELCOME + DAFTAR -->
        <div class="panel panel-right">
            <div id="rightPanelContent">
                <h2>SIPAKEM</h2>
                <div class="welcome-message">
                    Belum punya akun? Daftar sekarang!
                </div>
                <button class="btn btn-outline" id="toggleToSignUpBtn">
                    <i class="fas fa-user-plus"></i> Daftar
                </button>
            </div>
        </div>
    </div>

    <!-- TEMPLATE FORM REGISTRASI dengan Dropdown Fakultas & Prodi dinamis -->
    <div style="display: none;" id="registrationFormTemplate">
        <div class="form-wrapper" id="regFormWrapper">
            <h2>Buat Akun</h2>
            <form id="registerForm">
                <!-- NIM -->
                <div class="form-group">
                    <i class="fas fa-id-card"></i>
                    <input type="text" name="nim" id="nim" class="form-control" placeholder="NIM" required>
                </div>
                <!-- Nama Mahasiswa -->
                <div class="form-group">
                    <i class="fas fa-user"></i>
                    <input type="text" id="regFullname" placeholder="Nama Mahasiswa" required autocomplete="name">
                </div>
                <!-- Username -->
                <div class="form-group">
                    <i class="fas fa-envelope"></i>
                    <input type="text" id="regUsername" placeholder="Username" required autocomplete="username">
                </div>
                <!-- Password -->
                <div class="form-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="regPassword" placeholder="Password" required autocomplete="new-password">
                </div>
                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <i class="fas fa-check-circle"></i>
                    <input type="password" id="regConfirmPassword" placeholder="Konfirmasi Password" required
                        autocomplete="new-password">
                </div>

                <!-- FAKULTAS (Dropdown) -->
                <div class="form-group has-label">
                    <label for="fakultasSelect">Fakultas <span style="color:#e53e3e;">*</span></label>
                    <select id="fakultasSelect" required>
                        <!-- panggil dari database -->
                    </select>
                </div>

                <!-- PROGRAM STUDI (Dropdown dinamis) -->
                <div class="form-group has-label">
                    <label for="prodiSelect">Program Studi <span style="color:#e53e3e;">*</span></label>
                    <select id="prodiSelect" required disabled>
                        <option value="" disabled selected>-- Pilih Fakultas terlebih dahulu --</option>
                        <!-- panggil dari database -->
                    </select>
                    <div class="info-hint" id="prodiHint"></div>
                </div>

                <!-- Status Beasiswa Radio -->
                <div class="form-group has-label">
                    <label>Status Beasiswa</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="statusBeasiswa" value="1" required> Penerima Beasiswa
                        </label>
                        <label>
                            <input type="radio" name="statusBeasiswa" value="0" required> Bukan Penerima Beasiswa
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn" id="signUpBtn">Daftar</button>
                <div id="registerFeedback" class="demo-message" style="display: none;"></div>
            </form>
        </div>
    </div>
    <script src="{{ asset('auth-assets/auth.js') }}"></script>

    <!-- Script untuk populate Fakultas dan Prodi Data -->
    <script>
        // Mapping antara ID Fakultas dengan list Prodi
        const prodiMap = @json($prodiMap ?? []);

        // Script untuk populate dropdown fakultas saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            const fakultasSelect = document.getElementById('fakultasSelect');
            const allFakultasData = @json($fakultasData ?? []);

            if (fakultasSelect && allFakultasData.length > 0) {
                fakultasSelect.innerHTML = '<option value="" disabled selected>-- Pilih Fakultas --</option>';
                allFakultasData.forEach(fakultas => {
                    const option = document.createElement('option');
                    option.value = fakultas.id;
                    option.textContent = fakultas.nama;
                    fakultasSelect.appendChild(option);
                });
            }
        });
    </script>
</body>

</html>