<!DOCTYPE HTML>
<html>

<head>
	<title>Oops Curd</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			// alert("working");
			var from = $("#user_form");
			$("#btn-add").click(function(e) {
				if (from.valid()) {
					// console.log($("#user_form")[0].checkValidity());
					if ($("#user_form")[0].checkValidity()) {
						e.preventDefault();
						$.ajax({
							url: "action.php",
							type: "POST",
							data: $("#user_form").serialize() + "&action=insert",
							success: function(response) {
								$('.close').click();
								alert(response);
								view();
							}
						})
					}
				}

			});

			//view code
			view();

			function view() {
				$.ajax({
					url: "action.php?action=view",
					type: "GET",
					success: function(response) {
						$(".viewdata").html(JSON.parse(response));
					}
				})

			}

			//update code
			$(document).on('click', '.update', function() {
				// var id
				// console.log($(this).data('id'));
				$.ajax({
					url: "action.php?action=edit&id=" + $(this).data('id'),
					type: "GET",
					success: function(response) {
						var data = JSON.parse(response);
						console.log(data);
						$("#u_id").val(data.id);
						$("#u_name").val(data.name);
						$("#u_email").val(data.email);
						$("#u_password").val(data.password);
						$("#u_mobile").val(data.mobile);
						$("#u_city").val(data.city);
						$("#" + data.gender).prop('checked', true);
						$("#" + data.marital_status).prop('checked', true);
						$("#u_date").val(data.date);
						var hobbys = data.hobby;
						for (let li of hobbys) {
							$("#u_" + li).prop('checked', true);

						}


					}
				});

			});
			$(document).on("click", "#update", function(e) {
				e.preventDefault();
				// console.log($("#update_form").serialize());
				if ($("#update_form").valid()) {
					$.ajax({
						url: "action.php",
						type: "POST",
						data: $("#update_form").serialize() + "&action=update",
						success: function(response) {

							// console.log($("#updateusermodal"));
							// $("#updateusermodal").toggle();
							$('.close').click();

							view();
							// alert(response);
						}
					})
				}

			});

			// delete code confirmation box open on click delete button
			$(document).on("click", ".delete", function() {
				let id = $(this).data('id');
				$("#id_d").val(id);

			});
			// confrimation boc submit button click
			$(document).on("click", "#delete", function() {
				let id = $("#id_d").val();

				$.ajax({
					url: "action.php?action=delete&id=" + id,
					type: "GET",


					success: function(response) {
						// $("#deleteusermodal").modal('hide');
						$('.close').click();

						view();
					}

				});
			});

			$("#user_form").validate({
				rules: {
					name: {
						required: true
					},
					email: {
						required: true,
						email: true
					},
					password: {
						required: true,
						minlength: 6,

					},
					mobile: {
						required: true,
						digits: true,
						minlength: 10,
						maxlength: 10,
					},
					city: {
						required: true
					},
					gender: {
						required: true,
					},
					marital_status: {
						required: true
					},
					date: {
						required: true,
					},
					hobby: {

						required: function(elem) {
							return $("input.select:checked").length > 0;
						}

					}

				},
				messages: {
					name: 'Please Enter Name.',
					email: {
						required: 'Please enter email address.',
						email: 'Please Enater valid email address.'
					},
					password: {
						required: 'Please enter password.',
						password: 'Please password min-maxlength  10.'
					},
					mobile: {
						required: "Mobile Number cannot be empty",
						digits: "Mobile number must contain only numbers from 0-9",
						minlength: "Mobile number must be 10 digits long",
						minlength: "Mobile number must be 10 digits long",
					},
					city: {
						required: 'Please select a city.'
					},
					gender: {
						required: 'Please Select a gender.'
					},
					marital_status: {
						required: 'Please Select marital_status.'
					},
					date: {
						required: "Date of Birth cannot be empty",

					},
					// hobby: {
					// 	required: "Please select at least one checkbox",
					// }
				},

				highlight: function(element) {
					$(element).css('background', '#ffdddd');
					$(".error").css('color', 'red');
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).css('background', '');
					$(element).removeClass("error");
					$(element).removeClass("warn");
				},
				errorPlacement: function(error, element) {
					if (element.is(":radio")) {
						error.appendTo(element.parents('.radio-error'));
					} else if (element.is(":checkbox")) {
						error.appendTo(element.parents('.checkbox-error'));
					} else { // This is the default behavior 
						error.insertAfter(element);
					}
				},

			});
			$("#update_form").validate({
				rules: {
					name: {
						required: true
					},
					email: {
						required: true,
						email: true
					},
					password: {
						required: true,
						minlength: 6,

					},
					mobile: {
						required: true,
						digits: true,
						minlength: 10,
						maxlength: 10,
					},
					city: {
						required: true
					},
					gender: {
						required: true,
					},
					marital_status: {
						required: true
					},
					date: {
						required: true,
					},
					// hobby: {

					// 	required: function(elem) {
					// 		return $("input.select:checked").length > 0;
					// 	}

					// }

				},
				messages: {
					name: 'Please Enter Name.',
					email: {
						required: 'Please enter email address.',
						email: 'Please Enater valid email address.'
					},
					password: {
						required: 'Please enter password.',
						password: 'Please password min-maxlength  10.'
					},
					mobile: {
						required: "Mobile Number cannot be empty",
						digits: "Mobile number must contain only numbers from 0-9",
						minlength: "Mobile number must be 10 digits long",
						minlength: "Mobile number must be 10 digits long",
					},
					city: {
						required: 'Please select a city.'
					},
					gender: {
						required: 'Please Select a gender.'
					},
					marital_status: {
						required: 'Please Select marital_status.'
					},
					date: {
						required: "Date of Birth cannot be empty",

					},
					// hobby: {
					// 	required: "Please select at least one checkbox",
					// }
				},

				highlight: function(element) {
					$(element).css('background', '#ffdddd');
					$(".error").css('color', 'red');
				},
				unhighlight: function(element, errorClass, validClass) {
					$(element).css('background', '');
					$(element).removeClass("error");
					$(element).removeClass("warn");
				},
				errorPlacement: function(error, element) {
					if (element.is(":radio")) {
						error.appendTo(element.parents('.radio-error'));
					} else if (element.is(":checkbox")) {
						error.appendTo(element.parents('.checkbox-error'));
					} else { // This is the default behavior 
						error.insertAfter(element);
					}
				},

			});
			// $(function() {
			// 	$('#date').datepicker();
			// });
		});
	</script>




</head>

<body>

	<?php
	include "database1.php";

	?>
	<div class="container">
		<p id="success"></p>
		<div class="table-wapper">
			<div class="table-title">
				<div class="row">
					<div class="col-md-6">
						<h2><b>User</b></h2>
					</div>
					<div class="col-md-6">
						<a href="#addusermodal" class="btn btn-success" data-bs-toggle="modal"><i class="material-icons"></i><span>Add data</span></a>
					</div>
				</div>
			</div>
			<table class="table table-stried table-hover">
				<thead>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Password</th>
					<th>Mobile</th>
					<th>City</th>
					<th>Gender</th>
					<th>Marital_status</th>
					<th>Dob</th>
					<th>HOBBY</th>
					<th>Action</th>
					</tr>
				</thead>
				<tbody class="viewdata">
					<?php

					?>
				</tbody>
			</table>
		</div>
	</div>

	<!-- add create data -->
	<div id="addusermodal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="user_form">
					<div class="modal-header">
						<h3 class="modal-title">Add user data</h3>
						<button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">*</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label> Name:</label>
							<input type="text" name="name" placeholder="Name" id="name" class="form-control">
						</div>
						<div class="form-group">
							<label> Email:</label>
							<input type="email" name="email" placeholder="Email" id="email" class="form-control">
						</div>
						<div class="form-group">
							<label> Password:</label>
							<input type="password" name="password" placeholder="Password" autocomplete="password" id="password" class="form-control">
						</div>
						<div class="form-group">
							<label> Mobile:</label>
							<input type="text" name="mobile" placeholder="Mobile" id="mobile" class="form-control">
						</div>
						<div class="form-group">
							<label> City:</label>
							<select name="city" id="city" class="form-control"><br>
								<option value="">Select city</option>
								<option value="surat">Surat</option>
								<option value="ahmedabad">Ahmedabad</option>
								<option value="baroda">Baroda</option>
							</select>
						</div>
						<div class="form-group radio-error">
							<label> Gender:</label>

							<input type="radio" name="gender" value="female">Female
							<input type="radio" name="gender" id="gender" value="male">Male
						</div>
						<div class="form-group radio-error">
							<label> Maital status:</label>
							<input type="radio" name="marital_status" value="singal" id="marital_status">singal
							<input type="radio" name="marital_status" value="meried">meried
						</div>
						<div class="form-group">
							<label> Dob:</label>
							<input type="date" name="date" id="date" class="form-control">
						</div>
						<div class="form-group chechbox-error">
							<label> Hobby:</label>
							<input type="checkbox" name="hobby[]" id="reading" value="reading">Reading
							<input type="checkbox" name="hobby[]" id="writing" value="writing">Writing
							<input type="checkbox" name="hobby[]" id="danceing" value="danceing">Danceing

						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" value="1" name="action">
						<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
						<button type="submit" class="btn btn-success" name="submit" value="submit" id="btn-add">Submit</button>
					</div>
				</form>

			</div>
		</div>
	</div>
	<!-- edit data -->
	<div id="updateusermodal" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form id="update_form">
					<div class="modal-header">
						<h3 class="modal-title">update user data</h3>
						<button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">*</button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="u_id" name="id">
						<div class="form-group">
							<label> Name:</label>
							<input type="text" name="name" placeholder="Name" id="u_name" class="form-control">
						</div>
						<div class="form-group">
							<label> Email:</label>
							<input type="email" name="email" placeholder="Email" id="u_email" class="form-control">
						</div>
						<div class="form-group">
							<label> Password:</label>
							<input type="password" name="password" placeholder="Password" autocomplete="password" id="u_password" class="form-control">
						</div>
						<div class="form-group">
							<label> Mobile:</label>
							<input type="text" name="mobile" placeholder="Mobile" id="u_mobile" class="form-control">
						</div>
						<div class="form-group">
							<label> City:</label>
							<select name="city" id="u_city" class="form-control"><br>
								<option value="">Select city</option>
								<option value="surat">Surat</option>
								<option value="ahmedabad">Ahmedabad</option>
								<option value="baroda">Baroda</option>
							</select>
						</div>
						<div class="form-group radio-error">
							<label> Gender:</label>
							<input type="radio" name="gender" id="male" value="male">Male
							<input type="radio" name="gender" id="female" value="female">Female
						</div>
						<div class="form-group">
							<label> Maital status:</label>
							<input type="radio" name="marital_status" id="singal" value="singal">singal
							<input type="radio" name="marital_status" id="meried" value="meried">meried
						</div>
						<div class="form-group">
							<label> Dob:</label>
							<input type="date" name="date" id="u_date" class="form-control">
						</div>
						<div class="form-group checkbox-error">
							<label> Hobby:</label>
							<input type="checkbox" name="hobby[]" id="u_reading" value="reading">Reading
							<input type="checkbox" name="hobby[]" id="u_writing" value="writing">Writing
							<input type="checkbox" name="hobby[]" id="u_danceing" value="danceing">Danceing

						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" value="2" name="action">
						<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
						<button type="submit" class="btn btn-info" id="update">Submit</button>
					</div>
				</form>

			</div>
		</div>
	</div>
	<div id="deleteusermodal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">
						<h3 class="modal-title">dalete user data</h3>
						<button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">*</button>
					</div>
					<div class="modal-body">
						<input type="hidden" id="id_d" name="id" class="form-control">
						<p> Are you sure delete this data.!</p>
						<p class="text-warning"><small>This action cannot be undone.</small></p>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
						<button type="button" class="btn btn-danger" id="delete">submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>



	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>