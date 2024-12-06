<?php
require_once('../include/init.php');

if (!connexionAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}
if (isset($_GET['page']) && !empty($_GET['page'])) {
    $pageNow = (int) strip_tags($_GET['page']);
} else {
    $pageNow = 1;
}

$queryUser = $pdo->query("SELECT COUNT(id_user) AS nombreUsers FROM user");
$totalUsers = $queryUser->fetch();
$numberUsers = (int) $totalUsers['nombreUsers'];

$parPage = 7;
$numberPages = ceil($numberUsers / $parPage);
$firstUser = ($pageNow - 1) * $parPage;

if (isset($_GET['action'])) {

    if ($_POST) {
        if (!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9- _.]{3,20}$#', $_POST['pseudo'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format pseudo !</div>';
        }

        if ($_GET['action'] == 'add') {
            $checkPseudo = $pdo->prepare(" SELECT * FROM user WHERE pseudo = :pseudo ");
            $checkPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $checkPseudo->execute();

            if ($checkPseudo->rowCount() == 1) {
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur ce pseudo est déjà pris !</div>';
            }

            if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 8 || strlen($_POST['mdp']) > 30) {
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format mot de passe !</div>';
            }
            $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
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

        if (empty($erreur)) {
            if ($_GET['action'] == 'update') {
                $changeUser = $pdo->prepare(" UPDATE user SET id_user = :id_user, pseudo = :pseudo, nom = :nom, prenom = :prenom, telephone = :telephone, email = :email, civilite = :civilite WHERE id_user = :id_user");
                $changeUser->bindValue(':id_user', $_POST['id_user'], PDO::PARAM_STR);
                $changeUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $changeUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $changeUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $changeUser->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_STR);
                $changeUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $changeUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
                $changeUser->execute();

                $queryUsers = $pdo->query("SELECT pseudo FROM user WHERE id_user = '$_GET[id_user]' ");
                $user = $queryUsers->fetch(PDO::FETCH_ASSOC);
                $mess .= '<div class="alert alert-success alert-dismissible fade show mt-5"
    role="alert">
    Modification du membre <strong>' . $user['pseudo'] . '</strong> réussie !
    <button type="button" class="close" data-dismiss="alert" arialabel="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>';
            } else {
                $addUser = $pdo->prepare(" INSERT INTO user (pseudo, mdp, nom, prenom, telephone, email, civilite, created_at) VALUES (:pseudo, :mdp, :nom, :prenom, :telephone, :email, :civilite, NOW() ) ");
                $addUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $addUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
                $addUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $addUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $addUser->bindValue(':telephone', $_POST['telephone'], PDO::PARAM_STR);
                $addUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $addUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
                $addUser->execute();

                $mess .= '<div class="alert alert-success alert-dismissible fade show mt-5"
    role="alert">
    <strong>Félicitations !</strong> Ajout du user réussie !
    <button type="button" class="close" data-dismiss="alert" arialabel="Close">
    <span aria-hidden="true">&times;</span>
            </button>
    </div>';
            }
        }
    }

    if ($_GET['action'] == 'update') {
        $queryUsers = $pdo->query("SELECT * FROM user WHERE id_user =
        '$_GET[id_user]' ");
        $userNow = $queryUsers->fetch(PDO::FETCH_ASSOC);
    }
    $id_user = (isset($userNow['id_user'])) ? $userNow['id_user'] : "";
    $pseudo = (isset($userNow['pseudo'])) ? $userNow['pseudo'] : "";
    $nom = (isset($userNow['nom'])) ? $userNow['nom'] : "";
    $prenom = (isset($userNow['prenom'])) ? $userNow['prenom'] : "";
    $tel = (isset($userNow['telephone'])) ? $userNow['telephone'] : "";
    $email = (isset($userNow['email'])) ? $userNow['email'] : "";
    $civilite = (isset($userNow['civilite'])) ? $userNow['civilite'] : "";
    $date = (isset($userNow['created_at'])) ? $userNow['created_at'] : "";

    if ($_GET['action'] == 'delete') {
        $pdo->query("DELETE FROM user WHERE id_user = '$_GET[id_user]' ");
    }
}
require_once('includeAdmin/header.php');

?>


<h1 class="text-center my-5">
    <div class="badge badge-warning text-wrap p-3">Gestion
        des membres</div>
</h1>
<?php if (isset($_GET['action'])) : ?>

    <h2 class="my-5">Formulaire <?= ($_GET['action'] == "add") ? "d'ajout" : "de
modification" ?> des membres</h2>

    <?= $erreur ?>

    <form action="" method="POST">
        <input type="hidden" name="id_user" value="<?= $id_user ?>">
        <div class="form-group">
            <label for="pseudo">Pseudo :</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                </div>
                <input type="text" class="form-control" id="pseudo" name="pseudo" placeholder="Entrez votre pseudo" value="<?= $pseudo ?>">
            </div>
        </div>

        <?php if ($_GET['action'] == 'add') : ?>
            <div class="form-group">
                <label for="mdp">Mot de passe :</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    </div>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Entrez votre mot de passe">
                </div>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="nom">Nom :</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                </div>
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Entrez votre nom" value="<?= $nom ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                </div>
                <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Entrez votre prénom" value="<?= $prenom ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                </div>
                <input type="email" class="form-control" id="email" name="email" placeholder="Entrez votre email" value="<?= $email ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="telephone">Téléphone :</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                </div>
                <input type="tel" class="form-control" id="telephone" name="telephone" placeholder="Entrez votre numéro de téléphone" value="<?= $tel ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="civilite">Civilité :</label>
            <select class="form-control" id="civilite" name="civilite">
                <option value="h" <?= ($civilite == 'h') ? 'selected' : '' ?>>Homme</option>
                <option value="f" <?= ($civilite == 'f') ? 'selected' : '' ?>>Femme</option>
            </select>
        </div>
        <div class="form-group">
            <label for="statut">Statut :</label>
            <select class="form-control" id="statut" name="statut">
                <option value="admin">Admin</option>
                <option value="user">Membre</option>
            </select>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>

    </form>

<?php endif; ?>

<?php $queryUsers = $pdo->query("SELECT id_user FROM user") ?>
<h2 class="py-5">Nombre de membres en BDD: <?= $queryUsers->rowCount() ?></h2>
<div class="row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-lg btn-outline-success shadow rounded font-weight-bold">
            <i class="bi bi-plus-circle-fill"></i> Ajouter un nouveau user
        </button>
    </a>
</div>
<nav>
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($pageNow == 1) ? "disabled" : "" ?>">
            <a class="page-link text-dark" href="?page=<?= $pageNow - 1 ?>" arialabel="Previous">
            <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Précédente</span>
            </a>
        </li>
        <?php for ($page = 1; $page <= $numberPages; $page++) : ?>
            <li class="page-item <?= ($pageNow == $page) ? "active" : "" ?>">
                <a class="page-link bg-dark text-warning" href="?page=<?= $page ?>"><?= $page
                                                                                    ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= ($pageNow == $numberPages) ? "disabled" : "" ?>">
            <a class="page-link text-dark" href="?page=<?= $pageNow + 1 ?>" arialabel="Next">
            <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Suivante</span>
            </a>
        </li>
    </ul>
</nav>
<table class="table table-dark text-center">
    <?php $viewUsers = $pdo->query("SELECT * FROM user ORDER BY pseudo ASC LIMIT
$parPage OFFSET $firstUser") ?>
    <thead>
        <tr>
            <?php for ($i = 0; $i < $viewUsers->columnCount(); $i++) {
                $col = $viewUsers->getColumnMeta($i);
                if ($col['name'] != 'mdp') { ?>
                    <th><?= $col['name'] ?></th>
            <?php }
            } ?>
            <th colspan="2">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $viewUsers->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach ($user as $key => $value) {
                    if ($key != 'mdp') { ?>
                        <td><?= $value ?></td>
                <?php }
                } ?>
                <td><a href='?action=update&id_user=<?= $user['id_user'] ?>'><i class="bi bi-pen-fill text-warning"></i></a></td>
                <td><a href="?action=delete&id_user=<?= $user['id_user'] ?>" datatoggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill textdanger" style="font-size: 1.5rem;"></i></a></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<nav>
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($pageNow == 1) ? "disabled" : "" ?>">
            <a class="page-link text-dark" href="?page=<?= $pageNow - 1 ?>" arialabel="Previous">
            <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Précédente</span>
            </a>
        </li>
        <?php for ($page = 1; $page <= $numberPages; $page++) : ?>
            <li class="page-item <?= ($pageNow == $page) ? "active" : "" ?>">
                <a class="page-link bg-dark text-warning" href="?page=<?= $page ?>"><?= $page
                                                                                    ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= ($pageNow == $numberPages) ? "disabled" : "" ?>">
            <a class="page-link text-dark" href="?page=<?= $pageNow + 1 ?>" arialabel="Next">
            <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Suivante</span>
            </a>
        </li>
    </ul>
</nav>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" arialabelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: black;">
            <div class="modal-header">
            <h4 class="modal-title" style="color: red;">Confirmation de suppression</h4>
            </div>
            <div class="modal-body">
                Êtes-vous sur de vouloir retirer cet utilisateur de votre BDD ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Annuler</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<?php if (!isset($_GET['action']) && !isset($_GET['page'])) : ?>
    <div class="modal fade" id="myModalUsers" tabindex="-1" role="dialog" arialabelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: black;">
                <div class="modal-header">
                    <h5 class="modal-title text-warning" id="exampleModalLabel">Gestion des
                        utilisateurs</h5>
                        </div>
                <div class="modal-body">
                    <p style="color: yellow;">Gérez ici votre BDD des utilisateurs</p>
                    <p style="color: yellow;">Vous pouvez modifier leurs données, ajouter ou supprimer un utilisateur</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning text-dark" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<? require_once('includeAdmin/footer.php'); ?>