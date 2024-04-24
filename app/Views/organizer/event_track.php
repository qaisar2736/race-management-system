<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<style>
	select {
		outline: none;
	}
button:disabled {
  cursor: not-allowed;
  pointer-events: all !important;
}
.autocomplete-items {
	position: absolute;
	border: 1px solid #d4d4d4;
	border-bottom: none;
	border-top: none;
	z-index: 99;
	top: 100%;
	left: 0;
	right: 0;
}

.autocomplete {
	position: relative;
	display: inline-block;
}

tr {
	font-size: 16px;
}
table,input[name="filter"] {
	font-family: 'Montserrat', sans-serif;
}
input[name="filter"] {
	font-size: 16px;
}
.vertically-center {
	display: flex;
  align-items: center;
}
/* For small screens */
/* Two columns on small screens */
/* @media only screen and (max-width: 600px) {
	tr {
		border: 3px solid #1273eb;
		border-radius: 8px;
		font-size: 16px;
	}
  td, th {
    width: 50%;
    float: left;
    box-sizing: border-box;
  }
  td:nth-child(2n+1) {
    clear: left;
  }
} */
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
						<!-- Row end -->

						<!-- <div class="row" v-if="rows.length > 0">
							<div class="col">
								<button v-if="rows.length > 0" :disabled="start != null?'disabled':false" class="btn btn-success btn-block w-100" v-on:click="handleStartForAll($event)">Start</button>
							</div>
							<div class="col">
								<button :disabled="(end != null || start == null) ? 'disabled': false" class="btn btn-danger btn-block w-100" v-on:click="handleEndForAll($event)">End</button>
							</div>
						</div> -->

						<!-- Row start -->
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="card">
									<div class="card-header">
									<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
										<a href="<?= $_SERVER['HTTP_REFERER']; ?>"><button class="btn btn-info btn-sm">Back</button></a>
									<?php } ?>
										<?php if (isset($category)) { ?>
										<div class="card-title"><?= $category->name; ?></div>
										<div class="graph-day-selection" role="group">
											<a href="<?= base_url('organizer/category_results/'.$category->id); ?>"><button type="button" class="btn active">View Result</button></a>
										</div>
										<?php } ?>
									</div>
									<div class="card-body">
									<div class="row mb-4">
										<div class="col-md-5">
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
											<h3>Select user</h3>
											<form action="<?= base_url('organizer/find_user'); ?>" method="POST" name="track_event_form"  @submit.prevent="handleSubmitAddEvent">
												<!-- <div class="form-group mb-2 autocomplete"> -->
													<input type="hidden" name="event_id" value="<?= $event_id ?>">
													<!-- <input type="number" name="user_id" class="form-control" placeholder="User ID"> -->
													
												<!-- </div> -->
												<div class="field-wrapper">
													<select name="user_id" class="select-single js-states" title="Select Product Category" data-live-search="true">
														<?php foreach ($users as $u) { ?>
															<option 
																data-event-id="<?= $event_id ?>" 
																data-username="<?= $u->name.' '.$u->surname ?>" 
																value="<?= $u->id ?>" selected="false">

																<?= $u->name . ' ' . $u->surname . ' - ' . $u->id ?>

															</option>
														<?php } ?>
													</select>
													<div class="field-placeholder">Select User</div>
												</div>

												<div class="field-wrapper">
													<select name="track" id="track" class="select-single">
														<option value="">SELECT TRACK</option>
														<?php 
														foreach($tracks as $track) {
															echo "<option data-id='$track->id' value='$track->name'>$track->name</option>";
														}
														
														?>
													</select>
												</div>

												<!-- <div class="field-wrapper">
													<input type="text" name="track" class="form-control" placeholder="Track" v-model="track">
													<div class="field-placeholder">Track</div>
												</div> -->

												<div class="form-group">
													<input type="submit" name="submit" value="submit" class="btn btn-primary btn-sm mt-2">
												</div>
											</form>
										</div>
									</div>


										
												<div class="table-responsive">
												
												<table-component :rows="rows" :track="track" 
												:handle-start="handleStart" 
												:handle-end="handleEnd" 
												:handle-remove="handleRemove"
												:handle-edit="handleEdit" ></table-component>
													<!-- <table class="table products-table user-details">
														<thead>
															<tr>
																<th>User</th>
																<th>Track</th>
																<th>Start</th>
																<th>Start Time</th>
																<th>End</th>
																<th>End time</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table> -->
												</div>



<!-- <tr>
		<td>asdf</td>
		<td>asdf</td>
		<td>
			<button class="btn btn-success btn-sm btn-start" >START</button>
		</td>
		<td id="start_time"></td>
		<td>
			<button class="btn btn-danger btn-sm btn-end">END</button>
		</td>
		<td id="end_time"></td>
</tr> -->
										
									</div>
								</div>
							</div>
						</div>
						<!-- Row end -->

						<div class="row gutters" v-if="false">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">All past tracks:</div>
									</div>
									<div class="card-body">
									<!-- <input type="text" v-model="filterKeyword" placeholder="Enter a keyword" @input="applyFilter" /> -->

										<table class="table products-table user-details">
											<thead>
												<tr>
													<th>User</th>
													<th>Track</th>
													<!-- <th>Start</th> -->
													<th>Start Time</th>
													<!-- <th>End</th> -->
													<th>End time</th>
													<th>Duration</th>
												</tr>
											</thead>
											<tbody>
												<tr v-for="track in filterTracks(paginatedTracks)" :key="track.id">
													<td>{{ track.full_name }}</td>
													<td>{{ track.track }}</td>
													<td>{{ moment(track.start).format('DD MMM YYYY hh:mm A') }}</td>
													<td>{{ moment(track.end).format('DD MMM YYYY hh:mm A') }}</td>
													<td>{{ calculateDuration(track.start, track.end) }}</td>
												</tr>
											</tbody>
										</table>
										<div class="pagination">
											<button class="btn btn-info btn-sm mr-2" @click="previousPage">Previous</button>
											<!--<span>{{ currentPage }}</span> -->
											<button class="btn btn-warning btn-sm" @click="nextPage">Next</button>
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

const TableRowComponent = {
	props: ['track','row', 'handleStart', 'handleEnd', 'handleRemove', 'handleEdit'],
	template: `
		<tr>
			<td>{{ row.username }}</td>
			<td><div style="word-wrap: break-word;">{{ row.track }}</div></td>


			<td>
				<button class="btn btn-success btn-sm btn-start" 
				:disabled="row.start != null?'disabled':false"  
				@click="handleStart(row, $event)">START</button>
			</td>


			<td>{{ row.start_formatted }}</td>


			<td>
				<button class="btn btn-danger btn-sm btn-end" 
				:disabled="(!!row.start && !!row.end || row.start == null) ? 'disabled': false"
				@click="handleEnd(row, $event)">END</button>
			</td>

			<td>{{ row.end_formatted }}</td>

			<td>
				<a v-if="row.start != null" class="text-warning" href="javascript:void(0)" @click="handleEdit(row, $event)">Edit</a>
				<span v-else>-</span>
			</td>

			<td>
				<a class="text-danger" href="javascript:void(0)" @click="handleRemove(row, $event)">Remove</a>
			</td>



			<!-- <td>{{ row.end }}</td> -->
		</tr>
	`
};

const TableComponent = {
	props: ['rows', 'handleStart', 'handleEnd', 'handleRemove', 'handleEdit', 'track'],
	components: {
		'table-row': TableRowComponent
	},
  data() {
    return {
      filterValue: '' // Initialize the filter value
    };
  },
  computed: {
    filteredRows() {
      // Filter the rows based on the filterValue
      return this.rows.filter(row => {
        // Perform the filtering logic here
        // Here's an example assuming you want to filter based on the username
        return row.username.toLowerCase().includes(this.filterValue.toLowerCase())
								|| row.track.toLowerCase().includes(this.filterValue.toLowerCase());
      });
    }
  },
	template: `
		<div class="card-title d-flex">
			<div class="vertically-center">Tracks:</div>
			<div class="form-group col-8 col-sm-6 col-md-4 col-lg-2 ms-auto">
				<input type="text" name="filter" v-model="filterValue"  placeholder="Filter" class="form-control">
			</div>
		</div>
		<table class="table products-table user-details">
			<thead>
				<tr>
					<th>User</th>
					<th>Track</th>
					<th>Start</th>
					<th>Start Time</th>
					<th>End</th>
					<th>End time</th>
					<th>Edit</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>
				<template v-if="filteredRows.length > 0">
					<table-row v-for="row in filteredRows" :track="track" :key="row.id" :row="row" 
					:handleStart="handleStart" 
					:handleEnd="handleEnd" 
					:handleRemove="handleRemove"
					:handleEdit="handleEdit" ></table-row>
				</template>
				<template v-else>
					<tr class="text-center">
						<td colspan="8">No track data for this category.</td>
					</tr>
				</template>
			</tbody>
		</table>
	`
};

	const app = Vue.createApp({
	components: {
			'table-component': TableComponent
		},
  data() {
    return {
			event_id: null,
      rows: [

			],
			track: '',
			start: null,
			end: null,
			all_past_tracks: [],
			currentPage: 1, // Current page number
      itemsPerPage: 100, // Number of items per page
			filterKeyword: '',
      filteredTracks: [],
    }
  },
	computed: {
    reversedItems() {
      return this.items.reverse();
    },
		paginatedTracks() {
			const startIndex = (this.currentPage - 1) * this.itemsPerPage;
			const endIndex = startIndex + this.itemsPerPage;
			return this.filteredTracks.slice(startIndex, endIndex);
		},
		totalPages() {
			return Math.ceil(this.filteredTracks.length / this.itemsPerPage);
		}
  },
  methods: {
		moment,/* I WANT TO USE MOMENT IN HTML */
		handleStartForAll($event) {
			$($event.target).prop('disabled', true);
			let user_ids = this.rows.map(user => user.user_id);
			let event_id = this.event_id;
			let track = this.track;
			let outerThis = this;
	
			user_ids.forEach(function(id) {
				let user = outerThis.rows.find(row => row.user_id == id);
				event_id = user.event_id;

				$.ajax({
					url: '<?= base_url('organizer/start_all_event_tracks'); ?>',
					method: 'POST',
					data: { user_id: id, event_id },
					success: function(success) {
						if (success.start !== undefined) {
							outerThis.start = success.start;
							outerThis.rows = outerThis.rows.map(obj => {
								// if (obj.user_id == row.user_id) {
									// Update the property of object with id 2
									return { ...obj, start: moment(success.start).format('h:mm:ss a') };
								// }
								// Return unchanged object for other elements
								return obj;
								// return { ...user, start: moment(success.start).format('h:mm:ss a') };
							});
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
			});

			if (user_ids.length > 0) {
				// $.ajax({
				// 	url: '<?= base_url('organizer/start_all_event_tracks'); ?>',
				// 	method: 'POST',
				// 	data: { user_ids, event_id, track },
				// 	success: function(success) {
				// 		if (success.start !== undefined) {
				// 			outerThis.start = success.start;
				// 			outerThis.rows = outerThis.rows.map(user => {
				// 				return { ...user, start: moment(success.start).format('h:mm:ss a') };
				// 			});
				// 		}
				// 	},
				// 	error: function(error) {
				// 		console.log(error);
				// 	}
				// });
			}
		},
		handleEndForAll($event) {
			$($event.target).prop('disabled', true);
			let user_ids = this.rows.map(user => user.user_id);
			let event_id = this.event_id;
			let track = this.track;
			let outerThis = this;
			
			if (user_ids.length > 0) {
				$.ajax({
					url: '<?= base_url('organizer/end_all_event_tracks'); ?>',
					method: 'POST',
					data: { user_ids, event_id, track },
					success: function(success) {
						if (success.end !== undefined) {
							outerThis.end = success.end;
							outerThis.rows = outerThis.rows.map(user => {
								return { ...user, end: moment(success.end).format('h:mm:ss a') };
							});
						}
					},
					error: function(error) {
						console.log(error);
					}
				});
			}
		},
		handleRemove(clickedRow, $event) {
			let confirm = window.confirm('Are you sure?');
			if (confirm) {
				this.rows.forEach(function(row, index) {
					if (row.user_id == clickedRow.user_id && row.track_id == clickedRow.track_id) {
						this.rows.splice(index, 1);
					}
				}, this);
				
				// if row has id it means it is already saved in the database so delete it from there also
				if (clickedRow.hasOwnProperty('id')) {
					$.ajax({
						url: '<?= base_url('organizer/delete_event_track') ?>',
						method: 'POST',
						data: {id: clickedRow.id},
						success: function(success) {

						},
						error: function(error) {
							console.log(error);
						}
					})
				}
			}
		},
		handleEdit(row, $event) {
			let id = row.id;
			$('#exampleModal').remove();
			let myModal = $(`<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Update Track Details</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form method="POST" id="update_track_form">
								<div class="form-group">
									<label>Start</label>
									<input type="datetime-local" class="form-control" value="${moment(row.start).format('YYYY-MM-DDTHH:mm:ss')}" name="start"  step="1">
								</div>
								<div class="form-group">
									<label>End</label>
									<input type="datetime-local" class="form-control" value="${moment(row.end).format('YYYY-MM-DDTHH:mm:ss')}" name="end"  step="1">
								</div>
								<div class="form-group d-flex justify-content-between">
									<input type="submit" name="submit" value="Update" class="btn btn-primary btn-sm mt-2">
									<input type="reset" name="reset" value="Reset" class="btn btn-warning btn-sm mt-2">
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
							<!-- <button type="button" class="btn btn-primary">Save Changes</button> -->
						</div>
					</div>
				</div>
			</div>`);
			let outerThis = this;
			myModal.find('form').submit(function(e) {$('.alert').remove();
				e.preventDefault();
				let form = $(this);let start = form.find('input[name="start"]').val();let end = form.find('input[name="end"]').val();
				if (start != '') {
					$.ajax({
						url: '<?= base_url('organizer/update_event_track') ?>',
						method: 'POST',
						data: {start: start, end: end, id: id},
						success: function(success) {
							if (typeof success.updated !== undefined) {
								const objectToUpdate = outerThis.rows.find(obj => obj.id === id);

								if (objectToUpdate) {
									// Update the properties of the object
									objectToUpdate.start = start;
									
									objectToUpdate.start_formatted = moment(start).format('h:mm:ss a');

										objectToUpdate.end = end != '' ? end : null;
										objectToUpdate.end_formatted = end != '' ? moment(end).format('h:mm:ss a'): null;
								}
								form.before(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Event data updated successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
							}
						},
						error: function(error) {
							console.log(error);
						}
					});
				}
 			})
			$('body').append(myModal);
			$('#update_track_form').on('reset', function(e) {e.preventDefault();$(this).find('input[type="datetime-local"]').val('');});

			let modal = new window.bootstrap.Modal(document.querySelector('#exampleModal'));
			modal.show();
		},
		handleStart(row,$event) {
			$($event.target).prop('disabled', true);

			let temp = this.rows.filter((item) => item.user_id == row.user_id);
			let outerThis = this;

			$.ajax({
				url: '<?= base_url('organizer/start_event_track') ?>',
				method: 'POST',
				data: {
					user_id: row.user_id,
					event_id: row.event_id,
					track: row.track
				},
				success: function(success) {
					if (typeof success.race_started != 'undefined') {
						var start_time = success.start_time;
						// $('#start_time').text(start_time);
						let updatedArr = outerThis.rows.map(obj => {
							if (obj.user_id == row.user_id && obj.track_id == row.track_id) {
								// Update the property of object with id 2
								return { ...obj, start: start_time, start_formatted: moment(start_time).format('h:mm:ss a'), id: success.inserted_id };
							}
							// Return unchanged object for other elements
							return obj;
						});
						outerThis.rows = updatedArr;
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
		},
		handleEnd(row, $event) {
			$($event.target).prop('disabled', true);

			let temp = this.rows.filter((item) => item.user_id == row.user_id);
			let outerThis = this;

			$.ajax({
				url: '<?= base_url('organizer/stop_event_track') ?>',
				method: 'POST',
				data: {
					user_id: row.user_id,
					event_id: row.event_id,
					track: row.track
				},
				success: function(success) {
					if (success.end_time !== undefined) {
						var end_time = success.end_time;
						// $('#start_time').text(start_time);
						let updatedArr = outerThis.rows.map(obj => {
							if (obj.user_id == row.user_id && obj.track_id == row.track_id) {
								// Update the property of object with id 2
								return { ...obj, end: end_time, end_formatted: moment(end_time).format('h:mm:ss a') };
							}
							// Return unchanged object for other elements
							return obj;
						});
						outerThis.rows = updatedArr;
					}
				},
				error: function(error) {
					console.log(error);
				}
			});
		},
    handleSubmitAddEvent(event) {
      $('.alert').remove();

      let form = $(event.target);
      let user_id = ($('.select-single').val()).trim();
			// console.log(user_id);throw Error('hell');
      let track = form.find('select[name="track"]').val().trim();
			let event_id = form.find('select[name="track"] option:selected').attr('data-id');
      let username = $('.select-single option:selected').attr('data-username');
      let track_id = $('.select-single:eq(1) option:selected').attr('data-id');

      if (user_id == '') {
        form.before(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error! Select user.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
      } else if (track == '') {
        form.before(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error! Select track.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
      } else if (this.rows.some(user => user.user_id === user_id && user.track == track)) {
				form.before(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Error! User already added.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`);
			} else {
        // form[0].reset();
				this.event_id = event_id;
				this.track = track;
        this.rows.unshift({
					track,
					track_id,
					event_id,
          user_id,
          username,
					start: null,
					end: null
        })
      }
    },
    capitalizeFirstLetter(string) {
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
		calculateDuration(start, end) {
			const startDate = moment(start);
			const endDate = moment(end);

			const duration = moment.duration(endDate.diff(startDate));
			const durationInHours = duration.hours();
			const durationInMinutes = duration.minutes();
			const durationInSeconds = duration.seconds();

			return `${durationInHours}h ${durationInMinutes}m ${durationInSeconds}s`;
		},
		previousPage() {
			if (this.currentPage > 1) {
				this.currentPage--;
			}
		},
		nextPage() {
			if (this.currentPage < this.totalPages) {
				this.currentPage++;
			}
		},
		filterTracks(tracks) {
			return tracks;
		},
		getUniqueTrackNames(allTracks) {
			const trackNamesSet = new Set(allTracks.map(track => track.track));
			const uniqueTrackNames = Array.from(trackNamesSet);
			return uniqueTrackNames;
		}
  },
	created() {
    this.filteredTracks = this.all_past_tracks;
  },
  mounted() {
    $(".select-single").select2({
      placeholder: {
        id: "",
        text: "Select an option",
      },
    });
		let outerThis = this;
		/* GET TODAY TRACKS */
		$.ajax({
			url: '<?= base_url('organizer/get_all_tracks') ?>',
			method: 'POST',
			data: {},
			success: function(success) {
				if (success.rows !== undefined) {
					outerThis.all_past_tracks = outerThis.filteredTracks = success.all_past_tracks;
					const uniqueTrackNames = outerThis.getUniqueTrackNames(outerThis.all_past_tracks);

					const newArray = success.rows.map(row => {
						const { name, surname, start, end,  ...rest } = row;
						return {
							...rest,
							start,
							end,
							username: `${outerThis.capitalizeFirstLetter(name)} ${outerThis.capitalizeFirstLetter(surname)}`,
							start_formatted: start ? moment(start).format('h:mm:ss a'): null,
							end_formatted: end ? moment(end).format('h:mm:ss a') : null
						};
					});
					outerThis.rows = newArray;
				}
			},
			error: function(error) {
				console.log(error);
			}
		});
  }
})



app.mount('#vue-app');


	$('form[name="track_event_form"]').submit(function(e){
		// e.preventDefault();
		// $('.alert').remove();
		// var form = $(this);
		
		// var current_url = '<?= base_url($_SERVER['REQUEST_URI']) ?>';
		// var user_id = ($('select[name="user_id"]').val()).trim();
		// var track = ($('input[name="track"]').val()).trim();
		// track =  track.replace(/\s/g, '+');

		// if (user_id == '' || track == '') {
		// 	$(form).before($(`<div class="alert alert-danger alert-dismissible fade show" role="alert">
		// 									Both fields are required.
		// 									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		// 								</div>`));
		// } else {
		// 	current_url = current_url.replace('track/', '');
		// 	var new_url = current_url + ('/user/' + user_id + '/track/' + track);
		// 	window.location.replace(new_url);
		// }
	});



  // $('.btn-start').click(function() {
	// 	$(this).prop('disabled', true);

	// 	$.ajax({
	// 		url: '<?= base_url('organizer/start_event_track') ?>',
	// 		method: 'POST',
	// 		data: {
	// 			user_id: '',
	// 			event_id: '',
	// 			track: ''
	// 		},
	// 		success: function(success) {
	// 			if (typeof success.race_started != 'undefined') {
	// 				var start_time = success.start_time;
	// 				$('#start_time').text(start_time);
	// 			}
	// 		},
	// 		error: function(error) {
	// 			console.log(error);
	// 		}
	// 	});
	// });

	// $('.btn-end').click(function(){
	// 	$(this).prop('disabled', true);
		
	// 	$.ajax({
	// 		url: '<?= base_url('organizer/stop_event_track') ?>',
	// 		method: 'POST',
	// 		data: {
	// 			user_id: '',
	// 			event_id: '',
	// 			track: ''
	// 		},
	// 		success: function(success) {
	// 			if (typeof success.end_time != 'undefined') {
	// 				var end_time = success.end_time;
	// 				$('#end_time').text(end_time);
	// 			}
	// 		},
	// 		error: function(error) {
	// 			console.log(error);
	// 		}
	// 	});
	// });
});
</script>