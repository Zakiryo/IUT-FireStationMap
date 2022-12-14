<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://osmnames.org/api/v1/autocomplete.js"></script>
    <link href="https://osmnames.org/api/v1/autocomplete.css" rel="stylesheet" />
    <link rel="icon" href="img/logo.svg">
</head>

<body>
    <div class="registerLogin">
        <form action="phpFunctions/register.php" method="post">
            <h2>Nouveau visiteur ? Inscrivez-vous !</h2>
            <div class="mb-3">
                <label for="userName" class="form-label">Votre pseudonyme :</label>
                <input class="form-control" maxlength=90 name="registerUsername" id="userName" type="text" placeholder="Pseudo">
            </div>
            <div class="mb-3">
                <label for="registerMail" class="form-label">Votre adresse électronique valide :</label>
                <input type="email" maxlength=90 name="registerMail" class="form-control" id="registerMail" placeholder="exemple@exemple.com">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                <input type="password" maxlength=90 name="registerPassword" class="form-control" id="registerPassword">
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Votre nom de famille :</label>
                <input class="form-control" maxlength=90 name="registerLastName" id="lastName" type="text" placeholder="Nom">
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">Votre prénom :</label>
                <input class="form-control" maxlength=90 name="registerFirstName" id="firstName" type="text" placeholder="Prénom">
            </div>
            <div class="mb-3">
                <label for="registerAddress" class="form-label">Votre adresse principale :</label>
                <input class="form-control" maxlength=90 name="registerAddress" id="registerAddress" type="text" placeholder="Adresse principale">
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><label class="labels">Votre ville : </label><input type="text" maxlength=90 name="registerCity" class="form-control" placeholder="Ville" value=""></div>
                <div class="col-md-6"><label class="labels">Votre code postal : </label><input type="number" maxlength="5" min="10000" max="99999" name="registerCode" class="form-control" value="" placeholder="Code postal"></div>
            </div>
            <button type="submit" id="btnRegister" class="btn btn-primary">S'inscrire</button>
            <?php
            if (isset($_GET['register_error'])) {
                $error = htmlspecialchars($_GET['register_error']);
                switch ($error) {
                    case 'already_exist':
            ?>
                        <div class="alert alert-danger">
                            <b>Erreur : Ce compte existe déjà. Merci de choisir un mail ou un pseudo différent.</b>
                        </div>
                    <?php
                        break;
                    case 'empty':
                    ?>
                        <div class="alert alert-danger">
                            <b>Erreur : Veuillez remplir tous les champs.</b>
                        </div>
            <?php
                        break;
                }
            } ?>
            <?php
            if (isset($_GET['success'])) {
            ?>
                <div class="alert alert-success">
                    <b>Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.</b>
                </div>
            <?php
            }
            ?>
            <p class="bottomMessage"><a href="index.php">Retour à la connexion</a></p>
        </form>
    </div>
</body>

</html>