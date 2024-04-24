<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-3">
          <div class="field-wrapper">
            <select class="form-select" id="eventSelect" name="event_select">
              <option value="">Select event</option>
              <?php foreach($events as $event) { ?>
              <option value="<?= $event['id'] ?>" 
              <?= (isset($selected_event) && $selected_event == $event['id']) ? 'selected' : '' ?>
              ><?= $event['name'] ?></option>
              <?php } ?>
            </select>
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if (isset($selected_event)) { ?>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <h1 class="">Add Location</h1>

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

          <form action="<?= base_url('organizer/locations/save') ?>" method="POST" name="location_form">
            <input type="hidden" name="event_id" value="<?= $selected_event ?>">
            <input type="hidden" name="latitude_longitude_image" value="">
            <div class="field-wrapper">
              <input type="number" class="form-control" name="points" placeholder="points">
              <div class="field-placeholder">Points</div>
            </div>
            <div class="field-wrapper">
              <input type="text" class="form-control" name="location" placeholder="location">
              <div class="field-placeholder">Location</div>
            </div>
            <!-- <div class="field-wrapper">
              <input type="text" class="form-control" name="latitude_longitude" placeholder="Latitude,Longitude">
              <div class="field-placeholder">Latitude , Longitude</div>
            </div> -->
            <!-- <div class="field-wrapper">
              <label for="">QR code</label>
              <div id="qrcode"></div> -->
              <!-- <img src="" alt="" id="qrcode"> -->
            <!-- </div> -->

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>

          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <h1>Locations of this event:</h1>
          <table class="table table-hover table-bordered m-0">
            <thead>
              <tr>
                <th>Location</th>
                <!-- <th>Latitude , Longitude</th> -->
                <th>Points</th>
                <!-- <th>QR Code</th> -->
                <!-- <th>Download</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($locations as $location) { ?>
              <tr>
                <td><?= $location['location'] ?></td>
                <!-- <td><?php // echo $location['latitude_longitude'] ?></td> -->
                <td><?= $location['points'] ?></td>
                <!-- <td><img width="200" class="img-fluid" src="<?php 
                //echo base_url('qr_code_images/'.$location['barcode_image']) 
                ?>" alt="barcode image"></td> -->
                <!-- <td>
                  <a Download="<?php // echo $location['barcode_image'] ?>" class="text-primary" href="<?php // echo base_url('qr_code_images/'.$location['barcode_image']) ?>">Download</a>
                </td> -->
                <td>
                  <a href="<?= base_url('organizer/locations/edit?id='.$location['id'].'&event='.$selected_event); ?>">edit</a>&nbsp;
                  <a onclick="return confirm('Are you sure?');" href="<?= base_url('organizer/locations/delete?id='.$location['id'].'&event='.$selected_event); ?>">delete</a>&nbsp;
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php } ?>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {

  $('input[name="latitude_longitude"]').change(function(){
    // $('#qrcode > img').remove();
    
    // var qrcode = new QRCode("qrcode");
    // var latitude_longitude = ($(this).val()).trim();
    // var location = ($('input[name="location"]').val()).trim();


    // <?php if (isset($_GET['event_id'])): ?>
    // var url = '<?= base_url('user/reached'); ?>?location='+location+'&event_id=<?= $_GET['event_id'] ?>&latitude_longitude=' + latitude_longitude;
    // <?php else: ?>
    // var url = '<?= base_url('user/reached'); ?>?latitude_longitude=' + latitude_longitude;
    // <?php endif; ?>

    // if (latitude_longitude != '') {
    //   qrcode.makeCode(url);
    // }

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

  $('#eventSelect').change(function(){
    var event_id = $(this).val();
    if (event_id != '') {
      window.location = '/organizer/locations?event_id='+ event_id;
    }
  });
});
</script>