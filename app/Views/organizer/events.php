<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<style>
table {
	font-family: 'Montserrat', sans-serif;
	font-size: 14px;
}

.ff-montserrat {
	font-family: 'Montserrat', sans-serif;
}

.my-heading {
	font-size: 36px; 
	font-weight: bold; 
	color: #333; 
	text-align: center; 
	text-transform: uppercase; 
	letter-spacing: 2px; 
	margin-bottom: 30px;
}

					#map {
						height: 700px;
						width: 100%;
					}

</style>
<script>
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
</script>
<div id="vue-app">
<nav class="sidebar-wrapper">
<div class="sidebar-tabs">
	<div class="tab-content">
		<div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
			<div class="tab-pane-header">
				<a class="text-primary dashboard-link ff-montserrat" href="<?= base_url('organizer/events/'.$race->id) ?>"><?= $race->name ?></a>
			</div>
			<div class="sidebarMenuScroll">
				<div class="sidebar-menu">
						<?php 
						 if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
									$url = "https://";   
							else  
									$url = "http://";   
							// Append the host(domain name, ip) to the URL.   
							$url.= $_SERVER['HTTP_HOST'];   
							
							// Append the requested resource location to the URL   
							$url.= $_SERVER['REQUEST_URI']; 
							$url = parse_url( $url, $component = -1 );
							$path = explode('/', $url['path']);
							$profile_class = $events_class = $locations_class = 
							$event_requests = $categories_class = $event_track_results_class = $all_users_class = '';
						
							if (isset($path[2]) && $path[2] == 'profile') {
								$profile_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'events') {
								$events_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'locations') {
								$locations_class = 'current-page';
							} 
							if (isset($path[2]) && $path[2] == 'event_requests') {
								$event_requests = 'current-page';
							} 
							if (isset($path[2]) && $path[2] == 'categories') {
								$categories_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'event_track_results') {
								$event_track_results_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'all_users') {
								$all_users_class = 'current-page';
							} 

							
							
							?>
					<ul>
						<li style="text-align: center;">
							<img width="200px" style="width: 200px !important;" src="<?= base_url('img/Greicio_ratas_pagrindinis_logo-01.png') ?>" alt="logo">
						</li>
						<li class="text-center">
							<a href="javascript:void(0);">Add Class</a>

								<button v-on:click="show_class_modal" class="btn btn-info btn-sm" style="width: 120px;">
									<!-- <i class="fa-solid fa-plus"></i> -->+
								</button>
						</li>

						<li class="text-center">
							<a href="javascript:void(0);">Add Orientation Event</a>

								<button v-on:click="show_aoe_form" class="btn btn-info btn-sm" style="width: 120px;">
									<!-- <i class="fa-solid fa-plus"></i> -->+
								</button>
						</li>
						<li class="text-center">
							<a href="javascript:void(0);">Add Track Event</a>

								<button v-on:click="show_ate_form" class="btn btn-info btn-sm" style="width: 120px;">
									<!-- <i class="fa-solid fa-plus"></i> -->+
								</button>
						</li>

						<!-- <li>
							<a href="<?php echo base_url("organizer/profile"); ?>" class="<?= $profile_class; ?>">Profile</a>
						</li> -->
						<li>
							<a href="<?php echo base_url("organizer/races"); ?>" class="">Races</a>
						</li>
						<li>
							<a href="<?php echo base_url("organizer/categories"); ?>" class="<?= $categories_class; ?>">Categories</a>
						</li>
						<!-- <li>
							<a href="<?php echo base_url("organizer/events"); ?>" class="<?= $events_class; ?>">Events</a>
						</li> -->
						<li>
							<a href="<?php echo base_url("organizer/event_requests"); ?>" class="<?= $event_requests; ?>">Event Requests</a>
						</li>
						<li>
							<a href="<?php echo base_url("organizer/locations"); ?>" class="<?= $locations_class; ?>">Locations</a>
						</li>
						<li>
							<a href="<?php echo base_url("organizer/locations/reached"); ?>" 
							class="<?= (isset($path[3]) && strpos($path[3], 'reached') !== false) ? 'current-page' : false; ?>">Locations Reached</a>
						</li>
						<li>
							<a href="<?php echo base_url("organizer/category_results"); ?>" class="<?= $event_track_results_class; ?>">Results</a>
						</li>
						<li>
							<a href="<?php echo base_url("organizer/all_users"); ?>" class="<?= $all_users_class; ?>">Users</a>
						</li>
						<li>
							<a href="<?php echo base_url("organizer/map"); ?>" >Map</a>
						</li>
					</ul>

				</div>
			</div>
		</div>
	</div>
</div>
</nav>

<!-- ADD CLASS MODAL -->
<!-- Modal -->
<div class="modal fade" id="class_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
			
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Add Class</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form action="" @submit.prevent="add_classes_to_event" name="add_class_form">
					<div class="field-wrapper">
						<select class="form-select" id="event_id" name="event_id">
							<option 
								:value="event.id" 
								:key="event.id" 
								v-for="event in all_events">{{ event.name }}</option>
						</select>
						<div class="field-placeholder">Select event <span class="text-danger">*</span></div>
					</div>
						<!-- <div class="form-group">
							<label for="">Select event</label>
							<select name="event_id" id="event_id" class="form-control">
								<option 
								:value="event.id" 
								:key="event.id" 
								v-for="event in all_events">{{ event.name }}</option>
							</select>
						</div> -->
						<div class="field-wrapper">
							<input class="form-control" type="text" name="classes" required>
							<div class="field-placeholder">Classes <span class="text-danger">*</span><em>Enter comma (,) seperated classes</em></div>
						</div>
						<div class="form-group">
							<input class="btn btn-info btn-sm" type="submit" name="save" value="Save">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
					<!-- <button type="button" class="btn btn-primary">Save Changes</button> -->
				</div>
    </div>
  </div>
</div>

<!-- ADD TRACK Event Modal start -->
<div class="modal fade" id="addTrackEventModal" tabindex="-1" aria-labelledby="addTrackEventModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="addTrackEventModalLabel">Add Track Event</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form action="" method="POST" name="add_track_event_form" @submit.prevent="save_track_event">
			<div class="modal-body">
				<div class="row">
					<div class="col-12">

							<div class="field-wrapper">
								<select name="category" id="category" class="form-select">
									<option 
									v-for="(category, index) in track_categories"
									:key="category.id" 
									:value="category.id">
										{{category.name}}
									</option>
								</select>
								<div class="field-placeholder">Category<span class="text-danger">*</span></div>
							</div>
						
							<div class="field-wrapper">
								<input class="form-control" type="text" name="name">
								<div class="field-placeholder">Event name <span class="text-danger">*</span></div>
							</div>

							<!-- <div class="field-wrapper">
								<select class="form-select" id="formSelect" name="type">
									<option value="track" selected="">Track event</option>
									<option value="orentance">Orentance event</option>
								</select>
								<div class="field-placeholder">Event type <span class="text-danger">*</span></div>
							</div> -->

							<!-- <div class="field-wrapper">
								<input class="form-control" type="number" name="hours">
								<div class="field-placeholder">Event hours <span class="text-danger">*</span></div>
							</div> -->

							<!-- <div class="field-wrapper">
								<input class="form-control" type="number" name="minutes">
								<div class="field-placeholder">Event minutes <span class="text-danger">*</span></div>
							</div> -->

							<!-- <div class="field-wrapper">
								<input class="form-control" type="datetime-local" name="date">
								<div class="field-placeholder">Event start date time <span class="text-danger">*</span></div>
							</div> -->

							<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
						
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
				<button type="type" class="btn btn-primary">Save</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- ADD TRACK EVENT Modal end -->

<!-- ADD ORIENTATION EVENT Modal start -->
<div class="modal fade" id="addTrackOrientationModal" tabindex="-1" aria-labelledby="addTrackOrientationModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="addTrackOrientationModalLabel">Add Orientation Event</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form action="" method="POST" name="add_orientation_event_form" @submit.prevent="save_orientation_event">
			<div class="modal-body">
				<div class="row">
					<div class="col-12">

							<div class="field-wrapper">
								<select name="category" id="category" class="form-select">
									<option 
									v-for="(category, index) in orientation_categories"
									:key="category.id" 
									:value="category.id">
										{{category.name}}
									</option>
								</select>
								<div class="field-placeholder">Category<span class="text-danger">*</span></div>
							</div>
						
							<div class="field-wrapper">
								<input class="form-control" type="text" name="name">
								<div class="field-placeholder">Event name <span class="text-danger">*</span></div>
							</div>

							<!-- <div class="field-wrapper">
								<select class="form-select" id="formSelect" name="type">
									<option value="track" selected="">Track event</option>
									<option value="orentance">Orentance event</option>
								</select>
								<div class="field-placeholder">Event type <span class="text-danger">*</span></div>
							</div> -->

							<div class="field-wrapper">
								<input class="form-control" type="number" name="hours">
								<div class="field-placeholder">Event hours <span class="text-danger">*</span></div>
							</div>

							<div class="field-wrapper">
								<input class="form-control" type="number" name="minutes">
								<div class="field-placeholder">Event minutes <span class="text-danger">*</span></div>
							</div>

							<div class="field-wrapper">
								<input class="form-control" type="datetime-local" name="date">
								<div class="field-placeholder">Event start date time <span class="text-danger">*</span></div>
							</div>

							<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
						
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
				<button type="type" class="btn btn-primary">Save</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- ADD ORIENTATION Modal end -->

<!-- EDIT ORIENTATION EVENT Modal start -->
<div class="modal fade" id="updateTrackOrientationModal" tabindex="-1" aria-labelledby="updateTrackOrientationModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="updateTrackOrientationModalLabel">Edit Orientation Event</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form action="" method="POST" name="update_orientation_event_form" @submit.prevent="update_orientation_event">
			<input type="hidden" name="event_id" value="">
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
							<div class="field-wrapper">
								<select name="category" id="category" class="form-select">
									<option 
									v-for="(category, index) in orientation_categories"
									:key="category.id"
									:value="category.id">
										{{category.name}}
									</option>
								</select>
								<div class="field-placeholder">Category<span class="text-danger">*</span></div>
							</div>
						
							<div class="field-wrapper">
								<input class="form-control" type="text" name="name" required>
								<div class="field-placeholder">Event name <span class="text-danger">*</span></div>
							</div>

							<!-- <div class="field-wrapper">
								<select class="form-select" id="formSelect" name="type">
									<option value="track" selected="">Track event</option>
									<option value="orentance">Orentance event</option>
								</select>
								<div class="field-placeholder">Event type <span class="text-danger">*</span></div>
							</div> -->

							<div class="field-wrapper">
								<input class="form-control" type="number" name="hours" required>
								<div class="field-placeholder">Event hours <span class="text-danger">*</span></div>
							</div>

							<div class="field-wrapper">
								<input class="form-control" type="number" name="minutes" required>
								<div class="field-placeholder">Event minutes <span class="text-danger">*</span></div>
							</div>

							<div class="field-wrapper">
								<input class="form-control" type="datetime-local" name="date" required>
								<div class="field-placeholder">Event start date time <span class="text-danger">*</span></div>
							</div>

							<div class="field-wrapper">
								<input class="form-control" type="text" name="classes" required="">
								<div class="field-placeholder">Classes <span class="text-danger">*</span><em>Enter comma (,) seperated classes</em></div>
							</div>

							<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
						
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
				<button type="type" class="btn btn-primary">Save</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- Modal end -->

<!-- EDIT TRACK EVENT Modal start -->
<div class="modal fade" id="updateTrackModel" tabindex="-1" aria-labelledby="updateTrackModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="updateTrackModelLabel">TRACK</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form action="" method="POST" name="update_track_event_form" @submit.prevent="update_track_event">
			<input type="hidden" name="event_id" value="">
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
							<div class="field-wrapper">
								<select name="category" id="category" class="form-select">
									<option 
									v-for="(category, index) in track_categories"
									:key="category.id"
									:value="category.id">
										{{category.name}}
									</option>
								</select>
								<div class="field-placeholder">Category<span class="text-danger">*</span></div>
							</div>
						
							<div class="field-wrapper">
								<input class="form-control" type="text" name="name" required>
								<div class="field-placeholder">Event name <span class="text-danger">*</span></div>
							</div>

							<div class="field-wrapper">
								<input class="form-control" type="text" name="classes" required="">
								<div class="field-placeholder">Classes <span class="text-danger">*</span><em>Enter comma (,) seperated classes</em></div>
							</div>

							<!-- <div class="field-wrapper">
								<select class="form-select" id="formSelect" name="type">
									<option value="track" selected="">Track event</option>
									<option value="orentance">Orentance event</option>
								</select>
								<div class="field-placeholder">Event type <span class="text-danger">*</span></div>
							</div> -->

							<!-- <div class="field-wrapper">
								<input class="form-control" type="number" name="hours" required>
								<div class="field-placeholder">Event hours <span class="text-danger">*</span></div>
							</div> -->

							<!-- <div class="field-wrapper">
								<input class="form-control" type="number" name="minutes" required>
								<div class="field-placeholder">Event minutes <span class="text-danger">*</span></div>
							</div> -->

							<!-- <div class="field-wrapper">
								<input class="form-control" type="datetime-local" name="date" required>
								<div class="field-placeholder">Event start date time <span class="text-danger">*</span></div>
							</div> -->

							<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
						
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="btn btn-danger " data-bs-dismiss="modal">Close</button>
				<button type="type" class="btn btn-primary">Save</button>
			</div>
		</form>
		</div>
	</div>
</div>
<!-- Modal end -->

<div class="main-container">
<?php include('includes/topnavigation.php'); ?>


				<!-- Content wrapper scroll start -->
				<div class="content-wrapper-scroll">

					<!-- Content wrapper start -->
					<div class="content-wrapper">
						<div class="row">
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<!-- <h1 class="my-heading">Orientation Events</h1> -->
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
								<!-- <h1 class="my-heading">Track Events</h1> -->
							</div>
						</div>

						<!-- Row start -->
						<div class="row">
							<div class="col-md-6 col-lg-6">
							<h1 class="my-heading">Orientation Events</h1>
							<button v-on:click="aoc_button($event)" class="btn btn-info btn-sm mx-2" style="">+ Category</button>
							<div class="row">
									<div class=""><!-- col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 -->
											<div v-if="add_ocform" class="mx-2">
													<input type="name" value="" v-model="new_orientation_category" class="form-control mt-2 mb-2">
													<button class="btn btn-success btn-sm" v-on:click="add_orientation_c">Save</button>
											</div>
									</div>
							</div>

									<div class="row gutters mt-4" v-for="item in orientation_events">
										<div class=""><!-- col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 -->
												<div class="card">
														<div class="card-header  align-items-center justify-content-center">
																<div class="card-title text-center">{{ item.name }}</div>
																<div class="graph-day-selection" role="group">
																		<!-- <a href="<?= base_url('organizer/events/add'); ?>"><button type="button" class="btn active">Add Event</button></a> -->
																</div>
														</div>
														<div class="card-body">
																<!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
																		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
																</div>
																<div class="alert alert-danger alert-dismissible fade show" role="alert">
																		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
																</div> -->
																<div class="table-responsive">
																		<table class="table products-table">
																				<thead>
																						<tr>
																								<th>Name</th>
																								<th>Date</th>
																								<th>Hours</th>
																								<th>Minutes</th>
																								<th>Action</th>
																						</tr>
																				</thead>
																				<tbody>
																						<tr v-for="event in item.events">
																								<td>{{ event.event_name }}</td>
																								<td>{{ moment(event.date).format('YYYY-MM-DD hh:mm:ss a') }}</td>
																								<td>{{ event.hours }}</td>
																								<td>{{ event.minutes }}</td>
																								<td>
																										<a class="text-warning" 
																										v-on:click="edit_orientation_event(event.event_id)" 
																										href="javascript:void(0);">
																										edit
																										</a>&nbsp;&nbsp;
																										<a class="text-danger" v-on:click="delete_event(event.event_id)" href="javascript:void(0);">
																										delete
																										</a>&nbsp;&nbsp;
																										<!-- <a class="text-primary" href="">
																										View
																										</a> -->
																								</td>
																						</tr>
																				</tbody>
																		</table>
																</div>
														</div>
												</div>
												
										</div>
									</div>

								<div v-if="orientation_events.length == 0" class="alert alert-warning mt-4 alert-dismissible show">
									No orientation events saved yet.
									<!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
								</div>

						</div>

						<div class="col-md-6">
							<h1 class="my-heading">Track Events</h1>
								<!-- LOAD TRACK EVENTS -->
								<button v-on:click="atc_button($event)" class="btn btn-info btn-sm mx-2" style="">+ Category</button>
								<div class="row">
										<div class=""><!-- col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 -->
												<div v-if="add_tcform" class="mx-2">
														<input type="name" value="" v-model="new_track_category" class="form-control mt-2 mb-2">
														<button class="btn btn-success btn-sm" v-on:click="add_track_c">Save</button>
												</div>
										</div>
								</div>
								
										<div class="row gutters mt-4" v-for="item in track_events">
											<div class=""><!-- col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 -->
												<div class="card">
														<div class="card-header align-items-center justify-content-center">
																<div class="card-title"><a :href="generateItemLink(item.id)">{{ item.name }}</a></div>
																<div class="graph-day-selection" role="group">
																		<!-- <a href="<?= base_url('organizer/events/add'); ?>"><button type="button" class="btn active">Add Event</button></a> -->
																</div>
														</div>
														<div class="card-body">
																<!-- <div class="alert alert-success alert-dismissible fade show" role="alert">
																		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
																</div>
																<div class="alert alert-danger alert-dismissible fade show" role="alert">
																		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
																</div> -->
																<div class="table-responsive">
																		<table class="table products-table">
																				<thead>
																						<tr>
																								<th>Name</th>
																								<th>Action</th>
																						</tr>
																				</thead>
																				<tbody>
																							<tr v-for="event in item.events">
																								<td>{{ event.event_name }}</td>
																								<td>
																										<a v-bind:href="'<?= base_url('/organizer/events/'); ?>'+ event.event_id + '/category/'+item.id">
																											View
																										</a>&nbsp;&nbsp;
																										<a class="text-warning" v-on:click="edit_track_event(event.event_id)" href="javascript:void(0);">
																										edit
																										</a>&nbsp;&nbsp;
																										<a class="text-danger" v-on:click="delete_event(event.event_id)" href="javascript:void(0);">
																										delete
																										</a>&nbsp;&nbsp;
																										<!-- <a class="text-primary" href="">
																										View
																										</a> -->
																								</td>
																						</tr>
																				</tbody>
																		</table>
																</div>
														</div>
												</div>
											</div>
										</div>

									<div v-if="track_events.length == 0" class="alert alert-warning mt-4 alert-dismissible show">
										No track events saved yet.
										<!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
									</div>
								
							</div>

						</div>
					</div>
					
					


</div>

					<div class="card map-card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<div class="map-error-container">
									<?php if ($events_name == '') { ?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											There is no event today.
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									<?php } else { ?>
										<div class="alert alert-success alert-dismissible fade show" role="alert">
											<?php echo "Live locations for participants of events: $events_name"; ?>
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									<?php } ?>


									</div>
									<h1>Live Location of users for today's event:</h1>
									<button class="btn btn-primary btn-sm mb-2" onclick="toggleFullScreen()">Toggle Fullscreen</button>
									<div id="map"></div>
									
								</div>
							</div>
						</div>
					</div>
<script>
document.addEventListener("DOMContentLoaded", () => {

  const { createApp } = Vue;
	const app = createApp({
		methods: {
			moment,
			/* SHOW CLASSES MODAL */
			show_class_modal: function(){
				let modal = new bootstrap.Modal('#class_modal');
				modal.show();
			},
			save_class: function(){

			},
			/* ADD ORIENTATION CATEGORY CODE */
			aoc_button/* add orientation button */: function($event) {
				this.add_ocform = !this.add_ocform;
			},
			add_orientation_c:/* save orientation category to server */function($event) {
				let input = $($event.target).prev();
				let type = 'orientation';
				$(input).prev('.alert').remove();
				let category = (this.new_orientation_category).trim(); 
				if (category.length < 3) return;let outerThis = this;
				$.ajax({url: '<?= base_url('organizer/save_category'); ?>', method:'POST',data:{category,type},error: error => console.log(error),
				success: function(success) {
					if (success.category_already_exist !== undefined) {
						$(input).before(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
											Category with same name exist
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
					} else if (success.created !== undefined) {
						$(input).before(`<div class="alert alert-success alert-dismissible fade show" role="alert">
											Category saved successfully
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
						$(input).val('');
						outerThis.new_orientation_category = '';
						outerThis.orientation_categories = success.orientation;
					}
				}});
			},
			/* ~~~ ADD ORIENTATION CATEGORY CODE ^^^ */

			/* ADD TRACK CATEGORY CODE */
			atc_button/* add orientation button */: function($event) {
				this.add_tcform = !this.add_tcform;
			},
			add_track_c:/* save orientation category to server */function($event) {
				let input = $($event.target).prev();let type = 'track';
				$(input).prev('.alert').remove();
				let category = (this.new_track_category).trim(); 
				if (category.length < 3) return;let outerThis = this;
				$.ajax({url: '<?= base_url('organizer/save_category'); ?>', method:'POST',data:{category,type},error: error => console.log(error),
				success: function(success) {
					if (success.category_already_exist !== undefined) {
						$(input).before(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
											Category with same name exist
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
					} else if (success.created !== undefined) {
						$(input).before(`<div class="alert alert-success alert-dismissible fade show" role="alert">
											Category saved successfully
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
						$(input).val('');
						outerThis.new_track_category = '';
						outerThis.track_categories = success.track;
					}
				}});
			},
			/* SHOW ADD ORIENTATION EVENT FORM */
			show_aoe_form: function(){
				let modal = new bootstrap.Modal('#addTrackOrientationModal');
				modal.show();
			},
			save_orientation_event: function(){
				$('form[name="add_orientation_event_form"]').find('.alert').remove();

				let form = $('form[name="add_orientation_event_form"]');
				let name = ($(form).find('input[name="name"]').val()).trim();
				let hours = ($(form).find('input[name="hours"]').val()).trim();
				let minutes = ($(form).find('input[name="minutes"]').val()).trim();
				let date = ($(form).find('input[name="date"]').val()).trim();
				let category = ($(form).find('select[name="category"]').val());
				
				if (name == '' || hours == '' || minutes == '' || date == '') {
					let message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
					All fields are required.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>`);
					form.find('.col-12').prepend(message);
					$(message).fadeIn();
				} else {
					let outerThis = this;
					$.ajax({
						url: '<?= base_url('organizer/save_orientation_event') ?>',
						method: 'POST',
						data: {name, hours, minutes, date, category, race: outerThis.race},
						success: function(success) {
							if (success.event_name_used !== undefined) {
								let message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
									Event name in use.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
								form.find('.col-12').prepend(message);
								$(message).fadeIn();
							} else if (success.event_saved !== undefined) {
								form[0].reset();
								let message = $(`<div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;">
									Event saved successfully.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
								form.find('.col-12').prepend(message);
								$(message).fadeIn();

								outerThis.get_all_orientation_events();
								outerThis.get_all_track_events();
							}
						},
						error: function(error) {
							console.log(error);
						}
					})
				}
			},
			/* SHOW ADD TRACK EVENT FORM */
			show_ate_form: function(){
				let modal = new bootstrap.Modal('#addTrackEventModal');
				modal.show();
			},
			save_track_event:/* SAVE TRACK EVENT TO SERVER */function(){
				$('form[name="add_track_event_form"]').find('.alert').remove();

				let form = $('form[name="add_track_event_form"]');
				let name = ($(form).find('input[name="name"]').val()).trim();
				// let hours = ($(form).find('input[name="hours"]').val()).trim();
				// let minutes = ($(form).find('input[name="minutes"]').val()).trim();
				// let date = ($(form).find('input[name="date"]').val()).trim();
				let category = ($(form).find('select[name="category"]').val());
				
				if (name == '') {
					let message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
					All fields are required.
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>`);
					form.find('.col-12').prepend(message);
					$(message).fadeIn();
				} else {
					let outerThis = this;
					$.ajax({
						url: '<?= base_url('organizer/save_track_event') ?>',
						method: 'POST',
						data: {name, category, race: outerThis.race},// , hours, minutes, date, category
						success: function(success) {
							if (success.event_name_used !== undefined) {
								let message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
									Event name in use.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
								form.find('.col-12').prepend(message);
								$(message).fadeIn();
							} else if (success.event_saved !== undefined) {
								form[0].reset();
								let message = $(`<div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;">
									Event saved successfully.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
								form.find('.col-12').prepend(message);
								$(message).fadeIn();

								outerThis.get_all_orientation_events();
								outerThis.get_all_track_events();
							}
						},
						error: function(error) {
							console.log(error);
						}
					})
				}
			},

			get_all_orientation_events: function(){
				let outerThis = this;
				$.ajax({
					url: '<?= base_url('organizer/get_all_orientation_events') ?>',
					method: 'GET',
					data: {race: outerThis.race},
					success: function(success) {
						window.qaisar = success;
						if (success.events !== undefined) {
							const categories = {};

							for (const event of success.events) {
								const categoryName = event.category_name;
								if (!categories[categoryName]) {
									categories[categoryName] = {
										name: categoryName,
										events: []
									};
								}
								categories[categoryName].events.push(event);
							}

							const categoryCollection = Object.values(categories);
							outerThis.orientation_events = categoryCollection;
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
			},
			get_all_track_events: function(){
				let outerThis = this;
				$.ajax({
					url: '<?= base_url('organizer/get_all_track_events') ?>',
					method: 'GET',
					data: {race_id: outerThis.race},
					success: function(success) {
						window.qaisar = success;
						if (success.events !== undefined) {
							const categories = {};

							for (const event of success.events) {
								const categoryId = event.category_id;
								const categoryName = event.category_name;
								if (!categories[categoryName]) {
									categories[categoryName] = {
										id: categoryId,
										name: categoryName,
										events: []
									};
								}
								categories[categoryName].events.push(event);
							}

							const categoryCollection = Object.values(categories);
							outerThis.track_events = categoryCollection;
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
			},
			delete_event: function(id) {
				let confirm = window.confirm('Are you sure?');
				if (!confirm) return;
				let event_id = id;

				let outerThis = this;
				$.ajax({
					url: '<?= base_url('organizer/delete_event') ?>',
					method: 'GET',
					data: {event_id: event_id},
					success: function(success) {
						if (success.deleted !== undefined) {
							outerThis.get_all_orientation_events();
							outerThis.get_all_track_events();
						}
					}
				})
			},
			edit_orientation_event: function(event_id) {
				$.ajax({
					url: '<?= base_url('/organizer/get_single_orientation_event') ?>',
					method: 'GET',
					data: { event_id },
					success: function(success) {
						if (success.event !== undefined) {
							let { event } = success;
							let form = $('form[name="update_orientation_event_form"]');
							// form.find('select[name="category"]').val(event.category).prop('selected', true);
							form.find(`#category option[value="${event.category}"]`).attr('selected', 'selected');
							form.find('input[name="name"]').val(event.name);
							form.find('input[name="hours"]').val(event.hours);
							form.find('input[name="minutes"]').val(event.minutes);
							form.find('input[name="date"]').val(event.date);
							form.find('input[name="event_id"]').val(event.id);
							form.find('input[name="classes"]').val(event.classes);

							$('#updateTrackOrientationModal').find('h5').text(`Edit ${event.type} Event`);
							let modal = new bootstrap.Modal('#updateTrackOrientationModal');
							modal.show();
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
			},
			update_orientation_event: function() {
				$('form[name="update_orientation_event_form"]').find('.alert').remove();
				let outerThis = this;
				let form = $('form[name="update_orientation_event_form"]');
				let event_id = form.find('input[name="event_id"]').val();
				let name = (form.find('input[name="name"]').val()).trim();
				let classes = (form.find('input[name="classes"]').val()).trim();
				let hours = (form.find('input[name="hours"]').val()).trim();
				let minutes = (form.find('input[name="minutes"]').val()).trim();
				let date = (form.find('input[name="date"]').val()).trim();
				let category = form.find('select').children("option:selected").val();

				$.ajax({
					url: '<?= base_url('organizer/update_event') ?>',
					method: 'POST',
					data: {event_id, name, hours, minutes, date, category, classes},
					success: function(success) {
						if (success.event_name_used !== undefined) {
							let message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
									Event name in use.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
							form.find('.col-12').prepend(message);
							$(message).fadeIn();
						} else if (success.event_updated !== undefined) {
							let message = $(`<div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;">
									Event updated successfully.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
							form.find('.col-12').prepend(message);
							$(message).fadeIn();

							outerThis.get_all_orientation_events();
							outerThis.get_all_track_events();
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
			},
			edit_track_event: function(event_id) {
				$.ajax({
					url: '<?= base_url('/organizer/get_single_orientation_event') ?>',
					method: 'GET',
					data: { event_id },
					success: function(success) {
						if (success.event !== undefined) {
							let { event } = success;
							let form = $('form[name="update_track_event_form"]');
							// form.find('select[name="category"]').val(event.category).prop('selected', true);
							form.find(`#category option[value="${event.category}"]`).attr('selected', 'selected');
							form.find('input[name="name"]').val(event.name);
							// form.find('input[name="hours"]').val(event.hours);
							// form.find('input[name="minutes"]').val(event.minutes);
							// form.find('input[name="date"]').val(event.date);
							form.find('input[name="event_id"]').val(event.id);
							form.find('input[name="classes"]').val(event.classes);

							$('#updateTrackModel').find('h5').text(`Edit ${event.type} Event`);
							let modal = new bootstrap.Modal('#updateTrackModel');
							modal.show();
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
			},
			update_track_event: function() {
				$('form[name="update_track_event_form"]').find('.alert').remove();
				let outerThis = this;
				let form = $('form[name="update_track_event_form"]');
				let event_id = form.find('input[name="event_id"]').val();
				let name = (form.find('input[name="name"]').val()).trim();
				// let hours = (form.find('input[name="hours"]').val()).trim();
				// let minutes = (form.find('input[name="minutes"]').val()).trim();
				// let date = (form.find('input[name="date"]').val()).trim();
				let category = form.find('select').children("option:selected").val();
				let classes = (form.find('input[name="classes"]').val()).trim();

				$.ajax({
					url: '<?= base_url('organizer/update_event') ?>',
					method: 'POST',
					data: {event_id, name, /* hours, minutes, date,*/ category, classes},
					success: function(success) {
						if (success.event_name_used !== undefined) {
							let message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none;">
									Event name in use.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
							form.find('.col-12').prepend(message);
							$(message).fadeIn();
						} else if (success.event_updated !== undefined) {
							let message = $(`<div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;">
									Event updated successfully.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
							form.find('.col-12').prepend(message);
							$(message).fadeIn();

							outerThis.get_all_orientation_events();
							outerThis.get_all_track_events();
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
			},
			add_classes_to_event: function() {
				$('.alert').remove();
				let form = $('form[name="add_class_form"]');
				let event_id = form.find('select[name="event_id"]').val();
				let classes = (form.find('input[name="classes"]').val()).trim();
				
				if (classes == '') {
					form.prepend(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
									Enter classes.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
				} else {
					$.ajax({
						url: '<?= base_url('/organizer/add_classes_to_event'); ?>',
						method: 'POST',
						data: {event_id, classes},
						success: function(success) {
							if (success.class_added !== undefined) {
								form.prepend(`<div class="alert alert-success alert-dismissible fade show" role="alert">
									Classes Added successfully.
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>`);
								form[0].reset();

								outerThis.get_all_orientation_events();
								outerThis.get_all_track_events();
							}
						},
						error: function(error) {
							console.log(error);
						}
					});
				}
			},
			/* LINK FOR VIEW ALL RESULTS OF SELECTED CATEGORY - TRACK EVENTS */
			generateItemLink: function(id) {
				return '<?= base_url() ?>' + 'organizer/category_results/' + id;
			}
		},
		data() {
			return {
				race: '<?= $race->id ?>',
				track_categories: [],
				orientation_categories: [],
				add_ocform: false,
				new_orientation_category: '',
				add_tcform: false,
				new_track_category: '',

				orientation_events: [],
				track_events: [],

				all_events: [],
			}
		},
		mounted() {
			/* GET ORIENTATION AND TRACK EVENTS */
			this.get_all_orientation_events();
			this.get_all_track_events();
			let outerThis = this;
			
			/* AJAX REQUEST FOR GETTING ORIENTATION CATEGORIES */
			$.ajax({
				url: '<?= base_url('organizer/get_categories'); ?>',
				method: 'GET',
				data: {type: 'orientation'},
				success: function(success) {
					if (success.categories !== undefined) {
						outerThis.orientation_categories = success.categories;
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
			/* AJAX REQUEST FOR GETTING TRACK CATEGORIES */
			$.ajax({
				url: '<?= base_url('organizer/get_categories'); ?>',
				method: 'GET',
				data: {type: 'track'},
				success: function(success) {
					if (success.categories !== undefined) {
						outerThis.track_categories = success.categories;
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
			/* AJAX REQUEST FOR GETTING ALL EVENTS */
			$.ajax({
				url: '<?= base_url('/organizer/get_all_events'); ?>',
				method: 'GET',
				data: {type: 'orientation'},
				success: function(success) {
					if (success.events !== undefined) {
						outerThis.all_events = success.events;
					}
				},
				error: function(error) {
					console.log(error);
				}
			});


		}
	}).mount('#vue-app');

	$("#toggle-sidebar").on('click', function () {
		$(".page-wrapper").toggleClass("toggled");
	});

}); 
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {

	// document.addEventListener('keydown', function(event) {
  // if (event.key === 'c') {
	// 		exitFullscreen();
	// 	}
	// });
	// document.addEventListener('keydown', function(event) {
	// 	if (event.key === 'f') {
	// 		toggleFullScreen();
	// 	}
	// });


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
      data: {race_id: '<?= $race->id ?>'},
      success: function(success) {
        if (success.liveLocations !== undefined) {

          if (success.liveLocations.length == 0) {
            $('.map-error').remove();
            $('.map-error-container').append(`<div class="alert alert-danger alert-dismissible fade show map-error" role="alert">
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