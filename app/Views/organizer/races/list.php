<style>
.main-container {
	background: url('/img/background-image.jpg') no-repeat !important;
	background-size: cover !important;
	background-attachment: fixed !important;
	overflow: auto !important;
}
</style>
<div class="content-wrapper-scroll">

					<!-- Content wrapper start -->
					<div class="content-wrapper">

						<!-- Row start -->
						<div class="row gutters">
							
							
							
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
                    <div class="d-flex justify-content-between align-items-center w-100">
                      <div class="card-title">Races</div>
											<a class="btn btn-primary" href="<?= base_url('organizer/races/add') ?>">ADD +</a>
                      <div class="form-group  text-end">
												
                        <input type="text" name="search" value="" id="searchInput" class="form-control" placeholder="Search">
                      </div>
                    </div>
										<!-- <div class="card-title">Races
                      <input type="text" name="search" value="" class="form-control">
                    </div> -->
										<!-- <div class="graph-day-selection" role="group"> -->
											<!-- <button type="button" class="btn active">Export to Excel</button> -->
										<!-- </div> -->
									</div>
									<div class="card-body">
										<div class="table-responsive">
                      <?php if (session()->has('success')) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <?php echo session()->getFlashdata('success'); ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      <?php } ?>
											<table class="table products-table" id="myTable">
												<thead>
													<tr>
														<th>Name</th>
														<th>Edit</th>
														<th>Delete</th>
													</tr>
												</thead>
												<tbody>
                        <?php foreach($races as $race) { ?>
													<tr>
														<td><a href="<?= base_url('organizer/events/'.$race->id) ?>"><?= $race->name ?></a></td>
														<td><a href="<?= base_url('organizer/races/edit/'.$race->id) ?>">Edit</a></td>
                            <td><a onclick="return confirm('Are you sure?');" href="<?= base_url('organizer/races/delete/'.$race->id); ?>">Delete</a></td>
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

					<!-- App footer start -->
					<!-- <div class="app-footer">© Uni Pro Admin 2021</div>
					App footer end

				</div> -->
<script>

document.addEventListener("DOMContentLoaded", function() {

	$('.sidebar-wrapper').remove();
	$('.main-container').css('padding-left', '0px');
	$('.main-container').css('background', 'initial');
	// $('.main-container').css('background', 'url('+'<?= base_url() ?>'+'img/background-image.jpg) no-repeat');
  // $('.main-container').css('background-size', 'cover');
	// $('.main-container').css('background-attachment', 'fixed');
	// $('.main-container').css('overflow', 'auto');

	$('.content-wrapper').css('max-width', '500px');
	$('.content-wrapper').css('margin', '0 auto');
	$('.content-wrapper').css('overflow', 'hidden');

	$('.page-header').css('border-bottom', '0px');

  const searchInput = document.getElementById('searchInput');
  const table = document.getElementById('myTable');
  const tableRows = table.getElementsByTagName('tr');

  searchInput.addEventListener('input', function() {
    const searchTerm = searchInput.value.toLowerCase();

    for (let i = 1; i < tableRows.length; i++) {
      const rowData = tableRows[i].innerText.toLowerCase();

      if (rowData.includes(searchTerm)) {
        tableRows[i].style.display = '';
      } else {
        tableRows[i].style.display = 'none';
      }
    }
  });
}); 

</script>