<?php
require_once('include/init.php');

if(isset($_GET['action']) && $_GET['action'] == "deconnexion"){
    unset($_SESSION['user']);
    header('location:' . URL . 'connexion.php');
    exit();
    }
if(connexionUser()){
    header('location:' . URL . 'profil.php');
    exit();
}

if(isset($_GET['action']) && $_GET['action'] == 'validate'){
    $yes .= '<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
                    <strong>Félicitations !</strong> Votre inscription est réussie 😉, vous pouvez vous connecter !
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>';
}
if($_POST){

    $checkUser = $pdo->prepare(" SELECT * FROM user WHERE pseudo = :pseudo");
    $checkUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $checkUser->execute();


    if($checkUser->rowCount() == 1 ){
        $membre = $checkUser->fetch(PDO::FETCH_ASSOC);
        if(password_verify($_POST['mdp'], $membre['mdp'])){     
            foreach($membre as $key => $value ){
                if($key != 'mdp'){
                    $_SESSION['user'][$key] = $value;
                    if(connexionAdmin()){
                        header('location:' . URL . 'admin/index.php?action=validate');
                    }else{
                        header('location:' . URL . 'profil.php?action=validate');
                    }
                }
            }
        }else{
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur, mot de passe inconnu! </div>';
        }
    }else{
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur, pseudo inconnu.Vérifiez son écriture ou inscrivez-vous!</div>';
    }
}

if(isset($_GET['action']) && $_GET['action'] == "validate_index"){
    $validate_index .= '<div class="alert alert-success alert-dismissible fade show
    mt-5" role="alert">
    Félicitations <strong>' . $_SESSION['user']['pseudo'] .'</strong>, vous
    êtes connecté(e) 😉 !
    <button type="button" class="close" data-dismiss="alert" arialabel="
    Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
}
require_once('include/header.php');
?>

<?= $erreur ?>

<?= $yes ?>

<form class="my-5" method="POST" action="";>
    <div class="col-md-6 offset-md-3 my-4">
        <div class="card p-4 shadow-sm rounded" style="background-color: #d4f2e7">

        <h2 class="text-center mb-4"><div class="badge badge-success p-2" style="color: black;">Connexion</div></h2>

            <div class="mb-3">
                <label class="form-label" for="pseudo">Pseudo</label>
                <input class="form-control" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="mdp">Mot de passe</label>
                <input class="form-control" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" required>
            </div>

            <button type="submit" class="btn btn-success btn-lg btn-block">Connexion</button>
        </div>
    </div>
</form>
<?php
    require_once('include/footer.php');
    ?>