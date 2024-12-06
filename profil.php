<?php
require_once('include/init.php');

if (!connexionUser()) {
    header('location:' . URL . 'connexion.php');
    exit();
}


if (isset($_GET['action']) && $_GET['action'] == "validate") {
    $yes .= '<div class="alert alert-success alert-dismissible fade show mt-5"
    role="alert">
    " Bonjour ' . $_SESSION['user']['pseudo'] . ' vous êtes connecté(e)! 😉"
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}
    require_once('include/header.php');
    ?>

<div class="container">
    <h2 class="text-center my-5">
        <span class="badge bg-dark text-wrap p-3">Bonjour</span>
    </h2>

    <ul class="list-group">
        <li class="list-group-item border-3 bg-success text-dark my-3 shadow rounded"><?=$_SESSION['user']['pseudo'] ?></li>
        <li class="list-group-item border-3 bg-success text-dark my-3 shadow rounded"><?=$_SESSION['user']['nom'] ?></li>
        <li class="list-group-item border-3 bg-success text-dark my-3 shadow rounded"><?=$_SESSION['user']['prenom'] ?></li>
        <li class="list-group-item border-3 bg-success text-dark my-3 shadow rounded"><?=$_SESSION['user']['telephone'] ?></li>
        <li class="list-group-item border-3 bg-success text-dark my-3 shadow rounded"><?=$_SESSION['user']['email'] ?></li>
    </ul>

    <div class="text-center mt-5">
        <a href="depot_annonce.php" class="btn btn-primary">Faire une annonce</a>
    </div>
</div>



    <?php
    require_once('include/footer.php');
    ?>

