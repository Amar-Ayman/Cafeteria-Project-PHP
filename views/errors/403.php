<?php require base_path('views/partials/head.php') ?>
<style>
    .error-container {
        height: 80vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        font-family: 'Jost', sans-serif;
    }
    .error-code {
        font-size: 120px;
        font-weight: 800;
        color: #b8973a;
        line-height: 1;
        margin-bottom: 20px;
    }
    .error-message {
        font-size: 24px;
        color: #333;
        margin-bottom: 30px;
    }
    .back-btn {
        padding: 12px 30px;
        background-color: #1a1a1a;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        transition: 0.3s;
    }
    .back-btn:hover {
        background-color: #b8973a;
        transform: translateY(-3px);
    }
</style>

<div class="error-container">
    <div class="error-code">403</div>
    <div class="error-message">Sorry! You don't have permission to enter this area.</div>
    <a href="/" class="back-btn">Return to Safety</a>
</div>

<?php require base_path('views/partials/footer.php') ?>
