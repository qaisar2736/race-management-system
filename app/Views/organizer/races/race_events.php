<style>
.oe-tab, .te-tab {
  font-weight: 900;
  font-size: 20px;
  letter-spacing: 3px;
}
.race-title {
  text-transform: uppercase;
  color: #0d6efd;
  letter-spacing: 4px;
  text-align: center;
}
.nav-item .nav-link:not(.active) {
	opacity: 0.2;
}
.nav-item .nav-link.active {
	background: #73b0fc !important;
	opacity: 1;
}
</style>
<script>
	function show_edit_oe_form(id) {
		$.ajax({
			url: '<?= base_url('/organizer/get_single_orientation_event') ?>',
			method: 'GET',
			data: { event_id: id },
			success: function(success) {console.log('success');
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
	}

	function delete_event(id) {
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
					window.location.href = window.location.href;
				}
			}
		})
	}
</script>
<div class="content-wrapper-scroll">

					<div class="content-wrapper">

						<div class="row gutters">
						</div>

						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="card">
									<div class="card-header">
                    <div class="d-flex justify-content-between align-items-center w-100">
                      <div class="card-title race-title w-100"><h3><?= $race->name ?> - Race</h3></div>
                      <!-- <div class="form-group  text-end">
                        <input type="text" name="search" value="" id="searchInput" class="form-control" placeholder="Search">
                      </div> -->
                    </div>
									</div>
									<div class="card-body">
                  <div class="custom-tabs-container">
											<ul class="nav nav-tabs d-flex justify-content-between" id="myTab" role="tablist">
												<li class="nav-item flex-fill" role="presentation">
													<a class="nav-link active text-center oe-tab" id="first-tab" data-bs-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">Orientation Events</a>
												</li>
												<li class="nav-item flex-fill" role="presentation">
													<a class="nav-link text-center te-tab" id="second-tab" data-bs-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Track Events</a>
												</li>
												<!-- <li class="nav-item" role="presentation">
													<a class="nav-link" id="third-tab" data-bs-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">Third Tab</a>
												</li> -->
											</ul>
											<div class="tab-content" id="myTabContent">
												<div class="tab-pane fade show active orientation_events" id="first" role="tabpanel">
													<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addOrientationModal">ADD <span class="icon-plus1"></span></button>
													<p class="text-muter">
														<div class="table-responsive">
														<table class="table products-table">
															<thead>
																<tr>
																	<th>Name</th>
																	<th>Date</th>
																	<th>Hours</th>
																	<th>Minutes</th>
																	<th>Category</th>
																	<th>Action</th>
																</tr>
															</thead>
															<tbody>
																<?php foreach ($orientation_events as $oe): ?>
																<tr>
																	<td><?= $oe->name ?></td>
																	<td><?= proper_date($oe->date, 'Y-m-d h:i:s a') ?></td>
																	<td><?= $oe->hours ?></td>
																	<td><?= $oe->minutes ?></td>
																	<td><?= $oe->category_name ?></td>
																	<td>
																		<a href="javascript:void(0);" onclick="show_edit_oe_form(<?= $oe->id; ?>)">Edit</a>
																		<a href="javascript:void(0);" onclick="delete_event(<?= $oe->id ?>)">Delete</a>
																	</td>
																</tr>
																<?php endforeach; ?>
															</tbody>
														</table>
														</div>
													</p>

												</div>
												<div class="tab-pane fade" id="second" role="tabpanel">
													
												<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addOrientationModal">ADD <span class="icon-plus1"></span></button>
												<p class="text-muter"></p>
												<div class="table-responsive">
														<table class="table products-table">
																<thead>
																		<tr>
																				<th>Name</th>
																				<!-- <th>Date</th>
																				<th>Hours</th>
																				<th>Minutes</th> -->
																				<th>Category</th>
																				<th>Action</th>
																		</tr>
																</thead>
																<tbody>
																		<?php foreach ($track_events as $te): ?>
																		<tr>
																				<td><?= $te->name; ?></td>
																				<td><?= $te->category_name ?></td>
																				<td>
																					<a href="javascript:void(0);" onclick="show_edit_oe_form(<?= $te->id ?>)">Edit</a>&nbsp;
																					<a href="javascript:void(0);" onclick="delete_event(<?= $te->id ?>)">Delete</a></td>
																		</tr>
																		<?php endforeach; ?>
																</tbody>
														</table>
												</div>
												<p></p>

												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>


					</div>
<!-- ADD ORIENTATION EVENT Modal start -->
<div class="modal fade" id="addOrientationModal" tabindex="-1" aria-labelledby="addOrientationModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="addOrientationModal">Add Orientation Event</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form action="<?= base_url('organizer/races/'.$race->id.'/orientation_event/save') ?>" method="POST" name="add_orientation_event_form">
			<div class="modal-body">
				<div class="row">
					<div class="col-12">

							<div class="field-wrapper">
								<select name="category" id="category" class="form-select">
									<option value="">SELECT CATEGORY</option>
									<?php foreach ($categories as $category): ?>
										<option value="<?= $category->id; ?>"><?= $category->name; ?></option>
									<?php endforeach; ?>
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
		<form action="" method="POST" name="update_orientation_event_form">
			<input type="hidden" name="event_id" value="">
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
							<div class="field-wrapper">
								<select name="category" id="category" class="form-select">
									<option value="">SELECT CATEGORY</option>
									<?php foreach ($categories as $category): ?>
										<option value="<?= $category->id; ?>"><?= $category->name; ?></option>
									<?php endforeach; ?>
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
<script>

document.addEventListener("DOMContentLoaded", function() {

	/* UPDATE ORIENTATION FORM HANDLE */
	$('form[name="update_orientation_event_form"]').submit(function(e) {
		e.preventDefault();
		$('.alert').remove();
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

					setTimeout(() => {
						window.location.href = window.location.href;
					}, 1000);
				}
			},
			error: function(error) {
				console.log(error);
			}
		});
	});

	/* ADD ORIENTATION FORM HANDLE */
	$('form[name="add_orientation_event_form"]').submit(function(e) {
		$('.alert').remove();
		let form = $(this);
		let race_id = <?= $race->id ?>;
		let category = form.find('select[name="category"]').val();
		let name = form.find('input[name="name"]').val().trim();
		let hours = form.find('input[name="hours"]').val().trim();
		let minutes = form.find('input[name="minutes"]').val().trim();
		let date = form.find('input[name="date"]').val().trim();

		if (category == "" || name == "" || hours == "" || minutes == "" || date == "") {
			e.preventDefault();
      let message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
											All fields are required!
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
			form.find('.col-12').before(message);
      $(message).fadeIn(300);
		} else {
			e.preventDefault();
			$.ajax({
				url: '<?= base_url('organizer/save_orientation_event') ?>',
				method: 'POST',
				data: {name, hours, minutes, date, category, race_id},
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

						setTimeout(() => {
							window.location.href = window.location.href;
						}, 1000);
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
		}
		// e.preventDefault();
		// console.log(category);
	});

  // const searchInput = document.getElementById('searchInput');
  // const table = document.getElementById('myTable');
  // const tableRows = table.getElementsByTagName('tr');

  // searchInput.addEventListener('input', function() {
  //   const searchTerm = searchInput.value.toLowerCase();

  //   for (let i = 1; i < tableRows.length; i++) {
  //     const rowData = tableRows[i].innerText.toLowerCase();

  //     if (rowData.includes(searchTerm)) {
  //       tableRows[i].style.display = '';
  //     } else {
  //       tableRows[i].style.display = 'none';
  //     }
  //   }
  // });
}); 

</script>