                      
                        <div class="alert alert-block alert-warning">
                        <h4 class="header smaller lighter warning">
                            <i class="ace-icon fa fa-bullhorn"></i>
                            <b>Note:</b>
                        </h4>
                        <strong>Please Take Whole Class Picture And Submit It Along With Your Attendance For The Verification!...</strong>
                            
				    </div>
                    <div class="alert alert-block" id="alert_attendance_div" style="display:none">
                        <button type="button" class="close" >
                            <i class="ace-icon fa fa-times"></i>
                        </button> 
                        <span id="alert_attendance_message"></span>
                    </div>     
                    <div class="center">     
                       
                           
                            <button style="width:130px;border-radius:10px;" class="btn btn-primary" id="takePhotoButton"  type="button">
                            <i class="ace-icon fa fa-camera bigger-160"></i>
                                Take Photo
                            </button>

                            <!--display:none-->
                            <button style="width:130px;border-radius:10px;" class="btn btn-primary" id="switchCameraButton"  type="button" aria-pressed="false">
                            <i class="ace-icon fa fa-exchange bigger-160"></i>
                                Flip Camera
                            </button>
                            
                             <button style="width:130px;border-radius:10px;" class="btn btn-primary" id="toggleFullScreenButton"   type="button" aria-pressed="false">
                            <i class="ace-icon fa fa-laptop bigger-160"></i>
                                Fullscreen
                            </button>
                    
                    </div>
                    <br />
                     <div class="center">
                                 
                        
                             <Button style="width:130px;border-radius:10px;" class="btn btn-inverse" id="btn-go-back" type="submit">
                            <i class="ace-icon fa fa-undo bigger-160"></i>    
                                Go Back</Button>
                            
                            <Button  style="width:175px;border-radius:10px;" class="btn btn-success" id="btn-submit-attendance" type="submit" disabled>
                            <i class="ace-icon fa fa-floppy-o bigger-160"></i>    
                                Submit Attendance</Button>
                        
                    </div>
                    <hr />
                    <div>
                        <video id="video" autoplay class="table-responsive"></video>
                        <canvas id="canvas" class="table-responsive"></canvas>
                        <input type="hidden" name="img_url" id="img_url">
                    </div> 
                   
                  
                    
       <!--Scripts For Camera Configuration-->
        <script src="{{asset('../assets/web-cam/adapter.min.js')}}"></script>
        <script src="{{asset('../assets/web-cam/DetectRTC.min.js')}}"></script>
        <script src="{{asset('../assets/web-cam/howler.core.min.js')}}"></script>
        <script src="{{asset('../assets/web-cam/screenfull.min.js')}}"></script>
        <script src="{{asset('../assets/web-cam/webcam.css')}}"></script>
        <!--Scripts For Camera Configuration-->
        
        <!--JS Script-->
        <script>
        $(document).ready(function()
        {
       
            
            var video;
            var amountOfCameras = 0;
            var currentFacingMode = 'environment';

            var takePhotoButton;
            var toggleFullScreenButton;
            var switchCameraButton;

            var click_sound ="<?php echo asset('../assets/web-cam/snd/click.mp3');?>";
            
            video = document.getElementById('video');

            /*Check Cameras, Browser, OS, ETC before creating the interface*/
            DetectRTC.load(function() {

                /*Check Cameras, Browser, OS, ETC*/
                if (DetectRTC.isWebRTCSupported == false) {
                    alert('Please use Chrome, Firefox, iOS 11, Android 5 or higher, Safari 11 or higher');
                }
                else {
                    if (DetectRTC.hasWebcam == false) {
                        alert('Your Device has no camera. Please install an external webcam device.');
                    }
                    else {

                        amountOfCameras = DetectRTC.videoInputDevices.length;

                        initCameraUI();
                        initCameraStream();
                    } 
                }

                console.log("RTC Debug info: " + 
                    "\n OS:                   " + DetectRTC.osName + " " + DetectRTC.osVersion + 
                    "\n browser:              " + DetectRTC.browser.fullVersion + " " + DetectRTC.browser.name +
                    "\n is Mobile Device:     " + DetectRTC.isMobileDevice +
                    "\n has webcam:           " + DetectRTC.hasWebcam + 
                    "\n has permission:       " + DetectRTC.isWebsiteHasWebcamPermission +       
                    "\n getUserMedia Support: " + DetectRTC.isGetUserMediaSupported + 
                    "\n isWebRTC Supported:   " + DetectRTC.isWebRTCSupported + 
                    "\n WebAudio Supported:   " + DetectRTC.isAudioContextSupported +
                    "\n is Mobile Device:     " + DetectRTC.isMobileDevice
                );

            });
            /*Check Cameras, Browser, OS, ETC before creating the interface*/


            /*Take Photo Button onClick Event*/
            $(document).on("click",'#takePhotoButton',function()
            {
                takeSnapshot();        
            });  
            /*Take Photo Button onClick Event*/

            function initCameraUI() 
            {
                takePhotoButton = document.getElementById('takePhotoButton');
                toggleFullScreenButton = document.getElementById('toggleFullScreenButton');
                switchCameraButton = document.getElementById('switchCameraButton');

                // -- fullscreen part
                function fullScreenChange() {
                    if(screenfull.isFullscreen) {
                        toggleFullScreenButton.setAttribute("aria-pressed", true);
                    }
                    else {
                        toggleFullScreenButton.setAttribute("aria-pressed", false);
                    }
                }

                if (screenfull.enabled) {
                    screenfull.on('change', fullScreenChange);

                    //toggleFullScreenButton.style.display = 'block';  
                    $(toggleFullScreenButton).show();

                    // set init values
                    fullScreenChange();

                    toggleFullScreenButton.addEventListener("click", function() {
                        screenfull.toggle(document.getElementById('container')).then(function () {
                                console.log('Fullscreen mode: ' + (screenfull.isFullscreen ? 'enabled' : 'disabled'))
                        });
                    });
                }
                else {
                    console.log("iOS doesn't support fullscreen (yet)");   
                }

                // -- switch camera part
                if(amountOfCameras > 1) {

                    switchCameraButton.style.display = 'block';

                    switchCameraButton.addEventListener("click", function() {

                        if(currentFacingMode === 'environment')
                        {
                          currentFacingMode = 'user';  
                        } 
                        else
                        {
                           currentFacingMode = 'environment'; 
                        }                  

                        initCameraStream();
                    });  
                }
           
        }


            // https://github.com/webrtc/samples/blob/gh-pages/src/content/devices/input-output/js/main.js
            function initCameraStream() {

                // stop any active streams in the window
                if (window.stream) {
                    window.stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                }

                var constraints = { 
                    audio: false, 
                    video: {
                        width:500,
                        height:350,
                        facingMode: currentFacingMode
                    }
                };

                navigator.mediaDevices.getUserMedia(constraints).
                then(handleSuccess).catch(handleError);   

                function handleSuccess(stream) {

                    window.stream = stream; // make stream available to browser console
                    video.srcObject = stream;

                    if(constraints.video.facingMode) {

                        if(constraints.video.facingMode === 'environment') {
                            switchCameraButton.setAttribute("aria-pressed", true);
                        }
                        else {
                            switchCameraButton.setAttribute("aria-pressed", false);
                        }
                    }

                    return navigator.mediaDevices.enumerateDevices();
                }

                function handleError(error) {
                    console.log(error);
                    if(error === 'PermissionDeniedError') 
                    {
                        alert("Permission denied. Please refresh and give permission.");
                    }

                }

            }

            /*Take Photo Function*/
            function takeSnapshot() 
            {

                // if you'd like to show the canvas add it to the DOM
                var canvas = document.getElementById('canvas');

                var width = video.videoWidth;
                var height = video.videoHeight;

                canvas.width = width;
                canvas.height = height;

                context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, width, height);

                $("#img_url").val(canvas.toDataURL());
                $("#btn-submit-attendance").removeAttr('disabled');
                $(".btn-submit-attendance").removeAttr('disabled');
                
               
                
                 var sndClick = new Howl({ src: [click_sound] });
                sndClick.play();  
                console.log(canvas.toDataURL());

                // https://developers.google.com/web/fundamentals/primers/promises
                // https://stackoverflow.com/questions/42458849/access-blob-value-outside-of-canvas-toblob-async-function

                function getCanvasBlob(canvas) {
                    return new Promise(function(resolve, reject) {
                        canvas.toBlob(function(blob)
                         { resolve(blob) 

                        }, 'image/jpg');

                    })
                }

               

        }
            /*Take Photo Function*/

            
            
            $(document).on("click","#btn-go-back",function(){
                if (window.stream) 
                {
                    window.stream.getTracks().forEach(function(track) {
                        track.stop();
                    });
                }
                
                $("#camera_section").html('');
                $("#attendance_table_section").show();
                
                /*Top Alert*/
                $("#alert_attendance_div").hide();
                $("#alert_attendance_message").html("");
                /*Bottom Alert*/
                $("#alert_attendance_div2").hide();
                $("#alert_attendance_message2").html("");
                
                
                
            });
            
        });
            
</script>
        
  