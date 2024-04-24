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

    <!-- Row start -->
    <div class="row gutters">
      <div class="col-md-12 col-12 col-sm-12">
        <button class="btn btn-outline-info m-2" v-on:click="showTrackResult"  :class="{ active: track_result_display }">TRACK</button>
        <button class="btn btn-outline-success orientation-result-btn" v-on:click="showOrientationResult"  :class="{ active: orientation_result_display }">ORIENTATION</button>
      </div>
    </div>
    <!-- Row end -->

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
                      <td><a :href="base_url + 'organizer/tracks?user_id=' + item.user_id">{{ capitalizeFirstLetter(item.name) + ' ' + capitalizeFirstLetter(item.surname) }}</a></td>
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
            <div class="row mt-2 mb-2">
              <div class="col-md-3">
                <label for="">Select event:</label>
                <select class="form-control" name="select_orientation_event" id="select_orientation_event" v-model="selected_orientation_event" @change="handleSelectChange($event)">
                  <!-- <option value="">SELECT EVENT</option> -->
                  <option v-for="event in all_orientation_events" :key="event.event_id" :value="event.event_id">{{event.event_name}}</option>
                </select>
              </div>
            </div>
            <div class="row mb-4">
              <div class="table-responsive"> <!-- table-responsive -->
                <table class="">
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
                  <tr v-if="locations.length === 0">
                    <td colspan="5" style="">No Results for this event</td>
                  </tr>
                    <tr v-else v-for="(item, index) in locations" :key="item.id">
                      <td>{{ item.position }}</td>
                      <td><a :href="base_url + 'organizer/locations/reached?user_id=' + item.user_id">{{ capitalizeFirstLetter(item.name) + ' ' + capitalizeFirstLetter(item.surname) }}</a></td>
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

    <!-- Row start -->
    <!-- Row end -->

  </div>
  <!-- Content wrapper end -->
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
        if (this.selected_orientation_event) {
          clearInterval(this.my_interval);
          this.getAllLocationsReached();
          this.my_interval = setInterval(this.getAllLocationsReached, 1000);
        }
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
        let event_id = this.selected_orientation_event;
        $.ajax({
          url: '<?= base_url('organizer/get_locations_reached') ?>',
          method: 'GET',
          data: {event_id},
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
              // success.locations.sort((a, b) => b.total_points - a.total_points);

              // // Assign the position number to each object
              // let position = 1;
              // success.locations.forEach((obj, index) => {
              //   if (index > 0 && obj.total_points < success.locations[index - 1].total_points) {
              //     position++;
              //   }
              //   obj.position = position;
              // });

              // outerThis.locations = success.locations;

              success.locations.sort((a, b) => b.total_points - a.total_points);

              // Assign the position number to each object
              let position = 1;
              let prevPoints = null;
              success.locations.forEach((obj, index) => {
                if (obj.total_points !== prevPoints) {
                  position = index + 1;
                }
                obj.position = position;
                prevPoints = obj.total_points;
              });

              outerThis.locations = success.locations;
            }
          },
          error: function(error) {
            console.log(error);
          }
        });
      },
      handleSelectChange: function(event){
        let event_id = event.target.value;
        if (event_id != '') {
          this.selected_orientation_event = event_id;
          clearInterval(this.my_interval);
          this.getAllLocationsReached();
          this.my_interval = setInterval(this.getAllLocationsReached, 1000);
        }
      }
    },
    data() {
      return {
        base_url: '<?= base_url(); ?>',
        items: [],
        locations: [],
        track_result_display: true,
        orientation_result_display: false,
        my_interval: null,
        all_orientation_events: null,
        selected_orientation_event: null
      }
    },
    mounted() {
      this.getAllEventsRecord();
      this.my_interval = setInterval(this.getAllEventsRecord, 1000);
      let outerThis = this;

      

      $.ajax({
        url: '<?= base_url('organizer/get_all_orientation_events'); ?>',
        method: 'GET',
        data: {order_by: 'e.date DESC', limit: 10},
        success: function(success) {
          if (success.events !== undefined) {
            outerThis.all_orientation_events = success.events;
            let {all_orientation_events, selected_orientation_event} = outerThis;
            console.log(all_orientation_events[0]);
            outerThis.selected_orientation_event = outerThis.all_orientation_events.length > 0 ? outerThis.all_orientation_events[0].event_id : null;

            // CHECK WHICH RESULT TO SHOW
            const url = new URL(window.location.href);

            // Check if the "orientation" variable exists in the URL
            if (url.searchParams.has('orientation')) {
              document.querySelector('.orientation-result-btn').click();
            }
          }
        },
        error: function(error) {
          console.log(error);
        }
      });
    }
  });
  
  app.mount('#vue-app');
});
</script>