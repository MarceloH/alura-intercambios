let markers = [];

for (let i = 0; i < data.length; i++) {
    console.log(data[i]);
    let Icon = L.icon({
        iconUrl: data[i].imagem,
        iconSize:     [38, 38], // size of the icon
        shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
        shadowAnchor: [4, 62],  // the same for the shadow
        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });
    markers.push(
        L.marker([data[i].latitude, data[i].longitude],
        {icon: Icon}
        ).bindPopup(data[i].titulo)
    );
}

var cities = L.layerGroup(markers);

var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
});

if(data.length === 1){
    var map = L.map('map', {
        center: [data[0].latitude, data[0].longitude],
        zoom: 12,
        layers: [osm, cities]
    }); 
}else{
    var map = L.map('map', {
        center: [39.73, -104.99],
        zoom: 3,
        layers: [osm, cities]
    });
}

var baseMaps = {
    "OpenStreetMap": osm
};


var overlayMaps = {
};

var layerControl = L.control.layers(baseMaps, overlayMaps).addTo(map);

mapboxUrl = 'http://tile.mtbmap.cz/mtbmap_tiles/{z}/{x}/{y}.png';
mapboxAttribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &amp; USGS';

var satellite = L.tileLayer(mapboxUrl, {id: 'MapID', tileSize: 512, zoomOffset: -1, attribution: mapboxAttribution});

layerControl.addBaseLayer(satellite, "Satellite");
layerControl.addOverlay(cities, "Cidades");