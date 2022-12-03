<?php session_start();/*
if (!isset($_SESSION['username'])) {
    header('Location:loginForm.php');
}*/
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Casernes de Paris</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
</head>

<body>
    <div class="head">
        <img src="logo.svg" alt="" width="8%" height="8%">
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Rechercher une caserne..." aria-label="Search">
        </form>
        <h2>Bonjour <?php echo $_SESSION['username'] ?> !</h2>
        <h2><a href="account.html">Voir mon profil</a><br><a href="loginForm.php">Se déconnecter</a>
        </h2>
    </div>
    <div id="map">
    </div>

    <script src="script.js"></script>
</body>

</html>