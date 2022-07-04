<style>
	.loader {
		display: inline-block;
  border: 2px solid #f3f3f3; /* Light grey */
  border-top: 2px solid red; /* Blue */
  border-radius: 50%;
  width: 12px;
  height: 12px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.form-error{
	color: red;
	font-size: 12px;
}
</style>

<div class="page-header bg1 page-title-transparent" style="background: url('<?php echo base_url("assets/img/banners/Contact-US.jpg"); ?>'); background-position: center;">
						<div class="container white">
								<div class="col-md-12">
										<h1 class="title">Contact Us</h1>
										<ul class="breadcrumb white">
												<li>
														<a href="<?php echo site_url('northbridge/') ?>">Home</a>
												</li>
												<li class="active">Contact Us</li>
										</ul>
								</div>
						</div>
				</div>
				<!-- page-header -->
				
				<section id="contact-us" class="pad-sec">
					<div class="container">
						<div class="row">
							<div class="col-md-12 contact-info">
								<div class="section-title">
										<h2 class="title">Get in Touch</h2>
								</div>
								<p class="text-center bottom-margin-40">If you would like to find out more about how we can help you, please give us a call or drop us an email. <br>We welcome your comments and suggestions about this website and/or any other issues that you wish to raise.</p>
								<div class="row text-center">
									<address class="col-sm-4 col-md-4">
										<i class="fa fa-map-marker i-9x icons-circle text-color light-bg hover-black"></i>
										<div class="title">Address</div>
										
										4/5 Cross Over Plaza, <br>Olayiwola Street Abule-Egba,<br> Lagos Nigeria.
									</address>
									<address class="col-sm-4 col-md-4">
										<i class="fa fa-microphone i-9x icons-circle text-color light-bg hover-black"></i>
										<div class="title">Phones</div>
										<div>Tel(1): 090 166 63287</div>
										<div>Tel(2): 091 329 03420</div>
									</address>
									<address class="col-sm-4 col-md-4">
										<i class="fa fa-envelope i-9x icons-circle text-color light-bg hover-black"></i>
										<div class="title">Email Addresses</div>
										<div><!-- Inquiries: --> <a href="mailto:info@northbridge-fire.com" class="email-link">info@northbridge-fire.com</a></div>
										<div><!-- Local Sales: --> <a href="mailto:northbridgefireo1@gmail.com" class="email-link">northbridgefireo1@gmail.com</a></div>
										
									</address>
								</div>
							</div>
						</div>
						<hr class="pad-10">
							<div class="row">
								<div class="col-md-4">
									<p class="form-message"></p>
									<div class="contact-form">
										<!-- Form Begins -->
										<form role="form" name="contact_form" id="contact_form" method="post" action="<?php echo site_url('northbridge/submit_contact_form') ?>">
										<!-- Field 1 -->
											<div class="input-text form-group">
													<input type="text" name="contact_name" id="contact_name" class="input-name form-control" placeholder="Full Name" />
													<span class="form-error"></span>
											</div>
											<!-- Field 2 -->
											<div class="input-email form-group">
													<input type="email" name="contact_email" id="contact_email" class="input-email form-control" placeholder="Email"/>
													<span class="form-error"></span>
											</div>
											<!-- Field 3 -->
											<div class="input-email form-group">
													<input type="number" name="contact_phone" id="contact_phone" class="input-phone form-control" placeholder="Phone"/>
													<span class="form-error"></span>
											</div>
											<div class="input-subject form-group">
													<input type="text" name="contact_subject" id="contact_subject" class="input-subject form-control" placeholder="Subject"/>
													<span class="form-error"></span>
											</div>
											<div class="input-services form-group">
												<select name="contact_services" id="contact_services" class="input-services form-control">
													<option value="">Select Service</option>
													<option value="fire_extinguishers">Fire Extinguishers</option>
													<option value="fire_equipment">Fire Equipment</option>
													<option value="fire_protection_systems">Fire Protection Systems</option>
													<option value="fire_alarms">Fire Alarms</option>
													<option value="fire_valves">Fire Valves</option>
													<option value="fire_hydrants">Fire Hydrants</option>
													<option value="fire_pumps">Fire Pumps</option>
													<option value="passive_fire_protection">Passive Fire Protection</option>
													<option value="fire_trucks">Fire Trucks</option>
													<option value="access_control_systems">Access Control Systems</option>
												</select>
												<span class="form-error"></span>
											</div>
											<!-- Field 4 -->
											<div class="textarea-message form-group">
												<textarea name="contact_message" id="contact_message" class="textarea-message hight-82 form-control" placeholder="Message" rows="2" ></textarea>
												<span class="form-error"></span>
											</div>
											<!-- Button -->
											<button class="btn btn-default btn-block white" type="submit"><span>Send Now</span> <div class="loader" style="display: none;"></div> <i  class="fa fa-send"></i></button>
										</form>
										<!-- Form Ends -->
									</div>
								</div>                      
								<div class="col-md-8">
									
														
										<iframe class="col-xs-12" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4027.031043365501!2d3.311004189325363!3d6.655251304912977!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103b96cd03836c1d%3A0x734e91359b0ca8ca!2s4%2C%205%20Olayiwola%20St%2C%20Ifako-Ijaiye%2C%20Lagos!5e0!3m2!1sen!2sng!4v1607761402805!5m2!1sen!2sng" width="" height="600" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
									<!-- </div> -->
										
								</div><!-- map -->
							</div>
						</section><!-- page-section -->

<script>
	$(document).ready(function () {
		$("#contact_form").submit(function (evt) {
	        evt.preventDefault();

	        
	        var me = $(this);
	        var form_data = $(this).serializeArray();

	        var url = $(this).attr("action");

	        var loader = me.find(".loader");
	        var send_icon = me.find(".fa-send");

	        send_icon.hide();
	        loader.show();
	        console.log(url)
          	console.log(form_data)
          	$.ajax({
            	url : url,
            	type : "POST",
            	responseType : "json",
            	dataType : "json",
            	data : form_data,
	            success : function (response) {
	              	send_icon.show();
	        		loader.hide();
	              
	              	console.log(response)
	              	if(response.success){
		                $.notify({
		                  message:"Success"
		                },{
		                    type : "success"  
		                });

		                setTimeout(function(){
		                	document.location.reload();
		                },1500)
	              	}else{
		                $.each(response.messages, function (key,value) {

		                	var element = me.find("#"+key);
		                  
		                  	element.closest('div.form-group')
		                          
		                          .find('.form-error').remove();
		                  	element.after(value);
		                  
		                });
		                $.notify({
		                  message:"Some Values Were Not Entered Correctly. Please Correct It"
		                 },{
		                    type : "warning"  
		                });
		            }
            	},error : function (jqXHR,error, errorThrown) {
          			send_icon.show();
        			loader.hide();
	              	$.notify({
		              message:"Sorry Something Went Wrong."
		            },{
		                type : "danger"  
		            });
            	}
          	});  
	    })

	})
</script>