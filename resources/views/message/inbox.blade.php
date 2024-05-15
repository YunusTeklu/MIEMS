@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h3>Inbox</h3>
        <hr>
        <table id="inboxList" class="table table-hover table-striped table-responsive-sm">
            <thead>
                <tr>
                    <td>From</td>
                    <td>Image Type</td>
                    <td>Recieved At</td>
                </tr>
            </thead>
            <tbody id="tableBody">
                
            </tbody>
        </table>
    <d/iv>


    <script>
        $(function () {
            
            $.ajax({
                url: "http://localhost:8080/miems/public/api/message/inboxList/{{Auth::user()->id}}",
                type: 'get',
                dataType: 'json',
                contentType: 'application/json',
                success: function (result) {
                    if(result[0].id!=""){
                        $('#tableBody').html('');
                        for(msg in result){
                            $('#tableBody').prepend(`
                                <tr onclick="window.location='/miems/public/message/detail/${result[msg].id}'">
                                    <td>${result[msg].from}</td>
                                    <td>${result[msg].medical_image_type}</td>
                                    <td>${result[msg].created_at}</td>
                                </tr>
                            `);
                        }
                    }
                    $('#inboxList').DataTable({
                        "aaSorting": []
                    });
                   
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