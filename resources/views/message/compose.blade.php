@extends('layouts.app')

@section('content')
    
    <div class="container-fluid">
        <h4>Compose Message</h4>
        <hr>
        <form>
            @csrf
            <div class="form-group row">
                <label for="msg_to" class="col-md-3 col-form-label text-md-right">To </label>
                <div class="col-md-5">
                    <input type="enail" id="msg_to" class="form-control" placeholder="Recipient Email">
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5>Patient Information</h5></div>
                <div class="card-body">
                    <div class="form-group row">
                        <label for="p_name" class="col-md-3 col-form-label text-md-right">Patient Name </label>
                        <div class="col-md-6">
                            <input type="text" id="p_name" class="form-control" placeholder="Patient Name">
                        </div>
                    </div>
            
                    <div class="form-group row">
                        <label for="p_age" class="col-md-3 col-form-label text-md-right">Patient Age </label>
                        <div class="col-md-6">
                            <input type="text" id="p_age" class="form-control" placeholder="Patient Age">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="p_gender" class="col-md-3 col-form-label text-md-right">Patient Gender </label>
                        </br>
                        <div class="col-md-6">
                            <select class="form-control" id="p_gender">
                                <option>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
            
                    <div class="form-grou row">
                        <label for="med_img_type" class="col-md-3 col-form-label text-md-right">Type of Medical Image </label>
                        <div class="col-md-6">
                            <select class="form-control" id="med_img_type">
                                <option>Select Image Tyoe</option>
                                <option value="X-ray computed tomography (CT) scan">X-ray computed tomography (CT) scan</option>
                                <option value="Computed Axial Tomography (CAT) Scan">Computed Axial Tomography (CAT) Scan</option>
                                <option value="Magnetic resonance imaging (MRI)">Magnetic resonance imaging (MRI)</option>
                                <option value="Fluoroscopy">Fluoroscopy</option>
                                <option value="Projectional (conventional) radiography">Projectional (conventional) radiography</option>
                                <option value="Scintigraphy (Gamma Scan)">Scintigraphy (Gamma Scan)</option>
                                <option value="SPECT (Single-Photon Emission Computed Tomography(SPECT)">Single-Photon Emission Computed Tomography (SPECT)</option>
                                <option value="Positron emission tomography (PET) ">Positron emission tomography (PET) </option>
                                <option value="Ultrasound">Ultrasound</option>
                                <option value="Quasistatic Elastography/Strain Imaging">Quasistatic Elastography/Strain Imaging</option>
                                <option value="Shear Wave Elasticity Imaging (SWEI)">Shear Wave Elasticity Imaging (SWEI)</option>
                                <option value="Acoustic Radiation Force Impulse imaging (ARFI)">Acoustic Radiation Force Impulse imaging (ARFI)</option>
                                <option value="Supersonic Shear Imaging (SSI)">Supersonic Shear Imaging (SSI)</option>
                                <option value="Transient Elastography">Transient Elastography</option>
                                <option value="Photoacoustic Imaging">Photoacoustic Imaging</option>
                                <option value="Echocardiography">Echocardiography</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row py-3" >
                        <label for="msg_note" class="col-md-3 col-form-label text-md-right">Important Information (optional)</label>
                        <div class="col-md-6">
                            <textarea class="form-control" rows="5" id="msg_note" placeholder="For writing important information about patient..."></textarea>
                        </div>
                        
                    </div>
                </div>
            </div>
            <br>
            
            <div class="card">
                <div class="card-header"><h5>Medical Image</h5></div>
                <div class="card-body">

                    <div style="text-align:center;">
                        <img src="../storage/images/nophoto.jpg" style="height: 300px;" id="med_img" class="img-fluid rounded">
                    </div>
                    </br>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="img_file" class="col-md-3 col-form-label text-md-right">Image File </label>
                                <div class="col-md-9">
                                    <input type="file" id="img_file" class="form-control">
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <label for="enc_algo" class="col-md-3 col-form-label text-md-right">Encryption Algorithm </label>
                                <div class="col-md-9">
                                    <select class="form-control" id="enc_algo">
                                        <option>Select an Algorithm</option>
                                        <option value="AES">AES</option>
                                        <option value="DES">DES</option>
                                        <option value="Triple DES">Triple DES</option>
                                        <option value="Rabbit">Rabbit</option>
                                        <option value="RC4">RC4</option>
                                    </select>
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <label for="enc_key" class="col-md-3 col-form-label text-md-right">Encryption (Secret) Key </label>
                                <div class="col-md-9">
                                    <input type="password" id="enc_key" class="form-control">
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <label for="enc_key" class="col-md-3 col-form-label text-md-right"></label>
                                <div class="col-md-9">
                                    <input  id="btnEnc" class="btn btn-primary" disabled value="Encrypt Image">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 px-4">
                            <h5>Image and Encryption Information</h5>
                            <hr>
                            <dl>
                                <dt>Image File Name: </dt>
                                <dd id="dd_name"></dd>

                                <dt>Image File Size: </dt>
                                <dd id="dd_size"></dd>

                                <dt>Image File Type: </dt>
                                <dd id="dd_type"></dd>

                                <dt>Encryption Time :</dt>
                                <dd id="dd_encTime"></dd>
                            </dl>
                        </div>
                    </div>
                    
                </div>
            </div>

            <br>
            <div class="text-center">
                <input type="button" id="brnSend" class="btn btn-primary" value="Send Message" >
            </div>
        </form>
                    
                        
                    
            

                
            
        
        
    </div>

    <script>
        $(function(){

            var dataURL;
            var encryptedImgString= null;
            var imageName=null; 
            var encTime= 0; 
            var imageSize=0;
            var imgType=null;

            
            //To display the selected image and enable ecrypt button
            $('#img_file').change(function(event){
                event.preventDefault();
                var image = event.target;
                imageName= image.files[0].name;
                imageSize= image.files[0].size;
                imgType= image.files[0].type;
                $('#dd_name').html(imageName);
                $('#dd_size').html(imageSize+' Bytes');
                $('#dd_type').html(imgType);
                
                //To enable encrypt button
                if(imageName!=null){
                    $('#btnEnc').prop("disabled",false);
                }

                var reader = new FileReader();
                reader.onload = function(){
                    dataURL = reader.result;
                    var output = document.getElementById('med_img');
                    output.src = dataURL;
                };
                reader.readAsDataURL(image.files[0]);
            });
            
            //To encrypt the selected image
            $('#btnEnc').click(function(){
                var encKey=$('#enc_key').val();
                
                //select algorithm
                var selectedAlgo= $('#enc_algo').val();
                var encryptedImg,t0,t1;

                if(selectedAlgo=="AES"){
                    t0=performance.now();
                    encryptedImg=CryptoJS.AES.encrypt(dataURL,encKey);
                    t1=performance.now();
                }
                else if(selectedAlgo=="DES"){
                    t0=performance.now();
                    encryptedImg=CryptoJS.DES.encrypt(dataURL,encKey);
                    t1=performance.now();
                }
                else if(selectedAlgo=="Triple DES"){
                    t0=performance.now();
                    encryptedImg=CryptoJS.TripleDES.encrypt(dataURL,encKey);
                    t1=performance.now();
                }
                else if(selectedAlgo=="Rabbit"){
                    t0=performance.now();
                    encryptedImg=CryptoJS.Rabbit.encrypt(dataURL,encKey);
                    t1=performance.now();
                }
                else{
                    t0=performance.now();
                    encryptedImg=CryptoJS.RC4.encrypt(dataURL,encKey);
                    t1=performance.now();
                }
                

                encTime=(t1-t0).toFixed(4);
                encryptedImgString= encryptedImg.toString();
                console.log(encryptedImgString);
                //Display encryption info
                $('#dd_encTime').html(encTime+' milliseconds');
                
            });

            //To send the enntire message with the encrypted image
            $('#brnSend').click(function(){
                var message={
                    from : "{{Auth::user()->email}}",
                    to : $('#msg_to').val(),
                    patient_name : $('#p_name').val(),
                    patient_age : parseInt($('#p_age').val()),
                    patient_gender : $('#p_gender').val(),
                    medical_image_type : $('#med_img_type').val(),
                    note : $('#msg_note').val(),
                    state : "unseen",
                    algorithm : $('#enc_algo').val(),
                    encrypted_image : encryptedImgString,
                    encryption_time : encTime ,
                    image_size : imageSize,
                    image_name : imageName
                };

                //Client side validation
                if(($('#msg_to').val()=="")||
                    ($('#p_name').val()=="")||
                    ($('#p_age').val()=="")||
                    ($('#p_gender').val()=="")||
                    ($('#med_img_type').val()=="")||
                    ($('#enc_algo').val()=="")||
                    (encryptedImgString=="")||
                    (encTime=="")||
                    (imageSize=="")||
                    (imageName=="")){
                        alert("Error: The message composition can not be sent. The form is not complete.");
                }
                else{
                    //sending the message to the database
                    $.ajax({
                        url: "http://localhost:8080/miems/public/api/message/store",
                        type: 'post',
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8',
                        data: JSON.stringify(message),
                        success: function (result) {
                            $(location).attr('href','/miems/public/message/sent');
                            
                        },
                        error: function (request, status, error) {
                            response=JSON.parse(request.responseText);
                            var msg=' Error: '+response.message;
                            alert(msg);
                        }
                    });
                }

            });

        });

    </script>
@endsection