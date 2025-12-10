@extends('admin.layouts.app')

@section('title', 'Change Password | Car 4 Sale')

@section('style')
    <style>
        .password-toggle {
            position: relative;
        }

        .password-toggle .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .password-strength {
            height: 5px;
            margin-top: 5px;
            border-radius: 3px;
        }

        .strength-weak {
            background-color: #dc3545;
            width: 25%;
        }

        .strength-medium {
            background-color: #ffc107;
            width: 50%;
        }

        .strength-strong {
            background-color: #28a745;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="pagetitle">
        <h1>Change Password</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item">Settings</li>
                <li class="breadcrumb-item active">Change Password</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Change Your Password</h5>
                        <p class="text-muted">Please enter your current password and new password to update.</p>

                        @if ($errors->any())
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session::has('success'))
                            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show"
                                role="alert">
                                {{ Session::get('success') }}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (Session::has('error'))
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show"
                                role="alert">
                                {{ Session::get('error') }}
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Change Password Form -->
                        <form class="row g-3" action="{{ route('change.password.update') }}" method="POST"
                            id="changePasswordForm">
                            @csrf
                            @method('PUT')

                            <div class="col-12">
                                <label for="current_password" class="form-label">Current Password <span
                                        class="text-danger">*</span></label>
                                <div class="password-toggle">
                                    <input type="password" class="form-control" id="current_password"
                                        name="current_password" required>
                                    <span class="toggle-password" data-target="current_password">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                                @error('current_password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="new_password" class="form-label">New Password <span
                                        class="text-danger">*</span></label>
                                <div class="password-toggle">
                                    <input type="password" class="form-control" id="new_password" name="new_password"
                                        required>
                                    <span class="toggle-password" data-target="new_password">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                                <div class="password-strength d-none" id="passwordStrength"></div>
                                <small class="form-text text-muted">
                                    Password must be at least 8 characters long and contain at least one uppercase letter,
                                    one lowercase letter, one number, and one special character.
                                </small>
                                @error('new_password')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="new_password_confirmation" class="form-label">Confirm New Password <span
                                        class="text-danger">*</span></label>
                                <div class="password-toggle">
                                    <input type="password" class="form-control" id="new_password_confirmation"
                                        name="new_password_confirmation" required>
                                    <span class="toggle-password" data-target="new_password_confirmation">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                                <div class="mt-2" id="passwordMatch"></div>
                                @error('new_password_confirmation')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">Update Password</button>
                                <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Password Requirements</h5>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success rounded-circle p-1 me-2">
                                <i class="bi bi-check text-white"></i>
                            </div>
                            <span>Minimum 8 characters</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success rounded-circle p-1 me-2">
                                <i class="bi bi-check text-white"></i>
                            </div>
                            <span>At least one uppercase letter</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success rounded-circle p-1 me-2">
                                <i class="bi bi-check text-white"></i>
                            </div>
                            <span>At least one lowercase letter</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success rounded-circle p-1 me-2">
                                <i class="bi bi-check text-white"></i>
                            </div>
                            <span>At least one number</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded-circle p-1 me-2">
                                <i class="bi bi-check text-white"></i>
                            </div>
                            <span>At least one special character</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Security Tips</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bi bi-shield-check text-primary me-2"></i>Never share your
                                password</li>
                            <li class="mb-2"><i class="bi bi-arrow-repeat text-primary me-2"></i>Change password
                                regularly</li>
                            <li class="mb-2"><i class="bi bi-x-circle text-primary me-2"></i>Avoid common passwords</li>
                            <li><i class="bi bi-device-phone text-primary me-2"></i>Use different passwords for different
                                accounts</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            document.querySelectorAll('.toggle-password').forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('bi-eye');
                        icon.classList.add('bi-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('bi-eye-slash');
                        icon.classList.add('bi-eye');
                    }
                });
            });

            // Password strength checker
            const newPasswordInput = document.getElementById('new_password');
            const passwordStrengthDiv = document.getElementById('passwordStrength');

            if (newPasswordInput) {
                newPasswordInput.addEventListener('input', function() {
                    const password = this.value;
                    let strength = 0;

                    // Check password length
                    if (password.length >= 8) strength++;
                    if (password.length >= 12) strength++;

                    // Check for lowercase, uppercase, numbers, special characters
                    if (/[a-z]/.test(password)) strength++;
                    if (/[A-Z]/.test(password)) strength++;
                    if (/[0-9]/.test(password)) strength++;
                    if (/[^A-Za-z0-9]/.test(password)) strength++;

                    // Update strength indicator
                    passwordStrengthDiv.classList.remove('d-none');
                    passwordStrengthDiv.className = 'password-strength';

                    if (password.length === 0) {
                        passwordStrengthDiv.classList.add('d-none');
                    } else if (strength <= 3) {
                        passwordStrengthDiv.classList.add('strength-weak');
                    } else if (strength <= 5) {
                        passwordStrengthDiv.classList.add('strength-medium');
                    } else {
                        passwordStrengthDiv.classList.add('strength-strong');
                    }
                });
            }

            // Password confirmation match checker
            const confirmPasswordInput = document.getElementById('new_password_confirmation');
            const passwordMatchDiv = document.getElementById('passwordMatch');

            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', function() {
                    const newPassword = newPasswordInput.value;
                    const confirmPassword = this.value;

                    if (confirmPassword.length === 0) {
                        passwordMatchDiv.innerHTML = '';
                    } else if (newPassword === confirmPassword) {
                        passwordMatchDiv.innerHTML =
                            '<span class="text-success"><i class="bi bi-check-circle"></i> Passwords match</span>';
                    } else {
                        passwordMatchDiv.innerHTML =
                            '<span class="text-danger"><i class="bi bi-x-circle"></i> Passwords do not match</span>';
                    }
                });
            }

            // Form validation
            const form = document.getElementById('changePasswordForm');
            form.addEventListener('submit', function(e) {
                const newPassword = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;

                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    alert('New password and confirmation password do not match.');
                    return false;
                }

                // Additional validation
                const passwordRegex =
                /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                if (!passwordRegex.test(newPassword)) {
                    e.preventDefault();
                    alert(
                        'Password must contain at least 8 characters, including uppercase, lowercase, number and special character.');
                    return false;
                }
            });
        });
    </script>
@endsection
