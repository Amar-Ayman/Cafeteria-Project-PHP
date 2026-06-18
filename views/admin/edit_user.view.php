<?php 
/** @var array $user */
require base_path('views/partials/head.php') ?>

<style>
   :root {
      --gold: #B8973A;
      --bg: #FDFAF4;
      --card: #FFFFFF;
      --border: rgba(184,151,58,.25);
      --text: #2C2418;
   }
   main { display: flex; justify-content: center; padding: 40px 20px; background: var(--bg); min-height: 100vh; }
   form { width: 100%; max-width: 550px; background: var(--card); padding: 30px; border-radius: 16px; border: 1px solid var(--border); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
   form h2 { color: var(--gold); margin-bottom: 25px; font-size: 28px; }
   form label { display: block; margin-bottom: 8px; color: var(--text); font-weight: 600; }
   form input { width: 100%; padding: 12px 14px; border: 1px solid var(--border); border-radius: 10px; font-size: 15px; margin-bottom: 20px; box-sizing: border-box; }
   button { padding: 12px 25px; border: none; border-radius: 10px; cursor: pointer; font-weight: 600; background: var(--gold); color: white; }
   .btn-cancel { background: #E8DEC8; color: var(--text); text-decoration: none; padding: 12px 25px; border-radius: 10px; display: inline-block; font-size: 14px; font-weight: 600; }
</style>

<main>
    <form action="/admin/users/edit?id=<?= $user['id'] ?>" method="post" enctype="multipart/form-data">  
        <h2>Edit User: <?= htmlspecialchars($user['name']) ?></h2>
        
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <label for="pass">Password (Leave blank to keep current)</label>
        <input type="password" id="pass" name="pass" placeholder="New Password">

        <label for="Room_No">Room No</label>
        <input type="text" id="Room_No" name="Room_No" value="<?= htmlspecialchars($user['room_no']) ?>">

        <label for="Ext">Ext</label>
        <input type="text" id="Ext" name="Ext" value="<?= htmlspecialchars($user['ext']) ?>">

        <label>Current Picture</label>
        <img src="/images/<?= htmlspecialchars($user['profile_picture']) ?>" width="80" style="display: block; margin-bottom: 10px; border-radius: 50%;">

        <label for="picture">Change Picture</label>
        <input type="file" id="picture" name="picture">

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit">Update User</button>
            <a href="/admin/users" class="btn-cancel">Cancel</a>
        </div>
    </form>
</main>

<?php require base_path('views/partials/footer.php') ?>
