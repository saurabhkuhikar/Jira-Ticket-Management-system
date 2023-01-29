@extends('layout.admin')
@section('content')

<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
        <div class="row mb-2 content-header">
            <div class="col-sm-6">
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <legend style="color: green; font-weight: bold;">
                                Ticket List
                            </legend>
                        </div>            
                    </div>
                    <!-- /.card-header -->
                    <div class = "pt10-pl20">
                    @can('create-ticket', auth()->user())
                       <a href="{{route('ticket_add')}}" class="btn btn-info">Create Ticket</a>
                    @endcan
                    </div>
                    <div class="card-body ">
                        <!-- Alert message (start) -->
                        @if(Session::has('ticket_update'))
                            <div class="alert {{ Session::get('alert-class') }}">
                                {{ Session::get('ticket_update') }}
                            </div>
                        @endif
                        <!-- Alert message (end) -->
                        <table class="table table-bordered table-hover" width="100%">
                            <thead>
                                <tr class="text-center">
                                <th width="5%">Sr. No</th>
                                <th width="20%">Ticket No.</th>
                                <th width="20%">Dev Name</th>
                                <th width="20%">QA Name</th>
                                <th width="15%">Due Date</th>
                                <th width="5%">Status</th>
                                <th width="5%">Active</th>
                                <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sr = 1; ?>
                                @foreach ($ticketData as $user)  			   
                                <tr>
                                    <td class="text-center">{{ $sr++ }}</td>
                                    <td>{{ $user->ticket_no}}</td>
                                    <td>{{ $allUserList[$user->dev_user_id] ?? "" }}</td> 
                                    <td>{{ $allUserList[$user->qa_user_id] ?? "" }}</td> 
                                    <td>{{ $user->due_date }}</td> 
                                    <td>{{ $user->status }}</td> 
                                    <td class="text-center">
                                        <?php  
                                        $class = ($user->active == 1) ? "text-success" : "text-danger";                                           
                                        ?>
                                        <a href="#" user-data = "{{$user->id}}" user-status ="{{$user->active}}"  onClick="updateUser(this);" ><i class="fa fa-circle <?= $class ?>" title =" {{$userStatusArr[$user->active] }}" ></i></a>
                                    </td> 
                                    <td class="text-center">
                                        @can('update-ticket', auth()->user())
                                            <a href = "{{ route('ticket_edit',encrypt($user->id)) }}" role="button" class="" title="Edit" ><i class="fas fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                        @endcan
                                        @can('delete-ticket', auth()->user())
                                            <a href="{{ route('ticket_destroy',encrypt($user->id)) }}" role="button" class="" onClick="if(!confirm('Do you want to delete?')){ return false;}" title = "Delete" ><i class="fas fa-trash"></i></a>&nbsp;&nbsp;&nbsp;
                                        @endcan
                                        @can('view-ticket', auth()->user())
                                            <a href = "{{ route('ticket_view',encrypt($user->id)) }}" role="button" class="" title="View"><i class="fas fa-folder"></i></a>&nbsp;&nbsp;&nbsp;
                                        @endcan
                                        @can('assign-ticket', auth()->user())
                                            <a href = "{{ route('assign_ticket_add',encrypt($user->id)) }}" role="button" class="" title="Assigned user"><i class="fas fa-user"></i></a>   
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        {{ $ticketData->links() }}
                        </ul>
                    </div>
                    </div>
                    <!-- /.card -->           
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
    <!-- /.modal -->
@stop

@section('pagespecificscripts')
<script>
$(document).ready(function (){    
     
});

// function viweModal(obj) {
//     var dataURL = $(obj).attr('data-href');    
//     $('.modal-body').load(dataURL,function(){
//         $('.modal-title').html("View user");
//         $('#modal-default').modal({show:true});
//     })
// }
// function editModal(obj) {
//     var dataURL = $(obj).attr('data-href');        
//     $('.modal-body').load(dataURL,function(){
//         $('#modal-default').modal({show:true});
//     })
// }
function updateUser(obj) {

    var userId = $(obj).attr("user-data");
    var userStatus = $(obj).attr("user-status");
    var statusClass = "text-danger";
    if (!confirm('Do you want to change user status?')) {
       return false;
    }
    $.ajax({
        url: "{{route('user_status')}}",		
        type: 'POST',
        headers:{'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')},
        data: {'userId': userId,'userStatus':userStatus}  
    }).done(function (response) {
        var data = JSON.parse(response);        
        if (data.code == 200 && data.success == true) {
            if (data.status == 1) {
                statusClass = "text-success";
            }
            $(obj).html("<i class='fa fa-circle "+statusClass+"'></i>");
            $(obj).attr("title",data.value);
            $(obj).attr("user-status",data.status);
        }
    });
}


    
</script>
@stop