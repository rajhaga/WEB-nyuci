<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Locations</title>
    <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSyecMnyvZ2mBRoQdgy0ZoSz8DDfxXggNB2N&libraries=places"></script>
    <style>
        #map { height: 500px; width: 100%; }
    </style>
</head>
<body>
    <h1>Package Map</h1>
    <div id="map"></div>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: { lat: -6.2088, lng: 106.8456 }, // Default to Jakarta
                zoom: 10,
            });

            // Example data (replace this with dynamic data from Laravel)
            const packages = @json($packages);

            // Try to get the user's current location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const currentLocation = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude,
                        };

                        // Marker for the user's current location
                        new google.maps.Marker({
                            position: currentLocation,
                            map: map,
                            title: "Your Current Location",
                            icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
                        });

                        // Zoom the map to the user's location
                        map.setCenter(currentLocation);

                        // Loop through each package to add markers and routes
                        packages.forEach(pkg => {
                            // Marker for pickup location
                            const pickupMarker = new google.maps.Marker({
                                position: { lat: parseFloat(pkg.pickup_latitude), lng: parseFloat(pkg.pickup_longitude) },
                                map: map,
                                title: `Pickup: ${pkg.package_name}`,
                                icon: "http://maps.google.com/mapfiles/ms/icons/green-dot.png",
                            });

                            // Marker for destination location
                            const destinationMarker = new google.maps.Marker({
                                position: { lat: parseFloat(pkg.destination_latitude), lng: parseFloat(pkg.destination_longitude) },
                                map: map,
                                title: `Destination: ${pkg.package_name}`,
                                icon: "http://maps.google.com/mapfiles/ms/icons/red-dot.png",
                            });

                            // Draw route from current location to pickup
                            const directionsService = new google.maps.DirectionsService();
                            const directionsRenderer = new google.maps.DirectionsRenderer({
                                map: map,
                                suppressMarkers: true, // Prevent automatic markers
                            });

                            directionsService.route({
                                origin: currentLocation,
                                destination: {
                                    lat: parseFloat(pkg.pickup_latitude),
                                    lng: parseFloat(pkg.pickup_longitude),
                                },
                                travelMode: google.maps.TravelMode.DRIVING,
                            }, (response, status) => {
                                if (status === "OK") {
                                    directionsRenderer.setDirections(response);
                                } else {
                                    console.error("Directions request failed due to " + status);
                                }
                            });
                        });
                    },
                    (error) => {
                        console.error("Error getting location: ", error);
                        alert("Unable to access your location.");
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        window.onload = initMap;
    </script>
</body>
</html>
