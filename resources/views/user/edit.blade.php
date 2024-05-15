@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header"><h3>Edit Profile</h3></div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <hr>
                <div class="row">
                    <div class="col-md-6">

                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label text-md-right">Name </label>
                            <div class="col-md-8">
                                <input type="text" id="user_name" class="form-control" placeholder="Name" value="{{Auth::user()->name}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_email" class="col-md-4 col-form-label text-md-right">Email Address </label>
                            <div class="col-md-8">
                                <input type="enail" id="user_email" class="form-control" placeholder="Email" value="{{Auth::user()->email}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_org" class="col-md-4 col-form-label text-md-right">Organization </label>
                            <div class="col-md-8">
                                <input type="text" id="user_org" class="form-control" placeholder="Organization" value="{{Auth::user()->organization}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_dept" class="col-md-4 col-form-label text-md-right">Department </label>
                            <div class="col-md-8">
                                @if(Auth::user()->department==null)
                                    <input type="text" id="user_dept" class="form-control" placeholder="Department">
                                @else
                                    <input type="text" id="user_dept" class="form-control" placeholder="Department" value="{{Auth::user()->department}}">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_pos" class="col-md-4 col-form-label text-md-right">Position </label>
                            <div class="col-md-8">
                                @if(Auth::user()->position==null)
                                    <input type="text" id="user_pos" class="form-control" placeholder="Position">
                                @else
                                    <input type="text" id="user_pos" class="form-control" placeholder="Position" value="{{Auth::user()->position}}">
                                @endif
                            </div>
                        </div>

                    </div>


                    <div class="col-md-6">

                        <div style="text-align:center;">
                            @if(Auth::user()->photo==null)
                                <img src="../storage/images/emptyperson.png" style="max-height: 200px; max-width: 200px;" id="photoDisplay" class="img-fluid rounded">
                            @else
                                <img src="../storage/images/{{Auth::user()->photo}}" style="max-height: 200px; max-width: 200px;" id="photoDisplay" class="img-fluid rounded">
                            @endif
                        </div>
                        </br>
                        
                        <div class="form-group row">
                            <label for="img_file" class="col-md-3 col-form-label text-md-right">Photo </label>
                            <div class="col-md-6">
                                <input type="file" id="photoSelector" name="photo" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="button" id="btnUpload" class="btn btn-primary" value="Upload Image" disabled>
                            </div>
                        </div>

                        <div style="text-align: center;">
                            <p id="uploadStatus" style="font-style:italic;"></p>
                        </div>
                        
                    </div>
                </div>
                
            </form>
        </div>
        <div class="card-footer" style="text-align: center;">
            <input type="button" id="btnSave" class="btn btn-primary" value="Save Changes">
        </div>
    </div>

    <script>

        var photoName=null;
        var photoFileName=null;

        //Enable the upload button for selecting pho
        $('#photoSelector').change(function(e){
            e.preventDefault();
            var image = e.target;
            photoName= image.files[0].name;

            if(photoName!=null){
                $('#btnUpload').prop("disabled",false);
            }

        });

        //Handling the photo upload
        $('#btnUpload').click(function(e){
                e.preventDefault();
                
                var photo = new FormData();
                var files = $('#photoSelector')[0].files[0];
                photo.append('photo',files);
                
                if($('#photoSelector').val().length){
                    $('#uploadStatus').text("Uploading Image...");
                    $.ajax({
                        url: "http://localhost:8080/miems/public/api/file/uploadImage",
                        type: 'post',
                        data: photo,
                        contentType: false,
                        processData: false,
                        success: function(result) {
                            if(result=="noimage.jpg"){
                                $('#uploadStatus').text("An error has occured please tryagain");
                            }else{
                                $('#uploadStatus').text("");
                                
                                var photoShow= document.getElementById('photoDisplay');
                                photoShow.src='../storage/images/'+result;
                                
                                //Assign file name to logoName
                                photoFileName=result;

                                $('#btnUpload').prop("disabled", true);
                                
                            }
                        },
                        error: function (request, status, error) {
                            response=JSON.parse(request.responseText);
                            message=' Error: '+response.message;
                            alert(message);
                            $('#btnUpload').prop("disabled", true);
                            $('#uploadStatus').text("");
                        }
                    });
                }else{
                    $('#uploadBtn').addClass('ui-state-disabled');
                    $('#uploadStatus').text("Please select an image first");
                }

        });

        //updating the profile
        $('#btnSave').click(function(){
            var profile={
                name: $('#user_name').val(),
                photo : photoFileName,
                organization: $('#user_org').val(),
                email: $('#user_email').val(),
                position: $('#user_pos').val(),
                department:$('#user_dept').val()
            };

            //Client-side validation
            if(($('#user_name').val()=="")||
                ($('#user_email').val()=="")||
                ($('#user_org').val()=="")){
                alert("The fields Name, Email and Organization can not be empty.");
            }else{
                //To save the changes and update the database
                var apiUrl="http://localhost:8080/miems/public/api/users/update/"+"{{Auth::user()->id}}";
                $.ajax({
                        url: apiUrl,
                        type: 'put',
                        dataType: 'json',
                        contentType: 'application/json; charset=utf-8',
                        data: JSON.stringify(profile),
                        success: function (result) {
                            $(location).attr('href','/miems/public/users/detail/{{Auth::user()->id}}');
                            
                        },
                        error: function (request, status, error) {
                            response=JSON.parse(request.responseText);
                            var msg=' Error: '+response.message;
                            alert(msg);
                        }
                    });
            }

        });

    </script>

@endsection