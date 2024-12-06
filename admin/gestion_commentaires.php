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

$queryCommentCount = $pdo->query("SELECT COUNT(id_commentaire) AS nombreCommentaires FROM commentaire ");
$resultCommentCount = $queryCommentCount->fetch();
$numberComment = (int) $resultCommentCount['nombreCommentaires'];

$parPage = 5;
$numberPages = ceil($numberComment / $parPage);
$firstComment = ($pageNow - 1) * $parPage;
$queryCommentList = $pdo->query("SELECT c.id_commentaire, u.id_user, u.email, c.id_annonce, a.titre, c.commentaire, c.created_at 
                                FROM commentaire c 
                                JOIN user u ON c.id_user = u.id_user 
                                JOIN annonce a ON c.id_annonce = a.id_annonce
                                LIMIT $firstComment, $parPage");




?>

<?php require_once('includeAdmin/header.php'); ?>

<h1 class="text-center my-5">
    <div class="badge badge-warning text-wrap p-3">Gestion des commentaires</div>
</h1>

<?php $queryCommentCount = $pdo->query("SELECT id_commentaire FROM commentaire") ?>
<h2 class="py-5">Nombre de commentaires en BDD: <?= $queryCommentCount->rowCount() ?></h2>
<div class="row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-lg btn-outline-success shadow rounded font-weight-bold">
            <i class="bi bi-plus-circle-fill"></i> Ajouter un commentaire
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
                <th>ID Commentaire</th>
                <th>ID User</th>
                <th>ID Annonce</th>
                <th>Commentaire</th>
                <th>Date d'enregistrement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($comment = $queryCommentList->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                    <td><?= $comment['id_commentaire'] ?></td>
                    <td><?= $comment['id_user'] ?> - (<?= $comment['email'] ?>)</td>
                    <td><?= $comment['id_annonce'] ?> - (<?= $comment['titre'] ?>)</td>

                    <td><?= $comment['commentaire'] ?></td>
                    <td><?= $comment['created_at'] ?></td>
                    <td>
                        <a href='?action=update&id_commentaire=<?= $comment['id_commentaire'] ?>'><i class="bi bi-pen-fill text-warning"></i></a>
                        <a href="?action=delete&id_commentaire=<?= $comment['id_commentaire'] ?>" toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_commentaire'])) {

    $id_comment = $_GET['id_commentaire'];

    $query = $pdo->prepare("DELETE FROM commentaire WHERE id_commentaire = :id_commentaire");
    $query->execute([':id_commentaire' => $id_comment]);
}
?>




<?php if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'update')) : ?>
    <h2 class="my-5">Formulaire <?= ($_GET['action'] == "add") ? "d'ajout" : "de modification" ?></h2>

    <?php
    $id_comment = null;
    if (isset($_POST['id_commentaire'])) {
        $id_comment = $_POST['id_commentaire'];
    } elseif (isset($_GET['id_commentaire'])) {
        $id_comment = $_GET['id_commentaire'];
    }

    $comment = null;
    if ($id_comment !== null) {
        $queryComment = $pdo->prepare("SELECT id_user, id_annonce FROM commentaire WHERE id_commentaire = :id_commentaire");
        $queryComment->bindValue(':id_commentaire', $id_comment, PDO::PARAM_INT);
        $queryComment->execute();
        $comment = $queryComment->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <form id="form" class="my-5" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

        <input type="hidden" name="id_commentaire" value="<?= isset($id_comment) ? $id_comment : '' ?>">

        <?php if ($_GET['action'] == 'add') : ?>
            <div class="form-group">
                <label for="commentaire">Commentaire: </label>
                <input type="text" class="form-control" id="commentaire_add" name="commentaire" required>
            </div>
        <?php elseif ($_GET['action'] == 'update') : ?>
            <div class="form-group">
                <label for="titre">Commentaire :</label>
                <input type="text" class="form-control" id="commentaire_update" name="commentaire" value="<?= isset($comment['commentaire']) ? $comment['commentaire'] : '' ?>" required>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </div>
    </form>
<?php endif; ?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_commentaire'], $_POST['commentaire'])) {

        if (!empty($_POST['id_commentaire'])) {
            $id_comment = $_POST['id_commentaire'];
            $comment = $_POST['commentaire'];

            $queryUpdateComment = $pdo->prepare("UPDATE commentaire SET commentaire = :commentaire WHERE id_commentaire= :id_commentaire");
            $queryUpdateComment->bindValue(':id_commentaire', $id_comment, PDO::PARAM_INT);
            $queryUpdateComment->bindValue(':commentaire', $comment, PDO::PARAM_STR);

            if ($queryUpdateComment->execute()) {
                echo "Le commentaire a été mis à jour avec succès.";
            } else {
                $errorInfo = $queryUpdateComment->errorInfo();
                echo "Erreur lors de la mise à jour du commentaire: " . $errorInfo[2];
            }
        } else {

            $comment = $_POST['commentaire'];


            $queryInsertComment = $pdo->prepare("INSERT INTO commentaire (commentaire) VALUES (:commentaire)");
            $queryInsertComment->bindValue(':commentaire', $comment, PDO::PARAM_STR);

            if ($queryInsertComment->execute()) {

                exit();
            } else {
                $errorInfo = $queryInsertComment->errorInfo();
                echo "Erreur lors de l'ajout du commentaire : " . $errorInfo[2];
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
                Êtes-vous sûr de vouloir supprimer ce commentaire ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Annuler</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('includeAdmin/footer.php'); ?>