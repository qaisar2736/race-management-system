<nav class="sidebar-wrapper">
<div class="sidebar-tabs">
	<div class="tab-content">
		<div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
			<div class="tab-pane-header">
				Dashboards
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
							$profile_class = $events_class = $locations_class = '';
						
							if (isset($path[2]) && $path[2] == 'profile') {
								$profile_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'events') {
								$events_class = 'current-page';
							}
							if (isset($path[2]) && $path[2] == 'locations') {
								$locations_class = 'current-page';
							} 
							
							?>
					<ul>
						<li>
							<a href="<?php echo base_url("participant/profile"); ?>" class="<?= $profile_class; ?>">Profile</a>
						</li>
						<li>
							<a href="<?php echo base_url("participant/events"); ?>" class="<?= $events_class; ?>">Events</a>
						</li>
						<!-- <li>
							<a href="<?php echo base_url("participant/locations"); ?>" class="<?= $locations_class; ?>">Locations</a>
						</li> -->
					</ul>

				</div>
			</div>
		</div>
	</div>
</div>
</nav>
<div class="main-container">