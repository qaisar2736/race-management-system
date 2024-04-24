

				<!-- Content wrapper scroll start -->
				<div class="content-wrapper-scroll">

					<!-- Content wrapper start -->
					<div class="content-wrapper">

						<!-- Row start -->
						<div class="row gutters">
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
								<div class="stats-tile">
									<div class="sale-icon">
										<i class="icon-shopping-bag1"></i>
									</div>
									<div class="sale-details">
										<h2><?= $event->name ?></h2>
										<p>Event</p>
									</div>
									<div class="sale-graph">
										<div id="sparklineLine1"></div>
									</div>
								</div>
							</div>
						</div>
						<!-- Row end -->

						<!-- Row start -->
						<!-- Row end -->

						<!-- Row start -->
						<!-- Row end -->

						<!-- Row start -->
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">
                      <h1 class="display-2" id="countdown">
                        Start Time
                        <?= $event->hours . ' : ' . $event->minutes . '' ?>
                      

                      <?php
                      if ($difference != null) { ?>
                        <button class="btn btn-primary btn-lg" id="start">START</button>
                      <?php } ?>
                      
                    </div>
										<div class="graph-day-selection" role="group">
											<!-- <button type="button" class="btn active">Export to Excel</button> -->
										</div>
									</div>
									<div class="card-body">
                    <table class="table table-hover table-bordered m-0">
                      <thead>
                        <tr>
                          <th>Location</th>
                          <th>Status</th>
                          <th>Time Reached</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($locations as $location) { ?>
                          <tr>
                            <td><?= $location->location ?></td>
                            <td><span class="text-danger"><strong>NOT REACHED</strong></span></td>
                            <td>-</td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
									</div>
								</div>
							</div>
						</div>
						<!-- Row end -->

						<!-- Row start -->
						<!-- Row end -->

					</div>
					<!-- Content wrapper end -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  $('button#start').click(function(){

    $.ajax({
      'url': '<?= base_url('participant/events/start'); ?>',
      'data': {
        'event_start': true,
        'event_id': <?= (isset($event->id))?$event->id:''; ?>
      },
      'method': 'POST',
      'success': function(success) {
        start_counter_function();
      },
      'error': function(error) {
        console.log(error);
      }
    });


    

  });

  

  var start_counter_function = function(){
    // create date 
    <?php
    if (isset($difference) && $difference->h > 0) {
      echo 'var hours = ' . ($event->hours - $difference->h) . ';';
    } else {
      echo 'var hours = ' . $event->hours . ';';
    }
    if (isset($difference) && $difference->i > 0) {
      echo 'var minutes = ' . ($event->minutes - $difference->i) . ';';
    } else {
      echo 'var minutes = ' . $event->minutes . ';';
    }
    ?>

    var date = moment().add(hours, 'hours').add(minutes, 'minutes');

    // Set the date we're counting down to
    var countDownDate = new Date(date).getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

      // Get today's date and time
      var now = new Date().getTime();
        
      // Find the distance between now and the count down date
      var distance = countDownDate - now;
        
      // Time calculations for days, hours, minutes and seconds
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
      // Output the result in an element with id="demo"
      // document.getElementById("countdown").innerHTML = hours + " : " + minutes + " : " + seconds + " ";
        
      // If the count down is over, write some text 
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("countdown").innerHTML = "EXPIRED";
      }
    }, 1000);
  }

  <?php 
  if (isset($difference)) { 
    echo 'start_counter_function();';
  } 
  ?>
});
</script>