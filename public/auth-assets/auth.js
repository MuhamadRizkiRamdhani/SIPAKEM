// Global variables
const leftPanel = document.querySelector('.panel-left');
const loginWrapper = document.getElementById('loginFormWrapper');
const template = document.getElementById('registrationFormTemplate');
const rightPanelContainer = document.getElementById('rightPanelContent');

let regSection = null;
let activeMode = 'login';
let loginCooldownTimer = null;

// ==================== UTILITY FUNCTIONS ====================

/**
 * Clear semua feedback messages
 */
function clearFeedbacks() {
    const loginFeed = document.getElementById('loginFeedback');
    const regFeed = document.getElementById('registerFeedback');
    if (loginFeed) loginFeed.style.display = 'none';
    if (regFeed) regFeed.style.display = 'none';
}

/**
 * Show feedback message (success atau error)
 */
function showFeedback(element, message, isError = false) {
    if (!element) return;
    element.textContent = message;
    element.style.display = 'block';
    element.classList.remove('error-message', 'success-message');
    element.classList.add(isError ? 'error-message' : 'success-message');
    
    // Auto hide after 4 seconds untuk success, 5 seconds untuk error
    const timeout = isError ? 5000 : 4000;
    setTimeout(() => {
        if (element) element.style.display = 'none';
    }, timeout);
}

function resetButton(button, originalText) {
    if (!button) return;
    button.disabled = false;
    button.innerHTML = originalText;
    button.style.opacity = '1';
    button.style.cursor = 'pointer';
}

function startLoginCooldown(seconds) {
    const submitBtn = document.getElementById('signInBtn');
    const feedback = document.getElementById('loginFeedback');

    if (loginCooldownTimer) {
        clearInterval(loginCooldownTimer);
    }

    const endTime = Date.now() + (seconds * 1000);

    const updateCountdown = () => {
        const remaining = Math.max(0, Math.ceil((endTime - Date.now()) / 1000));

        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<i class="fas fa-clock"></i> ${remaining}s`;
            submitBtn.style.opacity = '0.7';
            submitBtn.style.cursor = 'not-allowed';
        }

        if (feedback) {
            feedback.style.display = 'none';
        }

        if (remaining <= 0) {
            clearInterval(loginCooldownTimer);
            loginCooldownTimer = null;
            if (submitBtn) {
                resetButton(submitBtn, 'Masuk');
            }
        }
    };

    updateCountdown();
    loginCooldownTimer = setInterval(updateCountdown, 1000);
}

/**
 * Validasi input login
 */
function validateLoginForm(username, password) {
    if (!username) return { valid: false, message: 'Username harus diisi' };
    if (username.length < 5) return { valid: false, message: 'Username minimal 5 karakter' };
    if (username.length > 50) return { valid: false, message: 'Username maksimal 50 karakter' };
    if (!/^[a-zA-Z0-9_]+$/.test(username)) return { valid: false, message: 'Username hanya boleh huruf, angka, dan underscore' };
    if (!password) return { valid: false, message: 'Password harus diisi' };
    return { valid: true };
}

/**
 * Validasi input register
 */
function validateRegisterForm(data) {
    // NIM
    if (!data.nim) return { valid: false, message: 'NIM harus diisi' };
    if (!/^\d+$/.test(data.nim)) return { valid: false, message: 'NIM hanya boleh angka' };
    if (data.nim.length < 8) return { valid: false, message: 'NIM minimal 8 digit' };
    if (data.nim.length > 15) return { valid: false, message: 'NIM maksimal 15 digit' };

    // Nama
    if (!data.fullname) return { valid: false, message: 'Nama lengkap harus diisi' };
    if (data.fullname.length < 5) return { valid: false, message: 'Nama minimal 5 karakter' };
    if (data.fullname.length > 50) return { valid: false, message: 'Nama maksimal 50 karakter' };
    if (!/^[a-zA-Z\s.\'\-]+$/.test(data.fullname)) return { valid: false, message: 'Nama hanya boleh huruf, spasi, titik, dan strip' };

    // Username
    if (!data.username) return { valid: false, message: 'Username harus diisi' };
    if (data.username.length < 5) return { valid: false, message: 'Username minimal 5 karakter' };
    if (data.username.length > 50) return { valid: false, message: 'Username maksimal 50 karakter' };
    if (!/^[a-zA-Z0-9_]+$/.test(data.username)) return { valid: false, message: 'Username hanya boleh huruf, angka, dan underscore' };

    // Password
    if (!data.password) return { valid: false, message: 'Password harus diisi' };
    if (data.password.length < 6) return { valid: false, message: 'Password minimal 6 karakter' };
    if (!data.confirmPassword) return { valid: false, message: 'Konfirmasi password harus diisi' };
    if (data.password !== data.confirmPassword) return { valid: false, message: 'Password dan konfirmasi password tidak cocok' };

    // Tahun Angkatan
    if (!data.tahunAngkatan) return { valid: false, message: 'Tahun angkatan harus diisi' };
    if (!/^\d{4}$/.test(data.tahunAngkatan)) return { valid: false, message: 'Tahun angkatan harus 4 digit angka' };
    const tahun = parseInt(data.tahunAngkatan);
    if (tahun < 2000 || tahun > new Date().getFullYear()) return { valid: false, message: `Tahun angkatan harus antara 2000 - ${new Date().getFullYear()}` };

    // Dropdown
    if (!data.fakultasValue) return { valid: false, message: 'Fakultas harus dipilih' };
    if (!data.prodi) return { valid: false, message: 'Program studi harus dipilih' };

    // Radio beasiswa
    if (data.beasiswa === undefined || data.beasiswa === null || data.beasiswa === '') {
        return { valid: false, message: 'Status penerima beasiswa harus dipilih' };
    }

    return { valid: true };
}


// ==================== PASSWORD TOGGLE ====================
document.addEventListener('click', function(e) {
    const toggleBtn = e.target.closest('.password-toggle');
    if (!toggleBtn) return;

    e.preventDefault();
    e.stopPropagation();

    const targetId = toggleBtn.getAttribute('data-target');
    const passwordInput = document.getElementById(targetId);
    const icon = toggleBtn.querySelector('i');

    if (!passwordInput || !icon) return;

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});


// ==================== PROGRAM STUDI DROPDOWN ====================

/**
 * Update dropdown prodi berdasarkan fakultas yang dipilih
 */
function updateProdiDropdown(fakultasValue, prodiSelectElement, hintElement = null) {
    if (!prodiSelectElement) return;

    prodiSelectElement.innerHTML = '';

    if (!fakultasValue || !prodiMap[fakultasValue]) {
        prodiSelectElement.disabled = true;
        prodiSelectElement.innerHTML = '<option value="" disabled selected>-- Pilih Fakultas terlebih dahulu --</option>';
        if (hintElement) hintElement.innerHTML = '';
        return;
    }

    const prodiList = prodiMap[fakultasValue];
    prodiSelectElement.disabled = false;
    prodiSelectElement.innerHTML = '<option value="" disabled selected>-- Pilih Program Studi --</option>';

    prodiList.forEach(prodi => {
        const option = document.createElement('option');
        option.value = prodi.value;
        option.textContent = prodi.label;
        prodiSelectElement.appendChild(option);
    });

    if (hintElement && prodiList.length) {
        hintElement.innerHTML = `✓ Tersedia ${prodiList.length} program studi`;
        hintElement.style.color = "#2c7a4d";
    }
}

/**
 * Initialize registration form
 */
function initRegistrationForm(regFormContainer) {
    const fakultasSelect = regFormContainer.querySelector('#fakultasSelect');
    const prodiSelect = regFormContainer.querySelector('#prodiSelect');
    const hintDiv = regFormContainer.querySelector('#prodiHint');

    if (fakultasSelect && prodiSelect) {
        // Remove old listeners dengan cloning
        const newFakultasSelect = fakultasSelect.cloneNode(true);
        fakultasSelect.parentNode.replaceChild(newFakultasSelect, fakultasSelect);

        const finalFakultasSelect = regFormContainer.querySelector('#fakultasSelect');
        const finalProdiSelect = regFormContainer.querySelector('#prodiSelect');
        const finalHintDiv = regFormContainer.querySelector('#prodiHint');

        // Add change listener
        finalFakultasSelect.addEventListener('change', function(e) {
            updateProdiDropdown(e.target.value, finalProdiSelect, finalHintDiv);
        });

        // Initialize dropdown
        if (finalFakultasSelect.value) {
            updateProdiDropdown(finalFakultasSelect.value, finalProdiSelect, finalHintDiv);
        } else {
            updateProdiDropdown(null, finalProdiSelect, finalHintDiv);
        }
    }
}

// ==================== LOGIN HANDLER ====================

/**
 * Handle login form submission
 */
async function handleLoginSubmit(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('signInBtn');
    const username = document.getElementById('loginUsername')?.value.trim();
    const password = document.getElementById('loginPassword')?.value;
    const feedback = document.getElementById('loginFeedback');

    const validation = validateLoginForm(username, password);
    if (!validation.valid) {
        showFeedback(feedback, validation.message, true);
        return;
    }

    // Disable + loading
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        submitBtn.style.opacity = '0.7';
        submitBtn.style.cursor = 'not-allowed';
    }

    try {
        const response = await fetch('/api/login', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({ username, password })
        });

        const result = await response.json();

        if (response.status === 429 && result.retry_after) {
            startLoginCooldown(result.retry_after);
            return;
        }

        if (response.ok && result.success) {
            showFeedback(feedback, 'Login berhasil! Mengalihkan...', false);
            setTimeout(() => {
                window.location.href = result.redirect;
            }, 1000);
        } else {
            showFeedback(feedback, result.message || 'Login gagal', true);
            resetButton(submitBtn, 'Masuk');
        }
    } catch (err) {
        console.error('Login error:', err);
        showFeedback(feedback, 'Login Gagal', true);
        resetButton(submitBtn, 'Masuk');
    }
}

function attachLoginEvent() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.removeEventListener('submit', handleLoginSubmit);
        loginForm.addEventListener('submit', handleLoginSubmit);
    }
}

// ==================== REGISTER HANDLER ====================

/**
 * Handle register form submission
 */
async function handleRegisterSubmit(e) {
    e.preventDefault();

    const submitBtn = document.getElementById('signUpBtn');
    const nim = document.getElementById('nim')?.value.trim();
    const fullname = document.getElementById('regFullname')?.value.trim();
    const username = document.getElementById('regUsername')?.value.trim();
    const password = document.getElementById('regPassword')?.value;
    const confirmPassword = document.getElementById('regConfirmPassword')?.value;
    
    const fakultasSelectEl = document.getElementById('fakultasSelect');
    const fakultasValue = fakultasSelectEl?.value;
    
    const prodiSelectEl = document.getElementById('prodiSelect');
    const prodi = prodiSelectEl?.value;
    
    const beasiswaRadio = document.querySelector('input[name="statusBeasiswa"]:checked');
    const beasiswa = beasiswaRadio ? beasiswaRadio.value : '';
    const tahunAngkatan = document.getElementById('tahunAngkatan')?.value;
    
    const feedbackReg = document.getElementById('registerFeedback');

    const validation = validateRegisterForm({
        nim, fullname, username, password, confirmPassword,
        fakultasValue, prodi, beasiswa, tahunAngkatan
    });

    if (!validation.valid) {
        showFeedback(feedbackReg, validation.message, true);
        return;
    }

    // Disable + loading
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mendaftarkan...';
        submitBtn.style.opacity = '0.7';
        submitBtn.style.cursor = 'not-allowed';
    }

    try {
        const response = await fetch('/api/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify({
                nim: nim,
                nama_mahasiswa: fullname,
                username: username,
                password: password,
                fakultas: fakultasSelectEl?.options[fakultasSelectEl.selectedIndex]?.text || '',
                prodi: prodi,
                penerima_beasiswa: parseInt(beasiswa),
                tahun_angkatan: parseInt(tahunAngkatan)
            })
        });

        const result = await response.json();

        if (response.ok && result.success) {
            showFeedback(feedbackReg, '✓ Pendaftaran berhasil! Silakan login.', false);
            setTimeout(() => {
                const loginUserField = document.getElementById('loginUsername');
                if (loginUserField) loginUserField.value = result.username;
                showLoginForm();
                const loginFeedback = document.getElementById('loginFeedback');
                if (loginFeedback) showFeedback(loginFeedback, 'Akun berhasil dibuat. Silakan masuk.', false);
            }, 1500);
        } else {
            let errorMessage = 'Registrasi gagal';
            if (result.message) {
                if (typeof result.message === 'object') {
                    const errors = Object.values(result.message);
                    if (errors.length > 0 && Array.isArray(errors[0])) {
                        errorMessage = errors[0][0];
                    } else if (errors.length > 0) {
                        errorMessage = errors[0];
                    }
                } else {
                    errorMessage = result.message;
                }
            }
            showFeedback(feedbackReg, errorMessage, true);
            resetButton(submitBtn, 'Daftar');
        }
    } catch (err) {
        console.error('Register error:', err);
        showFeedback(feedbackReg, 'Registrasi Gagal', true);
        resetButton(submitBtn, 'Daftar');
    }
}

function attachRegisterEvents(regFormElement, containerElement) {
    if (!regFormElement) return;

    const newRegForm = regFormElement.cloneNode(true);
    if (regFormElement.parentNode) {
        regFormElement.parentNode.replaceChild(newRegForm, regFormElement);
    }

    initRegistrationForm(newRegForm.closest('.form-wrapper') || containerElement);

    newRegForm.addEventListener('submit', handleRegisterSubmit);
}

// ==================== UI SWITCHING ====================

/**
 * Show login form
 */
function showLoginForm() {
    if (!loginWrapper) return;
    
    if (regSection && regSection.parentNode === leftPanel) {
        leftPanel.removeChild(regSection);
    }
    
    loginWrapper.style.display = 'block';
    loginWrapper.classList.add('fade-switch');
    setTimeout(() => loginWrapper.classList.remove('fade-switch'), 250);
    
    activeMode = 'login';
    updateRightPanelForLogin();
    clearFeedbacks();
}

/**
 * Show register form
 */
function showRegisterForm() {
    if (!regSection) {
        const cloneDiv = template.cloneNode(true);
        cloneDiv.id = "activeRegForm";
        cloneDiv.style.display = "block";
        const innerWrapper = cloneDiv.firstElementChild;
        regSection = innerWrapper || cloneDiv;
        leftPanel.appendChild(regSection);

        const regForm = regSection.querySelector('#registerForm');
        if (regForm) {
            attachRegisterEvents(regForm, regSection);
        }
    } else {
        if (regSection.parentNode !== leftPanel) {
            leftPanel.appendChild(regSection);
        }
        regSection.style.display = 'block';
        const regFormFresh = regSection.querySelector('#registerForm');
        if (regFormFresh) {
            attachRegisterEvents(regFormFresh, regSection);
        }
    }

    if (loginWrapper) loginWrapper.style.display = 'none';
    if (regSection) regSection.classList.add('fade-switch');
    setTimeout(() => {
        if (regSection) regSection.classList.remove('fade-switch');
    }, 250);

    activeMode = 'register';
    updateRightPanelForRegister();
    clearFeedbacks();
}

/**
 * Update right panel untuk login mode
 */
function updateRightPanelForLogin() {
    rightPanelContainer.innerHTML = `
        <h2>SIPAKEM</h2>
        <p class="sipakem-subtitle">Sistem Informasi Poin Aktivitas & Kredit Mahasiswa</p>
        <div class="welcome-message">
            Belum punya akun? Daftar sekarang!
        </div>
        <button class="btn btn-outline" id="toggleToSignUpBtn">
            <i class="fas fa-user-plus"></i> Daftar
        </button>
    `;
    const newBtn = document.getElementById('toggleToSignUpBtn');
    if (newBtn) {
        newBtn.addEventListener('click', (e) => {
            e.preventDefault();
            showRegisterForm();
        });
    }
}

/**
 * Update right panel untuk register mode
 */
function updateRightPanelForRegister() {
     rightPanelContainer.innerHTML = `
        <h2>SIPAKEM</h2>
        <p class="sipakem-subtitle">SIstem Informasi Poin Aktivitas & Kredit Mahasiswa</p>
        <div class="welcome-message">
            Sudah punya akun? Masuk sekarang!
        </div>
        <button class="btn btn-outline" id="toggleToSignInBtn">
            <i class="fas fa-sign-in-alt"></i> Login
        </button>
    `;
    const signInToggle = document.getElementById('toggleToSignInBtn');
    if (signInToggle) {
        signInToggle.addEventListener('click', (e) => {
            e.preventDefault();
            showLoginForm();
        });
    }
}

// ==================== INITIALIZATION ====================

/**
 * Initialize aplikasi
 */
function init() {
    attachLoginEvent();
    if (regSection && regSection.parentNode) {
        if (regSection.parentNode === leftPanel) leftPanel.removeChild(regSection);
    }
    regSection = null;
    loginWrapper.style.display = 'block';
    updateRightPanelForLogin();
    activeMode = 'login';
    
    const initialToggle = document.getElementById('toggleToSignUpBtn');
    if (initialToggle) {
        initialToggle.addEventListener('click', (e) => {
            e.preventDefault();
            showRegisterForm();
        });
    }

    const tahunInput = document.getElementById('tahunAngkatan');
    if (tahunInput) {
    tahunInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 4);
    });
    }

    const loginUsername = document.getElementById('loginUsername');
    if (loginUsername) {
    loginUsername.addEventListener('input', function () {
        this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '').slice(0, 50);
    });
    }

    const nimInput = document.getElementById('nim');
    if (nimInput) {
        nimInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
    }

    const usernameInput = document.getElementById('regUsername');
    if (usernameInput) {
    usernameInput.addEventListener('input', function () {
        this.value = this.value.replace(/[^a-zA-Z0-9_]/g, '').slice(0, 50);
    });
    }

    const nameInput = document.getElementById('regFullname');
    if (nameInput) {
        nameInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^a-zA-Z\s.\'\-]/g, '').slice(0, 50);
        });
    }
}


// Start aplikasi ketika DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
