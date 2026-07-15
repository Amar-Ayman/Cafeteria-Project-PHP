<?php 
/** @var array $errors */
require base_path('views/partials/head.php');
?>

<style>
    :root {
        --gold: #B8973A;
        --gold-light: #D4AF55;
        --gold-pale: #EDD98A;
        --gold-faint: #F7F0DC;
        --beige: #F5EFE0;
        --beige-dark: #E8DEC8;
        --cream: #FDFAF4;
        --white: #FFFFFF;
        --dark: #1E1A12;
        --text-dark: #2C2418;
        --text-mid: #6B5B3E;
        --text-light: #9E8C6E;
        --shadow: 0 20px 40px rgba(44, 36, 24, 0.12);
        --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    }

    body { 
        margin: 0;
        background: radial-gradient(circle at top right, var(--gold-faint), transparent),
                    radial-gradient(circle at bottom left, var(--beige), transparent),
                    var(--cream);
        background-attachment: fixed;
        color: var(--text-dark);
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

    main { 
        display: flex; justify-content: center; align-items: center; 
        padding: 80px 20px; min-height: 90vh; 
    }

    .form-card {
        width: 100%; max-width: 600px; 
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 50px;
        border-radius: 30px; 
        border: 1px solid rgba(184, 151, 58, 0.2); 
        box-shadow: var(--shadow);
        position: relative;
    }

    .form-card::after {
        content: ""; position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px;
        background: linear-gradient(135deg, var(--gold-pale), transparent, var(--beige-dark));
        z-index: -1; border-radius: 32px;
    }

    .form-header { margin-bottom: 40px; text-align: center; }
    .form-header h2 { 
        color: var(--gold); font-size: 36px; font-weight: 800; margin-bottom: 12px; 
        letter-spacing: -1px;
    }
    .form-header p { color: var(--text-mid); font-size: 16px; font-weight: 500; }

    .form-group { margin-bottom: 25px; }
    .form-group label { 
        display: block; margin-bottom: 10px; color: var(--text-dark); 
        font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; 
    }
    
    .form-control {
        width: 100%; padding: 16px 20px; border: 2px solid var(--beige-dark); border-radius: 15px;
        background: rgba(255, 255, 255, 0.8); color: var(--text-dark); font-size: 16px; 
        transition: var(--transition); box-sizing: border-box;
    }

    .form-control:focus { 
        outline: none; border-color: var(--gold); 
        background: var(--white); box-shadow: 0 10px 20px rgba(184, 151, 58, 0.1);
        transform: translateY(-2px);
    }

    /* Custom File Upload */
    .file-upload-wrapper {
        position: relative; width: 100%; height: 120px;
        border: 2px dashed var(--gold-pale); border-radius: 15px;
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        background: var(--gold-faint); transition: var(--transition); cursor: pointer;
        overflow: hidden;
    }

    .file-upload-wrapper:hover {
        background: var(--white); border-color: var(--gold);
        box-shadow: 0 10px 20px rgba(184, 151, 58, 0.1);
    }

    .file-upload-wrapper i { font-size: 30px; color: var(--gold); margin-bottom: 10px; }
    .file-upload-wrapper span { font-size: 14px; color: var(--text-mid); font-weight: 600; }
    .file-upload-wrapper input[type="file"] {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }

    .grid-row { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }

    .actions { margin-top: 45px; display: flex; gap: 20px; }

    .btn {
        flex: 1; padding: 18px; border: none; border-radius: 15px; font-weight: 800; font-size: 16px;
        cursor: pointer; transition: var(--transition); text-decoration: none; text-align: center;
        text-transform: uppercase; letter-spacing: 1px;
    }

    .btn-primary { 
        background: linear-gradient(135deg, var(--dark), #3a3428); 
        color: var(--gold-pale); 
        box-shadow: 0 10px 20px rgba(0,0,0,0.15); 
    }
    .btn-primary:hover { 
        transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); 
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        color: white;
    }

    .btn-secondary { background: var(--beige-dark); color: var(--text-dark); }
    .btn-secondary:hover { background: var(--beige); transform: translateY(-3px); }

    .error-msg {
        background: #FFF5F5; color: #E05252; padding: 15px; border-radius: 12px;
        border-right: 5px solid #E05252; font-weight: 700; margin-bottom: 25px; font-size: 14px;
        text-align: right;
    }

    @media (max-width: 480px) { .grid-row { grid-template-columns: 1fr; } .actions { flex-direction: column; } }
</style>

<!-- Adding FontAwesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<main>
    <div class="form-card">
        <div class="form-header">
            <h2>New Account</h2>
            <p>Join our premium cafeteria management team</p>
        </div>

        <form action="/admin/users/add" method="post" enctype="multipart/form-data">
            <?php if (isset($errors['email'])) : ?>
                <div class="error-msg">
                    <i class="fas fa-circle-exclamation"></i> <?= $errors['email'] ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="name@cafeteria.com" required>
            </div>

            <div class="form-group">
                <label for="pass">Secure Password</label>
                <input type="password" id="pass" name="pass" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="grid-row">
                <div class="form-group">
                    <label for="Room_No">Room Number</label>
                    <input type="number" id="Room_No" name="Room_No" class="form-control" min="100" max="300" placeholder="101" required>
                </div>
                <div class="form-group">
                    <label for="Ext">Extension</label>
                    <input type="number" id="Ext" name="Ext" class="form-control" min="1111" placeholder="1234" required>
                </div>
            </div>

            <div class="form-group">
                <label>Profile Image</label>
                <div class="file-upload-wrapper">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Click or Drag Image Here</span>
                    <input type="file" id="picture" name="picture" accept="image/*" required onchange="updateFileName(this)">
                    <small id="file-name" style="margin-top: 5px; color: var(--gold); font-weight: bold;"></small>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Create Account</button>
                <a href="/admin/users" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</main>

<script>
    function updateFileName(input) {
        const fileName = input.files[0].name;
        document.getElementById('file-name').textContent = "Selected: " + fileName;
    }
</script>

<?php require base_path('views/partials/footer.php'); ?>