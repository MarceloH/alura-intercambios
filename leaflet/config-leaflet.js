var map = L.map('map').setView([12.25, -68.75], 2);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);


let markers = [];
for (const cidade in data) {
    markers.push(L.marker([data.latitude, data.longitude]).bindPopup(data.titulo));
}
console.log(markers)
var cidades = L.layerGroup(markers);
console.log(cidades)
var satellite = L.tileLayer(mapboxUrl, {id: 'MapID', tileSize: 512, zoomOffset: -1, attribution: mapboxAttribution});

layerControl.addBaseLayer(satellite, "Satellite");
layerControl.addOverlay(cidades, "Cidades");

// L.marker([cidade.latitude, cidade.longitude]).addTo(map)
//     //.bindPopup(data.titulo)
//     .openPopup();

