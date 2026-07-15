<?php 
/** @var array $users */
require base_path('views/partials/head.php');
require base_path('views/partials/nav.php');
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
        --shadow: 0 10px 30px rgba(44, 36, 24, 0.08);
        --transition: all 0.3s ease;
    }

    body { 
        background: radial-gradient(circle at top right, var(--gold-faint), transparent), var(--cream);
        background-attachment: fixed;
        color: var(--text-dark);
        font-family: 'Segoe UI', Roboto, sans-serif;
    }

    .container {
        max-width: 1200px;
        margin: 50px auto;
        padding: 0 20px;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
        background: var(--white);
        padding: 25px 40px;
        border-radius: 20px;
        box-shadow: var(--shadow);
        border: 1px solid var(--beige-dark);
    }

    .header-section h1 {
        color: var(--gold);
        font-size: 32px;
        font-weight: 800;
        margin: 0;
        letter-spacing: -1px;
    }

    .btn-add {
       background: linear-gradient(135deg, var(--dark), #3a3428);
        color: var(--gold-pale);
        padding: 14px 28px;
        border-radius: 15px;
        text-decoration: none;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .btn-add:hover {
        transform: translateY(-3px);
        background: var(--gold);
        color: white;
        box-shadow: 0 8px 20px rgba(184, 151, 58, 0.3);
    }

    .table-card {
        background: var(--white);
        border-radius: 24px;
        overflow: hidden;
        box-shadow: var(--shadow);
        border: 1px solid var(--beige-dark);
    }

    .user-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .user-table th {
        background: var(--gold-faint);
        color: var(--text-dark);
        padding: 20px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        border-bottom: 2px solid var(--gold-pale);
    }

    .user-table td {
        padding: 20px;
        border-bottom: 1px solid var(--beige);
        vertical-align: middle;
        color: var(--text-mid);
        font-weight: 500;
    }

    .user-table tr:hover {
        background-color: rgba(247, 240, 220, 0.3);
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-info img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--gold-pale);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .user-name {
        font-weight: 700;
        color: var(--text-dark);
        font-size: 16px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        background: var(--beige);
        color: var(--text-mid);
    }

    .action-btns {
        display: flex;
        gap: 10px;
    }

    .btn-action {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: var(--transition);
        font-size: 18px;
    }

    .btn-edit {
        background: var(--gold-faint);
        color: var(--gold);
    }

    .btn-edit:hover {
        background: var(--gold);
        color: white;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #FFF5F5;
        color: #E05252;
        border: none;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #E05252;
        color: white;
        transform: translateY(-2px);
    }

    /* SweetAlert2 Custom Styling */
    .swal2-popup {
        border-radius: 20px !important;
        font-family: 'Segoe UI', sans-serif !important;
    }
    .swal2-styled.swal2-confirm {
        background-color: var(--gold) !important;
        border-radius: 10px !important;
    }
    .swal2-styled.swal2-cancel {
        border-radius: 10px !important;
    }
</style>

<!-- FontAwesome & SweetAlert2 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="container">
    <div class="header-section">
        <div>
            <h1>All Users</h1>
           
        </div>
        <a href="/admin/users/add" class="btn-add">
            <i class="fas fa-user-plus"></i> Add New User
        </a>
    </div>

    <div class="table-card">
        <table class="user-table">
            <thead>
                <tr>
                    <th>User Information</th>
                    <th>Room No</th>
                    <th>Extension</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user) : ?>
                <tr>
                    <td>
                        <div class="user-info">
                            <img src="/images/<?= htmlspecialchars($user['profile_picture']) ?>" alt="<?= htmlspecialchars($user['name']) ?>">
                            <span class="user-name"><?= htmlspecialchars($user['name']) ?></span>
                        </div>
                    </td>
                    <td><span class="badge">Room <?= htmlspecialchars($user['room_no']) ?></span></td>
                    <td><span class="badge">Ext: <?= htmlspecialchars($user['ext']) ?></span></td>
                    <td><span style="color: #27ae60; font-weight: 700;"><i class="fas fa-circle" style="font-size: 8px;"></i> Active</span></td>
                    <td>
                        <div class="action-btns">
                            <a href="/admin/users/edit?id=<?= $user['id']; ?>" class="btn-action btn-edit" title="Edit User">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn-action btn-delete" title="Delete User" 
                                    onclick="confirmDelete('<?= $user['id'] ?>', '<?= htmlspecialchars($user['name']) ?>')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete user: ${userName}. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#B8973A',
            cancelButtonColor: '#E8DEC8',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete URL
                window.location.href = `/admin/users?action=delete&id=${userId}`;
            }
        })
    }
</script>

<?php require base_path('views/partials/footer.php'); ?>