@extends('layouts.app')

@section('content')

    <div  class="container-fluid">
        <h3>Message</h3>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h5>Message Content</h5>
                <br>
                <div id="msgDetail">

                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Image</div>
                    <div class="card-body">
                        
                        <div class="text-center">
                            <img src="{{asset('storage/images/nophoto.jpg')}}" style="height: 300px;" id="med_img" class="img-fluid rounded">
                        </div>
                        <br>

                        <div class="form-group text-center">
                            <label for="dec_key" class=" col-form-label ">Decryption (Secret) Key </label>
                            <div class="mx-4">
                                <input type="password" id="dec_key" class="form-control">
                            </div>
                        </div>
                        <div class="text-center">
                            <input type="button" id="btnDecrypt" class="btn btn-primary" value="Decrypt & Download">
                        <div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<div id="imgInfo"></div>

    <script>
        $(function(){

            var encryptedString=null;
            var algo=null;
            var imageName=null;
            var OrgImageSize=null;
            var encTime=null;

            //Getting message detail
            $.ajax({
                    url: "http://localhost:8080/miems/public/api/message/detailRecord/{{$id}}",
                    type: 'get',
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function (result) {
                        
                        encryptedString=result.encrypted_image;
                        algo=result.algorithm;
                        imageName=result.image_name;
                        OrgImageSize=result.image_size;
                        encTime=result.encryption_time;

                        $('#msgDetail').html(`
                            
                            <table class="table table-hover table-striped table-responsive-sm">
                                <tr>
                                    <td><h6>From</h6></td>
                                    <td><p>${result.from}</p></td>
                                </tr>
                                <tr>
                                    <td><h6>To</h6></td>
                                    <td><p>${result.to}</p></td>
                                </tr>
                                <tr>
                                    <td><h6>Patient Name</h6></td>
                                    <td><p">${result.patient_name}</p></td>
                                </tr>
                                <tr>
                                    <td><h6>Patient Age</h6></td>
                                    <td><p>${result.patient_age}</p></td>
                                </tr>
                                <tr>
                                    <td><h6>Patient Gender</h6></td>
                                    <td><p>${result.patient_gender}</p></td>
                                </tr>
                                <tr>
                                    <td><h6>Medical Image Type</h6></td>
                                    <td><p>${result.medical_image_type}</p></td>
                                </tr>
                                <tr>
                                    <td><h6>Note</h6></td>
                                    <td><p>${result.note}</p></td>
                                </tr>
                                
                            </table>

                        `);
                    },
                    error: function (request, status, error) {
                       response=JSON.parse(request.responseText);
                       var message=' Error: '+response.message;
                       alert(message);
                   }
            });

            //Convert DataURL to Blob after decryption
            function dataURItoBlob(dataURI) {
               
                // convert base64 to raw binary data held in a string
                // doesn't handle URLEncoded DataURIs - see SO answer #6850276 for code that does this
                var byteString = atob(dataURI.split(',')[1]);

                // separate out the mime component
                var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0]
                
                // write the bytes of the string to an ArrayBuffer
                var ab = new ArrayBuffer(byteString.length);

                // create a view into the buffer
                var ia = new Uint8Array(ab);

                // set the bytes of the buffer to the correct values
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }

                // write the ArrayBuffer to a blob, and you're done
                var blob = new Blob([ab], {type: mimeString});
                return blob;

            }

            //To decrypt the sent image
            $('#btnDecrypt').click(function(){
                var secretKey=$('#dec_key').val();
                var t1,t0,decryptedDataUrl=null;

                if(algo=="AES"){
                    t0=performance.now();
                    decryptedDataUrl=CryptoJS.AES.decrypt(encryptedString,secretKey).toString(CryptoJS.enc.Latin1);
                    t1=performance.now();
                }else if(algo=="DES"){
                    t0=performance.now();
                    decryptedDataUrl=CryptoJS.DES.decrypt(encryptedString,secretKey).toString(CryptoJS.enc.Latin1);
                    t1=performance.now();
                }else if(algo=="TripleDES"){
                    t0=performance.now();
                    decryptedDataUrl=CryptoJS.TripleDES.decrypt(encryptedString,secretKey).toString(CryptoJS.enc.Latin1);
                    t1=performance.now();
                }else if(algo=="Rabbit"){
                    t0=performance.now();
                    decryptedDataUrl=CryptoJS.Rabbit.decrypt(encryptedString,secretKey).toString(CryptoJS.enc.Latin1);
                    t1=performance.now();
                }else {
                    t0=performance.now();
                    decryptedDataUrl=CryptoJS.RC4.decrypt(encryptedString,secretKey).toString(CryptoJS.enc.Latin1);
                    t1=performance.now();
                }
                
                var decTime=(t1-t0).toFixed(4)+' millisecond';

                try{
                    //To create a new image file for the decrypted blob
                    var newBlob= dataURItoBlob(decryptedDataUrl);
                }catch(e){
                    alert("Error: The secret key is incorrect. Decryption Failed !");
                    throw new Error("Error: The secret key is incorrect. Decryption Failed !");
                    
                }

                var newImage = new Blob([newBlob], {
                  type: "image/*"
                });
               
                //To display the downloaded image in the page
                var fr=new FileReader();
                fr.onload=function(){
                    var newImg=document.getElementById('med_img');
                    newImg.src=fr.result;
                };
                fr.readAsDataURL(newImage);
                
                //To download the created image
                saveAs(newImage, imageName);

                //Displaying info about the file
                $('#imgInfo').html(`
                    <br>
                    <div class="card">
                        <div class="card-header">Image Information</div>
                        <div class="card-body row p-3">
                            <div class="col-md-6">
                                <dl>
                                    <dt>Image Name</dt>
                                    <dd>${imageName}</dd>
                
                                    <dt>Image Type</dt>
                                    <dd>${newImage.type}</dd>
                
                                    <dt>Origional Image Size</dt>
                                    <dd>${OrgImageSize+' Bytes'}</dd>
                                </dl>
                            </div>
                            <div class="col-md-6">
                                <dl>
                                    <dt>Downloaded Image Size</dt>
                                    <dd>${newImage.size+' Bytes'}</dd>
                                    
                                    <dt>Encryption time</dt>
                                    <dd>${encTime+' miliseconds'}</dd>

                                    <dt>Decryptopn time</dt>
                                    <dd>${decTime}</dd>
                                </dl>
                        </div>
                    </div>
                </div>
                `);

            });
        });
    </script>
@endsection