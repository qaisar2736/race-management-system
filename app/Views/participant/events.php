

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
											<!-- <button type="button" class="btn active">Export to Excel</button> -->
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
														<th><!--Action--></th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($events as $event) { ?>
													<tr>
														<td><?= $event->name ?></td>
														<td><?= proper_date($event->date) ?></td>
														<td><?= $event->hours ?></td>
														<td><?= $event->minutes?></td>
														<td>
															<?php if ($event->user_id != $_SESSION['id'] && $event->status == 0) { ?>
															<a href="<?= base_url('participant/events/request?id='.$event->id); ?>">Request</a>
															<?php } else if ($event->user_id == $_SESSION['id'] && $event->status == 1) { ?>
															<a href="<?= base_url('participant/events/view?id='.$event->id); ?>">View</a>
															<?php } else if ($event->user_id == $_SESSION['id'] && $event->status == 0) { ?>
															<a href="#">Requested</a>
															<?php } ?>
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