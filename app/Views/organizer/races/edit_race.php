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
									
									<a href="<?= base_url('organizer/races') ?>"><button class="btn btn-info btn-sm">Back</button></a>
									
										<div class="card-title">Edit Race</div>
										<div class="graph-day-selection" role="group">
											<!-- <button type="button" class="btn active">Export to Excel</button> -->
										</div>
									</div>
									<div class="card-body">
										<div class="row">
                      <div class="col-md-4">
                      <?php if (session()->has('error')) { ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <?php echo session()->getFlashdata('error'); ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      <?php } ?>
                      <?php if (session()->has('success')) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <?php echo session()->getFlashdata('success'); ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                      <?php } ?>
                        <form action="<?= base_url('organizer/races/edit/'.$race->id); ?>" name="edit_race" method="POST">
                          <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="<?= $race->name ?>">
                          </div>

                          <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            <!-- <input type="save" name="save" value="Save" class="btn btn-primary btn-sm"> -->
                          </div>
                        </form>
                      </div>
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

  $('form[name="edit_race"]').submit(function(e) {
    $('.alert').remove();
    let form = $(this);
    let name = $(form).find('input[name="name"]').val().trim();

    if (name == '') {
      e.preventDefault();
      let message = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
											Enter name.
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
      $(form).before(message);
      $(message).fadeIn(300);
    }
  })
});
</script>