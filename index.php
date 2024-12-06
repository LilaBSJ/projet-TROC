<?php
require_once('include/init.php');



require_once('include/header.php');
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <div class="container-lg">
        </div>
    </ol>
</nav>

<div class="container-lg">
    <div class="row">
        <div class="col-lg-3 d-none d-lg-block">
            <div class="list-group">
                <div class="form-group">
                    <label for="categorie" style="font-weight: bold; font-size: 1em;">Catégorie</label>
                    <select class="form-control" id="categorie" onchange="filterAnnonces(this.value)">
                        <option value="toutes">Toutes catégories</option>
                        <option value="emploi">Emploi</option>
                        <option value="vehicule">Véhicule</option>
                        <option value="immobilier">Immobilier</option>
                        <option value="vacances">Vacances</option>
                        <option value="multimedia">Multimédia</option>
                        <option value="loisirs">Loisirs</option>
                        <option value="materiel">Matériel</option>
                        <option value="services">Services</option>
                        <option value="maison">Maison</option>
                        <option value="vetements">Vêtements</option>
                        <option value="autres">Autres</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ville" style="font-weight: bold; font-size: 1em;">Ville</label>
                    <select class="form-control" id="ville">
                        <option value="toutes">Toutes les villes</option>
                        <option value="paris">Paris</option>
                        <option value="amiens">Amiens</option>
                        <option value="reims">Reims</option>
                        <option value="toulouse">Toulouse</option>
                        <option value="marseille">Marseille</option>
                        <option value="strasbourg">Strasbourg</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="membre" style="font-weight: bold; font-size: 1em;">Membre</label>
                    <select class="form-control" id="membre">
                        <option value="tous">Tous les membres</option>
                        <option value="particulier">Particulier</option>
                        <option value="professionnel">Professionnel</option>
                    </select>
                </div>

                <label for="prix" style="font-weight: bold; font-size: 1em">Prix</label>
                <input type="range" class="form-range" id="prix" name="prix" min="0" max="10000" step="10" value="500">
                <p>Maximum <span id="valeurPrix">10000</span> €</p>
                <script>
                    document.getElementById("prix").addEventListener("input", function() {
                        document.getElementById("valeurPrix").innerHTML = this.value;
                    });

                    function filterAnnonces(categorie) {
                        window.location.href = "index.php?categorie=" + categorie;
                    }
                </script>
            </div>
        </div>

        <div class="col-lg-9">
            <label for="tri" style="font-weight: bold; font-size: 1em;">Option de tri</label>
            <select class="form-control float-end" id="tri" onchange="changeTri()">
                <option value="prix_asc">Trier par prix (du moins cher au plus cher)</option>
                <option value="prix_desc">Trier par prix (du plus cher au moins cher)</option>
                <option value="date_asc">Trier par date (de la plus ancienne à la plus récente)</option>
                <option value="date_desc">Trier par date (de la plus récente à la plus ancienne)</option>
                <option value="meilleurs_vendeurs">Trier par les meilleurs vendeurs en premier</option>
                <option value="meilleures_notes">Trier par les meilleures notes en premier</option>
            </select>
            <?php
             $id_categorie = isset($_GET['categorie']) ? $_GET['categorie'] : 'toutes';
             $tri = isset($_GET['tri']) ? $_GET['tri'] : 'id_annonce DESC';
             $query = "SELECT a.id_annonce, a.titre, a.desc_courte, a.prix, p.photo, n.note, n.avis, n.created_at as created_at, u.prenom as prenom
             FROM annonce a
             LEFT JOIN photo p ON a.id_photo = p.id_photo
             LEFT JOIN categorie c ON a.id_categorie = c.id_categorie
             LEFT JOIN note n ON a.id_user = n.id_user_auteur
            LEFT JOIN user u ON n.id_user_auteur = u.id_user";
            if ($id_categorie != 'toutes') {
                $query .= " WHERE c.titre = :titre_categorie";
            }

            $query .= " GROUP BY a.id_annonce ORDER BY ";
            switch ($tri) {
                 case 'prix_asc':
                     $query .= "a.prix ASC";
                     break;
                 case 'prix_desc':
                     $query .= "a.prix DESC";
                     break;
                 case 'date_asc':
                     $query .= "a.created_at ASC";
                     break;
                 case 'date_desc':
                     $query .= "a.created_at DESC";
                     break;
                 case 'meilleurs_vendeurs':
                     $query .= "a.meilleurs_vendeurs DESC";
                     break;
                 case 'meilleures_notes':
                     $query .= "moyenne_notes DESC";
                     break;
                 default:
                     $query .= "a.id_annonce DESC";
             }
 
             $stmt = $pdo->prepare($query);

             if ($id_categorie != 'toutes') {
                 $stmt->bindValue(':titre_categorie', $id_categorie, PDO::PARAM_STR);
             }
 
             $stmt->execute();
 
             if ($stmt && $stmt->rowCount() > 0) {
                 $counter = 0;
                 while ($annonce = $stmt->fetch(PDO::FETCH_ASSOC)) {
                     if ($counter % 2 == 0) {
                         echo '<div class="row">';
                     }
                     ?>
                     <div class="col-lg-6 mb-4">
                         <a href="fiche_annonce.php?id=<?= $annonce['id_annonce'] ?>" class="card-link">
                             <div class="card h-100">
                                 <img src="<?= URL . "img/" . basename($annonce['photo']) ?>" class="card-img-top"
                                      alt="<?= $annonce['titre'] ?>">
                                 <div class="card-body">
                                     <h5 class="card-title"><?= $annonce['titre'] ?></h5>
                                     <p class="card-text"><?= $annonce['desc_courte'] ?></p>
                                     <p class="card-text"><?= $annonce['prix'] ?> €</p>
                                     <?php if ($tri == 'note') : ?>
                                         <p>Note moyenne: <?= round($annonce['note'], 1) ?>/5</p>
                                     <?php endif; ?>
                                     <p><?= $annonce['prenom'] ?></p>
                                 </div>
                             </div>
                         </a>
                     </div>
                     <?php
                     $counter++;
                     if ($counter % 2 == 0) {
                         echo '</div>';
                     }
                 }
                 $stmt->closeCursor();
             } else {
                 echo "<div class='col-lg-12'><p>Aucune annonce n'a été trouvée.</p></div>";
             }
             ?>
         </div>
     </div>
 </div>
<?php
require_once('include/footer.php');
?>
