<?php 
/** @var array $users */
require base_path('views/partials/head.php');
require base_path('views/partials/nav.php');
?>
<style>
   :root {
      --gold: #B8973A; --gold-lt: #D4AF55; --bg: #FDFAF4; --surface: #F5EFE0;
      --card: #FFFFFF; --border: rgba(184,151,58,.25); --border-lt: rgba(184,151,58,.12);
      --text: #2C2418; --muted: #6B5B3E; --white: #FFFFFF; --dark: #1E1A12;
      --text-mid: #6B5B3E; --text-light: #9E8C6E;
   }
   .user-continer { display: flex; justify-content: center; align-items: center; position: relative; margin: 30px 30px; }
   .users-header { color: var(--text-mid); font-size: 30px; text-transform: uppercase; }
   .add-user { position: absolute; right: 50px; }
   .bnt-add { background: var(--gold); color: white; padding: 10px 15px; border-radius: 10px; text-decoration: none; font-weight: bold; }
   .bnt-add:hover { box-shadow: 0 4px 10px var(--dark); }
   .user-table { border-collapse: collapse; background-color: var(--white); width: 90%; margin: 40px auto; border: 2px solid var(--gold); direction: ltr; }
   .user-table th { background-color: var(--surface); color: var(--text-mid); padding: 15px 20px; border-bottom: 2px solid var(--gold); text-align: center; font-weight: bold; font-size: 18px; }
   .user-table td { padding: 15px 20px; border-bottom: 1px solid var(--border-lt); text-align: center; font-weight: bold; font-size: 18px; }
   .user-table tbody tr:hover { background-color: rgba(184, 151, 58, 0.03); }
   .user-table img { border-radius: 12px; object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1); transition: transform 0.2s ease; }
   .user-table img:hover { transform: scale(1.08); }
   .edit { background-color: #277bd4; color: white; display: inline-block; width: 80px; padding: 5px 0; border-radius: 15px; text-decoration: none; font-size: 16px; }
   .delete { background-color: #ca3535; color: white; display: inline-block; width: 80px; padding: 5px 0; border-radius: 15px; text-decoration: none; font-size: 16px; }
</style>

<main>
    <div class="user-continer">
        <h1 class="users-header">All users <hr></h1> 
        <div class="add-user"><a href="/admin/users/add" class="bnt-add">Add user</a></div>
    </div>
    <table class="user-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Room</th>
                <th>Image</th>
                <th>Ext</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user) : ?>
            <tr>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['room_no']) ?></td>
                <td>
                    <img src="/images/<?= htmlspecialchars($user['profile_picture']) ?>" width="60" height="60" alt="<?= htmlspecialchars($user['name']) ?>">
                </td>
                <td><?= htmlspecialchars($user['ext']) ?></td>
                <td>
                    <a class="edit" href="/admin/users/edit?id=<?= $user['id']; ?>">Edit</a> 
                    <a class="delete" href="/admin/users?action=delete&id=<?= $user['id']; ?>"
                       onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php require base_path('views/partials/footer.php'); ?>
