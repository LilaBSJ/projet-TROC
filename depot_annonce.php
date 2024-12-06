<?php
require_once('include/init.php');

if ($_POST) {
    
    $uploadDir = RACINE_SITE . 'img/';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileInfo = $_FILES['photo'];
    if ($fileInfo['error'] === UPLOAD_ERR_OK) {
        $uploadFile = $uploadDir . basename($fileInfo['name']);
        if (move_uploaded_file($fileInfo['tmp_name'], $uploadFile)) {
            $addPhoto = $pdo->prepare("INSERT INTO photo (photo) VALUES (:photo)");
            $addPhoto->bindValue(':photo', $uploadFile, PDO::PARAM_STR);
            $addPhoto->execute();
            $id_photo = $pdo->lastInsertId();

            $addAnnonce = $pdo->prepare("INSERT INTO annonce (titre, desc_courte, desc_longue, prix, pays, ville, adresse, cp, id_user, id_photo, id_categorie, created_at) VALUES (:titre, :desc_courte, :desc_longue, :prix, :pays, :ville, :adresse, :cp, :id_user, :id_photo, :id_categorie, NOW())");
            $addAnnonce->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
            $addAnnonce->bindValue(':desc_courte', $_POST['desc_courte'], PDO::PARAM_STR);
            $addAnnonce->bindValue(':desc_longue', $_POST['desc_longue'], PDO::PARAM_STR);
            $addAnnonce->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
            $addAnnonce->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
            $addAnnonce->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
            $addAnnonce->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
            $addAnnonce->bindValue(':cp', $_POST['cp'], PDO::PARAM_STR);
            $addAnnonce->bindValue(':id_user', $_SESSION['user']['id_user'], PDO::PARAM_INT);
            $addAnnonce->bindValue(':id_photo', $id_photo, PDO::PARAM_INT);
            $addAnnonce->bindValue(':id_categorie', $_POST['categorie'], PDO::PARAM_INT);
            $addAnnonce->execute();
            header('location:' . URL . 'connexion.php?action=validate');
            exit();
        }      
    
}
}
require_once('include/header.php');
?>
<?php echo $erreur ?>
<div class="container" style="background-color: #d4f2e7">
    <h1 class="text-center">Déposer une annonce</h1>
    <form method="POST" action="" class="needs-validation" novalidate style="background-color: #d4f2e7; padding: 20px; border-radius: 8px; border: 1px solid #2ecc71;" enctype="multipart/form-data">
        <div class="form-group">
            <label for="titre">Titre de l'annonce :</label>
            <input type="text" class="form-control" id="titre" name="titre" required>
        </div>
        <div class="form-group">
            <label for="desc_courte">Description courte :</label>
            <textarea class="form-control" id="desc_courte" name="desc_courte" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="desc_longue">Description longue :</label>
            <textarea class="form-control" id="desc_longue" name="desc_longue" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="prix">Prix :</label>
            <input type="number" class="form-control" id="prix" name="prix" required>
        </div>
        <div class="form-group">
            <label for="photo">Photo :</label>
            <br>
            <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*">
        </div>
        <div class="form-group">
    <label for="pays">Pays :</label>
    <select class="form-select" id="pays" name="pays" required>
        <option value="France" selected>France</option>
    </select>
</div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="ville" class="form-label">Ville</label>
                <select class="form-select" id="ville" name="ville">
                    <option value="Paris">Paris</option>
                    <option value="Reims">Reims</option>
                    <option value="Toulouse">Toulouse</option>
                    <option value="Marseille">Marseille</option>
                    <option value="Strasbourg">Strasbourg</option>
                    <option value="Amiens">Amiens</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="adresse">Adresse :</label>
            <input type="text" class="form-control" id="adresse" name="adresse" required>
        </div>
        <div class="form-group">
            <label for="cp">Code postal :</label>
            <input type="text" class="form-control" id="cp" name="cp" required>
        </div>

        <div class="form-group">
            <label for="categorie">Catégorie :</label>
            <select class="form-control" id="categorie" name="categorie" required>
                <option value="">Sélectionnez une catégorie</option>
                <?php
    
                $query = $pdo->query("SELECT id_categorie, titre FROM categorie");
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['id_categorie'] . '">' . $row['titre'] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" type="submit" style="background-color: #2ecc71; border-color: #2ecc71;">Enregistrer une annonce</button>

            </div>
        </div>

    </form>
</div>


<?php
require_once('include/footer.php');
?>