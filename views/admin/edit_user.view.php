<?php 
/** @var array $user */
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
        background: radial-gradient(circle at top left, var(--gold-faint), transparent),
                    radial-gradient(circle at bottom right, var(--beige), transparent),
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

    .form-header { margin-bottom: 40px; text-align: center; }
    .form-header h2 { 
        color: var(--gold); font-size: 36px; font-weight: 800; margin-bottom: 12px; 
    }
    
    .current-profile {
        display: flex; flex-direction: column; align-items: center; margin-bottom: 30px;
    }
    .current-profile img {
        width: 100px; height: 100px; border-radius: 50%; object-fit: cover;
        border: 4px solid var(--white); box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        margin-bottom: 10px;
    }
    .current-profile span { font-size: 14px; color: var(--text-mid); font-weight: 600; }

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
        background: var(--white); transform: translateY(-2px);
    }

    /* Custom File Upload */
    .file-upload-wrapper {
        position: relative; width: 100%; height: 100px;
        border: 2px dashed var(--gold-pale); border-radius: 15px;
        display: flex; flex-direction: column; justify-content: center; align-items: center;
        background: var(--gold-faint); transition: var(--transition); cursor: pointer;
    }

    .file-upload-wrapper:hover { background: var(--white); border-color: var(--gold); }
    .file-upload-wrapper i { font-size: 24px; color: var(--gold); margin-bottom: 5px; }
    .file-upload-wrapper input[type="file"] {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        opacity: 0; cursor: pointer;
    }

    .grid-row { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }

    .actions { margin-top: 45px; display: flex; gap: 20px; }

    .btn {
        flex: 1; padding: 18px; border: none; border-radius: 15px; font-weight: 800; font-size: 16px;
        cursor: pointer; transition: var(--transition); text-decoration: none; text-align: center;
        text-transform: uppercase;
    }

    .btn-primary { 
        background: linear-gradient(135deg, var(--dark), #3a3428); 
        color: var(--gold-pale); 
    }
    .btn-primary:hover { 
        transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); 
        background: var(--gold); color: white;
    }

    .btn-secondary { background: var(--beige-dark); color: var(--text-dark); }
    .btn-secondary:hover { background: var(--beige); transform: translateY(-3px); }

    .help-text { font-size: 12px; color: var(--text-light); margin-top: 8px; font-style: italic; }

    @media (max-width: 480px) { .grid-row { grid-template-columns: 1fr; } .actions { flex-direction: column; } }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<main>
    <div class="form-card">
        <div class="form-header">
            <h2>Edit Profile</h2>
        </div>

        <div class="current-profile">
            <img src="/images/<?= htmlspecialchars($user['profile_picture']) ?>" alt="User">
            <span>Currently: <?= htmlspecialchars($user['name']) ?></span>
        </div>

        <form action="/admin/users/edit?id=<?= $user['id'] ?>" method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
            </div>

            <div class="form-group">
                <label for="pass">New Password</label>
                <input type="password" id="pass" name="pass" class="form-control" placeholder="••••••••">
                <p class="help-text"><i class="fas fa-info-circle"></i> Leave blank to keep current password</p>
            </div>

            <div class="grid-row">
                <div class="form-group">
                    <label for="Room_No">Room No</label>
                    <input type="text" id="Room_No" name="Room_No" class="form-control" value="<?= htmlspecialchars($user['room_no']) ?>">
                </div>
                <div class="form-group">
                    <label for="Ext">Extension</label>
                    <input type="text" id="Ext" name="Ext" class="form-control" value="<?= htmlspecialchars($user['ext']) ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Update Profile Picture</label>
                <div class="file-upload-wrapper">
                    <i class="fas fa-image"></i>
                    <span>Choose New Image</span>
                    <input type="file" id="picture" name="picture" accept="image/*" onchange="updateFileName(this)">
                    <small id="file-name" style="margin-top: 5px; color: var(--gold); font-weight: bold;"></small>
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="/admin/users" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</main>

<script>
    function updateFileName(input) {
        if(input.files.length > 0) {
            const fileName = input.files[0].name;
            document.getElementById('file-name').textContent = "Selected: " + fileName;
        }
    }
</script>