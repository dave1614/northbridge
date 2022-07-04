<!DOCTYPE html>
<html>
<head>
	<title>Sign In</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="<?php echo base_url('assets/css/owl.carousel.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/owl.theme.default.css'); ?>">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
	<script src="<?php echo base_url('assets/js/jquery-3.0.0.js') ?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/css/animate.css') ?>">
	<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
	<link rel="stylesheet" href="<?php  echo base_url('assets/css/app.v1.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/login_styles.css'); ?>">
	
</head>
<body>
	<div class="section m-t-lg wrapper-md animated fadeInUp banner" >
		<main class="container aside-xl" style="padding-top: 0;">
			<section class="m-b-lg">
					
					<h1>Create Your Free Account</h1>
					
					
					<h4 style="color: red; font-style: italic; display: none;" id="ajax-error">Error! Something Went Wron Please Try Again Later</h4>
					<?php $attributes = array('id' => 'myForm') ?>
					<?php echo form_open('cloudhis/process_patient_sign_up',$attributes); ?>
						<div class="list-group">

							<div class="form-group">
								
								<label for="email">Enter Email Address: </label>
								<input type="email" id="email" name="email" class="form-control" required>
								<span class="form-error"></span>
							</div>

							<div class="form-group">
								
								<label for="country">Select Country: </label>
								<select name="country" id="country" class="form-control" onchange="changeStateAndCity()" required>
									<?php
										if(is_array($all_countries)){ 
											
											foreach($all_countries as $country){
												$country_name = $country->name;
												$country_code = $country->code;
												$country_id = $country->id;
									?>
									<option style="text-transform: capitalize;" value="<?php echo $country_id ?>" <?php if($country_code == "ng"){ echo "selected"; } ?>><?php echo $country_name; ?> (<?php echo $country_code; ?>)</option>
									<?php
											}
										}
									?>
								</select>
								<span class="form-error"></span>
							</div>
							
							<div class="form-group">
								
								<label for="region">Select State: </label>
								<select name="region" id="region" class="form-control" onchange="" required>
									<?php
										if(is_array($first_regions)){ 
											foreach($first_regions as $region){
												$region_name = $region->name;
												$country_id = $region->country_id;
												$region_id = $region->id;
									?>
									<option style="text-transform: capitalize;" value="<?php echo $region_id ?>"><?php echo $region_name; ?></option>
									<?php
											}
										}
									?>
								</select>
								<span class="form-error"></span>
							</div>

							
		
							<div class="form-group">
								
								<label for="user_name">Enter Username</label>
								<input type="text" id="user_name" name="user_name" class="form-control" required>
								<span class="form-error"></span>
							</div>

							<div class="form-group">
								
								<label for="pass" style="">Enter Password</label>
								<input type="password" id="pass" placeholder="" name="password" class="form-control"  required>
								<span class="form-error"></span>
							</div>
							<button type="submit" class="btn btn-lg btn-primary btn-block submit">
								<img src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>" alt="..." class="spinner">Register</button>
						
							<div class="text-center m-t m-b" style="color: white;">
								
								<p>Already Have An Account ?</p>
								<a href="<?php echo site_url('cloudhis') ?>" style="border: 1px solid grey; background: #fff;">Login Now</a>
							</div>
						</div>
						<input type="hidden" name="random_bytes" value='<?php echo bin2hex($this->encryption->create_key(16)); ?>' readonly>
					</form>
			</section>
			<!-- <input type="hidde"> -->
		</main>
		<script>
			$(document).ready(function(){
				$("#myForm").submit(function (evt) {
					evt.preventDefault();
					var url = $(this).attr("action");
					var form_data = $(this).serializeArray();
					$(".form-error").html("");
				      $(".spinner").show();
				      $(".submit").addClass("disabled");
				    $.ajax({
				        url : url,
				        type : "POST",
				        responseType : "json",
				        dataType : "json",
				        data : form_data,
				        success : function (response) {
				          console.log(response)
				           $(".spinner").hide();
				          $(".submit").removeClass("disabled");
				          if(response.success == true && response.successful == true){
				            document.location.assign("<?php echo site_url('cloudhis/cl_admin') ?>")
				          }else if(response.success == true && response.successful == false){
				            $.notify({
				            message:"Sorry Something Went Wrong"
				            },{
				              type : "warning"  
				            });
				          }
				          else{
				           $.each(response.messages, function (key,value) {

				            var element = $('#'+key);
				            
				            element.closest('div.form-group')
				                    
				                    .find('.form-error').remove();
				            element.after(value);
				            
				           });
				            $.notify({
				            message:"Some Values Where Not Valid. Please Enter Valid Values"
				            },{
				              type : "warning"  
				            });
				          }
				        },
				        error : function () {
				          $(".spinner").hide();
				          $(".submit").removeClass("disabled");
				          $.notify({
				          message:"Sorry Something Went Wrong. Please Check Your Internet Connection And Try Again"
				          },{
				            type : "warning"  
				          });
				        }
				    });
				})
			});
			function changeStateAndCity(evt){
				var country_id = $('#country').val();
				$.when(
					$.post("<?php echo site_url('cloudhis/get_regions') ?>","change_country_id=true&country_id=" + country_id,function(){
						// var states = states;
						
					}),

						
				).done(function (states,cities){
					$("#region").html(states);
					
				});
			}

			// function changeCity(){
			// 	var state_id = $('#region').val();
			// 	$.ajax({
			// 		url : "<?php echo site_url('cloudhis/get_cities') ?>",
			// 		dataType : "text",
			// 		type : "POST",
			// 		data : "get_cities=true&state_id=" + state_id ,
			// 		responseType : "any",
			// 		success : function(response){
			// 			// console.log(response)
			// 			$("#city").html(response);
			// 		},
			// 		error:function(err){
			// 			// $("#ajax-error").html(err);
			// 			$("#ajax-error").show();
			// 		}
			// 	});

			// }
		</script>
	
</div>
</body>
<script src="<?php echo base_url('assets/js/jquery-3.0.0.js') ?>"></script>
<script src="<?php echo base_url('assets/js/owl.carousel.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/bootstrap-notify.js')?> "></script>
</html>