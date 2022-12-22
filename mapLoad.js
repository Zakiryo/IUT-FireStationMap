const stations = L.layerGroup(); //Groupe comportant toutes les casernes
const favorites = L.layerGroup(); //Groupe comportant uniquement les casernes favorites de l'utilisateur
const map = L.map('map').setView([48.866295694987045, 2.3440361022949223], 13);
const save = []; //Sert de variable temporaire à la recherche des casernes
let routing; //Contient l'itinéraire courant généré par l'utilisateur
let saveFav = []; //Sert de variable temporaire à l'ajout de favoris
let isFavoriteDisplay = false; //Statut d'affichage des casernes favorites
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

/**
 * Récupération de l'adresse principale de l'utilisateur
 */
const mainAddress = function () {
    let tmp = null;
    $.ajax({
        async: false,
        type: "POST",
        url: "phpFunctions/getMainAddress.php",
        datatype: "json",
        success:
            function (data) {
                tmp = JSON.parse(data);
            }
    });
    return tmp;
}();

/**
 * Récupération de toutes les adresses secondaires de l'utilisateur
 */
const addresses = function () {
    let tmp = null;
    $.ajax({
        async: false,
        type: "POST",
        url: "phpFunctions/getAddresses.php",
        datatype: "json",
        success:
            function (data) {
                tmp = JSON.parse(data);
            }
    });
    return tmp;
}();

$(document).ready(() => {
    $("input").keyup(searchStation);
    initMap();
});

/**
 * Initialise la carte des casernes de Paris et sa grande ceinture et implémente des marqueurs faisant appel à différentes fonctions
 */
function initMap() {
    $('.leaflet-control-attribution').hide();
    $.ajax({
        url: 'casernes.json',
        success: function (data) {
            $.each(data, function (i) {
                let strAdr = "";
                let address = `${mainAddress['ADDRESS']}, ${mainAddress['POSTALCODE']} ${mainAddress['CITY']}`;
                addresses.forEach(function (adr) {
                    let buildedAdr = `${adr['ADDRESS']}, ${adr['POSTALCODE']} ${adr['CITY']}`;
                    strAdr += `<li onclick="createRoute('${data[i].fields.geo_point_2d}', '${buildedAdr}');"><a class="dropdown-item">${buildedAdr}</a></li>`;
                });
                const marker = L.marker(data[i].fields.geo_point_2d);
                stations.addLayer(marker);
                marker.bindPopup(`Secteur : ${data[i].fields.deno_cs}</br>
                                Adresse : ${data[i].fields.adresse}</br>
                                <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    S'y rendre depuis
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li onclick="createRoute('${data[i].fields.geo_point_2d}', '${address}');"><a class="dropdown-item">${address}</a></li>
                                    ${strAdr}
                                </ul>
                                </div>
                                <button type="button" class="btn btn-warning"
                                onclick="checkFavorite('${data[i].fields.deno_cs}') ? deleteFavorite('${data[i].fields.deno_cs}') : addToFavorite('${data[i].fields.deno_cs}');">
                                ${checkFavorite(data[i].fields.deno_cs) ? "Supprimer des favoris" : "Ajouter aux favoris"}</button>
                                `);
                if (checkFavorite(data[i].fields.deno_cs))
                    favorites.addLayer(marker); //Ajoute les favoris de l'utilisateur au layerGroup
                marker.getPopup().on('remove', function () {
                    if (typeof routing !== 'undefined')
                        map.removeControl(routing); //Si un itinéraire est initialisé, le supprimer lors de la fermeture du marqueur
                });
            });
            stations.addTo(map);
        }
    });
}

/**
 * Événement n'affichant sur la carte que les marqueurs dont le secteur correspond à ce qui a été saisi dans la barre de recherche
 * @param {object} e 
 */
function searchStation(e) {
    let search = e.target.value;
    stations.eachLayer(function (layer) {
        if (!layer.getPopup().getContent().includes(search.toUpperCase())) {
            save.push(layer);
            stations.removeLayer(layer);
        }
    });
    save.forEach(element => {
        if (element.getPopup().getContent().includes(search.toUpperCase()))
            stations.addLayer(element)
    });
}

/**
 * Si actif, n'affiche que les casernes favorites de l'utilisateur
 */
function displayFavorites() {
    if (!isFavoriteDisplay) {
        stations.eachLayer(function (layer) {
            if (!favorites.hasLayer(layer)) {
                saveFav.push(layer);
                stations.removeLayer(layer);
                isFavoriteDisplay = true;
            }
        });
    } else {
        saveFav.forEach(element => {
            stations.addLayer(element)
        });
        isFavoriteDisplay = false;
        saveFav = [];
    }
}

/**
 * Créer un itinéraire entre le marqueur sélectionné et l'adresse sélectionnée dans la liste déroulante
 * @param {*} coords Les coordonnées de la caserne cible
 * @param {string} address Libellé de l'adresse sélectionnée
 */
function createRoute(coords, address) {
    const pointedAddress = function () {
        var tmp = null;
        $.ajax({
            async: false,
            type: "POST",
            url: `https://nominatim.openstreetmap.org/search?q=${encodeURI(address)}&format=json`,
            datatype: "json",
            success:
                function (data) {
                    tmp = data;
                }
        });
        return tmp;
    }();
    routing = L.Routing.control({
        waypoints: [
            L.latLng(pointedAddress[0].lat, pointedAddress[0].lon),
            L.latLng(coords.split(','))
        ],
        router: new L.Routing.osrmv1({
            language: 'fr',
            profile: 'car'
        })
    }).addTo(map);
}

/**
 * Ajoute aux favoris de l'utilisateur la caserne sélectionnée
 * @param {string} sector 
 */
function addToFavorite(sector) {
    $.ajax({
        type: "POST",
        url: "phpFunctions/addFavorite.php",
        data: `sector=${sector}`,
        success: function () {
            location.reload();
        }
    });
}

/**
 * Supprime des favoris de l'utilisateur la caserne sélectionnée
 * @param {string} sector Le secteur de la caserne à enlever des favoris
 */
function deleteFavorite(sector) {
    $.ajax({
        type: "POST",
        url: "phpFunctions/deleteFavorite.php",
        data: `sector=${sector}`,
        success: function (data) {
            location.reload();
        }
    });
}

/**
 * Booléen retournant le statut de favoris d'une caserne sélectionnée
 * @param {string} sector Le secteur de la caserne
 * @returns Vrai ou faux selon le statut de favoris
 */
function checkFavorite(sector) {
    let result;
    $.ajax({
        async: false,
        type: "POST",
        url: "phpFunctions/getFavorites.php",
        data: `sector=${sector}`,
        success: function (data) {
            if (data == 1) {
                result = false;
            } else {
                result = true;
            }
        }
    })
    return result;
}
