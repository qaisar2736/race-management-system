<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<style>
table {
	font-family: 'Montserrat', sans-serif;
	font-size: 15px;
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
										<h2><?= count($categories) ?></h2>
										<p>Categories</p>
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
										<div class="card-title">Categories</div>
										<div class="" role="group">
											<!-- <a href="<?= base_url('organizer/categories/add'); ?>"><button type="button" class="btn active">Add Category</button></a> -->

											<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
												Add Category
											</button>

<!-- ADD CATEGORY Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<form action="" method="POST" name="save_category_form">
				<div class="field-wrapper">
					<input class="form-control" type="text" required name="category">
					<div class="field-placeholder">Category <span class="text-danger">*</span></div>
				</div>

				<input type="submit" name="save" value="Save" class="btn btn-primary btn-sm">
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-danger">Cancel</button> -->
      </div>
    </div>
  </div>
</div>

										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table products-table categories">
												<thead>
													<tr>
														<th>Name</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($categories as $category) { ?>
													<tr>
														<?php $ec = $category->event_count; ?>
														<td><?= $category->name ?>&nbsp;<em class="text-info"><?= ($ec > 0) ? $ec . ' events' :''; ?></em></td>
														<td>
															<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#updateCategoryModal" class="update_category" data-id="<?= $category->id ?>">edit</a>&nbsp;
															<a href="javascript:void(0)" class="delete_category" data-id="<?= $category->id ?>">delete</a>
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
<!-- ADD CATEGORY Modal -->
<div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
				<form action="" method="POST" name="update_category_form">
					<input type="hidden" name="category_id" value="">
				<div class="field-wrapper">
					<input class="form-control" type="text" required name="category">
					<div class="field-placeholder">Category <span class="text-danger">*</span></div>
				</div>

				<input type="submit" name="update" value="Update" class="btn btn-primary btn-sm">
				</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Close</button>
        <!-- <button type="button" class="btn btn-danger">Cancel</button> -->
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
  $('form[name="save_category_form"]').submit(function(e) {
		let form = $(this);
		e.preventDefault();

		var category = ($('input[name="category"]').val()).trim();
		$.ajax({
			url: '<?= base_url('organizer/categories/add'); ?>',
			method: 'POST',
			data: {
				category
			},
			success: function(success) {
				if (typeof success['success'] != 'undefined') {
					form.prepend($(`<div class="alert alert-success" role="alert">
										Category created successfully
										</div>`));

					setTimeout(function() {
						window.location.href = "<?= base_url('organizer/categories') ?>";
					}, 2000);
				}
			},
			error: function(error) {
				console.log(error);
			}
		});
	});

	$('.delete_category').click(function(){
		var confirm = window.confirm('Are you sure?');
		var tr = $(this).parent().parent();

		if (confirm) {
			$('.alert').remove();
			let category_id = $(this).attr('data-id')
			$.ajax({
				url: '<?= base_url('organizer/categories/delete'); ?>',
				method: 'POST',
				data: { id: category_id },
				success: function(success) {
					if (typeof success['success'] != 'undefined') {
						$(tr).fadeOut();

						$('table.categories').before($(`<div class="alert alert-success alert-dismissible fade show" role="alert">
												Success! Category deleted successfully.
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>`));
						
					}
				},	
				error: function(error) {
					console.log(error);
				}
			});
		}
		
	});

	$('.update_category').click(function(){
		let category_id = $(this).attr('data-id');
		let category = $(this).parent().parent().find('td')[0];
		category = $(category).text();
		
		$('form[name="update_category_form"]').find('input[name="category"]').val(category);
		$('form[name="update_category_form"]').find('input[name="category_id"]').val(category_id);
	});

	$('form[name="update_category_form"]').submit(function(e) {
		e.preventDefault();
		let form = $(this);
		let id = $(this).find('input[name="category_id"]').val();
		let category = $(this).find('input[name="category"]').val();

		$.ajax({
			url: '<?= base_url('organizer/categories/update'); ?>',
			method: 'POST',
			data: {
				id, category
			},
			success: function(success) {
				if (typeof success['success'] != 'undefined') {
					form.prepend($(`<div class="alert alert-success" role="alert">
										Category updated successfully
										</div>`));

					setTimeout(function() {
						window.location.href = "<?= base_url('organizer/categories') ?>";
					}, 2000);
				}
			},
			error: function(error) {
				console.log(error);
			}
		});
	});

});
</script>