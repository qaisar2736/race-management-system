<div class="container-fluid">
<?php if (session()->has('error')) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <?php echo session()->getFlashdata('error'); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php } ?>
          <?php 
        //   if (isset($_SERVER['HTTP_REFERER'])) {
        //     $previousPage = $_SERVER['HTTP_REFERER'];
        //     echo '<a href="' . $previousPage . '">Go Back</a>';
        // }
        ?>
  <!-- <div class="card">
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
                $participants = [];
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
  </div> -->

  <?php if (isset($tracks)) { ?>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <h4 class="">User tracks:</h4>

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
                <th>Username</th>
                <th>Track</th>
                <th>Start</th>
                <th>End</th>
                <td>Time</td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tracks as $track) { ?>
              <tr>
                <td><?= $track->username ?></td>
                <td><?= $track->track ?></td>
                <td><?= $track->start ?></td>
                <td><?= $track->end ?></td>
                <?php 
                $startDateTime = new DateTime($track->start);
                $endDateTime = new DateTime($track->end);
                
                $interval = $startDateTime->diff($endDateTime);
                
                $hours = $interval->format('%h');
                $minutes = $interval->format('%i');
                $seconds = $interval->format('%s');
                $timeDifference = '';

                if ($hours > 0) {
                    $timeDifference .= $hours . ' hour ';
                }
                
                if ($minutes > 0) {
                    $timeDifference .= $minutes . ' minutes ';
                }
                
                if ($seconds > 0) {
                    $timeDifference .= $seconds . ' seconds';
                }

                ?>
                <td><?= $timeDifference ?></td>
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

});
</script>