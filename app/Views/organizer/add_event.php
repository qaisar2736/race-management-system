<style>
.without_ampm::-webkit-datetime-edit-ampm-field {
   display: none;
 }
 input[type=time]::-webkit-clear-button {
   -webkit-appearance: none;
   -moz-appearance: none;
   -o-appearance: none;
   -ms-appearance:none;
   appearance: none;
   margin: -10px; 
 }
</style>
<div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <h1>Add Event</h1>

      <div class="row">
        <div class="col-md-4">
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
          <form action="/organizer/events/add" method="POST">
            <div class="field-wrapper">
              <input class="form-control" type="text" name="name">
              <div class="field-placeholder">Event name <span class="text-danger">*</span></div>
            </div>

            <div class="field-wrapper">
              <select class="form-select" id="formSelect" name="type">
                <option value="track" selected>Track event</option>
                <option value="orentance">Orentance event</option>
              </select>
              <div class="field-placeholder">Event type <span class="text-danger">*</span></div>
            </div>

            <div class="field-wrapper">
              <input class="form-control" type="number" name="hours">
              <div class="field-placeholder">Event hours <span class="text-danger">*</span></div>
            </div>

            <div class="field-wrapper">
              <input class="form-control" type="number" name="minutes">
              <div class="field-placeholder">Event minutes <span class="text-danger">*</span></div>
            </div>

            <div class="field-wrapper">
              <input class="form-control" type="datetime-local" name="date">
              <div class="field-placeholder">Event start date time <span class="text-danger">*</span></div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>