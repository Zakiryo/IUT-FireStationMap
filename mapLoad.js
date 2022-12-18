const stations = L.layerGroup();
const favorites = L.layerGroup();
const map = L.map('map').setView([48.866295694987045, 2.3440361022949223], 13);
const save = [];
let saveFav = [];
let isFavoriteDisplay = false;
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

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

$(document).ready(() => {
    $("input").keyup(searchStation);
    initMap();
});

function initMap() {
    $('.leaflet-control-attribution').hide();
    $.ajax({
        url: 'casernes.json',
        success: function (data) {
            $.each(data, function (i) {
                let address = `${mainAddress['ADDRESS']}, ${mainAddress['POSTALCODE']} ${mainAddress['CITY']}`;
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
                                </ul>
                                </div>
                                <button type="button" class="btn btn-success" onclick="displayMemos('${98 + i}');">Consulter les mémos</button>
                                <button type="button" class="btn btn-warning"
                                onclick="checkFavorite('${data[i].fields.deno_cs}') ? deleteFavorite('${data[i].fields.deno_cs}') : addToFavorite('${data[i].fields.deno_cs}');">
                                ${checkFavorite(data[i].fields.deno_cs) ? "Supprimer des favoris" : "Ajouter aux favoris"}</button>
                                `);
                if (checkFavorite(data[i].fields.deno_cs))
                    favorites.addLayer(marker);
            });
            stations.addTo(map);
        }
    });
}

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
    L.Routing.control({
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

function displayMemos(id) {
    stations._layers[id].setPopupContent("test");
}

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
