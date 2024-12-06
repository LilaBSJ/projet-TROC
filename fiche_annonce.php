<?php
require_once('include/init.php');
require_once('include/header.php');

if (isset($_GET['id'])) {

    $id_annonce = $_GET['id'];

    $queryCommentaires = $pdo->prepare("SELECT c.commentaire, u.pseudo FROM commentaire c INNER JOIN user u ON c.id_user = u.id_user WHERE c.id_annonce = :id_annonce");
    $queryCommentaires->execute(array(':id_annonce' => $id_annonce));
    $commentaires = $queryCommentaires->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT a.titre, a.desc_longue, a.prix, a.created_at, p.photo, u.prenom, n.note, a.adresse, a.cp, a.ville, u.telephone
          FROM annonce a
          LEFT JOIN photo p ON a.id_photo = p.id_photo
          LEFT JOIN user u ON a.id_user = u.id_user
          LEFT JOIN note n ON a.id_user = n.id_user_auteur
          WHERE a.id_annonce = :id_annonce";

    $statement = $pdo->prepare($query);
    $statement->execute(array(':id_annonce' => $id_annonce));
    $annonce = $statement->fetch(PDO::FETCH_ASSOC);

    if ($annonce) {
?>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-12 text-right">
                    <button id="contactBtn" class="btn btn-primary" style="font-size: 1rem;">Contacter <?= $annonce['prenom'] ?></button>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="card-title" style="font-size: 2rem; font-weight: bold;"><?= $annonce['titre'] ?></h5>
                    <div class="card">
                        <img src="<?= URL . "img/" . basename($annonce['photo']) ?>" class="card-img-top" alt="<?= $annonce['titre'] ?>" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                        <div class="card-body" style="padding: 20px;">
                            <p class="card-text" style="font-size: 1.2rem; color: #555;"><i class="bi bi-calendar"></i> Date de publication: <?= date('d/m/Y', strtotime($annonce['created_at'])) ?></p>
                            <?php if (isset($annonce['prenom'])) : ?>
                                <p class="card-text" style="font-size: 1.2rem; color: #555;"><i class="bi bi-person"></i> <?= $annonce['prenom'] ?></p>
                            <?php endif; ?>
                            <?php if (isset($annonce['note']) && is_int($annonce['note']) && $annonce['note'] >= 0 && $annonce['note'] <= 5) : ?>
    <p class="card-text" style="font-size: 1.2rem; color: #555;">Note attribuée: <?= $annonce['note'] ?>/5</p>
<?php else : ?>
    <p class="card-text" style="font-size: 1.2rem; color: #555;">Aucune note disponible</p>
<?php endif; ?>


                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <h5 class="card-title">Description</h5>
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text"><?= $annonce['desc_longue'] ?></p>
                            <p class="card-text"><i class="fas fa-euro-sign"></i> <?= $annonce['prix'] ?></p>
                            <p class="card-text"><i class="fas fa-map-marker-alt"></i> <?= $annonce['adresse'] ?>, <?= $annonce['cp'] ?> <?= $annonce['ville'] ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-4">
    <h5 class="card-title">Commentaires</h5>
    <div class="card">
        <div class="card-body">
            <?php if (!empty($commentaires)) : ?>
                <ul class="list-group">
                    <?php foreach ($commentaires as $commentaire) : ?>
                        <li class="list-group-item"><?= $commentaire['commentaire'] ?> - <?= $commentaire['pseudo'] ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="card-text">Aucun commentaire pour cette annonce.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

        <?php
    } else {

        echo "<div class='container'><p>Aucune annonce n'a été trouvée avec cet identifiant.</p></div>";
    }
} else {

    echo "<div class='container'><p>L'ID de l'annonce n'a pas été spécifié dans l'URL.</p></div>";
}
        ?>
        <div class="col-md-12">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.546929550671!2d2.297415175614064!3d48.84778020145429!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e67022b8199c2d%3A0xe7c31bfb1f245dc9!2s39%20Rue%20Fr%C3%A9micourt%2C%2075015%20Paris!5e0!3m2!1sfr!2sfr!4v1707159194706!5m2!1sfr!2sfr" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
            </div>

            <div class="d-flex justify-content-between mt-3 mb-5">
                <a href="depot_commentaire.php?id_annonce=<?= $id_annonce ?>" class="btn btn-secondary">Déposer un commentaire</a>
                <a href="depot_note.php?id_annonce=<?= $id_annonce ?>" class="btn btn-info mr-2">Déposer une note</a>
                <a href="index.php" class="btn btn-primary">Retour vers les annonces</a>
            </div>
        </div>


        <?php require_once('include/footer.php');
