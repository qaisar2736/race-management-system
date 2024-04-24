<div class="container-fluid">

  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <h1 class="">Update Location</h1>

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

          <form action="<?= base_url('organizer/locations/update') ?>" method="POST" name="location_form">
            <input type="hidden" name="location_id" value="<?= $location['id'] ?>">
            <input type="hidden" name="event_id" value="<?= $selected_event ?>">
            <!-- <input type="hidden" name="latitude_longitude_image" value=""> -->
            <div class="field-wrapper">
              <input type="text" class="form-control" name="points" placeholder="points" value="<?= $location['points'] ?>">
              <div class="field-placeholder">Points</div>
            </div>
            <div class="field-wrapper">
              <input type="text" class="form-control" name="location" placeholder="location" value="<?= $location['location'] ?>">
              <div class="field-placeholder">Location</div>
            </div>
            <!-- <div class="field-wrapper">
              <input type="text" class="form-control" name="latitude_longitude" placeholder="Latitude,Longitude" value="<?= $location['latitude_longitude'] ?>">
              <div class="field-placeholder">Latitude , Longitude</div>
            </div> -->
            <!-- <div class="field-wrapper">
              <label for="">QR code</label>
              <div id="qrcode"></div>
              <img src="" alt="" id="qrcode">
            </div> -->

            <button type="submit" name="update" class="btn btn-primary">Update</button>

          </form>
        </div>
      </div>
    </div>
  </div>

</div>
<script>
document.addEventListener("DOMContentLoaded", () => {

  $('input[name="latitude_longitude"]').change(function(){
    $('#qrcode').html('');
    
    var qrcode = new QRCode("qrcode");
    var latitude_longitude = ($(this).val()).trim();

    var url = '<?= base_url('participant/reached'); ?>?latitude_longitude=' + latitude_longitude;

    if (latitude_longitude != '') {
      qrcode.makeCode(url);
    }

  })

  $('form[name="location_form"]').submit(function(e) {
    $('.alert').remove();

    var form = $(this);
    var location = ($('input[name="location"]').val()).trim();
    var points = ($('input[name="points"]').val()).trim();

    if (location == '' || points == '') {
      e.preventDefault();
      $('form').before(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
											Both fields are required.
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>`);
    } else {
      // var barcode_image = $('#qrcode > img').attr('src');
      // $('input[name="latitude_longitude_image"]').val(barcode_image);
    }
  });

});
</script>