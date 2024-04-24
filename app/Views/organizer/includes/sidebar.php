<nav class="sidebar-wrapper">
<div class="sidebar-tabs">
	<div class="tab-content">
		<div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
			<div class="tab-pane-header">
				<?php if ($_SESSION['account_type'] == 'admin') { ?>
				<a class="text-primary dashboard-link" href="<?= base_url('organizer/races') ?>">Races</a>
				<?php } else if ($_SESSION['account_type'] == 'organizer') { ?>
					<a class="text-primary dashboard-link" href="<?= base_url('organizer/events/track') ?>">Events</a>
				<?php } ?>
			</div>
			<div class="sidebarMenuScroll">
				<div class="sidebar-menu">
						<?php 
						 if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
									$url = "https://";   
							else  
									$url = "http://";   
							// Append the host(domain name, ip) to the URL.   
							$url.= $_SERVER['HTTP_HOST'];   
							
							// Append the requested resource location to the URL   
							$url.= $_SERVER['REQUEST_URI']; 
							$url = parse_url( $url, $component = -1 );
							$path = explode('/', $url['path']);
							$profile_class = $events_class = $locations_class = 
							$event_requests = $categories_class = $event_track_results_class = $all_users_class = $map_class = '';
						
							if (isset($path[2]) && $path[2] == 'profile') {
								$profile_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'events') {
								$events_class = 'current-page';
							}
							if (isset($path[2]) && !isset($path[3]) && $path[2] == 'locations') {
								$locations_class = 'current-page';
							} 
							if (isset($path[2]) && $path[2] == 'event_requests') {
								$event_requests = 'current-page';
							} 
							if (isset($path[2]) && $path[2] == 'categories') {
								$categories_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'event_track_results') {
								$event_track_results_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'all_users') {
								$all_users_class = 'current-page';
							} 
							if (isset($path[2]) && $path[2] == 'map') {
								$map_class = 'current-page';
							} 

							
							
							?>
					<ul>
						<!-- <li>
							<a href="<?php echo base_url("organizer/profile"); ?>" class="<?= $profile_class; ?>">Profile</a>
						</li> -->
						<?php if ($_SESSION['account_type'] == 'admin') { ?>
						<li>
							<a href="<?php echo base_url("organizer/categories"); ?>" class="<?= $categories_class; ?>">Categories</a>
						</li>
						<?php } ?>
						<!-- <li>
							<a href="<?php echo base_url("organizer/events"); ?>" class="<?= $events_class; ?>">Events</a>
						</li> -->
						<?php if ($_SESSION['account_type'] == 'admin') { ?>
						<li>
							<a href="<?php echo base_url("organizer/event_requests"); ?>" class="<?= $event_requests; ?>">Event Requests</a>
						</li>
						<?php } ?>
						<?php if ($_SESSION['account_type'] == 'admin') { ?>
						<li>
							<a href="<?php echo base_url("organizer/locations"); ?>" class="<?= $locations_class; ?>">Locations</a>
						</li>
						<li>
							<a href="<?php echo base_url("organizer/locations/reached"); ?>" 
							class="<?= (isset($path[3]) && strpos($path[3], 'reached') !== false) ? 'current-page' : false; ?>">Locations Reached</a>
						</li>
						<?php } ?>
						<?php if ($_SESSION['account_type'] == 'admin') { ?>
						<li>
							<a href="<?php echo base_url("organizer/category_results"); ?>" class="<?= $event_track_results_class; ?>">Results</a>
						</li>
						<?php } ?>
						<?php if ($_SESSION['account_type'] == 'admin') { ?>
						<li>
							<a href="<?php echo base_url("organizer/all_users"); ?>" class="<?= $all_users_class; ?>">Users</a>
						</li>
						<li>
							<a href="<?php echo base_url("organizer/map"); ?>" class="<?= $map_class; ?>">Map</a>
						</li>
						<?php } ?>
						<?php if ($_SESSION['account_type'] == 'organizer') { ?>
							<?php foreach ($races as $race) { ?>
						<li>
							<a href="<?php echo base_url("/organizer/events/track/" . $race->id); ?>" class=""><?= $race->name ?></a>
						</li>
						<?php } } ?>
					</ul>

				</div>
			</div>
		</div>
	</div>
</div>
</nav>
<div class="main-container">