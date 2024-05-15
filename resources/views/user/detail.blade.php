@extends('layouts.app')

@section('content')
    <div class="text-center">

        @if(Auth::user()->id==$id)
            <h3>My Profile</h3>
            <a href="/miems/public/users/edit" class="btn btn-link">
                <span><i class="fas fa-user-edit"></i></span>Edit Profile</a>
            <a href="" class="btn btn-link" id="btnDelete">
                <span><i class="fas fa-trash"></i></span>Close Account</a>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    @if(Auth::user()->photo==null)
                        <img src="/miems/public/storage/images/emptyperson.png" style="height: 200px; width: 200px; margin:20px; border-radius: 50%; border: 2px solid white;"  class="img-fluid"/>
                    @else
                        <img src="/miems/public/storage/images/{{Auth::user()->photo}}" style="height: 200px; width: 200px; margin:20px; border-radius: 50%; border: 2px solid white;"  class="img-fluid"/>
                    @endif
                </div>

                <div class="col-md-6 text-left px-3">
                    
                    <table class="table table-hover table-striped table-responsive-sm">
                        <tr>
                            <td><h6>Name</h6></td>
                            <td><p>{{Auth::user()->name}}</p></td>
                        </tr>
                        <tr>
                            <td><h6>Email</h6></td>
                            <td><p>{{Auth::user()->email}}</p></td>
                        </tr>
                        <tr>
                            <td><h6>Organization</h6></td>
                            <td><p">{{Auth::user()->organization}}</p></td>
                        </tr>
                        <tr>
                            <td><h6>Department</h6></td>
                            <td><p>{{Auth::user()->department}}</p></td>
                        </tr>
                        <tr>
                            <td><h6>Position</h6></td>
                            <td><p>{{Auth::user()->position}}</p></td>
                        </tr>
                    </table>
                        
                </div>
            </div>
            
        @else
            <div id="others"></div>
        @endif
    </div>

    <script>
        //Get the user record of other users
        $(function(){
            if({{Auth::user()->id}}!={{$id}}){
                $.ajax({
                    url: "http://localhost:8080/miems/public/api/users/detailRecord/{{$id}}",
                    type: 'get',
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function (result) {
                        //To insert default picture
                        var imageName="emptyperson.png";
                        if(result.photo!=null){
                            imageName=result.photo;
                        }

                        $('#others').html(`
                            <h3>User Profile</h3>
                            <hr>

                            <div class="row">
                                <div class="col-md-6">
                                    <img src="/miems/public/storage/images/${imageName}" style="height: 200px; width: 200px; margin:20px; border-radius: 50%; border: 2px solid white;"  class="img-fluid"/>
                                </div>

                                <div class="col-md-6 text-left">
                                    <table class="table table-hover table-striped table-responsive-sm">
                                        <tr>
                                            <td><h6>Name</h6></td>
                                            <td><p>${result.name}</p></td>
                                        </tr>
                                        <tr>
                                            <td><h6>Email</h6></td>
                                            <td><p>${result.email}</p></td>
                                        </tr>
                                        <tr>
                                            <td><h6>Organization</h6></td>
                                            <td><p">${result.organization}</p></td>
                                        </tr>
                                        <tr>
                                            <td><h6>Department</h6></td>
                                            <td><p>${result.department}</p></td>
                                        </tr>
                                        <tr>
                                            <td><h6>Position</h6></td>
                                            <td><p>${result.position}</p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                        `);
                    },
                    error: function (request, status, error) {
                       response=JSON.parse(request.responseText);
                       var message=' Error: '+response.message;
                       alert(message);
                   }
                });
            }

            //To handle delete event
            $('#btnDelete').click(function(){
               var res= confirm("Are you sure you want to delete your user account ?\n If you press ok you will remove your account and the system will automatically log you out.");
               if(res==true){
                    $.ajax({
                        url: "http://localhost:8080/miems/public/api/users/delete/{{Auth::user()->id}}",
                        type: 'delete',
                        contentType: false,
                        processData: false,
                        success: function(result) {
                            
                        },
                        error: function (request, status, error) {
                            response=JSON.parse(request.responseText);
                            var message=' Error: '+response.message;
                            alert(message);
                        }
                    });
                    
               }

            });

        });
    </script>
    
@endsection