<?php 
/** @var array $user */
/** @var bool $isEdit */
require base_path('views/partials/head.php');
$isEdit = isset($user);
?>

<style>
   :root {
      --gold: #B8973A; --gold-lt: #D4AF55; --bg: #FDFAF4; --surface: #F5EFE0;
      --card: #FFFFFF; --border: rgba(184,151,58,.25); --text: #2C2418; --beige-dk: #E8DEC8;
   }
   main { display: flex; justify-content: center; padding: 40px 20px; background: var(--bg); min-height: 100vh; }
   form { width: 100%; max-width: 550px; background: var(--card); padding: 30px; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 8px 25px rgba(0,0,0,0.08); text-align: left; }
   form h2 { color: var(--gold); margin-bottom: 25px; font-size: 28px; }
   form label { display: block; margin-bottom: 8px; color: var(--text); font-weight: 600; }
   form input { width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 10px; background: var(--surface); color: var(--text); font-size: 15px; margin-bottom: 18px; box-sizing: border-box; }
   button { padding: 12px 24px; border: none; border-radius: 10px; font-weight: 600; cursor: pointer; transition: .3s; }
   button[type="submit"] { background: var(--gold); color: white; }
   .btn-cancel { background: var(--beige-dk); color: var(--text); padding: 12px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; display: inline-block; }
</style>

<main>
    <form action="<?= $isEdit ? '/admin/users/edit?id='.$user['id'] : '/admin/users/add' ?>" method="post" enctype="multipart/form-data">    
        <h2><?= $isEdit ? 'Edit User' : 'Add User' ?></h2>
        <?php if (isset($errors['email'])) : ?>
            <p style="color: #E05252; font-weight: bold; margin-bottom: 15px;"><?= $errors['email'] ?></p>
        <?php endif; ?>

        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= $isEdit ? htmlspecialchars($user['name']) : '' ?>" required>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= $isEdit ? htmlspecialchars($user['email']) : '' ?>" required>
        
        <label for="pass">Password <?= $isEdit ? '(Leave blank to keep current)' : '' ?></label>
        <input type="password" id="pass" name="pass" <?= $isEdit ? '' : 'required' ?>>
        
        <label for="Room_No">Room No</label>
        <input type="number" id="Room_No" name="Room_No" min="100" max="300" value="<?= $isEdit ? htmlspecialchars($user['room_no']) : '' ?>" required>
        
        <label for="Ext">Ext</label>
        <input type="number" id="Ext" name="Ext" min="1111" value="<?= $isEdit ? htmlspecialchars($user['ext']) : '' ?>" required>
        
        <label for="picture">Profile Picture</label>
        <?php if ($isEdit && !empty($user['profile_picture'])): ?>
            <div style="margin-bottom: 15px;">
                <img src="/images/<?= htmlspecialchars($user['profile_picture']) ?>" style="width: 80px; height: 80px; border-radius: 10px; object-fit: cover;">
            </div>
        <?php endif; ?>
        <input type="file" id="picture" name="picture" accept="image/*" <?= $isEdit ? '' : 'required' ?>>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit"><?= $isEdit ? 'Update' : 'Save' ?></button>
            <?php if ($isEdit): ?>
                <a href="/admin/users" class="btn-cancel">Cancel</a>
            <?php else: ?>
                <button type="reset" style="background: var(--beige-dk);">Reset</button>
            <?php endif; ?>
        </div>
    </form>
</main>

<?php require base_path('views/partials/footer.php'); ?>
