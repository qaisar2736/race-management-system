<style>
.card {
  min-height: 550px;
}
</style>
<div class="container pt-4 mt-4">
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
  <div class="row">
    <div class="col-md-3">
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
    </div>
  </div>
    <!-- Card start -->
    <div class="card">
      <div class="card-body">

        <div class="custom-tabs-container">
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" id="first-tab" data-bs-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">Profile</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="second-tab" data-bs-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">Password</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="third-tab" data-bs-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">Email</a>
            </li>
            <li class="nav-item" role="presentation">
              <a class="nav-link" id="machine-tab" data-bs-toggle="tab" href="#machine" role="tab" aria-controls="machine" aria-selected="false">Machine</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade active show" id="first" role="tabpanel">

              <!-- BASIC PROFILE UPDATE FORM -->
              <div class="row">
                <div class="col-md-3">
                  <form action="/user/update_profile" method="POST">
                    <div class="field-wrapper">
                      <input type="text" class="form-control" name="name" value="<?= $user['name'] ?>">
                      <div class="field-placeholder">Name</div>
                    </div>

                    <div class="field-wrapper">
                      <input type="text" class="form-control" name="surname" value="<?= $user['surname'] ?>">
                      <div class="field-placeholder">Surname</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="second" role="tabpanel">
              
              <!-- PASSWORD UPDATE FORM  -->
              <div class="row">
                <div class="col-md-3">
                  <form action="/user/update_password" method="POST">
                    <div class="field-wrapper">
                      <input type="password" class="form-control" name="old_password">
                      <div class="field-placeholder">Old password</div>
                    </div>

                    <div class="field-wrapper">
                      <input type="password" class="form-control" name="new_password">
                      <div class="field-placeholder">New password</div>
                    </div>

                    <div class="field-wrapper">
                      <input type="password" class="form-control" name="confirm_password">
                      <div class="field-placeholder">Confirm password</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="third" role="tabpanel">
              
              <!-- UPDATE EMAIL FORM  -->
              <div class="row">
                <div class="col-md-3">
                  <form action="/user/update_email" method="POST" name="email_update_form">
                    <div class="field-wrapper">
                      <input type="text" class="form-control" name="email" value="<?= $user['email'] ?>">
                      <div class="field-placeholder">Email</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                </div>
              </div>

              

            </div>
            <div class="tab-pane fade" id="machine" role="tabpanel">
              
              <!-- UPDATE MACHINE INFORMATION FORM  -->
              <div class="row">
                <div class="col-md-3">
                  <form action="/user/update_machine" method="POST" name="machine_update_form">
                    <div class="field-wrapper">
                      <input type="text" class="form-control" name="machine" value="<?= $user['machine'] ?>">
                      <div class="field-placeholder">Name of machine</div>
                    </div>

                    <div class="field-wrapper">
                      <input type="text" class="form-control" name="size_of_wheel" value="<?= $user['size_of_wheel'] ?>">
                      <div class="field-placeholder">Size of wheel</div>
                    </div>

                    <div class="field-wrapper">
                      <div class="checkbox-container">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="have_winch" id="yes" value="yes" <?= ($user['have_winch'] == 1) ? 'checked': ''; ?>>
                          <label class="form-check-label" for="yes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="have_winch" id="no" value="no" <?= ($user['have_winch'] == 0) ? 'checked': ''; ?>>
                          <label class="form-check-label" for="no">No</label>
                        </div>
                        <div class="field-placeholder">Do you have winch?</div>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
                </div>
              </div>

            </div>
            <div class="tab-pane fade" id="fifth" role="tabpanel">
              
              <p class="text-muter">User experience (abbreviated as UX) is how a person feels when interfacing with a system. The system could be a website, a web application or desktop software and, in modern contexts, is generally denoted by some form of human-computer interaction.</p>
              
            </div>
          </div>
        </div>

      </div>
    </div>
    <!-- Card end -->

  </div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  var validateEmail = (email) => {
    return String(email)
      .toLowerCase()
      .match(
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      );
  };
  $('form[name="email_update_form"').submit(function(e) {
    $('.alert').remove();
    var email = ($('input[name="email"]').val()).trim();
    
    if (email == '') {
      e.preventDefault();
      var error_alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Enter email.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`);
      $("#alert-container").append(error_alert);
    } else if (!validateEmail(email)) {
      e.preventDefault();
      var error_alert = $(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
          Enter proper email.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`);
      $("#alert-container").append(error_alert);
    } else {
      e.preventDefault();
      $.ajax({
        url: '<?= base_url('user/update_email'); ?>',
        method: 'POST',
        data: { email: email },
        success: function(data) {
          if (data['email_sent'] != undefined) {
            var error_alert = $(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                Check email for confirmation.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>`);
            $("#alert-container").append(error_alert);
          }
        },
        error: function(error) {
          console.log(error)
        }
      });
    }
  });
});
</script>
</div>
</div>
<?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'participant') { require "live_location.php"; } ?>