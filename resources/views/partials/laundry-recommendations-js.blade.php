<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Initialize map with default location (or use first laundry location if available)
    const defaultLat = {{ $rekomendasi[0]->latitude ?? -6.2088 }};
    const defaultLng = {{ $rekomendasi[0]->longitude ?? 106.8456 }};
    const map = L.map('map').setView([defaultLat, defaultLng], 13);
    
    // Add tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    
    // Add marker
    const marker = L.marker([defaultLat, defaultLng], {
        draggable: true
    }).addTo(map).bindPopup("Lokasi pencarian").openPopup();
    
    // DOM elements
    const locationInput = document.getElementById('locationInput');
    const searchBtn = document.getElementById('searchBtn');
    const editLocation = document.getElementById('editLocation');
    const resultsContainer = document.getElementById('resultsContainer');
    const loadingIndicator = document.getElementById('loading');
    const emptyState = document.getElementById('emptyState');
    const emptyStateInitial = document.getElementById('emptyStateInitial');
    const tryAgainBtn = document.getElementById('tryAgainBtn');
    
    // Current location
    let currentLocation = {
        lat: defaultLat,
        lng: defaultLng,
        address: "{{ $rekomendasi[0]->alamat ?? 'Jakarta, Indonesia' }}"
    };
    
    // Set initial address if available
    @if(isset($rekomendasi) && count($rekomendasi) > 0)
        locationInput.value = "{{ $rekomendasi[0]->alamat }}";
    @endif
    
    // Update location function
    async function updateLocation(lat, lng) {
        currentLocation.lat = lat;
        currentLocation.lng = lng;
        
        // Update marker position
        marker.setLatLng([lat, lng]);
        map.setView([lat, lng], 13);
        
        // Get address from coordinates
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
            const data = await response.json();
            currentLocation.address = data.display_name || `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
            locationInput.value = currentLocation.address;
        } catch (error) {
            console.error('Error getting address:', error);
            currentLocation.address = `${lat.toFixed(4)}, ${lng.toFixed(4)}`;
            locationInput.value = currentLocation.address;
        }
        
        // Search nearby laundries
        searchNearbyLaundries();
    }
    
    // Search nearby laundries function
    async function searchNearbyLaundries() {
        // Show loading
        resultsContainer.innerHTML = '';
        loadingIndicator.classList.remove('hidden');
        emptyState.classList.add('hidden');
        if (emptyStateInitial) emptyStateInitial.classList.add('hidden');
        
        try {
            // Get position from marker
            const lat = currentLocation.lat;
            const lng = currentLocation.lng;
            const radius = 10;  // For example, 50 km radius

            // Call the backend API with radius 50 km
            const url = `/api/laundry/nearby?lat=${lat}&lng=${lng}&radius=${radius}`;
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Error fetching laundries');
            }

            const laundries = await response.json();

            // Display results
            displayResults(laundries.data);
            loadingIndicator.classList.add('hidden');
        } catch (error) {
            console.error('Error searching laundries:', error);
            loadingIndicator.classList.add('hidden');
            emptyState.classList.remove('hidden');
        }
    }

    // Display results function
    function displayResults(laundries) {
        resultsContainer.innerHTML = '';

        if (laundries.length === 0) {
            emptyState.classList.remove('hidden');
            return;
        }

        laundries.forEach(laundry => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-lg shadow-md overflow-hidden transition duration-300 hover:shadow-lg';
            card.innerHTML = `
                <img src="/storage/${laundry.foto_tempat}" alt="${laundry.nama_laundry}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-lg font-semibold text-gray-800">${laundry.nama_laundry}</h4>
                        <span class="flex items-center bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">
                            <i class="fas fa-star mr-1"></i> ${laundry.rating || 'Baru'}
                        </span>
                    </div>
                    <p class="text-gray-600 text-sm mb-3">
                        <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i> 
                        ${laundry.alamat.substring(0, 50)}${laundry.alamat.length > 50 ? '...' : ''} 
                        <br>
                        <span class="text-gray-500">Jarak: ${laundry.distance}</span>
                    </p>
                    <div class="flex justify-between items-center">
                        <span class="text-blue-600 font-medium">Rp ${new Intl.NumberFormat().format(laundry.harga)}/kg</span>
                        <a href="/katalog/${laundry.id}/detail" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm transition">
                            <i class="fas fa-shopping-cart mr-1"></i> Pesan
                        </a>
                    </div>
                </div>
            `;
            resultsContainer.appendChild(card);
        });
    }

    // Event listeners
    searchBtn.addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    updateLocation(position.coords.latitude, position.coords.longitude);
                },
                error => {
                    alert('Tidak dapat mendapatkan lokasi Anda: ' + error.message);
                    searchNearbyLaundries();
                }
            );
        } else {
            alert('Browser Anda tidak mendukung geolocation');
            searchNearbyLaundries();
        }
    });
    
    marker.on('dragend', function(e) {
        const newPos = marker.getLatLng();
        updateLocation(newPos.lat, newPos.lng);
    });
    
    editLocation.addEventListener('click', function(e) {
        e.preventDefault();
        locationInput.focus();
    });
    
    tryAgainBtn.addEventListener('click', searchNearbyLaundries);
    
    // If no initial recommendations, try to get user's location
    @if(!isset($rekomendasi) || count($rekomendasi) === 0)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    updateLocation(position.coords.latitude, position.coords.longitude);
                },
                () => {
                    // Use default location if geolocation fails
                    searchNearbyLaundries();
                }
            );
        } else {
            // Browser doesn't support geolocation
            searchNearbyLaundries();
        }
    @endif
});
</script>

