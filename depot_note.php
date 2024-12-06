<?php
require_once('include/init.php');

if (!connexionUser()) {
    header('location:' . URL . 'connexion.php');
    exit();
}

$id_user = null; 
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $pseudo = $user['pseudo'];

    $query = $pdo->prepare("SELECT id_user FROM user WHERE pseudo = :pseudo");
    $query->execute(array(':pseudo' => $pseudo));
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $id_user = $result['id_user'];
    }
}

$id_annonce = null; // Initialisation de $id_annonce à null
if (isset($_GET['id_annonce'])) {
    $id_annonce = $_GET['id_annonce'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['note']) && isset($_POST['avis']) && isset($id_user) && isset($id_annonce)) {
        $note = $_POST['note'];
        $avis = $_POST['avis'];

        $queryAnnonce = $pdo->prepare("SELECT id_user FROM annonce WHERE id_annonce = :id_annonce");
        $queryAnnonce->execute(array(':id_annonce' => $id_annonce));
        $resultAnnonce = $queryAnnonce->fetch(PDO::FETCH_ASSOC);
        if ($resultAnnonce) {
            $id_user_auteur = $resultAnnonce['id_user'];

            $addNote = $pdo->prepare("INSERT INTO note (id_user_notant, id_user_auteur, note, avis, created_at) VALUES (:id_user_notant, :id_user_auteur, :note, :avis, NOW())");
            $addNote->bindValue(':id_user_notant', $id_user, PDO::PARAM_INT);
            $addNote->bindValue(':id_user_auteur', $id_user_auteur, PDO::PARAM_INT); 
            $addNote->bindValue(':note', $_POST['note'], PDO::PARAM_STR);
            $addNote->bindValue(':avis', $_POST['avis'], PDO::PARAM_STR);
            $addNote->execute();
            header('Location: depot_note.php?success=1');
            exit();
        } 
    }
}

require_once('include/header.php');
?>

<div class="container mt-5">
    <h1>Déposer une note et avis</h1>
    <form method="POST" action="">
        <input type="hidden" name="id_annonce" value="<?= $id_annonce ?>">

        <div class="form-group">
            <label for="note">Note :</label>
            <select class="form-control" id="note" name="note" required>
                <option value="">Sélectionnez une note</option>
                <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <option value="<?= $i ?>"><?= $i ?>/5</option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="avis">Avis :</label>
            <textarea class="form-control" id="avis" name="avis" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Publier</button>
    </form>
</div>

 
<?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
    <div class="alert alert-success" role="alert">
        La note a été ajoutée avec succès.
    </div>
<?php endif; ?>

<?php require_once('include/footer.php'); ?>
