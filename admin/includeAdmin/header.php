<!DOCTYPE html>
<html lang="fr">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>TROC Admin</title>

  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <link href="css/simple-sidebar.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />

</head>

<body>

  <div class="d-flex" id="wrapper">

    <div class="bg-dark border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-warning">TROC Admin </div>
      <div class="list-group list-group-flush">
        <a href="<?= URL ?>admin/gestion_users.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-warning text-light">Gestion&nbsp&nbsp&nbsp&nbsp des&nbsp&nbsp&nbsp users&nbsp&nbsp&nbsp&nbsp</button></a>
        <a href="<?= URL ?>admin/gestion_annonces.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-warning text-light">Gestion&nbsp des&nbsp&nbsp annonces&nbsp</button></a>
        <a href="<?= URL ?>admin/gestion_categories.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-warning text-light">Gestion&nbsp&nbsp des&nbsp catégories</button></a>
        <a href="<?= URL ?>admin/gestion_commentaires.php" class="list-group-item list-group-item-action bg-dark text-light py-4"><button type="button" class="btn btn-outline-warning text-light">Gestion des commentaires</button></a>
        <a href="<?= URL ?>admin/gestion_notes.php" class="list-group-item list-group-item-action bg-dark text-light py-4"><button type="button" class="btn btn-outline-warning text-light">&nbspGestion&nbsp&nbsp&nbsp des&nbsp&nbsp&nbsp notes&nbsp&nbsp&nbsp&nbsp</button></a>
        <a href="<?= URL ?>index.php" class="list-group-item list-group-item-action bg-dark text-light py-5"><button type="button" class="btn btn-outline-warning text-light">Retour Accueil TROC</button></a>
      </div>
    </div>
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
        <button class="btn btn-lg btn-outline-warning" id="menu-toggle"><i class="bi bi-caret-left-square-fill"></i> Menu <i class="bi bi-caret-right-square-fill"></i></button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>index.php"><button type="button" class="btn btn-outline-warning text-light">Accueil TROC</button></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= URL ?>admin/index.php"><button type="button" class="btn btn-outline-warning text-light">Home Admin</button></a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <button type="button" class="btn btn-outline-warning text-light">Menu Admin</button>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_annonces.php">Gestion des annonces</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_categories.php">Gestion des catégories</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_users.php">Gestion des users</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_commentaires.php">Gestion des commentaires</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_notes.php">Gestion des notes</a>
                <a class="dropdown-item" href="<?= URL ?>admin/statistiques.php">Statistiques</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container mb-5">