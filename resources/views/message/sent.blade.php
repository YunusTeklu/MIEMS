@extends('layouts.app')

@section('content')
    <div class="p-4">
        <h3>Sent Messages</h3>
        <hr>
        <div class="table-responsive-sm">
            <table id="sentList" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td>To</td>
                        <td>Image Type</td>
                        <td>Recieved At</td>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    
                </tbody>
            </table>
        </div>
    <d/iv>

    <script>
        $(function () {
            
            

            $.ajax({
                url: "http://localhost:8080/miems/public/api/message/sentList/{{Auth::user()->id}}",
                type: 'get',
                dataType: 'json',
                contentType: 'application/json',
                success: function (result) {
                    if(result[0].id!=""){
                        $('#tableBody').html('');
                        for(msg in result){
                            $('#tableBody').prepend(`
                                <tr onclick="window.location='/miems/public/message/detail/${result[msg].id}'">
                                    <td>${result[msg].to}</td>
                                    <td>${result[msg].medical_image_type}</td>
                                    <td>${result[msg].created_at}</td>
                                </tr>
                            `);
                            
                        }    
                    }
                    $('#sentList').DataTable({
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