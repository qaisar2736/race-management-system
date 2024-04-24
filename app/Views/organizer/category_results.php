<!-- <script src="https://unpkg.com/xlsx@0.18.5/dist/xlsx.full.min.js"></script> -->
<style>
th {
	cursor: pointer;
}
</style>
<script>
	function tableToExcel2(table, name, filename) {
        let uri = 'data:application/vnd.ms-excel;base64,', 
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><title></title><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>', 
        base64 = function(s) { return window.btoa(decodeURIComponent(encodeURIComponent(s))) },         format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; })}
        
        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}

        var link = document.createElement('a');
        link.download = filename;
        link.href = uri + base64(format(template, ctx));
        link.click();
}
	function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
	function exportToExcel() {
			const table = document.getElementById('myTable');
      const workbook = XLSX.utils.book_new();
      const worksheet = XLSX.utils.table_to_sheet(table);

      // Set cell type as text for all cells
      const range = XLSX.utils.decode_range(worksheet['!ref']);
      for (let R = range.s.r; R <= range.e.r; ++R) {
        for (let C = range.s.c; C <= range.e.c; ++C) {
          const cellAddress = XLSX.utils.encode_cell({ c: C, r: R });
          const cell = worksheet[cellAddress];
          if (cell) {
            cell.t = 's'; // Set cell type as string
          }
        }
      }

      XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet1');
      XLSX.writeFile(workbook, 'data.xlsx');
	}


	function sortTable(clickedHeader) {
  const tableBody = clickedHeader.closest('table').querySelector('tbody');
  const columnIndex = Array.from(clickedHeader.parentNode.children).indexOf(clickedHeader);
  const rows = Array.from(tableBody.getElementsByTagName('tr'));

  let sortOrder = clickedHeader.dataset.sortOrder || 'asc'; // Default to ascending order if no sortOrder is set
  sortOrder = sortOrder === 'asc' ? 'desc' : 'asc'; // Toggle between ascending and descending order

  rows.sort((rowA, rowB) => {
    let secondsA = rowA.getElementsByTagName('td')[columnIndex].innerText;console.log(secondsA);
    let secondsB = rowB.getElementsByTagName('td')[columnIndex].innerText;
    secondsA = convertToSeconds(secondsA);
    secondsB = convertToSeconds(secondsB);

    if (sortOrder === 'asc') {
      if (secondsA < secondsB) {
        return -1;
      } else if (secondsA > secondsB) {
        return 1;
      } else {
        return 0;
      }
    } else {
      if (secondsA > secondsB) {
        return -1;
      } else if (secondsA < secondsB) {
        return 1;
      } else {
        return 0;
      }
    }
  });

  while (tableBody.firstChild) {
    tableBody.firstChild.remove();
  }

  rows.forEach(row => {
    tableBody.appendChild(row);
  });

  clickedHeader.dataset.sortOrder = sortOrder; // Store the updated sortOrder on the clickedHeader
}

function sortTable2(clickedHeader) {
  const tableBody = clickedHeader.closest('table').querySelector('tbody');
  const columnIndex = Array.from(clickedHeader.parentNode.children).indexOf(clickedHeader) ;
  const rows = Array.from(tableBody.getElementsByTagName('tr'));

	rows.sort((rowA, rowB) => {
		let secondsA = rowA.getElementsByTagName('td')[columnIndex].innerText;
		let secondsB = rowB.getElementsByTagName('td')[columnIndex].innerText;
		secondsA = convertToSeconds(secondsA);
		secondsB = convertToSeconds(secondsB);

		if (secondsA < secondsB) {
			return -1;
		} else if (secondsA > secondsB) {
			return 1;
		} else {
			return 0;
		}
	});

  while (tableBody.firstChild) {
    tableBody.firstChild.remove();
  }

  rows.forEach(row => {
    tableBody.appendChild(row);
  });
}

function convertToSeconds(time) {
  if (time === '-') {
    return Infinity; // Assign a large value to ensure '-' is placed at the end
  }
  
  const [minutes, seconds] = time.split(',');
  return Number(minutes) * 60 + Number(seconds);
}

function parseTime(timeString) {
  if (timeString === '-') {
    return { minutes: Infinity, seconds: Infinity };
  }

  const [minutes, seconds] = timeString.split(',').map(Number);
  return { minutes, seconds };
}

</script>
				<!-- Content wrapper scroll start -->
				<div class="content-wrapper-scroll">

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
										<h2><?= count([]) ?></h2>
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

						<!-- Row start -->
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="card">
									<div class="card-header">
									<?php if (isset($_SERVER['HTTP_REFERER'])) { ?>
									<a href="<?= $_SERVER['HTTP_REFERER']; ?>"><button class="btn btn-info btn-sm">Back</button></a>
									<?php } ?>
										<div class="card-title">Results for category <?= $category->name ?></div>
										<div class="graph-day-selection" role="group">
											<button type="button" class="btn active" onclick="tableToExcel2('myTable', 'name', '<?= $category->name ?>.xls')">Generate Excel</button>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
                    <table class="table products-table" id="myTable">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>ID</th>
                          <th>Class</th>
                          <?php foreach ($tracks as $track) : ?>
                            <th onclick="sortTable(this)" data-sort-order="desc"><?= $track ?></th>
                          <?php endforeach; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($users as $user) : ?>
                          <tr>
                            <td><strong><?= ucfirst($user->name) . ' ' . ucfirst($user->surname) ?></strong></td>
                            <td><strong><?= $user->id ?></strong></td>
                            <td><?= $user->class ?></td>
                            <?php foreach ($all_track_ids_for_given_category as $track_id) : ?>
                              <?php // var_dump($track_id);exit;
                              $filteredArray = array_filter($event_details, function ($item) use ($track_id, $user) {
                                return $item->event_id == $track_id  && $item->user_id == $user->id;
                                //$item->track === $track
                              });
                            
                              ?>
                              <td><?php 
                                if (empty($filteredArray)) {
                                  echo '-';
                                } else {
                                  $object = $filteredArray[array_keys($filteredArray)[0]];
                                  $startDateTime = new DateTime($object->start); // Assuming $start is the starting date/time from the database
                                  $endDateTime = new DateTime($object->end); // Assuming $end is the ending date/time from the database

                                  $interval = $startDateTime->diff($endDateTime);

                                  $minutes = $interval->i; // Get the minutes
                                  $seconds = $interval->s; // Get the seconds
                                  echo $minutes . ','.$seconds;
                                }
                              ?></td>
                            <?php endforeach; ?>
                          </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>

											<!--<table class="table products-table">
												<thead>
													<tr>
														<th>Name</th>
														<th>UserID</th>
														
													</tr>
                          
												</thead>
												<tbody>

												</tbody>
											</table>-->
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Row end -->

						<!-- Row start -->
						<!-- Row end -->

					</div>
					<!-- Content wrapper end -->
<script>
document.addEventListener("DOMContentLoaded", () => {
  var total_tracks = <?= count($tracks); ?>;
  var total_users = <?= count($users); ?>;
  var start_td = 4;
  var table = document.getElementById('myTable');
  var cell_index = 3;

  for (i = 1; i <= total_tracks; i++) {
    // i - current track
    var td_array = [];
    for (j = 1; j <= total_users; j++) {
      // j - current user
      let td = $(`tbody tr:nth-child(${j}) td:nth-child(${i + 3}`);
      td_array.push(td);
    }
    td_array.sort((rowA, rowB) => {//console.log($(rowA).text(), $(rowB).text());throw Error('stop');
      let secondsA = $(rowA).text();
      let secondsB = $(rowB).text();
      secondsA = convertToSeconds(secondsA);
      secondsB = convertToSeconds(secondsB);


      if (secondsA < secondsB) {
        return -1;
      } else if (secondsA > secondsB) {
        return 1;
      } else {
        return 0;
      }
    });

    var count = 0;
    for (var k = 0; k < td_array.length; k++) {
      if ($(td_array[k]).text() != '-') {
        count++;
        if (count >= 3) {
          break;
        }
      }
    }
    var at_least_three_elements_has_value = count >= 3;

    if (at_least_three_elements_has_value) {
      $(td_array[0]).html(function(index, currentText) {
        return currentText != '-' ? currentText + ' <img width="30" src="<?= base_url('img/medals/first.png') ?>" alt="medal">': currentText;
      });
      $(td_array[1]).html(function(index, currentText) {
        return currentText != '-' ? currentText + ' <img width="30" src="<?= base_url('img/medals/second.png') ?>" alt="medal">': currentText;
      });
      $(td_array[2]).html(function(index, currentText) {
        return currentText != '-' ? currentText + ' <img width="30" src="<?= base_url('img/medals/third.png') ?>" alt="medal">': currentText;
      });
    }

  }
});
</script>