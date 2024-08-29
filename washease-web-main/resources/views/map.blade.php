<html>
<head>
    <title>Leaflet + Raster Map tiles</title>
    <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
    <link
        rel="stylesheet"
        type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.css" />

    <style id="compiled-css" type="text/css">
        html,
        body,
        #my-map {
            width: 100%;
            height: 100%;
            margin: 0;
        }
    </style>
</head>
<body data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="">
<div id="my-map"></div>
<script type="text/javascript">
    const INITIALVIEW = {
        latutude: 14.6090537,
        longitude: 121.0222565,
    };

    const originRoute = {
        latutude: 14.6090537,
        longitude: 121.0222565,
    };

    const targetRoute = {
        latutude: 12.3708333333,
        longitude: 123.6236111111,
    };

    // The Leaflet map Object
    const map = L.map("my-map").setView(
        [INITIALVIEW.latutude, INITIALVIEW.longitude],
        12
    );

    // The API Key provided is restricted to JSFiddle website
    // Get your own API Key on https://myprojects.geoapify.com
    const myAPIKey = "dbaa4e2007de44898b873a14e22407ce";

    // Retina displays require different mat tiles quality
    const isRetina = L.Browser.retina;

    const baseUrl =
        "https://maps.geoapify.com/v1/tile/osm-bright/{z}/{x}/{y}.png?apiKey=dbaa4e2007de44898b873a14e22407ce";
    const retinaUrl =
        "https://maps.geoapify.com/v1/tile/osm-bright/{z}/{x}/{y}@2x.png?apiKey=dbaa4e2007de44898b873a14e22407ce";

    // Add map tiles layer. Set 20 as the maximal zoom and provide map data attribution.
    L.tileLayer(isRetina ? retinaUrl : baseUrl, {
        attribution:
            'Powered by <a href="https://www.geoapify.com/" target="_blank">Geoapify</a> | <a href="https://openmaptiles.org/" rel="nofollow" target="_blank">© OpenMapTiles</a> <a href="https://www.openstreetmap.org/copyright" rel="nofollow" target="_blank">© OpenStreetMap</a> contributors',
        apiKey: myAPIKey,
        maxZoom: 20,
        id: "osm-bright",
    }).addTo(map);

    // calculate and display routing:
    // from 38.937165,-77.045590 (1920 Quincy Street Northwest, Washington, DC 20011, United States of America)
    const fromWaypoint = [originRoute.latutude, originRoute.longitude]; // latutude, longitude
    const fromWaypointMarker = L.marker(fromWaypoint)
        .addTo(map)
        .bindPopup(
            "1920 Quincy Street Northwest, Washington, DC 20011, United States of America"
        );

    // to 38.881152,-76.990693 (1125 G Street Southeast, Washington, DC 20003, United States of America)
    const toWaypoint = [targetRoute.latutude, targetRoute.longitude]; // latitude, longitude
    const toWaypointMarker = L.marker(toWaypoint)
        .addTo(map)
        .bindPopup(
            "1125 G Street Southeast, Washington, DC 20003, United States of America"
        );

    const turnByTurnMarkerStyle = {
        radius: 5,
        fillColor: "#fff",
        color: "#555",
        weight: 1,
        opacity: 1,
        fillOpacity: 1,
    };

    fetch(
        `https://api.geoapify.com/v1/routing?waypoints=${fromWaypoint.join(
            ","
        )}|${toWaypoint.join(",")}&mode=drive&apiKey=${myAPIKey}`
    )
        .then((res) => res.json())
        .then(
            (result) => {
                // Note! GeoJSON uses [longitude, latutude] format for coordinates
                L.geoJSON(result, {
                    style: (feature) => {
                        return {
                            color: "rgba(20, 137, 255, 0.7)",
                            weight: 5,
                        };
                    },
                })
                    .bindPopup((layer) => {
                        return `${layer.feature.properties.distance} ${layer.feature.properties.distance_units}, ${layer.feature.properties.time}`;
                    })
                    .addTo(map);

                // collect all transition positions
                const turnByTurns = [];
                result.features.forEach((feature) =>
                    feature.properties.legs.forEach((leg, legIndex) =>
                        leg.steps.forEach((step) => {
                            const pointFeature = {
                                type: "Feature",
                                geometry: {
                                    type: "Point",
                                    coordinates:
                                        feature.geometry.coordinates[legIndex][step.from_index],
                                },
                                properties: {
                                    instruction: step.instruction.text,
                                },
                            };
                            turnByTurns.push(pointFeature);
                        })
                    )
                );

                L.geoJSON(
                    {
                        type: "FeatureCollection",
                        features: turnByTurns,
                    },
                    {
                        pointToLayer: function (feature, latlng) {
                            return L.circleMarker(latlng, turnByTurnMarkerStyle);
                        },
                    }
                )
                    .bindPopup((layer) => {
                        return `${layer.feature.properties.instruction}`;
                    })
                    .addTo(map);
            },
            (error) => console.log(err)
        );
</script>
</body>
</html>
