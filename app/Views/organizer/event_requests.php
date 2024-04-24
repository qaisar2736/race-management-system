<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<style>
table {
	font-family: 'Montserrat', sans-serif;
	font-size: 14px;
}
a:hover {
	cursor: pointer;
}
</style>

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
										<h2><?= count($event_requests) ?></h2>
										<p>Event Requests</p>
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
										<div class="card-title">Event requests</div>
										<div class="graph-day-selection" role="group">
											<!-- <button type="button" class="btn active">Export to Excel</button> -->
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table products-table">
												<thead>
													<tr>
														<th>Participant</th>		
														<th>Email</th>
														<th>Event</th>
														<!-- <th>Hours</th> -->
														<!-- <th>Minutes</th>										 -->
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($event_requests as $request) { ?>
													<tr>
														<td><?= $request->name . ' ' . $request->surname ?></td>
														<td><?= $request->user_email ?></td>
														<td><?= $request->event_name ?></td>
														<!-- <td><?php /* $request->hours */ ?></td> -->
														<!-- <td><?php /* $request->minutes */ ?></td> -->
														<td>
                              <?php if ($request->status == 0) { ?>
															<a class="text-warning approve" href="<?= base_url('/organizer/event_requests/approve?id=' . $request->id); ?>" data-id="<?= $request->id ?>">Approve</a>
                              <?php } else { 
                                echo '<a href="#" class="text-success">Approved</a>';
                              } ?>
														</td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Row end -->

<!-- Modal -->
<div class="modal fade" id="approveRequestModal" tabindex="-1" aria-labelledby="approveRequestModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="approveRequestModalLabel">Approve request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

						<!-- Row start -->
						<!-- Row end -->

					</div>
					<!-- Content wrapper end -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  $('.approve').click(function(){
		let anchor_tag = $(this);
		let APPROVE_URL = '<?= base_url('organizer/event_requests/approve?id='); ?>';
		let request_id = $(this).attr('data-id');

		$.ajax({
			url: '<?= base_url('organizer/get_available_classes'); ?>',
			method: 'GET',
			data: { request_id },
			success: function(success) {
				let availabe_classes = [];
				if (success.classes !== undefined) {
					let user = success.user;
					let user_information = $(`<table class="table table-bordered">
							<thead>
								<tr>
									<th>User</th>
									<td>${user.name} ${user.surname}</td>
								</tr>
								<tr>
									<th>Machine</th>
									<td>${user.machine}</td>
								</tr>
								<tr>
									<th>Size of wheel</th>
									<td>${user.size_of_wheel}</td>
								</tr>
								<tr>
									<th>Have winch:</th>
									<td>${user.have_winch == '1' ? 'yes' : user.have_winch == '0' ? 'no' : '-'}</td>
								</tr>
							</thead>
						</table>`);
					availabe_classes = (typeof success.classes === 'string' && success.classes.length > 0) ? success.classes.split(',') : [];
					let select = `<select name="selected_class" class="form-control mb-2"><option value="">SELECT CLASS</option>`;
					availabe_classes.forEach(function(x) {
						select += `<option value="${x}">${x}</option>`;
					});
					select += `</select>`;
					select = $(select);
					let html = $(`<div></div>`);

					if (availabe_classes.length > 0) {
						
						$(html).append(user_information);
						$(html).append(`<label>Select class for user</label>`);
						let approve_button = $(`<button class="btn btn-success mx-2" disabled="true">APPROVE</button>`);
						$(select).change(function() {
							let selected_class = $(this).val();
							if (selected_class == '') {
								$(approve_button).attr('disabled', true);
							} else {
								$(approve_button).attr('disabled', false);
							}
						});
						$(html).append(select);
						$(approve_button).click(function(){
							let selected_class = $('select[name="selected_class"]').val();
							$.ajax({
								url: '<?= base_url('organizer/approve_request') ?>',
								method: 'POST',
								data: { selected_class, request_id },
								success: function(success) {
									if (success.approved !== undefined) {
										$(anchor_tag).text('Approved');
										$(anchor_tag).removeClass('text-warning').addClass('text-success');
										$(html).prepend(`<div class="alert alert-success alert-dismissible fade show" role="alert">
											Approved successfully.
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
									}
								}
							});
						});
						$(html).append(approve_button);
					} else {
						$(html).append(user_information);
						$(html).append(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
											No classes added to this event.
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
						$(html).append(`<a href="${APPROVE_URL + request_id}"><button class="btn btn-success">APPROVE</button></a>`);
					}
					
					$('.modal-body').html(html);

					var approveModal = new bootstrap.Modal('#approveRequestModal');
					approveModal.show();
				}
			},
			error: function(error) {
				console.log(error);
			}
		});

		
	});
});
</script>