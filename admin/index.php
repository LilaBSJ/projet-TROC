<?php
require_once('../include/init.php');

if (!connexionAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == "validate") {
    $yes .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
    <strong>' . $_SESSION['user']['pseudo'] . '</strong>, vous êtes connecté(e) ! 😉
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>';
}
require_once('includeAdmin/header.php');?>

<?= $yes ?>

<h2 class="text-center my-5">
<div class="badge badge-dark text-wrap p-3" style="background-color: green; color: black;">
        Bonjour <?= (connexionAdmin() ? $_SESSION['user']['pseudo'] : ""); ?>
    </div>
</h2>

<div class="row justify-content-around my-5">
    <img class='img-fluid' src="../img/backend_image.jpg" alt="Backend image" loading="lazy">
</div>

<?php require_once('includeAdmin/footer.php'); ?>

