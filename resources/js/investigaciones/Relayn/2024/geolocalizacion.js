// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

let selectedMarker = null;
const markers = [];

function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    center: {
      lat: 40.749933,
      lng: -73.98633,
    },
    zoom: 13,
    mapTypeControl: false,
    streetViewControl: false,
  });

  // Realiza una solicitud de geocodificación para obtener las coordenadas del municipio por su nombre
  const geocoder = new google.maps.Geocoder();
  geocoder.geocode(
    { address: ubicacion }, // Reemplaza "Nombre del municipio" con el nombre real del municipio
    (results, status) => {
      if (status === google.maps.GeocoderStatus.OK) {
        // Si la solicitud se completó correctamente, centra el mapa en las coordenadas obtenidas
        map.setCenter(results[0].geometry.location);
      } else {
        console.error(
          "La geocodificación no se pudo completar debido a: " + status
        );
      }
    }
  );

  // Crea un nuevo marcador en la ubicación del clic
  const marker = new google.maps.Marker({
    map,
    draggable: false,
    animation: google.maps.Animation.DROP,
  });

  map.addListener("click", addMarkerOnClick);

  function addMarkerOnClick(event) {
    const clickedLocation = event.latLng;

    deleteMarcadores();
    marker.setPosition(clickedLocation);
    marker.setVisible(true);
    // Agrega el nuevo marcador a la lista de marcadores
    markers.push(marker);
    // Obtén las coordenadas del marcador
    const lat = marker.getPosition().lat();
    const lng = marker.getPosition().lng();

    // Crea la URL de Google Maps con las coordenadas
    googleMapsUrl = `https://www.google.com/maps?q=${lat},${lng}`;

    $("#coordenadas").val(googleMapsUrl)
  }

  function deleteMarcadores() {
    // Elimina los marcadores anteriores
    for (let i = 0; i < markers.length; i++) {
      markers[i].setMap(null); // Elimina el marcador del mapa
    }
    marker.setMap(map);
  }

  const card = document.getElementById("pac-card");
  const input = document.getElementById("pac-input");
  const strictBoundsInputElement = document.getElementById("use-strict-bounds");
  const options = {
    fields: ["formatted_address", "geometry", "name"],
    strictBounds: false,
  };

  map.controls[google.maps.ControlPosition.TOP_LEFT].push(card);

  const autocomplete = new google.maps.places.Autocomplete(input, options);

  // Bind the map's bounds (viewport) property to the autocomplete object,
  // so that the autocomplete requests use the current map bounds for the
  // bounds option in the request.
  autocomplete.bindTo("bounds", map);

  const infowindow = new google.maps.InfoWindow();
  const infowindowContent = document.getElementById("infowindow-content");

  infowindow.setContent(infowindowContent);

  autocomplete.addListener("place_changed", () => {
    infowindow.close();
    marker.setVisible(false);

    const place = autocomplete.getPlace();

    if (!place.geometry || !place.geometry.location) {
      // User entered the name of a Place that was not suggested and
      // pressed the Enter key, or the Place Details request failed.
      window.alert("No details available for input: '" + place.name + "'");
      return;
    }

    const latitude = place.geometry.location.lat();
    const longitude = place.geometry.location.lng();
    googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
    $("#coordenadas").val(googleMapsUrl)

    // If the place has a geometry, then present it on a map.
    if (place.geometry.viewport) {
      map.fitBounds(place.geometry.viewport);
    } else {
      map.setCenter(place.geometry.location);
      map.setZoom(17);
    }

    deleteMarcadores();
    marker.setPosition(place.geometry.location);
    marker.setVisible(true);
    markers.push(marker);

    infowindowContent.children["place-name"].textContent = place.name;
    infowindowContent.children["place-address"].textContent =
      place.formatted_address;
    infowindow.open(map, marker);
  });

  // Sets a listener on a radio button to change the filter type on Places
  // Autocomplete.
  function setupClickListener(id, types) {
    const radioButton = document.getElementById(id);

    radioButton.addEventListener("click", () => {
      autocomplete.setTypes(types);
      input.value = "";
    });
  }

  setupClickListener("changetype-all", []);
  setupClickListener("changetype-address", ["address"]);
  setupClickListener("changetype-establishment", ["establishment"]);
  setupClickListener("changetype-geocode", ["geocode"]);
  setupClickListener("changetype-cities", ["(cities)"]);
  setupClickListener("changetype-regions", ["(regions)"]);
  strictBoundsInputElement.addEventListener("change", () => {
    autocomplete.setOptions({
      strictBounds: strictBoundsInputElement.checked,
    });
    if (strictBoundsInputElement.checked) {
      autocomplete.bindTo("bounds", map);
    }

    input.value = "";
  });
}

window.initMap = initMap;
