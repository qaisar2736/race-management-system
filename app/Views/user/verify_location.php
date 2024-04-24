<!--<div class="container">
		<div class="mt-4 p-5 bg-primary text-white rounded">
				<h1>Welcome to rally: <br></h1>
				
		</div>
</div> -->
<style>

</style>
<div class="container">
		<div class="row">
				<div class="col-md-12">
						
					<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
									<div id="alert-container">
										
										<?php if (session()->has('success')) { ?>
											<div class="alert alert-success alert-dismissible fade show" role="alert">
												<?php echo session()->getFlashdata('success'); ?>
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										<?php } ?>
										<?php if (session()->has('error')) { ?>
											<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<?php echo session()->getFlashdata('error'); ?>
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
										<?php } ?>
									</div>
								<div class="card">
									<div class="card-header">
                      <h5>Verify Location:</h5>
										</div>
										<div class="card-title">

                    </div>
										<div class="graph-day-selection" role="group">
											<!-- <button type="button" class="btn active">Export to Excel</button> -->
										</div>
									</div>
									<div class="card-body">
                      
                      <!-- <button class="btn btn-primary btn-sm get_location mb-2">Get Location</button> -->

                      <p id="result"></p>

									</div>
								</div>
							</div>
						</div>

				</div>

				

		</div>
</div>
<br><br><br><br><br><br><br><br><br><br>
<script>
document.addEventListener("DOMContentLoaded", () => {
	$(document).ready(function(){

    var EVENT_ID = <?= $location->event_id ?>;
    var LOCATION_ID = <?= $location->id ?>;

    function degreesToRadians(degrees) {
      var radians = (degrees * Math.PI) / 180;
      return radians;
    }

    function calcDistance (startingLat, startingLong, destinationLat, destinationLong) {
      startingLat = degreesToRadians(startingLat);
      startingLong = degreesToRadians(startingLong);
      destinationLat = degreesToRadians(destinationLat);
      destinationLong = degreesToRadians(destinationLong);

      // Radius of the Earth in kilometers
      let radius = 6571;


      // Haversine equation
      let distanceInKilometers = Math.acos(Math.sin(startingLat) * Math.sin(destinationLat) +
      Math.cos(startingLat) * Math.cos(destinationLat) *
      Math.cos(startingLong - destinationLong)) * radius;
      return Math.floor(distanceInKilometers * 1000);

    }

    // $('.get_location').click(function(){

      var latitude_longitude = '<?= $location->latitude_longitude ?>';
      var latitude = latitude_longitude.split(',')[0];
      var longitude = latitude_longitude.split(',')[1];

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        $('.alert-container').html($(`<div class="alert alert-danger">
        Geolocation is not supported by this browser.
        </div>`));
      }

      function showPosition(position) {
        var current_latitude = position.coords.latitude;
        var current_longitude = position.coords.longitude;

        var difference_between_locations = calcDistance(latitude, longitude, current_latitude, current_longitude);
        if (difference_between_locations > 100) {
          var message = $(`<div class="alert alert-danger" role="alert">
            You are more then 100 meters away from location
          </div>`);
          $('#alert-container').html(message);
        } else {
          $.ajax({
            url: '/user/mark_location',
            method: 'GET',
            data: {
              event_id: EVENT_ID,
              location_id: LOCATION_ID
            },
            success: function(success) {
              if (typeof success.location_already_marked != 'undefined') {
                var message = $(`<div class="alert alert-danger" role="alert">
                  Location is already marked as reached!
                </div>`);
                $('#alert-container').html(message);
              } else if (typeof success.location_marked != 'undefined') {
                window.location.href = '<?= base_url('events/view?id=') ?>' + EVENT_ID;
              }
            },
            error: function(error) {
              console.log(error);
            }
          });
        }
        
      }
    // });

	});
});
</script>