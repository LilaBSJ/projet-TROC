<?php require_once('../include/init.php');

if (!connexionAdmin()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

$queryNoteCount = $pdo->query("SELECT COUNT(id_note) AS nombreNotes FROM note");
$resultNoteCount = $queryNoteCount->fetch();
$numberNote = (int)$resultNoteCount['nombreNotes'];

$parPage = 5;
$numberPages = ceil($numberNote / $parPage);
$pageNow = isset($_GET['page']) && !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$firstNote = ($pageNow - 1) * $parPage;

$queryNoteList = $pdo->query("SELECT n.id_note, n.id_user_notant, u1.email AS email_notant, n.id_user_auteur, u2.email AS email_auteur, n.note, n.avis, n.created_at 
                              FROM note n 
                              JOIN user u1 ON n.id_user_notant = u1.id_user 
                              JOIN user u2 ON n.id_user_auteur = u2.id_user 
                              LIMIT $firstNote, $parPage");
?>

<?php require_once('includeAdmin/header.php'); ?>

<h1 class="text-center my-5">
    <div class="badge badge-warning text-wrap p-3">Gestion des notes</div>
</h1>

<?php $queryNoteCount = $pdo->query("SELECT id_note FROM note") ?>
<h2 class="py-5">Nombre de notes en BDD: <?= $queryNoteCount->rowCount() ?></h2>
<div class="row justify-content-center py-5">
    <a href='?action=add'>
        <button type="button" class="btn btn-lg btn-outline-success shadow rounded font-weight-bold">
            <i class="bi bi-plus-circle-fill"></i> Ajouter une note
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
                <th>ID Note</th>
                <th>ID User Notant</th>
                <th>ID User Auteur</th>
                <th>Note</th>
                <th>Avis</th>
                <th>Date d'enregistrement</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($note = $queryNoteList->fetch(PDO::FETCH_ASSOC)) : ?>
                <tr>
                    <td><?= $note['id_note'] ?></td>
                    <td><?= $note['id_user_notant'] ?> (<?= $note['email_notant'] ?>)</td>
                    <td><?= $note['id_user_auteur'] ?> (<?= $note['email_auteur'] ?>)</td>
                    <td><?= $note['note'] ?></td>
                    <td><?= $note['avis'] ?></td>
                    <td><?= $note['created_at'] ?></td>
                    <td>
                        <a href='?action=update&id_note=<?= $note['id_note'] ?>'><i class="bi bi-pen-fill text-warning"></i></a>
                        <a href="?action=delete&id_note=<?= $note['id_note'] ?>" toggle="modal" data-target="#confirm-delete"><i class="bi bi-trash-fill text-danger"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id_note'])) {
    $id_note = $_GET['id_note'];

    $query = $pdo->prepare("DELETE FROM note WHERE id_note = :id_note");
    $query->execute([':id_note' => $id_note]);
}
?>


<?php if (isset($_GET['action']) && ($_GET['action'] == 'add' || $_GET['action'] == 'update')) : ?>
    <h2 class="my-5">Formulaire <?= ($_GET['action'] == "add") ? "d'ajout" : "de modification" ?></h2>

    <?php
    $id_note = null;
    if (isset($_POST['id_note'])) {
        $id_note = $_POST['id_note'];
    } elseif (isset($_GET['id_note'])) {
        $id_note = $_GET['id_note'];
    }

    $note = null;
    if ($id_note !== null) {
        $queryNote = $pdo->prepare("SELECT note, avis FROM note WHERE id_note = :id_note");
        $queryNote->bindValue(':id_note', $id_note, PDO::PARAM_INT);
        $queryNote->execute();
        $note = $queryNote->fetch(PDO::FETCH_ASSOC);
    }
    ?>
<form id="form" class="my-5" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

<input type="hidden" name="id_note" value="<?= isset($id_note) ? $id_note : '' ?>">

<?php if ($_GET['action'] == 'add') : ?>
    <div class="form-group">
        <label for="note">Note: </label>
        <input type="text" class="form-control" id="note_add" name="note" required>
    </div>
<?php elseif ($_GET['action'] == 'update') : ?>
    <div class="form-group">
        <label for="note">Note :</label>
        <input type="text" class="form-control" id="note_update" name="note" value="<?= isset($note['note']) ? $note['note'] : '' ?>" required>
    </div>
    <div class="form-group">
        <label for="avis">Avis :</label>
        <input type="text" class="form-control" id="avis_update" name="avis" value="<?= isset($note['avis']) ? $note['avis'] : '' ?>" required>
    </div>
<?php endif; ?>

<div class="text-center mt-4">
    <button type="submit" class="btn btn-primary">Soumettre</button>
</div>
</form> 

<?php endif; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id_note'], $_POST['note'])) {

        if (!empty($_POST['id_note'])) {
            $id_note = $_POST['id_note'];
            $note = $_POST['note'];
            $avis = $_POST['avis'];

            $queryUpdateNote = $pdo->prepare("UPDATE note SET note = :note, avis = :avis WHERE id_note = :id_note");
            $queryUpdateNote->bindValue(':id_note', $id_note, PDO::PARAM_INT);
            $queryUpdateNote->bindValue(':note', $note, PDO::PARAM_STR);
            $queryUpdateNote->bindValue(':avis', $avis, PDO::PARAM_STR);
            

            if ($queryUpdateNote->execute()) {
                echo "La note a été mise à jour avec succès.";
            } else {
                $errorInfo = $queryUpdateNote->errorInfo();
                echo "Erreur lors de la mise à jour de la note: " . $errorInfo[2];
            }
        } else {

            $comment = $_POST['note'];


            $queryInsertComment = $pdo->prepare("INSERT INTO note(note) VALUES (:note)");
            $queryInsertComment->bindValue(':note', $comment, PDO::PARAM_STR);

            if ($queryInsertComment->execute()) {

                exit();
            } else {
                $errorInfo = $queryInsertComment->errorInfo();
                echo "Erreur lors de l'ajout de la note : " . $errorInfo[2];
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
                Êtes-vous sûr de vouloir supprimer cette note ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Annuler</button>
                <a class="btn btn-danger btn-ok">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('includeAdmin/footer.php'); ?>
