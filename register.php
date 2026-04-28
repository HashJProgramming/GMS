<?php
session_start();
if (isset($_SESSION['member_id'])) {
    header('Location: ./member_dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GMS - Register</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Nunito.css">
    <style>
        .step-indicator { display: flex; align-items: center; justify-content: center; gap: 0; margin-bottom: 28px; }
        .step { display: flex; flex-direction: column; align-items: center; gap: 4px; }
        .step-circle { width: 34px; height: 34px; border-radius: 50%; border: 2px solid #dee2e6; background: #fff; color: #aaa; font-size: 13px; font-weight: 700; display: flex; align-items: center; justify-content: center; transition: all 0.3s; }
        .step-circle.active { border-color: #198754; background: #198754; color: #fff; }
        .step-circle.done   { border-color: #198754; background: #198754; color: #fff; }
        .step-label { font-size: 11px; color: #aaa; font-weight: 600; }
        .step-label.active { color: #198754; }
        .step-line { width: 60px; height: 2px; background: #dee2e6; margin-bottom: 18px; transition: background 0.3s; }
        .step-line.done { background: #198754; }
        .form-step { display: none; }
        .form-step.active { display: block; }
        .membership-card { border: 2px solid #dee2e6; border-radius: 12px; padding: 16px; cursor: pointer; transition: all 0.2s; text-align: center; }
        .membership-card:hover { border-color: #198754; background: #f0faf4; }
        .membership-card.selected { border-color: #198754; background: #f0faf4; }
        .membership-card .price { font-size: 22px; font-weight: 700; color: #198754; }
        .membership-card .plan { font-size: 14px; font-weight: 600; color: #333; }
        .membership-card .desc { font-size: 12px; color: #888; margin-top: 4px; }
        .password-strength { height: 4px; border-radius: 2px; margin-top: 6px; transition: all 0.3s; }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md shadow py-3" style="background: var(--bs-primary-text-emphasis);">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="index.php" style="color: var(--bs-body-bg);">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -32 576 576" width="1em" height="1em" fill="currentColor" class="text-success" style="font-size: 36px;">
                    <path d="M173.2 0c-1.8 0-3.5 .7-4.8 2C138.5 32.3 120 74 120 120c0 26.2 6 50.9 16.6 73c-22 2.4-43.8 9.1-64.2 20.5C37.9 232.8 13.3 262.4 .4 296c-.7 1.7-.5 3.7 .5 5.2c2.2 3.7 7.4 4.3 10.6 1.3C64.2 254.3 158 245.1 205 324s-8.1 153.1-77.6 173.2c-4.2 1.2-6.3 5.9-4.1 9.6c1 1.6 2.6 2.7 4.5 3c36.5 5.9 75.2 .1 109.7-19.2c20.4-11.4 37.4-26.5 50.5-43.8c13.1 17.3 30.1 32.4 50.5 43.8c34.5 19.3 73.3 25.2 109.7 19.2c1.9-.3 3.5-1.4 4.5-3c2.2-3.7 .1-8.4-4.1-9.6C379.1 477.1 324 403 371 324s140.7-69.8 193.5-21.4c3.2 2.9 8.4 2.3 10.6-1.3c1-1.6 1.1-3.5 .5-5.2c-12.9-33.6-37.5-63.2-72.1-82.5c-20.4-11.4-42.2-18.1-64.2-20.5C450 170.9 456 146.2 456 120c0-46-18.5-87.7-48.4-118c-1.3-1.3-3-2-4.8-2c-5 0-8.4 5.2-6.7 9.9C421.7 80.5 385.6 176 288 176S154.3 80.5 179.9 9.9c1.7-4.7-1.6-9.9-6.7-9.9zM240 272a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zM181.7 417.6c6.3-11.8 9.8-25.1 8.6-39.8c-19.5-18-34-41.4-41.2-67.8c-12.5-8.1-26.2-11.8-40-12.4c-9-.4-18.1 .6-27.1 2.7c7.8 57.1 38.7 106.8 82.9 139.4c6.8-6.7 12.6-14.1 16.8-22.1zM288 64c-28.8 0-56.3 5.9-81.2 16.5c2 8.3 5 16.2 9 23.5c6.8 12.4 16.7 23.1 30.1 30.3c13.3-4.1 27.5-6.3 42.2-6.3s28.8 2.2 42.2 6.3c13.4-7.2 23.3-17.9 30.1-30.3c4-7.3 7-15.2 9-23.5C344.3 69.9 316.8 64 288 64zM426.9 310c-7.2 26.4-21.7 49.7-41.2 67.8c-1.2 14.7 2.2 28.1 8.6 39.8c4.3 8 10 15.4 16.8 22.1c44.3-32.6 75.2-82.3 82.9-139.4c-9-2.2-18.1-3.1-27.1-2.7c-13.8 .6-27.5 4.4-40 12.4z"></path>
                </svg>
                <span class="mx-3 fw-bold">GMS</span>
            </a>
            <a href="index.php" class="btn btn-outline-light btn-sm">← Back to Login</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-lg border-0 my-5" style="max-width: 620px; margin: auto;">
            <div class="card-body p-5">
                <div class="text-center mb-2">
                    <h4 class="fw-bold text-dark">Create Your Account</h4>
                    <p class="text-muted small">Join the gym and start your fitness journey!</p>
                </div>

                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step">
                        <div class="step-circle active" id="circle-1">1</div>
                        <div class="step-label active" id="label-1">Personal</div>
                    </div>
                    <div class="step-line" id="line-1"></div>
                    <div class="step">
                        <div class="step-circle" id="circle-2">2</div>
                        <div class="step-label" id="label-2">Account</div>
                    </div>
                    <div class="step-line" id="line-2"></div>
                    <div class="step">
                        <div class="step-circle" id="circle-3">3</div>
                        <div class="step-label" id="label-3">Membership</div>
                    </div>
                </div>

                <form id="registerForm" action="functions/register.php" method="POST">

                    <!-- STEP 1: Personal Info -->
                    <div class="form-step active" id="step-1">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="e.g. Juan dela Cruz" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="e.g. 09123456789" maxlength="11" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small">Sex <span class="text-danger">*</span></label>
                                <select class="form-select" name="sex" id="sex" required>
                                    <option value="" disabled selected>Select sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold small">Birthdate <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="e.g. Brgy. San Jose, Imus, Cavite" required>
                        </div>
                        <button type="button" class="btn btn-success w-100" onclick="goToStep(2)">Next: Account Setup →</button>
                    </div>

                    <!-- STEP 2: Account Info -->
                    <div class="form-step" id="step-2">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="e.g. juan@email.com" required>
                            <div class="form-text text-muted">This will be used to login.</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="At least 8 characters" required oninput="checkStrength(this.value)">
                            <div class="password-strength bg-secondary mt-2" id="strength-bar" style="width:0%"></div>
                            <div class="form-text" id="strength-text"></div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold small">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Re-enter password" required>
                            <div class="form-text text-danger d-none" id="pass-mismatch">Passwords do not match.</div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary w-50" onclick="goToStep(1)">← Back</button>
                            <button type="button" class="btn btn-success w-50" onclick="goToStep(3)">Next: Membership →</button>
                        </div>
                    </div>

                    <!-- STEP 3: Membership Type -->
                    <div class="form-step" id="step-3">
                        <p class="fw-semibold small mb-3">Choose your membership plan: <span class="text-danger">*</span></p>
                        <input type="hidden" name="type" id="membership-type" required>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="membership-card" onclick="selectPlan(this, 'Monthly')">
                                    <div class="plan">Monthly</div>
                                    <div class="price">₱500</div>
                                    <div class="desc">30 days access</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="membership-card" onclick="selectPlan(this, 'Quarterly')">
                                    <div class="plan">Quarterly</div>
                                    <div class="price">₱1,300</div>
                                    <div class="desc">90 days access</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="membership-card" onclick="selectPlan(this, 'Annual')">
                                    <div class="plan">Annual</div>
                                    <div class="price">₱4,800</div>
                                    <div class="desc">365 days access</div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary w-50" onclick="goToStep(2)">← Back</button>
                            <button type="submit" class="btn btn-success w-50" id="submit-btn" disabled>Register Now ✓</button>
                        </div>
                        <p class="text-center text-muted small mt-3">Already have an account? <a href="index.php" class="text-success fw-bold">Login here</a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>

    <script>
        function goToStep(step) {
            // Validate step 1
            if (step === 2) {
                const fields = ['fullname','phone','sex','birthdate','address'];
                for (let f of fields) {
                    if (!document.getElementById(f).value.trim()) {
                        swal("Incomplete!", "Please fill in all personal information.", "warning");
                        return;
                    }
                }
            }
            // Validate step 2
            if (step === 3) {
                const email = document.getElementById('email').value.trim();
                const pass  = document.getElementById('password').value;
                const conf  = document.getElementById('confirm_password').value;
                if (!email || !pass) {
                    swal("Incomplete!", "Please fill in your email and password.", "warning");
                    return;
                }
                if (pass.length < 8) {
                    swal("Weak Password!", "Password must be at least 8 characters.", "warning");
                    return;
                }
                if (pass !== conf) {
                    document.getElementById('pass-mismatch').classList.remove('d-none');
                    return;
                }
                document.getElementById('pass-mismatch').classList.add('d-none');
            }

            // Hide all steps
            document.querySelectorAll('.form-step').forEach(s => s.classList.remove('active'));
            document.getElementById('step-' + step).classList.add('active');

            // Update indicators
            for (let i = 1; i <= 3; i++) {
                const circle = document.getElementById('circle-' + i);
                const label  = document.getElementById('label-' + i);
                circle.classList.remove('active','done');
                label.classList.remove('active');
                if (i < step)       { circle.classList.add('done'); }
                else if (i === step){ circle.classList.add('active'); label.classList.add('active'); }
            }
            for (let i = 1; i <= 2; i++) {
                const line = document.getElementById('line-' + i);
                line.classList.toggle('done', i < step);
            }
        }

        function selectPlan(el, plan) {
            document.querySelectorAll('.membership-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            document.getElementById('membership-type').value = plan;
            document.getElementById('submit-btn').disabled = false;
        }

        function checkStrength(val) {
            const bar  = document.getElementById('strength-bar');
            const text = document.getElementById('strength-text');
            let strength = 0;
            if (val.length >= 8) strength++;
            if (/[A-Z]/.test(val)) strength++;
            if (/[0-9]/.test(val)) strength++;
            if (/[^A-Za-z0-9]/.test(val)) strength++;
            const levels = [
                { w:'25%', bg:'bg-danger',  t:'Weak',      tc:'text-danger'  },
                { w:'50%', bg:'bg-warning', t:'Fair',      tc:'text-warning' },
                { w:'75%', bg:'bg-info',    t:'Good',      tc:'text-info'    },
                { w:'100%',bg:'bg-success', t:'Strong',    tc:'text-success' },
            ];
            if (val.length === 0) { bar.style.width='0%'; text.textContent=''; return; }
            const lvl = levels[strength - 1] || levels[0];
            bar.style.width = lvl.w;
            bar.className   = 'password-strength mt-2 ' + lvl.bg;
            text.className  = 'form-text ' + lvl.tc;
            text.textContent = lvl.t;
        }

        // SweetAlert for success/error from PHP redirect
        const urlParams = new URLSearchParams(window.location.search);
        const type      = urlParams.get('type');
        const message   = urlParams.get('message');
        if (type === 'success') swal("Success!", message, "success");
        else if (type === 'error') swal("Error!", message, "error");
    </script>
</body>
</html>