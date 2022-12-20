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
        <form action="phpFunctions/login.php" method="post">
            <?php
            if (isset($_GET['disconnected'])) {
            ?>
                <div class="alert alert-success">
                    <b>Vous avez bien été déconnecté.</b>
                </div>
            <?php
            }
            ?>
            <?php
            if (isset($_GET['update_success'])) {
            ?>
                <div class="alert alert-success">
                    <b>Vos informations ont été mises à jour ! Merci de vous reconnecter.</b>
                </div>
            <?php
            }
            ?>
            <?php
            if (isset($_GET['success'])) {
            ?>
                <div class="alert alert-success">
                    <b>Votre compte vient d'être créé ! Vous pouvez maintenant vous connecter.</b>
                </div>
            <?php
            }
            ?>
            <h2>Se connecter</h2>
            <div class="mb-3">
                <label for="loginMail" class="form-label">Adresse électronique</label>
                <input type="email" maxlength=90 name="loginMail" class="form-control" id="loginMail" placeholder="exemple@exemple.com">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                <input type="password" maxlength=90 name="loginPassword" class="form-control" id="loginPassword">
            </div>
            <button type="submit" class="btn btn-primary">Connexion</button>
            <?php
            if (isset($_GET['login_error'])) {
                $error = htmlspecialchars($_GET['login_error']);
                switch ($error) {
                    case 'password':
            ?>
                        <div class="alert alert-danger">
                            <b>Erreur : Mot de passe incorrect.</b>
                        </div>
                    <?php
                        break;

                    case 'not_exist':
                    ?>
                        <div class="alert alert-danger">
                            <b>Erreur : Compte inexistant.</b>
                        </div>
            <?php
                        break;
                }
            }
            ?>
            <p class="bottomMessage"><a href="registerPage.php">Créer un compte</a></p>
        </form>
    </div>
</body>

</html>