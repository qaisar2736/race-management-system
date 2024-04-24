<div class="container-fluid">
<?php if (session()->has('error')) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?php echo session()->getFlashdata('error'); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php } ?>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-3 select-user-div">
          <div class="field-wrapper">
            <select class="form-select" id="user_select" name="user_select">
              <?php 
                if (isset($_GET['user_id'])) {
                  $user_id = $_GET['user_id'];
                } else {
                  $user_id = '';
                }
              ?>
              <option value="">Select user</option>
              <?php foreach($participants as $user) { ?>
              <option value="<?= $user->id ?>" <?= ($user_id == $user->id) ? 'selected' : ''; ?>>
                <?= $user->name . ' ' . $user->surname ?>
              </option>
              <?php } ?>
            </select>
            
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php if (isset($reached_locations)) { ?>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <h4 class="">Reached locations:</h4>

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

          <table class="table table-bordered">
            <thead>
              <tr>
                <!-- <th>User</th> -->
                <th>Event</th>
                <th>Location</th>
                <th>Date</th>
                <th>Points</th>
                <th>Image</th>
                <th>Revoke</th>
                <th>Reason</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reached_locations as $lr) { ?>
              <tr>
                <td><?= $lr->event_name ?></td>
                <td><?= $lr->location ?></td>
                <td><?= proper_date($lr->lr_date, 'd-m-Y h:i:s a') ?></td>
                <td><?= $lr->points ?></td>
                <td>
                  <img width="200" src="<?= base_url('location_images/'.$lr->image) ?>" alt="<?= $lr->image ?>">
                </td>
                <td>
                  <a href="javascript:void(0);" class="text-success revoke" data-lr-id="<?= $lr->id; ?>">Revoke</a>
                </td>
                <td>
                  <?= (empty($lr->revoke_reason)) ? '-' : $lr->revoke_reason; ?>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>


<!-- Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal content goes here -->
      <?php (isset($_GET['user_id'])) ? $user_id = $_GET['user_id'] : $user_id = ''; ?>
      <form action="<?= base_url('organizer/locations/reached?user_id='.$user_id) ?>" method="POST" id="myForm">
        <input type="hidden" name="location_reached_id" value="">
        <div class="modal-header">
          <h5 class="modal-title">Revoke Location Reached</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          
            <div class="form-group">
              <label for="">Revoke Reason</label>
              <textarea name="revoke_reason" id="revoke_reason" cols="30" rows="10" class="form-control" required></textarea>
            </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>



  <?php } ?>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {

  $('.revoke').click(function(){
    let location_reached_id = $(this).attr('data-lr-id');
    $('#myForm').find('input[name="location_reached_id"]').val(location_reached_id);
    const myModal = document.getElementById('myModal');
    const modal = new bootstrap.Modal(myModal);
    modal.show();
  });

  function load_events_of_user(user_id, redirect){
    let column_div = $('.select-user-div');
    $.ajax({
      url: '<?= base_url('organizer/get_events_of_locations_reached'); ?>',
      method: 'GET',
      data: {user_id},
      success: function(success) {
        if (typeof success.events !== undefined && success.events.length < 2) {
          (redirect) ? window.location = '/organizer/locations/reached?user_id='+ user_id: false;
        } else {
          let next_column_div = `<div class="col-md-3">
              <div class="field-wrapper">
                  <select class="form-select" id="event_select" name="event_select">
                      <option value="">Select event</option>`;
          success.events.forEach(function(event) {
            next_column_div += `<option value="${event.event_id}">${event.name}</option>`;
          });      
          next_column_div += `</select>
              </div>
          </div>`;
          $(column_div).after(next_column_div);

          const eventId = urlParams.get('event_id');
          if (eventId) {
            const selectElement = document.getElementById('event_select');
            const optionToSelect = selectElement.querySelector(`option[value="${eventId}"]`);
            
            if (optionToSelect) {
              optionToSelect.selected = true;
            }
          }

          $('#event_select').change(function(){
            let event_id = $('#event_select option:selected').val();
            let user_id = $('#user_select').val();

            window.location = '<?= base_url(); ?>' + 'organizer/locations/reached?user_id=' + user_id + '&event_id=' + event_id;
          })
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  }

  const urlParams = new URLSearchParams(window.location.search);
  const userId = urlParams.get('user_id');

  if (userId) {
    let redirect = false;
    load_events_of_user(userId, redirect);
  }



  $('#user_select').change(function(){
    $('#event_select').closest('.col-md-3').remove();
    var user_id = $(this).val();
    if (user_id != '') {
      // GET NUMBER OF EVENTS FOR WHICH USER HAS REACHED LOCATIONS
      load_events_of_user(user_id, true);
    }
  });
});
</script>