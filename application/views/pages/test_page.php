<!DOCTYPE html>
<html>
<head>
	<title>Jspdf Test</title>
	<meta name="google-signin-client_id" content="354355175439-476beqc08q6k70an04u09gf63u852chm.apps.googleusercontent.com">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://apis.google.com/js/client:platform.js?onload=renderButton" async defer></script>
	<script>
		window.fbAsyncInit = function() {
		    // FB JavaScript SDK configuration and setup
		    FB.init({
		      appId      : '1246299548858182', // FB App ID
		      cookie     : true,  // enable cookies to allow the server to access the session
		      xfbml      : true,  // parse social plugins on this page
		      version    : 'v2.8' // use graph api version 2.8
		    });
		    
		    // Check whether the user already logged in
		    FB.getLoginStatus(function(response) {
		        if (response.status === 'connected') {
		            //display user data
		            getFbUserData();
		        }
		    });
		};

		// Load the JavaScript SDK asynchronously
		(function(d, s, id) {
		    var js, fjs = d.getElementsByTagName(s)[0];
		    if (d.getElementById(id)) return;
		    js = d.createElement(s); js.id = id;
		    js.src = "//connect.facebook.net/en_US/sdk.js";
		    fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));

		// Facebook login with JavaScript SDK
		function fbLogin() {
		    FB.login(function (response) {
		        if (response.authResponse) {
		            // Get and display the user profile data
		            getFbUserData();
		        } else {
		            document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
		        }
		    }, {scope: 'email'});
		}

		// Fetch the user profile data from facebook
		function getFbUserData(){
		    FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
		    function (response) {
		        document.getElementById('fbLink').setAttribute("onclick","fbLogout()");
		        document.getElementById('fbLink').innerHTML = 'Logout from Facebook';
		        document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.first_name + '!';
		        document.getElementById('userData').innerHTML = '<p><b>FB ID:</b> '+response.id+'</p><p><b>Name:</b> '+response.first_name+' '+response.last_name+'</p><p><b>Email:</b> '+response.email+'</p><p><b>Gender:</b> '+response.gender+'</p><p><b>Locale:</b> '+response.locale+'</p><p><b>Picture:</b> <img src="'+response.picture.data.url+'"/></p><p><b>FB Profile:</b> <a target="_blank" href="'+response.link+'">click to view profile</a></p>';
		    });
		}

		// Logout from facebook
		function fbLogout() {
		    FB.logout(function() {
		        document.getElementById('fbLink').setAttribute("onclick","fbLogin()");
		        document.getElementById('fbLink').innerHTML = '<img src="<?php echo base_url('assets/images/facebook_sign_in_btn.png') ?>"/>';
		        document.getElementById('userData').innerHTML = '';
		        document.getElementById('status').innerHTML = 'You have successfully logout from Facebook.';
		    });
		}

		function renderButton() {
		    gapi.signin2.render('gSignIn', {
		        'scope': 'profile email',
		        'width': 240,
		        'height': 50,
		        'longtitle': true,
		        'theme': 'dark',
		        'onsuccess': onSuccess,
		        'onfailure': onFailure
		    });
		}

		// Sign-in success callback
		function onSuccess(googleUser) {
		    // Get the Google profile data (basic)
		    //var profile = googleUser.getBasicProfile();
		    
		    // Retrieve the Google account data
		    gapi.client.load('oauth2', 'v2', function () {
		        var request = gapi.client.oauth2.userinfo.get({
		            'userId': 'me'
		        });
		        request.execute(function (resp) {
		            // Display the user details
		            var profileHTML = '<h3>Welcome '+resp.given_name+'! <a href="javascript:void(0);" onclick="signOut();">Sign out</a></h3>';
		            profileHTML += '<img src="'+resp.picture+'"/><p><b>Google ID: </b>'+resp.id+'</p><p><b>Name: </b>'+resp.name+'</p><p><b>Email: </b>'+resp.email+'</p><p><b>Gender: </b>'+resp.gender+'</p><p><b>Locale: </b>'+resp.locale+'</p><p><b>Google Profile:</b> <a target="_blank" href="'+resp.link+'">click to view profile</a></p>';
		            document.getElementsByClassName("userContent")[0].innerHTML = profileHTML;
		            
		            document.getElementById("gSignIn").style.display = "none";
		            document.getElementsByClassName("userContent")[0].style.display = "block";
		        });
		    });
		}

		// Sign-in failure callback
		function onFailure(error) {
		    console.log(error);
		}

		// Sign out the user
		function signOut() {
		    var auth2 = gapi.auth2.getAuthInstance();
		    auth2.signOut().then(function () {
		        document.getElementsByClassName("userContent")[0].innerHTML = '';
		        document.getElementsByClassName("userContent")[0].style.display = "none";
		        document.getElementById("gSignIn").style.display = "block";
		    });
		    
		    auth2.disconnect();
		}
	</script>
	<link href="<?php echo base_url('assets/css/treeflex.css') ?>" rel="stylesheet">
	<style>
    .tf-tree{
      text-align: center;
      /*cursor: col-resize;*/
    }
  
    .tf-tree .tf-nc .name{
      font-size: 13px;
    }

    .tf-tree .tf-nc {
      width: 120px;
      height: 220px;
      background: #fff;
      border: 0;
      border-radius: 4px;
      
      /*cursor: pointer;*/

    }

    .tf-tree .tf-nc .icons-div{
      /*margin-top: 10px;
      margin-bottom: 20px;*/
    }

    .tf-nc.business{
      border: 5px solid #89229b;
      box-shadow: 0 2px 6px 0 #89229b;
    }

    .tf-nc.basic{
      border: 5px solid #4caf50;
      box-shadow: 0 2px 6px 0 #4caf50;
    }

    .tf-nc.basic .package{
      color: #4caf50;
      text-transform: uppercase;
      font-weight: 700;
    }

    .tf-nc.business .package{
      color: #89229b;
      text-transform: uppercase;
      font-weight: 700;
    }
    .tf-nc .register-text{
      line-height: 200px;
      font-size: 19px;
      font-weight: bold;
    }

    .tf-nc.register{
      border: 5px solid #000;
    }

    .tf-tree .tf-nc .user-name{
      font-weight: bold;
      font-size: 12px;
    }

    .tf-custom .tf-nc:before,
    .tf-custom .tf-nc:after {
      /* css here */
    }

    .tf-custom li li:before {
      /* css here */
    }

    .spinner{
      display: none;
    }
  </style>
</head>
<body>
	<?php
		// $plain_text = 'This is a plain-text message!';
		// $ciphertext = $this->encryption->encrypt($plain_text);
		// echo $ciphertext . "<br>";
		// echo $this->encryption->decrypt($ciphertext);
		$this->allenexpress_model->genereateMortuaryFieldsString("packages");
		// $mobile_no = "07051942325";
		// $otp = 12567;
		// if($this->sabicapital_model->sendOtp($mobile_no,$otp)){
		// 	echo "sent successfully";
		// }

		// $url = "https://www.payscribe.ng/api/validate/multichoice/";
		// $use_post = true;
		// $post_data = array(
		// 	'multichoice_type' => "GOTV",
		// 	'smart_card_no' => "2009387651"
		// );
		// $response = $this->sabicapital_model->payscribeVtuCurl($url,$use_post,$post_data);
		// if($this->sabicapital_model->isJson($response)){
		// 	$response = json_decode($response);
		// 	if($response->status == true){
		// 		echo $response->message->details->productCode;
		// 		var_dump($response->message->details);
		// 	}
		// }	


		echo $this->sabicapital_model->getDataAmountByProductId(03,1000.01);

		
		// $otp = rand ( 10000 , 99999 );
		// $email = "ikechukwunwogo@gmail.com";
		// $email_arr = array($email);
		// if($this->sabicapital_model->sendOtpEmail($email_arr,$otp)){
		// 	echo "email sent successfully <br>";
		// }


		
	?>
	<?php var_dump($this->sabicapital_model->getIdsToCreditPlacement(52)) ?>
	<!-- <div class="tf-tree example"> -->
	<?php 
		
	?>
	<!-- </div> -->

	<!-- Display login status -->
	<div id="status"></div>

	<!-- Facebook login or logout button -->
	<a href="javascript:void(0);" onclick="fbLogin()" id="fbLink"><img src="<?php echo base_url('assets/images/facebook_sign_in_btn.png') ?>"/></a>

	<!-- Display user profile data -->
	<div id="userData"></div>
	<!-- Display Google sign-in button -->
	<div id="gSignIn"></div>

	<!-- Show the user profile details -->
	<div class="userContent" style="display: none;"></div>
	
	<img width="60" height="60" class="round" avatar="Hope Home Hospitals">

	<?php
		$monnify_base_url = "https://api.monnify.com";
		$transactionReference = "MNFY|20200617121133|000474";
		$transactionReferenceUrl = urlencode($transactionReference);
		$url = $monnify_base_url . "/api/v2/transactions/".$transactionReferenceUrl;
		// $url = urlencode($url);
		echo $url;
		$use_post = false;
		$accessToken = $this->sabicapital_model->getMonnifyAccessToken();
		echo $accessToken;
		if($accessToken != ""){
			$response = $this->sabicapital_model->monnifyFinalCurl($url, $use_post,$accessToken);
			echo $response;
			if($this->sabicapital_model->isJson($response)){
				$response = json_decode($response);
				var_dump($response);
			}
		}

		// $monnify_base_url = "https://api.monnify.com";
		// $url = $monnify_base_url . "/api/v1/bank-transfer/reserved-accounts";
		// $use_post = true;
		// $accessToken = $this->sabicapital_model->getMonnifyAccessToken();
		// if($accessToken != ""){
		// 	echo $accessToken . "<br>";
		// 	$accountReference = $this->sabicapital_model->generateReferenceForNewMonnifyAccount();
		// 	$post_data = [
		// 		"accountReference" => $accountReference,
		// 		"accountName" => "David Nwogo",
		// 		"currencyCode" => "NGN",
		// 		"contractCode" => "252367234964",
		// 		"customerEmail" => "ikechukwunwogo@mail.com",
		// 		"customerName" => "David Nwogo"
		// 	];

		// 	$response = $this->sabicapital_model->monnifyFinalCurl($url, $use_post,$accessToken, $post_data);
		// 	if($this->sabicapital_model->isJson($response)){
		// 		echo $response;
		// 		$response = json_decode($response);
		// 		if($response->requestSuccessful && $response->responseMessage == "success"){
		// 			var_dump($response->responseBody);
		// 		}
		// 	}
		// }
	// 
		// $type = "startimes";
		// $product_id = "04";
		// echo $this->sabicapital_model->getTvPackageCostByProductId($type,$product_id);
		// var_dump($this->sabicapital_model->getLocalGovernmentsByStateId(2507));
		// $list_of_locals_in_state = $this->sabicapital_model->getListOfLocalsInStateCommaSeeperated(2516);
		// var_dump($list_of_locals_in_state);
		// $expiry_date = "2019-08-11";

		// $now = time(); // or your date as well
		// echo $now . "<br>";
		// $your_date = strtotime($expiry_date);
		// echo $your_date . "<br>";
		// $datediff = $your_date - $now;

		// $datediff = $datediff / (60 * 60 * 24);
		// if($datediff >= 0){
		// 	echo "string";
		// }
		// echo $datediff;

		

		// $this->sabicapital_model->genereateDatabaseTableFieldsString("merchants_products_mini_importation");
		// $users = $this->sabicapital_model->getAllUsersLikeString();
		// if($this->sabicapital_model->updateAllPostsLikes($users)){
		// 	echo "done";
		// }
	?>

	 <?php
	 // $all_posts = $this->sabicapital_model->getAllPosts();
	 // if(is_array($all_posts)){
	 // 	foreach($all_posts as $row){
	 // 		$post_id = $row->id;
	 // 		$content = $row->content;
	 // 		$slug = strtolower(url_title(substr($content, 0,50)));
	 // 		$form_array = array(
	 // 			'slug' => $slug
	 // 		);
	 // 		$this->sabicapital_model->updatePost($form_array,$post_id);
	 // 	}
	 // }
	 // echo $this->sabicapital_model->getSocialMediaTime("10 Feb 2019","01:45:50pm");
	 // $date1 = strtotime("31 Mar 2019");
	 // $date1 = date("j M Y",$date1);

	 // $time1 = strtotime("08:00:00pm");
	 // $time1 = date("H:i:s",$time1);

	 // $date2 = strtotime("31 Mar 2019");
	 // $date2 = date("j M Y",$date2);

	 // $time2 = strtotime("05:00:10pm");
	 // $time2 = date("H:i:s",$time2);

	 // $curr_date = date("j M Y");
	 // $curr_time = date("H:i:s");

	 // $social_formated_time = "";

	 // $date_time1 = $date1 . " " . $time1;
	 // $date_time1 = new DateTime($date_time1);
	 // $date_time2 = $date2 . " " .$time2;
	 // $date_time2 = new DateTime($date_time2);

	 // $time_diff = $date_time1->getTimestamp() - $date_time2->getTimestamp();
	 // // echo $time_diff;

	 // //First Check If Time Is Greater Equal
	 // if($time_diff == 0){
	 // 	$social_formated_time = "Just Now";
	 // }else if($time_diff <= 60){
	 // 	$social_formated_time = $time_diff . " secs";
	 // }else if(($time_diff > 60) && ($time_diff < 3600)){
	 // 	$social_formated_time = floor($time_diff / 60);
	 // 	$social_formated_time = $social_formated_time . " mins";
	 // }else if(($time_diff >= 3600) && ($time_diff < 86400)){
	 // 	$social_formated_time = floor($time_diff / 3600);
	 // 	if($social_formated_time == 1){
		//  	$social_formated_time = $social_formated_time . " hour";
		// }else{
		// 	$social_formated_time = $social_formated_time . " hours";
		// }
	 // }else if(($time_diff >= 86400) && ($time_diff < 2628000)){
	 // 	$social_formated_time = floor($time_diff / 86400);
	 // 	if($social_formated_time == 1){
	 // 		$social_formated_time = $social_formated_time . " day";
	 // 	}else{
	 // 		$social_formated_time = $social_formated_time . " days";
	 // 	}
	 // }else if(($time_diff >= 2628000) && (date("Y",strtotime($date1)) == date("Y",strtotime($date2)))){
	 // 	$social_formated_time = date("j M",strtotime($date2));
	 // }else if ((date("Y",strtotime($date1)) !== date("Y",strtotime($date2)))) {
	 // 	$social_formated_time = date("j M Y",strtotime($date2));
	 // }
	 
	 // echo $social_formated_time;

	 // $last_two_weeks = strtotime("-1 month");
	 // $last_two_weeks = date("j M Y",$last_two_weeks);
	 // echo $last_two_weeks;
	 // if($last_two_weeks == "13 Nov 2018"){
	 // 	echo "string";
	 // }
	 // // echo $this->sabicapital_model->getUserTotalF
	 // $disable_otp = $this->paystack->curl("https://api.paystack.co/transfer/disable_otp",TRUE);
	 // $disable_otp = json_decode($disable_otp);
	 // if($disable_otp->status == true){
	 // 	echo "done";
	 // }

	 // $post_data = [
	 // 	"otp" => ''
	 // ];
	 // $disable_otp2 = $this->paystack->curl("https://api.paystack.co/transfer/disable_otp_finalize",TRUE);
	 // $disable_otp = json_decode($disable_otp);
	 // if($disable_otp->status == true){
	 // 	echo "done";
	 // }

	
	// $recepient = array('meetglobalresources@gmail.com');
	// $subject = "Test Email Subject";
	// $message = "";
	// $message .= '<!DOCTYPE html>';
	// $message .= '<html>';
	// $message .= '<head>';
	// $message .= '<title>Test</title>';
	// $message .= '<style type="text/css">';		
	// // $message .= require_once('bootstrap.css');
	// $message .= '</style>';
	// $message .= '</head>';
	// $message .= '<body>';
	// $message .= '<div class="container">';
	// $message .= '<div class="col-xs-6" style="height: 100px; color: blue">';
	// $message .= '<h2>Hello Everyone</h2>';
	// $message .= '</div>';
	// $message .= '</div>';
	// $message .= '</body>';
	// $message .= '</html>';
	
	// if($this->sabicapital_model->sendEmail($recepient,$subject,$message)){
	// 	echo "sent";
	// }
	$url = site_url('meetglobal/process_users');
	$use_post = FALSE;

	// $users_json = $this->sabicapital_model->custom_curl($url,$use_post);
	// if($this->sabicapital_model->isJson($users_json)){
	// 	$users = json_decode($users_json);
	// 	for($i = 0; $i < count($users); $i++){
	// 		$user_info = $users[$i];
	// 		$user_info = $this->sabicapital_model->objToArray($user_info);
	// 		$this->sabicapital_model->storeSuperForexUsers($user_info);
	// 	}
	// }





	?>

	<?php
	?>
<?php
?>
<?php
$fruits = array("d" => "lemon", "a" => "orange", "b" => "banana", "c" => "apple");
$fruitArrayObject = new ArrayObject($fruits);
$fruitArrayObject->asort();

foreach ($fruitArrayObject as $key => $val) {
    // echo "$key = $val\n";
}
// echo htmlspecialchars('<h2 class="fg-white">AboutUs</h2><pclass="fg-white">developing and supporting complex IT solutions.Touchingmillions of lives world wide by bringing in innovative technology </p>');
?>
	<div id="map"></div>
	<!-- <code>
		<?php echo $message; ?>
	</code>
 -->	<img src="<?php echo base_url('assets/images/56cf7edd4216cffc33ea64f3bac5ce6d_thumb.png') ?>" alt="">

	<form action="<?php echo site_url('meetglobal/index/test-ajax') ?>" id="paystack-form">
		<div class="form-group">
			<label for="first_name">FirstName: </label>
			<input type="text" class="form-control" id="first_name" name="first_name">
		</div>
		<div class="form-group">
			<label for="last_name">LastName: </label>
			<input type="text" class="form-control" id="last_name" name="last_name">
		</div>
		<div class="form-group">
			<label for="email">Email: </label>
			<input type="email" name="email" id="email" class="form-control">
		</div>
		<input type="submit" class="btn btn-default">
	</form>
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      $(document).ready(function () {
      	console.log("");

      	
      	$("#paystack-form").submit(function (evt) {
      		evt.preventDefault();
      		var form_data = $(this).serializeArray();
      		var url = $(this).attr("action");
      		$.ajax({
				url : url,
				type : "POST",
				responseType : "json",
				dataType : "json",
				data : form_data,
				success : function (response) {
					console.log(response)
				},
				error : function () {

				}
      		});
      	})
      })
      var map, infoWindow;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 6
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
    </script>
<!--Add External Libraries - JQuery and jspdf 
check out url - https://scotch.io/@nagasaiaytha/generate-pdf-from-html-using-jquery-and-jspdf
-->
	<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
	
	<script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBqwCCwgdlL1PelauMcK8hCGXACDzEMwWg&libraries=places&callback=initMap"></script>
	<script>
		function randomColorProperty (obj) {
	        var keys = Object.keys(obj)
	        return obj[keys[ keys.length * Math.random() << 0]];
	    }
	    function getKeyByValue(object, value) {
		  return Object.keys(object).find(key => object[key] === value);
		}

		$(document).ready(function () {

// This code is collected but useful, click below to jsfiddle link.
		var colours = {
                   "1" : "#1abc9c", "2" : "#2ecc71", "3" :"#3498db", "4" :"#9b59b6", "5" :"#34495e", "6" :"#16a085","7" : "#27ae60","8" : "#2980b9","9" : "#8e44ad", "10" :"#2c3e50", 
                    "11" :"#f1c40f", "12" :"#e67e22", "13" :"#e74c3c","14" : "#ecf0f1", "15" :"#95a5a6", "16" :"#f39c12","17" : "#d35400", "18" :"#c0392b", "19" :"#bdc3c7", "20" :"#7f8c8d"
                };
        var random_colour = randomColorProperty(colours);  
		console.log(random_colour);
		console.log(getKeyByValue(colours,random_colour));

		})
	</script>
	<script>
		
	</script>
	<script src="<?php echo base_url('assets/js/index (2).js')?> "></script>
</body>
</html>