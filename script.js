const stations = L.layerGroup();
var favoriteIcon = L.icon({
    iconUrl: 'favorite_icon.png'
});
const favorites = L.layerGroup({ icon: favoriteIcon });
const map = L.map('map').setView([48.866295694987045, 2.3440361022949223], 13);
const save = [];
L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

$(document).ready(() => {

    const stationSearch = document.querySelector('input');
    stationSearch.addEventListener('input', searchStation);
    initMap();
});

function initMap() {
    $.ajax({
        url: 'casernes.json',
        success: function (data) {
            $.each(data, function (i) {
                const marker = L.marker(data[i].fields.geo_point_2d);
                stations.addLayer(marker);
                marker.bindPopup(`Secteur : ${data[i].fields.deno_cs}</br>
                                Adresse : ${data[i].fields.adresse}</br>
                                <button type="button" class="btn btn-outline-dark" onclick="createRoute('${data[i].fields.geo_point_2d}');">S'y rendre</button>`);
            })
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
        if (element.getPopup().getContent().includes(search.toUpperCase())) stations.addLayer(element)
    });
}

function createRoute(coords) {
    L.Routing.control({
        waypoints: [
            L.latLng(48.93065947179935, 2.54744213526183),
            L.latLng(coords.split(','))
        ],
        router: new L.Routing.osrmv1({
            language: 'fr',
            profile: 'car'
        })
    }).addTo(map);
}
