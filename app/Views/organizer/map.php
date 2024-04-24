<style>
#map {
  height: 700px;
  width: 100%;
}
</style>

<div class="container-fluid">

  <?php if ($events == '') { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      There is no event today.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php } else { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?php echo "Live locations for participants of events: $events"; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php } ?>

  <div class="card map-card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <h1>Live Location of users for today's event:</h1>
          <button class="btn btn-primary btn-sm mb-2" onclick="toggleFullScreen()">Toggle Fullscreen</button>
          <div id="map"></div>
          
        </div>
      </div>
    </div>
  </div>


</div>
<script>
document.addEventListener('keydown', function(event) {
  if (event.key === 'c') {
    exitFullscreen();
  }
});
document.addEventListener('keydown', function(event) {
  if (event.key === 'f') {
    toggleFullScreen();
  }
});
function toggleFullScreen() {
  var fullscreenDiv = document.getElementById('map');

  if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
    exitFullscreen();
  } else if (fullscreenDiv.requestFullscreen) {
    fullscreenDiv.requestFullscreen();
  } else if (fullscreenDiv.mozRequestFullScreen) {
    fullscreenDiv.mozRequestFullScreen();
  } else if (fullscreenDiv.webkitRequestFullscreen) {
    fullscreenDiv.webkitRequestFullscreen();
  } else if (fullscreenDiv.msRequestFullscreen) {
    fullscreenDiv.msRequestFullscreen();
  }
}

function exitFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  }
}
document.addEventListener("DOMContentLoaded", () => {
  function centerLeafletMapOnMarker(map, marker) {
    var latLngs = [ marker.getLatLng() ];
    var markerBounds = L.latLngBounds(latLngs);
    map.fitBounds(markerBounds);
  }
  let result = {};
  window.result = result;
  var users = [];
  window.users = users;

  // var default_location = ['54.687191801012894', '25.266766609935694'];
  var map = L.map("map").setView([54.688779404355145, 25.269513191922833], 12);
  L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
    attribution:
      'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors',
    maxZoom: 18,
  }).addTo(map);

  var markers = [];

  function renderMarkers() {
    $.ajax({
      url: '<?= base_url('organizer/get_live_locations') ?>',
      method: 'GET',
      data: {},
      success: function(success) {
        if (success.liveLocations !== undefined) {

          if (success.liveLocations.length == 0) {
            $('.map-error').remove();
            $('.map-card').before(`<div class="alert alert-danger alert-dismissible fade show map-error" role="alert">
                No live locations for now...
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>`);
          } else {
            $('.map-error').remove();
          }

          let locations = success.liveLocations;
          locations.forEach(location => {
            const existingObject = users.find(obj => obj.id === location.id);
            if (existingObject) {
              // Update the existing object
              Object.assign(existingObject, location);
            } else {
              // Push the new object to the array
              users.push(location);
            }
          });

          users.forEach(function (user) {
            if (user.marker !== undefined) user.marker.remove();
            user.marker = L.marker([user.latitude, user.longitude])
              .addTo(map)
              .bindPopup(user.full_name, {
                closeOnClick: false,
                autoClose: false,
              })
              .openPopup();
            // markers.push(marker);
          });

          var coordinates_collection = users.map(function(user) {
            return [parseFloat(user.latitude), parseFloat(user.longitude)];
          });
          var bounds = L.latLngBounds(coordinates_collection);
          // map.fitBounds(bounds);
          map.setView(bounds.getCenter(), map.getZoom());
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
    // markers = [];
  }

  // Render markers initially
  renderMarkers();

  // Re-render markers every 5 seconds
  setInterval(renderMarkers, 3000);

});
</script>

					<!-- App footer start -->
					<!-- <div class="app-footer">© Organizer <?= date('Y') ?></div> -->
					<!-- App footer end -->

				<!-- </div> -->
				<!-- Content wrapper scroll end -->

			<!-- </div> -->
			<!-- *************
				************ Main container end *************
			************* -->

		</div>
		<!-- Page wrapper end -->

<!-- <script src="/js/jquery.min.js"></script> -->
<!-- <script src="/js/main.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>
<script>
		// $(document).ready(function(){
		// 	$('.toggle-sidebar').click(function(){
		// 		let toggleSide = $(this);
		// 		let iElement = toggleSide.find('i');

		// 		let iClass = $(iElement).attr('class')
		// 		if (iClass == 'icon-menu') {
		// 			iElement.removeClass("icon-menu");
		// 			iElement.html('&#x2716;');
		// 			iElement.css('font-style', 'normal');
		// 		} else {
		// 			iElement.html('');
		// 			iElement.addClass("icon-menu");
		// 		}
				
		// 	});
		// });
		</script>