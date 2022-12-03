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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
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

                </div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Modifier vos informations : </h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Prénom</label><input type="text" class="form-control" placeholder="Votre nouveau prénom" value=""></div>
                        <div class="col-md-6"><label class="labels">Nom de famille</label><input type="text" class="form-control" value="" placeholder="Votre nouveau nom"></div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Mettre à jour votre profil</button></div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
</body>

</html>