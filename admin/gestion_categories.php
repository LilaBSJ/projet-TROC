<?php require_once('../include/init.php');

if (!connexionAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

if (isset($_GET['page']) && !empty($_GET['page'])) {
    $pageNow = (int) strip_tags($_GET['page']);
} else {
    $pageNow = 1;
}

$queryCategoriesCount = $pdo->query("SELECT COUNT(id_categorie) AS nombreCategories FROM categorie ");
$resultCategorieCount = $queryCategoriesCount->fetch();
$numberCategories = (int) $resultCategorieCount['nombreCategories'];

$parPage = 5;
$numberPages = ceil($numberCategories / $parPage);
$firstCategorie = ($pageNow - 1) * $parPage;
$queryCategoriesList = $pdo->query("SELECT id_categorie, titre, motscles FROM categorie LIMIT $firstCategorie, $parPage");

?>

<?php require_once('includeAdmin/header.php'); ?>

<h1 class="text-center my-5">
    <div class="badge badge-warning text-wrap p-3">Gestion des catégories</div>
</h1>

<?php $queryCategoriesCount = $pdo->query("SELECT id_categorie FROM categorie") ?>
<h2 class="py-5">Nombre de categories en BDD: <?= $queryCategoriesCount->rowCount() ?></h2>
<div class="row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-lg btn-outline-success shadow rounded font-weight-bold">
            <i class="bi bi-plus-circle-fill"></i> Ajouter une categorie
        </button>
    </a>
</div>
<nav aria-label="">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($pageNow == 1) ? "disabled" : "" ?>">
            <a class="page-link bg-dark text-warning" href="?page=<?= $pageNow - 1 ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Précédente</span>
            </a>
        </li>
        <?php for ($pageNumber = 1; $pageNumber <= $numberPages; $pageNumber++) : ?>
            <li class="page-item <?= ($pageNumber == $pageNow) ? "active" : "" ?>">
                <a class="page-link bg-dark text-warning" href="?page=<?= $pageNumber ?>"><?= $pageNumber ?></a>
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
<div class="table-responsive">
    <table class="table table-dark text-center">
        <thead>
            <tr>
                <th>ID Catégorie</th>
                <th>Titre</th>
                <th>Mots-clés</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($categorie = $queryCategoriesList->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                    <td><?= $categorie['id_categorie'] ?></td>
                    <td><?= $categorie['titre'] ?></td>
                    <td><?= $categorie['motscles'] ?></td>
                    <td>
                        <a href='?action=update&id_categorie=<?= $categorie['id_categorie'] ?>'><i class="bi bi-pen-fill text-warning"></i></a>
                        <a href="?action=delete&id_categorie=<?= $categorie['id_categorie'] ?>" toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php 
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_categorie'])) {

    $id_categorie = $_GET['id_categorie'];

    $query = $pdo->prepare("DELETE FROM categorie WHERE id_categorie = :id_categorie");
    $query->execute([':id_categorie' => $id_categorie]);
}
?>


<?php if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'update')) : ?>
    <h2 class="my-5">Formulaire <?= ($_GET['action'] == "add") ? "d'ajout" : "de modification" ?></h2>

    <?php
    $id_categorie = null;
    if (isset($_POST['id_categorie'])) {
        $id_categorie = $_POST['id_categorie'];
    } elseif (isset($_GET['id_categorie'])) {
        $id_categorie = $_GET['id_categorie'];
    }

    $categorie = null;
    if ($id_categorie !== null) {
        $queryCategorie = $pdo->prepare("SELECT titre, motscles FROM categorie WHERE id_categorie = :id_categorie");
        $queryCategorie->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $queryCategorie->execute();
        $categorie = $queryCategorie->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <form id="form" class="my-5" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

        <input type="hidden" name="id_categorie" value="<?= isset($id_categorie) ? $id_categorie : '' ?>">

        <?php if ($_GET['action'] == 'add') : ?>
    <div class="form-group">
        <label for="titre">Titre :</label>
        <input type="text" class="form-control" id="titre_add" name="titre" required>
    </div>
<?php elseif ($_GET['action'] == 'update') : ?>
    <div class="form-group">
        <label for="titre">Titre :</label>
        <input type="text" class="form-control" id="titre_update" name="titre" value="<?= isset($categorie['titre']) ? $categorie['titre'] : '' ?>" required>
    </div>
<?php endif; ?>



        <div class="form-group">
            <label for="motscles">Mots-clés :</label>
            <textarea class="form-control" id="motscles" name="motscles" rows="3"><?= isset($categorie['motscles']) ? $categorie['motscles'] : '' ?></textarea>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>
    </form>
<?php endif; ?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_categorie'], $_POST['titre'], $_POST['motscles'])) {
        if (!empty($_POST['id_categorie'])) {
            $id_categorie = $_POST['id_categorie'];
            $titre = $_POST['titre'];
            $motscles = $_POST['motscles'];

            $queryUpdateCategorie = $pdo->prepare("UPDATE categorie SET titre = :titre, motscles = :motscles WHERE id_categorie = :id_categorie");
            $queryUpdateCategorie->bindValue(':id_categorie', $id_categorie, PDO::PARAM_INT);
            $queryUpdateCategorie->bindValue(':titre', $titre, PDO::PARAM_STR);
            $queryUpdateCategorie->bindValue(':motscles', $motscles, PDO::PARAM_STR);

            if ($queryUpdateCategorie->execute()) {
                echo "La catégorie a été mise à jour avec succès.";
            } else {
                $errorInfo = $queryUpdateCategorie->errorInfo();
                echo "Erreur lors de la mise à jour de la catégorie : " . $errorInfo[2];
            }
        } else {
            $titre = $_POST['titre'];
            $motscles = $_POST['motscles'];

            $queryInsertCategorie = $pdo->prepare("INSERT INTO categorie (titre, motscles) VALUES (:titre, :motscles)");
            $queryInsertCategorie->bindValue(':titre', $titre, PDO::PARAM_STR);
            $queryInsertCategorie->bindValue(':motscles', $motscles, PDO::PARAM_STR);

            if ($queryInsertCategorie->execute()) {
        
        
                exit();
            } else {
                $errorInfo = $queryInsertCategorie->errorInfo();
                echo "Erreur lors de l'ajout de la catégorie : " . $errorInfo[2];
            }
        }
    }
}
?>



<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: black;">
            <div class="modal-header">
                <h4 class="modal-title" style="color: red;">Confirmation de suppression</h4>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cette catégorie ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Annuler</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('includeAdmin/footer.php'); ?>
