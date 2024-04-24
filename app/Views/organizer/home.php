

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
										<h2><?= count($events) ?></h2>
										<p>Events</p>
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
										<div class="card-title">Events</div>
										<div class="graph-day-selection" role="group">
											<a href="<?= base_url('organizer/events/add'); ?>"><button type="button" class="btn active">Add Event</button></a>
										</div>
									</div>
									<div class="card-body">
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
													<?php foreach ($events as $event) { ?>
													<tr>
														<td><?= $event['name'] ?></td>
														<td><?= proper_date($event['date'], 'd-m-Y h:i:s a') ?></td>
														<td><?= $event['hours'] ?></td>
														<td><?= $event['minutes'] ?></td>
														<td>
															<a href="/organizer/events/edit?id=<?= $event['id'] ?>">edit</a>&nbsp;
															<a onclick="return confirm('Are you sure?')" href="/organizer/events/delete?id=<?= $event['id'] ?>">delete</a>
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

						<!-- Row start -->
						<!-- Row end -->

					</div>
					<!-- Content wrapper end -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  console.log(jQuery.fn.jquery);
});
</script>