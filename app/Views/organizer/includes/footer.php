
					<!-- App footer start -->
					<div class="app-footer">© Organizer <?= date('Y') ?></div>
					<!-- App footer end -->

				</div>
				<!-- Content wrapper scroll end -->

			</div>
			<!-- *************
				************ Main container end *************
			************* -->

		</div>
		<!-- Page wrapper end -->

		<!-- *************
			************ Required JavaScript Files *************
		************* -->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		<script src="/js/jquery.min.js"></script>
		<script src="/js/bootstrap.bundle.min.js"></script>
		<script src="/js/modernizr.js"></script>
		<script src="/js/moment.js"></script>

		<!-- *************
			************ Vendor Js Files *************
		************* -->
		
		<!-- Megamenu JS -->
		<script src="/vendor/megamenu/js/megamenu.js"></script>
		<script src="/vendor/megamenu/js/custom.js"></script>

		<!-- Slimscroll JS -->
		<script src="/vendor/slimscroll/slimscroll.min.js"></script>
		<script src="/vendor/slimscroll/custom-scrollbar.js"></script>

		<!-- Search Filter JS -->
		<script src="/vendor/search-filter/search-filter.js"></script>
		<script src="/vendor/search-filter/custom-search-filter.js"></script>

		<!-- Apex Charts -->
		<!-- <script src="/vendor/apex/apexcharts.min.js"></script>
		<script src="/vendor/apex/custom/home/salesGraph.js"></script>
		<script src="/vendor/apex/custom/home/ordersGraph.js"></script>
		<script src="/vendor/apex/custom/home/earningsGraph.js"></script>
		<script src="/vendor/apex/custom/home/visitorsGraph.js"></script>
		<script src="/vendor/apex/custom/home/customersGraph.js"></script>
		<script src="/vendor/apex/custom/home/sparkline.js"></script> -->

		<!-- Circleful Charts -->
		<!-- <script src="/vendor/circliful/circliful.min.js"></script>
		<script src="/vendor/circliful/circliful.custom.js"></script> -->

		<!-- Bootstrap Select JS -->
		<script src="/vendor/bs-select/bs-select.min.js"></script>
		<script src="/vendor/bs-select/bs-select-custom.js"></script>

		<!-- <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script> -->

		<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/leaflet.js"></script>

		<!-- vuejs -->
		<!-- <script src="<?= base_url('js/vue.global.js') ?>"></script> -->
		<script src="<?= base_url('js/vue.global.prod.min.js') ?>"></script>

		

		<!-- Main Js Required -->
		<script src="/js/main.js"></script>
		<script>
		$(document).ready(function(){

			$('.sidebarMenuScroll').css('height', '');
			$('.slimScrollDiv').css('height', '');

			$('.toggle-sidebar').click(function(){
				let toggleSide = $(this);
				let iElement = toggleSide.find('i');

				let iClass = $(iElement).attr('class')
				if (iClass == 'icon-menu') {
					iElement.removeClass("icon-menu");
					iElement.html('&#x2716;');
					iElement.css('font-style', 'normal');
				} else {
					iElement.html('');
					iElement.addClass("icon-menu");
				}
				
			});
		});
		</script>
	</body>
</html>