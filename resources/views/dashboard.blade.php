<x-base-layout>
    <?php
    session_start();
    if(!isset($_SESSION['user_id'])){
        header("Location: /resources/views/auth/login.blade.php");
        exit;
    }
    ?>
    
    <h1>Welkom, <?php echo $_SESSION['user_name']; ?></h1>

    <?php if($_SESSION['is_admin']): ?>
        <p>Je bent admin en hebt hogere rechten.</p>
    <?php endif; ?>
</x-base-layout>
