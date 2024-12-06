<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TROC-Site d'annonces</title>

    <link rel="stylesheet" href="css/simple-sidebar.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js" integrity="sha384-6D6NvxV6z6wV9vREiw5g7bVfjM2b1QFhbii+HN3lwk9mg5YRVm+XqDjtyGQFhp0" crossorigin="anonymous"></script>
</head>

<body style="padding-top: 56px;">
<header>

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-lg">
            <a class="navbar-brand" href="index.php">TROC</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Qui Sommes Nous</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <form class="d-flex mx-auto">
                    <input class="form-control me-2" type="search" placeholder="Recherche" aria-label="Recherche">
                    <button class="btn btn-outline-success" type="submit">
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                            <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                        </svg>
                    </button>
                </form>
                <ul class="navbar-nav">
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <button type="button" class="btn btn-outline-success">Espace<strong></strong></button>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= URL ?>profil.php">Profil</a>
                            <a class="dropdown-item" href="<?= URL ?>connexion.php?action=deconnexion">Déconnexion</a>
                        </div>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <button type="button" class="btn btn-outline-success">Espace membre<strong></strong></button>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?= URL ?>inscription.php"><button class ="btn-outline-success">Inscription</button></a>
                            <a class="dropdown-item"><button class ="btn-outline-success" data-toggle="modal" data-target="#connexionModal">Connexion</button></a>
                        </div>
                    </li>
                    
                    <li class ="nav-item mr-5">
                        <a class ="nav-link" href="admin/index.php"><button type="button" class="btn btn-outline-success">Admin</button></a>
                    </li>


                </ul>
            </div>
        </div>
    </nav>
</header>
<div class ="container">

<div class="modal fade" id="connexionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body text-center">
                
                <form name="connexion" method="POST" action="">
                    <div class="row justify-content-around">
                      <div class="col-md-4 mt-4">
                      <label class="form-label" for="pseudo"><div class="badge badge-dark text-wrap">Pseudo</div></label>
                      <input class="form-control btn btn-outline-success" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo">
                      </div>
                    </div>

                    <div class="row justify-content-around">
                      <div class="col-md-6 mt-4">
                      <label class="form-label" for="mdp"><div class="badge badge-dark text-wrap">Mot de passe</div></label>
                      <input class="form-control btn btn-outline-success" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe">
                      </div>
                    </div>
                    
                    <div class="row justify-content-center">
                      <button type="submit" name="connexion" class="btn btn-lg btn-outline-success mt-3">Connexion</button>
                    </div>

                </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                </div>
              </div>
            </div>
          </div>


</div>