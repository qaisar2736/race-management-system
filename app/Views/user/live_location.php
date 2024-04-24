<?php 

?>
<script>
function updateLiveLocation(){

}
document.addEventListener("DOMContentLoaded", () => {
  if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function (position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;
      
      setInterval(() => {
        $.ajax({
          url: '<?= base_url('user/live_location'); ?>',
          method: 'POST',
          data: {
            latitude: latitude,
            longitude: longitude
          },
          success: function(success) {
            console.log(success);
          },
          error: function(error) {
            console.log(error);
          }
        });
      }, 5000);
    }, function (error) {

      $.ajax({
        url: '<?= base_url('user/accepted_for_today_event') ?>',
        method: 'POST',
        data: {},
        success: function(success){
          if (success.accepted !== undefined) {
            window.location.href = '<?= base_url('user/turn_on_location') ?>';
          }
        },
        error: function(error){
          console.log(error);
        }
      })

      console.error("Error getting geolocation:", error);

      $('nav').after(`<div class="container alert alert-danger alert-dismissible fade show mt-4 location-error" role="alert">
												<strong>Error</strong> User denied Geolocation <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>`);
      
      var targetOffset = $(".location-error").offset().top; // Get the top offset of the target element
      $("nav").animate({ scrollTop: targetOffset }, 1000); // Animate scrolling to the target element
    });
  } else {
    console.error("Geolocation is not supported by this browser.");
  }
});
</script>