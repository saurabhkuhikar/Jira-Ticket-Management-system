@extends('layout.admin')
@section('content')

<div class="content-wrapper">
    <div class="content">
        <div class="container-fluid">
            <div class="row mb-2 content-header">
                <div class="col-sm-6">
                </div>
            </div>       
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <legend style="color: green; font-weight: bold;">View User Details
                            </legend>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table  table-bordered table-hover" style="width: 69%;">                            
                            <tbody>
                                <tr>
                                    <th scope="col">Full Name</th>
                                    <td>{{($userDataArr->name) ?? ""}}</td>                    
                                </tr>
                                <tr>
                                    <th scope="col">Email</th>
                                    <td>{{ ($userDataArr->email) ?? ""}}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Gender</th>
                                    <td>{{$genderArr[$userDataArr->gender] ?? ""}}</td>
                                </tr>
                                <tr>
                                <th scope="col">Role</th>
                                    <td>{{$userRoleArr[$userDataArr->role] ?? ""}}</td>  
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-md-6 pt-10">
                            <div class="form-group">
                                <a href="{{route('user_index')}}" class="btn btn-danger" type="submit">Back</a>
                                <a href="{{ route('user_edit',encrypt($userDataArr->id)) }}" class="btn btn-primary">Update</a>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('pagespecificscripts')


@stop