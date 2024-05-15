@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h3>Users</h3>
        <hr>
        <table id="userList" class="table table-hover table-striped table-responsive-sm">
            <thead>
                <tr>
                    <td>Nane</td>
                    <td>Email</td>
                    <td>Organization</td>
                </tr>
            </thead>
            <tbody id="tableBody">
                
            </tbody>
        </table>
    <d/iv>
    

    <script>
        $(function () {
            
            $.ajax({
                url: "http://localhost:8080/miems/public/api/users/userList",
                type: 'get',
                dataType: 'json',
                contentType: 'application/json',
                success: function (result) {
                    if(result[0].id!=""){
                        $('#tableBody').html('');
                        for(user in result){
                            $('#tableBody').append(`
                                <tr onclick="window.location='users/detail/${result[user].id}'">
                                    <td>${result[user].name}</td>
                                    <td>${result[user].email}</td>
                                    <td>${result[user].organization}</td>
                                </tr>
                            `);
                        }
                    }
                    $('#userList').DataTable();
                },
                error: function (request, status, error) {
                       response=JSON.parse(request.responseText);
                       var message=' Error: '+response.message;
                       alert(message);
                }
            });
            
            
        });
    </script>
@endsection