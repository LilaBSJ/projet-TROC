<?php
require_once('include/init.php');
require_once('include/header.php');
?>

<div class="container border border-3 border-success p-4" style="background-color: #d4edda;">
    <h2 class="text-center mb-4">Contactez-nous</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

    
        $nom = filter_var($nom, FILTER_VALIDATE_REGEXP);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $message = filter_var($message,FILTER_SANITIZE_SPECIAL_CHARS);

        $to = "varnava@gmail.com";
        $subject = "Nouveau message de contact de $nom";
        $body = "De: $nom Email: $email Message: $message";
        $headers = "From: $email";
        if (mail($to, $subject, $body, $headers)) {
            echo "<p class='alert alert-success'>Votre message a été envoyé avec succès. Nous vous répondrons dès que possible.</p>";
        } else {
            echo "<p class='alert alert-danger'>Une erreur s'est produite lors de l'envoi du message. Veuillez réessayer plus tard.</p>";
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom :</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email :</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Message :</label>
            <textarea id="message" name="message" rows="4" class="form-control" required></textarea>
        </div>

        <div class="d-grid gap-2 justify-content-center">
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
    </form>
</div>

<?php
require_once('include/footer.php');
?>


