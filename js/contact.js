function initMap() {
	// The center of the map
	const pizzeriaPos = {
		lat: 43.935989,
		lng: 12.65749,
	};

	// Create Map
	const map = new google.maps.Map($("#locationMap")[0], {
		center: pizzeriaPos,
		zoom: 17,
		mapId: 'f36bdaee4314cae0',
		// disableDefaultUI: true,
		zoomControl: true,
		// mapTypeControl: true,
		scaleControl: true,
		// streetViewControl: false,
		// rotateControl: true,
		fullscreenControl: true,
	});

	// Marker info

	const iconBase = "/img/markers/";

	const icon = {
		url: iconBase + "mark.svg",
		fillColor: '#FF0000',
		strokeWeight: 0,
		scaledSize: new google.maps.Size(30, 45),
	};

	const features = {
		position: pizzeriaPos,
		type: "pizzeria",
		title: "Pizzeria",
		markerContent: "<em>Pizza Time</em>",
	};

	const infoWindow = new google.maps.InfoWindow({
		content: features.markerContent,
	});


	// Create marker
	const marker = new google.maps.Marker({
		position: features.position,
		title: features.title,
		icon: icon,
		map: map,
		draggable: false,
		animation: google.maps.Animation.DROP,
	});

	// Add InfoWindow to the marker
	marker.addListener("click", () => {
		infoWindow.open(map, marker);
	});
}

$(function () {
	setTimeout(() => {
		// Removes the (developer) dismiss button from maps
		$("#locationMap .dismissButton")?.click();
		// Alternative
		// $(".dismissButton")?.closest("#locationMap>div").remove();
	}, 500);
})