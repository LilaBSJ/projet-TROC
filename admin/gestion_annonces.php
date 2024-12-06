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

$ancienne_categorie = ''; 
$photo_bdd = ''; 
$id_categorie = ''; 
$titre = isset($_POST['titre']) ? $_POST['titre'] : '';
$desc_courte = isset($_POST['desc_courte']) ? $_POST['desc_courte'] : '';
$desc_longue = isset($_POST['desc_longue']) ? $_POST['desc_longue'] : '';
$prix = isset($_POST['prix']) ? $_POST['prix'] : '';
$pays = isset($_POST['pays']) ? $_POST['pays'] : '';
$ville = isset($_POST['ville']) ? $_POST['ville'] : '';
$adresse = isset($_POST['adresse']) ? $_POST['adresse'] : '';
$cp = isset($_POST['cp']) ? $_POST['cp'] : '';
$id_annonce = isset($_POST['id_annonce']) ? $_POST['id_annonce'] : '';

$queryAnnonces = $pdo->query("SELECT COUNT(id_annonce) AS nombreAnnonces FROM annonce ");
$resultAnnonces = $queryAnnonces->fetch();
$numberAnnonces = (int) $resultAnnonces['nombreAnnonces'];

$parPage = 7;
$numberPages = ceil($numberAnnonces / $parPage);
$firstAnnonce = ($pageNow - 1) * $parPage;


if (isset($_GET['action'])) {
    if ($_POST) {

        if (!isset($_POST['titre']) || iconv_strlen($_POST['titre']) < 2 || iconv_strlen($_POST['titre']) > 30) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format titre !</div>';
        }
        if (isset($_POST['desc_courte']) && isset($_POST['desc_longue'])) {
            $desc_courte = $_POST['desc_courte'];
            $desc_longue = $_POST['desc_longue'];
        
            if (!empty($desc_courte) && (iconv_strlen($desc_courte) < 2 || iconv_strlen($desc_courte) > 50)) {
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description courte !</div>';
            }
            if (!empty($desc_longue) && (iconv_strlen($desc_longue) < 20 || iconv_strlen($desc_longue) > 500)) {
                $erreur .= '<div class="alert alert-danger" role="alert">Erreur format description longue !</div>';
            }
        
        
        if (!isset($_POST['prix']) || !preg_match('#^[0-9]{1,10}$#', $_POST['prix'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format prix !</div>';
        }
        if (!isset($_POST['ville']) || !in_array($_POST['ville'], ['Paris', 'Reims', 'Toulouse', 'Marseille', 'Strasbourg', 'Amiens'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format ville!</div>';
        }
        
        if (!isset($_POST['adresse']) || !preg_match('#^[a-zA-Z0-9-é\s.]{3,50}$#', $_POST['adresse'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format adresse !</div>';
        }
        if (!isset($_POST['cp']) || !preg_match('#^[0-9]{1,5}$#', $_POST['cp'])) {
            $erreur .= '<div class="alert alert-danger" role="alert">Erreur format code postal !</div>';
        }
        
           
            if(!empty($_FILES['photo']['name'])){
                $photo_nom = $_POST['titre'] . "_" . $_FILES['photo']['name'];
                $photo_bdd = "$photo_nom";
                $photo_dossier = RACINE_SITE . "img/$photo_nom";
                copy($_FILES['photo']['tmp_name'], $photo_dossier);
                }
                if(empty($erreur)){
                    if($_GET['action'] == "update"){
            $modifierAnnonce = $pdo->prepare("UPDATE annonce SET
    titre = :titre, desc_courte = :desc_courte, desc_longue = :desc_longue, prix = :prix, pays = :pays, ville = :ville, adresse = :adresse, cp = :cp, id_categorie = :id_categorie, photo = :photo WHERE id_annonce = :id_annonce");

            $modifierAnnonce->bindValue(':id_annonce', $_POST['id_annonce'], PDO::PARAM_INT);
            $modifierAnnonce->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':desc_courte', $_POST['desc_courte'], PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':desc_longue', $_POST['desc_longue'], PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':cp', $_POST['cp'], PDO::PARAM_STR);
            $modifierAnnonce->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
            $modifierAnnonce->execute();

            $queryAnnonce = $pdo->prepare("SELECT titre, id_categorie FROM annonce WHERE id_annonce = :id_annonce");
            $queryAnnonce->bindValue(':id_annonce', $_GET['id_annonce'], PDO::PARAM_INT);
            $queryAnnonce->execute();
            $annonce = $queryAnnonce->fetch(PDO::FETCH_ASSOC);
            
            $mess .= '<div class="alert alert-success alert-dismissible fade show mt-5"
                role="alert">
                Modification d\'annonce <strong>' . $annonce['titre'] . ' ' . $annonce['id_categorie'] . '</strong> réussie !
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
        } else {
            $ajouterAnnonce = $pdo->prepare(" INSERT INTO photo (photo) VALUES (:photo ) ");
            $ajouterAnnonce->bindValue(':photo',  $photo_bdd, PDO::PARAM_STR);
            $ajouterAnnonce->execute();

            $id_photo = $pdo->lastInsertId();

        
            $ajouterAnnonce = $pdo->prepare(" INSERT INTO annonce (titre, desc_courte, desc_longue, prix, pays, ville, adresse, cp, created_at, id_user, id_photo, id_categorie) VALUES (:titre, :desc_courte, :desc_longue, :prix, :pays, :ville, :adresse, :cp, NOW(), :id_user, :id_photo, :id_categorie ) ");
            $ajouterAnnonce->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
            $ajouterAnnonce->bindValue(':desc_courte', $_POST['desc_courte'], PDO::PARAM_STR);
            $ajouterAnnonce->bindValue(':desc_longue', $_POST['desc_longue'], PDO::PARAM_STR);
            $ajouterAnnonce->bindValue(':prix', $_POST['prix'], PDO::PARAM_INT);
            $ajouterAnnonce->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
            $ajouterAnnonce->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
            $ajouterAnnonce->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
            $ajouterAnnonce->bindValue(':cp', $_POST['cp'], PDO::PARAM_INT);
            $ajouterAnnonce->bindValue(':id_user', $_SESSION['user']['id_user'], PDO::PARAM_STR);
            $ajouterAnnonce->bindValue(':id_photo', $id_photo, PDO::PARAM_INT);
            $ajouterAnnonce->bindValue(':id_categorie', $_POST['categorie'], PDO::PARAM_INT);
            $ajouterAnnonce->execute();

            $mess .= '<div class="alert alert-success alert-dismissible fade show mt-5"
role="alert">
<strong>Félicitations !</strong> Ajout d\'annonce réussie !
<button type="button" class="close" data-dismiss="alert" arialabel="Close">
<span aria-hidden="true">&times;</span>
        </button>
</div>';
        }
    }
    }
    if($_GET['action'] == "update"){
        $queryAnnonce = $pdo->query("SELECT * FROM annonce WHERE id_annonce =
        '$_GET[id_annonce]' ");
        $annonceActuel = $queryAnnonce->fetch(PDO::FETCH_ASSOC);
        }
        $id_annonce = isset($annonceActuel['id_annonce']) ? $annonceActuel['id_annonce'] : '';
    $titre = isset($annonceActuel['titre']) ? $annonceActuel['titre'] : '';
    $desc_courte = isset($annonceActuel['desc_courte']) ? $annonceActuel['desc_courte'] : '';
    $desc_longue = isset($annonceActuel['desc_longue']) ? $annonceActuel['desc_longue'] : '';
    $prix = isset($annonceActuel['prix']) ? $annonceActuel['prix'] : '';
    $photo = isset($annonceActuel['photo']) ? $annonceActuel['photo'] : '';
    $pays = isset($annonceActuel['pays']) ? $annonceActuel['pays'] : '';
    $ville = isset($annonceActuel['ville']) ? $annonceActuel['ville'] : '';
    $adresse = isset($annonceActuel['adresse']) ? $annonceActuel['adresse'] : '';
    $cp = isset($annonceActuel['cp']) ? $annonceActuel['cp'] : '';

    if ($_GET['action'] == 'delete' && isset($_GET['id_annonce'])) {
        echo "Début du bloc de suppression d'annonce.";
        $id_annonce = intval($_GET['id_annonce']);
        echo "ID de l'annonce à supprimer : " . $id_annonce;
        $supprimerAnnonce = $pdo->prepare("DELETE FROM annonce WHERE id_annonce = :id_annonce");

        if (!$supprimerAnnonce) {
           
            echo "Erreur lors de la préparation de la requête de suppression.";
            print_r($pdo->errorInfo());

        } else {
         
            $supprimerAnnonce->bindParam(':id_annonce', $id_annonce, PDO::PARAM_INT);
            if (!$supprimerAnnonce->execute()) {
                $errorInfo = $supprimerAnnonce->errorInfo();
                echo "Erreur lors de la suppression de l'annonce: " . $errorInfo[2];
            }
            
        }
        }
    }
}

 require_once('includeAdmin/header.php'); 
 ?>

<?php if (!isset($_GET['action']) && !isset($_GET['page'])) : ?>
<h1 class="text-center my-5">
    <div class="badge badge-warning text-wrap p-3">Gestion annonces</div>
</h1>
    <div class="modal fade" id="myModalUsers" tabindex="-1" role="dialog" arialabelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background-color: black;">
                <div class="modal-header">
                    <h5 class="modal-title text-warning" id="exampleModalLabel">Gestion des annonces</h5>
                </div>
                <div class="modal-body">
                    <p style="color: yellow;">Gérez ici votre BDD Annonces</p>
                    <p style="color: yellow;">Vous pouvez les modifier, ajouter ou supprimer</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning text-dark" data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>


<?php if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'update')) : ?>
    <h2 class="my-5">Formulaire <?= ($_GET['action'] == "add") ? "d'ajout" : "de modification" ?> d'annonces</h2>

    <form id="form" class="my-5" method="POST" action="" enctype="multipart/form-data">

<input type="hidden" name="id_annonce" value="<?= $id_annonce ?>">


        <div class="form-group">
            <label for="titre">Titre :</label>
            <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de l'annonce" value="<?= $titre ?>">
        </div>

        <div class="form-group">
            <label for="desc_courte">Description Courte :</label>
            <textarea class="form-control" id="desc_courte" name="desc_courte" placeholder="Description courte de votre annonce" rows="3"><?= $desc_courte ?></textarea>
        </div>

        <div class="form-group">
            <label for="desc_longue">Description Longue :</label>
            <textarea class="form-control" id="desc_longue" name="desc_longue" placeholder="Description longue de votre annonce" rows="5"><?= $desc_longue ?></textarea>
        </div>

        <div class="form-group">
            <label for="prix">Prix :</label>
            <input type="text" class="form-control" id="prix" name="prix" placeholder="Prix figurant dans l'annonce" value="<?= $prix ?>">
        </div>

        <div class="form-group">
            <label for="photo">Photo :</label>
            <input type="file" class="form-control" id="photo" name="photo" placeholder="Photo">
        </div>
        <?php if (!empty($photo)) : ?>
            <div class="mt-4">
                <p>Vous pouvez changer d'image
                    <img src="<?= URL . 'img/' . $photo ?>" width="50">
                </p>
            </div>
        <?php endif ?>
        <input type="hidden" name="photoActuelle" value="<?= $photo ?>">

        <div class="form-group">
            <label for="pays">Pays :</label>
            <select class="form-select" id="pays" name="pays">
                <option value="France" selected>France</option>
            </select>
        </div>

        <div class="form-group">
            <label for="ville">Ville :</label>
            <select class="form-select" id="ville" name="ville">
                <option value="Paris" <?= ($ville == 'Paris') ? 'selected' : '' ?>>Paris</option>
                <option value="Reims" <?= ($ville == 'Reims') ? 'selected' : '' ?>>Reims</option>
                <option value="Toulouse" <?= ($ville == 'Toulouse') ? 'selected' : '' ?>>Toulouse</option>
                <option value="Marseille" <?= ($ville == 'Marseille') ? 'selected' : '' ?>>Marseille</option>
                <option value="Strasbourg" <?= ($ville == 'Strasbourg') ? 'selected' : '' ?>>Strasbourg</option>
                <option value="Amiens" <?= ($ville == 'Amiens') ? 'selected' : '' ?>>Amiens</option>

            </select>
        </div>

        <div class="form-group">
            <label for="adresse">Adresse :</label>
            <input type="text" class="form-control" id="adresse" name="adresse" placeholder="Adresse figurant dans l'annonce" value="<?= $adresse ?>">
        </div>

        <div class="form-group">
            <label for="cp">Code Postal :</label>
            <input type="text" class="form-control" id="cp" name="cp" placeholder="Code postal" value="<?= $cp ?>">
        </div>


        <div class="form-group">
            <label for="categorie">Catégorie :</label>
            <select class="form-control" id="categorie" name="categorie" required>
                <option value="">Sélectionnez une catégorie</option>
                <?php
                $queryCategories = $pdo->query("SELECT id_categorie, titre FROM categorie");
                while ($row = $queryCategories->fetch(PDO::FETCH_ASSOC)) {
                    $selected = ($_POST['categorie'] == $row['id_categorie']) ? 'selected' : '';
                    echo '<option value="' . $row['id_categorie'] . '" ' . $selected . '>' . $row['titre'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="date">Date :</label>
            <input type="text" class="form-control" id="date" name="date" value="<?= date('d/m/Y H:i:s') ?>" readonly>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>

    </form>

    <?php endif; ?>

    <?php $queryUserInfo = $pdo->prepare("SELECT prenom FROM user WHERE id_user = :id_user");
    $queryUserInfo->bindValue(':id_user', $_SESSION['user']['statut'], PDO::PARAM_INT);
    $queryUserInfo->execute();
    $userInfo = $queryUserInfo->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['id_categorie'])) {
        $queryCategory = $pdo->prepare("SELECT titre FROM categorie WHERE id_categorie = :id_categorie");
        $queryCategory->bindValue(':id_categorie', $_POST['id_categorie'], PDO::PARAM_INT);
        $queryCategory->execute();
        $category = $queryCategory->fetch(PDO::FETCH_ASSOC);
    } else {
        $category = array('titre' => 'Catégorie non définie');
    }

    $nom_user = isset($userInfo['prenom']) ? $userInfo['prenom'] : '';
    $categorie_annonce = isset($category['categorie']) ? $category['categorie'] : '';
    ?>

    

<nav aria-label="">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($pageNow == 1) ? "disabled" : "" ?>">
            <a class="page-link bg-dark text-warning" href="?page=<?= $pageNow - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Précédente</span>
            </a>
        </li>
        <?php for ($page = 1; $page <= $numberPages; $page++) : ?>
            <li class="page-item <?= ($pageNow == $page) ? "active" : "" ?>">
                <a class="page-link bg-dark text-warning" href="?page=<?= $page ?>"><?= $page ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= ($pageNow == $numberPages) ? "disabled" : "" ?>">
            <a class="page-link bg-dark text-warning" href="?page=<?= $pageNow + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Suivante</span>
            </a>
        </li>
    </ul>
</nav>

<?php $queryAnnonces = $pdo->query("SELECT id_annonce FROM annonce") ?>
<h2 class="py-5">Nombre d'annonces en BDD: <?= $queryAnnonces->rowCount() ?></h2>
<div class="row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-lg btn-outline-success shadow rounded font-weight-bold">
            <i class="bi bi-plus-circle-fill"></i> Ajouter une annonce
        </button>
    </a>
</div>

<div class="table-responsive">
    <table class="table table-dark text-center">

        <form action="" method="GET">
            <div class="form-group">
                <label for="categorie">Trier par catégorie :</label>
                <select class="form-control" id="categorie" name="categorie">
                    <option value="">Toutes les catégories</option>
                    <?php
                    $queryCategories = $pdo->query("SELECT id_categorie, titre FROM categorie");
                    while ($row = $queryCategories->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($_GET['categorie'] == $row['id_categorie']) ? 'selected' : '';
                        echo '<option value="' . $row['id_categorie'] . '" ' . $selected . '>' . $row['titre'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Trier</button>
        </form>

        <thead>
            <tr>
                <th>ID Annonce</th>
                <th>Titre</th>
                <th>Description Courte</th>
                <th>Description Longue</th>
                <th>Prix</th>
                <th>Photo</th>
                <th>Pays</th>
                <th>Ville</th>
                <th>Adresse</th>
                <th>Code Postal</th>
                <th>Prénom</th>
                <th>Catégorie</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
       

            <?php
            $query = "SELECT a.*, u.prenom AS prenom, c.titre AS categorie, p.photo AS photo
        FROM annonce a 
        JOIN user u ON a.id_user = u.id_user 
        JOIN categorie c ON a.id_categorie = c.id_categorie
        LEFT JOIN photo p ON a.id_photo = p.id_photo";


            if (isset($_GET['categorie']) && $_GET['categorie'] !== '') {
                $query .= " WHERE c.id_categorie = :id_categorie";
            }

            $query .= " ORDER BY created_at ASC LIMIT $parPage OFFSET $firstAnnonce";

            $afficheAnnonce = $pdo->prepare($query);

            if (isset($_GET['categorie']) && $_GET['categorie'] !== '') {
                $afficheAnnonce->bindValue(':id_categorie', $_GET['categorie'], PDO::PARAM_INT);
            }

            $afficheAnnonce->execute();
            ?>
            <?php while ($annonce = $afficheAnnonce->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                    <td><?= $annonce['id_annonce'] ?></td>
                    <td><?= $annonce['titre'] ?></td>
                    <td><?= $annonce['desc_courte'] ?></td>
                    <td><?= substr($annonce['desc_longue'], 0, 50) . '...' ?></td>
                    <td><?= $annonce['prix'] ?> €</td>
                    <td><img class="img-fluid" src="<?= URL . "img/" . basename($annonce['photo']) ?>" width="50"></td>

                    <td><?= $annonce['pays'] ?></td>
                    <td><?= $annonce['ville'] ?></td>
                    <td><?= $annonce['adresse'] ?></td>
                    <td><?= $annonce['cp'] ?></td>
                    <td><?= $annonce['prenom'] ?></td>
                    <td><?= $annonce['categorie'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($annonce['created_at'])) ?></td>

                    <td>
                        <a href='?action=update&id_annonce=<?= $annonce['id_annonce'] ?>'><i class="bi bi-pen-fill text-warning"></i></a>
                        <a href="?action=delete&id_annonce=<?= $annonce['id_annonce'] ?>" toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php 
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_annonce'])) {

    $id_annonce = $_GET['id_annonce'];

    $query = $pdo->prepare("DELETE FROM annonce WHERE id_annonce = :id_annonce");
    $query->execute([':id_annonce' => $id_annonce]);
}
?>
<nav aria-label="">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($pageNow == 1) ? "disabled" : "" ?>">
            <a class="page-link bg-dark text-warning" href="?page=<?= $pageNow - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Précédente</span>
            </a>
        </li>
        <?php for ($page = 1; $page <= $numberPages; $page++) : ?>
            <li class="page-item <?= ($pageNow == $page) ? "active" : "" ?>">
                <a class="page-link bg-dark text-warning" href="?page=<?= $page ?>"><?= $page ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= ($pageNow == $numberPages) ? "disabled" : "" ?>">
            <a class="page-link bg-dark text-warning" href="?page=<?= $pageNow + 1 ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Suivante</span>
            </a>
        </li>
    </ul>
</nav>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: black;">
            <div class="modal-header">
                <h4 class="modal-title" style="color: red;">Confirmation de suppression</h4>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette annonce ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Annuler</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('includeAdmin/footer.php'); ?>