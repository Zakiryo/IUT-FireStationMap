<?php session_start();
if (!isset($_SESSION['username'])) {
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Profil - <?php echo $_SESSION['username']; ?></title>
    <link rel="stylesheet" href="account.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="icon" href="img/logo.svg">
</head>

<body>
    <div class="head">
        <img src="img/logo.svg" alt="" width="8%" height="8%" onclick="window.location.href='map.php';" id="logo">
        <h2>Profil de <?php echo $_SESSION['username'] ?></h2>
        <h2><a href="account.php">Voir mon profil</a><br><a href="phpFunctions/disconnect.php">Se déconnecter</a>
        </h2>
    </div>
    <hr>
    <form method="post" action="phpFunctions/updateAccount.php">
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                        <span class="font-weight-bold"><?php echo $_SESSION['username'] ?></span>
                        <span class="text-black-50"><?php echo $_SESSION['mail'] ?></span>
                        <div class="row mt-2">
                            <span class="col-md-6"><?php echo $_SESSION['firstname'] ?></span>
                            <span class="col-md-6"><?php echo $_SESSION['lastname'] ?></span>
                        </div>
                        <span class="text-black-50"><?php echo $_SESSION['mainaddress'] ?></span>
                    </div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Modifier vos informations : </h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Prénom</label><input type="text" maxlength=90 name="modifyFirstName" class="form-control" placeholder="Votre nouveau prénom" value=""></div>
                            <div class="col-md-6"><label class="labels">Nom de famille</label><input type="text" maxlength=90 name="modifyLastName" class="form-control" value="" placeholder="Votre nouveau nom"></div>
                        </div>
                        <br>
                        <div class="mb-3">
                            <label for="modifyMail" class="form-label">Votre nouvelle adresse électronique</label>
                            <input type="email" maxlength=90 name="modifyMail" class="form-control" id="modifyMail" placeholder="exemple@exemple.com">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Merci de retaper votre mot de passe : </label>
                            <input type="password" maxlength=90 name="confirmPassword" class="form-control" id="confirmPassword">
                        </div>
                        <div class="mt-5 text-center">
                            <button class="btn btn-secondary" id="backToMap" type="button" onclick="window.location.href='map.php';">Retour à la carte</button>
                            <button class="btn btn-primary profile-button" id="confirmModify" type="submit">Mettre à jour votre profil</button>
                        </div>
                        <?php
                        if (isset($_GET['update_error'])) {
                            $error = htmlspecialchars($_GET['update_error']);
                            switch ($error) {
                                case 'all_empty':
                        ?>
                                    <div class="alert alert-danger">
                                        <b>Erreur : Merci de remplir au moins un champ.</b>
                                    </div>
                                <?php
                                    break;

                                case 'wrong_password':
                                ?>
                                    <div class="alert alert-danger">
                                        <b>Erreur : Le mot de passe saisi est incorrect.</b>
                                    </div>
                                <?php
                                    break;
                                case 'password_not_set':
                                ?>
                                    <div class="alert alert-danger">
                                        <b>Erreur : Merci de saisir votre mot de passe.</b>
                                    </div>
                                <?php
                                    break;
                                case 'already_exist':
                                ?>
                                    <div class="alert alert-danger">
                                        <b>Erreur : L'adresse électronique saisie existe déjà. Merci d'en choisir une autre.</b>
                                    </div>
                        <?php
                                    break;
                            }
                        }
                        ?>
                    </div>
                </div>
    </form>
    <div class="col-md-4 border-right" id="listAddresses">
        <div class="d-flex flex-column align-items-center text-center p-7 py-5">
            <span class="font-weight-bold">Vos adresses : </span>
            <span class="text-black-50"><?php echo $_SESSION['mainaddress'] ?></span>
            <?php
            foreach ($_SESSION["addresses"] as $address) {
                $index = 0;
            ?><span class="text-black-50"><?php echo $address['libelle'] ?>
                    <form method="post" action="phpFunctions/deleteAddress.php">
                        <input type="hidden" name="addressID" value="<?php echo $address['id'] ?>">
                        <input type="hidden" name="keyValue" value="<?php echo $index ?>">
                        <button type="submit" class="btn btn-outline-danger">Supprimer</button>
                    </form>
                </span>
            <?php ++$index;
            } ?>
        </div>
        <form method="post" action="phpFunctions/addAddress.php" style="text-align: center;">
            <div class="mb-3">
                <input class="form-control" name="newAddress" id="newAddress" type="text" maxlength=90 placeholder="Intitulé de l'adresse">
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><input type="text" maxlength=90 name="newCity" class="form-control" placeholder="Ville" value=""></div>
                <div class="col-md-6"><input type="number" maxlength="5" min="10000" max="99999" name="newCode" class="form-control" value="" placeholder="Code postal"></div>
            </div>
            <button type="submit" class="btn btn-outline-success" style="margin:1em;">Ajouter une nouvelle adresse</button>
        </form>
    </div>
</body>

</html>