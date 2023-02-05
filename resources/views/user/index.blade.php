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
                                User List
                            </legend>
                        </div>            
                    </div>
                    <!-- /.card-header -->
                    <div class = "pt10-pl20">
                       <a href="{{route('user_add')}}" class="btn btn-info">Add User</a>
                    </div>
                    <div class="card-body ">
                        <!-- Alert message (start) -->
                        @if(Session::has('user_update'))
                            <div class="alert {{ Session::get('alert-class') }}">
                                {{ Session::get('user_update') }}
                            </div>
                        @endif
                        <!-- Alert message (end) -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="text-center">
                                <th width="3%">Sr. No</th>
                                <th width="20%">Name</th>
                                <th width="10%">email</th>
                                <th width="10%">Type</th>
                                <th width="3%">Status</th>
                                <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sr = 1; ?>
                                @foreach ($userData as $user)  			   
                                <tr>
                                    <td class="text-center">{{ $sr++ }}</td>
                                    <td>{{ $user->name}}</td>
                                    <td>{{ $user->email }}</td> 
                                    <td>{{ $userRoleArr[$user->role] }}</td> 
                                    <td class="text-center">
                                        <?php  
                                        $class = ($user->active == 1) ? "text-success" : "text-danger";                                           
                                        ?>
                                        <a href="#" user-data = "{{$user->id}}" user-status ="{{$user->active}}"  onClick="updateUser(this);" ><i class="fa fa-circle <?= $class ?>" title =" {{$userStatusArr[$user->active] }}" ></i></a>
                                    </td> 
                                    <td class="text-center">
                                            <a href="{{ route('user_destroy',encrypt($user->id)) }}" role="button" class="btn btn-danger" onClick="if(!confirm('Do you want to delete?')){ return false;}" title = "Delete" ><i class="fas fa-trash"></i></a>                                            
                                            <a href = "{{ route('user_view',encrypt($user->id)) }}" role="button" class="btn btn-secondary" title="View"  title = "View"><i class="fas fa-folder"></i></a>
                                            <a href = "{{ route('user_edit',encrypt($user->id)) }}" role="button" class="btn b btn-info" title="Edit" title = "Edit"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        {{ $userData->links() }}
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