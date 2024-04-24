<!--<div class="container">
		<div class="mt-4 p-5 bg-primary text-white rounded">
				<h1>Welcome to rally: <br></h1>
				
		</div>
</div> -->
<style>
video#webcam {
  width: 100%;
  height: auto;
}
.html5-qrcode-element {
  color: #ffffff;
  background-color: #1273eb;
  border-color: #1273eb;
  cursor: pointer;
  padding: 0.4rem 0.8rem;
  border-radius: 2px;
  border: 1px solid transparent;
  font-size: .825rem;
  font-weight: 400;
  padding: 0.594rem 1.25rem;
}
#html5-qrcode-button-camera-start {
  margin-bottom: 20px !important;
}
</style>
<div class="container">
		<div class="row">
				<div class="col-md-12">
						
					<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4">
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
								<div class="card">
									<div class="card-header">

										</div>
										<div class="card-title">

                    </div>
										<div class="graph-day-selection" role="group">
											<!-- <button type="button" class="btn active">Export to Excel</button> -->
										</div>
									</div>
									<div class="card-body">
                      <h1>Scan QR Code:</h1>
                      <!-- <p>Select QR Code image for scanning...</p> -->

                      <!-- <div class="row">
                        <div class="col-md-8">
                          <video id="webcam" style="display:none;" autoplay playsinline></video>
                          <canvas id="canvas" class="d-none"></canvas>
                          <img src="" id="camera_snap" alt=""> -->
                          <!-- <audio id="snapSound" src="audio/snap.wav" preload = "auto"></audio> -->

                          <!-- <br> -->

                          <!-- <div class="mt-2 mb-2">
                            <button id="start" class="btn btn-primary btn-sm mr-2">START</button>
                            <button id="takesnap" class="btn btn-primary btn-sm mr-2">Take snap</button>
                            <button id="end" class="btn btn-primary btn-sm">END</button>
                            <button id="cameraFlip" class="btn btn-primary btn-sm">CAMERA FLIP</button>
                          </div>
                        </div>
                      </div> -->

                      <div class="row">
                        <div class="col-md-4">

                          <!-- <div class="mb-3">
                            <label for="qrcode_image" class="form-label">Select QR Code Image:</label>
                            <input class="form-control" name="qrcode_image" type="file" id="qrcode_image">
                          </div>

                          <div class="form-group">
                            <input type="button" class="btn btn-primary btn-sm" name="scan_image" value="Scan Image">
                          </div> -->

                          <p id="scanned_result"></p>
                        </div>
                      </div>

                      <div id="qr-reader" style="width:500px"></div>
                      <div id="qr-reader-results"></div>


									</div>
								</div>
							</div>
						</div>

				</div>

				

		</div>
</div>
<br><br><br><br><br><br><br><br><br><br>
<script>
document.addEventListener("DOMContentLoaded", () => {
	$(document).ready(function(){
    localStorage.removeItem('HTML5_QRCODE_DATA'); 

      // TAKE SNAP WITH CAMERA
      // const webcamElement = document.getElementById('webcam');
      // const canvasElement = document.getElementById('canvas');
      // const snapSoundElement = document.getElementById('snapSound');
      // const webcam = new Webcam(webcamElement, 'user', canvasElement, snapSoundElement);
      // $('#start').click(function(){
      //   $('#webcam').show();
      //   webcam.start()
      //   .then(result =>{
      //       console.log("webcam started");
      //   })
      //   .catch(err => {
      //       console.log(err);
      //   });
      // });

      // $('#end').click(function(){
      //   $('#webcam').hide();
      //   webcam.stop();
      // });
        
      // $('#takesnap').click(function(){
      //   let picture = webcam.snap();
      //   $('#camera_snap').attr('src', picture);

      //   function DataURIToBlob(dataURI) {
      //     const splitDataURI = dataURI.split(',')
      //     const byteString = splitDataURI[0].indexOf('base64') >= 0 ? atob(splitDataURI[1]) : decodeURI(splitDataURI[1])
      //     const mimeString = splitDataURI[0].split(':')[1].split(';')[0]

      //     const ia = new Uint8Array(byteString.length)
      //     for (let i = 0; i < byteString.length; i++)
      //         ia[i] = byteString.charCodeAt(i)

      //     return new Blob([ia], { type: mimeString })
      //   }

      //   const file = DataURIToBlob(picture);
      //   const formData = new FormData();
      //   formData.append('file', file, 'image.jpg') 
        // formData.append('profile_id', this.profile_id) //other param
        // formData.append('path', 'temp/') //other param
      //   $.ajax({
      //     url: 'http://api.qrserver.com/v1/read-qr-code/',
      //     method: 'POST',
      //     data: formData,
      //     dataType: 'json',
      //     contentType: false,
      //     cache: false,
      //     processData:false,
      //     success: function(success) {
      //       let result = success[0].symbol[0].data;
      //       if (success[0].symbol[0].error != null) {
      //         $('#scanned_result').html('');
      //         $('#scanned_result').append('<p class="text-danger"><strong>Incorrect image, Select proper QR Code Image</strong></p>');
      //       } else {
      //         var link = success['text'];
      //         var anchor_tag = $(`<a class="text-success" href="${link}" target="blank">Click here so that location will be marked as reached</a>`);
      //         $('#scanned_result').html('');
      //         $('#scanned_result').append(anchor_tag);
      //       }
            
      //     },
      //     error: function(error) {
      //       console.log(error);
      //     }
      //   });
      // });

      // $('#cameraFlip').click(function() {
      //     webcam.flip();
      //     webcam.start();  
      // });


      // $('input[name="scan_image"]').click(function(){
      //   var file_data = $('#qrcode_image').prop('files')[0];   
      //   var form_data = new FormData();                  
      //   form_data.append('file', file_data);
        // const formData = new FormData();
        // formData.append('file', file, 'image.jpg') 
        // formData.append('profile_id', this.profile_id) //other param
        // formData.append('path', 'temp/') //other param
      //   $.ajax({
      //     url: 'http://api.qrserver.com/v1/read-qr-code/',
      //     method: 'POST',
      //     data: form_data,
      //     dataType: 'json',
      //     contentType: false,
      //     cache: false,
      //     processData:false,
      //     success: function(success) {
      //       let result = success[0].symbol[0].data;
      //       if (success[0].symbol[0].error != null) {
      //         $('#scanned_result').html('');
      //         $('#scanned_result').append('<p class="text-danger"><strong>Incorrect image, Select proper QR Code Image</strong></p>');
      //       } else {
      //         // var link = success['text'];
      //         var anchor_tag = $(`<a class="text-success" href="${result}" target="blank">Click here so that location will be marked as reached</a>`);
      //         $('#scanned_result').html('');
      //         $('#scanned_result').append(anchor_tag);
      //       }
            
      //     },
      //     error: function(error) {
      //       console.log(error);
      //     }
      //   });
      // });



      // QR Code Scanner
      var resultContainer = document.getElementById('qr-reader-results');
      var lastResult, countResults = 0;

      function onScanSuccess(decodedText, decodedResult) {
          if (decodedText !== lastResult) {
              ++countResults;
              lastResult = decodedText;
              // Handle on success condition with the decoded message.
              // console.log(`Scan result ${decodedText}`, decodedResult);
              // var myWindow = window.open(decodedText, "newWin", "width="+screen.availWidth+",height="+screen.availHeight);
              window.location.href = decodedText;
          }
      }

      function onScanError(errorMessage) {
        console.log(errorMessage);
      }

      var html5QrcodeScanner = new Html5QrcodeScanner(
          "qr-reader", { fps: 10, qrbox: 250 });
      html5QrcodeScanner.render(onScanSuccess);

      setTimeout(() => {
        $('#qr-reader').css('width', 'auto');
        $('#qr-reader').css('padding-bottom', '25px');
        $('#html5-qrcode-button-camera-permission').addClass('btn btn-primary btn-sm');
        $('#html5-qrcode-button-camera-permission').css('margin-bottom', '25px');
        $('#html5-qrcode-anchor-scan-type-change').css('text-decoration', 'none');

        $('#html5-qrcode-anchor-scan-type-change').click(function(){
          $('#html5-qrcode-button-file-selection').addClass('btn btn-primary btn-sm');
        });

        $('#html5-qrcode-button-camera-permission').click(function(){
          $('#html5-qrcode-button-camera-stop').addClass('btn btn-primary btn-sm');
        });


        $('#html5-qrcode-button-camera-stop').addClass('btn btn-primary btn-sm');
      }, 0);

	});
});
</script>