<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<style>
button:disabled {
  cursor: not-allowed;
  pointer-events: all !important;
}
      
      h1 {
        text-align: center;
        color: #555;
        margin-top: 30px;
        margin-bottom: 20px;
      }
      
      table {
        font-family: 'Montserrat', sans-serif;
        background-color: #f9f9f9;
        border-collapse: collapse;
        width: 100%;
        /* width: 80%; */
        margin: 0 auto;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-size: 16px;
      }

      tr td:first-child:not(:only-child) {
        font-size: 30px;
        font-family: "Arial Black", sans-serif;
        color: #4CAF50;
      }
      
      th, td {
        text-align: center;
        padding: 12px;
        border-bottom: 1px solid #ddd;
      }
      
      th {
        background-color: #4CAF50;
        color: white;
        position: sticky;
        top: 0;
      }
      
      td {
        background-color: #fff;
      }
      
      tr:nth-child(even) {
        background-color: #f2f2f2;
      }
      
      tr:hover td {
        background-color: #e2e2e2;
        transition: 0.2s;
      }
      
      @media screen and (max-width: 768px) {
        table {
          width: 100%;
        }
      }






</style>

<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll" id="vue-app">

  <!-- Content wrapper start -->
  <div class="content-wrapper">

    <!-- Row start -->
    <!-- <div class="row gutters">
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
        <div class="stats-tile">
          <div class="sale-icon">
            <i class="icon-shopping-bag1"></i>
          </div>
          <div class="sale-details">
            <h2><?= '' ?></h2>
            <p>Events</p>
          </div>
          <div class="sale-graph">
            <div id="sparklineLine1"></div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- Row end -->

    <!-- Row start -->
    <!-- Row end -->



    <div class="row gutters" v-if="orientation_result_display">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Event Orientation Results</div>
            <div class="graph-day-selection" role="group">
              <!-- <a href="<?= base_url('organizer/events/add'); ?>"><button type="button" class="btn active">Add Event</button></a> -->
            </div>
          </div>
          <div class="card-body">
            <div class="row mt-2 mb-2">
              <div class="col-md-3">
                <label for="">Select category:</label>
                <select class="form-control" id="select_category">
                  <!-- <option value="">SELECT EVENT</option> -->
                  <option >Selet</option>
                  <?php foreach ($categories as $category) { ?>
                    <option value="<?= $category->id ?>"><?= $category->name ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

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
  document.getElementById("select_category").onchange = function() {
    // Code to be executed when the value changes
    var selectedValue = this.value;
    if (selectedValue != '') {
      window.location.href = '<?= base_url(); ?>' + 'organizer/category_results/' + selectedValue;
    }
  };
});
</script>