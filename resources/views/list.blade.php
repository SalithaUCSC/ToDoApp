<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <style type="text/css">
        body {
            font-family: 'Lato', sans-serif;
        }
    </style>
    <body>
    <div class="container" style="margin-top: 20px; min-height: 2000px;">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <h3 class="text-center">TO DO LIST APP</h3><br>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">TASKS <a id="addNewBtn" data-toggle="modal" data-target="#todoModal" class="pull-right"><i class="fa fa-plus"></i></a></h3>
                    </div>
                    <div class="panel-body" id="items">
                        <div class="list-group">
                            @foreach($items as $item)
                                <input type="hidden" id="itemId" value="{{ $item->id }}">
                                <li class="list-group-item taskItem" data-toggle="modal" data-id="{{ $item->id }}" data-target="#todoModal">{{ $item->item }}</li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
    <div class="modal fade" id="todoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top: 60px;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title" id="modTitle">Add New Task</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" >
                    <input type="text" placeholder="Add a task to the list" id="addTask" class="form-control">
                    <div id="error" style="color: #A61D1D; font-weight: bold;margin-top: 10px;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal" style="display: none;">Close</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" id="delBtn" style="display: none;">Delete</button>
                    <button type="button" class="btn btn-success btn-sm" data-dismiss="modal" id="saveBtn" style="display: none;">Save changes</button>
                    <button type="button" class="btn btn-primary btn-sm"  id="addBtn">Add Task</button>
                </div>
            </div>
        </div>
    </div>
    {{ csrf_field() }}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $(document).on('click', '.taskItem', function (event) {
                var text = $(this).text();
                $('#modTitle').text('Edit Task');
                $('#delBtn').show();
                $('#saveBtn').show();
                $('#addBtn').hide();
                $('#addTask').val(text);
                var id = $('#id').val($(this).attr("data-id"));
            });

            $(document).on('click', '#addNewBtn', function (event) {
                $('#modTitle').text('Add New Item');
                $('#delBtn').hide();
                $('#saveBtn').hide();
                $('#addBtn').show();
                $('#addTask').val('');
            });

            $('#addBtn').click(function (event) {
               var text = $('#addTask').val();
               if (text == ""){
                   $('#error').html('Task description is needed');$('#todoModal').show();
               }
               else{
                   $.post('list', {'text' : text, '_token' : $('input[name=_token]').val()}, function (data) {
                       console.log(data);
                       $('#todoModal').hide();
                       $('.modal-backdrop').remove();
                       $('#items').load(location.href + ' #items');
                   });
               }
            });

            $('#delBtn').click(function (event) {
                var id = $('#id').val();
                $.post('delete', {'id' : id, '_token' : $('input[name=_token]').val()}, function (data) {
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });

            $('#saveBtn').click(function (event) {
                var id = $('#id').val();
                var value = $('#addTask').val();
                $.post('update', {'id' : id, 'value' : value, '_token' : $('input[name=_token]').val()}, function (data) {
                    console.log(data);
                    $('#items').load(location.href + ' #items');
                });
            });
        });
    </script>
    </body>
</html>
