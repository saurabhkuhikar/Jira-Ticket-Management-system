@extends('layout.modalLayout')
@section('content')
    <!-- <div class="content-wrapper"> -->
        <div class="content">
            <div class="container-fluid">
                <div class="row mb-2 content-header">
                <div class="col-md-12">
				<div class="row">			
					<div class="col-md-2"></div>			
						<div class="card">
							<div class="card-header">
								<div class="card-title">
									<legend style="color: green; font-weight: bold;">
										Update User
									</legend>
								</div>
							</div>
							<div class="card-body">
								<!-- Alert message (start) -->
									@if(Session::has('user_update'))
										<div class="alert {{ Session::get('alert-class') }}">
											{{ Session::get('user_update') }}
										</div>
									@endif
								<!-- Alert message (end) -->
								<form role="form" action="{{route('user_update',[$usersData->id])}}" method="post" id="store" onSubmit="return false;">
									@csrf
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="first-name">First Name</label>
												<input type="text" id="name" name="first_name" class="{{ ($errors->apply->has('first_name'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Your Full Name" value="{{$usersData->first_name}}">
												@if ($errors->apply->has('first_name'))
													<span class="invalid-feedback">{{ $errors->apply->first('first_name') }}</span>
												@endif
											</div>
										</div>											
										<div class="col-md-6">
											<div class="form-group">
												<label for="first-name">Last Name</label>
												<input type="text" id="name" name="last_name" class="{{ ($errors->apply->has('last_name'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Your Full Name" value="{{$usersData->last_name}}">
												@if ($errors->apply->has('last_name'))
													<span class="invalid-feedback">{{ $errors->apply->first('last_name') }}</span>
												@endif
											</div>
										</div>											
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<div>
													<label for="lname">Gender:</label>
												</div>
												<div class="form-group">										
													<div class="custom-control custom-radio custom-control-inline">
														<input class="{{ ($errors->apply->has('gender'))?'is-invalid custom-control-input':'custom-control-input' }}" type="radio" value="male" id="male" name="gender" <?= ($usersData->gender == "male")?'checked':""?>>
														<label class="custom-control-label" for="male">Male</label>
													</div>
													<div class="custom-control custom-radio custom-control-inline">
														<input class="{{ ($errors->apply->has('gender'))?'is-invalid custom-control-input':'custom-control-input' }}" type="radio" value="female" id="female" name="gender" <?= ($usersData->gender == "female")?'checked':""?>>
														<label class="custom-control-label" for="female">Female</label>
													</div>																
													@if ($errors->apply->has('gender'))
													<span class="invalid-feedback" style="display:block;">{{ $errors->apply->first('gender') }}</span>
													@endif
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="last-name">Age</label>
												<input type="text" name="age" id="age" class="{{ ($errors->apply->has('age'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Your Age" value="{{$usersData->age}}" maxlength="3">
												@if ($errors->apply->has('age'))
													<span class="invalid-feedback">{{ $errors->apply->first('age') }}</span>
												@endif
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date of birth </label>
                                            <div class="input-group date" id="reservationdate">
                                                <input type="text" name="dob" class="{{ ($errors->apply->has('dob')) ? 'is-invalid form-control':'form-control'}}" data-target="#reservationdate" autocomplete="off" placeholder = "Select date of birth" value="{{$usersData->dob}}" />
                                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                                @if ($errors->apply->has('dob'))
                                                    <span class="invalid-feedback">{{ $errors->apply->first('dob') }}</span>
                                                @endif
                                            </div>
                                        </div>
										</div>
										<div class="col-md-6">	
											<div class="form-group">
												<label for="last-name">Phone Number</label>
												<input type="text" name="mobile_no" id="mobile_no" class="{{ ($errors->apply->has('mobile_no'))?'is-invalid form-control':'form-control' }}" placeholder="Enter Your Phone Number" value="{{$usersData->mobile_no}}"  maxlength="10">
												@if ($errors->apply->has('mobile_no'))
													<span class="invalid-feedback">{{ $errors->apply->first('mobile_no') }}</span>
												@endif
											</div>
										</div>
									</div>
									<div class="row">						
										<div class="col-md-6">
											<div class="form-group">
												<button class="btn btn-primary" type="submit">Update</button>
											</div>
										</div>
									</div>								
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
                </div>
            </div>
        </div>
    <!-- </div> -->
@stop

@section('pagespecificscripts')
<script>
$(document).ready(function (){
    var token =  $('meta[name = "csrf-token"]').attr('content');

	var Toast = Swal.mixin({
      toast: true,
      position: 'top-left',
      showConfirmButton: false,
      timer: 3000
    });

    $(function () {
		$.validator.setDefaults({
			submitHandler: function () {
				// alert( "Form successful submitted!" );
			}
		});
		$('#store').validate({
				rules: {
					first_name: {
						required: true
					},
					last_name: {
						required: true
					},
					gender: {
						required: true,
					},
					dob: {
						required: true,
					},
					age: {
						required: true,
						maxlength: 2,
						number:true
					},
					mobile_no: {
						required: true,
						maxlength: 10,
						number:true
					},
				},
				messages: {
					first_name: {
						required: "Please enter a first name"
					},
					last_name: {
						required: "Please enter a last name"
					},					
					age: {
						required: "Please enter your age",
						maxlength: "Age must be at least 2 digit long",
						number :"Age must be a number"
					},
					mobile_no: {
						required: "Please enter your phone Number",
						maxlength: "Your password must be at least 10 digit long"
					},
				},
				errorElement: 'span',
				errorPlacement: function (error, element) {
				error.addClass('invalid-feedback');
				element.closest('.form-group').append(error);
				},
				highlight: function (element, errorClass, validClass) {
				$(element).addClass('is-invalid');
				},
				unhighlight: function (element, errorClass, validClass) {
				$(element).removeClass('is-invalid');
				}
		});
	});


    $("#store").on("submit",function () {

		/*  */
        $.ajax({
            type: 'POST',
            url: `{{ url('/user/update/'.encrypt($usersData->id)) }}`,
            headers:{'X-CSRF-TOKEN': $('meta[name = "csrf-token"]').attr('content')},
            data : $(this).serialize()
        }).done(function (response) {
			var data = JSON.parse(response);  
            if (data.success == true) {
				Toast.fire({
					icon: 'success',
					title: 'User updated successfully'
				})
			}
            if (data.success == false) {
				Toast.fire({
					icon: 'error',
					title: 'User updated not updated.'
				})
			}
        });
    })

	/* date picker */
    $(function () {
        $('#reservationdate').datepicker({
            autoclose:true,
            format: 'yyyy-mm-dd'
        });
    });
});
</script>
@stop