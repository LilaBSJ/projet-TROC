<?php
require_once('include/init.php');

if (connexionUser()) {
    header('location:' . URL . 'profil.php');
    exit();
}


if ($_POST) {
    if (!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9- _.]{3,20}$#', $_POST['pseudo'])) {
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
    }

    if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 8 || strlen($_POST['mdp']) > 30) {
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mot de passe !</div>';
    }


if (!isset($_POST['nom']) || !preg_match('#^[a-zA-Z -]{3,20}$#', $_POST['nom'])) {
    $erreur .= '<div class="alert alert-danger" role="alert">Erreur format nom !</div>';
}

if (!array_key_exists('prenom', $_POST) || !preg_match('#^[a-zA-Z -]{3,20}$#', $_POST['prenom'])) {
    $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prénom !</div>';
}

if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $erreur .= '<div class="alert alert-danger" role="alert">Erreur format email !</div>';
}

if (!isset($_POST['telephone']) || !preg_match('#^[0-9]{10}$#', $_POST['telephone'])) {
    $erreur .= '<div class="alert alert-danger" role="alert">Erreur format téléphone !</div>';
}

if (!isset($_POST['civilite']) || $_POST['civilite'] != 'f' && $_POST['civilite'] != 'h') {
    $erreur .= '<div class="alert alert-danger" role="alert">Erreur format civilité !</div>';
}
    $checkPseudo = $pdo->prepare(" SELECT pseudo FROM user WHERE pseudo = :pseudo ");
    $checkPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $checkPseudo->execute();

    if ($checkPseudo->rowCount() == 1) {
        $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce pseudo est déjà pris !</div>';
    }
    
    $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

    if (empty($erreur)) {
        $addUser = $pdo->prepare(" INSERT INTO user (pseudo, mdp, nom, prenom, telephone, email, civilite, created_at) VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, NOW() ) ");
        $addUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $addUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
        $addUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
        $addUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
        $addUser->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_STR);
        $addUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $addUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
        $addUser->execute();


        header('location:' . URL . 'connexion.php?action=validate');
    }

}

require_once('include/header.php');
?>

<div class="col-md-12 text-center" style="padding-top: 30px;">
    <h2>Inscription</h2>
</div>

<?= $erreur ?>

<div class="container" style="padding-top:0;">
    <form method="POST" action="" class="needs-validation" novalidate style="background-color: #d4f2e7; padding: 20px; border-radius: 8px; border: 1px solid #2ecc71;">
        <div class="row">
            <div class="col-md-6">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Votre pseudo" pattern="^[a-zA-Z0-9- _.]{3,20}$" title="Caractères alphanumériques acceptés, ainsi que les caractères spéciaux - _ ., entre trois et vingt caractères." required>
                        <div class="invalid-feedback">
                            Veuillez entrer un pseudo valide.
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" pattern="^[a-zA-Z -]{3,20}$" title="Caractères alphabétiques acceptés, entre trois et vingt caractères." required>
                        <div class="invalid-feedback">
                            Veuillez entrer un nom valide.
                        </div>
                    </div>


                    <div class="col-md-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" required>
                        <div class="invalid-feedback">
                            Veuillez entrer une adresse email valide.
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="mdp">Mot de passe</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe" minlength="8" maxlength="30" required>
                        <div class="invalid-feedback">
                            Le mot de passe doit avoir entre 8 et 30 caractères.
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom" pattern="^[a-zA-Z -]{3,20}$" title="Caractères alphabétiques acceptés, entre trois et vingt caractères." required>
                        <div class="invalid-feedback">
                            Veuillez entrer un prénom valide.
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="telephone">Téléphone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Votre téléphone" pattern="^[0-9]{10}$" title="Entrez un numéro de téléphone valide (10 chiffres)." required>
                        <div class="invalid-feedback">
                            Veuillez entrer un numéro de téléphone valide.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label>Civilité</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="civilite" id="civilite2" value="h" required>
                    <label class="form-check-label" for="civilite2">Homme</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="civilite" id="civilite1" value="f" required>
                    <label class="form-check-label" for="civilite1">Femme</label>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" type="submit" style="background-color: #2ecc71; border-color: #2ecc71;">Inscription</button>

            </div>
        </div>

    </form>

    <?php
    require_once('include/footer.php');
    ?>