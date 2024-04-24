<div class="container">
		<div class="mt-4 p-5 bg-secondary text-white rounded">
				<h1>Welcome to rally</h1>
				<p>Here you can view...</p>
		</div>
</div>

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
														<th>Date Time</th>										
														<th><!--Action--></th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($events as $event) { ?>
													<tr>
														<td><?= $event->name ?></td>
														<td><?= proper_date($event->date, 'd-m-Y h:i:s a') ?></td>
														<!-- <td><?php /* $event->hours . ' hours ' . $event->minutes . ' minutes' */ ?></td> -->
														<td>
															<?php if ($event->user_id != $_SESSION['id'] && $event->status == 0) { ?>
															<h6><a href="<?= base_url('events/request?id='.$event->id); ?>">Request</a></h6>
															<?php } else if ($event->user_id == $_SESSION['id'] && $event->status == 1) { ?>
															<h6><a class="text-primary" href="<?= base_url('events/view?id='.$event->id); ?>">View</a></h6>
															<?php } else if ($event->user_id == $_SESSION['id'] && $event->status == 0) { ?>
															<h6><a class="text-success" href="#">Requested</a></h6>
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

				</div>

				

		</div>
</div>
<br><br><br><br><br><br><br><br><br><br>
<?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'participant') { require "live_location.php"; } ?>
