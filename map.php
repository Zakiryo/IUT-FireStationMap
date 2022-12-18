<?php session_start();
if (!isset($_SESSION['username'])) {
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Casernes de Paris</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/logo.svg">
</head>

<body>
    <div class="head">
        <img src="img/logo.svg" alt="" width="8%" height="8%">
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Rechercher une caserne..." aria-label="Search">
        </form>
        <h2>Bonjour <?php echo $_SESSION['username'] ?> !</h2>
        <h2><a href="account.php">Voir mon profil</a><br><a href="phpFunctions/disconnect.php">Se déconnecter</a>
        </h2>
    </div>
    <div id="map">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="mapLoad.js"></script>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="toggleFavorite" onchange="displayFavorites();">
        <label class="form-check-label" for="toggleFavorite">
            N'afficher que vos favoris
        </label>
    </div>
</body>

</html>