<?php
require_once('include/init.php');

if (!connexionUser()) {
    
    header('location:' . URL . 'connexion.php');
    exit();
}
if (isset($_GET['id_annonce'])) {
    $id_annonce = $_GET['id_annonce'];
}
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (isset($_POST['id_annonce'])) {
        $id_annonce = $_POST['id_annonce'];
        $commentaire = $_POST['commentaire'];
    
        $addComment = $pdo->prepare("INSERT INTO commentaire (id_user, id_annonce, commentaire, created_at) VALUES (:id_user, :id_annonce, :commentaire, NOW())");
        $addComment->bindValue(':id_user', $id_user, PDO::PARAM_INT);
        $addComment->bindValue(':id_annonce', $id_annonce, PDO::PARAM_INT);
        $addComment->bindValue(':commentaire', $_POST['commentaire'], PDO::PARAM_STR);
        $addComment->execute();
        header('Location: depot_commentaire.php?success=1');
        exit();
    } 
}
require_once('include/header.php');
?>

<div class="container" style="background-color: #d4f2e7">
    <h1 class="text-center">Déposer un commentaire</h1>
 
    <?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
        <div class="alert alert-success" role="alert">
            Le commentaire a été ajouté avec succès.
        </div>
    <?php endif; ?>
    <form method="POST" action="" class="needs-validation" novalidate style="background-color: #d4f2e7; padding: 50px; border-radius: 8px; border: 1px solid #2ecc71;" enctype="multipart/form-data">
    <input type="hidden" name="id_annonce" value="<?= $id_annonce ?>">
    
        <div class="form-group">
            <label for="commentaire">Commentaire :</label>
            <textarea class="form-control" id="commentaire" name="commentaire" rows="3" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" type="submit" style="background-color: #2ecc71; border-color: #2ecc71;">Publier</button>
            </div>
        </div>
    </form>
</div>

<?php
require_once('include/footer.php');
?>
