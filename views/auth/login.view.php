<?php 
$header = "Login";
require base_path("views/partials/head.php");  
?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --gold: #B8973A;
        --gold-light: #D4AF55;
        --gold-pale: #EDD98A;
        --gold-faint: #F7F0DC;
        --beige: #F5EFE0;
        --beige-dark: #E8DEC8;
        --cream: #FDFAF4;
        --champagne: #FFF8F0;
        --champagne-warm: #FFF4E6;
        --white: #FFFFFF;
        --dark: #1E1A12;
        --text-dark: #2C2418;
        --text-mid: #6B5B3E;
    }

    html, body {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    body {
        background: var(--champagne);
        font-family: 'Segoe UI', Roboto, sans-serif;
        color: var(--text-dark);
    }

    /* ============================================
       CHAMPAGNE LUXURY BACKGROUND
       ============================================ */

    .champagne-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 20% 30%, var(--gold-pale) 0%, transparent 40%),
            radial-gradient(circle at 80% 70%, var(--beige) 0%, transparent 40%),
            radial-gradient(circle at 50% 50%, var(--champagne-warm) 0%, transparent 60%),
            linear-gradient(135deg, #FFF8F0 0%, #FFF4E6 50%, #FDFAF4 100%);
        background-size: 200% 200%;
        animation: champagneFlow 18s ease-in-out infinite;
        z-index: -2;
    }

    @keyframes champagneFlow {
        0%, 100% { 
            background-position: 0% 0%;
        }
        50% { 
            background-position: 100% 100%;
        }
    }

    /* Warm light overlay */
    .champagne-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: 
            radial-gradient(circle at 15% 20%, rgba(184, 151, 58, 0.12) 0%, transparent 40%),
            radial-gradient(circle at 85% 75%, rgba(212, 175, 55, 0.08) 0%, transparent 45%),
            radial-gradient(circle at 50% 50%, rgba(184, 151, 58, 0.06) 0%, transparent 50%);
        animation: warmGlow 22s ease-in-out infinite;
        z-index: 1;
    }

    @keyframes warmGlow {
        0%, 100% { 
            transform: translate(0, 0);
            opacity: 0.7;
        }
        50% { 
            transform: translate(30px, -30px);
            opacity: 0.9;
        }
    }

    /* ============================================
       LOGIN CONTAINER
       ============================================ */

    .login-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 10;
    }

    .login-container {
        position: relative;
        width: 100%;
        max-width: 540px;
        perspective: 1200px;
    }

    /* ============================================
       FROSTED GLASS CARD - CHAMPAGNE LUXURY
       ============================================ */

    .login-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 2px solid rgba(184, 151, 58, 0.3);
        border-radius: 35px;
        padding: 70px;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.08),
            inset 0 1px 1px rgba(255, 255, 255, 0.6),
            inset 0 -1px 1px rgba(0, 0, 0, 0.05),
            0 0 50px rgba(184, 151, 58, 0.12);
        position: relative;
        overflow: hidden;
        animation: cardFloat 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes cardFloat {
        0% {
            opacity: 0;
            transform: translateY(50px) scale(0.9);
        }
        100% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Animated golden border glow */
    .login-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: conic-gradient(
            from 0deg,
            rgba(184, 151, 58, 0.25),
            rgba(212, 175, 55, 0.15),
            rgba(184, 151, 58, 0.25)
        );
        animation: goldenBorder 5s linear infinite;
        z-index: -1;
        opacity: 0.5;
    }

    @keyframes goldenBorder {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Top accent line */
    .login-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--gold), var(--gold-light), var(--gold));
        background-size: 200% 100%;
        animation: accentShine 3s ease-in-out infinite;
        border-radius: 35px 35px 0 0;
    }

    @keyframes accentShine {
        0%, 100% { background-position: 0% 0%; }
        50% { background-position: 100% 0%; }
    }

    /* ============================================
       HEADER
       ============================================ */

    .login-header {
        text-align: center;
        margin-bottom: 50px;
        animation: fadeInDown 0.8s ease-out 0.2s both;
    }

    .login-header h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3.8rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 50%, #A67C52 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 12px;
        letter-spacing: -1px;
    }

    .login-header p {
        font-size: 1.05rem;
        color: var(--text-mid);
        font-weight: 400;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ============================================
       FORM ELEMENTS
       ============================================ */

    .form-group {
        margin-bottom: 30px;
        animation: fadeInUp 0.8s ease-out both;
    }

    .form-group:nth-child(1) { animation-delay: 0.3s; }
    .form-group:nth-child(2) { animation-delay: 0.4s; }
    .form-group:nth-child(3) { animation-delay: 0.5s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .form-input {
        width: 100%;
        padding: 16px 22px;
        background: rgba(255, 255, 255, 0.5);
        border: 2px solid var(--beige-dark);
        border-radius: 15px;
        font-family: 'Jost', sans-serif;
        font-size: 1rem;
        color: var(--text-dark);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        backdrop-filter: blur(15px);
    }

    .form-input::placeholder {
        color: var(--text-mid);
        opacity: 0.5;
    }

    .form-input:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.8);
        border-color: var(--gold);
        box-shadow: 
            0 0 0 4px rgba(184, 151, 58, 0.2),
            inset 0 0 20px rgba(184, 151, 58, 0.08);
        transform: translateY(-2px);
    }

    /* ============================================
       BUTTONS
       ============================================ */

    .btn-login {
        width: 100%;
        padding: 18px 24px;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 50%, #A67C52 100%);
        color: var(--white);
        border: none;
        border-radius: 15px;
        font-size: 1.05rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 35px rgba(184, 151, 58, 0.3);
    }

    .btn-login::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
        transition: left 0.6s ease;
    }

    .btn-login:hover::before {
        left: 100%;
    }

    .btn-login:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 45px rgba(184, 151, 58, 0.4);
    }

    .btn-login:active {
        transform: translateY(-1px);
    }

    /* ============================================
       ERROR & SUCCESS MESSAGES
       ============================================ */

    .error-msg {
        color: #d93025;
        font-size: 0.85rem;
        margin-top: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* ============================================
       FOOTER LINK
       ============================================ */

    .login-footer {
        text-align: center;
        margin-top: 45px;
        padding-top: 30px;
        border-top: 1px solid rgba(184, 151, 58, 0.2);
        animation: fadeInUp 0.8s ease-out 0.6s both;
    }

    .login-footer p {
        color: var(--text-mid);
        font-size: 0.95rem;
    }

    .login-link {
        color: var(--gold);
        text-decoration: none;
        font-weight: 700;
        transition: all 0.3s ease;
        position: relative;
    }

    .login-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gold);
        transition: width 0.3s ease;
    }

    .login-link:hover::after {
        width: 100%;
    }

    .login-link:hover {
        color: var(--gold-light);
    }

    /* ============================================
       RESPONSIVE DESIGN
       ============================================ */

    @media (max-width: 600px) {
        .login-card {
            padding: 45px 30px;
        }

        .login-header h1 {
            font-size: 2.8rem;
        }

        .login-header p {
            font-size: 0.9rem;
        }

        .form-input {
            padding: 14px 16px;
            font-size: 0.95rem;
        }

        .btn-login {
            padding: 16px 20px;
            font-size: 1rem;
        }
    }

    @media (max-width: 400px) {
        .login-wrapper {
            padding: 15px;
        }

        .login-card {
            padding: 35px 20px;
            border-radius: 25px;
        }

        .login-header h1 {
            font-size: 2.2rem;
        }

        .login-header p {
            font-size: 0.85rem;
            letter-spacing: 1px;
        }
    }
</style>

<div class="champagne-bg"></div>

<div class="login-wrapper">
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h1>SERENO</h1>
                <p>Premium Café Management</p>
            </div>

            <form action="/login" method="POST">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="your@email.com" 
                        required 
                        value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                    <?php if (isset($errors["email"])) : ?>
                        <div class="error-msg">
                            <span>✕</span>
                            <?= $errors["email"] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="••••••••" 
                        required>
                    <?php if (isset($errors["password"])) : ?>
                        <div class="error-msg">
                            <span>✕</span>
                            <?= $errors["password"] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-login">
                    Sign In
                </button>
            </form>

            <div class="login-footer">
                <p>Forgot your password? <a href="/forget_password" class="login-link">Reset it here</a></p>
            </div>
        </div>
    </div>
</div>

