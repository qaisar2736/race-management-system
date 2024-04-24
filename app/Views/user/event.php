<div class="container">
		<div class="mt-4 p-5 bg-primary text-white rounded">
				<h1>Welcome to rally: <br><?= strtoupper($event->name); ?></h1>
				<!-- <p>Here you can view...</p> -->
		</div>
</div>

<div class="container mt-4 mb-4">
	<div class="card row">
		<div class="col-md-3 col-12">
		<?php if (session()->has('location_msg')) { ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?php echo session()->getFlashdata('location_msg'); ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php } ?>
		<?php if (session()->has('location_error')) { ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?php echo session()->getFlashdata('location_error'); ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php } ?>
			<form action="<?= base_url('events/view?id='.$event->id); ?>" method="POST" name="location_form" enctype="multipart/form-data">
				<div class="form-group">
					<label for="">Select location:</label>
					<select name="location_id" id="" class="form-control">
						<option value="">SELECT</option>
						<?php foreach($all_locations as $sl) {
							echo "<option value='{$sl->id}'>{$sl->location}</option>";
						}unset($sl);
						?>
					</select>
				</div>

				<div class="form-group mt-2 mb-2">
					<label for="">Select location image</label>
					<input class="form-control" name="location_image" id="location_image" type="file" id="formFile" accept="image/*">
				</div>

				<div class="form-group">
					<div id="previewContainer" class="mb-2"></div>
				</div>

				<input type="submit" name="submit" value="Submit" class="btn btn-info btn-sm">
			</form>
		</div>
	</div>
</div>

<div class="container">
		<div class="row">
				<div class="col-md-12">
						
					<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
									<div id="event_started_container">
										<?php 
											$event_time = $event->date;
											$time_now = date_format(date_create(),"Y-m-d H:i:s");
											$time_event_ends = date('Y-m-d H:i:s',strtotime("+{$event->hours} hour +{$event->minutes} minutes", strtotime($event_time)));

											// echo '<pre>';
											// var_dump($event_time);
											// var_dump($time_now);
											// echo '</pre>';exit;

											$dateTimestamp_now = strtotime($time_now);
											$dateTimestamp_event_time = strtotime($event_time);
											$dateTimestamp_time_event_ends = strtotime($time_event_ends);

											// var_dump($dateTimestamp_now, $dateTimestamp_event_time, $dateTimestamp_time_event_ends);exit;
											
											if ($dateTimestamp_now > $dateTimestamp_event_time && $dateTimestamp_now < $dateTimestamp_time_event_ends) {
										?>
											<div class="alert alert-success alert-dismissible fade show" role="alert">
												Event has started ...
												<!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
											</div>
						<?php } else if ($dateTimestamp_now > $dateTimestamp_event_time && $dateTimestamp_now > $dateTimestamp_time_event_ends) { ?>
							<div class="alert alert-danger alert-dismissible fade show" role="alert">
								Event has ended ...
								<!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
							</div>
						
						<?php } ?>
									</div>
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
											<div class="w-100">
											<table class="table table-bordered m-0">
												<tr>
													<th class="text-center" colspan="2">
														<h3><?= proper_date($event->date, 'd-m-Y'); ?></h3>
													</th>
												</tr>
												<tr>
													<td class="text-center">
														<h1 class="display-4 d-none d-sm-block d-md-block w-100"><?= proper_date($event->date, 'h:i:s a'); ?></h1>
														<p class="fs-5 d-block d-sm-none d-md-none d-lg-none w-100"><?= proper_date($event->date, 'h:i:s a'); ?></p>
													</td>
													<td class="text-center">
														<h1 class="display-4  d-none d-sm-block d-md-block w-100"><?= proper_date($time_event_ends, 'h:i:s a'); ?></h1>
														<p class="fs-5 d-block d-sm-none d-md-none d-lg-none w-100"><?= proper_date($time_event_ends, 'h:i:s a'); ?></p>
													</td>
												</tr>
											</table>
										</div>
										<div class="card-title">
											

                      <!-- <h4>Event date: <?= proper_date($event->date, 'd-m-Y'); ?></h4>
                      <h4>Event start time: <?= proper_date($event->date, 'h:i:s a'); ?></h4>
											<h4>Event end time: <?= proper_date($time_event_ends, 'h:i:s a'); ?></h4> -->
                    </div>
										<div class="graph-day-selection" role="group">
											<!-- <button type="button" class="btn active">Export to Excel</button> -->
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table products-table">
												<thead>
													<tr>
														<th>Location</th>
														<th>Status</th>
														<th>Time</th>
                            <th>Points</th>								
														<!-- <th>Action</th> -->
													</tr>
												</thead>
												<tbody>
													<?php if (count($locations_reached) > 0) { ?>
													<?php foreach ($locations_reached as $lr) { ?>
                            <tr>
                              <td><?= $lr->location ?></td>
                              <td>
																<?php if ($lr->date == NULL) { ?>
                                <h5 class="text-danger"><?= 'NOT REACHED' ?></h5>
																<?php } else { ?>
																<h5 class="text-success"><?= 'REACHED' ?></h5>
																<?php } ?>
                              </td>
                              <td>
																<?php if ($lr->date == NULL) {
                                echo '-';
																} else {
																echo proper_date($lr->date, 'h:i:s a');
																} ?>
															</td>
                              <td>
																<?php if ($lr->date == NULL) {
                                echo '-';
																} else if ($lr->status == 'revoked') {
																echo "<span class='text-danger'>Revoked ($lr->revoke_reason)</span>";
																} else {
																echo $lr->points;
																} ?>
                              </td>
                            </tr>
                          <?php } ?>
													<?php } else { ?>
														<tr>
															<td colspan="4" class="text-center"><em>No location reached yet!</em></td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
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
	/* SHOW LOCATION IMAGE FILE USER HAS SELECTED */
	$('#location_image').on('change', function(e) {
		var file = e.target.files[0];
		var reader = new FileReader();

		reader.onload = function(e) {
			var imgSrc = e.target.result;
			var imgElement = $('<img width="100">').attr('src', imgSrc);

			$('#previewContainer').html(imgElement);
		};

		reader.readAsDataURL(file);
	});
	$('form[name="location_form"]').submit(function(e) {
		let form = $(this);
		form.closest('div').find('.alert').remove();
		let location_id = $('select[name="location_id"]').val();
		let location_image = $('input[name="location_image"]').val();

		if (location_id == '') {
			e.preventDefault();
			form.before($(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
											Error! Select location.
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`));
		} else if (location_image == '') {
			e.preventDefault();
			form.before($(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
											Error! Select location image.
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`));
		}
	});
	$(document).ready(function(){
		var event_time = '<?= $event_time; ?>';
		var time_event_ends = '<?= $time_event_ends; ?>';
		var time_now = '<?= date_format(date_create(),"Y-m-d H:i:s"); ?>';

		var timestamp_event_time = new Date(event_time).getTime();
		var timestamp_time_event_ends = new Date(time_event_ends).getTime();
		var timestamp_time_now = new Date(time_now).getTime();

		setInterval(() => {
			timestamp_time_now += 1000;
		
			if (timestamp_time_now > timestamp_event_time && timestamp_time_now < timestamp_time_event_ends) {
				var event_start_container_html = $('#event_started_container').html().trim();
				if (event_start_container_html == '') {
					var message = $(`<div class="alert alert-success alert-dismissible fade show" role="alert">
												Event has started ...
											</div>`);
					$('#event_started_container').html(message);
				}
			} else if (timestamp_time_now > timestamp_event_time && timestamp_time_now > timestamp_time_event_ends) {
				var event_start_container_html = $('#event_started_container').html().trim();
					if ($('#event_started_container').find('.alert-danger').length == 0) {
						var message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
												Event has ended ...
											</div>`);
						$('#event_started_container').html(message);
					}
			}

		}, 1000);
	});
});
</script>
<?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'participant') { require "live_location.php"; } ?>