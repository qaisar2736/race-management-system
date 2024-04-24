<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<style>
      button:disabled {
        cursor: not-allowed;
        pointer-events: all !important;
      }
          
      h1 {''
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

      td:first-child {
        font-size: 30px;
        font-family: "Arial Black", sans-serif;
        /* color: #ff24e0; */
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

  <!-- Loading wrapper start -->
  <div id="loading-wrapper">
    <div class="spinner-border"></div>
    Loading...
  </div>
  <!-- Loading wrapper end -->

  <div class="container pt-4 mt-4" id="vue-app">
    <div class="row mb-2">
      <div class="col-md-12">
        <div class="d-flex justify-content-center justify-content-sm-start">
          <button class="btn btn-outline-info me-2" v-on:click="showTrackResult">TRACK</button>
          <button class="btn btn-outline-secondary" v-on:click="showOrientationResult">ORIENTATION</button>
        </div>
      </div>
    </div>

    <!-- Row start -->
    <div class="row gutters" v-if="track_result_display">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Event Track Results</div>
            <div class="graph-day-selection" role="group">
              <!-- <a href="<?= base_url('organizer/events/add'); ?>"><button type="button" class="btn active">Add Event</button></a> -->
            </div>
          </div>
          <div class="card-body">
            <div class="row mb-4">
              <div class="table-responsive"> <!-- table-responsive -->
                <table>
                  <thead>
                    <tr>
                      <th>Pos.</th>
                      <th>Driver</th>
                      <th>Machine</th>
                      <th>Size of wheel</th>
                      <th>Track</th>
                      <th>Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in items" :key="item.id">
                      <td>{{ item.position }}</td>
                      <td>{{ capitalizeFirstLetter(item.name) + ' ' + capitalizeFirstLetter(item.surname) }}</td>
                      <td>{{ item.machine }}</td>
                      <td>{{ item.size_of_wheel }}</td>
                      <td>{{ item.track }}</td>
                      <td>{{ duration(item.start, item.end) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
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
            <div class="row mb-4">
              <div class="table-responsive"> <!-- table-responsive -->
                <table>
                  <thead>
                    <tr>
                      <th>Pos.</th>
                      <th>Driver</th>
                      <th>Machine</th>
                      <th>Size of wheel</th>
                      <!-- <th>Event</th> -->
                      <th>Points</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(item, index) in locations" :key="item.id">
                      <td>{{ item.position }}</td>
                      <td>{{ capitalizeFirstLetter(item.name) + ' ' + capitalizeFirstLetter(item.surname) }}</td>
                      <td>{{ item.machine }}</td>
                      <td>{{ item.size_of_wheel }}</td>
                      <!--<td>{{ item.event_name }}</td> -->
                      <td>{{ item.total_points }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
  document.addEventListener("DOMContentLoaded", () => {
    const app = Vue.createApp({
      methods: {
        showTrackResult: function() {
          this.track_result_display = true;
          this.orientation_result_display = false;

          clearInterval(this.my_interval);

          this.getAllEventsRecord();
          this.my_interval = setInterval(this.getAllEventsRecord, 1000);
        },
        showOrientationResult: function() {
          this.track_result_display = false;
          this.orientation_result_display = true;
          clearInterval(this.my_interval);
          this.getAllLocationsReached();
          this.my_interval = setInterval(this.getAllLocationsReached, 1000);
        },
        duration: function(start, end) {
          const duration = moment.duration(moment(end).diff(moment(start)));
          return moment.utc(duration.asMilliseconds()).format('H:mm:ss');
        },
        capitalizeFirstLetter: function(string) {
          return string.charAt(0).toUpperCase() + string.slice(1);
        },
        getAllEventsRecord: function() {
          let outerThis = this;
          $.ajax({
            url: '<?= base_url('organizer/get_event_track_results') ?>',
            method: 'GET',
            data: {},
            success: function(success) {
              if (success.items !== undefined) {
                outerThis.items = success.items;
                outerThis.items = success.items.sort((a, b) => {
                  const durationA = moment.duration(moment(a.end).diff(moment(a.start)));
                  const durationB = moment.duration(moment(b.end).diff(moment(b.start)));
                  return durationA.asMilliseconds() - durationB.asMilliseconds();
                });

                let position = 1;
                let previousDuration = null;
                let previousPosition = null;

                for (let i = 0; i < outerThis.items.length; i++) {
                  const duration = moment.duration(moment(outerThis.items[i].end).diff(moment(outerThis.items[i].start)));

                  if (duration.asMilliseconds() !== previousDuration) {
                    position = previousPosition !== null ? previousPosition + 1 : 1;
                    previousDuration = duration.asMilliseconds();
                    previousPosition = position;
                  }

                  outerThis.items[i].position = position;
                }

              }
            },
            error: function(error) {
              console.log(error);
            }
          });
        },
        getAllLocationsReached: function() {
          let outerThis = this;
          $.ajax({
            url: '<?= base_url('organizer/get_locations_reached') ?>',
            method: 'GET',
            data: {},
            success: function(success) {
              if (success.locations !== undefined) {
                // let sortedLocations = success.locations.sort((a, b) => parseInt(a.total_points) - parseInt(b.total_points));

                // // Add position property to each object
                // sortedLocations.forEach((location, index) => {
                //   location.position = index + 1;
                // });
                // Sort the array by total_points in ascending order
                // Sort the array by total_points in descending order
                // success.locations.sort((a, b) => b.total_points - a.total_points);

                // // Add the position property to each object
                // success.locations.forEach((item, index) => item.position = index + 1);

                // Sort the array by total_points in descending order
                success.locations.sort((a, b) => b.total_points - a.total_points);

                // Assign the position number to each object
                let position = 1;
                success.locations.forEach((obj, index) => {
                  if (index > 0 && obj.total_points < success.locations[index - 1].total_points) {
                    position++;
                  }
                  obj.position = position;
                });

                outerThis.locations = success.locations;
              }
            },
            error: function(error) {
              console.log(error);
            }
          });
        }
      },
      data() {
        return {
          items: [],
          locations: [],
          track_result_display: true,
          orientation_result_display: false,
          my_interval: null
        }
      },
      mounted() {
        this.getAllEventsRecord();
        this.my_interval = setInterval(this.getAllEventsRecord, 1000);
      }
    });
    
    app.mount('#vue-app');

    // Loading
    $(function() {
      $("#loading-wrapper").fadeOut(1000);
    });
  });
  </script>
  <?php if (isset($_SESSION['account_type']) && $_SESSION['account_type'] == 'participant') { require "live_location.php"; } ?>