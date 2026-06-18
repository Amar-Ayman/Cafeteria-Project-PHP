<?php 
$header = "Reset Password";
require base_path("views/partials/head.php"); 
require base_path("views/partials/nav.php"); 
require base_path("views/partials/header.php"); 
?>

<!-- Custom CSS to fix container conflict for auth pages -->
<style>
    /* Force full width and center alignment by overriding the default container in header.php */
    main .container.py-6 {
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;

        .auth-container {
    min-height: calc(100vh - 400px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: radial-gradient(circle at top right, var(--gold-faint), transparent),
                radial-gradient(circle at bottom left, var(--beige), transparent);
}

.auth-card {
    background: var(--white);
    width: 100%;
    max-width: 450px;
    padding: 50px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(44, 36, 24, 0.1);
    border: 1px solid var(--gold-pale);
    position: relative;
    overflow: hidden;
}

.auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
}

.auth-header {
    text-align: center;
    margin-bottom: 40px;
}

.auth-header h2 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 2.5rem;
    color: var(--text-dark);
    margin-bottom: 10px;
}

.auth-header p {
    color: var(--text-light);
    font-size: 1rem;
}

.form-group {
    margin-bottom: 25px;
    position: relative;
}

.form-label {
    display: block;
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text-mid);
    margin-bottom: 8px;
    transition: 0.3s;
}

.form-input {
    width: 100%;
    padding: 15px 20px;
    background-color: var(--cream);
    border: 1px solid var(--beige-dark);
    border-radius: 12px;
    font-family: 'Jost', sans-serif;
    font-size: 1rem;
    color: var(--text-dark);
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--gold);
    background-color: var(--white);
    box-shadow: 0 0 0 4px var(--gold-faint);
}

.form-input::placeholder {
    color: var(--text-light);
    opacity: 0.6;
}

.btn-auth {
    width: 100%;
    padding: 16px;
    background-color: var(--dark);
    color: var(--white);
    border: none;
    border-radius: 12px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-auth:hover {
    background-color: var(--gold);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(184, 151, 58, 0.2);
}

.btn-auth:active {
    transform: translateY(0);
}

.auth-footer {
    text-align: center;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 1px solid var(--gold-faint);
}

.auth-link {
    color: var(--gold);
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: 0.3s;
}

.auth-link:hover {
    color: var(--text-dark);
    text-decoration: underline;
}

.error-msg {
    color: #d93025;
    font-size: 0.85rem;
    margin-top: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.success-banner {
    background-color: #e6f4ea;
    color: #1e7e34;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 25px;
    font-size: 0.95rem;
    border-left: 4px solid #1e7e34;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.auth-card {
    animation: fadeIn 0.8s ease-out;
}

    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Recover Access</h2>
            <p>Enter your email to receive reset instructions</p>
        </div>

        <form action="/forget_password" method="POST">
            <?php if (isset($success) && !empty($success)) : ?>
                <div class="success-banner">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span><?= $success ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-input" placeholder="name@example.com" required value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                <?php if (isset($errors["email"])) : ?>
                    <div class="error-msg">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <?= $errors["email"] ?>
                    </div>
                <?php endif; ?>
            </div>

            <button type="submit" class="btn-auth">
                <span>Send Reset Link</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            </button>
        </form>

        <div class="auth-footer">
            <a href="/login" class="auth-link">
                <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span>Back to Login</span>
                </div>
            </a>
        </div>
    </div>
</div>

<?php require base_path("views/partials/footer.php"); ?>
