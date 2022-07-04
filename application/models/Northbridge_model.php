<?php
	class Northbridge_model extends CI_Model{
		public function __construct (){
			parent::__construct();
			$this->load->database();
			$this->load->library('encryption');
			$this->load->library('session');
			$this->load->helper('cookie');
			$this->load->library('phpmailer_lib');
		}

		public function sendContactEmail($message_details){
			$recepient_arr = array('info@northbridge-fire.com');
					
			if($_SERVER['SERVER_NAME'] !== "localhost"){

				if(is_array($recepient_arr)){
					$contact_name = $message_details['contact_name'];
					$email = $message_details['email'];
					$contact_phone = $message_details['contact_phone'];
					$contact_subject = $message_details['contact_subject'];
					$contact_services = $message_details['contact_services'];
					$contact_message = $message_details['contact_message'];

					$subject = "New Contact Request From ". $contact_name;
					$message = "Name: " . $contact_name . "<br>";
					$message .= "Phone Number: " . $contact_phone . "<br>";
					$message .= "Subject: " . $contact_subject . "<br>";
					$message .= "Services Requested: " . $contact_services . "<br>";
					$message .= "Message: " . $contact_message;

					$mail = $this->phpmailer_lib->load();

			        // SMTP configuration
			        $mail->isSMTP();

			        // $mail->Host     = 'smtp.gmail.com';
			        // $mail->SMTPAuth = true;
			        // $mail->Username = 'easybizcoop@gmail.com';
			        // $mail->Password = 'Ogidifx@@123..';
			        // $mail->SMTPSecure = 'tsl';
			        // $mail->Port     = 587;
			        
			        // $mail->setFrom('easybizcoop@gmail.com', 'Meet Global Resources');

			        // $mail->Host     = 'smtp.gmail.com';
			        // $mail->SMTPAuth = true;
			        // $mail->Username = 'Sabicapitalresources@gmail.com';
			        // $mail->Password = 'ogidifx@@123...';
			        // $mail->SMTPSecure = 'tsl';
			        // $mail->Port     = 587;
			        
			        // $mail->setFrom('Sabicapitalresources@gmail.com', 'Meet Global Resources');

			        // $mail->Host     = 'smtp.gmail.com';
			        // $mail->SMTPAuth = true;
			        // $mail->Username = 'Ogididavis02@gmail.com';
			        // $mail->Password = 'treasure16';
			        // $mail->SMTPSecure = 'tsl';
			        // $mail->Port     = 587;
			        
			        // $mail->setFrom('Ogididavis02@gmail.com', 'Meet Global Resources');


			        // $mail->Host     = 'smtp.gmail.com';
			        // $mail->SMTPAuth = true;
			        // $mail->Username = 'ikechukwunwogo@gmail.com';
			        // $mail->Password = 'programmer';
			        // $mail->SMTPSecure = 'tsl';
			        // $mail->Port     = 587;
			        
			        // $mail->setFrom('ikechukwunwogo@gmail.com', 'Meet Global Resources');

			        // $mail->Host     = 'smtp.gmail.com';
			        // $mail->SMTPAuth = true;
			        // $mail->Username = 'meetgresources@gmail.com';
			        // $mail->Password = 'dave1614.';
			        // $mail->SMTPSecure = 'tsl';
			        // $mail->Port     = 587;
			        
			        // $mail->setFrom('meetgresources@gmail.com', 'Meet Global Resources');

			        $email_address = "info@northbridge-fire.com";
			        $password = "Terrytony@12";

			        // $email_address = "purehealthtoall@gmail.com";
			        // $password = "WealthyMan88";

			        // $mail->SMTPDebug = 2;

			     //    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				    // $mail->SMTPAuth = true;                               // Enable SMTP authentication
				    // $mail->Username = $email_address;                 // SMTP username
				    // $mail->Password = $password;                           // SMTP password
				    // $mail->SMTPSecure = 'tsl';                            // Enable TLS encryption, `ssl` also accepted
				    // $mail->Port = 587;                                    // TCP port to connect to
			        
			     //    $mail->setFrom($email_address, 'Sabicapital');


			        $mail->Host = 'localhost';  // Specify main and backup SMTP servers
				    $mail->SMTPAuth = true;                               // Enable SMTP authentication
				    $mail->Username = $email_address;                 // SMTP username
				    $mail->Password = $password;                           // SMTP password
				    $mail->SMTPSecure = 'pop3';                            // Enable TLS encryption, `ssl` also accepted
				    $mail->Port = 25;                                    // TCP port to connect to
			        
			        $mail->setFrom($email_address, $contact_name);
			        // $mail->addReplyTo('info@example.com', 'CodexWorld');
			        
			        // Add a recipient
			        for($i = 0; $i < count($recepient_arr); $i++){
				    	$to_email = $recepient_arr[$i];
				    	// if($this->checkIfEmailHasNotifEnabled($to_email)  && $this->checkIfEmailNotifIsEnabled()){
						    $mail->addAddress($to_email);     // Add a recipient
						// }
					}
			        
			      
			        // Email subject
			        $mail->Subject = $subject;
			        
			        // Set email format to HTML
			        $mail->isHTML(true);
			        
			        // Email body content
			        // $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
			        //     <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
			        $mail->Body = $message;
			        
			        // Send email
			        if(!$mail->send()){
			            // echo 'Message could not be sent.';
			            // echo 'Mailer Error: ' . $mail->ErrorInfo;
			            return false;
			        }else{
			            return true;
			        }
				}
			}else{
				return true;
			}
				
		}

		public function getPackageInfoByTrackingId($tracking_id){
			$query = $this->db->get_where('packages',array('tracking_id' => $tracking_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfTrackingIdIsValid($tracking_id){
			$query = $this->db->get_where('packages',array('tracking_id' => $tracking_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function editThisPackageStatus($form_array,$package_status_id){
			return $this->db->update('package_status',$form_array,array('id' => $package_status_id));
		}

		public function getPackageStatusInfoById($package_status_id){
			$query = $this->db->get_where('package_status',array('id' => $package_status_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function deletePackageStatus($package_status_id){
			return $this->db->delete('package_status',array('id' => $package_status_id));
		}

		public function addThisPackageStatus($form_array){
			return $this->db->insert("package_status",$form_array);
		}

		public function getPackageStatusesByPackageId($package_id){
			// $query = $this->db->get_where('package_status',array('package_id' => $package_id));
			$this->db->select("*");
			$this->db->from("package_status");
			$this->db->where("package_id",$package_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPackageParamById($param,$package_id){
			$query = $this->db->get_where('packages',array('id' => $package_id));
			if($query->num_rows() == 1){
				return $query->result()[0]->$param;
			}else{
				return false;
			}
		}

		public function updatePackage($form_array,$package_id){
			return $this->db->update('packages',$form_array,array('id' => $package_id));
		}

		public function deleteThisPackage($package_id){
			return $this->db->delete('packages',array('id' => $package_id));
		}

		public function editThisPackage($form_array,$package_id){
			return $this->db->update('packages',$form_array,array('id' => $package_id));
		}


		public function getPackageInfoByUserId($package_id){
			$query = $this->db->get_where('packages',array('id' => $package_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function addNewPackage($form_array){
			return $this->db->insert('packages',$form_array);
		}

		public function generateNewTrackingId(){
			$val = "";
			$val = bin2hex($this->encryption->create_key(16));
			$val = substr($val, 0, 8);
			
			if(!$this->checkIfThisTrackingIdHasBeenUsedBefore($val)){
				return $val;
			}else{
				$this->generateNewTrackingId();
			}
		}

		public function checkIfThisTrackingIdHasBeenUsedBefore($tracking_id){
			$query = $this->db->get_where("packages",array('tracking_id' => $tracking_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}


		public function getAllPackagesByPagination($page,$get_vars){
			$offset = $page * 10;
			$query_str = "SELECT * FROM `packages` WHERE `id` != 0";


			if(isset($get_vars['package_name'])){
				$package_name = $get_vars['package_name'];
				if($package_name != ""){
					$query_str .= " AND package_name LIKE '" . $package_name . "%' ";
				}
			}


			if(isset($get_vars['tracking_id'])){
				$tracking_id = $get_vars['tracking_id'];
				if($tracking_id != ""){
					$query_str .= " AND tracking_id = '" . $tracking_id . "'";
				}
			}

			if(isset($get_vars['length'])){
				$length = $get_vars['length'];
				if($length != ""){
					$query_str .= " AND length = " . $length;
				}
			}

			if(isset($get_vars['height'])){
				$height = $get_vars['height'];
				if($height != ""){
					$query_str .= " AND height = " . $height;
				}
			}

			if(isset($get_vars['width'])){
				$width = $get_vars['width'];
				if($width != ""){
					$query_str .= " AND width = " . $width;
				}
			}

			if(isset($get_vars['weight'])){
				$weight = $get_vars['weight'];
				if($weight != ""){
					$query_str .= " AND weight = " . $weight;
				}
			}


			if(isset($get_vars['origin_location'])){
				$origin_location = $get_vars['origin_location'];
				if($origin_location != ""){
					$query_str .= " AND origin_location LIKE '" . $origin_location . "%' ";
				}
			}

			if(isset($get_vars['destination_location'])){
				$destination_location = $get_vars['destination_location'];
				if($destination_location != ""){
					$query_str .= " AND destination_location LIKE '" . $destination_location . "%' ";
				}
			}

			if(isset($get_vars['package_owners_name'])){
				$package_owners_name = $get_vars['package_owners_name'];
				if($package_owners_name != ""){
					$query_str .= " AND package_owners_name LIKE '" . $package_owners_name . "%' ";
				}
			}


			if(isset($get_vars['status'])){
				$status = $get_vars['status'];
				if($status == "in_transit"){
					$query_str .= " AND delivered = 0 ";
				}else if($status == "all"){
					
				}else if($status == "delivered"){
					$query_str .= " AND delivered = 1 ";
				}else{
					$query_str .= " AND delivered = 0 ";
				}
			}else{
				$query_str .= " AND delivered = 0 ";
			}

			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}


			if(isset($get_vars['delivered_date'])){
				$delivered_date = $get_vars['delivered_date'];
				if($delivered_date != ""){
					$delivered_date = date("j M Y", strtotime($delivered_date));  
				}
				$query_str .= " AND delivered_date LIKE '" . $delivered_date . "%' ";
			}



			$query_str .= " ORDER BY `id` DESC LIMIT 10 OFFSET ". $offset;
			// echo $query_str;


			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getAllPackagesByPaginationNum($get_vars){
			$query_str = "SELECT * FROM `packages` WHERE `id` != 0";


			if(isset($get_vars['package_name'])){
				$package_name = $get_vars['package_name'];
				if($package_name != ""){
					$query_str .= " AND package_name LIKE '" . $package_name . "%' ";
				}
			}


			if(isset($get_vars['tracking_id'])){
				$tracking_id = $get_vars['tracking_id'];
				if($tracking_id != ""){
					$query_str .= " AND tracking_id = '" . $tracking_id . "'";
				}
			}

			if(isset($get_vars['length'])){
				$length = $get_vars['length'];
				if($length != ""){
					$query_str .= " AND length = " . $length;
				}
			}

			if(isset($get_vars['height'])){
				$height = $get_vars['height'];
				if($height != ""){
					$query_str .= " AND height = " . $height;
				}
			}

			if(isset($get_vars['width'])){
				$width = $get_vars['width'];
				if($width != ""){
					$query_str .= " AND width = " . $width;
				}
			}

			if(isset($get_vars['weight'])){
				$weight = $get_vars['weight'];
				if($weight != ""){
					$query_str .= " AND weight = " . $weight;
				}
			}


			if(isset($get_vars['origin_location'])){
				$origin_location = $get_vars['origin_location'];
				if($origin_location != ""){
					$query_str .= " AND origin_location LIKE '" . $origin_location . "%' ";
				}
			}

			if(isset($get_vars['destination_location'])){
				$destination_location = $get_vars['destination_location'];
				if($destination_location != ""){
					$query_str .= " AND destination_location LIKE '" . $destination_location . "%' ";
				}
			}

			if(isset($get_vars['package_owners_name'])){
				$package_owners_name = $get_vars['package_owners_name'];
				if($package_owners_name != ""){
					$query_str .= " AND package_owners_name LIKE '" . $package_owners_name . "%' ";
				}
			}


			if(isset($get_vars['status'])){
				$status = $get_vars['status'];
				if($status == "in_transit"){
					$query_str .= " AND delivered = 0 ";
				}else if($status == "all"){
					
				}else if($status == "delivered"){
					$query_str .= " AND delivered = 1 ";
				}else{
					$query_str .= " AND delivered = 0 ";
				}
			}else{
				$query_str .= " AND delivered = 0 ";
			}

			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}


			if(isset($get_vars['delivered_date'])){
				$delivered_date = $get_vars['delivered_date'];
				if($delivered_date != ""){
					$delivered_date = date("j M Y", strtotime($delivered_date));  
				}
				$query_str .= " AND delivered_date LIKE '" . $delivered_date . "%' ";
			}



			$query_str .= " ORDER BY `id` DESC";




			$query = $this->db->query($query_str);


			return $query->num_rows();
		}



		public function getApprovedSabiAcccountManagerRequestsByPagination($page,$get_vars){
			$offset = $page * 10;
			$query_str = "SELECT * FROM `sabi_account_manager` WHERE `approved` = 1";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['phone'])){
				$phone = $get_vars['phone'];
				$query_str .= " AND phone LIKE '" . $phone . "%' ";
			}

			if(isset($get_vars['email'])){
				$email = $get_vars['email'];
				$query_str .= " AND email LIKE '" . $email . "%' ";
			}

			if(isset($get_vars['start_capital'])){
				$start_capital = $get_vars['start_capital'];
				$query_str .= " AND start_capital LIKE '" . $start_capital . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}


			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}


			if(isset($get_vars['approved_date_time'])){
				$approved_date_time = $get_vars['approved_date_time'];
				if($approved_date_time != ""){
					$approved_date_time = date("j M Y", strtotime($approved_date_time));  
				}
				$query_str .= " AND approved_date_time LIKE '" . $approved_date_time . "%' ";
			}




			$query_str .= " ORDER BY `id` DESC LIMIT 10 OFFSET ". $offset;
			// echo $query_str;


			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getApprovedSabiAcccountManagerRequestsByPaginationNum($get_vars){
			$query_str = "SELECT * FROM `sabi_account_manager` WHERE `approved` = 1";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['phone'])){
				$phone = $get_vars['phone'];
				$query_str .= " AND phone LIKE '" . $phone . "%' ";
			}

			if(isset($get_vars['email'])){
				$email = $get_vars['email'];
				$query_str .= " AND email LIKE '" . $email . "%' ";
			}

			if(isset($get_vars['start_capital'])){
				$start_capital = $get_vars['start_capital'];
				$query_str .= " AND start_capital LIKE '" . $start_capital . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}


			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}


			if(isset($get_vars['approved_date_time'])){
				$approved_date_time = $get_vars['approved_date_time'];
				if($approved_date_time != ""){
					$approved_date_time = date("j M Y", strtotime($approved_date_time));  
				}
				$query_str .= " AND approved_date_time LIKE '" . $approved_date_time . "%' ";
			}



			$query_str .= " ORDER BY `id` DESC";


			$query = $this->db->query($query_str);

			return $query->num_rows();
		}

		public function declineSabiAccountManagerRequest($id){
			return $this->db->delete("sabi_account_manager",array('id' => $id));
		}


		public function approveSabiAccountManagerRequest($id){
			$date = date("j M Y");
			$time = date("h:i:sa");
			$date_time = $date . " " . $time;
			return $this->db->update("sabi_account_manager",array('approved' => 1,'approved_date_time' => $date_time),array('id' => $id));
		}


		public function getPendingSabiAcccountManagerRequestsByPagination($page,$get_vars){
			$offset = $page * 10;
			$query_str = "SELECT * FROM `sabi_account_manager` WHERE `approved` = 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['phone'])){
				$phone = $get_vars['phone'];
				$query_str .= " AND phone LIKE '" . $phone . "%' ";
			}

			if(isset($get_vars['email'])){
				$email = $get_vars['email'];
				$query_str .= " AND email LIKE '" . $email . "%' ";
			}

			if(isset($get_vars['start_capital'])){
				$start_capital = $get_vars['start_capital'];
				$query_str .= " AND start_capital LIKE '" . $start_capital . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}


			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}




			$query_str .= " ORDER BY `id` DESC LIMIT 10 OFFSET ". $offset;
			// echo $query_str;


			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPendingSabiAcccountManagerRequestsByPaginationNum($get_vars){
			$query_str = "SELECT * FROM `sabi_account_manager` WHERE `approved` = 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['phone'])){
				$phone = $get_vars['phone'];
				$query_str .= " AND phone LIKE '" . $phone . "%' ";
			}

			if(isset($get_vars['email'])){
				$email = $get_vars['email'];
				$query_str .= " AND email LIKE '" . $email . "%' ";
			}

			if(isset($get_vars['start_capital'])){
				$start_capital = $get_vars['start_capital'];
				$query_str .= " AND start_capital LIKE '" . $start_capital . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}


			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}



			$query_str .= " ORDER BY `id` DESC";


			$query = $this->db->query($query_str);

			return $query->num_rows();
		}

		public function makeSabiAccountManagerRequest($form_array){
			return $this->db->insert('sabi_account_manager',$form_array);
		}

		public function updateThisSignal($form_array,$id){
			return $this->db->update('superforex_signals',$form_array,array('id' => $id));
		}

		public function getSuperforexSignalInfoById($id){
			$query = $this->db->get_where('superforex_signals',array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function deleteThisSignal($id){
			return $this->db->delete('superforex_signals',array('id' => $id));
		}

		public function uploadNewSignal($form_array){
			return $this->db->insert('superforex_signals',$form_array);
		}

		public function getSuperforexSignalsForTheDay(){
			$query_str = "SELECT * FROM `superforex_signals` WHERE `id` != 0";

			$date = date("j M Y");
			
			
			$query_str .= " AND date LIKE '" . $date . "%' ";

			$query_str .= " ORDER BY `id` DESC";
			// echo $query_str;


			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function clearSabiAcademyRequest($id){
			return $this->db->update("sabi_academy_requests",array('cleared' => 1),array('id' => $id));
		}


		public function getSabiAcademyRequestsByPagination($page,$get_vars){
			$offset = $page * 10;
			$query_str = "SELECT * FROM `sabi_academy_requests` WHERE `cleared` = 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['phone'])){
				$phone = $get_vars['phone'];
				$query_str .= " AND phone LIKE '" . $phone . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}


			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date_time LIKE '" . $date . "%' ";
			}



			$query_str .= " ORDER BY `id` DESC LIMIT 10 OFFSET ". $offset;
			// echo $query_str;


			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}



		public function getSabiAcademyRequestsByPaginationNum($get_vars){
			$query_str = "SELECT * FROM `sabi_academy_requests` WHERE `cleared` = 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['phone'])){
				$phone = $get_vars['phone'];
				$query_str .= " AND phone LIKE '" . $phone . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}


			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date_time LIKE '" . $date . "%' ";
			}



			$query_str .= " ORDER BY `id` DESC";


			$query = $this->db->query($query_str);

			return $query->num_rows();
		}

		public function addRequestForSabiAcademy($form_array){
			return $this->db->insert('sabi_academy_requests',$form_array);
		}


		public function getAllDeclinedSuperforexWithdrawalRequestsForUser($user_id){
			$this->db->select("*");
			$this->db->from("withdraw_live_account_requests");
			$this->db->where("approved",0);
			$this->db->where("declined",1);
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function getAllApprovedSuperforexWithdrawalRequestsForUser($user_id){
			$this->db->select("*");
			$this->db->from("withdraw_live_account_requests");
			$this->db->where("approved",1);
			$this->db->where("declined",0);
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfSuperForexWithdrawalRequestIdIsValidForUser($id,$user_id){
			$query = $this->db->get_where('withdraw_live_account_requests',array('id' => $id,'user_id' => $user_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getAllPendingSuperforexWithdrawalsRequestsForUser($user_id){
			$this->db->select("*");
			$this->db->from("withdraw_live_account_requests");
			$this->db->where("approved",0);
			$this->db->where("declined",0);
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getWithdrawalHistoryForByPagination($page,$get_vars){
			$offset = $page * 10;
			$query_str = "SELECT * FROM `withdraw_live_account_requests` WHERE `user_id` != 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['amount'])){
				$amount = $get_vars['amount'];
				$query_str .= " AND amount LIKE '" . $amount . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}

			if(isset($get_vars['exchange_rate'])){
				$exchange_rate = $get_vars['exchange_rate'];
				$query_str .= " AND exchange_rate LIKE '" . $exchange_rate . "%' ";
			}

			if(isset($get_vars['status'])){
				$status = $get_vars['status'];
				if($status == "approved"){
					$query_str .= " AND approved LIKE '1%' ";
				}else if($status == "declined"){
					$query_str .= " AND declined LIKE '1%' ";
				}else if($status == "pending"){
					$query_str .= " AND approved LIKE '0%' AND declined LIKE '0%'";
				}
			}

			

			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}


			$query_str .= " ORDER BY `id` DESC LIMIT 10 OFFSET ". $offset;
			// echo $query_str;


			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function getWithdrawalHistoryForByPaginationNum($get_vars){
			$query_str = "SELECT * FROM `withdraw_live_account_requests` WHERE `user_id` != 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['amount'])){
				$amount = $get_vars['amount'];
				$query_str .= " AND amount LIKE '" . $amount . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}

			if(isset($get_vars['exchange_rate'])){
				$exchange_rate = $get_vars['exchange_rate'];
				$query_str .= " AND exchange_rate LIKE '" . $exchange_rate . "%' ";
			}

			if(isset($get_vars['status'])){
				$status = $get_vars['status'];
				if($status == "approved"){
					$query_str .= " AND approved LIKE '1%' ";
				}else if($status == "declined"){
					$query_str .= " AND declined LIKE '1%' ";
				}else if($status == "pending"){
					$query_str .= " AND approved LIKE '0%' AND declined LIKE '0%'";
				}
			}

			

			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}



			$query_str .= " ORDER BY `id` DESC";


			$query = $this->db->query($query_str);

			return $query->num_rows();
		}


		public function declineSuperforexWithdrawalRequest($reason,$id,$user_id,$date,$time){
			$date_time = $date . " " . $time;
			if($this->db->update('withdraw_live_account_requests',array('declined' => 1,'declined_date_time' => $date_time,'reason' => $reason),array('id' => $id))){

				$email = $this->getUserParamById("email",$user_id);

				$full_name = $this->getSuperForexWithdrawalRequestParamById("full_name",$id);
    			$amount = $this->getSuperForexWithdrawalRequestParamById("amount",$id);
    			
    			$super_forex_account_number = $this->getSuperForexWithdrawalRequestParamById("super_forex_account_number",$id);
    			$date_time = $this->getSuperForexWithdrawalRequestParamById("date",$id) . " " . $this->getSuperForexWithdrawalRequestParamById("time",$id);

    			// $amount_due = $amount * $exchange_rate;
				$title = "SuperForex Account Withdrawal Request Declined";
				$message = "Your Request To Withdraw From Your SuperForex Account With Following Details Has Been Declined. See Details Below.";
				$message .= "Full Name: <em class='text-primary'>".$full_name."</em><br>";
				$message .= "Amount: <em class='text-primary'>$".number_format($amount,2)."</em><br>";
				$message .= "SuperForex Acct. Number: <em class='text-primary'>".$super_forex_account_number."</em><br>";
				$message .= "Date / Time Of Request: <em class='text-primary'>".$date_time."</em><br>";
				
				$email = array($email);

				
				if($this->sendEmail($email,$title,$message,true)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function approveSuperforexWithdrawalRequest($id,$user_id,$date,$time){
			$date_time = $date . " " . $time;
			return $this->db->update('withdraw_live_account_requests',array('approved' => 1,'approved_date_time' => $date_time),array('id' => $id));
		}

		public function getPendingSuperforexWithdrawalRequestInfoById($id){
			$query = $this->db->get_where('withdraw_live_account_requests', array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result();;
			}else{
				return false;
			}
		}

		public function getSuperForexWithdrawalRequestParamById($param,$id){
			$query = $this->db->get_where('withdraw_live_account_requests', array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result()[0]->$param;
			}else{
				return false;
			}
		}

		public function checkIfSuperForexWithdrawalRequestIdIsValid($id){
			$query = $this->db->get_where('withdraw_live_account_requests',array('id' => $id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}


		public function addRequestToWithdrawFromSuperForexAccount($form_array){
			return $this->db->insert('withdraw_live_account_requests',$form_array);
		}

		public function checkIfPayentDetailsHaveInputed($user_id){
			$bank_name = $this->getUserParamById("bank_name",$user_id);
			$account_number = $this->getUserParamById("account_number",$user_id);

			if($bank_name != "" && $account_number != ""){
				return true;
			}else{
				return false;
			}
		}

		public function getAccountFundingHistoryForByPagination($page,$get_vars){
			$offset = $page * 10;
			$query_str = "SELECT * FROM `fund_live_account_requests` WHERE `user_id` != 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['amount'])){
				$amount = $get_vars['amount'];
				$query_str .= " AND amount LIKE '" . $amount . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}

			if(isset($get_vars['exchange_rate'])){
				$exchange_rate = $get_vars['exchange_rate'];
				$query_str .= " AND exchange_rate LIKE '" . $exchange_rate . "%' ";
			}

			if(isset($get_vars['status'])){
				$status = $get_vars['status'];
				if($status == "approved"){
					$query_str .= " AND approved LIKE '1%' ";
				}else if($status == "declined"){
					$query_str .= " AND declined LIKE '1%' ";
				}else if($status == "pending"){
					$query_str .= " AND approved LIKE '0%' AND declined LIKE '0%'";
				}
			}

			

			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}


			$query_str .= " ORDER BY `id` DESC LIMIT 10 OFFSET ". $offset;
			// echo $query_str;


			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getAccountFundingHistoryForByPaginationNum($get_vars){
			$query_str = "SELECT * FROM `fund_live_account_requests` WHERE `user_id` != 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['amount'])){
				$amount = $get_vars['amount'];
				$query_str .= " AND amount LIKE '" . $amount . "%' ";
			}

			if(isset($get_vars['super_forex_account_number'])){
				$super_forex_account_number = $get_vars['super_forex_account_number'];
				$query_str .= " AND super_forex_account_number LIKE '" . $super_forex_account_number . "%' ";
			}

			if(isset($get_vars['exchange_rate'])){
				$exchange_rate = $get_vars['exchange_rate'];
				$query_str .= " AND exchange_rate LIKE '" . $exchange_rate . "%' ";
			}

			if(isset($get_vars['status'])){
				$status = $get_vars['status'];
				if($status == "approved"){
					$query_str .= " AND approved LIKE '1%' ";
				}else if($status == "declined"){
					$query_str .= " AND declined LIKE '1%' ";
				}else if($status == "pending"){
					$query_str .= " AND approved LIKE '0%' AND declined LIKE '0%'";
				}
			}

			

			
			if(isset($get_vars['date'])){
				$date = $get_vars['date'];
				if($date != ""){
					$date = date("j M Y", strtotime($date));  
				}
				$query_str .= " AND date LIKE '" . $date . "%' ";
			}



			$query_str .= " ORDER BY `id` DESC";


			$query = $this->db->query($query_str);

			return $query->num_rows();
		}


		public function getAllDeclinedSuperforexDepositRequestsForUser($user_id){
			$this->db->select("*");
			$this->db->from("fund_live_account_requests");
			$this->db->where("approved",0);
			$this->db->where("declined",1);
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getAllApprovedSuperforexDepositRequestsForUser($user_id){
			$this->db->select("*");
			$this->db->from("fund_live_account_requests");
			$this->db->where("approved",1);
			$this->db->where("declined",0);
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function getAllPendingSuperforexDepositRequestsForUser($user_id){
			$this->db->select("*");
			$this->db->from("fund_live_account_requests");
			$this->db->where("approved",0);
			$this->db->where("declined",0);
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function approveSuperforexFundRequest($id,$user_id,$date,$time){
			$date_time = $date . " " . $time;
			return $this->db->update('fund_live_account_requests',array('approved' => 1,'approved_date_time' => $date_time),array('id' => $id));
		}

		public function declineSuperforexFundRequest($reason,$id,$user_id,$date,$time){
			$date_time = $date . " " . $time;
			if($this->db->update('fund_live_account_requests',array('declined' => 1,'declined_date_time' => $date_time,'reason' => $reason),array('id' => $id))){

				$email = $this->getUserParamById("email",$user_id);

				$full_name = $this->getSuperForexDepositRequestParamById("full_name",$id);
    			$amount = $this->getSuperForexDepositRequestParamById("amount",$id);
    			
    			$super_forex_account_number = $this->getSuperForexDepositRequestParamById("super_forex_account_number",$id);
    			$date_time = $this->getSuperForexDepositRequestParamById("date",$id) . " " . $this->getSuperForexDepositRequestParamById("time",$id);

    			// $amount_due = $amount * $exchange_rate;
				$title = "SuperForex Account Funding Declined";
				$message = "Your Request To Fund Your SuperForex Account With Following Details Has Been Declined. See Details Below.";
				$message .= "Full Name: <em class='text-primary'>".$full_name."</em><br>";
				$message .= "Amount: <em class='text-primary'>$".number_format($amount,2)."</em><br>";
				$message .= "SuperForex Acct. Number: <em class='text-primary'>".$super_forex_account_number."</em><br>";
				$message .= "Date / Time Of Request: <em class='text-primary'>".$date_time."</em><br>";
				
				$email = array($email);

				
				if($this->sendEmail($email,$title,$message,true)){
					return true;
				}else{
					return false;
				}
			}
		}

		public function getPendingSuperforexDepositRequestInfoById($id){
			$query = $this->db->get_where('fund_live_account_requests', array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result();;
			}else{
				return false;
			}
		}

		public function getSuperForexDepositRequestParamById($param,$id){
			$query = $this->db->get_where('fund_live_account_requests', array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result()[0]->$param;
			}else{
				return false;
			}
		}

		public function checkIfSuperForexDepositRequestIdIsValid($id){
			$query = $this->db->get_where('fund_live_account_requests',array('id' => $id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getPendingSuperforexDepositRequests(){
			$this->db->select("*");
			$this->db->from("fund_live_account_requests");
			$this->db->where("approved",0);
			$this->db->where("declined",0);
			$this->db->order_by("id","ASC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPendingSuperforexWithdrawalRequests(){
			$this->db->select("*");
			$this->db->from("withdraw_live_account_requests");
			$this->db->where("approved",0);
			$this->db->where("declined",0);
			$this->db->order_by("id","ASC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function addRequestToFundSuperForexAccount($form_array){
			return $this->db->insert('fund_live_account_requests',$form_array);
		}

		public function getFundingExchangeRate(){
			$query = $this->db->get_where("users",array('is_admin' => 1));
			if($query->num_rows() == 1){
				return $query->result()[0]->fund_exchange_rate;
			}
		}


		public function getWithdrawExchangeRate(){
			$query = $this->db->get_where("users",array('is_admin' => 1));
			if($query->num_rows() == 1){
				return $query->result()[0]->withdraw_exchange_rate;
			}
		}

		public function updateUserLiveAccountRequestAsSuccessful($user_id,$date,$time){
			$date_time = $date . " " . $time;
			return $this->db->update('live_account_requests',array('approved_time' => $date_time,'approved' => 1),array('user_id' => $user_id));
		}


		public function getUsersWhoRequestedForLiveAccountByOffset($page){
			
			$offset = $page * 10;
			$query_str = "SELECT * FROM `live_account_requests` WHERE `approved` = 0";

			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUsersWhoRequestedForLiveAccountByOffsetNum(){
			$query_str = "SELECT * FROM `live_account_requests` WHERE `approved` = 0";


			$query_str .= " ORDER BY `id` ASC";


			$query = $this->db->query($query_str);

			return $query->num_rows();
		}

		public function requestForLiveAccount($form_array){
			return $this->db->insert('live_account_requests',$form_array);
		}

		public function checkIfUserHasRequestedLiveAccountBefore($user_id){
			$query = $this->db->get_where('live_account_requests',array('user_id' => $user_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfAdminHasApprovedUsersRequestToOpenLiveAccount($user_id){
			$live_account_request_approved = $this->getUserParamById("live_account_request_approved",$user_id);
			if($live_account_request_approved == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserHasRequestedToOpenLiveAccount($user_id){
			$live_account_request = $this->getUserParamById("live_account_request",$user_id);
			if($live_account_request == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfFullUserDataHasBeenEnteredByUser($user_id){
			$full_name = $this->getUserParamById("full_name",$user_id);
			$phone = $this->getUserParamById("phone",$user_id);
			$email = $this->getUserParamById("email",$user_id);
			$dob = $this->getUserParamById("dob",$user_id);
			$address = $this->getUserParamById("address",$user_id);

			if($full_name != "" && $phone != "" && $email != "" && $dob != "" && $address != ""){
				return true;
			}else{
				return false;
			}
		}


		public function getPatientAge($dob){
			$val = "";
			$orig_date = $dob;

			$orig_date = date("j M Y h:i:sa",strtotime($orig_date));
			$orig_date = strtotime($orig_date);
			$curr_date = strtotime(date("j M Y h:i:sa"));
			$date_diff_secs = $curr_date - $orig_date;
			

			$seconds = $curr_date;
		        
		    $date_diff_seconds = $date_diff_secs;
		    
		    if($date_diff_seconds > 0){
		      $date_diff_minutes = floor($date_diff_seconds / 60);
		      $date_diff_hours = floor($date_diff_minutes / 60);
		      $date_diff_days = floor($date_diff_hours / 24);
		      $date_diff_weeks = floor($date_diff_days / 7);
		      $date_diff_months = floor($date_diff_weeks / 4.345);
		      $date_diff_years = floor($date_diff_months / 12);
		      
		      if($date_diff_minutes < 1){
		        $val = "";
		      }else if($date_diff_hours < 1){
		        $val = $date_diff_minutes . " minute(s)";
		      }else if($date_diff_days < 1){
		        $val = $date_diff_hours . " hour(s)";
		      }else if($date_diff_weeks < 1){
		        $val = $date_diff_days . " day(s)";
		      }else if($date_diff_months < 1){
		        $val = $date_diff_weeks . " week(s)";
		      }else if($date_diff_years < 1){
		        $val = $date_diff_months . " month(s)";
		      }else{
		        $val = $date_diff_years . " year(s)";
		      }
		    }else{
		      return false;
		    }

		    return $val;
		}


		public function getUsersPaginationByOffset($page,$get_vars){
			
			$offset = $page * 10;
			$query_str = "SELECT * FROM `users` WHERE `is_admin` = 0";


			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['user_name'])){
				$user_name = $get_vars['user_name'];
				$query_str .= " AND user_name LIKE '" . $user_name . "%' ";
			}

			if(isset($get_vars['phone'])){
				$phone = $get_vars['phone'];
				$query_str .= " AND phone LIKE '" . $phone . "%' ";
			}

			if(isset($get_vars['email'])){
				$email = $get_vars['email'];
				$query_str .= " AND email LIKE '" . $email . "%' ";
			}

			if(isset($get_vars['created_date'])){
				$created_date = $get_vars['created_date'];
    			if($created_date != ""){
					$created_date = date("j M Y", strtotime($created_date));  
				}
				$query_str .= " AND created_date LIKE '" . $created_date . "%' ";
			}



			$query_str .= " ORDER BY `id` ASC LIMIT 10 OFFSET ". $offset;


			$query = $this->db->query($query_str);

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}
		

		public function getUsersPaginationByOffsetNum($get_vars){
			$query_str = "SELECT * FROM `users` WHERE `is_admin` = 0";

			if(isset($get_vars['full_name'])){
				$full_name = $get_vars['full_name'];
				$query_str .= " AND full_name LIKE '" . $full_name . "%' ";
			}

			if(isset($get_vars['user_name'])){
				$user_name = $get_vars['user_name'];
				$query_str .= " AND user_name LIKE '" . $user_name . "%' ";
			}

			if(isset($get_vars['phone'])){
				$phone = $get_vars['phone'];
				$query_str .= " AND phone LIKE '" . $phone . "%' ";
			}

			if(isset($get_vars['email'])){
				$email = $get_vars['email'];
				$query_str .= " AND email LIKE '" . $email . "%' ";
			}

			if(isset($get_vars['created_date'])){
				$created_date = $get_vars['created_date'];
				if($created_date != ""){
					$created_date = date("j M Y", strtotime($created_date));  
				}
				$query_str .= " AND created_date LIKE '" . $created_date . "%' ";
			}



			$query_str .= " ORDER BY `id` ASC";


			$query = $this->db->query($query_str);

			return $query->num_rows();
		}

		public function getTotalNumberOfRegisteredUsers(){
			$query = $this->db->get_where('users',array('is_admin' => 0));
			return $query->num_rows();
		}

		public function checkIfThisMonnifyTransactionReferenceHasBeenUsedBefore($transactionReference){
			$query = $this->db->get_where('account_credit_history',array('payment_option' => 'monnify','reference' => $transactionReference));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfMonnifyTransactionReferenceIsValid($transactionReference){
			if($_SERVER['SERVER_NAME'] == "localhost"){
				$monnify_base_url = "https://api.monnify.com";
			}else{
				$monnify_base_url = "https://api.monnify.com";
			}
			$transactionReferenceUrl = urlencode($transactionReference);

			$url = $monnify_base_url . "/api/v2/transactions/".$transactionReferenceUrl;
			// $url = urlencode($url);
			// echo $url;
			$use_post = false;
			$accessToken = $this->allenexpress_model->getMonnifyAccessToken();
			// echo $accessToken;
			if($accessToken != ""){
				$response = $this->monnifyFinalCurl($url, $use_post,$accessToken, $post_data=[]);
				// echo $response;
				if($this->isJson($response)){
					$response = json_decode($response);
					// var_dump($response);
					if($response->requestSuccessful && $response->responseMessage == "success"){
						// echo "string";
						// echo $response->responseBody->transactionReference . "<br>";
						// echo $transactionReference . "<br>";
						// echo strcmp($response->responseBody->transactionReference, $transactionReference) . "<br>";
						if($response->responseBody->transactionReference == $transactionReference){
							// echo "string";
							return true;
						}else{
							return false;
						}
					}
				}
			}
		}

		public function getUserInfoByUserMonifyReference($monnify_account_reference){
			$query = $this->db->get_where('users',array('monnify_account_reference' => $monnify_account_reference));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function addMinifyAccountWebhookJsonData($json_post){
			return $this->db->insert('test_table',array('test' => $json_post));
		}

		public function getMonnifyAccountDetails($user_id){
			if($_SERVER['SERVER_NAME'] == "localhost"){
				$monnify_base_url = "https://api.monnify.com";
			}else{
				$monnify_base_url = "https://api.monnify.com";
			}

			$monnify_account_reference = $this->getUserParamById("monnify_account_reference",$user_id);

			$url = $monnify_base_url . "/api/v1/bank-transfer/reserved-accounts/" . $monnify_account_reference;
			$use_post = false;
			$accessToken = $this->allenexpress_model->getMonnifyAccessToken();
			if($accessToken != ""){
				$response = $this->monnifyFinalCurl($url, $use_post,$accessToken, $post_data=[]);
				return $response;
			}
		}

		public function checkIfMonnifyAccountReferenceIsSetForThisUserAndSetIfNot(){

			$user_id = $this->getUserIdWhenLoggedIn();
			if(!$this->checkIfMonnifyAccountReferenceIsSetForThisUser($user_id)){

				if($_SERVER['SERVER_NAME'] == "localhost"){
					$monnify_base_url = "https://api.monnify.com";
				}else{
					$monnify_base_url = "https://api.monnify.com";
				}

				$url = $monnify_base_url . "/api/v1/bank-transfer/reserved-accounts";
				$use_post = true;
				$accessToken = $this->allenexpress_model->getMonnifyAccessToken();
				if($accessToken != ""){
					$user_name = $this->getUserParamById("user_name",$user_id);
					$email = $this->getUserParamById("email",$user_id);
					$full_name = $this->getUserParamById("full_name",$user_id);

					$accountReference = $this->allenexpress_model->generateReferenceForNewMonnifyAccount();
					$post_data = [
						"accountReference" => $accountReference,
						"accountName" => $full_name,
						"currencyCode" => "NGN",
						"contractCode" => "252367234964",
						"customerEmail" => $email,
						"customerName" => $user_name
					];

					$response = $this->allenexpress_model->monnifyFinalCurl($url, $use_post,$accessToken, $post_data);
					if($this->allenexpress_model->isJson($response)){
						
						$response = json_decode($response);
						if($response->requestSuccessful && $response->responseMessage == "success"){
							$user_array = array('monnify_account_reference' => $accountReference);
							if($this->updateUserTable($user_array,$user_id)){
								return true;
							}
						}
					}
				}
			}
		}

		public function checkIfMonnifyAccountReferenceIsSetForThisUser($user_id){
			$query = $this->db->get_where('users',array('monnify_account_reference !=' => '','id' => $user_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function generateReferenceForNewMonnifyAccount(){
			$val = "";
			$val = bin2hex($this->encryption->create_key(16));
			
			if(!$this->checkIfThisMonifyAccountReferenceHasBeenUsedBefore($val)){
				return $val;
			}else{
				$this->generateReferenceForNewMonnifyAccount();
			}
		}

		public function checkIfThisMonifyAccountReferenceHasBeenUsedBefore($val){
			$query = $this->db->get_where('users',array('monnify_account_reference' => $val));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getMonnifyAccessToken(){
			$accessToken = "";
			if($_SERVER['SERVER_NAME'] == "localhost"){
				$monnify_base_url = "https://api.monnify.com";
			}else{
				$monnify_base_url = "https://api.monnify.com";
			}
			$url = $monnify_base_url . "/api/v1/auth/login";
			$use_post = true;

			$response = $this->allenexpress_model->monnifyInitCurl($url, $use_post, $post_data=[]);
			if($this->allenexpress_model->isJson($response)){
				$response = json_decode($response);
				if($response->requestSuccessful && $response->responseMessage == "success"){
					$accessToken = $response->responseBody->accessToken;
				}
			}
			return $accessToken;
		}

		public function monnifyInitCurl($url, $use_post, $post_data=[]){
	        $curl = curl_init();
	        
	        curl_setopt($curl, CURLOPT_URL, $url);
	        $encoded_str = base64_encode("MK_PROD_HASLF3ULE8:8CAARSR6YV8GUEZTMWHCYH6T82ELHEU8");
	        $authorization = 'Authorization: Basic ' . $encoded_str;
	        $headers = [$authorization];
	        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	        
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	        
	        if($use_post){
	            curl_setopt($curl, CURLOPT_POST, TRUE);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
	        }
	        //Modify this two lines to suit your needs
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	        $response = curl_exec($curl);
	        curl_close($curl);
	        
	        return $response;
	    
		}

		public function monnifyFinalCurl($url, $use_post,$authorization_val, $post_data=[]){
	        $curl = curl_init();
	        
	        curl_setopt($curl, CURLOPT_URL, $url);
	        $authorization = 'Authorization: Bearer ' . $authorization_val;
	        $headers = [$authorization,'Content-Type: application/json'];

	        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	        
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	        
	        if($use_post){
	            curl_setopt($curl, CURLOPT_POST, TRUE);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
	        }
	        //Modify this two lines to suit your needs
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	        $response = curl_exec($curl);
	        curl_close($curl);
	        
	        return $response;
	    
		}

		public function getAccountCreditHistoryForAllUsers($date){
			$this->db->select("*");
			$this->db->from("account_credit_history");
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getTotalAmountOfAccountCreditRecordsForAllUsersInADay($date){
			$sum = 0;
			$query = $this->db->get_where('account_credit_history',array('date' => $date));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$sum += $amount;
				}
			}
			return $sum;
		}


		public function getLastTimeOfAccountCreditRecordsForAllUsersInADay($date){
			

			$this->db->select("time");
			$this->db->from("account_credit_history");
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");
			$this->db->limit(1);

			$query = $this->db->get();
			if($query->num_rows() == 1){
				return $query->result()[0]->time;
			}

			return array_values(array_unique($ret_arr));
		}

		public function getNumberOfAccountCreditRecordsForAllUsersInADay($date){

			$query = $this->db->get_where('account_credit_history',array('date' => $date));
			return $query->num_rows();
		}

		public function getDaysOfAccountCreditHistoryForAllUsers(){
			$ret_arr = array();

			$this->db->select("date");
			$this->db->from("account_credit_history");
			// $this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$date = $row->date;
					$ret_arr[] = $date;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function refundFundsAndMarkAsRefunded($order_id){
			$query = $this->db->get_where('vtu_transactions',array('order_id' => $order_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$user_id = $row->user_id;
					$refunded = $row->refunded;

					if($refunded == 0){

						$query = $this->db->update('vtu_transactions',array('refunded' => 1),array('order_id' => $order_id));
						if($query){
							if($this->creditUser($user_id,$amount)){
								return true;
							}
						}else{
							return false;
						}
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}

		public function getVtuTransactionParamByOrderId($param,$order_id){
			$query = $this->db->get_where('vtu_transactions',array('order_id' => $order_id));
			if($query->num_rows() == 1){
				return $query->result()[0]->$param;
			}else{
				return false;
			}
		}

		public function getVtuDataBundleCostByProductId($type,$product_id){
			$url = "https://www.nellobytesystems.com/APIQueryV1.asp?UserID=CK10153218&APIKey=UYV68HTPI15IFS0T8C94HC55PP7UCK44E11O033OAAEW7604BM3S7N50EE483649&OrderID=6322187656";
			$url = "https://www.nellobytesystems.com/APIDatabundlePlansV1.asp";
			$use_post = true;
			$amount = 0;

			

			$response = $this->allenexpress_model->vtu_curl($url,$use_post,$post_data=[]);
			
			if($this->allenexpress_model->isJson($response)){
				$response = json_decode($response);
				if(is_object($response)){
					if($type == "mtn-data"){
						$network = "MTN";
						$bundles = $response->MOBILE_NETWORK->MTN[0]->PRODUCT;
					}else if($type == "glo-data"){
						$network = "Glo";
						$bundles = $response->MOBILE_NETWORK->Glo[0]->PRODUCT;
					}else if($type == "airtel-data"){
						$network = "Airtel";
						$bundles = $response->MOBILE_NETWORK->Airtel[0]->PRODUCT;
					}else if($type == "9mobile-data"){
						$network = "9mobile";
						$bundles = $response->MOBILE_NETWORK->{'9mobile'}[0]->PRODUCT;
					}

					for($i = 0; $i < count($bundles); $i++){
						$PRODUCT_ID = $bundles[$i]->PRODUCT_ID;
						if($PRODUCT_ID == $product_id){
							$amount = $bundles[$i]->PRODUCT_AMOUNT;
							break;
						}
					}
				}
			}

			return $amount;
		}

		public function getDataAmountByProductId($mobilenetwork_code,$product_id){
			if($mobilenetwork_code == "01"){
				$network = "MTN";
			}else if($mobilenetwork_code == "02"){
				$network = "Glo";
			}else if($mobilenetwork_code == "03"){
				$network = "9mobile";
			}else if($mobilenetwork_code == "04"){
				$network = "Airtel";
			}
			$ret = false;
			$url = "https://www.nellobytesystems.com/APIDatabundlePlansV1.asp";
			$use_post = true;

			$response = $this->vtu_curl($url,$use_post,$post_data=[]);

			if($this->isJson($response)){
				$response = json_decode($response);
				if(is_object($response)){
					$array_of_bundles = $response->MOBILE_NETWORK->$network[0]->PRODUCT;
					if(is_array($array_of_bundles)){
						for($i = 0; $i < count($array_of_bundles); $i++){
							$val = $array_of_bundles[$i]->PRODUCT_ID;
							// echo $val . "<br>";
							if($val == $product_id){
								$ret = $array_of_bundles[$i]->PRODUCT_NAME;
								break;
							}
						}
					}
				}
			}
			return $ret;	

		}

		public function buyPowerVtuCurl($url, $use_post, $post_data=[]){
	        $curl = curl_init();
	        
	        curl_setopt($curl, CURLOPT_URL, $url);
	        $headers = [
    			'Authorization: Bearer df3f813b8dc7d9488535e7ea415d46e552f6e23f2da736e24eb9dae2700c5393',
    			'Content-Type: application/json'
    		];
	        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	        
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	        
	        if($use_post){
	            curl_setopt($curl, CURLOPT_POST, TRUE);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
	        }
	        //Modify this two lines to suit your needs
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	        $response = curl_exec($curl);
	        curl_close($curl);
	        
	        return $response;
	    
		}


		public function testSendEmail($email_address,$password){
			$recepient_arr = array('ikechukwunwogo@gmail.com');
			$subject = "Testing Email Service";
			$message = "This Is Just To Test The Email Service";


			if(count($recepient_arr) > 0){

				if($message !== ""){
					$message = "<h3 style='text-transform:capitalize;'>" . $message . "</h3>";
					$year = date("Y");
					$message .= "<h5><a href='Sabicapitalresources.com'>Sabicapital Resources</a> &copy; " . $year . ". All Rights Reserved</h5>";
				}
				if($_SERVER['SERVER_NAME'] !== "localhost"){

					if(is_array($recepient_arr)){

						$mail = $this->phpmailer_lib->load();
    
				        // SMTP configuration
				        $mail->isSMTP();



				        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
					    $mail->SMTPAuth = true;                               // Enable SMTP authentication
					    $mail->Username = $email_address;                 // SMTP username
					    $mail->Password = $password;                           // SMTP password
					    $mail->SMTPSecure = 'tsl';                            // Enable TLS encryption, `ssl` also accepted
					    $mail->Port = 587;                                    // TCP port to connect to
				        
				        $mail->setFrom($email_address, 'Meet Global Resources');

				        // $mail->addReplyTo('info@example.com', 'CodexWorld');
				        
				        // Add a recipient
				        for($i = 0; $i < count($recepient_arr); $i++){
					    	$to_email = $recepient_arr[$i];
					    	// if($this->checkIfEmailHasNotifEnabled($to_email)  && $this->checkIfEmailNotifIsEnabled()){
							    $mail->addAddress($to_email);     // Add a recipient
							// }
						}
				        
				      
				        // Email subject
				        $mail->Subject = $subject;
				        
				        // Set email format to HTML
				        $mail->isHTML(true);
				        
				        // Email body content
				        // $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
				        //     <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
				        $mail->Body = $message;
				        
				        // Send email
				        if(!$mail->send()){
				            // echo 'Message could not be sent.';
				            // echo 'Mailer Error: ' . $mail->ErrorInfo;
				            return $mail->ErrorInfo;
				        }else{
				            return true;
				        }
					}
				}else{
					return true;
				}
			}else{
				return true;
			}
			
		}


		public function sendEmail($recepient_arr,$subject,$message,$otp = FALSE){
			if($otp){


				//Then Filter It To Those Who Have Email Notifications Enabled
				// $recepient_arr = $this->filterSubEmails($recepient_arr);
				if(count($recepient_arr) > 0){

					if($message !== ""){
						$message = "<h3 style='text-transform:capitalize;'>" . $message . "</h3>";
						$year = date("Y");
						$message .= "<h5><a href='http://sabicapital.com'>Sabicapital</a> &copy; " . $year . ". All Rights Reserved</h5>";
					}
					if($_SERVER['SERVER_NAME'] !== "localhost"){

						if(is_array($recepient_arr)){

							$mail = $this->phpmailer_lib->load();
        
					        // SMTP configuration
					        $mail->isSMTP();

					        // $mail->Host     = 'smtp.gmail.com';
					        // $mail->SMTPAuth = true;
					        // $mail->Username = 'easybizcoop@gmail.com';
					        // $mail->Password = 'Ogidifx@@123..';
					        // $mail->SMTPSecure = 'tsl';
					        // $mail->Port     = 587;
					        
					        // $mail->setFrom('easybizcoop@gmail.com', 'Meet Global Resources');

					        // $mail->Host     = 'smtp.gmail.com';
					        // $mail->SMTPAuth = true;
					        // $mail->Username = 'Sabicapitalresources@gmail.com';
					        // $mail->Password = 'ogidifx@@123...';
					        // $mail->SMTPSecure = 'tsl';
					        // $mail->Port     = 587;
					        
					        // $mail->setFrom('Sabicapitalresources@gmail.com', 'Meet Global Resources');

					        // $mail->Host     = 'smtp.gmail.com';
					        // $mail->SMTPAuth = true;
					        // $mail->Username = 'Ogididavis02@gmail.com';
					        // $mail->Password = 'treasure16';
					        // $mail->SMTPSecure = 'tsl';
					        // $mail->Port     = 587;
					        
					        // $mail->setFrom('Ogididavis02@gmail.com', 'Meet Global Resources');


					        // $mail->Host     = 'smtp.gmail.com';
					        // $mail->SMTPAuth = true;
					        // $mail->Username = 'ikechukwunwogo@gmail.com';
					        // $mail->Password = 'programmer';
					        // $mail->SMTPSecure = 'tsl';
					        // $mail->Port     = 587;
					        
					        // $mail->setFrom('ikechukwunwogo@gmail.com', 'Meet Global Resources');

					        // $mail->Host     = 'smtp.gmail.com';
					        // $mail->SMTPAuth = true;
					        // $mail->Username = 'meetgresources@gmail.com';
					        // $mail->Password = 'dave1614.';
					        // $mail->SMTPSecure = 'tsl';
					        // $mail->Port     = 587;
					        
					        // $mail->setFrom('meetgresources@gmail.com', 'Meet Global Resources');

					        $email_address = $this->allenexpress_model->getDefaultEmailAdress();
					        $password = $this->allenexpress_model->getDefaultEmailAdressPassword();

					        // $email_address = "purehealthtoall@gmail.com";
					        // $password = "WealthyMan88";

					        // $mail->SMTPDebug = 2;

					     //    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
						    // $mail->SMTPAuth = true;                               // Enable SMTP authentication
						    // $mail->Username = $email_address;                 // SMTP username
						    // $mail->Password = $password;                           // SMTP password
						    // $mail->SMTPSecure = 'tsl';                            // Enable TLS encryption, `ssl` also accepted
						    // $mail->Port = 587;                                    // TCP port to connect to
					        
					     //    $mail->setFrom($email_address, 'Sabicapital');


					        $mail->Host = 'localhost';  // Specify main and backup SMTP servers
						    $mail->SMTPAuth = true;                               // Enable SMTP authentication
						    $mail->Username = $email_address;                 // SMTP username
						    $mail->Password = $password;                           // SMTP password
						    $mail->SMTPSecure = 'pop3';                            // Enable TLS encryption, `ssl` also accepted
						    $mail->Port = 25;                                    // TCP port to connect to
					        
					        $mail->setFrom($email_address, 'Sabicapital');
					        // $mail->addReplyTo('info@example.com', 'CodexWorld');
					        
					        // Add a recipient
					        for($i = 0; $i < count($recepient_arr); $i++){
						    	$to_email = $recepient_arr[$i];
						    	// if($this->checkIfEmailHasNotifEnabled($to_email)  && $this->checkIfEmailNotifIsEnabled()){
								    $mail->addAddress($to_email);     // Add a recipient
								// }
							}
					        
					      
					        // Email subject
					        $mail->Subject = $subject;
					        
					        // Set email format to HTML
					        $mail->isHTML(true);
					        
					        // Email body content
					        // $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
					        //     <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
					        $mail->Body = $message;
					        
					        // Send email
					        if(!$mail->send()){
					            // echo 'Message could not be sent.';
					            // echo 'Mailer Error: ' . $mail->ErrorInfo;
					            return false;
					        }else{
					            return true;
					        }
						}
					}else{
						return true;
					}
				}else{
					return true;
				}
			}else{
				return true;
			}	
		}

		public function updateDefaultEmailAddress($email_address,$password){
			$query = $this->db->update('default_email_address',array('email_address' => $email_address,'password' => $password),array('id' => 1));
			return $query;
		}

		public function getDefaultEmailAdress(){
			$query = $this->db->get_where('default_email_address',array('id' => 1));
			if($query->num_rows() == 1){
				return $query->result()[0]->email_address;
			}else{
				return false;
			}
		}

		public function getDefaultEmailAdressPassword(){
			$query = $this->db->get_where('default_email_address',array('id' => 1));
			if($query->num_rows() == 1){
				return $query->result()[0]->password;
			}else{
				return false;
			}
		}

		public function getPrepaidRequestById($id){
			$this->db->select('*');
			$this->db->from('prepaid_electricity_requests');
			$this->db->where('notif_sent',0);
			$this->db->where('id',$id);
			$this->db->order_by('id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}
		


		public function getPayscribeVtuDataBundleCostByProductId($type,$product_id){
			$url = "https://www.payscribe.ng/api/lookup/data";

			
			$use_post = true;
			$amount = 0;

			$response = $this->allenexpress_model->payscribeVtuCurl($url,$use_post,$post_data=[]);
			
			if($this->allenexpress_model->isJson($response)){
				$response = json_decode($response);
				if(is_object($response)){
					if($response->status == true){
						if($type == "mtn-data"){
							$network = "Mtn";
							$plans = $response->message->details[0]->plans;
						}elseif($type == "glo-data"){
							$network = "Glo";
							$plans = $response->message->details[1]->plans;
						}else if($type == "airtel-data"){
							$network = "Airtel";
							$plans = $response->message->details[2]->plans;
						}else if($type == "9mobile-data"){
							$network = "9mobile";
							$plans = $response->message->details[3]->plans;
						}

						for($i = 0; $i < count($plans); $i++){
							$PRODUCT_ID = $plans[$i]->plan_code;
							if($PRODUCT_ID == $product_id){
								$amount = $plans[$i]->amount;
								break;
							}
						}
					}
				}
			}

			return $amount;
		}

		public function payscribeVtuCurl($url, $use_post, $post_data=[]){
	        $curl = curl_init();
	        
	        curl_setopt($curl, CURLOPT_URL, $url);
	        $headers = [
    			'Authorization: Bearer c7eaacbb5ee8491fa0dbcc518ba2f80ad478bf113a07986adf8c3492b5eda818',
    			'Content-Type: application/json'
    		];
	        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	        
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	        
	        if($use_post){
	            curl_setopt($curl, CURLOPT_POST, TRUE);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
	        }
	        //Modify this two lines to suit your needs
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	        $response = curl_exec($curl);
	        curl_close($curl);
	        
	        return $response;
	    
		}

		public function getPrepaidElectricityHistoryForUser($offset){
			// $query = $this->db->get_where('mlm_income_history',array('user_id' => $user_id));
			
			$this->db->select("*");
			$this->db->from("prepaid_electricity_requests");
			$this->db->where('notif_sent',1);
			
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				// $ret_arr = array('sender' => )
				// echo $this->db->last_query();
				$rows = array();
				$new_rows = array();
				foreach($query->result() as $row){
				  $id = $row->id;
                  $vtu_id = $row->vtu_id;
                  $meter_token = $row->meter_token;
                  $notif_sent = $row->notif_sent;
                  $date_time = $row->date_time;
                  $phone_number = $row->phone_number;
                  $email = $row->email;

					$rows[] = array(
						'id' => $id,
						'vtu_id' => $vtu_id,
						'meter_token' => $meter_token,
						'notif_sent' => $notif_sent,
						'date_time' => $date_time,
						'phone_number' => $phone_number,
						'email' => $email
					);
				}
				
				// $rows = array_unique($rows,SORT_REGULAR);
				$rows1 = array_unique($this->array_column_manual($rows, 'id'));
				// var_dump($rows1);
				// print_r(array_intersect_key($array, $tempArr));
				$rows = array_intersect_key($rows,$rows1);
				$rows = array_values($rows);
				$slice = $offset * 10;

				$rows = array_slice($rows, $slice,10);
				
			}else{
				$rows = false;
			}
			return $rows;
		}

		public function getTotalNoOfPrepaidElectricityHistory(){
			// $query = $this->db->get_where('mlm_income_history',array('user_id' => $user_id));

			$this->db->select("*");
			$this->db->from("prepaid_electricity_requests");
			$this->db->where("notif_sent",1);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			return $query->num_rows();
		}

		public function sendSmsMessage($mobile_no,$message){
			$sender = "MGR";
			
			$use_post = true;
			$api_token = "uLeQszF9qDyUbfjZVGEsZZ5c6rNl2BRc6Cqw2KGyDTmtt8WZGQWUpdWhv2gA";
			$post_data = [
				"api_token" => $api_token,
				"from" => $sender,
				"body" => $message,
				"to" => $mobile_no
			];
			

			$url = "https://www.bulksmsnigeria.com/api/v1/sms/create";
			// $url = site_url("onehealth/testing123");
			// $url .= "api_token=". $api_token."&from=".$from."&body=".$body."&to=".$to;
			
			// echo $url;
			$response = $this->curl($url, $use_post, $post_data);
			// var_dump($response);
			if($this->isJson($response)){
				return true;
			}
		}

		public function getVtuIdByPrepaidElectricityHistoryId($id){
			$query = $this->db->get_where('prepaid_electricity_requests',array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result()[0]->id;
			}else{
				return false;
			}
		}


		public function sendMeterTokenForPrepaidToUserByNotifAfterApproval($id,$date_time,$user_id,$date,$time,$orderid,$disco,$meter_no,$amount,$phone_number,$email,$meter_token){

			$title = "Meter Token For Your Prepaid Electricity Bill";
			$message = "Your Meter Token For Your Prepaid Electricity Transaction With The Following Details Has Arrived: <br>";
			$message .= "Meter Token: <em class='text-primary'>".$meter_token."</em><br>";
			$message .= "Order Id: <em class='text-primary'>".$orderid."</em><br>";
			$message .= "Disco: <em class='text-primary'>".$disco."</em><br>";
			$message .= "Meter No.: <em class='text-primary'>".$meter_no."</em><br>";
			$message .= "Amount: <em class='text-primary'>".$amount."</em><br>";
			$message .= "Date / Time: <em class='text-primary'>".$date_time."</em><br>";

			$form_array = array(
				'sender' => "System",
				'receiver' => $user_id,
				'title' => $title,
				'message' => $message,
				'date_sent' => $date,
				'time_sent' => $time,
				'type' => 'misc'
			);

			
			$email = array($email);

			$this->sendMessage($form_array);
			$this->sendEmail($email,$title,$message,true);
			// $sms_message = "Your Meter Token For Meter No. ".$meter_no.", ". $disco ." Is: " . $meter_token;
			$sms_message = "Your " . $disco . " Payment Was Successful. Amount:N".$amount." Date:" . $date_time . " Token:".$meter_token;
			$this->sendSmsMessage($phone_number,$sms_message);

			$form_array = array(
				'meter_token' => $meter_token,
				'notif_sent' => 1,
				'date_time' => $date . " " . $time
			);
			return $this->db->update('prepaid_electricity_requests',$form_array,array('id' => $id));
		}

		public function getVtuTransactionParamById($param,$vtu_id){
			$query = $this->db->get_where('vtu_transactions',array('id' => $vtu_id));
			if($query->num_rows() == 1){
				return $query->result()[0]->$param;
			}
		}

		public function getNewPrepaidRequests(){
			$this->db->select('*');
			$this->db->from('prepaid_electricity_requests');
			$this->db->where('notif_sent',0);
			$this->db->order_by('id','DESC');

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function get9mobileComboCostByProductId($product_id){
			$query = $this->db->get_where("9mobile_combo_data_plans",array('id' => $product_id));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function get9mobileComboDataAmountByProductId($product_id){
			$query = $this->db->get_where("9mobile_combo_data_plans",array('id' => $product_id));
			if($query->num_rows() == 1){
				return $query->result()[0]->data_amount;
			}
		}

		public function get9mobileComboDataBundles(){
			
			$this->db->select("*");
			$this->db->from("9mobile_combo_data_plans");
			$this->db->order_by("id","ASC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		

		public function getIdsToCreditSGPS($mlm_db_id){
			$ret_arr = array();
			$ret_arr[] =  array(
				'mlm_db_id' => $mlm_db_id,
				'user_id' => $this->getMlmDbParamById("user_id",$mlm_db_id)
			);
			for($i = 1; $i <= 15; $i++){
				$query = $this->db->get_where('mlm_db',array('id' => $mlm_db_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$under = $row->under;
						if(!is_null($under)){
							$user_id = $this->allenexpress_model->getMlmDbParamById("user_id",$under);
							// $this->getIdsToCreditPlacement($under);
							$mlm_db_id = $under;
							$ret_arr[] = array(
								'mlm_db_id' => $under,
								'user_id' => $user_id
							);
							
						}else{
							$ret_arr[] =  array(
								'mlm_db_id' => 1,
								'user_id' => $this->getAdminId()
							);
						}
					}
				}

			}
			return $ret_arr;
		}

		public function creditUserSGPSIncome($mlm_db_id,$sgps_income,$sgps_income_vat,$real_sgps_income,$charge_type,$date,$time,$sgps_income_vat_val){

			$creditors_user_id = $this->getMlmDbParamById("user_id",$mlm_db_id);
			$ids_to_credit = $this->getIdsToCreditSGPS($mlm_db_id);
			$ids_to_credit_num = count($ids_to_credit);
			for($i = 0; $i < count($ids_to_credit); $i++){
				$user_id = $ids_to_credit[$i]['user_id'];
				$sgps_mlm_db_id = $ids_to_credit[$i]['mlm_db_id'];

				if($this->db->insert("mlm_earnings",array('user_id' => $user_id,'mlm_db_id' => $sgps_mlm_db_id,'charge_type' => $charge_type,'amount' => $sgps_income,'vat' => $sgps_income_vat,'date' => $date,'time' => $time))){

					$total_vat = $this->getUserParamById("admin_vat_total",$this->getAdminId());
					$new_vat_total = $total_vat + $sgps_income_vat_val;
					$form_array = array(
						'admin_vat_total' => $new_vat_total
					);

					if($this->updateUserTable($form_array,$this->getAdminId())){
						$form_array = array();

						
						$total_business_income = $this->getUserParamById("total_business_income",$user_id);
						$new_total_business_income = $total_business_income + $real_sgps_income;

						$form_array = array(
							'total_business_income' => $new_total_business_income
						);
						

						if($this->updateUserTable($form_array,$user_id)){

						}

						$sponsored_business_partner_id = $creditors_user_id;
						$sponsored_business_partner_username = $this->getUserNameById($sponsored_business_partner_id);
						$sponsored_business_partner_slug = $this->getUserParamById("slug",$sponsored_business_partner_id);
						$sponsored_business_partner_full_name = $this->getUserParamById("full_name",$sponsored_business_partner_id);
						$sponsored_business_partner_phone_code = $this->getUserParamById("phone_code",$sponsored_business_partner_id);
						$sponsored_business_partner_phone_num = $this->getUserParamById("phone",$sponsored_business_partner_id);
						$sponsored_business_partner_phone_num =  "+". $sponsored_business_partner_phone_code . "" . $sponsored_business_partner_phone_num;

						
						$history_array = array(
							'user_id' => $user_id,
							'income_type' => 'sgps',
							'creditors_id' => $sponsored_business_partner_id,
							'amount' => $sgps_income,
							'vat' => $sgps_income_vat,
							'date' => $date,
							'time' => $time
						);

						
						$history_array['package'] = 2;
						

						if($this->addMlmIncomeHistory($history_array) && $i == ($ids_to_credit_num - 1)){
							return true;
						}
					}
				}
			}
		}

		public function getAllUsersBusinessMlmDbIds(){
			$ret_arr = array();
			// $query = $this->db->get_where("mlm_db",array('user_id' => $user_id));
			$this->db->select("id");
			$this->db->from("mlm_db");
			$this->db->where("package",2);
			$this->db->order_by("id","ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] = $id;
				}
			}
			return $ret_arr;
		}

		public function getSGPSVatCharge(){
			$query = $this->db->get_where("mlm_charges",array('id' => 15));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function performMonthlySubscriptionOnBusinessAccounts(){
			$date = date("j M Y");
			$time = date("h:i:sa");
			

			//Get All Mlm Accounts For This User
			$all_mlm_db_ids = $this->getAllUsersBusinessMlmDbIds();

			if(is_array($all_mlm_db_ids)){
				for($i = 0; $i < count($all_mlm_db_ids); $i++){
					$mlm_db_id = $all_mlm_db_ids[$i];

					if($mlm_db_id != 1){

						$user_id = $this->getMlmDbParamById("user_id",$mlm_db_id);
						$package = $this->getMlmDbParamById("package",$mlm_db_id);
						$last_subscription_date = $this->getMlmDbParamById("last_subscription_date",$mlm_db_id);
						$date_created = $this->getMlmDbParamById("date_created",$mlm_db_id);
						if($last_subscription_date == ""){
							$last_subscription_date = $date_created;
						}

						$date1 = strtotime($date);
						$date2 = strtotime($last_subscription_date);
						$datediff = $date1 - $date2;

						$datediff = $datediff / (60 * 60 * 24);

						if($datediff >= 30){
						
							$total_business_earnings = $this->getTotalBusinessWithdrawableEarningsForMlmAccount($user_id,$mlm_db_id);

							$sgps_income = round(100 / 16,2);
							$sgps_income_vat = $this->getSGPSVatCharge();
							$sgps_income_vat_val = $sgps_income_vat / 100;
							$real_sgps_income = round($sgps_income - (($sgps_income_vat / 100) * $sgps_income),2);

							if($total_business_earnings >= 100){
								if($this->creditUserSGPSIncome($mlm_db_id,$sgps_income,$sgps_income_vat,$real_sgps_income,15,$date,$time,$sgps_income_vat_val)){
									$total_mlm_withdrawn = $this->getUserParamById("mlm_withdrawn",$user_id);
									$total_mlm_withdrawn = $total_mlm_withdrawn + 100;
									$form_array = array(
										'mlm_withdrawn' => $total_mlm_withdrawn
									);
									if($this->updateUserTable($form_array,$user_id)){
										$form_array = array(
											'last_subscription_date' => $date
										);
										if($this->updateMlmTable($form_array,$mlm_db_id)){
											return true;
										}
									}
								}
							}
						}
					}
					
				}
			}
		}


		public function getAdminCreditsForUser($user_id,$date){

			$this->db->select("*");
			$this->db->from("admin_fund_users_history");
			$this->db->where("user_id",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function getTransfersForUser($user_id,$date){
			
			$this->db->select("*");
			$this->db->from("transfer_funds_history");
			$this->db->where("sender",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function getVtuTransactionsForUser($user_id,$date){

			$this->db->select("*");
			$this->db->from("vtu_transactions");
			$this->db->where("user_id",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getWithdrawalHistoryForUser($user_id,$date){
			
			$this->db->select("*");
			$this->db->from("withdrawal_history");
			$this->db->where("user_id",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getAccountCreditHistoryForUser($user_id,$date){
			$this->db->select("*");
			$this->db->from("account_credit_history");
			$this->db->where("user_id",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getTotalAmountOfAdminCreditRecordsForUserInADay($user_id,$date){
			$sum = 0;
			$query = $this->db->get_where('admin_fund_users_history',array('user_id' => $user_id,'date' => $date));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$sum += $amount;
				}
			}
			return $sum;
		}

		public function getLastTimeOfAdminCreditRecordsForUserInADay($user_id,$date){
			

			$this->db->select("time");
			$this->db->from("admin_fund_users_history");
			$this->db->where("user_id",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");
			$this->db->limit(1);

			$query = $this->db->get();
			if($query->num_rows() == 1){
				return $query->result()[0]->time;
			}

			return array_values(array_unique($ret_arr));
		}

		public function getNumberOfAdminCreditRecordsForUserInADay($user_id,$date){

			$query = $this->db->get_where('admin_fund_users_history',array('user_id' => $user_id,'date' => $date));
			return $query->num_rows();
		}

		public function getDaysOfAdminCreditsForUser($user_id){
			$ret_arr = array();

			$this->db->select("date");
			$this->db->from("admin_fund_users_history");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$date = $row->date;
					$ret_arr[] = $date;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function getTotalAmountOfTransferRecordsForUserInADay($user_id,$date){
			$sum = 0;
			$query = $this->db->get_where('transfer_funds_history',array('sender' => $user_id,'date' => $date));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$sum += $amount;
				}
			}
			return $sum;
		}

		public function getLastTimeOfVTransferRecordsForUserInADay($user_id,$date){
			

			$this->db->select("time");
			$this->db->from("transfer_funds_history");
			$this->db->where("sender",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");
			$this->db->limit(1);

			$query = $this->db->get();
			if($query->num_rows() == 1){
				return $query->result()[0]->time;
			}

			return array_values(array_unique($ret_arr));
		}

		public function getNumberOfTransferRecordsForUserInADay($user_id,$date){

			$query = $this->db->get_where('transfer_funds_history',array('sender' => $user_id,'date' => $date));
			return $query->num_rows();
		}

		public function getDaysOftransfersForUser($user_id){
			$ret_arr = array();

			$this->db->select("date");
			$this->db->from("transfer_funds_history");
			$this->db->where("sender",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$date = $row->date;
					$ret_arr[] = $date;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function getTotalAmountOfVtuTransactionRecordsForUserInADay($user_id,$date){
			$sum = 0;
			$query = $this->db->get_where('vtu_transactions',array('user_id' => $user_id,'date' => $date));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$sum += $amount;
				}
			}
			return $sum;
		}

		public function getLastTimeOfVtuTransactionRecordsForUserInADay($user_id,$date){
			

			$this->db->select("time");
			$this->db->from("vtu_transactions");
			$this->db->where("user_id",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");
			$this->db->limit(1);

			$query = $this->db->get();
			if($query->num_rows() == 1){
				return $query->result()[0]->time;
			}

			return array_values(array_unique($ret_arr));
		}

		public function getNumberOfVtuTransactionRecordsForUserInADay($user_id,$date){

			$query = $this->db->get_where('vtu_transactions',array('user_id' => $user_id,'date' => $date));
			return $query->num_rows();
		}

		public function getDaysOfVtuTransactionsForUser($user_id){
			$ret_arr = array();

			$this->db->select("date");
			$this->db->from("vtu_transactions");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$date = $row->date;
					$ret_arr[] = $date;
				}
			}

			return array_values(array_unique($ret_arr));
		}


		public function getTotalAmountOfWithdrawalRecordsForUserInADay($user_id,$date){
			$sum = 0;
			$query = $this->db->get_where('withdrawal_history',array('user_id' => $user_id,'date' => $date));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$sum += $amount;
				}
			}
			return $sum;
		}

		public function getLastTimeOfWithdrawalRecordsForUserInADay($user_id,$date){
			

			$this->db->select("time");
			$this->db->from("withdrawal_history");
			$this->db->where("user_id",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");
			$this->db->limit(1);

			$query = $this->db->get();
			if($query->num_rows() == 1){
				return $query->result()[0]->time;
			}

			return array_values(array_unique($ret_arr));
		}

		public function getNumberOfWithdrawalRecordsForUserInADay($user_id,$date){

			$query = $this->db->get_where('withdrawal_history',array('user_id' => $user_id,'date' => $date));
			return $query->num_rows();
		}

		public function getDaysOfWithdrawalHistoryForUser($user_id){
			$ret_arr = array();

			$this->db->select("date");
			$this->db->from("withdrawal_history");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$date = $row->date;
					$ret_arr[] = $date;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function getTotalAmountOfAccountCreditRecordsForUserInADay($user_id,$date){
			$sum = 0;
			$query = $this->db->get_where('account_credit_history',array('user_id' => $user_id,'date' => $date));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$sum += $amount;
				}
			}
			return $sum;
		}


		public function getLastTimeOfAccountCreditRecordsForUserInADay($user_id,$date){
			

			$this->db->select("time");
			$this->db->from("account_credit_history");
			$this->db->where("user_id",$user_id);
			$this->db->where("date",$date);
			$this->db->order_by("id","DESC");
			$this->db->limit(1);

			$query = $this->db->get();
			if($query->num_rows() == 1){
				return $query->result()[0]->time;
			}

			return array_values(array_unique($ret_arr));
		}


		public function getNumberOfAccountCreditRecordsForUserInADay($user_id,$date){

			$query = $this->db->get_where('account_credit_history',array('user_id' => $user_id,'date' => $date));
			return $query->num_rows();
		}

		public function getDaysOfAccountCreditHistoryForUser($user_id){
			$ret_arr = array();

			$this->db->select("date");
			$this->db->from("account_credit_history");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$date = $row->date;
					$ret_arr[] = $date;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function addAdminCreditHistory($user_id,$amount,$date,$time){
			return $this->db->insert('admin_fund_users_history',array('user_id' => $user_id,'amount' => $amount,'date' => $date,'time' => $time));
		}

		public function addWithrawalHistory($user_id,$amount){
			$date = date("j M Y");
			$time = date("h:i:sa");
			return $this->db->insert('withdrawal_history',array('user_id' => $user_id,'amount' => $amount,'date' => $date,'time' => $time));
		}

		public function loadAllRegisteredUsers(){
			$ret_arr = array();
			$this->db->select("id");
			$this->db->from("users");
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] = $id;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function searchUsers($search_val){
			$ret_arr = array();
			$this->db->select("id");
			$this->db->from("users");
			$this->db->like("user_name",$search_val,"after");
			$this->db->or_like("full_name",$search_val,"after");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] = $id;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function getFirstUsers($search_val){
			
			$this->db->select("*");
			$this->db->from("users");
			$this->db->like("user_name",$search_val,"after");
			$this->db->or_like("full_name",$search_val,"after");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}

			
		}

		public function creditUser($user_id,$amount){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$total_income = $row->total_income;
				}
				$new_total_income = $total_income + $amount;
				$query = $this->db->update('users',array('total_income' => $new_total_income),array('id' => $user_id));
				if($query){
					return true;
				}else{
					return false;
				}
			}
		}


		public function sendMeterTokenForPrepaidToUserByNotif($user_id,$email,$date,$time,$orderid,$disco,$meter_no,$amount,$meter_token){

			$title = "Successful Prepaid Electricity Recharge";
			$message = "Your Prepaid Electricity Recharge Was Successful With The Following Details: <br>";
			$message .= "Order Id: <em class='text-primary'>".$orderid."</em><br>";
			$message .= "Meter Token: <em class='text-primary'>".$meter_token."</em><br>";
			$message .= "Disco: <em class='text-primary'>".$disco."</em><br>";
			$message .= "Meter No.: <em class='text-primary'>".$meter_no."</em><br>";
			$message .= "Amount: <em class='text-primary'>".$amount."</em><br>";

			$form_array = array(
				'sender' => "System",
				'receiver' => $user_id,
				'title' => $title,
				'message' => $message,
				'date_sent' => $date,
				'time_sent' => $time,
				'type' => 'misc'
			);

			
			$email = array($email);

			$this->sendMessage($form_array);
			$this->sendEmail($email,$title,$message,true);
		}


		public function sendAdminEmailToNotifyAboutNewPrepaidElectricity($vtu_id,$user_id,$date,$time,$orderid,$disco,$meter_no,$amount,$phone_number,$user_email){

			$title = "New Prepaid Electricity Recharge Request";
			$message = "Prepaid Electricity Details: <br>";
			$message .= "Order Id: <em class='text-primary'>".$orderid."</em><br>";
			
			$message .= "Disco: <em class='text-primary'>".$disco."</em><br>";
			$message .= "Meter No.: <em class='text-primary'>".$meter_no."</em><br>";
			$message .= "Amount: <em class='text-primary'>".$amount."</em><br>";

			

			$email = "Sabicapitalresources@gmail.com";
			$email = array($email);

			$form_array = array(
				'phone_number' => $phone_number,
				'email' => $user_email,
				'vtu_id' => $vtu_id,
				'notif_sent' => 0
			);
			
			$this->sendAdminEmail($email,$title,$message,true);
			$this->addPrepaidElectricityRequests($form_array);
		}

		public function getVtuIdByOrderId($order_id){
			$vtu_id = "";
			$query = $this->db->get_where("vtu_transactions",array('order_id' => $order_id));
			if($query->num_rows() == 1){
				$vtu_id = $query->result()[0]->id;
			}

			return $vtu_id;
		}

		public function addPrepaidElectricityRequests($form_array){
			return $this->db->insert("prepaid_electricity_requests",$form_array);
		}

		public function performAutomaticUpgradingOfUsersBasicAccountsToBusiness(){
			$date = date("j M Y");
			$time = date("h:i:sa");
			$user_id = $this->getUserIdWhenLoggedIn();

			//Get All Mlm Accounts For This User
			$all_mlm_db_ids = $this->getAllUsersMlmDbIds($user_id);

			if(is_array($all_mlm_db_ids)){
				for($i = 0; $i < count($all_mlm_db_ids); $i++){
					$mlm_db_id = $all_mlm_db_ids[$i];


					$package = $this->getMlmDbParamById("package",$mlm_db_id);
					if($package == 1){

						$total_business_earnings = $this->getTotalBusinessWithdrawableEarningsForMlmAccount($user_id,$mlm_db_id);


						if($total_business_earnings >= 6500){
							if($this->upgradeMlmAccountToBusiness($mlm_db_id,$user_id,$date,$time)){
								$total_mlm_withdrawn = $this->getUserParamById("mlm_withdrawn",$user_id);
								$total_mlm_withdrawn = $total_mlm_withdrawn + 6500;
								$form_array = array(
									'mlm_withdrawn' => $total_mlm_withdrawn
								);
								if($this->updateUserTable($form_array,$user_id)){
									return true;
								}
							}
						}
					}
				}
			}
		}


		public function getTotalBusinessWithdrawableEarningsForMlmAccount($user_id,$mlm_db_id){
			$total = 0;
			// $this->db->select("*");
			// $this->db->from("mlm_earnings");
			// $this->db->or_where("charge_type",3);
			// $this->db->or_where("charge_type",4);
			// $this->db->or_where("charge_type",7);
			// $this->db->or_where("charge_type",12);
			// $this->db->or_where("charge_type",13);
			// $this->db->or_where("charge_type",14);
			// $this->db->or_where("charge_type",15);
			

			$query_str = "SELECT * FROM mlm_earnings WHERE mlm_db_id = " . $mlm_db_id . " AND user_id = ".$user_id." AND (charge_type = 3 OR charge_type = 4 OR charge_type = 7 OR charge_type = 12 OR charge_type = 13 OR charge_type = 14 OR charge_type = 15)";
			$query = $this->db->query($query_str);
			// echo $this->db->last_query();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$mlm_db_id1 = $row->mlm_db_id;
					$mlm_user_id = $row->user_id;
					// if($mlm_user_id == $user_id && $mlm_db_id == $mlm_db_id1){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
					// }
				}
			}
			return $total;
		}

		public function performMlmRegistrationForFirstTimeUsersWithOutPlacement($user_id,$sponsor_user_name,$date,$time){

			$sponsor_id = $this->allenexpress_model->getUserIdByName($sponsor_user_name);
			$sponsor_id = $this->allenexpress_model->getUsersFirstMlmDbId($sponsor_id);
        	
  			$package = 1;
  			$package_str = "Basic";
      		
  			if($this->allenexpress_model->checkIfMlmDbIdIsValid($sponsor_id) ){
	          	
				
				if($this->allenexpress_model->registerUserInMlm3($user_id,$sponsor_id,$date,$time,$package,0)){
					return true;
				}
			}
				
		}

		public function performMlmRegistrationForFirstTimeUsersWithPlacement($user_id,$sponsor_user_name,$placement_mlm_db_id,$placement_position,$date,$time){

			$sponsor_id = $this->allenexpress_model->getUserIdByName($sponsor_user_name);
			$sponsor_id = $this->allenexpress_model->getUsersFirstMlmDbId($sponsor_id);
        	
        	$package = 1;
        	
	          	
  			$package = 1;
  			$package_str = "Basic";
      		
      		if($placement_position == "left" || $placement_position == "right"){
      			if($this->allenexpress_model->checkIfMlmDbIdIsValid($sponsor_id) && $this->allenexpress_model->checkIfMlmDbIdIsValid($placement_mlm_db_id)){
		          	
					if($placement_position == "left"){
						$next_available_position = "right";
					}else{
						$next_available_position = "left";
					}

					

					if($this->allenexpress_model->checkIfThisPlacementPositionIsAvailable($placement_mlm_db_id,$placement_position)){
						// echo "string";
		          	
		          		if($this->allenexpress_model->registerUserInMlm2($user_id,$sponsor_id,$placement_mlm_db_id,$placement_position,$date,$time,$package,0)){
		          			
				          	return true;
						}
					}else if($this->allenexpress_model->checkIfThisPlacementPositionIsAvailable($placement_mlm_db_id,$next_available_position)){
						if($this->allenexpress_model->registerUserInMlm2($user_id,$sponsor_id,$placement_mlm_db_id,$next_available_position,$date,$time,$package,0)){
		          			// echo "string";
							return true;
						}
					}else{
						if($this->allenexpress_model->registerUserInMlm3($user_id,$sponsor_id,$date,$time,$package,0)){
							return true;
						}
					}
					
				}
			}
				
		}

		public function sendOtpEmail($email,$otp){
			if(is_array($email)){
				$subject = "OTP For Sabicapital Resources";
				$message = "Your Otp Is: ".$otp.". Thanks For Using Sabicapital.";
				if($this->sendEmail($email,$subject,$message,true)){
					return true;
				}
			}
		}

		// public function getTotalNoOfMlmAccountsUnderUserLeft($mlm_db_id){
		// 	$this->getChildrenIdsOfParent()
		// }

		public function getComboRechargeHistoryForUser($offset){
			// $query = $this->db->get_where('mlm_income_history',array('user_id' => $user_id));
			
			$this->db->select("*");
			$this->db->from("combo_recharge_vtu");
			$this->db->where('credited',1);
			
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				// $ret_arr = array('sender' => )
				// echo $this->db->last_query();
				$rows = array();
				$new_rows = array();
				foreach($query->result() as $row){
				  $id = $row->id;
                  $user_id = $row->user_id;
                  $number = $row->number;
                  $amount = $row->amount;
                  $date = $row->date;
                  $time = $row->time;
                  $credited = $row->credited;
                  $credited_date = $row->credited_date;
                  $credited_time = $row->credited_time;


					$rows[] = array(
						'id' => $id,
						'user_id' => $user_id,
						'number' => $number,
						'amount' => $amount,
						'date' => $date,
						'time' => $time,
						'credited' => $credited,
						'credited_date' => $credited_date,
						'credited_time' => $credited_time
					);
				}
				
				// $rows = array_unique($rows,SORT_REGULAR);
				$rows1 = array_unique($this->array_column_manual($rows, 'id'));
				// var_dump($rows1);
				// print_r(array_intersect_key($array, $tempArr));
				$rows = array_intersect_key($rows,$rows1);
				$rows = array_values($rows);
				$slice = $offset * 10;

				$rows = array_slice($rows, $slice,10);
				
			}else{
				$rows = false;
			}
			return $rows;
		}

		public function getTotalNoOfComboRechargeHistory(){
			// $query = $this->db->get_where('mlm_income_history',array('user_id' => $user_id));

			$this->db->select("*");
			$this->db->from("combo_recharge_vtu");
			$this->db->where("credited",1);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			return $query->num_rows();
		}

		public function getComboRecordParamById($param,$id){
			$query = $this->db->get_where("combo_recharge_vtu",array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result()[0]->$param;
			}
		}

		public function markComboRecordAsRecharged($form_array,$id,$date,$time){
			if($this->db->update("combo_recharge_vtu",$form_array,array('id' => $id))){
				$user_id = $this->getComboRecordParamById("user_id",$id);
				$user_name = $this->getUserParamById("user_name",$user_id);

				$combo_date = $this->getComboRecordParamById("date",$id) . " " . $this->getComboRecordParamById("time",$id);

				$amount = $this->getComboRecordParamById("amount",$id);
				$number = $this->getComboRecordParamById("number",$id);

				$title = "VTU Combo Recharged Successfully";
        		$message = "This Is To Alert You That The Combo Recharge You Requested On <em class='text-primary'>" . $date . "</em> With Mobile Number <em class='text-primary'>".$number."</em> For <em class='text-primary'>".$amount."</em> Worth Of Airtime Has Been Recharged By The Admin. ";
        		

				$form_array = array(
					'sender' => "System",
					'receiver' => $user_id,
					'title' => $title,
					'message' => $message,
					'date_sent' => $date,
					'time_sent' => $time,
					'type' => 'misc'
				);

				if($this->sendMessage($form_array)){
					return true;
				}
			}
		}

		public function getNewRechargeComboRequests(){
			$this->db->select("*");
			$this->db->from("combo_recharge_vtu");
			$this->db->where("credited",0);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();

			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function addComboRequest($form_array){
			return $this->db->insert("combo_recharge_vtu",$form_array);
		}

		public function getNoOfAccountsOwnedByUser($user_id){
			$query = $this->db->get_where("mlm_db",array('user_id' => $user_id));
			return $query->num_rows();
		}

		public function getTotalNoOfMlmIncomeHistoryForUser($user_id){
			// $query = $this->db->get_where('mlm_income_history',array('user_id' => $user_id));

			$this->db->select("*");
			$this->db->from("mlm_income_history");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");

			$query = $this->db->get();
			return $query->num_rows();
		}

		public function getMlmIncomeHistoryForUser($user_id,$offset){
			// $query = $this->db->get_where('mlm_income_history',array('user_id' => $user_id));
			
			$this->db->select("*");
			$this->db->from("mlm_income_history");
			$this->db->where('user_id',$user_id);
			
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				// $ret_arr = array('sender' => )
				// echo $this->db->last_query();
				$rows = array();
				$new_rows = array();
				foreach($query->result() as $row){
					$id = $row->id;
                    $income_type = $row->income_type;
                    $package = $row->package;
                    $creditors_id = $row->creditors_id;
                    $amount = $row->amount;
                    $vat = $row->vat;
                    $date = $row->date;
                    $time = $row->time;

					$rows[] = array(
						'id' => $id,
						'income_type' => $income_type,
						'package' => $package,
						'creditors_id' => $creditors_id,
						'amount' => $amount,
						'vat' => $vat,
						'date' => $date,
						'time' => $time
					);
				}
				
				// $rows = array_unique($rows,SORT_REGULAR);
				$rows1 = array_unique($this->array_column_manual($rows, 'id'));
				// var_dump($rows1);
				// print_r(array_intersect_key($array, $tempArr));
				$rows = array_intersect_key($rows,$rows1);
				$rows = array_values($rows);
				$slice = $offset * 10;

				$rows = array_slice($rows, $slice,10);
				
			}else{
				$rows = false;
			}
			return $rows;
		}

		public function sendOtp($mobile_no,$otp){
			$sender = "MGR";
			$message = "Your Otp Is: ".$otp.". Thanks For Using MGR.";
			
			$use_post = true;
			$api_token = "uLeQszF9qDyUbfjZVGEsZZ5c6rNl2BRc6Cqw2KGyDTmtt8WZGQWUpdWhv2gA";
			$post_data = [
				"api_token" => $api_token,
				"from" => $sender,
				"body" => $message,
				"to" => $mobile_no
			];
			

			$url = "https://www.bulksmsnigeria.com/api/v1/sms/create";
			// $url = site_url("onehealth/testing123");
			// $url .= "api_token=". $api_token."&from=".$from."&body=".$body."&to=".$to;
			
			// echo $url;
			$response = $this->curl($url, $use_post, $post_data);
			// var_dump($response);
			if($this->isJson($response)){
				return true;
			}
		}

		public function confirmThisPaymentReferenceHasNotBeenUsedBefore($reference){
			$query = $this->db->get_where("mlm_db");
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$reference_str = $row->reference;
					if(!is_null($reference_str)){
						$former_references_arr = explode(",", $reference_str);
						if(in_array($reference,$former_references_arr)){
							return true;
						}
					}
				}
				
			}
		}

		public function checkIfThisReferenceHasNotBeenUsedBeforeCreditAccount($reference){
			$query = $this->db->get_where("account_credit_history",array('reference' => $reference));
			if($query->num_rows() > 0){
				return false;
			}else{
				return true;
			}
		}

		public function getUsersMainAccountCreditHistory($user_id){
			$query = $this->db->get_where('account_credit_history',array('user_id' => $user_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return true;
			}
		}

		public function sendRegistrationEmail(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$user_email = $this->getUserEmailById($user_id);
			$user_slug = $this->getUserParamById("slug",$user_id);
			$partner_array = array();
			$partner_array[] = $user_email;
			$subject = "Welcome To Sabicapital Resources Community";
			$message = "Dear Partner,<br><br><br><br>";

			$message .= "You have completed the registration in Meet Global Resources(MGR) system.<br>";

			$message .= "From now, you are able to access the Partners Member area and start using your account for  your needs.<br>";

			$message .= "Your partner  Referral ID: <a href='https://Sabicapitalresources.com/login_page?id=".$user_slug."'></a> <br><br>";

			$message .= "Use your ID and password, which you submitted in the registration form, to access your account.<br><br><br>";

			$message .= "Thank you for registering with MGR!";
			if($this->sendEmail($partner_array,$subject,$message)){

			}
		}

		public function getUsersVtuTransactionHistory($user_id){
			$query = $this->db->get_where('vtu_transactions',array('user_id' => $user_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return true;
			}
		}

		public function getUsersMainAccountTransferHistory($user_id){
			// $query = $this->db->get_where('	transfer_funds_history',array('user_id' => $user_id));
			$this->db->select("*");
			$this->db->from("transfer_funds_history");
			$this->db->where("sender",$user_id);
			$this->db->or_where("recepient",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return true;
			}
		}

		public function addNewAccountCreditHistory($form_array){
			return $this->db->insert("account_credit_history",$form_array);
		}

		

		public function get_client_ip() {
		    $ipaddress = '';
		    if (getenv('HTTP_CLIENT_IP'))
		        $ipaddress = getenv('HTTP_CLIENT_IP');
		    else if(getenv('HTTP_X_FORWARDED_FOR'))
		        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		    else if(getenv('HTTP_X_FORWARDED'))
		        $ipaddress = getenv('HTTP_X_FORWARDED');
		    else if(getenv('HTTP_FORWARDED_FOR'))
		        $ipaddress = getenv('HTTP_FORWARDED_FOR');
		    else if(getenv('HTTP_FORWARDED'))
		       $ipaddress = getenv('HTTP_FORWARDED');
		    else if(getenv('REMOTE_ADDR'))
		        $ipaddress = getenv('REMOTE_ADDR');
		    else
		        $ipaddress = 'UNKNOWN';
		    return $ipaddress;
		}

		public function performAutomaticRemovalOfDispatchRequestsMiniImportationOrders(){
			$date =	date("j M Y");
			$time = date("H:i:s");
			$query = $this->db->get_where("mini_importation_orders",array('sent_to_dispatcher' => 1,'with_dispatcher' => 0));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$sent_to_dispatcher_date = $row->sent_to_dispatcher_date;
					$sent_to_dispatcher_time = $row->sent_to_dispatcher_time;
					$center_leader_id = $row->center_leader;
					$product_id = $row->product_id;
					$dispatcher_id = $row->dispatcher;
					$dispatcher_full_name = $this->getUserParamById("full_name",$dispatcher_id);

					$now = time(); // or your date as well
				    $your_date = strtotime($sent_to_dispatcher_date . " " . $sent_to_dispatcher_time);
				    $datediff = $now - $your_date;

				    if(!$this->checkIfSentToDispatcherIs0($id)){
					    if($datediff > 10800){
					    	$query = $this->db->update('mini_importation_orders',array('sent_to_dispatcher' => 0,'sent_to_dispatcher_date' => '','sent_to_dispatcher_time' => '','dispatcher' => NULL),array('center_leader' => $center_leader_id,'product_id' => $product_id,'sent_to_dispatcher' => 1,'with_dispatcher' => 0));

					    	if($query){
					    		$title = "Dispatch Responsibility Timeout";
				        		$message = "This Is To Alert You That The Selected Dispatcher's Alloted 3hrs Time In Mini Importation Has Expired. Click The Button Below To Reassign Dispatcher Responsibility.";
				        		$btn_1 = "<a class='btn btn-success' href='".site_url('Sabicapital/admin_mini_importation/?open_products_on_way_to_center_leader_info=true&center_leader_id='.$center_leader_id.'&product_id='.$product_id)."'>Click Here</a>";

								$form_array = array(
									'sender' => "System",
									'receiver' => $this->getAdminId(),
									'title' => $title,
									'message' => $message,
									'date_sent' => $date,
									'time_sent' => $time,
									'type' => 'misc',
									'btn_1' => $btn_1
								);

								$this->sendMessage($form_array);
					    	}
					    }
					}    
		            
				}
			}
		}

		public function genereateMortuaryFieldsString($table_name){
			$query_str = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table_name."'";
			$query = $this->db->query($query_str);
			$ret = "";
			foreach($query->result() as $row){
				$column_name = $row->COLUMN_NAME;
				$ret .= "$".$column_name . " = " . "$" . "row" . "->" . $column_name . ";<br>";
			}
			echo $ret;
		}

		public function checkIfSentToDispatcherIs0($id){
			$query = $this->db->get_where("mini_importation_orders",array('id' => $id,'sent_to_dispatcher' => 0));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function uploadFrontPageMessage($form_array){
			return $this->db->insert('front_page_messages',$form_array);
		}

		public function checkIfUserHasHalfRegistered($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$created = $row->created;
					// var_dump($created);
					if($created == '0'){
						return true;
					}else{
						return false;
					}
				}
			}
		}

		public function checkIfUserIsFullyRegistered($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$created = $row->created;
					if($created == '1'){
						return true;
					}else{
						return false;
					}
				}
			}
		}



		public function testCreateTable(){
			$query_str = "CREATE TABLE test (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				user_name VARCHAR(40) NOT NULL,
				hashed VARCHAR(50) NOT NULL,
				position VARCHAR(50) NOT NULL,
				token TEXT NOT NULL,
				dept VARCHAR(100) NOT NULL,
				sub_dept VARCHAR(100) NOT NULL,
				personnel VARCHAR(100) NOT NULL,
				email VARCHAR(50) NOT NULL,
				phone BIGINT NOT NULL,
				country INT(11) NOT NULL,
				state INT(11) NOT NULL,
				address TEXT NOT NULL,
				slug VARCHAR(50) NOT NULL,
				register INT(11) NOT NULL,
				date VARCHAR(20) NOT NULL,
				time VARCHAR(20) NOT NULL
			)";
			if($this->db->query($query_str)){
				return true;
			}else{
				return false;
			}
		}

		//get departments
		public function getDepts(){
			$query = $this->db->get('dept');
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getHealthFacilityInfoByUserId($user_id){
			$query = $this->db->get_where('health_facility',array('user_id' => $user_id),1);
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getHealthFacilityInfoId($id){
			$query = $this->db->get_where('health_facility',array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfThisNumberHasBeenUsed($phone,$calling_code){
			$user_id = $this->getUserIdWhenLoggedIn();
			// $query = $this->db->get_where('users',array('phone' => $phone,'phone_code' => $calling_code));
			$this->db->select("*");
			$this->db->from("users");
			$this->db->where("phone",$phone);
			$this->db->where("phone_code",$calling_code);
			$this->db->where("id !=",$user_id);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfThisEmailHasBeenUsed($email){
			$query = $this->db->get_where('users',array('email' => $email));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfEmailIsInId($email,$user_id){
			$query = $this->db->get_where('users',array('id' => $user_id,'email' => $email));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfEmailExists($email){
			$query = $this->db->get_where('users',array('email' => $email));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfPhoneExists($phone_number,$phone_code,$user_id){
			$this->db->select("*");
			$this->db->from('users');
			$this->db->where('id !=',$user_id);
			$this->db->where('phone',$phone_number);
			$this->db->where('phone_code',$phone_code);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				return true;
			}else{
				// echo $this->db->last_query();
				return false;
			}

		}

		public function getIdByStage0($type,$stage){
			if($stage == 0){
				$query = $this->db->get_where($type,array('stage' => $stage));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$id = $row->id;
					}
					return $id;
				}
			}else{
				return false;
			}
		}
		
		public function checkIfThisStageIsFull1($type,$stage){
			// echo $stage;
			$previous_stage = $stage - 1;
			
			$query = $this->db->get_where('new_nigeria1',array('stage' => $stage));
			$no_in_child_stage = $query->num_rows();
			$query = $this->db->get_where('new_nigeria1',array('stage' => $previous_stage));
			$no_in_current_stage = $query->num_rows();
			// echo $no_in_child_stage."<br>";
			// echo $no_in_current_stage."<br>";
			$total_amount_supposed_to_be_in_current_stage = $no_in_current_stage * 2;
			// echo $total_amount_supposed_to_be_in_current_stage."<br>";
			if($no_in_child_stage == $total_amount_supposed_to_be_in_current_stage){

				return true;
			}else{
				// echo "string";
				return false;
			}
			
		}

		public function recycleNewNigeria2($record_id,$form_array){
			// echo "string";
			//Get Record Id Info
			$query = $this->db->get_where('new_nigeria1',array('id' => $record_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$main_user_id = $row->user_id;
					$under = $row->under;
					$stage = $row->stage;
				}
				$childrens_stage = $form_array['stage'];
				if($this->checkIfThisStageIsFull1('new_nigeria1',$childrens_stage)){
					// echo "string";
					//Stage Is Full Add To A New Stage Under The First Guy In The Previous Stage
					$new_stage = $stage + 2;
					$query = $this->db->get_where('new_nigeria1',array('stage' => $childrens_stage),1);
					foreach($query->result() as $row){
						$id = $row->id;
						$user_id = $row->user_id;						
					}
					$form_array['stage'] = $new_stage;
					$form_array['under'] = $id;
					// print_r($form_array);
					unset($form_array['referred_by']);
					// print_r($form_array);
					$form_array = array_merge($form_array,array('recycled' => 1));
					$query = $this->db->insert('new_nigeria1',$form_array);
					if($query){
						$this->creditUserNewNigeria($main_user_id,2000,"new_nigeria");
						return true;
					}else{
						return false;
					}
				}else{
					//Stage Is Not Full Add To The Present Stage Under The Next Guy In This Stage. i.e first guy under the next guy to be added under
					$new_stage = $stage + 1;
					// Get The Last Guy In Previous Stage With 3 under Him. Then Recycle To The Next Available Guy With No One Under Him.
					$query = $this->db->get_where('new_nigeria1',array('stage' => $stage));
					if($query->num_rows() > 0){
						foreach($query->result() as $row){
							$id = $row->id;
							$query = $this->db->get_where('new_nigeria1',array('under' => $id,'stage' => $new_stage));
							if($query->num_rows() < 2){
								$this->session->set_userdata('id1',$id);
								break;
							}
						}
						$form_array['stage'] = $new_stage;
						$form_array['under'] = $this->session->id1;
						unset($_SESSION['id1']);
						$form_array = array_merge($form_array,array('recycled' => 1));
						$query = $this->db->insert('new_nigeria1',$form_array);
						if($query){
							$this->creditUserNewNigeria($main_user_id,2000,"new_nigeria");
							return true;
						}else{
							return false;
						}
					}
				}
			}
		}

		

		public function performAddingOneNigeria2($user_id,$date,$time){
			//If Referred Is None Set Reference to Null
			$query = $this->db->get_where('users',array('is_admin' => 1,'user_name' => 'admin'),1);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sponsor_income = $row->sponsor_income;
					$total_income = $row->total_income;
				}

				//Form Array For Inserting New Records
				$form_array = array(
					'user_id' => $user_id,
					'stage' => 0,
					'under' => NULL,
					
					'date' => $date,
					'time' => $time
				);
				//Get All New Nigeria Records
				$query = $this->db->get('new_nigeria1');
				//Get If Rows Are Greater Than 0.
				if($query->num_rows() > 0){
					//Select The Max Stage
					$this->db->select_max('stage');
					$query = $this->db->get('new_nigeria1',1);
					if($query->num_rows() == 1){
						foreach($query->result() as $row){
							// $id = $row->id;
							$stage = $row->stage;
						}
						//If Stage == 0
						if($stage == 0){
							//Just Add This Guy Under The First Guy With Stage Of Stage + 1
							$new_stage = $stage + 1;
							$under = $this->getIdByStage0('new_nigeria1',$stage);
							$form_array['under'] = $under;
							$form_array['stage'] = $new_stage;
							$query = $this->db->insert('new_nigeria1',$form_array);
							if($query){
								return true;
							}else{
								return false;
							}
						}else{
							//Get Next Available Space To Insert This Guy In

							//Check If There Is More Space In This Stage
							//Get The Last Guy In This Stage To See Where To Place This Guy
							$this->db->select("*");
							$this->db->from("new_nigeria1");
							$this->db->where("stage",$stage);
							$this->db->order_by("id","DESC");
							$this->db->limit(1);
							$query = $this->db->get();
							if($query->num_rows() == 1){
								foreach($query->result() as $row){
									$id = $row->id;
									$user_id = $row->user_id;
									$under = $row->under;
								}
								// $previous_stage = $stage - 1;
								$query = $this->db->get_where('new_nigeria1',array('under' => $under));
								$num_under_the_guy_above = $query->num_rows();
								if($query->num_rows() > 0){

									//If This Guy Remains One To Full
									if($num_under_the_guy_above == 1){
										//Then We Add This Guy And Recycle The Oga At The Top
										$form_array['under'] = $under;
										$form_array['stage'] = $stage;
										// echo $form_array['stage'];
										$query = $this->db->insert('new_nigeria1',$form_array);
										if($query){
											if($this->recycleNewNigeria2($under,$form_array)){
												// echo "string";
												return true;
											}else{
												return false;
											}
										}else{
											return false;
										}
									}else{//else That Is This Guy Just Hs One Under Him
										//Then We Just Him Normally
										//Stage Remains The Same
										//You Add Him Under The Oga At The Top
										$form_array['under'] = $under;
										$form_array['stage'] = $stage;
										$query = $this->db->insert('new_nigeria1',$form_array);
										if($query){
											return true;
										}else{
											return false;
										}
									}
								}
							}
						}
					}
				}else{
					$query = $this->db->insert('new_nigeria1',$form_array);
					if($query){
						return true;
					}else{
						return false;
					}
				}
			}	
		}

		public function creditAdmin($amount,$type){
			$query = $this->db->get_where('users',array('is_admin' => 1,'user_name' => 'admin'),1);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sponsor_income = $row->sponsor_income;
					$total_income = $row->total_income;
					$new_nigeria_income = $row->new_nigeria_income;
					$great_nigeria_income = $row->great_nigeria_income;
				}
				if($type == "sponsor"){
					$new_sponsor_income = $sponsor_income + $amount;
					$new_total_income = $total_income + $amount;
					$query = $this->db->update('users',array('sponsor_income' => $new_sponsor_income,'total_income' => $new_total_income),array('is_admin' => 1));
					if($query){
						return true;
					}else{
						return false;
					}
				}elseif($type == "new_nigeria"){
					$new_nigeria_income = $new_nigeria_income + $amount;
					$new_total_income = $total_income + $amount;
					$query = $this->db->update('users',array('new_nigeria_income' => $new_nigeria_income,'total_income' => $new_total_income),array('is_admin' => 1));
					if($query){
						return true;
					}else{
						return false;
					}
				}
				
			}		
		}

		public function creditUserNewNigeria($user_id,$amount,$reason){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				$form_array = array();
				foreach($query->result() as $row){
					$new_nigeria_income = $row->new_nigeria_income;
					$great_nigeria_income = $row->great_nigeria_income;
					$sponsor_income = $row->sponsor_income;
					$total_income = $row->total_income;
				}
				if($reason == "sponsor"){
					$sponsor_income = $sponsor_income + $amount;
					$total_income = $total_income + $amount;
					$form_array = array(
						'sponsor_income' => $sponsor_income,
						'total_income' => $total_income
					);
				}elseif($reason == "new_nigeria"){
					$new_nigeria_income = $new_nigeria_income + $amount;
					$total_income = $total_income + $amount;
					$form_array = array(
						'new_nigeria_income' => $new_nigeria_income,
						'total_income' => $total_income
					);
				}

				$this->db->update('users',$form_array,array('id' => $user_id));

			}
		}

		public function checkIfThisStageIsFull($type,$stage){
			if($type == "new_nigeria1"){
				$table = "new_nigeria";
			}elseif($type == "new_nigeria2"){
				$table = "new_nigeria1";
			}
			$previous_stage = $stage - 1;
			if($table == "new_nigeria"){
				$query = $this->db->get_where($table,array('stage' => $stage));
				$no_in_child_stage = $query->num_rows();
				$query = $this->db->get_where($table,array('stage' => $previous_stage));
				$no_in_current_stage = $query->num_rows();
				$total_amount_supposed_to_be_in_current_stage = $no_in_current_stage * 3;
				if($no_in_child_stage == $total_amount_supposed_to_be_in_current_stage){
					return true;
				}else{
					return false;
				}
			}
		}

		public function recycleNewNigeria1($record_id,$form_array){
			//Get Record Id Info

			$query = $this->db->get_where('new_nigeria',array('id' => $record_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$main_user_id = $row->user_id;
					$under = $row->under;
					$stage = $row->stage;
				}
				$childrens_stage = $form_array['stage'];
				$this->creditUserNewNigeria($main_user_id,1500,"new_nigeria");
				$this->creditAdmin(500,"sponsor");
				if($this->checkIfThisStageIsFull('new_nigeria1',$childrens_stage)){
					//Stage Is Full Add To A New Stage Under The First Guy In The Previous Stage
					$new_stage = $stage + 2;
					$query = $this->db->get_where('new_nigeria',array('stage' => $childrens_stage),1);
					foreach($query->result() as $row){
						$id = $row->id;
						$user_id = $row->user_id;						
					}
					$form_array['stage'] = $new_stage;
					$form_array['under'] = $id;
					$form_array['referred_by'] = NULL;
					$form_array = array_merge($form_array,array('recycled' => 1));
					$query = $this->db->insert('new_nigeria',$form_array);
					if($query){
						if($this->performAddingOneNigeria2($main_user_id,$form_array['date'],$form_array['time'])){
							return true;
						}
					}else{
						return false;
					}
				}else{
					//Stage Is Not Full Add To The Present Stage Under The Next Guy In This Stage. i.e first guy under the next guy to be added under
					$new_stage = $stage + 1;
					//Get The Last Guy In Previous Stage With 3 under Him. Then Recycle To The Next Available Guy With No One Under Him.
					$query = $this->db->get_where('new_nigeria',array('stage' => $stage));
					if($query->num_rows() > 0){
						foreach($query->result() as $row){
							$id = $row->id;
							$query = $this->db->get_where('new_nigeria',array('under' => $id,'stage' => $new_stage));
							if($query->num_rows() < 3){
								$this->session->set_userdata('id',$id);
								break;
							}
						}
						$form_array['stage'] = $new_stage;
						$form_array['under'] = $this->session->id;
						unset($_SESSION['id']);
						$form_array['referred_by'] = NULL;
						$form_array = array_merge($form_array,array('recycled' => 1));
						$query = $this->db->insert('new_nigeria',$form_array);
						if($query){
							if($this->performAddingOneNigeria2($main_user_id,$form_array['date'],$form_array['time'])){
								return true;
							}
						}else{
							return false;
						}
					}
				}
			}
		}

		

		public function performAddingOneNigeria1($user_id,$referred_by,$date,$time,$automatic = FALSE){
			//If Referred Is None Set Reference to Null
			if($automatic){
				$automatic = 1;
			}else{
				$automatic = 0;
			}
			if(!$this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 1,'user_name' => 'admin'),1);
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$sponsor_income = $row->sponsor_income;
						$total_income = $row->total_income;
					}

					if($referred_by == "none"){
						$referred_by = NULL;
						//Credit Admin With 400 For Referral
						$new_sponsor_income = $sponsor_income + 500;
						$new_total_income = $total_income + 500;
						$query = $this->db->update('users',array('sponsor_income' => $new_sponsor_income,'total_income' => $new_total_income),array('is_admin' => 1));
						if($query){

						}
					}else{
						//Credit Referred By With 400
						$this->creditUserNewNigeria($referred_by,400,"sponsor");
						$new_sponsor_income = $sponsor_income + 100;
						$new_total_income = $total_income + 100;
						$query = $this->db->update('users',array('sponsor_income' => $new_sponsor_income,'total_income' => $new_total_income),array('is_admin' => 1));
						if($query){

						}
					}
					//Form Array For Inserting New Records
					$form_array = array(
						'user_id' => $user_id,
						'stage' => 0,
						'under' => NULL,
						'referred_by' => $referred_by,
						'date' => $date,
						'time' => $time,
						'automatic' => $automatic
					);
					//Get All New Nigeria Records
					$query = $this->db->get('new_nigeria');
					//Get If Rows Are Greater Than 0.
					if($query->num_rows() > 0){
						//Select The Max Stage
						$this->db->select_max('stage');
						$query = $this->db->get('new_nigeria',1);
						if($query->num_rows() == 1){
							foreach($query->result() as $row){
								// $id = $row->id;
								$stage = $row->stage;
							}
							//If Stage == 0
							if($stage == 0){
								//Just Add This Guy Under The First Guy With Stage Of Stage + 1
								$new_stage = $stage + 1;
								$under = $this->getIdByStage0('new_nigeria',$stage);
								$form_array['under'] = $under;
								$form_array['stage'] = $new_stage;
								$query = $this->db->insert('new_nigeria',$form_array);
								if($query){
									return true;
								}else{
									return false;
								}
							}else{
								//Get Next Available Space To Insert This Guy In

								//Check If There Is More Space In This Stage
								//Get The Last Guy In This Stage To See Where To Place This Guy
								$this->db->select("*");
								$this->db->from("new_nigeria");
								$this->db->where("stage",$stage);
								$this->db->order_by("id","DESC");
								$this->db->limit(1);
								$query = $this->db->get();
								if($query->num_rows() == 1){
									foreach($query->result() as $row){
										$id = $row->id;
										$user_id = $row->user_id;
										$under = $row->under;
									}
									// $previous_stage = $stage - 1;
									$query = $this->db->get_where('new_nigeria',array('under' => $under));
									$num_under_the_guy_above = $query->num_rows();
									if($query->num_rows() > 0){

										//If This Guy Remains One To Full
										if($num_under_the_guy_above == 2){
											//Then We Add This Guy And Recycle The Oga At The Top
											$form_array['under'] = $under;
											$form_array['stage'] = $stage;
											$query = $this->db->insert('new_nigeria',$form_array);
											if($query){
												if($this->recycleNewNigeria1($under,$form_array)){
													return true;
												}else{
													return false;
												}
											}else{
												return false;
											}
										}else{//else That Is This Guy Just Hs One Under Him
											//Then We Just Him Normally
											//Stage Remains The Same
											//You Add Him Under The Oga At The Top
											$form_array['under'] = $under;
											$form_array['stage'] = $stage;
											$query = $this->db->insert('new_nigeria',$form_array);
											if($query){
												return true;
											}else{
												return false;
											}
										}
									}
								}
							}
						}
					}else{
						$query = $this->db->insert('new_nigeria',$form_array);
						if($query){
							return true;
						}else{
							return false;
						}
					}
				}
			}	
		}

		public function getAdminId(){
			$query = $this->db->get_where('users',array('is_admin' => 1));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$id = $row->id;
				}
				return $id;
			}
		}

		public function getUserIdByName($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$user_id = $row->id;
				}
				return $user_id;
			}else{
				return "";
			}
		}

		public function getUserNameByPhone($phone_number,$user_id){
			// $query = $this->db->get_where('users',array('phone' => $phone_number));
			$this->db->select("*");
			$this->db->from('users');
			$this->db->where('id !=',$user_id);
			$this->db->where('phone',$phone_number);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$user_name = $row->user_name;
				}
				return $user_name;
			}else{
				return "";
			}
		}

		public function getUserNameByPhone1($phone_number){
			$query = $this->db->get_where('users',array('phone' => $phone_number));
			
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$user_name = $row->user_name;
				}
				return $user_name;
			}else{
				return false;
			}
		}


		public function getFullNameByPhone($phone_number,$user_id){
			$this->db->select("*");
			$this->db->from('users');
			$this->db->where('id !=',$user_id);
			$this->db->where('phone',$phone_number);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$full_name = $row->full_name;
				}
				return $full_name;
			}else{
				return "";
			}
		}

		public function getHealthFacilityInfoBySlug($slug){
			$query = $this->db->get_where('health_facility',array('slug' => $slug));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getSubDeptsByDeptId($dept_id){
			$query = $this->db->get_where('sub_dept',array('dept_id' => $dept_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfNotifExistsById($id){
			$query = $this->db->get_where('notif',array('id' => $id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function markNotifAsRead($id,$user_id){
			$query = $this->db->get_where('notif',array('id' => $id,'receiver' => $user_id));
			if($query->num_rows() == 1){
				$query = $this->db->update('notif',array('received' => 1),array('id' => $id));
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		public function getFirstPostLikes($post_id){
			$user_id = $this->getUserIdWhenLoggedIn();
			$this->db->select("*");
			$this->db->from("posts");
			$this->db->where("id",$post_id);
			$query  = $this->db->get();
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$likes = $row->likes;
				}
				if($likes !== ""){
					$likes_arr = explode(",", $likes);
					$likes_arr = array_reverse($likes_arr);
					// $likes_arr = array_slice($likes_arr,0, 2);
					return $likes_arr;
				}
			}
		}

		public function getFirstPostLikesHealth($post_id){
			$user_id = $this->getUserIdWhenLoggedIn();
			$this->db->select("*");
			$this->db->from("health_posts");
			$this->db->where("id",$post_id);
			$query  = $this->db->get();
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$likes = $row->likes;
				}
				if($likes !== ""){
					$likes_arr = explode(",", $likes);
					$likes_arr = array_reverse($likes_arr);
					// $likes_arr = array_slice($likes_arr,0, 2);
					return $likes_arr;
				}
			}
		}

		public function getSocialMediaTime($post_date,$post_time){
			$social_formated_time = "";
			if($post_date !== "" && $post_time !== ""){
				$post_date = strtotime($post_date);
				$post_date = date("j M Y",$post_date);
				$post_time = strtotime($post_time);
				$post_time = date("H:i:s",$post_time);

				$post_date1 = $post_date;
				$post_time1 = $post_time;

				$curr_date = date("j M Y");
				$curr_time = date("h:i:sa");
				$curr_date = date("j M Y",strtotime($curr_date));
				$curr_time = date("H:i:s",strtotime($curr_time));
				
				$curr_date = $curr_date . " " . $curr_time;
				// echo $curr_date;
				$curr_date = new DateTime($curr_date);
				$post_date = $post_date . " " .$post_time;
				$post_date = new DateTime($post_date);

				$time_diff = $curr_date->getTimestamp() - $post_date->getTimestamp();
				// echo $time_diff;
				if($time_diff >= 0){
					//First Check If Time Is Greater Equal
					if($time_diff == 0){
						$social_formated_time = "Just Now";
					}else if($time_diff <= 60){
						$social_formated_time = $time_diff . " secs ago";
					}else if(($time_diff > 60) && ($time_diff < 3600)){
						$social_formated_time = floor($time_diff / 60);
					 	$social_formated_time = $social_formated_time . " mins ago";
					}else if(($time_diff >= 3600) && ($time_diff < 86400)){
					 	$social_formated_time = floor($time_diff / 3600);
					 	if($social_formated_time == 1){
						 	$social_formated_time = $social_formated_time . " hour ago";
						}else{
							$social_formated_time = $social_formated_time . " hours ago";
						}
					}else if(($time_diff >= 86400) && ($time_diff < 2628000)){
					 	$social_formated_time = floor($time_diff / 86400);
					 	if($social_formated_time == 1){
					 		$social_formated_time = $social_formated_time . " day ago";
					 	}else{
					 		$social_formated_time = $social_formated_time . " days ago";
					 	}
					}else if(($time_diff >= 2628000) && (date("Y") == date("Y",strtotime($post_date1)))){
					 	$social_formated_time = date("j M",strtotime($post_date1));
					}else if ((date("Y") !== date("Y",strtotime($post_date1)))) {
					 	$social_formated_time = date("j M Y",strtotime($post_date1));
					}
				}
			}
			return $social_formated_time;
		}

		public function checkIfUserIsAdmin(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where('users',array('id' => $user_id,'is_admin' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsAdmin1($user_id){
			
			$query = $this->db->get_where('users',array('id' => $user_id,'is_admin' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfProductForCenterLeaderHasBeenGivenADispatcher($product_id,$center_leader_id){
			$query = $this->db->get_where('mini_importation_orders',array('product_id' => $product_id,'center_leader' => $center_leader_id,'sent_to_dispatcher' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getDispatcherIdForProductForCenterLeader($product_id,$center_leader_id){
			$query = $this->db->get_where('mini_importation_orders',array('product_id' => $product_id,'center_leader' => $center_leader_id),1);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$dispatcher = $row->dispatcher;
				}
				return $dispatcher;
			}else{
				return false;
			}
				
		}

		public function checkIfDispatcherForProductForCenterLeaderHasApprovedReceiptOfProduct($product_id,$center_leader_id){
			$query = $this->db->get_where('mini_importation_orders',array('product_id' => $product_id,'center_leader' => $center_leader_id,'with_dispatcher' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function updateMiniImportationOrderDispatcher($form_array,$center_leader_id,$product_id){
			return $this->db->update("mini_importation_orders",$form_array,array('center_leader' => $center_leader_id,'product_id' => $product_id,'sent_to_dispatcher' => 0));
		}

		public function updateMiniImportationOrderUserPickedUpGoods($form_array,$order_id){
			return $this->db->update("mini_importation_orders",$form_array,array('dispatched' => 1,'id' => $order_id));
		}

		public function checkIfProductCenterLeaderHasADispatcherAlready($center_leader_id,$product_id){
			$query = $this->db->get_where("mini_importation_orders",array('center_leader' => $center_leader_id,'product_id' => $product_id,'sent_to_dispatcher' => 0),1);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$dispatcher = $row->dispatcher;
				}
				if(is_null($dispatcher)){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		public function checkIfAllMiniImportationSlotsHaveBeenTaken($product_id){
			$query = $this->db->get_where('products_mini_importation',array('id' => $product_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$quantity = $row->quantity;
					$quantity_purchased = $row->quantity_purchased;

					if(($quantity - $quantity_purchased) == 0){
						return true;
					}else{
						return false;
					}
				}
			}
		}

		public function getCenterLeaderOnTheWayProducts(){
			// $query = $this->db->get_where("mini_importation_orders",array('gotten_to_center_leader' => 0));
			$ret_arr = array();
			$this->db->select("*");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",0);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$product_id = $row->product_id;
					$quantity_purchased = $this->getProductParamByIdMiniImportation("quantity_purchased",$product_id);
					$original_quantity = $this->getProductParamByIdMiniImportation("quantity",$product_id);
					$progress_percent = ($quantity_purchased / $original_quantity) * 100;

			        
					if(!$this->checkIfMiniImportationProductIdHasExpired($product_id) || $this->checkIfAllMiniImportationSlotsHaveBeenTaken($product_id)){
						if($progress_percent >= 50){
							$ret_arr[] = $product_id;
						}else{
							$this->allenexpress_model->refundMoneyPaidForProductMiniImportationToAllUsers($product_id);
						}
					}
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function markOrderAsPickedUpByUser($order_id,$date,$time,$user_id){
			$form_array = array(
				'received_by_user' => 1
			);
			if($this->updateMiniImportationOrderUserPickedUpGoods($form_array,$order_id)){
				$product_amount_paid = $this->getMiniImportationOrderParamById("product_amount_paid",$order_id);
				$total_shipping_fee = $this->getMiniImportationOrderParamById("shipping_fee",$order_id);

				$service_charge = (0.05 * ($product_amount_paid + $total_shipping_fee));

				$center_leader_id = $this->getMiniImportationOrderParamById("center_leader",$order_id);
				$amount_to_credit_center_leader = 300 + (0.005 * ($product_amount_paid + $total_shipping_fee));
				if($this->creditCenterLeaderSelectionIncome($center_leader_id,$amount_to_credit_center_leader)){
					$amount_to_credit_admin = 200 + (0.010 * ($product_amount_paid + $total_shipping_fee));
					if($this->creditAdminCenterLeaderSelectionIncome($amount_to_credit_admin)){
						$mlm_db_id = $this->getUsersFirstMlmDbId($user_id);
						$placement_income = (0.0023 * ($product_amount_paid + $total_shipping_fee));
						$placement_income_vat = 5;
						$real_placement_income = $placement_income - (0.05 * $placement_income);
						$charge_type = 13;
						$placement_income_vat_val = (0.05 * $placement_income);
						if($this->creditUserPlacementIncome($mlm_db_id,$placement_income,$placement_income_vat,$real_placement_income,$charge_type,$date,$time,$placement_income_vat_val)){
							return true;
						}
					}
				}
			}
		}

		public function viewOrdersAwaitingCenterLeadersApproval(){
			// $query = $this->db->get_where("mini_importation_orders",array('gotten_to_center_leader' => 0));
			$ret_arr = array();
			$this->db->select("*");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",1);
			$this->db->where("center_leader_recieved",0);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$product_id = $row->product_id;
					$ret_arr[] = $product_id;
				}
			}
			// print_r($query->result());

			return array_values(array_unique($ret_arr));
		}

		public function viewOrdersWithCenterLeadersApproval(){
			// $query = $this->db->get_where("mini_importation_orders",array('gotten_to_center_leader' => 0));
			$ret_arr = array();
			$this->db->select("*");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",1);
			$this->db->where("center_leader_recieved",1);
			$this->db->where("dispatched",0);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$product_id = $row->product_id;
					$ret_arr[] = $product_id;
				}
			}
			// print_r($query->result());

			return array_values(array_unique($ret_arr));
		}

		public function getMiniImportationOrderParamByCenterLeaderIdAndProductId($param,$center_leader_id,$product_id){
			$query = $this->db->get_where("mini_importation_orders",array('center_leader' => $center_leader_id,'product_id' => $product_id),1);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}else{
				return false;
			}
		}

		public function confirmThisIsTheRealDispatchOfficer($user_id,$product_id,$center_leader_id){
			$query = $this->db->get_where("mini_importation_orders",array('product_id' => $product_id,'center_leader' => $center_leader_id,'dispatcher' => $user_id,'sent_to_dispatcher' => 1,'with_dispatcher' => 0));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}



		public function updateMiniImportationOrderDispatcherAsAccepted($product_id,$center_leader_id){
			return $this->db->update("mini_importation_orders",array('with_dispatcher' => 1),array('product_id' => $product_id,'center_leader' => $center_leader_id,'sent_to_dispatcher' => 1,'with_dispatcher' => 0));
		}

		public function updateMiniImportationOrderCenterLeaderrAsReceived($product_id,$center_leader_id){
			return $this->db->update("mini_importation_orders",array('center_leader_recieved' => 1),array('product_id' => $product_id,'center_leader' => $center_leader_id,'sent_to_dispatcher' => 1,'with_dispatcher' => 1,'gotten_to_center_leader' => 1,'center_leader_recieved' => 0));
		}

		public function getAllUsersWhoHaveShareInThisOrder($product_id,$center_leader_id){
			$ret_arr = array();
			$query = $this->db->get_where("mini_importation_orders",array('product_id' => $product_id,'center_leader' => $center_leader_id,'center_leader_recieved' => 1,'dispatched' => 0));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$user_id = $row->user_id;
					$ret_arr[] = $user_id;
				}
			}
			return array_values(array_unique($ret_arr));
		}

		public function checkIfThisCenterLeaderAndProductIdIsForThisDispatcher($user_id,$center_leader_id,$product_id){
			$query = $this->db->get_where("mini_importation_orders",array('center_leader' => $center_leader_id,'product_id' => $product_id,'sent_to_dispatcher' => 1,'dispatcher' => $user_id,'gotten_to_center_leader' => 0,'with_dispatcher' => 0));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function makeSureUserIsTheRightDispatcherForMiniImportationOrder($product_id,$center_leader_id,$user_id){
			$query = $this->db->get_where("mini_importation_orders",array('center_leader' => $center_leader_id,'product_id' => $product_id,'sent_to_dispatcher' => 1,'dispatcher' => $user_id,'gotten_to_center_leader' => 0,'with_dispatcher' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function markCenterLeaderProductAsDeliveredToHim($center_leader_id,$product_id,$user_id,$date,$time){
			return $this->db->update("mini_importation_orders",array('gotten_to_center_leader' => 1,'gotten_to_center_leader_date' => $date,'gotten_to_center_leader_time' => $time),array('sent_to_dispatcher' => 1,'dispatcher' => $user_id,'gotten_to_center_leader' => 0,'with_dispatcher' => 1));
		}

		public function checkIfThisCenterLeaderAndProductIdIsForThisDispatcher1($user_id,$center_leader_id,$product_id){
			$query = $this->db->get_where("mini_importation_orders",array('center_leader' => $center_leader_id,'product_id' => $product_id,'sent_to_dispatcher' => 1,'dispatcher' => $user_id,'gotten_to_center_leader' => 0,'with_dispatcher' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getCenterLeaderOnTheWayProductsNewDispatcherRequests($user_id){
			// $query = $this->db->get_where("mini_importation_orders",array('gotten_to_center_leader' => 0));
			$ret_arr = array();
			$this->db->select("product_id");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",0);
			$this->db->where("sent_to_dispatcher",1);
			$this->db->where("with_dispatcher",0);
			$this->db->where("dispatcher",$user_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$product_id = $row->product_id;
					$ret_arr[] = $product_id;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function getCenterLeaderOnTheWayProductsPreviousDispatcherRequests($user_id){
			// $query = $this->db->get_where("mini_importation_orders",array('gotten_to_center_leader' => 0));
			$ret_arr = array();
			$this->db->select("product_id");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",0);
			$this->db->where("sent_to_dispatcher",1);
			$this->db->where("with_dispatcher",1);
			$this->db->where("dispatcher",$user_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$product_id = $row->product_id;
					$ret_arr[] = $product_id;
				}
			}

			return array_values(array_unique($ret_arr));
		}

		public function getMiniImportationCenterLeaderUserIds($product_id){
			$ret_arr = array();
			$this->db->select("center_leader");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",0);
			$this->db->where("product_id",$product_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$center_leader = $row->center_leader;
					$ret_arr[] = $center_leader;
				}
			}
			return array_values(array_unique($ret_arr));
		}


		public function getMiniImportationCenterLeaderUserIdsAwaitingCenterLeaderApproval($product_id){
			$ret_arr = array();
			$this->db->select("center_leader");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",1);
			$this->db->where("center_leader_recieved",0);
			$this->db->where("product_id",$product_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$center_leader = $row->center_leader;
					$ret_arr[] = $center_leader;
				}
			}
			return array_values(array_unique($ret_arr));
		}

		public function getUsersWhoHaveShareInOrderByProductIdAndCenterLeaderId($product_id,$center_leader_id){
			$this->db->select("*");
			$this->db->from("mini_importation_orders");
			$this->db->where("center_leader",$center_leader_id);
			$this->db->where("product_id",$product_id);
			$this->db->where("center_leader_recieved",1);
			$this->db->where("dispatched",0);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function markOrderAsDeliveredToFinalUserByCenterLeader($order_id,$user_id){
			return $this->db->update("mini_importation_orders",array('dispatched' => 1),array('center_leader' => $user_id,'dispatched' => 0,'center_leader_recieved' => 1,'id' => $order_id));
		}

		public function getMiniImportationOrderParamById($param,$order_id){
			$query = $this->db->get_where("mini_importation_orders",array('id' => $order_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}else{
				return false;
			}
		}

		public function getMiniImportationCenterLeaderUserIdsWithCenterLeaderApproval($product_id){
			$ret_arr = array();
			$this->db->select("center_leader");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",1);
			$this->db->where("center_leader_recieved",1);
			$this->db->where("dispatched",0);
			$this->db->where("product_id",$product_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$center_leader = $row->center_leader;
					$ret_arr[] = $center_leader;
				}
			}
			return array_values(array_unique($ret_arr));
		}

		public function getUsersWhoAreNotDispatchers(){
			$this->db->select("*");
			$this->db->from("users");
			$this->db->where("dispatcher",0);
			$this->db->order_by("full_name","ASC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function listAllDispatchers(){
			$this->db->select("*");
			$this->db->from("users");
			$this->db->where("dispatcher",1);
			$this->db->order_by("full_name","ASC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getMiniImportationOrderStatusesByProductIdAndCenterLeaderId($product_id,$center_leader_id){
			// $query = $this->db->get_where("mini_importation_orders_status",array('product_id' => $product_id,'center_leader' => $center_leader_id));

			$this->db->select("*");
			$this->db->from("mini_importation_orders_status");
			$this->db->where("product_id",$product_id);
			$this->db->where("center_leader",$center_leader_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function updateMiniImportationStatusTable($form_array){
			return $this->db->insert("mini_importation_orders_status",$form_array);
		}

		public function getMiniImportationCenterLeaderUserIds1($product_id,$center_leader_id){
			$ret_arr = array();
			$this->db->select("center_leader");
			$this->db->from("mini_importation_orders");
			$this->db->where("gotten_to_center_leader",0);
			$this->db->where("product_id",$product_id);
			$this->db->where("center_leader",$center_leader_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$center_leader = $row->center_leader;
					$ret_arr[] = $center_leader;
				}
			}
			return array_values(array_unique($ret_arr));
		}

		public function getMiniImportationCenterLeaderUserIds2($product_id,$center_leader_id){
			$ret_arr = array();
			$this->db->select("center_leader");
			$this->db->from("mini_importation_orders");
			
			$this->db->where("product_id",$product_id);
			$this->db->where("center_leader",$center_leader_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$center_leader = $row->center_leader;
					$ret_arr[] = $center_leader;
				}
			}
			return array_values(array_unique($ret_arr));
		}

		public function getMiniImportationProductQuantityComingToCenterLeader($product_id,$center_leader_id){
			$total_quantity = 0;
			$query = $this->db->get_where("mini_importation_orders",array('product_id' => $product_id,'center_leader' => $center_leader_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$quantity = $row->quantity;
					$total_quantity += $quantity;
				}
			}
			return $total_quantity;
		}

		public function uploadBannerImage($form_array){
			return $this->db->insert("mini_importation_banners",$form_array);
		}

		public function checkIfMiniImportationProductIdIsValid($product_id){
			$query = $this->db->get_where('products_mini_importation',array('id' => $product_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfMiniImportationProductIdIsInStock($product_id){
			$query = $this->db->get_where('products_mini_importation',array('id' => $product_id));

			if($query->num_rows() == 1){

				foreach($query->result() as $row){
					$quantity = $row->quantity;
					$quantity_purchased = $row->quantity_purchased;

					if($quantity == $quantity_purchased){
						return false;
					}else{
						return true;
					}
				}
			}else{
				return false;
			}
		}

		public function checkIfThisProductIsInCartAlreadyMiniImportation($product_id){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where('mini_importation_cart',array('product_id' => $product_id,'user_id' => $user_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getCartParamByIdMiniImportation($param,$cart_id){
			$query = $this->db->get_where('mini_importation_cart',array('id' => $cart_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}else{
				return false;
			}
		}

		public function getMiniImportationCartIdByProductIdAndUserId($product_id,$user_id){
			$query = $this->db->get_where('mini_importation_cart',array('product_id' => $product_id,'user_id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$cart_id = $row->id;
				}
				return $cart_id;
			}else{
				return false;
			}
		}

		public function getTotalSumOfProductsSelectedPlusShippingMiniImportation(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$total = 0;
			$query = $this->db->get_where('mini_importation_cart',array('user_id' => $user_id,'checked_out' => 0));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$product_id = $row->product_id;
					$quantity = $row->quantity;
					$product_quantity = $this->allenexpress_model->getProductParamByIdMiniImportation("quantity",$product_id);
					$product_quantity_purchased = $this->allenexpress_model->getProductParamByIdMiniImportation("quantity_purchased",$product_id);
					$remaining_product_quantity = $product_quantity - $product_quantity_purchased;

					if($remaining_product_quantity >= $quantity){
						
					}else{

						if($quantity > $remaining_product_quantity){
							if($this->allenexpress_model->readjustMiniImpotationCartForUserIfItExceedsRemainingQuantity($product_id,$user_id)){
								$quantity = $this->allenexpress_model->getCartParamByIdMiniImportation("quantity",$id);
							}
						}
					}

					$product_cost = $this->allenexpress_model->getProductParamByIdMiniImportation("new_price",$product_id) * $quantity;
					$product_shipping_cost = $this->allenexpress_model->getProductParamByIdMiniImportation("shipping_fee",$product_id) * $quantity;

					$total_product_cost = $product_cost + $product_shipping_cost;
					$total += $total_product_cost;
				}
			}
			return $total + ($total * 0.05);
		}

		public function checkIfUserIsAValidCenterLeader($center_leader_user_id){
			$query = $this->db->get_where("users",array('id' => $center_leader_user_id,'center_leader' => 1));
			if($query->num_rows()){
				return true;
			}else{
				return false;
			}
		}

		public function readjustMiniImpotationCartForUserIfItExceedsRemainingQuantity($product_id,$user_id){
			$cart_id = $this->getMiniImportationCartIdByProductIdAndUserId($product_id,$user_id);
			$product_quantity = $this->getProductParamByIdMiniImportation("quantity",$product_id);
			$product_quantity_purchased = $this->getProductParamByIdMiniImportation("quantity_purchased",$product_id);
			$remaining_product_quantity = $product_quantity - $product_quantity_purchased;
			return $this->db->update('mini_importation_cart',array('quantity' => $remaining_product_quantity));
		}

		public function checkIfSlotsForProductIsStillRemainingForYou($new_quantity,$product_id,$user_id){
			$product_quantity = $this->getProductParamByIdMiniImportation("quantity",$product_id);
			$product_quantity_purchased = $this->getProductParamByIdMiniImportation("quantity_purchased",$product_id);
			$remaining_product_quantity = $product_quantity - $product_quantity_purchased;

			if($remaining_product_quantity >= $new_quantity){
				return true;
			}else{
				if(($new_quantity - 1) > $remaining_product_quantity){
					$this->readjustMiniImpotationCartForUserIfItExceedsRemainingQuantity($product_id,$user_id);
				}
				return false;
			}
		}


		public function getQuantityOfProductRequestedInCartMiniImportation($product_id){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where('mini_importation_cart',array('product_id' => $product_id,'user_id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$quantity = $row->quantity;
					return $quantity;
				}
			}else{
				return false;
			}
		}

		public function getMiniImportationProductsSelecetedByUserInArrForm(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$ret_arr = array();
			$query = $this->db->get_where('mini_importation_cart',array('checked_out' => 0));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$product_id = $row->product_id;
					$quantity = $row->quantity;
					$shipping_fee = $this->getProductParamByIdMiniImportation("shipping_fee",$product_id);
					$ret_arr[] = array(
						'product_id' => $product_id,
						'quantity' => $quantity,
						'shipping_fee' => $shipping_fee,
						'cart_id' => $id
					);
				}
			}
			return $ret_arr;
		}

		public function updateMiniImportationCart1($form_array,$user_id){
			return $this->db->update("mini_importation_cart",$form_array,array('user_id' => $user_id,'checked_out' => 0));
		}

		public function updateMiniImportationCart($form_array,$cart_id,$user_id){
			return $this->db->update("mini_importation_cart",$form_array,array('id' => $cart_id,'user_id' => $user_id));
		}

		public function insertMiniImportationCart($form_array){
			return $this->db->insert("mini_importation_cart",$form_array);
		}

		public function moveMiniImportationCartRowToOrdersTable($form_array,$cart_id,$user_id){
			if($this->db->insert("mini_importation_orders",$form_array)){
				return $this->db->delete("mini_importation_cart",array('id' => $cart_id));
			}
		}

		public function getMiniImportationOrderNumberOfProducts($order_code){
			$query = $this->db->get_where("mini_importation_orders",array('order_code' => $order_code));
			return $query->num_rows();
		}

		public function getMiniImportationOrderParamByOrderCode($param,$order_code){
			$query = $this->db->get_where('mini_importation_orders',array('order_code' => $order_code),1);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}
		}

		public function getMiniImportationOrderParamByUserIdProductIdAndCenterLeaderId($param,$user_id,$product_id,$center_leader_id){
			$query = $this->db->get_where('mini_importation_orders',array('user_id' => $user_id,'product_id' => $product_id,'center_leader' => $center_leader_id,'center_leader_recieved' => 1,'dispatched' => 0));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}
		}


		public function getMiniImportationOrderCodes(){
			$ret_arr = array();
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where('mini_importation_orders',array('user_id' => $user_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$order_code = $row->order_code;
					$ret_arr[] = $order_code;
				}
				$ret_arr = array_values(array_unique($ret_arr));
			}
			return $ret_arr;
		}

		public function getNumberOfProductsInCart(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$ret = 0;
			$query = $this->db->get_where('mini_importation_cart',array('user_id' => $user_id,'checked_out' => 0));
			if($query->num_rows() > 0){

				foreach($query->result() as $row){
					$id = $row->id;
					$product_id = $row->product_id;

					if($this->checkIfMiniImportationProductIdIsInStock($product_id)){
						
						if($this->checkIfMiniImportationProductIdHasExpired($product_id)){
							$ret++;
						}
					}
				}
			}

			return $ret;
		}

		public function getProductParamByIdMiniImportation($param,$product_id){
			$query = $this->db->get_where("products_mini_importation",array('id' => $product_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}else{
				return false;
			}
		}

		public function getMiniImportationCartInfo(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where('mini_importation_cart',array('user_id' => $user_id,'checked_out' => 0));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getCartIdOfProductRequestedInCartMiniImportation($product_id){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where('mini_importation_cart',array('product_id' => $product_id,'user_id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$id = $row->id;
					return $id;
				}
			}else{
				return false;
			}
		}

		public function removeItemFromCart($cart_id,$user_id){
			return $this->db->delete('mini_importation_cart',array('id' => $cart_id,'user_id' => $user_id));
		}

		public function getMiniImportationOrderParamByUserIdAndProductId($param,$user_id,$product_id){
			$query = $this->db->get_where("mini_importation_orders",array('user_id' => $user_id,'product_id' => $product_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}else{
				return false;
			}
		}

		public function getUsersWhoHaveSlotsInProduct($product_id){
			$ret_arr = array();
			$query = $this->db->get_where("mini_importation_orders",array('product_id' => $product_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$user_id = $row->user_id;
					$quantity = $row->quantity;
					if($quantity > 0){
						$ret_arr[] = $user_id;
					}
				}
			}
			return $ret_arr;
		}

		public function refundMoneyPaidForProductMiniImportationToAllUsers($product_id){
			if($this->getProductParamByIdMiniImportation("refunded",$product_id) == 0){
				$partakers_ids = $this->getUsersWhoHaveSlotsInProduct($product_id);
				if(is_array($partakers_ids)){
					for($i = 0; $i < count($partakers_ids); $i++){
						$user_id = $partakers_ids[$i];
						$product_amount_paid = $this->getMiniImportationOrderParamByUserIdAndProductId("product_amount_paid",$user_id,$product_id);
						$shipping_fee = $this->getMiniImportationOrderParamByUserIdAndProductId("shipping_fee",$user_id,$product_id);
						$total_amount_paid = $product_amount_paid + $shipping_fee;
						$total_amount_paid + ($total_amount_paid * 0.05);
						$check_out_date = $this->getMiniImportationOrderParamByUserIdAndProductId("check_out_date",$user_id,$product_id);
						$order_code = $this->getMiniImportationOrderParamByUserIdAndProductId("order_code",$user_id,$product_id);
						$quantity_purchased = $this->getProductParamByIdMiniImportation("quantity",$product_id);
						$product_name = $this->getProductParamByIdMiniImportation("name",$product_id);
						$form_array = array(
							'refunded' => 1
						);
						if($this->updateProduct($form_array,$product_id)){
							if($this->creditUser($user_id,$total_amount_paid)){
								$title = "Credit Alert";
				        		$message = "This Is To Inform You That The Money For Your Product Purchase With Order Code: <em class='text-primary'>".$order_code."</em> For <em class='text-primary'>".$quantity_purchased."</em> Units Of <em class='text-primary'>".$product_name."</em> Amounting To <em class='text-primary'> ₦ ".number_format($total_amount_paid,2)."</em> Has Been Refunded";
				        		$date =	date("j M Y");
								$time = date("H:i:s");
								$btn1 = '<a href="'.site_url('Sabicapital/mini_importation_refunds').'" class="btn btn-info">View Your Refunds History</a>';

								$form_array = array(
									'sender' => $this->getAdminId(),
									'receiver' => $user_id,
									'title' => $title,
									'message' => $message,
									'date_sent' => $date,
									'time_sent' => $time,
									'type' => 'misc',
									'btn_1' => $btn1
								);

								if($this->allenexpress_model->sendMessage($form_array)){
									$form_array = array(
										'user_id' => $user_id,
										'product_id' => $product_id,
										'amount' => $total_amount_paid,
										'date' => $date,
										'time' => $time
									);
									return $this->db->insert("mini_importation_refunds",$form_array);
								}
							}
						}	
					}
				}
			}
			return true;
		}

		public function getMiniImportationRefunds(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where("mini_importation_refunds",array('user_id' => $user_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function checkIfMiniImportationProductIdHasExpired($product_id){
			$query = $this->db->get_where('products_mini_importation',array('id' => $product_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$expiry_date = $row->expiry_date;

					$now = time(); // or your date as well
					$your_date = strtotime($expiry_date);
					$datediff = $your_date - $now;

					$datediff = $datediff / (60 * 60 * 24);
					if($datediff >= 0){
						return true;
					}else{
						return false;
					}
				}
			}else{
				return false;
			}
		}

		public function getMiniImportationBanners(){
			$query = $this->db->get("mini_importation_banners");
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function uploadProduct($form_array){
			return $this->db->insert('products_mini_importation',$form_array);
		}

		public function uploadMerchantProduct($form_array){
			return $this->db->insert('merchants_products_mini_importation',$form_array);
		}

		public function updateProduct($form_array,$product_id){
			return $this->db->update('products_mini_importation',$form_array,array('id' => $product_id));
		}

		public function getAllMerchantRequests(){
			$query = $this->db->get_where('merchants_products_mini_importation',array('disapproved' => 0));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getMerchantRequestInfo($id){
			$query = $this->db->get_where('merchants_products_mini_importation',array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getMerchantRequestParamById($param,$id){
			$query = $this->db->get_where("merchants_products_mini_importation",array('id' => $id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}else{
				return false;
			}
		}

		public function getDisapprovedRequests($user_id){
			$query = $this->db->get_where("merchants_products_mini_importation",array('user_id' => $user_id,'disapproved' => 1));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getDisapprovedRequestInfo($user_id,$id){
			$query = $this->db->get_where("merchants_products_mini_importation",array('id' => $id,'user_id' => $user_id,'disapproved' => 1));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function disapproveMerchantRequest($id,$date,$time){
			$query = $this->db->update('merchants_products_mini_importation',array('disapproved' => 1),array('id' => $id));
			if($query){
				$sent_date = $this->getMerchantRequestParamById("upload_date",$id) . " " . $this->getMerchantRequestParamById("upload_time",$id);
				$product_name = $this->getMerchantRequestParamById("name",$id);
				$image = $this->getMerchantRequestParamById("image",$id);
				$user_id = $this->getMerchantRequestParamById("user_id",$id);

				$title = "Notice Of Merchant Request Disapproval";
        		$message = "This Is To Alert You That You Your Merchant Request You Made On " . $sent_date . " Has Been Disapproved. You Can View Details Below. View More Details On The Merchant Request Tab In <a href='".site_url('Sabicapital/mini_importation')."'>Mini Importation</a>";
        		$message .= "<div class='container' style='margin-top: 30px;'>";
        		$message .= "<p>Product Name: <em class='text-primary'>".$product_name."</em><p>";
        		$message .= "<p>Product Image: <p>";
        		$message .= "<img class='col-sm-6' src='".base_url('assets/images/'.$image)."'/>";
        		
        		$message .= "</div>";
        		

				$form_array = array(
					'sender' => "System",
					'receiver' => $user_id,
					'title' => $title,
					'message' => $message,
					'date_sent' => $date,
					'time_sent' => $time,
					'type' => 'misc'
				);

				if($this->sendMessage($form_array)){
					return true;
				}
			}else{
				return false;
			}
		}

		public function checkIfMerchantRequestIdIsValid($id){
			$query = $this->db->get_where('merchants_products_mini_importation',array('id' => $id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function deleteMerchantRequest($id){
			return $this->db->delete("merchants_products_mini_importation",array('id' => $id));
		}

		public function genereateDatabaseTableFieldsString($table_name){
			$query_str = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '".$table_name."'";
			$query = $this->db->query($query_str);
			$ret = "";
			foreach($query->result() as $row){
				$column_name = $row->COLUMN_NAME;
				$ret .= "$".$column_name . " = " . "$" . "row" . "->" . $column_name . ";<br>";
			}
			echo $ret;
		}

		public function getMiniImportationProductInfoById($product_id){
			$query = $this->db->get_where("products_mini_importation",array('id' => $product_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getMiniImportationProducts(){
			$ret = array();
			$query = $this->db->get("products_mini_importation");
			$j = -1;
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$j++;
					$id = $row->id;
					if($this->checkIfMiniImportationProductIdHasExpired($id)){
						$ret[$j] = $query->result()[$j];
					}
				}
			}else{
				return false;
			}

			return $ret;
		}

		public function getUsersWithSlotsOnProductMiniImportation($product_id){
			$query = $this->db->get_where('mini_importation_orders',array('checked_out' => 1,'product_id' => $product_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUserParamById($param,$user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				return $query->result()[0]->$param;
			}else{
				return false;
			}
		}

		public function getLiveMiniImportationProducts(){
			$ret = array();
			$query = $this->db->get("products_mini_importation");
			$j = -1;
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$j++;
					$id = $row->id;
					$quantity = $row->quantity;
					$quantity_purchased = $row->quantity_purchased;
					if($quantity > $quantity_purchased){
						if($this->checkIfMiniImportationProductIdHasExpired($id)){
							$ret[$j] = $query->result()[$j];
						}
					}
				}
			}else{
				return false;
			}

			return $ret;
		}

		public function getExpiredMiniImportationProducts(){
			$ret = array();
			$query = $this->db->get("products_mini_importation");
			$j = -1;
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$j++;
					$id = $row->id;
					$quantity = $row->quantity;
					$quantity_purchased = $row->quantity_purchased;
					
					if(!$this->checkIfMiniImportationProductIdHasExpired($id)){
						$ret[$j] = $query->result()[$j];
					}
					
				}
			}else{
				return false;
			}

			return $ret;
		}

		public function getTotalNoOfRrgisteredUsers(){
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 0));
				return $query->num_rows();
			}
		}
		public function checkIfThisUserIsSubscribed($user_id){
			$query = $this->db->get_where('new_nigeria',array('user_id' => $user_id,'recycled' => 0));
			if($query->num_rows() > 0){
				return true;
			}else{
				$query = $this->db->get_where('great_nigeria',array('user_id' => $user_id,'recycled' => 0));
				if($query->num_rows() > 0){
					return true;
				}else{					
					return false;
				}				
			}
		}

		public function getTotalNoOfAccountsSubscribed(){
			$ret = 0;
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 0));
				if($query->num_rows() > 0){
					foreach($query->result() as $row){
						$user_id = $row->id;
						if($this->checkIfThisUserIsSubscribed($user_id)){
							$ret++;
						}
					}
				}
			}
			return $ret;
		}

		public function getTotalNoOfRecycles($type){
			$ret = 0;
			if($this->checkIfUserIsAdmin()){
				if($type == "new_nigeria"){
					$query = $this->db->get_where('new_nigeria',array('recycled' => 1));
					$ret += $query->num_rows();
					$query = $this->db->get_where('new_nigeria1',array('recycled' => 1));
					$ret += $query->num_rows();
				}elseif($type == "great_nigeria"){
					$query = $this->db->get_where('great_nigeria',array('recycled' => 1));
					$ret += $query->num_rows();
					$query = $this->db->get_where('great_nigeria1',array('recycled' => 1));
					$ret += $query->num_rows();
				}
			}
			return $ret;
		}

		public function checkIfThereIsActiveResubscription($type){
			$user_id = $this->getUserIdWhenLoggedIn();
			if($type == "new_nigeria"){
				$query = $this->db->get_where('users',array('id' => $user_id,'active_subscription1' => 1));
				if($query->num_rows() == 1){
					return true;
				}else{
					return false;
				}
			}elseif($type == "great_nigeria"){
				$query = $this->db->get_where('users',array('id' => $user_id,'active_subscription2' => 1));
				if($query->num_rows() == 1){
					return true;
				}else{
					return false;
				}
			}
		}

		// public function getActiveSubscriptionInterval($type){
		// 	$user_id = $this->getUserIdWhenLoggedIn();
		// 	if($type == "new_nigeria"){
		// 		$sear = "active_subscription1";
		// 		$search = "active_subscription1_interval";
		// 	}elseif($type == "great_nigeria"){
		// 		$sear = "active_subscription2";
		// 		$search = "active_subscription2_interval";
		// 	}
		// 	$query = $this->db->get_where('users',array('id' => $user_id,$sear => 1));
		// 		if($query->num_rows() == 1){
		// 			foreach($query->result() as $row){
		// 				$interval = $row->$search;
		// 			}
		// 			return $interval;
		// 		}else{
		// 			return false;
		// 		}
		// }

		// public function getActiveSubscriptionStart($type){
		// 	$user_id = $this->getUserIdWhenLoggedIn();
		// 	if($type == "new_nigeria"){
		// 		$sear = "active_subscription1";
		// 		$search = "active_subscription1_start_date";
		// 	}elseif($type == "great_nigeria"){
		// 		$sear = "active_subscription2";
		// 		$search = "active_subscription2_start_date";
		// 	}
		// 	$query = $this->db->get_where('users',array('id' => $user_id,$sear => 1));
		// 		if($query->num_rows() == 1){
		// 			foreach($query->result() as $row){
		// 				$interval = $row->$search;
		// 			}
		// 			return $interval;
		// 		}else{
		// 			return false;
		// 		}
		// }

		public function getTotalSystemBonus(){
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 1));
				if($query->num_rows() > 0){
					foreach($query->result() as $row){
						$sponsor_income = $row->sponsor_income;
					}
					return number_format($sponsor_income);
				}
			}
		}

		public function checkIfAutoResubHasBeenDoneToday($user_id,$date,$type){
			
			$query = $this->db->get_where($type,array('user_id' => $user_id,'date' => $date,'automatic' => 1));
			if($query->num_rows() > 0){
				return false;
			}else{
				return true;
			}
			
		}

		// public function cancelActiveResub($user_id,$type){
		// 	if($type == "new_nigeria"){
		// 		$form_array = array(
		// 			'active_subscription1' => 0,
		// 			'active_subscription1_interval' => "",
		// 			'active_subscription1_start_date' => "",
		// 			'active_subscription1_last_date' => ""
		// 		);				
		// 	}elseif($type == "great_nigeria"){
		// 		$form_array = array(
		// 			'active_subscription2' => 0,
		// 			'active_subscription2_interval' => "",
		// 			'active_subscription2_start_date' => "",
		// 			'active_subscription2_last_date' => ""
		// 		);				
		// 	}
		// 	$query = $this->db->update('users',$form_array,array('id' => $user_id));
		// 	if($query){
		// 		return true;
		// 	}else{
		// 		return false;
		// 	}
		// }

		// public function performAutomaticResubscription(){
		// 	$date = date("j M Y");
		// 	$time = date("h:i:sa");
		// 	$referred_by = "none";
		// 	$query = $this->db->get_where('users',array('active_subscription1'));
		// 	if($query->num_rows() > 0){
		// 		foreach($query->result() as $row){
		// 			$user_id = $row->id;
		// 			$active = $row->active_subscription1;
		// 			$interval = $row->active_subscription1_interval;
		// 			$last_date = $row->active_subscription1_last_date;
		// 			if($active == 1){

		// 				if($interval == "biweekly"){
		// 					$interval = strtotime("-2 weeks");
		// 				}else{
		// 					$interval = strtotime("-1 month");
		// 				}
		// 				$interval = date("j M Y",$interval);

		// 				if($interval == date("j M Y")){// If Its Due Today
		// 					//Then Check Is Already In Today
		// 					if($this->checkIfAutoResubHasBeenDoneToday($user_id,$date,"new_nigeria")){
		// 						if($this->checkIfserIsBouyant1($user_id,2500)){	

		// 							if($this->performAddingOneNigeria1($user_id,$referred_by,$date,$time,true)){
										
		// 			           			if($this->debitUser($user_id,2500)){
		// 				           			$form_array = array(
		// 				           				'active_subscription1_last_date' => $date
		// 				           			);
		// 				           			$this->updateUserTable($form_array,$user_id);
		// 				           		}
		// 			           		}
		// 			           	}
		// 		           	}
		// 	           	}
		// 	        }   	
		// 		}
		// 	}

		// 	$query = $this->db->get_where('users',array('active_subscription2'));
		// 	if($query->num_rows() > 0){
		// 		foreach($query->result() as $row){
		// 			$user_id = $row->id;
		// 			$active = $row->active_subscription2;
		// 			$interval = $row->active_subscription2_interval;
		// 			$last_date = $row->active_subscription2_last_date;
		// 			if($active == 1){

		// 				if($interval == "biweekly"){
		// 					$interval = strtotime("-2 weeks");
		// 				}else{
		// 					$interval = strtotime("-1 month");
		// 				}
		// 				$interval = date("j M Y",$interval);

		// 				if($interval == date("j M Y")){
		// 					if($this->checkIfAutoResubHasBeenDoneToday($user_id,$date,"great_nigeria")){
		// 						if($this->checkIfserIsBouyant1($user_id,5000)){	

		// 							if($this->performAddingGreatNigeria1($user_id,$referred_by,$date,$time,true)){
										
		// 			           			if($this->debitUser($user_id,5000)){
		// 				           			$form_array = array(
		// 				           				'active_subscription2_last_date' => $date
		// 				           			);
		// 				           			$this->updateUserTable($form_array,$user_id);
		// 				           		}
		// 			           		}
		// 			           	}
		// 		           	}
		// 	           	}
		// 	        }   	
		// 		}
		// 	}
		// }

		public function getSystemBonus(){
			$ret = 0;
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('new_nigeria',array('recycled' => 0));
				if($query->num_rows() > 0){
					foreach($query->result() as $row){
						$ret += 100;
					}
					$query = $this->db->get_where('new_nigeria',array('referred_by' => NULL,'recycled' => 0));
					if($query->num_rows() > 0){
						foreach($query->result() as $row){
							$ret += 400;
						}	
						$query = $this->db->get_where('great_nigeria',array('referred_by' => NULL,'recycled' => 0));
						if($query->num_rows() > 0){
							foreach($query->result() as $row){
								$ret += 800;
							}						
						}				
					}
				}	
			}
			return number_format($ret);
		}

		public function getAutomaticRecycleSystemBonus(){
			$ret = 0;
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('new_nigeria',array('recycled' => 1));
				if($query->num_rows() > 0){
					foreach($query->result() as $row){
						$ret += 100;
					}
					$query = $this->db->get_where('new_nigeria',array('referred_by' => NULL,'recycled' => 1));
					if($query->num_rows() > 0){
						foreach($query->result() as $row){
							$ret += 400;
						}	
						$query = $this->db->get_where('great_nigeria',array('referred_by' => NULL,'recycled' => 1));
						if($query->num_rows() > 0){
							foreach($query->result() as $row){
								$ret += 800;
							}						
						}				
					}
				}	
			}
			return number_format($ret);
		}

		public function getTotalSystemIncome(){
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 1),1);
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$total_income = $row->total_income;
					}
					return number_format($total_income);
				}
			}
		}

		public function getTotalUsersIncome(){
			$ret = 0;
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 0));
				if($query->num_rows() > 0){
					foreach($query->result() as $row){
						$total_income = $row->total_income;
						$ret += $total_income;
					}
				}
			}
			return number_format($ret);
		}

		public function getTotalUsersWithdrawn(){
			$ret = 0;
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 0));
				if($query->num_rows() > 0){
					foreach($query->result() as $row){
						$withdrawn = $row->withdrawn;
						$ret += $withdrawn;
					}
				}
			}
			return number_format($ret);
		}

		public function getUsersMoneyInSystem(){
			$ret1 = 0;
			$ret2 = 0;
			$ret = 0;
			if($this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 0));
				if($query->num_rows() > 0){
					foreach($query->result() as $row){
						$total_income = $row->total_income;
						$withdrawn = $row->withdrawn;
						$ret1 += $total_income;
						$ret2 += $withdrawn;
					}
				}
				$ret = $ret1 - $ret2;
			}
			return number_format($ret);
		}

		public function getUsersMlmBasicSponsorEarnings($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",1);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function getAdminSponsorBonus(){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",5);
			$this->db->or_where("charge_type",6);
			// $this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}


		public function getAdminBasicSponsorBonus(){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",5);
			
			// $this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}


		public function getAdminPlacementSponsorBonus(){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",6);
			// $this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}





		public function getUsersMlmBusinessSponsorEarnings($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",3);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function getUsersMlmBasicPlacementEarnings($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",2);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function getUsersMlmBusinessPlacementEarnings($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",4);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function getUsersCenterLeaderSponsorBonus($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",7);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function getUsersCenterLeaderPlacementBonus($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",12);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function getUsersCarAwardEarnings($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",11);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function transferMoneyFromMlmAccountToMainAccount($user_id,$amount){
			$mlm_withdrawn = $this->getUserParamById("mlm_withdrawn",$user_id);
			$new_mlm_withdrawn = $mlm_withdrawn + $amount;
			if($this->db->update("users",array('mlm_withdrawn' => $new_mlm_withdrawn),array('id' => $user_id))){
				if($this->creditUser($user_id,$amount)){
					return true;
				}
			}
		}


		public function transferMoneyFromMlmAccountToMainAccountAdmin($user_id,$amount){
			$mlm_withdrawn = $this->getUserParamById("admin_mlm_withdrawn",$user_id);
			$new_mlm_withdrawn = $mlm_withdrawn + $amount;
			if($this->db->update("users",array('admin_mlm_withdrawn' => $new_mlm_withdrawn),array('id' => $user_id))){
				if($this->creditUser($user_id,$amount)){
					return true;
				}
			}
		}

		public function getTotalWithdrawableMlmIncome($user_id){
			$basic_sponsor_earnings = $this->allenexpress_model->getUsersMlmBasicSponsorEarnings($user_id);
	        $business_sponsor_earnings = $this->allenexpress_model->getUsersMlmBusinessSponsorEarnings($user_id);
	        $basic_placement_earnings = $this->allenexpress_model->getUsersMlmBasicPlacementEarnings($user_id);
	        $business_placement_earnings = $this->allenexpress_model->getUsersMlmBusinessPlacementEarnings($user_id);
	        $center_leader_sponsor_bonus = $this->allenexpress_model->getUsersCenterLeaderSponsorBonus($user_id);
	        $center_leader_placement_bonus = $this->allenexpress_model->getUsersCenterLeaderPlacementBonus($user_id);
	        $center_leader_selection_income = $this->allenexpress_model->getUserParamById("center_leader_selection_income",$user_id);
	        $trade_delivery_income = $this->allenexpress_model->getUsersTradeDeliveryIncome($user_id);
	        $vtu_trade_income = $this->allenexpress_model->getUsersVtuTradeIncome($user_id);
	        $car_award_earnings = $this->allenexpress_model->getUsersCarAwardEarnings($user_id);

	        // $total_basic_earnings = $basic_sponsor_earnings + $basic_placement_earnings;
	        $total_basic_earnings = 0;
	        $total_business_earnings = $business_sponsor_earnings + $business_placement_earnings + $center_leader_sponsor_bonus + $center_leader_placement_bonus + $center_leader_selection_income + $trade_delivery_income + $car_award_earnings + $vtu_trade_income;

	        $total_withdrawable_basic_earnings = $total_basic_earnings;
	        $total_withdrawable_business_earnings = $this->allenexpress_model->getTotalBusinessWithdrawableEarnings($user_id);

	        $grand_total_withdrawable_earnings = $total_withdrawable_basic_earnings + $total_withdrawable_business_earnings;
    		$total_mlm_withdrawn = $this->allenexpress_model->getUserParamById("mlm_withdrawn",$user_id);
    		$grand_total_balance = $grand_total_withdrawable_earnings - $total_mlm_withdrawn;

    		return $grand_total_balance;
		}

		public function getTotalBusinessWithdrawableEarnings($user_id){
			$total = 0;
			// $this->db->select("*");
			// $this->db->from("mlm_earnings");
			// $this->db->or_where("charge_type",3);
			// $this->db->or_where("charge_type",4);
			// $this->db->or_where("charge_type",7);
			// $this->db->or_where("charge_type",12);
			// $this->db->or_where("charge_type",13);
			// $this->db->or_where("charge_type",14);
			// $this->db->or_where("charge_type",15);
			

			$query_str = "SELECT * FROM mlm_earnings WHERE user_id = ".$user_id." AND (charge_type = 3 OR charge_type = 4 OR charge_type = 7 OR charge_type = 12 OR charge_type = 13 OR charge_type = 14 OR charge_type = 15)";
			$query = $this->db->query($query_str);
			// echo $this->db->last_query();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$mlm_db_id = $row->mlm_db_id;
					$mlm_user_id = $row->user_id;
					if($this->getMlmDbParamById("package",$mlm_db_id) == 2){
						$amount = $row->amount;
						$vat = $row->vat;
						$vat_perc = $vat / 100;

						$sub_total = ($amount - ($amount * $vat_perc));
						$total += $sub_total;
					}
				}
			}
			return $total + $this->getUserParamById("center_leader_selection_income",$user_id);
		}

		public function getUsersTradeDeliveryIncome($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",13);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function getUsersVtuTradeIncome($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",14);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}

		public function getUsersSGPSIncome($user_id){
			$total = 0;
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("charge_type",15);
			$this->db->where("user_id",$user_id);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$sub_total = ($amount - ($amount * $vat_perc));
					$total += $sub_total;
				}
			}
			return $total;
		}





		public function debitUser($user_id,$amount){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$withdrawn = $row->withdrawn;
				}
				$new_withdrawn = $withdrawn + $amount;
				$query = $this->db->update('users',array('withdrawn' => $new_withdrawn),array('id' => $user_id));
				if($query){
					return true;
				}else{
					return false;
				}
			}
		}

		

		public function creditCenterLeaderSelectionIncome($user_id,$amount){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$center_leader_selection_income = $row->center_leader_selection_income;
				}
				$new_center_leader_selection_income = $center_leader_selection_income + $amount;
				$query = $this->db->update('users',array('center_leader_selection_income' => $new_center_leader_selection_income),array('id' => $user_id,'center_leader' => 1));
				if($query){
					// if($this->creditUser($user_id,$amount)){
						return true;
					// }
				}else{
					return false;
				}
			}
		}

		public function creditAdminCenterLeaderSelectionIncome($amount){
			$user_id = $this->getAdminId();
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$admin_center_leader_selection_income = $row->admin_center_leader_selection_income;
				}
				$new_admin_center_leader_selection_income = $admin_center_leader_selection_income + $amount;
				$query = $this->db->update('users',array('admin_center_leader_selection_income' => $new_admin_center_leader_selection_income),array('id' => $user_id));
				if($query){
					// if($this->creditUser($user_id,$amount)){
						return true;
					// }
				}else{
					return false;
				}
			}
		}

		

		public function getTvPackageCostByProductId($type,$package_id){
			
			$url = "https://www.nellobytesystems.com/APICableTVPackagesV1.asp";
			$use_post = true;
			$amount = 0;

			

			$response = $this->allenexpress_model->vtu_curl($url,$use_post,$post_data=[]);

			if($this->allenexpress_model->isJson($response)){
				$response = json_decode($response);
				if(is_object($response)){
					if($type == "dstv"){
						$network = "DStv";
						$bundles = $response->TV_ID->DStv[0]->PRODUCT;
					}else if($type == "gotv"){
						$network = "GOtv";
						$bundles = $response->TV_ID->GOtv[0]->PRODUCT;
					}else if($type == "startimes"){
						$network = "Startimes";
						$bundles = $response->TV_ID->Startimes[0]->PRODUCT;
					}

					for($i = 0; $i < count($bundles); $i++){
						$PACKAGE_ID = $bundles[$i]->PACKAGE_ID;
						if($PACKAGE_ID == $package_id){
							$amount = $bundles[$i]->PRODUCT_DISCOUNT_AMOUNT;
							break;
						}
					}
				}
			}

			return $amount;
		}

		public function getVtuTradeVatCharge(){
			$query = $this->db->get_where("mlm_charges",array('id' => 14));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function addTransactionStatus($form_array){	
			$date = date("j M Y");
			$time = date("h:i:sa");		
			if($this->db->insert("vtu_transactions",$form_array)){
				$user_id = $form_array['user_id'];
				$amount = $form_array['amount'];
				$type = $form_array['type'];
				if($type == "airtime" || $type == "data"){
					$perc_amount = round((0.21 / 100) * $amount,2);
					$purchaser_amount = round((2 / 100) * $amount,2);
				}else if($type == "electricity"){
					$perc_amount = round((0.21 / 100) * $amount,2);
					$purchaser_amount = round((1 / 100) * $amount,2);
				}else if($type == "cable tv"){
					$perc_amount = round((0.21 / 100) * $amount,2);
					$purchaser_amount = round((1 / 100) * $amount,2);
				}
				$vtu_income_vat = $this->getVtuTradeVatCharge();
				$vtu_income_vat_val = round(($vtu_income_vat / 100) * $perc_amount,2);

				$real_vtu_income = round(($perc_amount - $vtu_income_vat_val),2);

				$charge_type = 14;

				$mlm_db_id = $this->getUsersFirstMlmDbId($user_id);
				$ids_to_credit = $this->getIdsToCreditVtu($mlm_db_id);


				if($this->db->insert("mlm_earnings",array('user_id' => $user_id,'mlm_db_id' => $mlm_db_id,'charge_type' => $charge_type,'amount' => $purchaser_amount,'vat' => 0,'date' => $date,'time' => $time))){

					
					$total_business_income = $this->getUserParamById("total_business_income",$user_id);
					$new_total_business_income = $total_business_income + $real_vtu_income;

					$form_array = array(
						'total_business_income' => $new_total_business_income
					);
					
					$this->updateUserTable($form_array,$user_id);
				}

				$ids_to_credit_num = count($ids_to_credit);
				for($i = 0; $i < count($ids_to_credit); $i++){
					$user_id = $ids_to_credit[$i]['user_id'];
					$placements_mlm_db_id = $ids_to_credit[$i]['mlm_db_id'];


					if($this->db->insert("mlm_earnings",array('user_id' => $user_id,'mlm_db_id' => $placements_mlm_db_id,'charge_type' => $charge_type,'amount' => $perc_amount,'vat' => $vtu_income_vat,'date' => $date,'time' => $time))){

						$total_vat = $this->getUserParamById("admin_vat_total",$this->getAdminId());
						$new_vat_total = $total_vat + $vtu_income_vat_val;
						$form_array = array(
							'admin_vat_total' => $new_vat_total
						);

						if($this->updateUserTable($form_array,$this->getAdminId())){
							$form_array = array();

							
							$total_business_income = $this->getUserParamById("total_business_income",$user_id);
							$new_total_business_income = $total_business_income + $real_vtu_income;

							$form_array = array(
								'total_business_income' => $new_total_business_income
							);
							

							if($this->updateUserTable($form_array,$user_id)){

							}

							if($i == ($ids_to_credit_num - 1)){
								return true;
							}
						}
					}
				}
				
			}
		}

		// public function testVtuCrediting($user_id,$mlm_db_id,$ids_to_credit,$amount,$type){
		// 	$date = date("j M Y");
		// 	$time = date("h:i:sa");
		// 	if($type == "airtime"){
		// 		$perc_amount = round((0.21 / 100) * $amount,2);

		// 		$vtu_income_vat = $this->getVtuTradeVatCharge();
		// 		$vtu_income_vat_val = round(($vtu_income_vat / 100) * $perc_amount,2);

		// 		$real_vtu_income = round(($perc_amount - $vtu_income_vat_val),2);

		// 		$charge_type = 14;

		// 		$mlm_db_id = $this->getUsersFirstMlmDbId($user_id);
		// 		$ids_to_credit = $this->getIdsToCreditVtu($mlm_db_id);

		// 		$ids_to_credit_num = count($ids_to_credit);
		// 		for($i = 0; $i < count($ids_to_credit); $i++){
		// 			$user_id = $ids_to_credit[$i]['user_id'];
		// 			$placements_mlm_db_id = $ids_to_credit[$i]['mlm_db_id'];


		// 			if($this->db->insert("mlm_earnings",array('user_id' => $user_id,'mlm_db_id' => $placements_mlm_db_id,'charge_type' => $charge_type,'amount' => $perc_amount,'vat' => $vtu_income_vat,'date' => $date,'time' => $time))){

		// 				$total_vat = $this->getUserParamById("admin_vat_total",$this->getAdminId());
		// 				$new_vat_total = $total_vat + $vtu_income_vat_val;
		// 				$form_array = array(
		// 					'admin_vat_total' => $new_vat_total
		// 				);

		// 				if($this->updateUserTable($form_array,$this->getAdminId())){
		// 					$form_array = array();

							
		// 					$total_business_income = $this->getUserParamById("total_business_income",$user_id);
		// 					$new_total_business_income = $total_business_income + $real_vtu_income;

		// 					$form_array = array(
		// 						'total_business_income' => $new_total_business_income
		// 					);
							

		// 					if($this->updateUserTable($form_array,$user_id)){

		// 					}

		// 					if($i == ($ids_to_credit_num - 1)){
		// 						return true;
		// 					}
		// 				}
		// 			}
		// 		}
		// 	}
		// }

		public function getIdsToCreditVtu($mlm_db_id){
			$ret_arr = array();
			$ret_arr[] = array(
				'mlm_db_id' => $mlm_db_id,
				'user_id' => $this->getMlmDbParamById("user_id",$mlm_db_id)
			);
			for($i = 1; $i <= 8; $i++){
				$query = $this->db->get_where('mlm_db',array('id' => $mlm_db_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$under = $row->under;
						if(!is_null($under)){
							$user_id = $this->allenexpress_model->getMlmDbParamById("user_id",$under);
							// $this->getIdsToCreditPlacement($under);
							$mlm_db_id = $under;
							$ret_arr[] = array(
								'mlm_db_id' => $under,
								'user_id' => $user_id
							);
							
						}else{
							$ret_arr[] =  array(
								'mlm_db_id' => 1,
								'user_id' => $this->getAdminId()
							);
						}
					}
					
				}

			}

			return $ret_arr;
		}

		public function getUsersFirstMlmDbId($user_id){
			// $query = $this->db->get_where("mlm_db",array('user_id' => $sponsor_id),1)
			$this->db->select("id");
			$this->db->from("mlm_db");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","ASC");
			$this->db->limit(1);

			$query = $this->db->get();
			if($query->num_rows() == 1){
				return $query->result()[0]->id;
			}
		}

		public function getPositioningOfMlmUserDirect($stage,$sponsor_id){
			$query = $this->db->get_where("mlm_db",array('stage' => $stage,'under' => $sponsor_id));
			if($query->num_rows() == 1){
				$query->result()[0]->positioning;
			}else{
				return false;
			}
		}

		

		public function getChildrenIdsOfParent($sponsors_first_mlm_db_id){
			$ret_arr = array();
			// $query = $this->db->get_where('mlm_db',array('under' => $sponsors_first_mlm_db_id));
			$this->db->select("id");
			$this->db->from("mlm_db");
			$this->db->where("under",$sponsors_first_mlm_db_id);
			$this->db->order_by("id","ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] = $id;
				}
			}
			return $ret_arr;
		}

		public function checkIfThisUserHasHisNextLevelFull($parent_id){
			// $query = $this->db->get_where('mlm_db',array('under' => $parent_id));
			$this->db->select("id");
			$this->db->from("mlm_db");
			$this->db->where("under",$parent_id);
			$this->db->order_by("id","ASC");
			$query = $this->db->get();
			if($query->num_rows() >= 2){
				return true;
			}else{
				return false;
			}
		}

		public function getNumberOfImmediateChildrenOfThisUser($parent_id){
			$query = $this->db->get_where('mlm_db',array('under' => $parent_id));
			return $query->num_rows();
		}

		public function getPositioningOfImmediateChildOfThisUser($parent_id){
			$query = $this->db->get_where('mlm_db',array('under' => $parent_id));
			if($query->num_rows() == 1){
				return $query->result()[0]->positioning;
			}
		}

		public function getIdsOfChildren($current_array){
			$ret_arr = array();
			if(is_array($current_array)){
				for($i = 0; $i < count($current_array); $i++){
					$id = $current_array[$i];
					$query = $this->db->get_where("mlm_db",array('under' => $id));
					if($query->num_rows() > 0){
						foreach($query->result() as $row){
							$id1 = $row->id;
							$ret_arr[] = $id1;
						}
					}
				}
			}
			return $ret_arr;
		}

		public function makeSureNoAccountOfThisUserIsWithThisDateAndTime($user_id,$date,$time){
			$query = $this->db->get_where("mlm_db",array('user_id' => $user_id,'date_created' => $date,'time_created' => $time));
			if($query->num_rows() > 0){
				return false;
			}else{
				return true;
			}
		}

		public function getMlmDbIdByDateAndTime($user_id,$date,$time){
			$query = $this->db->get_where("mlm_db",array('user_id' => $user_id,'date_created' => $date,'time_created' => $time));
			if($query->num_rows() == 1){
				return $query->result()[0]->id;
			}else{
				return true;
			}
		}

		public function fixUserInNextAvailableSpaceForMlm($package,$type,$sponsor_id,$user_id,$date,$time,$reference = NULL){
			//If Type Is Next Available space
			
			// echo $sponsor_id;
			//Get Sponsors First Mlm Db Id
			if($type == 0){
				$sponsors_first_mlm_db_id = $this->getUsersFirstMlmDbId($sponsor_id);
			}else{
				$sponsors_first_mlm_db_id = $sponsor_id;
			}
			// echo $sponsors_first_mlm_db_id . "<br>";
			//Get The Stage Here
			$sponsors_first_mlm_db_stage = $this->getMlmDbParamById("stage",$sponsors_first_mlm_db_id);
			// echo $sponsors_first_mlm_db_stage;
			// echo $sponsors_first_mlm_db_stage;
			//Get The First Generation Under Sponsor Thats Empty
			$query = $this->db->get_where('mlm_db',array('under' => $sponsors_first_mlm_db_id));
			$number_under_him = $query->num_rows();
			//If First Level Under Him Is Full
			if($number_under_him == 2){
				$i = 1;
				$current_array = array();
				while (true) {
					$i++;
					// echo $i;

					$previous_stage = $i - 1;
					$stage_to_check_for = $sponsors_first_mlm_db_stage + $previous_stage;
					$current_stage = $sponsors_first_mlm_db_stage + $i;


					
					if($i == 2){
						$parents_ids = $this->getChildrenIdsOfParent($sponsors_first_mlm_db_id);
						// print_r($parents_ids);
					}else{
						$parents_ids = $this->getIdsOfChildren($current_array);
					}
					// var_dump($parents_ids);
					if(is_array($parents_ids)){
						$current_array = $parents_ids;
						for($j = 0; $j < count($parents_ids); $j++){
							$parent_id = $parents_ids[$j];
							if(!$this->checkIfThisUserHasHisNextLevelFull($parent_id)){
								
								$parents_children_num = $this->getNumberOfImmediateChildrenOfThisUser($parent_id);
								// echo $parents_children_num;
								if($parents_children_num == 0){
									$positioning = "left";
								}else if($parents_children_num == 1){
									$other_users_positioning = $this->getPositioningOfImmediateChildOfThisUser($parent_id);
									if($other_users_positioning == "right"){
										$positioning = "left";
									}else{
										$positioning = "right";
									}
								}
								$form_array = array(
									'user_id' => $user_id,
									'package' => $package,
									'sponsor' => $sponsors_first_mlm_db_id,
									'under' => $parent_id,
									'stage' => $current_stage,
									'positioning' => $positioning,
									'date_created' => $date,
									'time_created' => $time,
									'reference' => $reference
								);
								$query = $this->db->insert("mlm_db",$form_array);
								if($query){
									$mlm_db_id = $this->db->insert_id();
									
									if($package == 1){
										$placement_income = $this->getPlacementChargeForBasicPackage();
						      			$placement_income_vat = $this->getPlacementVatChargeForBasicPackage();
						      			$charge_type = 2;
						      		}else{
						      			$placement_income = $this->getPlacementChargeForBusinessPackage();
						      			$placement_income_vat = $this->getPlacementVatChargeForBusinessPackage();
						      			$charge_type = 4;
						      		}
					      			$placement_income_vat_perc = $placement_income_vat / 100;
					      			$placement_income_vat_val = ($placement_income_vat_perc * $placement_income);
					      			$real_placement_income = $placement_income - ($placement_income_vat_perc * $placement_income);
					      			
					          		$this->creditUserPlacementIncome($mlm_db_id,$placement_income,$placement_income_vat,$real_placement_income,$charge_type,$date,$time,$placement_income_vat_val);
					          		return true;
								}
								break 2;
							}
						}
					}
					
				}
			}else{ //If Not
				$new_stage = $sponsors_first_mlm_db_stage + 1;
				if($number_under_him == 1){
					$other_users_positioning = $this->getPositioningOfMlmUserDirect($new_stage,$sponsors_first_mlm_db_id);
					if($other_users_positioning == "right"){
						$positioning = "left";
					}else{
						$positioning = "right";
					}
				}else{
					$positioning = "left";
				}
				
				$form_array = array(
					'user_id' => $user_id,
					'package' => $package,
					'sponsor' => $sponsors_first_mlm_db_id,
					'under' => $sponsors_first_mlm_db_id,
					'stage' => $new_stage,
					'positioning' => $positioning,
					'date_created' => $date,
					'time_created' => $time,
					'reference' => $reference
				);
				$query = $this->db->insert("mlm_db",$form_array);
				$mlm_db_id = $this->db->insert_id();
									

				if($package == 1){
					$placement_income = $this->getPlacementChargeForBasicPackage();
	      			$placement_income_vat = $this->getPlacementVatChargeForBasicPackage();
	      			$charge_type = 2;
	      		}else{
	      			$placement_income = $this->getPlacementChargeForBusinessPackage();
	      			$placement_income_vat = $this->getPlacementVatChargeForBusinessPackage();
	      			$charge_type = 4;
	      		}
      			$placement_income_vat_perc = $placement_income_vat / 100;
      			$placement_income_vat_val = ($placement_income_vat_perc * $placement_income);
      			$real_placement_income = $placement_income - ($placement_income_vat_perc * $placement_income);
      			
          		
          		$this->creditUserPlacementIncome($mlm_db_id,$placement_income,$placement_income_vat,$real_placement_income,$charge_type,$date,$time,$placement_income_vat_val);
          		return true;
			}

			
		}

		public function getTotalNumberOfUsersInAGeneration($levels_num){
			$total = 1;
  			$count = 1;
			for($i = 1; $i <= $levels_num; $i++){
		        for($j = 1; $j <= 2; $j++){
		          $count *= $j;
		        }
		        $total += $count;
		        
		    }
		    return $count;
		}

		public function registerUserInMlm($user_id,$sponsor_id,$date,$time,$package,$type,$reference = NULL){
			if($this->fixUserInNextAvailableSpaceForMlm($package,$type,$sponsor_id,$user_id,$date,$time,$reference)){
				if($package == 1){
	      			$sponsor_income = $this->getSponsorChargeForBasicPackage();
	      			$sponsor_income_vat = $this->getSponsorVatChargeForBasicPackage();
	      			$sponsor_income_vat_perc = $sponsor_income_vat / 100;
	      			$sponsor_income_vat_val = ($sponsor_income_vat_perc * $sponsor_income);
	      			$real_sponsor_income = $sponsor_income - ($sponsor_income_vat_perc * $sponsor_income);
	      			$sponsors_first_mlm_db_id = $this->getUsersFirstMlmDbId($sponsor_id);
	          		$this->creditUserSponsorIncome($user_id,$sponsor_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$sponsors_first_mlm_db_id,1,$date,$time,$sponsor_income_vat_val);

	          		return true;
	          		
				}else if($package == 2){
					$sponsor_income = $this->getSponsorChargeForBusinessPackage();
	      			$sponsor_income_vat = $this->getSponsorVatChargeForBusinessPackage();
	      			$sponsor_income_vat_perc = $sponsor_income_vat / 100;
	      			$sponsor_income_vat_val = ($sponsor_income_vat_perc * $sponsor_income);
	      			$real_sponsor_income = $sponsor_income - ($sponsor_income_vat_perc * $sponsor_income);
	      			$sponsors_first_mlm_db_id = $this->getUsersFirstMlmDbId($sponsor_id);
	          		$this->creditUserSponsorIncome($user_id,$sponsor_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$sponsors_first_mlm_db_id,3,$date,$time,$sponsor_income_vat_val);

	          		return true;
				}
			}
		}

		public function checkIfThisPlacementPositionIsAvailable($placement_id,$positioning){
			$query = $this->db->get_where("mlm_db",array('under' => $placement_id,'positioning' => $positioning));
			if($query->num_rows() == 1){
				return false;
			}else{
				return true;
			}
		}

		public function registerUserInMlm2($user_id,$sponsor_id,$placement_id,$positioning,$date,$time,$package,$type,$reference = NULL){
			if($this->fixUserInPositionMlm($package,$type,$sponsor_id,$placement_id,$positioning,$user_id,$date,$time,$reference)){
				if($package == 1){
	      			$sponsor_income = $this->getSponsorChargeForBasicPackage();
	      			$sponsor_income_vat = $this->getSponsorVatChargeForBasicPackage();
	      			$sponsor_income_vat_perc = $sponsor_income_vat / 100;
	      			$sponsor_income_vat_val = ($sponsor_income_vat_perc * $sponsor_income);
	      			$real_sponsor_income = $sponsor_income - ($sponsor_income_vat_perc * $sponsor_income);
	      			$sponsor_user_id = $this->getMlmDbParamById("user_id",$sponsor_id);
	          		$this->creditUserSponsorIncome($user_id,$sponsor_user_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$sponsor_id,1,$date,$time,$sponsor_income_vat_val);

	          		return true;
	          		
				}else if($package == 2){
					$sponsor_income = $this->getSponsorChargeForBusinessPackage();
	      			$sponsor_income_vat = $this->getSponsorVatChargeForBusinessPackage();
	      			$sponsor_income_vat_perc = $sponsor_income_vat / 100;
	      			$sponsor_income_vat_val = ($sponsor_income_vat_perc * $sponsor_income);
	      			$real_sponsor_income = $sponsor_income - ($sponsor_income_vat_perc * $sponsor_income);
	      			$sponsor_user_id = $this->getMlmDbParamById("user_id",$sponsor_id);
	          		$this->creditUserSponsorIncome($user_id,$sponsor_user_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$sponsor_id,3,$date,$time,$sponsor_income_vat_val);


	          		return true;
				}
			}
		}

		public function fixUserInPositionMlm($package,$type,$sponsor_id,$placement_id,$positioning,$user_id,$date,$time,$reference = NULL){
			if($this->allenexpress_model->checkIfThisPlacementPositionIsAvailable($placement_id,$positioning)){
				$placement_stage =  $this->getMlmDbParamById("stage",$placement_id);
				$new_stage = $placement_stage + 1;
				$form_array = array(
					'user_id' => $user_id,
					'package' => $package,
					'sponsor' => $sponsor_id,
					'under' => $placement_id,
					'stage' => $new_stage,
					'positioning' => $positioning,
					'date_created' => $date,
					'time_created' => $time,
					'reference' => $reference
				);
				$query = $this->db->insert("mlm_db",$form_array);
				if($query){
					$mlm_db_id = $this->db->insert_id();
					if($package == 1){
						$placement_income = $this->getPlacementChargeForBasicPackage();
		      			$placement_income_vat = $this->getPlacementVatChargeForBasicPackage();
		      			$charge_type = 2;
		      		}else{
		      			$placement_income = $this->getPlacementChargeForBusinessPackage();
		      			$placement_income_vat = $this->getPlacementVatChargeForBusinessPackage();
		      			$charge_type = 4;
		      		}
	      			$placement_income_vat_perc = $placement_income_vat / 100;
	      			$placement_income_vat_val = ($placement_income_vat_perc * $placement_income);
	      			$real_placement_income = $placement_income - ($placement_income_vat_perc * $placement_income);
	      			
	          		$this->creditUserPlacementIncome($mlm_db_id,$placement_income,$placement_income_vat,$real_placement_income,$charge_type,$date,$time,$placement_income_vat_val);
	          		return true;
				}
			}else{
				if($this->fixUserInNextAvailableSpaceForMlm($package,1,$sponsor_id,$user_id,$date,$time,$reference)){
					return true;
				}
			}	
		}

		public function registerUserInMlm3($user_id,$sponsor_id,$date,$time,$package,$type,$reference = NULL){
			if($this->fixUserInNextAvailableSpaceForMlm($package,1,$sponsor_id,$user_id,$date,$time,$reference)){
				if($package == 1){
	      			$sponsor_income = $this->getSponsorChargeForBasicPackage();
	      			$sponsor_income_vat = $this->getSponsorVatChargeForBasicPackage();
	      			$sponsor_income_vat_perc = $sponsor_income_vat / 100;
	      			$sponsor_income_vat_val = ($sponsor_income_vat_perc * $sponsor_income);
	      			$real_sponsor_income = $sponsor_income - ($sponsor_income_vat_perc * $sponsor_income);
	      			$sponsor_user_id = $this->getMlmDbParamById("user_id",$sponsor_id);
	          		$this->creditUserSponsorIncome($user_id,$sponsor_user_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$sponsor_id,1,$date,$time,$sponsor_income_vat_val);

	          		return true;
	          		
				}else if($package == 2){
					$sponsor_income = $this->getSponsorChargeForBusinessPackage();
	      			$sponsor_income_vat = $this->getSponsorVatChargeForBusinessPackage();
	      			$sponsor_income_vat_perc = $sponsor_income_vat / 100;
	      			$sponsor_income_vat_val = ($sponsor_income_vat_perc * $sponsor_income);
	      			$real_sponsor_income = $sponsor_income - ($sponsor_income_vat_perc * $sponsor_income);
	      			$sponsor_user_id = $this->getMlmDbParamById("user_id",$sponsor_id);
	          		$this->creditUserSponsorIncome($user_id,$sponsor_user_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$sponsor_id,3,$date,$time,$sponsor_income_vat_val);


	          		return true;
				}
			}
		}


		public function updateMlmTable($form_array,$mlm_db_id){
			return $this->db->update("mlm_db",$form_array,array('id' => $mlm_db_id));
		}

		public function upgradeMlmAccountToBusiness($mlm_db_id,$user_id,$date,$time,$reference = NULL){

			$sponsor_id = $this->getMlmDbParamById("sponsor",$mlm_db_id);
			$sponsor_user_id = $this->getMlmDbParamById("user_id",$sponsor_id);
			$sponsor_income = $this->getSponsorChargeForBusinessPackage();
  			$sponsor_income_vat = $this->getSponsorVatChargeForBusinessPackage();
  			$sponsor_income_vat_perc = $sponsor_income_vat / 100;
  			$sponsor_income_vat_val = ($sponsor_income_vat_perc * $sponsor_income);
  			$real_sponsor_income = $sponsor_income - ($sponsor_income_vat_perc * $sponsor_income);

  			$placement_income = $this->getPlacementChargeForBusinessPackage();
  			$placement_income_vat = $this->getPlacementVatChargeForBusinessPackage();
  			$placement_income_vat_perc = $placement_income_vat / 100;
  			$placement_income_vat_val = ($placement_income_vat_perc * $placement_income);
  			$real_placement_income = $placement_income - ($placement_income_vat_perc * $placement_income);

  			$car_bonus_income = $this->getCarBonus();
  			$car_bonus_income_vat = $this->getCarBonusVat();
  			if($car_bonus_income_vat != 0){
	  			$car_bonus_income_vat_perc = $car_bonus_income_vat / 100;
	  			$car_bonus_income_vat_val = ($car_bonus_income_vat_perc * $car_bonus_income);
	  			$real_car_bonus_income = $car_bonus_income - ($car_bonus_income_vat_perc * $car_bonus_income);
	  		}else{
	  			$car_bonus_income_vat_perc = 0;
	  			$car_bonus_income_vat_val = 0;
	  			$real_car_bonus_income = $car_bonus_income;
	  		}
  			
  			
  			
  			
      		$this->creditUserCarBonus($mlm_db_id,$car_bonus_income,$car_bonus_income_vat,$real_car_bonus_income,11,$date,$time,$car_bonus_income_vat_val);
      		$this->creditUserPlacementIncome($mlm_db_id,$placement_income,$placement_income_vat,$real_placement_income,4,$date,$time,$placement_income_vat_val);
  			// $sponsors_first_mlm_db_id = $this->getUsersFirstMlmDbId($sponsor_id);
      		$this->creditUserSponsorIncome($user_id,$sponsor_user_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$sponsor_id,3,$date,$time,$sponsor_income_vat_val);
      		$former_references = $this->getMlmDbParamById("reference",$mlm_db_id);
      		if(!is_null($former_references)){
	      		$former_references_arr = explode(",",$former_references);
	      		$former_references_arr[] = $reference;
	      		$reference = implode(",",$former_references_arr);
	      	}

      		$form_array = array(
      			'reference' => $reference,
      			'package' => 2,
      			'date_created' => $date,
      			'time_created' => $time
      		);
      		if($this->updateMlmTable($form_array,$mlm_db_id)){
      			return true;
      		}
		}

		public function creditUserCarBonus($mlm_db_id,$car_bonus_income,$car_bonus_income_vat,$real_car_bonus_income,$charge_type,$date,$time,$car_bonus_income_vat_val){
			$creditors_user_id = $this->getMlmDbParamById("user_id",$mlm_db_id);
			$ids_to_credit = $this->getIdsToCreditPlacement($mlm_db_id);
			for($i = 0; $i < count($ids_to_credit); $i++){
				$user_id = $ids_to_credit[$i]['user_id'];
				$placements_mlm_db_id = $ids_to_credit[$i]['mlm_db_id'];

				if($this->db->insert("mlm_earnings",array('user_id' => $user_id,'mlm_db_id' => $placements_mlm_db_id,'charge_type' => $charge_type,'amount' => $car_bonus_income,'vat' => $car_bonus_income_vat,'date' => $date,'time' => $time))){

					$total_vat = $this->getUserParamById("admin_vat_total",$this->getAdminId());
					$new_vat_total = $total_vat + $car_bonus_income_vat_val;
					$form_array = array(
						'admin_vat_total' => $new_vat_total
					);

					if($this->updateUserTable($form_array,$this->getAdminId())){
						$form_array = array();
					}

					
				}
			}
		}

		public function creditUserSponsorIncome($user_id,$sponsor_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$mlm_db_id,$charge_type,$date,$time,$sponsor_income_vat_val){
			if($this->db->insert("mlm_earnings",array('user_id' => $sponsor_id,'mlm_db_id' => $mlm_db_id,'charge_type' => $charge_type,'amount' => $sponsor_income,'vat' => $sponsor_income_vat,'date' => $date,'time' => $time))){
				$total_vat = $this->getUserParamById("admin_vat_total",$this->getAdminId());
				$new_vat_total = $total_vat + $sponsor_income_vat_val;
				$form_array = array(
					'admin_vat_total' => $new_vat_total
				);

				if($this->updateUserTable($form_array,$this->getAdminId())){
					$form_array = array();

					if($charge_type == 1){
						$admin_sponsor_bonus = $this->getAdminSponsorChargeForBasicPackage();
						// echo $admin_sponsor_bonus;
						if($this->db->insert("mlm_earnings",array('user_id' => $this->getAdminId(),'mlm_db_id' => 1,'charge_type' => 5,'amount' => $admin_sponsor_bonus,'vat' => 0,'date' => $date,'time' => $time))){
							$total_basic_income = $this->getUserParamById("total_basic_income",$this->getAdminId());
							$new_total_basic_income = $total_basic_income + $admin_sponsor_bonus;

							$form_array = array(
								'total_basic_income' => $new_total_basic_income
							);
							if($this->updateUserTable($form_array,$this->getAdminId())){

							}
						}

						$total_basic_income = $this->getUserParamById("total_basic_income",$sponsor_id);
						$new_total_basic_income = $total_basic_income + $real_sponsor_income;

						$form_array = array(
							'total_basic_income' => $new_total_basic_income
						);

					}else if($charge_type == 3){
						$admin_sponsor_bonus = $this->getAdminSponsorChargeForBusinessPackage();
						// echo $admin_sponsor_bonus;
						if($this->db->insert("mlm_earnings",array('user_id' => $this->getAdminId(),'mlm_db_id' => 1,'charge_type' => 6,'amount' => $admin_sponsor_bonus,'vat' => 0,'date' => $date,'time' => $time))){
							$total_business_income = $this->getUserParamById("total_business_income",$this->getAdminId());
							$new_total_business_income = $total_business_income + $admin_sponsor_bonus;

							$form_array = array(
								'total_business_income' => $new_total_business_income
							);
							if($this->updateUserTable($form_array,$this->getAdminId())){

							}

						}
						$total_business_income = $this->getUserParamById("total_business_income",$sponsor_id);
						$new_total_business_income = $total_business_income + $real_sponsor_income;

						$form_array = array(
							'total_business_income' => $new_total_business_income
						);
					}

					if($this->updateUserTable($form_array,$sponsor_id)){

					}

					$sponsored_business_partner_id = $user_id;
					$sponsored_business_partner_username = $this->getUserNameById($sponsored_business_partner_id);
					$sponsored_business_partner_slug = $this->getUserParamById("slug",$sponsored_business_partner_id);
					$sponsored_business_partner_full_name = $this->getUserParamById("full_name",$sponsored_business_partner_id);
					$sponsored_business_partner_phone_code = $this->getUserParamById("phone_code",$sponsored_business_partner_id);
					$sponsored_business_partner_phone_num = $this->getUserParamById("phone",$sponsored_business_partner_id);
					$sponsored_business_partner_phone_num =  "+". $sponsored_business_partner_phone_code . "" . $sponsored_business_partner_phone_num;

					$title = "Credit Alert";
	        		$message = "This Is To Alert You That You Were Credited With Sponsor Income. View Details Below.";
	        		$message .= "<div class='container' style='margin-top: 30px;'>";
	        		$message .= "<p>Sponsor Income Amount: <em class='text-primary'>".number_format($sponsor_income,2)."</em><p>";
	        		$message .= "<p>Sponsor Income Vat: <em class='text-primary'>".number_format($sponsor_income_vat,2)."%</em><p>";
	        		$message .= "<p>Withdrawable Sponsor Balance: <em class='text-primary'>".number_format($real_sponsor_income,2)."</em><p>";

	        		if($charge_type == 1){
		        		$message .= "<h4 class='text-center' style='margin-top: 20px;'>Newly Sponsored Basic Partner Details<h4>";
		        	}else if($charge_type == 3){
		        		$message .= "<h4 class='text-center' style='margin-top: 20px;'>Newly Sponsored Business Partner Details<h4>";
		        	}

		        	$message .= "<p>Username: <a target='_blank' href='".site_url('Sabicapital/'.$sponsored_business_partner_slug)."'>".$sponsored_business_partner_username."</a><p>";

		        	$message .= "<p>Full Name: <em class='text-primary'>".$sponsored_business_partner_full_name."</em><p>";
		        	// $message .= "<p>Phone Number: <em class='text-primary'>".$sponsored_business_partner_phone_num."</em><p>";

	        		$message .= "</div>";
	        		

					$form_array = array(
						'sender' => "System",
						'receiver' => $sponsor_id,
						'title' => $title,
						'message' => $message,
						'date_sent' => $date,
						'time_sent' => $time,
						'type' => 'misc'
					);

					$history_array = array(
						'user_id' => $sponsor_id,
						'income_type' => 'sponsor',
						'creditors_id' => $sponsored_business_partner_id,
						'amount' => $sponsor_income,
						'vat' => $sponsor_income_vat,
						'date' => $date,
						'time' => $time
					);

					if($charge_type == 1){
						$history_array['package'] = 1;
					}elseif($charge_type == 3){
						$history_array['package'] = 2;
					}


					if($this->sendMessage($form_array) && $this->addMlmIncomeHistory($history_array)){
						return true;
					}
				}
			}
		}



		public function creditUserSponsorIncomeCenterLeader($user_id,$sponsor_user_id,$sponsor_income,$sponsor_income_vat,$real_sponsor_income,$mlm_db_id,$charge_type,$date,$time,$sponsor_income_vat_val){
			if($this->db->insert("mlm_earnings",array('user_id' => $sponsor_user_id,'mlm_db_id' => $mlm_db_id,'charge_type' => $charge_type,'amount' => $sponsor_income,'vat' => $sponsor_income_vat,'date' => $date,'time' => $time))){

				$total_vat = $this->getUserParamById("admin_vat_total",$this->getAdminId());
				$new_vat_total = $total_vat + $sponsor_income_vat_val;
				$form_array = array(
					'admin_vat_total' => $new_vat_total
				);

				if($this->updateUserTable($form_array,$this->getAdminId())){
					$form_array = array();
					
					$admin_sponsor_bonus = $this->getCenterLeaderAdminSponsorBonus();
					// echo $admin_sponsor_bonus;
					if($this->db->insert("mlm_earnings",array('user_id' => $this->getAdminId(),'mlm_db_id' => 1,'charge_type' => 5,'amount' => $admin_sponsor_bonus,'vat' => 0,'date' => $date,'time' => $time))){
						
					}

					$sponsored_business_partner_id = $user_id;
					$sponsored_business_partner_username = $this->getUserNameById($sponsored_business_partner_id);
					$sponsored_business_partner_slug = $this->getUserParamById("slug",$sponsored_business_partner_id);
					$sponsored_business_partner_full_name = $this->getUserParamById("full_name",$sponsored_business_partner_id);
					$sponsored_business_partner_phone_code = $this->getUserParamById("phone_code",$sponsored_business_partner_id);
					$sponsored_business_partner_phone_num = $this->getUserParamById("phone",$sponsored_business_partner_id);
					$sponsored_business_partner_phone_num =  "+". $sponsored_business_partner_phone_code . "" . $sponsored_business_partner_phone_num;

					$title = "Credit Alert";
	        		$message = "This Is To Alert You That You Were Credited With Sponsor Income. View Details Below.";
	        		$message .= "<div class='container' style='margin-top: 30px;'>";
	        		$message .= "<p>Sponsor Income Amount: <em class='text-primary'>".number_format($sponsor_income,2)."</em><p>";
	        		$message .= "<p>Sponsor Income Vat: <em class='text-primary'>".number_format($sponsor_income_vat,2)."%</em><p>";
	        		$message .= "<p>Withdrawable Sponsor Balance: <em class='text-primary'>".number_format($real_sponsor_income,2)."</em><p>";

	        		
		        	$message .= "<h4 class='text-center' style='margin-top: 20px;'>Center Leader Sponsor Bonus<h4>";
		        	

		        	$message .= "<p>Username: <a target='_blank' href='".site_url('Sabicapital/'.$sponsored_business_partner_slug)."'>".$sponsored_business_partner_username."</a><p>";

		        	$message .= "<p>Full Name: <em class='text-primary'>".$sponsored_business_partner_full_name."</em><p>";
		        	$message .= "<p>Phone Number: <em class='text-primary'>".$sponsored_business_partner_phone_num."</em><p>";

	        		$message .= "</div>";
	        		

					$form_array = array(
						'sender' => "System",
						'receiver' => $sponsor_user_id,
						'title' => $title,
						'message' => $message,
						'date_sent' => $date,
						'time_sent' => $time,
						'type' => 'misc'
					);

					if($this->sendMessage($form_array)){
						return true;
					}
				}
			}
		}

		public function getIdsToCreditPlacement($mlm_db_id){
			$ret_arr = array();
			for($i = 1; $i <= 16; $i++){
				$query = $this->db->get_where('mlm_db',array('id' => $mlm_db_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$under = $row->under;
						if(!is_null($under)){
							$user_id = $this->allenexpress_model->getMlmDbParamById("user_id",$under);
							// $this->getIdsToCreditPlacement($under);
							$mlm_db_id = $under;
							$ret_arr[] = array(
								'mlm_db_id' => $under,
								'user_id' => $user_id
							);
							
						}else{
							$ret_arr[] =  array(
								'mlm_db_id' => 1,
								'user_id' => $this->getAdminId()
							);
						}
					}
				}

			}
			return $ret_arr;
		}

		public function creditUserPlacementIncome($mlm_db_id,$placement_income,$placement_income_vat,$real_placement_income,$charge_type,$date,$time,$placement_income_vat_val){

			$creditors_user_id = $this->getMlmDbParamById("user_id",$mlm_db_id);
			$ids_to_credit = $this->getIdsToCreditPlacement($mlm_db_id);
			$ids_to_credit_num = count($ids_to_credit);
			for($i = 0; $i < count($ids_to_credit); $i++){
				$user_id = $ids_to_credit[$i]['user_id'];
				$placements_mlm_db_id = $ids_to_credit[$i]['mlm_db_id'];

				if($this->db->insert("mlm_earnings",array('user_id' => $user_id,'mlm_db_id' => $placements_mlm_db_id,'charge_type' => $charge_type,'amount' => $placement_income,'vat' => $placement_income_vat,'date' => $date,'time' => $time))){

					$total_vat = $this->getUserParamById("admin_vat_total",$this->getAdminId());
					$new_vat_total = $total_vat + $placement_income_vat_val;
					$form_array = array(
						'admin_vat_total' => $new_vat_total
					);

					if($this->updateUserTable($form_array,$this->getAdminId())){
						$form_array = array();

						if($charge_type == 2){
							$total_basic_income = $this->getUserParamById("total_basic_income",$user_id);
							$new_total_basic_income = $total_basic_income + $real_placement_income;

							$form_array = array(
								'total_basic_income' => $new_total_basic_income
							);
						}else if($charge_type == 4){
							$total_business_income = $this->getUserParamById("total_business_income",$user_id);
							$new_total_business_income = $total_business_income + $real_placement_income;

							$form_array = array(
								'total_business_income' => $new_total_business_income
							);
						}

						if($this->updateUserTable($form_array,$user_id)){

						}

						$sponsored_business_partner_id = $creditors_user_id;
						$sponsored_business_partner_username = $this->getUserNameById($sponsored_business_partner_id);
						$sponsored_business_partner_slug = $this->getUserParamById("slug",$sponsored_business_partner_id);
						$sponsored_business_partner_full_name = $this->getUserParamById("full_name",$sponsored_business_partner_id);
						$sponsored_business_partner_phone_code = $this->getUserParamById("phone_code",$sponsored_business_partner_id);
						$sponsored_business_partner_phone_num = $this->getUserParamById("phone",$sponsored_business_partner_id);
						$sponsored_business_partner_phone_num =  "+". $sponsored_business_partner_phone_code . "" . $sponsored_business_partner_phone_num;

						$title = "Credit Alert";
		        		$message = "This Is To Alert You That You Were Credited With Placement Income. View Details Below.";
		        		$message .= "<div class='container' style='margin-top: 30px;'>";
		        		$message .= "<p>Placement Income Amount: <em class='text-primary'>".number_format($placement_income,2)."</em><p>";
		        		$message .= "<p>Placement Income Vat: <em class='text-primary'>".number_format($placement_income_vat,2)."%</em><p>";
		        		// $message .= "<p>Withdrawable Placement Balance: <em class='text-primary'>".number_format($real_placement_income,2)."</em><p>";

		        		if($charge_type == 2){
			        		$message .= "<h4 class='text-center' style='margin-top: 20px;'>Newly Placement Basic Partner Details<h4>";
			        	}else if($charge_type == 4){
			        		$message .= "<h4 class='text-center' style='margin-top: 20px;'>Newly Placement Business Partner Details<h4>";
			        	}

			        	$message .= "<p>Username: <a target='_blank' href='".site_url('Sabicapital/'.$sponsored_business_partner_slug)."'>".$sponsored_business_partner_username."</a><p>";

			        	$message .= "<p>Full Name: <em class='text-primary'>".$sponsored_business_partner_full_name."</em><p>";
			        	// $message .= "<p>Phone Number: <em class='text-primary'>".$sponsored_business_partner_phone_num."</em><p>";

		        		$message .= "</div>";
		        		

						$form_array = array(
							'sender' => "System",
							'receiver' => $user_id,
							'title' => $title,
							'message' => $message,
							'date_sent' => $date,
							'time_sent' => $time,
							'type' => 'misc'
						);

						$history_array = array(
							'user_id' => $user_id,
							'income_type' => 'placement',
							'creditors_id' => $sponsored_business_partner_id,
							'amount' => $placement_income,
							'vat' => $placement_income_vat,
							'date' => $date,
							'time' => $time
						);

						if($charge_type == 2){
							$history_array['package'] = 1;
						}elseif($charge_type == 4){
							$history_array['package'] = 2;
						}

						if(($this->sendMessage($form_array) && $this->addMlmIncomeHistory($history_array)) && $i == ($ids_to_credit_num - 1)){
							return true;
						}
					}
				}
			}
		}

		public function addMlmIncomeHistory($history_array){
			return $this->db->insert("mlm_income_history",$history_array);
		}

		public function makeSureUserHasReferredAtLeastTenPersonsInMlm($user_id){
			$num = 0;
			$mlm_db_ids = $this->getAllUsersMlmDbIds($user_id);
			// print_r($mlm_db_ids);
			if(is_array($mlm_db_ids)){
				$query = $this->db->get_where("mlm_db");
				foreach($query->result() as $row){
					$sponsor = $row->sponsor;
					if(in_array($sponsor,$mlm_db_ids )){
						$num++;
					}
				}
			}
			// echo $num;
			if($num >= 10){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserHasAtLeastOneBusinessAccount($user_id){
			$num = 0;
			$query = $this->db->get_where("mlm_db",array('user_id' => $user_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$package = $row->package;
					if($package == 2){
						$num++;
					}
				}
			}
			// echo $num;
			if($num >= 1){
				return true;
			}else{
				return false;
			}
		}

		public function getAllUsersMlmDbIds($user_id){
			$ret_arr = array();
			// $query = $this->db->get_where("mlm_db",array('user_id' => $user_id));
			$this->db->select("id");
			$this->db->from("mlm_db");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] = $id;
				}
			}
			return $ret_arr;
		}

		public function checkIfMlmDbIdHasNoAvailablePositionUnderHim($mlm_db_id){
			$query = $this->db->get_where("mlm_db",array('under' => $mlm_db_id));
			if($query->num_rows() == 2){
				return true;
			}else{
				return false;
			}
		}

		public function getAvailablePositionUnderMlmDbId($mlm_db_id){
			if($this->checkIfMlmDbIdIsValid($mlm_db_id)){
				$query = $this->db->get_where("mlm_db",array('under' => $mlm_db_id));
				if($query->num_rows() == 0){
					return "both";
				}else if($query->num_rows() == 1){
					$taken_id = $this->getChildrenOfParent($mlm_db_id)[0]->id;
					$taken_position = $this->getMlmDbParamById("positioning",$taken_id);
					if($taken_position == "left"){
						return "right";
					}else{
						return "left";
					}
				}else{
					return false;
				}
			}	
		}

		public function checkIfMlmDbIdIsValid($mlm_db_id){
			$query = $this->db->get_where("mlm_db",array('id' => $mlm_db_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfMlmDbIdBelongsToUser($mlm_db_id,$user_id){
			$query = $this->db->get_where("mlm_db",array('user_id' => $user_id,'id' => $mlm_db_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfMlmDbIdBelongsToUserOrDownline($mlm_db_id,$user_id){

		}

		public function loadMlmTableRecords($mlm_db_id){
			$query = $this->db->get_where("mlm_db",array('id' => $mlm_db_id));
			return $query->result();
		}

		public function checkIfUserIsValidForCreatingNewMlmAccount($user_id){
			$mlm_db_id = $this->getUsersFirstMlmDbId($user_id);
			if($this->getMlmDbParamById("package",$mlm_db_id) == 2){
				return true;
			}else{
				return false;
			}
		}

		public function getDownlineArr($parentID,$ret_arr = array()){

			
		    // Create the query
		    
		    $query_str = "SELECT * FROM mlm_db WHERE ";
		    if($parentID == null) {
		        $query_str .= "under IS NULL";
		    }
		    else {
		        $query_str .= "`under`=" . intval($parentID);
		    }

		    $query_str .= " ORDER BY positioning ASC";
		    // Execute the query and go through the results.
		    
		    $query = $this->db->query($query_str);
		    if($query->num_rows() > 0)
		    {
		    	
		        foreach($query->result() as $row)
		        {
		            $currentID = $row->id;
		            // echo $currentID;
		            $ret_arr[] = $currentID;
		            
			        $ret_arr = $this->getDownlineArr($currentID,$ret_arr);
		        }
		        
		    }
		    
		    return $ret_arr;
		}

		public function getMlmIdsIndexNumber($mlm_db_id){
			$array = array();
			$user_id = $this->getMlmDbParamById("user_id",$mlm_db_id);
			$this->db->select("id");
			$this->db->from("mlm_db");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","ASC");

			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$array[] = $id;
				}
			}

			if(count($array) > 0){
				for($i = 0; $i < count($array); $i++){
					if($mlm_db_id == $array[$i]){
						return $i + 1;
					}
				}
			}
		}

		public function printTree($package1,$your_mlm_db_id,$level=0, $parentID=null,$stage,$return_str = "",$j = 0)
		{
			$j++;
			// echo $j;
			// echo $level;

		    // echo '<ul>';
		    // echo '<li>';
		    // echo '<span class="tf-nc">'.$parentID.'</span>';
		    // Create the query
		    $num_1 = false;
		    $query_str = "SELECT * FROM mlm_db WHERE ";
		    if($parentID == null) {
		        $query_str .= "under IS NULL";
		    }
		    else {
		        $query_str .= "`under`=" . intval($parentID);
		    }

		    $query_str .= " ORDER BY positioning ASC";
		    // Execute the query and go through the results.
		    
		    $query = $this->db->query($query_str);
		    if($query->num_rows() > 0)
		    {
		    	if($query->num_rows() == 1){
		    		$num_1 = true;
		    	}
		    	
		    	$return_str .= '<ul>';
		        foreach($query->result() as $row)
		        {
		        	
		        	
		            // Print the current ID;
		            $currentID = $row->id;
		            $positioning = $row->positioning;
		            $user_id = $row->user_id;
		            $logo = $this->getUserParamById("logo",$user_id);
		            $user_name = $this->getUserParamById("user_name",$user_id);
		            $full_name = $this->getUserParamById("full_name",$user_id);
		            $package = $row->package;
		            $index = $this->getMlmIdsIndexNumber($currentID);
		            if($package == 1){
		            	$package = "basic";
		            }else{
		            	$package = "business";
		            }
		            if(is_null($logo)){
		            	$logo = "avatar21.jpg";
		            }
		            if($num_1){
		            	if($positioning == "left"){
			            	$return_str .= '<li>';
			            	$return_str .= '<div class="tf-nc ' . $package . '">';
					    	$return_str .= '<img class="" src="'.base_url('assets/images/'.$logo).'" style="width: 100%; border-radius: 50%; height: 40%;" alt="">';
							$return_str .= '<p class="name">'.$full_name.'</p>';
							$return_str .= '<p class="user-name">'.$user_name. ' (' . $index . ') ' . '</p>';
							$return_str .= '<p class="package">'.$package.'</p>';
							$return_str .= '<div class="icons-div">';
							if($package == "basic"){
								$return_str .= '<button style="margin-right: 8px;" onclick="goUpMlm(this,event,'.$currentID.','.$your_mlm_db_id.')" data-package="'.$package1.'" class="btn  btn-success btn-fab btn-fab-mini btn-round">';
							}else{
								$return_str .= '<button style="margin-right: 8px;" onclick="goUpMlm(this,event,'.$currentID.','.$your_mlm_db_id.')" data-package="'.$package1.'"  class="btn  btn-primary btn-fab btn-fab-mini btn-round">';
							}
							$return_str .= '<i class="fas fa-arrow-up"></i>';
							$return_str .= '</button>';

							if($package == "basic"){
								$return_str .= '<button onclick="goDownMlm(this,event,'.$currentID.','.$your_mlm_db_id.')" style="margin-right: 10px;" data-package="'.$package1.'" class="btn  btn-success btn-fab btn-fab-mini btn-round">';
							}else{
								$return_str .= '<button onclick="goDownMlm(this,event,'.$currentID.','.$your_mlm_db_id.')"  style="margin-right: 10px;" data-package="'.$package1.'" class="btn  btn-primary btn-fab btn-fab-mini btn-round">';
							}
							$return_str .= '<i class="fas fa-arrow-down"></i>';
							$return_str .= '</button>';
					        // echo '<span class="tf-nc">'.$currentID.'</span>';
					        $return_str .= '</div>';
					        $return_str .= '</div>';
				            // $return_str .= '</li>';

				            // $return_str .= '<li>';
			            	// $return_str .= '<div style="cursor:pointer;" class="tf-nc register" data-under="'.$parentID .'">';
			            	
            				// $return_str .= '<p class="register-text">Register</p>';
				            // // echo '<span class="tf-nc">'.$currentID.'</span>';
				            // $return_str .= '</div>';
				            // $return_str .= '</li>';
				           
				        }else{
				        	// $return_str .= '<li>';
			          //   	$return_str .= '<div style="cursor:pointer;" class="tf-nc register" data-under="'.$parentID .'">';
			            	
            	// 			$return_str .= '<p class="register-text">Register</p>';
				         //    // echo '<span class="tf-nc">'.$currentID.'</span>';
				         //    $return_str .= '</div>';
				         //    $return_str .= '</li>';

				        	$return_str .= '<li>';
			            	$return_str .= '<div class="tf-nc ' . $package . '">';
					    	$return_str .= '<img class=""  src="'.base_url('assets/images/'.$logo).'" style="width: 100%; border-radius: 50%; height: 40%;" alt="">';
							$return_str .= '<p class="name">'.$full_name.'</p>';
							$return_str .= '<p class="user-name">'.$user_name. ' (' . $index . ') ' . '</p>';
							$return_str .= '<p class="package">'.$package.'</p>';
							$return_str .= '<div class="icons-div">';
							if($package == "basic"){
								$return_str .= '<button style="margin-right: 8px;" onclick="goUpMlm(this,event,'.$currentID.','.$your_mlm_db_id.')" data-package="'.$package1.'" class="btn  btn-success btn-fab btn-fab-mini btn-round">';
							}else{
								$return_str .= '<button style="margin-right: 8px;" onclick="goUpMlm(this,event,'.$currentID.','.$your_mlm_db_id.')" data-package="'.$package1.'" class="btn  btn-primary btn-fab btn-fab-mini btn-round">';
							}
							$return_str .= '<i class="fas fa-arrow-up"></i>';
							$return_str .= '</button>';

							if($package == "basic"){
								$return_str .= '<button onclick="goDownMlm(this,event,'.$currentID.','.$your_mlm_db_id.')" style="margin-right: 10px;" data-package="'.$package1.'" class="btn  btn-success btn-fab btn-fab-mini btn-round">';
							}else{
								$return_str .= '<button onclick="goDownMlm(this,event,'.$currentID.','.$your_mlm_db_id.')"  style="margin-right: 10px;" data-package="'.$package1.'" class="btn  btn-primary btn-fab btn-fab-mini btn-round">';
							}
							$return_str .= '<i class="fas fa-arrow-down"></i>';
							$return_str .= '</button>';
					        // echo '<span class="tf-nc">'.$currentID.'</span>';
					        $return_str .= '</div>';
					        $return_str .= '</div>';
				            
				            
				        }
		            }else{
			            $return_str .= '<li>';
		            	$return_str .= '<div class="tf-nc ' . $package . '">';
				    	$return_str .= '<img class="" src="'.base_url('assets/images/'.$logo).'" style="width: 100%; border-radius: 50%; height: 40%;" alt="">';
						$return_str .= '<p class="name">'.$full_name.'</p>';
						$return_str .= '<p class="user-name">'.$user_name. ' (' . $index . ') ' . '</p>';
						$return_str .= '<p class="package">'.$package.'</p>';
						$return_str .= '<div class="icons-div">';
						if($package == "basic"){
							$return_str .= '<button style="margin-right: 8px;" onclick="goUpMlm(this,event,'.$currentID.','.$your_mlm_db_id.')"  data-package="'.$package1.'" class="btn  btn-success btn-fab btn-fab-mini btn-round">';
						}else{
							$return_str .= '<button style="margin-right: 8px;" onclick="goUpMlm(this,event,'.$currentID.','.$your_mlm_db_id.')"  data-package="'.$package1.'" class="btn  btn-primary btn-fab btn-fab-mini btn-round">';
						}
						$return_str .= '<i class="fas fa-arrow-up"></i>';
						$return_str .= '</button>';

						if($package == "basic"){
							$return_str .= '<button onclick="goDownMlm(this,event,'.$currentID.','.$your_mlm_db_id.')" style="margin-right: 10px;" data-package="'.$package1.'" class="btn  btn-success btn-fab btn-fab-mini btn-round">';
						}else{
							$return_str .= '<button onclick="goDownMlm(this,event,'.$currentID.','.$your_mlm_db_id.')"  style="margin-right: 10px;" data-package="'.$package1.'" class="btn  btn-primary btn-fab btn-fab-mini btn-round">';
						}
						$return_str .= '<i class="fas fa-arrow-down"></i>';
						$return_str .= '</button>';
				        // echo '<span class="tf-nc">'.$currentID.'</span>';
				        $return_str .= '</div>';
				        $return_str .= '</div>';
				            
			        }
		            
		            for($i = 0; $i < $level; $i++) {
		                $return_str .= " ";
		            }

		            // echo $currentID . PHP_EOL;
		            // Print all children of the current ID
		            if($j < $stage){
		            	// echo $j;
			            $return_str = $this->printTree($package1,$your_mlm_db_id,$level+1, $currentID,$stage,$return_str,$j);
			        }
		           
		            $return_str .= '</li>';
		        }
		        $return_str .= '</ul>';
		        
		    }
		    else {
		  //       $return_str .= '<ul>';
		  //       $return_str .= '<li>';
    //         	$return_str .= '<div style="cursor:pointer;" class="tf-nc register" data-under="'.$parentID .'">';
            	
				// $return_str .= '<p class="register-text">Register</p>';
	   //          // echo '<span class="tf-nc">'.$currentID.'</span>';
	   //          $return_str .= '</div>';
	   //          $return_str .= '</li>';
	            
				// $return_str .= '<li>';
    //         	$return_str .= '<div style="cursor:pointer;" class="tf-nc register" data-under="'.$parentID .'">';
            	
				// $return_str .= '<p class="register-text">Register</p>';
	   //          // echo '<span class="tf-nc">'.$currentID.'</span>';
	   //          $return_str .= '</div>';
	   //          $return_str .= '</li>';
	   //          $return_str .= '</ul>';
		    }
		    // echo '</li>';
		    // echo '</ul>';
		    return $return_str;
		}

		public function printSponsorTree($level=0, $parentID=null,$stage,$return_str = "",$j = 0)
		{
			$j++;
			// echo $j;
			// echo $level;

		    // echo '<ul>';
		    // echo '<li>';
		    // echo '<span class="tf-nc">'.$parentID.'</span>';
		    // Create the query
		    $num_1 = false;
		    $query_str = "SELECT * FROM mlm_db WHERE ";
		    if($parentID == null) {
		        $query_str .= "sponsor IS NULL";
		    }
		    else {
		        $query_str .= "`sponsor`=" . intval($parentID);
		    }

		    $query_str .= " ORDER BY positioning ASC";
		    // Execute the query and go through the results.
		    
		    $query = $this->db->query($query_str);
		    if($query->num_rows() > 0)
		    {
		    	if($query->num_rows() == 1){
		    		$num_1 = true;
		    	}
		    	
		    	$return_str .= '<ul>';
		        foreach($query->result() as $row)
		        {
		        	
		        	
		            // Print the current ID;
		            $currentID = $row->id;
		            $positioning = $row->positioning;
		            $user_id = $row->user_id;
		            $logo = $this->getUserParamById("logo",$user_id);
		            $user_name = $this->getUserParamById("user_name",$user_id);
		            $full_name = $this->getUserParamById("full_name",$user_id);
		            $index = $this->getMlmIdsIndexNumber($currentID);
		            $package = $row->package;
		            if($package == 1){
		            	$package = "basic";
		            }else{
		            	$package = "business";
		            }
		            if(is_null($logo)){
		            	$logo = "avatar21.jpg";
		            }
		            if($num_1){
		            	if($positioning == "left"){
			            	$return_str .= '<li>';
			            	$return_str .= '<div class="tf-nc ' . $package . '">';
			            	$return_str .= '<img class="" src="'.base_url('assets/images/'.$logo).'" style="width: 100%; border-radius: 50%; height: 40%;" alt="">';
            				$return_str .= '<p >'.$full_name.'</p>';
            				$return_str .= '<p class="user-name">'.$user_name. ' (' . $index . ') ' . '</p>';
            				$return_str .= '<p class="package">'.$package.'</p>';
				            // echo '<span class="tf-nc">'.$currentID.'</span>';
				            $return_str .= '</div>';
				            // $return_str .= '</li>';

				            
				            // $return_str .= '</li>';
				            
				           
				           
				        }else{
				        	

				        	$return_str .= '<li>';
			            	$return_str .= '<div class="tf-nc ' . $package . '">';
			            	$return_str .= '<img class="" src="'.base_url('assets/images/'.$logo).'" style="width: 100%; border-radius: 50%; height: 40%;" alt="">';
            				$return_str .= '<p >'.$full_name.'</p>';
            				$return_str .= '<p class="user-name">'.$user_name. ' (' . $index . ') ' . '</p>';
            				$return_str .= '<p class="package">'.$package.'</p>';
				            // echo '<span class="tf-nc">'.$currentID.'</span>';
				            $return_str .= '</div>';
				            
				            
				        }
		            }else{
			            $return_str .= '<li>';
		            	$return_str .= '<div class="tf-nc ' . $package . '">';
		            	$return_str .= '<img class="" src="'.base_url('assets/images/'.$logo).'" style="width: 100%; border-radius: 50%; height: 40%;" alt="">';
        				$return_str .= '<p >'.$full_name.'</p>';
        				$return_str .= '<p class="user-name">'.$user_name. ' (' . $index . ') ' . '</p>';
        				$return_str .= '<p class="package">'.$package.'</p>';
			            // echo '<span class="tf-nc">'.$currentID.'</span>';
			            $return_str .= '</div>';
				            
			        }
		            
		            for($i = 0; $i < $level; $i++) {
		                $return_str .= " ";
		            }

		            // echo $currentID . PHP_EOL;
		            // Print all children of the current ID
		            if($j < $stage){
		            	// echo $j;
			            $return_str = $this->printSponsorTree($level+1, $currentID,$stage,$return_str,$j);
			        }
		           
		            $return_str .= '</li>';
		        }
		        $return_str .= '</ul>';
		        
		    }
		    else {
		        
		    }
		    // echo '</li>';
		    // echo '</ul>';
		    return $return_str;
		}

		function printTree1($level=0, $parentID=null)
		{
		    // global $dbLink;
		    // Create the query
		    $query_str = "SELECT * FROM mlm_db WHERE ";
		    if($parentID == null) {
		        $query_str .= "under IS NULL";
		    }
		    else {
		        $query_str .= "`under`=" . intval($parentID);
		    }
		    // Execute the query and go through the results.
		    // $result = $dbLink->query($sql);
		    $query_str .= " ORDER BY id ASC";
		    $query = $this->db->query($query_str);
		    if($query->num_rows() > 0)
		    {
		        foreach($query->result() as $row)
		        {
		            // Print the current ID;
		            $currentID = $row->id;
		            for($i = 0; $i < $level; $i++) {
		                echo " ";
		            }
		            echo $currentID . PHP_EOL;
		            // Print all children of the current ID
		            $this->printTree1($level+1, $currentID);
		        }
		        
		    }
		    else {
		        // echo "nothing here";
		    }
		}



		public function getThisAccountsTotalEarnings($id){
			$total_amount = 0;
			// $query = $this->db->get_where("mlm_earnings",array('mlm_db_id' => $id));
			$this->db->select("*");
			$this->db->from("mlm_earnings");
			$this->db->where("mlm_db_id",$id);
			$this->db->where("charge_type !=",11);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$real_amount = $amount - ($vat_perc * $amount);
					$total_amount += $real_amount;
				}
			}
			return $total_amount;
		}

		public function getThisAccountsTotalBasicEarnings($id){
			$total_amount = 0;
			
			// $this->db->select("*");
			// $this->db->from("mlm_earnings");
			// $this->db->where("charge_type",1);
			// $this->db->or_where("charge_type",2);
			// $this->db->or_where("charge_type",5);
			
			

			$query_str = "SELECT * FROM mlm_earnings WHERE mlm_db_id = " . $id . " AND (charge_type = 1 OR charge_type = 2 OR charge_type = 5)";
			
			$query = $this->db->query($query_str);
			// echo $this->db->last_query();
			if($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$mlm_db_id = $row->mlm_db_id;
					
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$real_amount = $amount - ($vat_perc * $amount);
					$total_amount += $real_amount;
					
				}
			}
			return $total_amount;
		}

		public function getThisAccountsCarAwardFunds($id){
			$total_amount = 0;
			// $query = $this->db->get_where("mlm_earnings",array('mlm_db_id' => $id));
			// $this->db->select("*");
			// $this->db->from("mlm_earnings");
			// $this->db->where("charge_type",11);

			$query_str = "SELECT * FROM mlm_earnings WHERE charge_type = 11 AND mlm_db_id = " .$id;
			
			// $this->db->where("mlm_db_id",$id);
			
			$query = $this->db->query($query_str);
			// echo $this->db->last_query();
			if($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$mlm_db_id = $row->mlm_db_id;
					// if($mlm_db_id == $id){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = $vat / 100;

					$real_amount = $amount - ($vat_perc * $amount);
					$total_amount += $real_amount;
					// }
				}
			}
			return $total_amount;
		}

		public function getThisAccountsTotalBusinessEarnings($id){
			$total_amount = 0;
			
			// $this->db->select("*");
			// $this->db->from("mlm_earnings");
			// $this->db->where("charge_type",3);
			// $this->db->or_where("charge_type",4);
			
			// $this->db->or_where("charge_type",6);
			// $this->db->or_where("charge_type",7);
			// $this->db->or_where("charge_type",8);
			// $this->db->or_where("charge_type",9);
			// $this->db->or_where("charge_type",10);
			// $this->db->or_where("charge_type",12);
			

			$query_str = "SELECT * FROM mlm_earnings WHERE mlm_db_id = " . $id . " AND (charge_type = 3 OR charge_type = 4 OR charge_type = 6 OR charge_type = 7 OR charge_type = 8 OR charge_type = 9 OR charge_type = 10 OR charge_type = 12)";
			
			$query = $this->db->query($query_str);
			// echo $this->db->last_query();
			if($query->num_rows() > 0) {
				foreach($query->result() as $row){
					$mlm_db_id = $row->mlm_db_id;
					// if($mlm_db_id == $id){
					$amount = $row->amount;
					$vat = $row->vat;
					$vat_perc = round($vat / 100,2);

					$real_amount = round($amount - ($vat_perc * $amount),2);
					$total_amount += $real_amount;
					// }
				}
			}
			return $total_amount;
		}

		public function getUsersMlmAccounts($user_id){
			// $query = $this->db->get_where("mlm_db",array('user_id' => $user_id));
			$this->db->select("*");
			$this->db->from("mlm_db");
			$this->db->where("user_id",$user_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUsersBusinessAccounts($user_id){
			// $query = $this->db->get_where("mlm_db",array('user_id' => $user_id));
			$this->db->select("*");
			$this->db->from("mlm_db");
			$this->db->where("user_id",$user_id);
			$this->db->where("package",2);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUsersBasicAccounts($user_id){
			$query = $this->db->get_where("mlm_db",array('user_id' => $user_id,'package' => 1));
			// $this->db->select("*");
			// $this->db->from("mlm_db");
			// $this->db->where("user_id",$user_id);
			// $this->db->where("package",1);
			// $this->db->order_by("id","DESC");
			// $query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getChildrenOfParent($mlm_db_id){
			// $query = $this->db->get_where("mlm_db",array('under' => $mlm_db_id));
			$this->db->select("*");
			$this->db->from("mlm_db");
			$this->db->where("under",$mlm_db_id);
			$this->db->order_by("id","ASC");
			// $this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfThisMlmUserHasChildren($mlm_db_id){
			$query = $this->db->get_where("mlm_db",array('under' => $mlm_db_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getMlmDbParamById($param,$mlm_db_id){
			$query = $this->db->get_where("mlm_db",array('id' => $mlm_db_id));
			if($query->num_rows() == 1){
				return $query->result()[0]->$param;
			}
		}

		public function getReferredIdByUserId($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$referred_by = $row->referred_by;
				}
				return $referred_by;
			}
		}

		public function getPhoneCodeById($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$phone_code = $row->phone_code;
				}
				return $phone_code;
			}
		}

		public function getPhoneById($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$phone = $row->phone;
				}
				return $phone;
			}
		}

		public function getUserReferredByForSpons($user_id){
			$ret = "";
			$referred_by = $this->getReferredIdByUserId($user_id);
			if($this->checkIfUserExists1($referred_by)){
				$phone_code = $this->getPhoneCodeById($referred_by);
				$phone = $this->getPhoneById($referred_by);
				$phone = "0" . $phone ;
				$ret = $phone;
			}
			return $ret;
		}

		public function getCountryCodeByCountryId($country_id){
			$query = $this->db->get_where('countries',array('id' => $country_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$code = $row->code;
				}
				return $code;
			}
		}

		public function getFullMobileNoByUserName($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$phone_code = $row->phone_code;
					$phone = $row->phone;
				}
				$full_num = "+" . $phone_code . "" . $phone;
			}
			if(isset($full_num)){
				return $full_num;
			}else{
				return "";
			}
		}

		public function getCountryCodeById($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$country_id = $row->country_id;
				}
				
				$country_code = $this->getCountryCodeByCountryId($country_id);
				return $country_code;
			}
		}

		public function getUserReferredByForSponsCountryCode($user_id){
			$ret = "";
			$referred_by = $this->getReferredIdByUserId($user_id);
			if($this->checkIfUserExists1($referred_by)){
				$phone_code = $this->getCountryCodeById($referred_by);
			}
			return $ret;
		}

		public function checkIfserIsBouyant($second_addition,$user_id){
			if($second_addition == "new_nigeria" || $second_addition == "great_nigeria"){
				$query = $this->db->get_where('users',array('id' => $user_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$total_income = $row->total_income;
						$withdrawn = $row->withdrawn;
						$real_income = $total_income - $withdrawn;
					}
					
					if($second_addition == "new_nigeria"){
						if($real_income >= 2498){
							return true;
						}else{
							return false;
						}
					}else{
						if($real_income >= 5000){
							return true;
						}else{
							return false;
						}
					}
				}
			}
		}

		public function checkIfserIsBouyant1($user_id,$amount){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$total_income = $row->total_income;
					$withdrawn = $row->withdrawn;
					$real_income = $total_income - $withdrawn;
				}
				if($real_income >= $amount){
					return true;
				}else{
					return false;
				}
			}
		}

		// public function activateResubscription($user_id,$type,$interval){
		// 	$date = date("j M Y");
		// 	if($type == "new_nigeria"){
		// 		$form_array = array(
		// 			'active_subscription1' => 1,
		// 			'active_subscription1_interval' => $interval,
		// 			'active_subscription1_start_date' => $date,
		// 			'active_subscription1_last_date' => $date
		// 		);
		// 	}else{
		// 		$form_array = array(
		// 			'active_subscription2' => 1,
		// 			'active_subscription2_interval' => $interval,
		// 			'active_subscription2_start_date' => $date,
		// 			'active_subscription2_last_date' => $date
		// 		);
		// 	}
		// 	if($this->db->update('users',$form_array,array('id' => $user_id))){
		// 		return true;
		// 	}else{
		// 		return false;
		// 	}
		// }

		public function checkIfUserHasReferredAnyOne($user_id){
			$query = $this->db->get_where('new_nigeria',array('referred_by' => $user_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				$query = $this->db->get_where('great_nigeria',array('referred_by' => $user_id));
				if($query->num_rows() > 0){
					return true;
				}
			}
		}

		public function checkIfUserHasReferredAtLeast15People(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where("users",array('referred_by' => $user_id));
			if($query->num_rows() >= 0){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsACenterLeader(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where("users",array('id' => $user_id,'center_leader' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}


		public function checkIfUserOwnsThisMessage($id,$user_name){
			$query = $this->db->get_where('notif',array('id' => $id,'receiver' => $user_name));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getNotifById($id){
			$query = $this->db->get_where('notif',array('id' => $id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPersonnelBySubDeptIdAndDeptId($dept_id,$sub_dept_id){
			$query = $this->db->get_where('personnel',array('sub_dept_id' => $sub_dept_id,'dept_id' => $dept_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUsersAndHealthFacilities($search_val){
			$this->db->select("a.name,b.user_name");
			$this->db->from('health_facility as a');
			$this->db->from('users as b');
			$this->db->like('a.name',$search_val,'after');
			$this->db->or_like('b.user_name',$search_val,'after');
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}

		}

		public function getUserBySlug($slug){
			$query = $this->db->get_where('users',array('slug' => $slug));
			if($query->num_rows() == 1){
				return $query->num_rows();
			}else{
				return false;
			}
		}

		public function getUserById($slug){
			$query = $this->db->get_where('users',array('id' => $slug));
			if($query->num_rows() == 1){
				return $query->num_rows();
			}else{
				return false;
			}
		}

		public function getHealthFacilities($search_val){
			$this->db->select("*");
			$this->db->from("health_facility");
			$this->db->like("health_facility.name",$search_val,"after");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getFirstHealthFacilities($search_val){
			$this->db->select("*");
			$this->db->from("health_facility");
			$this->db->like("name",$search_val,"after");
			$this->db->limit(10);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPaginationHealthFacilities($search_val){
			$this->db->select("*");
			$this->db->from("health_facility");
			$this->db->like("name",$search_val,"after");
			
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		

		public function getFirstPatients($search_val){
			$this->db->select("*");
			$this->db->from("users");
			$this->db->where('is_patient',1);
			$this->db->where('is_admin',0);
			$this->db->like("user_name",$search_val,"after");			
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getRealAffiliatedFacilities($affiliated_facilities){
			$affiliated_facilities_arr = explode(",", $affiliated_facilities);
			foreach ($affiliated_facilities_arr as $key => $value) {
                if (empty($value)) {
                   unset($affiliated_facilities_arr[$key]);
                }
            }
            if(!empty($affiliated_facilities_arr)){
            	$new_str = "";
            	for($i = 0; $i < count($affiliated_facilities_arr); $i++){
            		$health_facility_table_name = $affiliated_facilities_arr[$i];
            		if($this->db->table_exists($health_facility_table_name)){
	            		$query = $this->db->get($health_facility_table_name,1);
	            		if($query->num_rows() == 1){
	            			foreach($query->result() as $row){
	            				$health_facility_name = $row->facility_name;
	            				$new_str .= $health_facility_name .',';
	            			}
	            		}
	            	}
            		
            	}
            	return $new_str;
            }else{
            	return "";
            }
		}



		public function getHealthFacilityTableByDeptAndPosition($health_facility_table_name,$dept,$sub_dept){
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,"personnel" => "",'position' => 'sub_admin' , 'is_admin' => 1));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getSubAdmins($health_facility_table_name,$dept,$sub_dept){
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,"personnel" => "",'position' => 'sub_admin' , 'is_admin' => 1));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getSubAdminsNum($health_facility_table_name,$dept,$sub_dept){

			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,"personnel" => "",'position' => 'sub_admin' , 'is_admin' => 1));
			return $query->num_rows();
		}

		public function getPersonnel($health_facility_table_name,$dept,$sub_dept,$personnel){
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,"personnel" => $personnel,'position' => 'personnel' , 'is_admin' => 1));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPersonnelNum($health_facility_table_name,$dept,$sub_dept,$personnel){
			// echo $dept . ' : ' . $sub_dept . ' : ' .$personnel; 
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,'personnel' => $personnel));
			return $query->num_rows();
		}

		public function getUserPosition($health_facility_table_name,$user_id){
			$query = $this->db->get_where($health_facility_table_name,array('user_id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$position = $row->position;
				}
				return $position;
			}else{
				return false;
			}
		}


		public function getHealthFacilityTableByDeptAndPositionPersonnel($health_facility_table_name,$dept,$sub_dept,$personnel){
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,"personnel" => $personnel,'position' => 'personnel'));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfUserIsAdminOfFacility($hospital_table_name,$user_id){
			$query = $this->db->get_where($hospital_table_name,array('user_id' => $user_id,'position' => 'admin'));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getHealthFacilityTableBySubDeptDeptAndPosition($health_facility_table_name,$dept,$sub_dept,$personnel){
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,'personnel' => $personnel,'position' => 'personnel'));
			// echo $query->num_rows();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getHealthFacilityTableBySubDeptAndPosition($health_facility_table_name,$sub_dept,$user_position){
			$query = $this->db->get_where($health_facility_table_name,array('sub_dept' => $sub_dept,'position' => 'personnel',));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getHealthFacilityTableByDeptSubDeptAndPosition($health_facility_table_name,$dept,$sub_dept,$personnel){
			// echo $dept . ' : ' . $sub_dept .' : ' .$personnel; 
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'position' => 'personnel','sub_dept' => $sub_dept,'personnel' => $personnel));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function slugifyDept($form_array,$dept_id){
			$query = $this->db->update('personnel',$form_array,array('id' => $dept_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getDeptBooleanBySlug($slug){
			$query = $this->db->get_where('dept',array('slug' => $slug));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getSubDeptBooleanBySlug($slug){
			$query = $this->db->get_where('sub_dept',array('slug' => $slug));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getPersonnelBooleanBySlug($slug){
			$query = $this->db->get_where('personnel',array('slug' => $slug));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getDeptById($dept_id){
			$query = $this->db->get_where('dept',array('id' => $dept_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getSubDeptBySlugAndDeptId($dept_id,$slug){
			$query = $this->db->get_where('sub_dept',array('slug' => $slug,'dept_id' => $dept_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkForSubAdmin($health_facility_table_name,$dept,$sub_dept){
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,'personnel' => "",'position' => 'sub_admin' , 'is_admin' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function checkForPersonnel($health_facility_table_name,$dept,$sub_dept,$personnel){
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $dept,'sub_dept' => $sub_dept,'personnel' => $personnel,'position' => 'personnel'));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getPersonnelBySlugDeptIdAndSubDeptId($slug,$dept_id,$sub_dept_id){
			$query = $this->db->get_where('personnel',array('slug' => $slug,'dept_id' => $dept_id,'sub_dept_id' => $sub_dept_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getDeptBySlug($slug){
			$query = $this->db->get_where('dept',array('slug' => $slug));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPersonnelByDeptIdAndSubDeptId($dept_id,$sub_dept_id){
			$query = $this->db->get_where('personnel',array('dept_id' => $dept_id,'sub_dept_id' => $sub_dept_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getDeptIdBySlug($slug){
			$query = $this->db->get_where('dept',array('slug' => $slug));
			if($query->num_rows() == 1){
				foreach($query->result() as $row ){
					$dept_id = $row->id;
				}
				return $dept_id;
			}else{
				return false;
			}
		}

		public function getSubDeptIdBySlugAndDeptId($slug,$dept_id){
			$query = $this->db->get_where('sub_dept',array('slug' => $slug,'dept_id' => $dept_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row ){
					$sub_dept_id = $row->id;
				}
				return $sub_dept_id;
			}else{
				return false;
			}
		}

		public function getPersonnelIdBySlugDeptIdAndSubDeptId($slug,$dept_id,$sub_dept_id){
			$query = $this->db->get_where('personnel',array('slug' => $slug,'dept_id' => $dept_id,'sub_dept_id' => $sub_dept_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row ){
					$personnel_id = $row->id;
				}
				return $personnel_id;
			}else{
				return false;
			}
		}


		public function getPersonnelBySlug($slug){
			$query = $this->db->get_where('personnel',array('slug' => $slug));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getSubDeptPostBySlug($sub_dept_slug,$dept_id){
			$query = $this->db->get_where('sub_dept',array('slug' => $sub_dept,'dept_id' => $dept_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $sub_dept){
					$post = $sub_dept->name; 
					$id = $sub_dept->id;
					return $id;
				}

			}else{
				return false;
			}
		}

		public function getPersonnelPostBySlug($personnel_slug,$dept_id,$sub_dept_id){
			$query = $this->db->get_where('personnel',array('slug' => $personnel_slug,'dept_id' => $dept_id,'sub_dept_id' => $sub_dept_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $personnel){
					$post = $personnel->name; 
					$id = $personnel->id;
					return $id;
				}

			}else{
				return false;
			}
		}

		public function getPersonnelsByDeptIdAndSubDeptId($dept_id,$sub_dept_id){
			$query = $this->db->get_where('personnel',array('dept_id' => $dept_id,'sub_dept_id' => $sub_dept_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		//Add SubAdmin
		public function addSubAdmin($table_name,$health_facility_table_array){
			$query = $this->db->insert($table_name,$health_facility_table_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}
		public function getCountries(){
			$query = $this->db->query('SELECT * FROM countries ORDER BY name ASC');

			if($query->num_rows() > 0){
				return $query->result();
			}

		}

		public function getCountryById($id){
			$query = $this->db->get_where('countries',array('id' => $id),1);

			if(is_array($query->result())){
				foreach($query->result() as $row){
					return $row->name;
				}
			}
		}

		public function getCountryAcrById($id){
			$query = $this->db->get_where('countries',array('id' => $id),1);

			if(is_array($query->result())){
				foreach($query->result() as $row){
					return $row->code;
				}
			}
		}

		public function getStateById($id){
			$query = $this->db->query('SELECT * FROM regions WHERE id = '.$id.' ORDER BY id ASC');
			if(is_array($query->result())){
				foreach($query->result() as $row){
					return $row->name;
				}
			}
		}

		public function updateHealthFacility($form_array,$health_facility_id){
			$query = $this->db->update('health_facility',$form_array,array('id' => $health_facility_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getHealthFacilityLogo($health_facility_id){
			$query = $this->db->get_where('health_facility',array('id' => $health_facility_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$logo = $row->logo;
					return $logo;
				}
			}
		}
		
		public function getHealthFacilityIdByTableName($affiliated_facility_table){
			$query = $this->db->get_where('health_facility',array('table_name' => $affiliated_facility_table));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$id = $row->id;
				}
				return $id;
			}
		}

		public function getHealthFacilitySlugByTableName($affiliated_facility_table){
			$query = $this->db->get_where('health_facility',array('table_name' => $affiliated_facility_table));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$slug = $row->slug;
				}
				return $slug;
			}
		}
		public function getListOfStatesInCountryCommaSeeperated($id){
			$ret_arr = array();
			$this->db->select("id");
			$this->db->from("regions");
			$this->db->where("country_id",$id);
			
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] = $id;
				}
			}else{
				return false;
			}
			return implode(",", $ret_arr);
		}


		public function getListOfLocalsInStateCommaSeeperated($state_id){

			$ret_arr = array();
			$state_name = $this->getStateNameById($state_id);
			$other_state_id = $this->getOtherStateIdByName($state_name);
			$this->db->select("id");
			$this->db->from("locals");
			$this->db->where("state_id",$other_state_id);
			
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] = $id;
				}
			}else{
				return false;
			}
			return implode(",", $ret_arr);
		}

		public function getFirstRegionsByCountryId($id){
			$this->db->select("*");
			$this->db->from("regions");
			$this->db->where("country_id",$id);
			$this->db->order_by("name","ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}
		}

		public function getFirstLocalGovernments(){
			$this->db->select("*");
			$this->db->from("locals");
			$this->db->where("state_id",1);
			$this->db->order_by("name","ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}
		}

		public function getStateNameById($state_id){
			$this->db->select("name");
			$this->db->from("regions");
			$this->db->where("id",$state_id);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$name = $row->name;
				}
				return $name;
			}
		}

		public function getOtherStateIdByName($state_name){
			$this->db->select("*");
			$this->db->from("states");
			$this->db->where("name",$state_name);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				
				foreach($query->result() as $row){
					$id = $row->id;
				}
				return $id;
			}
		}

		public function getMiniImportationUndeliveredProductsNumByOrderCode($order_code){
			$query = $this->db->get_where("mini_importation_orders",array('order_code' => $order_code,'dispatched' => 0));
			return $query->num_rows();
		}

		public function getMiniImportationDeliveredProductsNumByOrderCode($order_code){
			$query = $this->db->get_where("mini_importation_orders",array('order_code' => $order_code,'dispatched' => 1));
			return $query->num_rows();
		}

		public function getCenterLeaderRequestsOrderCodesForUserUndelivered($user_id){
			// $query = $this->db->get_where("mini_importation_orders",array('center_leader' => $user_id));
			$ret_arr = array();
			$this->db->select("order_code");
			$this->db->from("mini_importation_orders");
			$this->db->where("center_leader",$user_id);
			$this->db->where("dispatched",0);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$order_code = $row->order_code;
					$ret_arr[] = $order_code;
				}
			}else{
				return false;
			}
			return array_values(array_unique($ret_arr));
		}


		public function getCenterLeaderRequestsOrderCodesForUserDelivered($user_id){
			// $query = $this->db->get_where("mini_importation_orders",array('center_leader' => $user_id));
			$ret_arr = array();
			$this->db->select("order_code");
			$this->db->from("mini_importation_orders");
			$this->db->where("center_leader",$user_id);
			$this->db->where("dispatched",1);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$order_code = $row->order_code;
					$ret_arr[] = $order_code;
				}
			}else{
				return false;
			}
			return array_values(array_unique($ret_arr));
		}


		public function getLocalGovernmentsByStateId($state_id){
			$state_name = $this->getStateNameById($state_id);
			$other_state_id = $this->getOtherStateIdByName($state_name);
			$this->db->select("*");
			$this->db->from("locals");
			$this->db->where("state_id",$other_state_id);
			$this->db->order_by("name","ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}
		}

		public function getMiniImportationOrderCurrentStatus($center_leader_id,$product_id){
			// $query = $this->db->get_where("mini_importation_orders_status",array('center_leader' => $center_leader_id,'product_id' => $product_id),1);
			$this->db->select("status");
			$this->db->from("mini_importation_orders_status");
			$this->db->where("center_leader",$center_leader_id);
			$this->db->where("product_id",$product_id);
			$this->db->order_by("id","DESC");
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				return $query->result()[0]->status;
			}
		}

		public function getMiniImportationOrderCurrentStatusByOrderId($order_id){
			// $query = $this->db->get_where("mini_importation_orders_status",array('center_leader' => $center_leader_id,'product_id' => $product_id),1);
			$current_status = "";
			$this->db->select("*");
			$this->db->from("mini_importation_orders");
			$this->db->where("id",$order_id);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$id = $row->id;
					$user_id = $row->user_id;
					$product_id = $row->product_id;
					$quantity = $row->quantity;
					$cart_date = $row->cart_date;
					$cart_time = $row->cart_time;
					$checked_out = $row->checked_out;
					$check_out_date = $row->check_out_date;
					$check_out_time = $row->check_out_time;
					$center_leader = $row->center_leader;
					$gotten_to_center_leader = $row->gotten_to_center_leader;
					$gotten_to_center_leader_date = $row->gotten_to_center_leader_date;
					$gotten_to_center_leader_time = $row->gotten_to_center_leader_time;
					$center_leader_recieved = $row->center_leader_recieved;
					$dispatched = $row->dispatched;
					$received_by_user = $row->received_by_user;
					$status = $row->status;
					$order_code = $row->order_code;
					$product_amount_paid = $row->product_amount_paid;
					$shipping_fee = $row->shipping_fee;
					$sent_to_dispatcher = $row->sent_to_dispatcher;
					$sent_to_dispatcher_date = $row->sent_to_dispatcher_date;
					$sent_to_dispatcher_time = $row->sent_to_dispatcher_time;
					$with_dispatcher = $row->with_dispatcher;
					$dispatcher = $row->dispatcher;

					if($sent_to_dispatcher == 0){
						$current_status = "Your Order Is Currently Shipping";
					}else if($with_dispatcher == 1 && $center_leader_recieved == 0){
						$dispatcher_full_name = $this->getUserParamById("full_name",$dispatcher);
						$dispatcher_slug = $this->getUserParamById("slug",$dispatcher);
						$current_status = "Your Order Is Currently With The Dispatcher, <em><a target='_blank' href='".site_url('Sabicapital/'.$dispatcher_slug)."'>" . $dispatcher_full_name . "</a></em> Heading To Center Leaders Location";
					}else if($center_leader_recieved == 1 && $dispatched == 0){
						$center_leader_full_name = $this->getUserParamById("full_name",$center_leader);
						$center_leader_slug = $this->getUserParamById("slug",$center_leader);
						$current_status = "Your Order Is Currently With Your Center Leader, <em><a target='_blank' href='".site_url('Sabicapital/'.$center_leader_slug)."'>" . $center_leader_full_name . "</a></em>. Please Proceed To Retrieve It.";
					}else if($dispatched == 1 && $received_by_user == 0){
						
						$current_status = "Your Center Leader Says You Have Picked Your Order. If So, Please Approve Below.";
					}else if($dispatched == 1 && $received_by_user == 1){
						$current_status = "You Have Picked This Order.";
					}
				}
			}
			return $current_status;
		}

		public function deleteMiniImportationStatusTable($id){
			return $this->db->delete("mini_importation_orders_status",array('id' => $id));
		}

		public function getMiniImporataionOrderStatusParamById($param,$id){
			$query = $this->db->get_where("mini_importation_orders_status",array('id' => $id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$param_val = $row->$param;
				}
				return $param_val;
			}
		}

		public function getLocalGovernmentByStateIdAndId($state_id,$id){
			$state_name = $this->getStateNameById($state_id);
			$other_state_id = $this->getOtherStateIdByName($state_name);
			$this->db->select("*");
			$this->db->from("locals");
			$this->db->where("state_id",$other_state_id);
			$this->db->where("id",$id);
			$this->db->order_by("name","ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result()[0]->name;
			}
		}

		public function getFirstLocalGovtIdOfState($state_id){
			$this->db->select("id");
			$this->db->from("locals");
			$this->db->where("state_id",$state_id);
			$this->db->order_by("name","ASC");
			$this->db->limit(1);
			$query = $this->db->get();
			// return $this->db->last_query();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
				}
				return $id;
			}else{
				return false;
			}
		}


		public function getRegionsByCountryId($country_id){
			$query = $this->db->get_where('regions',array('country_id' => $country_id));
			if($query->num_rows() > 0){
				return $query->result();
			}
		}

		public function getFirstCitiesByRegionAndCountryId(){
			$query = $this->db->get_where('cities',array('country_id' => 1,'region_id' => 2));
			if($query->num_rows() > 0){
				return $query->result();
			}
		}

		public function getCitiesByFirstStateId($id){
			$query = $this->db->get_where('cities',array('region_id' => $id));
			if($query->num_rows() > 0){
				return $query->result();
			}
		}

		public function getFirstStateByCountryId($id){
			// $query = $this->db->get_where('cities',array('country_id' => $id) ,1);
			$query_str = "SELECT * FROM regions WHERE country_id= $id LIMIT 1";
			$query = $this->db->query($query_str);
			if($query->num_rows() == 1){
				return $query->result();
			}
		}

		public function getCitiesByStateId($state_id){
			$query = $this->db->get_where('cities',array('region_id' => $state_id));
			if($query->num_rows() > 0){
				return $query->result();
			}
		}




		//Create Health Facility Account
		public function createUser($user_array){
			$query = $this->db->insert('users',$user_array);
			if($query){
				return true;
			}
			else{
				return false;
			}
		}

		public function updateUserTable($user_array,$id){
			$query = $this->db->update('users',$user_array,array('id' => $id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function transferFundsToUser($user_id,$recepient_id,$amount,$date,$time){
			
			$sender_full_name = $this->getUserParamById("full_name",$user_id);
			$sender_slug = $this->getUserParamById("slug",$user_id);
			if($this->debitUser($user_id,$amount)){
				if($this->creditUser($recepient_id,$amount)){
				
					$title = "Transfer Credit Alert";
	        		$message = "This Is To Alert You That " . number_format($amount,2) . " Was Transferred To You By <a target='_blank' href='".site_url('Sabicapital/'.$sender_slug)."'>".$sender_full_name."</a>";
	        		

					$form_array = array(
						'sender' => "System",
						'receiver' => $recepient_id,
						'title' => $title,
						'message' => $message,
						'date_sent' => $date,
						'time_sent' => $time,
						'type' => 'misc'
					);

					if($this->sendMessage($form_array)){
						$form_array = array(
							'sender' => $user_id,
							'recepient' => $recepient_id,
							'amount' => $amount,
							'date' => $date,
							'time' => $time
						);
						return $this->db->insert("transfer_funds_history",$form_array);
					}
				}
			}
		}

		public function checkIfUserIdIsValid($recepient_id){
			$query = $this->db->get_where("users",array('id' => $recepient_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getAllusers(){
			$query = $this->db->get("users");
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfUserNameExists($user_name){
			$query = $this->db->get_where("users",array('user_name' => $user_name));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		

		public function getUserTotalAmountByUse($user_id){
			$query = $this->db->get_where("users",array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$total_income = $row->total_income;
					$withdrawn = $row->withdrawn;
				}
				return $total_income - $withdrawn;
			}else{
				return false;
			}
		}

		public function updateUserLastActivity($user_id){
			$query_str = "UPDATE users SET last_activity = NOW() WHERE id=".$user_id;
			if($this->db->query($query_str)){
				return true;
			}else{
				return false;
			}
		}

		public function create_health_facility_account_table($health_facility_table_array,$table_name){
			$query_str = 'CREATE TABLE ' .$table_name.' (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				facility_name VARCHAR(100) NOT NULL,
				user_name VARCHAR(40) NOT NULL,
				user_id INT NOT NULL,
				hashed VARCHAR(50) NOT NULL,
				dept VARCHAR(100) NOT NULL,
				sub_dept VARCHAR(100) NOT NULL,
				personnel VARCHAR(100) NOT NULL,
				position VARCHAR(50) NOT NULL,
				is_admin INT NOT NULL,
				date VARCHAR(20) NOT NULL,
				time VARCHAR(20) NOT NULL
			)';
			if($this->db->query($query_str)){
				$query = $this->db->insert($table_name,$health_facility_table_array);
				if($query == true){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		public function create_health_facility_test_table($table_name){
			$query_str = 'CREATE TABLE ' .$table_name.' (
				id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				main_test_id INT NOT NULL,
				facility_name VARCHAR(100) NOT NULL,
				test_id VARCHAR(1000) NOT NULL,
				name TEXT NOT NULL,
				sample_required TEXT NOT NULL,
				indication TEXT NOT NULL,
				cost BIGINT NOT NULL,
				t_a BIGINT NOT NULL,
				pppc TEXT NOT NULL,
				section VARCHAR(50) NOT NULL,
				active INT DEFAULT 1,
				no INT DEFAULT 1 NOT NULL,
				tests TEXT NULL,
				unit VARCHAR(100) NOT NULL,
				range_lower INT NOT NULL,
				range_higher INT NOT NULL,
				range_enabled INT DEFAULT 1 NOT NULL,
				unit_enabled INT DEFAULT 1 NOT NULL,
				control_enabled INT DEFAULT 1 NOT NULL			
			)';
			if($this->db->query($query_str)){
				return true;
			}else{
				return false;
			}
		}

		public function getDefaultTests(){
			$query = $this->db->get('tests');
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUserAffiliatedFacilities($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$affiliated_facilities = $row->affiliated_facilities;
				}
				return $affiliated_facilities;
			}else{
				return false;
			}
		}

		public function add_tests($test_table_name,$form_array){
			$query = $this->db->insert($test_table_name,$form_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function create_health_facility_account($health_facility_array){
			$query = $this->db->insert('health_facility',$health_facility_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getUserRow($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name));
			if($query->num_rows() == 1){
				return $query->result();
			}
		}

		public function getHealthFacilityRow($name){
			$query = $this->db->get_where('health_facility',array('name' => $name));
			if($query->num_rows() == 1){
				return $query->result();
			}
		}

		public function onRegister($user_id,$token){
			$user_id = strtolower($user_id);
			$token = strtolower($token);
			$cookie = $user_id . ':' .$token;
			$mac = $this->encryption->encrypt($cookie);
			$cookie .= ':' .$mac;
			if(setcookie('allenexpressrem',$cookie,time() + 31536000,'/')) {
				return true;
			}
		}

		public function getUserInfoByTableName($table_name,$user_id){
			$query = $this->db->get_where($table_name,array('user_id' => $user_id),1);
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUserInfoByUserTableName($health_facility_table_name,$user_name){
			$query = $this->db->get_where($health_facility_table_name,array('user_name' => $user_name),1);
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}



		public function getUserInfoByUserName($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUserInfoByUserId($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUserInfoBySlug($slug){
			$query = $this->db->get_where('users',array('slug' => $slug));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUserInfoById($slug){
			$query = $this->db->get_where('users',array('id' => $slug));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getIfUserIdIsValid($partner_id){
			$query = $this->db->get_where('users',array('id' => $partner_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getIfPostIdIsValid($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getIfPostIdIsValidHealth($post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getFirstChatMessages($user_id,$partner_id){
			$this->db->select("*");
			$this->db->from("messages");
			$this->db->where('sender',$user_id);
			$this->db->where('receiver',$partner_id);
			$this->db->or_where('sender',$partner_id);
			$this->db->where('receiver',$user_id);
			$this->db->limit(10);
			$this->db->order_by('id','DESC');
			

			$query = $this->db->get();
			if($query->num_rows() > 0){
				// echo $this->db->last_query();
				return $query->result();
			}else{
				return false;
			}
		}

		public function getSubsequentChatMessages($user_id,$partner_id,$offset){
			$this->db->select("*");
			$this->db->from("messages");
			$this->db->where('sender',$partner_id);
			$this->db->where('receiver',$user_id);
			$this->db->where('received',0);
			$this->db->where('id >',$offset);
			// $this->db->limit(10);
			$this->db->order_by('id','DESC');
			

			$query = $this->db->get();
			if($query->num_rows() > 0){
				// echo $this->db->last_query();
				return $query->result();
			}else{
				// echo $this->db->last_query();
				return false;
			}
		}

		public function getSubsequentChatOlderMessages($user_id,$partner_id,$offset){
			$this->db->select("*");
			$this->db->from("messages");

			$this->db->where('sender',$user_id);
			$this->db->where('receiver',$partner_id);
			$this->db->where('id <',$offset);
			$this->db->or_where('sender',$partner_id);
			$this->db->where('receiver',$user_id);
			$this->db->where('id <',$offset);
			
			$this->db->limit(10);
			$this->db->order_by('id','DESC');
			

			$query = $this->db->get();
			if($query->num_rows() > 0){
				// echo $this->db->last_query();
				return $query->result();
			}else{
				// echo $this->db->last_query();
				return false;
			}
		}

		public function getUserOnlineStatus($partner_id){
			// echo $partner_id;
			$query_str = "SELECT * FROM users WHERE id = ".$partner_id." AND last_activity < SUBTIME(NOW(),'0:0:06')";
			$query = $this->db->query($query_str);
			if($query->num_rows() == 1){
				// echo $this->db->last_query();
				return false;
			}else{
				return true;
			}
		}

		

		public function updatePostLikes($likes_arr,$post_id){
			if(is_array($likes_arr)){
				$likes = implode(",", $likes_arr);
				if($this->db->update('posts',array('likes' => $likes),array('id' => $post_id))){
					return true;
				}else{
					return false;
				}
			}
		}

		public function updatePostLikesHealth($likes_arr,$post_id){
			if(is_array($likes_arr)){
				$likes = implode(",", $likes_arr);
				if($this->db->update('health_posts',array('likes' => $likes),array('id' => $post_id))){
					return true;
				}else{
					return false;
				}
			}
		}

		public function getUserEmailById($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$email = $row->email;
				}
				return $email;
			}else{
				return false;
			}
		}

		public function saveSetting($key,$value){
			//Check If Row Exists In Database
			$user_id = $this->getUserIdWhenLoggedIn();

			if($value == "true"){
				$value = 1;
			}else{
				$value = 0;
			}
			
			$query = $this->db->update('users',array($key => $value),array('id' => $user_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		

		public function getNoOfCommentsInPost($post_id){
			$query = $this->db->get_where('comments',array('post_id' => $post_id));
			if($query->num_rows() > 0){
				return $query->num_rows();
			}else{
				return false;
			}
		}

		public function getNoOfCommentsInPostHealth($post_id){
			$query = $this->db->get_where('health_comments',array('post_id' => $post_id));
			if($query->num_rows() > 0){
				return $query->num_rows();
			}else{
				return false;
			}
		}


		public function checkIfCommentIdIsValid($comment_id){
			$query = $this->db->get_where('comments',array('id' => $comment_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfCommentIdIsValidHealth($comment_id){
			$query = $this->db->get_where('health_comments',array('id' => $comment_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfPostIdIsValid($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfPostIdIsValidHealth($post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}
		
		public function getPostIdByCommentId($comment_id){
			$query = $this->db->get_where('comments',array('id' => $comment_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$post_id = $row->post_id;
				}
				return $post_id;
			}else{
				return false;
			}
		}

		public function getPostIdByCommentIdHealth($comment_id){
			$query = $this->db->get_where('health_comments',array('id' => $comment_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$post_id = $row->post_id;
				}
				return $post_id;
			}else{
				return false;
			}
		}


		public function checkIfImageIsPartOfPost($post_id,$image_name){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images !== ""){
					$images_arr = explode(",", $images);
					if(in_array($image_name,$images_arr)){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}

		public function checkIfImageIsPartOfPostHealth($post_id,$image_name){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images !== ""){
					$images_arr = explode(",", $images);
					if(in_array($image_name,$images_arr)){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}


		public function getPostSenderUserName($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sender_id = $row->sender;
				}
				$sender_username = $this->getUserNameById($sender_id);
				return $sender_username;
			}else{
				return false;
			}
		}

		public function deletePostImage($post_id,$image_name){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images !== ""){
					$images_arr = explode(",", $images);
					if(in_array($image_name,$images_arr)){
						$index = array_search($image_name, $images_arr);
						unset($images_arr[$index]);
						$images = implode(",", $images_arr);
						$query = $this->db->update('posts',array('images' => $images),array('id' => $post_id));
						if($query){
							unlink('./assets/images/'.$image_name);
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}

		public function deletePostImageHealth($post_id,$image_name){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images !== ""){
					$images_arr = explode(",", $images);
					if(in_array($image_name,$images_arr)){
						$index = array_search($image_name, $images_arr);
						unset($images_arr[$index]);
						$images = implode(",", $images_arr);
						$query = $this->db->update('health_posts',array('images' => $images),array('id' => $post_id));
						if($query){
							unlink('./assets/images/'.$image_name);
							return true;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}

		public function deletePost($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images !== ""){
					$images_arr = explode(",", $images);
					for($i = 0; $i < count($images_arr); $i++){
						$image_name = $images_arr[$i];
						unlink('./assets/images/'.$image_name);
					}
				}	
				$query = $this->db->delete('posts',array('id' => $post_id));
				if($query){
					return true;
				}else{
					return false;
				}		
				
			}else{
				return false;
			}	
		}


		public function deletePostHealth($post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images !== ""){
					$images_arr = explode(",", $images);
					for($i = 0; $i < count($images_arr); $i++){
						$image_name = $images_arr[$i];
						unlink('./assets/images/'.$image_name);
					}
				}	
				$query = $this->db->delete('health_posts',array('id' => $post_id));
				if($query){
					return true;
				}else{
					return false;
				}		
				
			}else{
				return false;
			}	
		}

		public function deleteCommentsUnderPost($post_id){
			$query = $this->db->delete('comments',array('post_id' => $post_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function deleteCommentsUnderPostHealth($post_id){
			$query = $this->db->delete('health_comments',array('post_id' => $post_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function updatePostContent($post_id,$content){
			$query = $this->db->update('posts',array('content' => $content),array('id' => $post_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function updatePostContentHealth($post_id,$content){
			$query = $this->db->update('health_posts',array('content' => $content),array('id' => $post_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getIfUserOwnsThisPost($post_id,$user_id){
			$query = $this->db->get_where('posts',array('id' => $post_id,'sender' => $user_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getIfUserOwnsThisPostHealth($post_id,$user_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id,'sender' => $user_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getIfThereIsStillSpaceForPostUpload($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images !== ""){
					$images_arr = explode(",", $images);
					if(count($images_arr) < 5){
						return true;
					}else{
						return false;
					}
				}else{
					return true;
				}
			}else{
				return false;
			}	
		}

		public function getIfThereIsStillSpaceForPostUploadHealth($post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images !== ""){
					$images_arr = explode(",", $images);
					if(count($images_arr) < 5){
						return true;
					}else{
						return false;
					}
				}else{
					return true;
				}
			}else{
				return false;
			}	
		}

		public function getPostById($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPostByIdHealth($post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPostSender($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sender = $row->sender;
					$sender_username = $this->getUserNameById($sender);
				}
				return $sender_username;
			}else{
				return false;
			}
		}

		public function getPostSenderHealth($post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sender = $row->sender;
					$sender_username = $this->getUserNameById($sender);
				}
				return $sender_username;
			}else{
				return false;
			}
		}

		public function getPostSenderId($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sender = $row->sender;
				}
				return $sender;
			}else{
				return false;
			}
		}

		public function getPostTitleById($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sender = $row->sender;
					$sender_username = $this->getUserNameById($sender);
					$sender_name = $this->getUserFullNameById($sender);
					$content = $row->content;
				}
				$title = $sender_name." on Meet Global Resources: " .$content;
				return $title;
			}else{
				return false;
			}
		}

		public function getPostTitleByIdHealth($post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sender = $row->sender;
					$sender_username = $this->getUserNameById($sender);
					$sender_name = $this->getUserFullNameById($sender);
					$content = $row->content;
				}
				$title = $sender_name." on Meet Global Resources: " .$content;
				return $title;
			}else{
				return false;
			}
		}

		public function checkIfCommentsBatchIsLast($post_id,$offset){
			$this->db->select("*");
			$this->db->from("comments");

			$this->db->where('post_id',$post_id);
			
			$this->db->where('id <',$offset);
			
			$this->db->limit(10);
			$this->db->order_by('id','DESC');
			

			$query = $this->db->get();
			if($query->num_rows() == 10){
				// echo $this->db->last_query();
				return false;
			}else{
				// echo $this->db->last_query();
				return true;
			}
		}

		public function checkIfCommentsBatchIsLastHealth($post_id,$offset){
			$this->db->select("*");
			$this->db->from("health_comments");

			$this->db->where('post_id',$post_id);
			
			$this->db->where('id <',$offset);
			
			$this->db->limit(10);
			$this->db->order_by('id','DESC');
			

			$query = $this->db->get();
			if($query->num_rows() == 10){
				// echo $this->db->last_query();
				return false;
			}else{
				// echo $this->db->last_query();
				return true;
			}
		}



		public function getSubsequentCommentsOnPost($post_id,$offset){
			$this->db->select("*");
			$this->db->from("comments");

			$this->db->where('post_id',$post_id);
			
			$this->db->where('id <',$offset);
			
			$this->db->limit(10);
			$this->db->order_by('id','DESC');
			

			$query = $this->db->get();
			if($query->num_rows() > 0){
				// echo $this->db->last_query();
				return $query->result();
			}else{
				// echo $this->db->last_query();
				return false;
			}
		}


		public function getSubsequentCommentsOnPostHealth($post_id,$offset){
			$this->db->select("*");
			$this->db->from("health_comments");

			$this->db->where('post_id',$post_id);
			
			$this->db->where('id <',$offset);
			
			$this->db->limit(10);
			$this->db->order_by('id','DESC');
			

			$query = $this->db->get();
			if($query->num_rows() > 0){
				// echo $this->db->last_query();
				return $query->result();
			}else{
				// echo $this->db->last_query();
				return false;
			}
		}

		public function getSubsequentPostsUserProfile($user_id,$offset){
			$this->db->select("*");
			$this->db->from("posts");
			$this->db->where('sender',$user_id);
			$this->db->where('id <',$offset);
			
			$this->db->limit(2);
			$this->db->order_by('id','DESC');
			

			$query = $this->db->get();
			if($query->num_rows() > 0){
				// echo $this->db->last_query();
				return $query->result();
			}else{
				// echo $this->db->last_query();
				return false;
			}
		}

		public function getUserLogoById($sender){
			$query = $this->db->get_where('users',array('id' => $sender));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$logo = $row->logo;
				}
				if(is_null($logo)){
					$logo = base_url('assets/images/avatar.jpg');
				}else{
					$logo = base_url('assets/images/'.$logo);
				}
				return $logo;
			}else{
				return false;
			}
		}

		public function get_user_posts($user_id){
			$query = $this->db->get_where('posts',array('sender' => $user_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return "";
			}
		}

		public function getMainUserPostById($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getMainUserPostByIdHealth($post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function updateCommentLikes($likes_arr,$comment_id){
			if(is_array($likes_arr)){
				$likes = implode(",", $likes_arr);
				if($this->db->update('comments',array('likes' => $likes),array('id' => $comment_id))){
					return true;
				}else{
					return false;
				}
			}
		}

		public function updateCommentLikesHealth($likes_arr,$comment_id){
			if(is_array($likes_arr)){
				$likes = implode(",", $likes_arr);
				if($this->db->update('health_comments',array('likes' => $likes),array('id' => $comment_id))){
					return true;
				}else{
					return false;
				}
			}
		}


		public function getOnlineUsersNum($followers_arr){
			$j = 0;
			for($i = 0; $i < count($followers_arr); $i++){
				$user_id = $followers_arr[$i];
				if($this->getUserOnlineStatus($user_id)){
					$j++;
				}
			}
			return $j;
		}

		public function getOnlineUsers($followers_arr){
			$new_arr = array();
			for($i = 0; $i < count($followers_arr); $i++){
				$user_id = $followers_arr[$i];
				if($this->getUserOnlineStatus($user_id)){
					$new_arr[] .= $user_id;
				}
			}
			return $new_arr;
		}

		public function getUserTotalFollowingOnlineNum($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->following;
				}
				if($followers !== ""){
					$followers_arr = explode(",",$followers);
					$followers_arr = array_unique($followers_arr);
					$following = implode(",", $followers_arr);					
					if($this->db->update('users',array('following' => $following),array('id' => $user_id))){
						
					}else{
						return false;
					}
					if(!empty($followers_arr)){
						$foller_num = $this->getOnlineUsersNum($followers_arr);
					}else{
						$foller_num = 0;
					}
				}else{
					$foller_num = 0;
				}
				return $foller_num;
			}else{
				return false;
			}
		}

		public function getUserTotalOnlineFollowing($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->following;
				}
				if($followers !== ""){
					$followers_arr = explode(",",$followers);
					$followers_arr = array_unique($followers_arr);
					$following = implode(",", $followers_arr);					
					if($this->db->update('users',array('following' => $following),array('id' => $user_id))){
						
					}else{
						return false;
					}
					if(!empty($followers_arr)){
						$foller_num = count($followers_arr);
						$followers_arr = $this->getOnlineUsers($followers_arr);
						return $followers_arr;
					}else{
						$foller_num = 0;
					}
				}else{
					$foller_num = 0;
				}
				return $foller_num;
			}else{
				return false;
			}
		}

		public function getUserTotalPostsNum($user_id){
			$query = $this->db->get_where('posts',array('sender' => $user_id));
			return $query->num_rows();
		}

		public function getUserTotalFollowersNum($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->followers;
				}
				if($followers !== ""){
					$followers_arr = explode(",",$followers);
					$followers_arr = array_unique($followers_arr);
					$followers = implode(",", $followers_arr);
					if($this->db->update('users',array('followers' => $followers),array('id' => $user_id))){

					}else{
						return false;
					}
					// print_r($followers_arr);
					if(!empty($followers_arr)){
						$foller_num = count($followers_arr);
					}else{
						$foller_num = 0;
					}
				}else{
					$foller_num = 0;
				}
				return $foller_num;
			}else{
				return false;
			}
		}

		public function getUserTotalFollowers($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->followers;
				}
				if($followers !== ""){
					$followers_arr = explode(",",$followers);
					$followers_arr = array_unique($followers_arr);
					$followers = implode(",", $followers_arr);
					if($this->db->update('users',array('followers' => $followers),array('id' => $user_id))){

					}else{
						return false;
					}
					// print_r($followers_arr);
					if(!empty($followers_arr)){
						$foller_num = count($followers_arr);
						return $followers_arr;
					}else{
						$foller_num = 0;
					}
				}else{
					$foller_num = 0;
				}
				return false;
			}else{
				return false;
			}
		}

		public function getUserTotalFollowersUserName($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->followers;
				}
				if($followers !== ""){
					$followers_arr = explode(",",$followers);
					$followers_arr = array_unique($followers_arr);
					$followers = implode(",", $followers_arr);
					if($this->db->update('users',array('followers' => $followers),array('id' => $user_id))){

					}else{
						return false;
					}
					// print_r($followers_arr);
					if(!empty($followers_arr)){
						$foller_num = count($followers_arr);
						$followers_arr_names = array();
						for($i = 0; $i < $foller_num; $i++){
							$followers_arr[$i] = $this->getUserNameById($followers_arr[$i]);
							$followers_arr_names[] = $followers_arr[$i];
						}
						return $followers_arr_names;
					}else{
						$foller_num = 0;
					}
				}else{
					$foller_num = 0;
				}
				return array();
			}else{
				return array();
			}
		}


		public function convertToWebp($file,$ext,$file_no_ext){
			// $file='hnbrnocz.jpg';
			if($ext == "jpg" || $ext == "jpeg"){
				$image=  imagecreatefromjpeg($file);
				
				
			}elseif($ext == "gif"){
				$image=  imagecreatefromgif($file);
				
				
			}elseif($ext == "png"){
				$image=  imagecreatefrompng($file);
				
				
			}
			
			
			imagewebp($image,$file_no_ext.'.webp',100);
			

		}

		public function getAllPostsByUser($user_id){
			$this->db->select("*");
			$this->db->from("posts");
			$this->db->where("sender",$user_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getFirstTenPostsByUser($user_id){
			$this->db->select("*");
			$this->db->from("posts");
			$this->db->where("sender",$user_id);
			$this->db->limit(2);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getFirstTenPostsByUserHealth($user_id){
			$this->db->select("*");
			$this->db->from("health_posts");
			$this->db->where("sender",$user_id);
			$this->db->limit(2);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getFirstTenPostsByUserFront($user_id){
			$ret_arr = array();
            $followers_arr = $this->getUserTotalFollowing($user_id);
            if(is_array($followers_arr)){
	            for($i = 0; $i < count($followers_arr); $i++){
	                $following_id = $followers_arr[$i];
					$this->db->select("*");
					$this->db->from("posts");
					$this->db->where("sender",$following_id);
					// $this->db->limit();
					$this->db->order_by("id","DESC");
					$query = $this->db->get();
					if($query->num_rows() > 0){
						$ret_arr = array_merge($ret_arr,$query->result());
						
					}else{
						
					}
				}
				sort($ret_arr);
				$ret_arr = array_reverse($ret_arr);
				$ret_arr = array_slice($ret_arr,0, 2);
				return $ret_arr;
			}else{
				return "no followers";
			}
		}

		public function getFirstTenPostsByUserFrontHealth($user_id){
			$ret_arr = array();
            
			$this->db->select("*");
			$this->db->from("health_posts");
			
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$ret_arr = array_merge($ret_arr,$query->result());
				
			}else{
				
			}
			
			sort($ret_arr);
			$ret_arr = array_reverse($ret_arr);
			$ret_arr = array_slice($ret_arr,0, 2);
			return $ret_arr;
		}


		public function getPostLikesUserInfo($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$user_id = $row->id;
					if($this->getUserIdWhenLoggedIn() == $user_id){
						$row->user_name = "you";
					}
				}
				return $query->result();
			}
		}

		public function getUserFrontPagePostsAndComments($user_id){
			$ret_arr = array();
            $followers_arr = $this->getUserTotalFollowing($user_id);
            if(is_array($followers_arr)){
	            for($i = 0; $i < count($followers_arr); $i++){
	                $following_id = $followers_arr[$i];
					$this->db->select("*");
					$this->db->from("posts");
					$this->db->where("sender",$following_id);
					// $this->db->limit();
					$this->db->order_by("id","DESC");
					$query = $this->db->get();
					if($query->num_rows() > 0){
						foreach($query->result() as $row){
							$sender = $row->sender;
							$row->sender_logo = $this->getUserLogoById($sender);
							$user_name = $this->getUserNameById($sender);
							$row->sender = $user_name;
							$likes = $row->likes;
							if($likes != ""){
								$likes_arr = explode(",", $likes);
								if(in_array($user_id, $likes_arr)){
									$is_liked = true;
								}else{
									$is_liked = false;
								}
								$row->likes_num = count($likes_arr);
								
							}else{
								$row->likes_num = 0;
								$is_liked = false;
							}

							$row->is_liked = $is_liked;

							$images = $row->images;
							if($images != ""){
								$images_arr = explode(",",$images);
								$row->images = $images_arr;
							}else{
								$row->images = null;
							}
							$row->post_date = $this->getSocialMediaTime($row->date,$row->time);
							$id = $row->id;

							$first_comments = $this->getFirstFiveCommentsOnPost($id);
							if(!$first_comments){
								$row->comments = null;
							}else{
								$row->comments = $first_comments;
								foreach($row->comments as $row){
									$date = $row->date;
									$time = $row->time;
									$comment_date = $this->getSocialMediaTime($date,$time);
									$row->comment_date = $comment_date;
									unset($row->likes);
									$id = $row->id;
									unset($row->id);
									$row->comment_id = $id;
									$sender = $this->getUserNameById($row->sender);
									unset($row->sender);
									$row->comment_sender = $sender;
									$content = $row->content;
									unset($row->content);
									$row->comment_content = $content;
									// $comment_date = $row->date;
									// unset($row->date);
									// $row->comment_date = $comment_date;
									$comment_time = $row->time;
									unset($row->time);
									$row->comment_time = $comment_time;
								}
							}
						}
						$ret_arr = array_merge($ret_arr,$query->result());
					}else{
						
					}
				}
				sort($ret_arr);
				$ret_arr = array_reverse($ret_arr);
				$ret_arr = array_slice($ret_arr,0, 5);
				return $ret_arr;
			}else{
				return "no followers";
			}
		}

		public function getUserFrontPageSubsequentPostsAndComments($user_id,$offset,$last_id){
			$ret_arr = array();
            $followers_arr = $this->getUserTotalFollowing($user_id);
            if(is_array($followers_arr)){
	            for($i = 0; $i < count($followers_arr); $i++){
	                $following_id = $followers_arr[$i];
					$this->db->select("*");
					$this->db->from("posts");
					$this->db->where("sender",$following_id);
					// $this->db->limit();
					$this->db->order_by("id","DESC");
					$query = $this->db->get();
					if($query->num_rows() > 0){
						$result = $query->result();
						$index = -1;
						foreach($result as $row){	
							$index++;
							if($row->id < $last_id){
								$sender = $row->sender;
								$row->sender_logo = $this->getUserLogoById($sender);
								$user_name = $this->getUserNameById($sender);
								$row->sender = $user_name;
								$likes = $row->likes;
								if($likes != ""){
									$likes_arr = explode(",", $likes);
									if(in_array($user_id, $likes_arr)){
										$is_liked = true;
									}else{
										$is_liked = false;
									}
									$row->likes_num = count($likes_arr);
									
								}else{
									$row->likes_num = 0;
									$is_liked = false;
								}

								$row->is_liked = $is_liked;

								$images = $row->images;
								if($images != ""){
									$images_arr = explode(",",$images);
									$row->images = $images_arr;
								}else{
									$row->images = null;
								}
								$row->post_date = $this->getSocialMediaTime($row->date,$row->time);
								$id = $row->id;

								$first_comments = $this->getFirstFiveCommentsOnPost($id);
								if(!$first_comments){
									$row->comments = null;
								}else{
									$row->comments = $first_comments;
									foreach($row->comments as $row){
										$date = $row->date;
										$time = $row->time;
										$comment_date = $this->getSocialMediaTime($date,$time);
										$row->comment_date = $comment_date;
										unset($row->likes);
										$id = $row->id;
										unset($row->id);
										$row->comment_id = $id;
										$sender = $this->getUserNameById($row->sender);
										unset($row->sender);
										$row->comment_sender = $sender;
										$content = $row->content;
										unset($row->content);
										$row->comment_content = $content;
										// $comment_date = $row->date;
										// unset($row->date);
										// $row->comment_date = $comment_date;
										$comment_time = $row->time;
										unset($row->time);
										$row->comment_time = $comment_time;
									}
								}
							}else{
								unset($result[$index]);
							}
						}
						$ret_arr = array_merge($ret_arr,$result);
					}else{
						
					}
				}
				sort($ret_arr);
				$ret_arr = array_reverse($ret_arr);
				$ret_arr = array_slice($ret_arr,0, 5);
				return $ret_arr;
			}else{
				return "no followers";
			}
		}

		public function getSubsequentPostsByUserFront($user_id,$offset,$last_id){
			$ret_arr = array();
            $followers_arr = $this->getUserTotalFollowing($user_id);
            if(is_array($followers_arr)){
	            for($i = 0; $i < count($followers_arr); $i++){
	                $following_id = $followers_arr[$i];
					$this->db->select("*");
					$this->db->from("posts");
					$this->db->where("sender",$following_id);
					// $this->db->limit();
					$this->db->order_by("id","DESC");
					$query = $this->db->get();
					if($query->num_rows() > 0){
						
						$result = $query->result();
						$index = -1;
						foreach($result as $row){	
							$index++;
							if($row->id < $last_id){

							}else{
								unset($result[$index]);
							}
						}	
						$ret_arr = array_merge($ret_arr,$result);	
					}else{
						
					}
				}
				sort($ret_arr);
				$ret_arr = array_reverse($ret_arr);
				$ret_arr = array_slice($ret_arr,0, 2);
				return $ret_arr;
			}else{
				return "no followers";
			}
		}

		public function getSubsequentPostsByUserFrontHealth($user_id,$offset,$last_id){
			$ret_arr = array();
            
			$this->db->select("*");
			$this->db->from("health_posts");
			// $this->db->limit();
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				
				$result = $query->result();
				// print_r($result);
				$index = -1;
				foreach($result as $row){
					$index++;
					if($row->id < $last_id){

					}else{
						unset($result[$index]);
					}
				}	
				$ret_arr = array_merge($ret_arr,$result);	
			}else{
				
			}
				
			sort($ret_arr);
			$ret_arr = array_reverse($ret_arr);
			$ret_arr = array_slice($ret_arr,0, 2);
			return $ret_arr;
		}


		public function getAllUsersLikeString(){
			$ret_arr = array();
			$query = $this->db->get('users');
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] = $id;
				}
				return implode(",", $ret_arr);
			}
		}


		public function updateAllPostsLikes($users){
			$query = $this->db->update('posts',array('likes' => $users));
			if($query){
				return true;
			}else{
				return false;
			}
		}


		public function getFirstFiveCommentsOnPost($post_id){
			// $query = $this->db->get_where('comments',array('post_id' => $post_id),5);
			$this->db->select("*");
			$this->db->from("comments");
			$this->db->where("post_id",$post_id);
			$this->db->limit(5);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getFirstFiveCommentsOnPostHealth($post_id){
			// $query = $this->db->get_where('comments',array('post_id' => $post_id),5);
			$this->db->select("*");
			$this->db->from("health_comments");
			$this->db->where("post_id",$post_id);
			$this->db->limit(5);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function updatePostImages($file_name,$post_id,$user_id){
			$query = $this->db->get_where('posts',array('id' => $post_id,'sender' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images == ""){
					$new_images = $file_name;
				}else{
					$images_arr = explode(",",$images);
					$new_images = $images . "," . $file_name;
				}
				if($this->db->update('posts',array('images' => $new_images),array('id' => $post_id))){
					return true;
				}else{
					return false;
				}

			}
		}

		public function updatePostImagesHealth($file_name,$post_id,$user_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id,'sender' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				if($images == ""){
					$new_images = $file_name;
				}else{
					$images_arr = explode(",",$images);
					$new_images = $images . "," . $file_name;
				}
				if($this->db->update('health_posts',array('images' => $new_images),array('id' => $post_id))){
					return true;
				}else{
					return false;
				}

			}
		}

		public function getUserTotalFollowingNum($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->following;
				}
				if($followers !== ""){
					$followers_arr = explode(",",$followers);
					$followers_arr = array_unique($followers_arr);
					$following = implode(",", $followers_arr);					
					if($this->db->update('users',array('following' => $following),array('id' => $user_id))){
						
					}else{
						return false;
					}
					if(!empty($followers_arr)){
						$foller_num = count($followers_arr);
					}else{
						$foller_num = 0;
					}
				}else{
					$foller_num = 0;
				}
				return $foller_num;
			}else{
				return false;
			}
		}

		public function getUserTotalFollowing($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->following;
				}
				if($followers !== ""){
					$followers_arr = explode(",",$followers);
					$followers_arr = array_unique($followers_arr);
					$following = implode(",", $followers_arr);					
					if($this->db->update('users',array('following' => $following),array('id' => $user_id))){
						
					}else{
						return false;
					}
					if(!empty($followers_arr)){
						$foller_num = count($followers_arr);
						return $followers_arr;
					}else{
						$foller_num = 0;
					}
				}else{
					$foller_num = 0;
				}
				return $foller_num;
			}else{
				return false;
			}
		}

		public function getUserTotalFollowingUserName($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->following;
				}
				if($followers !== ""){
					$followers_arr = explode(",",$followers);
					$followers_arr = array_unique($followers_arr);
					$following = implode(",", $followers_arr);					
					if($this->db->update('users',array('following' => $following),array('id' => $user_id))){
						
					}else{
						return false;
					}
					if(!empty($followers_arr)){
						$foller_num = count($followers_arr);
						$followers_arr_names = array();
						for($i = 0; $i < $foller_num; $i++){
							$followers_arr[$i] = $this->getUserNameById($followers_arr[$i]);
							$followers_arr_names[] = $followers_arr[$i];
						}
						return $followers_arr_names;
					}else{
						$foller_num = 0;
					}
				}else{
					$foller_num = 0;
				}
				return $foller_num;
			}else{
				return false;
			}
		}

		public function checkIfUserIsAlreadyFollowedByUser($user_id,$partner_id){
			$query = $this->db->get_where('users',array('id' => $partner_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->followers;
				}
				$followers_arr = explode(",", $followers);
				if(in_array($user_id, $followers_arr)){
					return false;
				}else{
					return true;
				}
			}	
		}

		

		public function checkIfUserHasAlreadyLikedPost($user_id,$post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$likes = $row->likes;
				}
				$likes_arr = explode(",", $likes);
				if(in_array($user_id, $likes_arr)){
					return false;
				}else{
					return true;
				}
			}	
		}


		public function checkIfUserHasAlreadyLikedPostHealth($user_id,$post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$likes = $row->likes;
				}
				$likes_arr = explode(",", $likes);
				if(in_array($user_id, $likes_arr)){
					return false;
				}else{
					return true;
				}
			}	
		}


		public function checkIfUserIsFollowingUser($user_id,$partner_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$following = $row->following;
				}
				$following_arr = explode(",", $following);
				// print_r($following_arr);
				if(in_array($partner_id, $following_arr)){
					return false;
				}else{
					return true;
				}
			}	
		}

		public  function checkIfThisIsAdmin($id){
			$query = $this->db->get_where('users',array('id' => $id,'is_admin' => 1));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}


		public function unlikePost($user_id,$post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$likes = $row->likes;
				}
				if($likes == ""){
					return false;
				}else{
					$likes_arr = explode(",", $likes);
					if(in_array($user_id, $likes_arr)){
						$index = array_search($user_id, $likes_arr);
						unset($likes_arr[$index]);
						// print_r($followers_arr)
						if(empty($likes_arr)){
							$likes = "";
						}else{
							$likes = implode(",", $likes_arr);
						}
					}
				}
				
				if($this->db->update('posts',array('likes' => $likes),array('id' => $post_id))){
					return true;
				}else{
					return false;
				}
					
			}else{
				return false;
			}
		}

		public function unlikePostHealth($user_id,$post_id){
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$likes = $row->likes;
				}
				if($likes == ""){
					return false;
				}else{
					$likes_arr = explode(",", $likes);
					if(in_array($user_id, $likes_arr)){
						$index = array_search($user_id, $likes_arr);
						unset($likes_arr[$index]);
						// print_r($followers_arr)
						if(empty($likes_arr)){
							$likes = "";
						}else{
							$likes = implode(",", $likes_arr);
						}
					}
				}
				
				if($this->db->update('health_posts',array('likes' => $likes),array('id' => $post_id))){
					return true;
				}else{
					return false;
				}
					
			}else{
				return false;
			}
		}
		public function sendChatMessage($form_array,$partner_id){
			$user_id = $this->getUserIdWhenLoggedIn();
			$user_name = $this->getUserNameById($user_id);
			if($this->db->insert('messages',$form_array)){
				if(!$this->getUserOnlineStatus($partner_id)){
					$partner_email = $this->getUserEmailById($partner_id);
					$partner_array = array();
					$partner_array[] = $partner_email;
					$subject = $user_name . " Just Sent You A Message";
					$message = $user_name . " Just Sent You A Message. <a href='" . site_url('Sabicapital/index/'.$user_id.'/messaging') . "'>View Message</a>";
					if($this->sendEmail($partner_array,$subject,$message)){

					}
				}
				return $this->db->insert_id();
			}else{
				return false;
			}
		}

		public function socialMediaFormatNum($num){
			if($num >= 1000 && $num < 1000000){
				$num = round($num / 1000,2);
				$num = $num . 'K';
			}elseif($num >= 1000000 && $num < 1000000000){
				$num = round($num / 1000000,2);
				$num = $num . 'M';
			}elseif($num >= 1000000000 && $num < 1000000000000){
				$num = round($num / 1000000000,2);
				$num = $num . 'B';
			}elseif($num >= 1000000000000){
				$num = round($num / 1000000000000,2);
				$num = $num . 'T';
			}
			return $num;
		}

		public function updateMessageAsRead($id){
			$query = $this->db->update('messages',array('received' => 1),array('id' => $id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getAllHealthFacilities(){
			$query = $this->db->get("health_facility");
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getFacilityStructures(){
			$query = $this->db->get("health_facility_structure");
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}	
		}



		public function checkIfUserIsAnAdmin($health_facility_table_name,$user_id){
			// echo $user_id;
			// echo $health_facility_table_name;
			// echo $user_id;
			$query = $this->db->get_where($health_facility_table_name,array('user_id' => $user_id,'is_admin' => 1));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}



		public function getUserInfoHealthFacilityById($affiliated_facility_table,$user_id){
			if($this->db->table_exists($affiliated_facility_table)){
				$query = $this->db->get_where($affiliated_facility_table,array('user_id' => $user_id));
				if($query->num_rows() == 1){
					return $query->result();
				}else{
					return false;
				}
			}else{
				$query = $this->db->get_where('users',array('id' => $user_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$affiliated_facilities = $row->affiliated_facilities;
						$affiliated_facilities_arr = explode(",", $affiliated_facilities);
						$index = array_search($affiliated_facility_table,$affiliated_facilities_arr);
						unset($affiliated_facilities_arr[$index]);
						$affiliated_facilities = implode(",", $affiliated_facilities_arr);
						$user_array = array(
							'affiliated_facilities' => $affiliated_facilities
						);
						$this->updateUserTable($user_array,$user_id);
					}
				}else{
					return false;
				}
			}
		}

		public function checkIfBankDetailsAreSet($health_facility_name,$health_facility_id){
			$query = $this->db->get_where('health_facility',array('id' => $health_facility_id,'name' => $health_facility_name,'bank_name' => 0,'account_number' => NULL));
			// print_r($query->result());
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsAPatient($health_facility_table_name,$user_id){
			$query = $this->db->get_where($health_facility_table_name,array('user_id' => $user_id,'position' => 'patient'));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function confirmHealthFacilityIdAndSlug($health_facility_id,$health_facility_slug){
			// echo $health_facility_id . ' ' .$health_facility_slug;
			$query = $this->db->get_where('health_facility',array('id' => $health_facility_id,'slug' => $health_facility_slug));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsAnAdminBool($health_facility_table_name,$user_name){
			$query = $this->db->get_where($health_facility_table_name,array('user_name' => $user_name,'is_admin' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsAnAdminOrSubAdminBool($health_facility_table_name,$user_name){
			$this->db->select("*");
			$this->db->from($health_facility_table_name);
			$this->db->where('user_name = "'.$user_name.'" AND position = "admin" OR position = "sub_admin"');
			$query = $this->db->get();
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		// public function isJson($string) {
		//  json_decode($string);
		//  return (json_last_error() == JSON_ERROR_NONE);
		// }

		public function getCountryIdByCountryCode($country_code){
			$query = $this->db->get_where('countries',array('code' => $country_code));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$country_id = $row->id;
				}
				return $country_id;
			}else{
				return 0;
			}
		}

		public function getUserHashedById($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$hashed = $row->hashed;
				}
				return $hashed;
			}else{
				return "";
			}
		}


		public function checkIfUserIsMainAdminBool($health_facility_table_name,$user_name){
			$query = $this->db->get_where($health_facility_table_name,array('user_name' => $user_name,'is_admin' => 1,'position' => 'admin'));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getAllPaidTests($health_facility_table_name){
			// $query = $this->db->get_where($health_facility_table_name,array('paid' => 1));
			$this->db->select("*");
			$this->db->from($health_facility_table_name);
			$this->db->where('paid',1);
			$this->db->order_by('id','DESC');
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPdfTestsRows($health_facility_test_result_table,$lab_id){
			$query = $this->db->get_where($health_facility_test_result_table,array('lab_id' => $lab_id,'paid' => 1));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPaidPatients($health_facility_patient_db_table,$form_array){
			$query = $this->db->get_where($health_facility_patient_db_table,$form_array);
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getPatientsTests($health_facility_patient_db_table,$form_array){
			$query = $this->db->get_where($health_facility_patient_db_table,$form_array);
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getIfPatientResultIsVerified($health_facility_patient_db_table,$lab_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('lab_id' => $lab_id,'verified' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getDateOfVerification($health_facility_patient_db_table,$lab_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('lab_id' => $lab_id,'verified' => 1));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$date_of_verification = $row->date_of_verification;
				}
				if(is_null($date_of_verification)){
					return "";
				}
				return $date_of_verification;
			}else{
				return false;
			}
		}

		public function addPatientRecord($health_facility_table_name,$form_array){
			if($this->db->table_exists($health_facility_table_name)){
				$query = $this->db->insert($health_facility_table_name,$form_array);
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_table_name.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					
					initiation_code VARCHAR(50) NOT NULL,
					lab_id TEXT NOT NULL,
					patient_name VARCHAR(200) NOT NULL,
					firstname VARCHAR(50) NOT NULL,
					surname VARCHAR(50) NOT NULL,
					dob VARCHAR(50) NOT NULL,
					age INT NOT NULL,
					age_unit VARCHAR(50) NOT NULL,
					sex VARCHAR(50) NOT NULL,
					race VARCHAR(50) NOT NULL,
					mobile_no BIGINT NOT NULL,
					email VARCHAR(50) NOT NULL,
					height INT NOT NULL,
					weight INT NOT NULL,
					present_medications TEXT NOT NULL,
					fasting INT NOT NULL,
					sample VARCHAR(300) NOT NULL,
					sample_other VARCHAR(200) NOT NULL,
					date_of_request VARCHAR(50) NOT NULL,
					referring_dr VARCHAR(50) NOT NULL,
					consultant VARCHAR(70) NOT NULL,
					consultant_email VARCHAR(50) NOT NULL,
					consultant_mobile BIGINT NOT NULL,
					pathologist VARCHAR(100) NOT NULL,
					pathologist_email VARCHAR(60) NOT NULL,
					pathologist_mobile BIGINT NOT NULL,
					address TEXT NOT NULL,
					created INT NOT NULL,
					date_created VARCHAR(50) NOT NULL,
					time_created VARCHAR(50) NOT NULL,
					clinical_summary TEXT NOT NULL,
					lmp VARCHAR(50) NOT NULL,
					sampling_time VARCHAR(50) NOT NULL,
					separation_time VARCHAR(50) NOT NULL,
					observation TEXT NOT NULL,
					sampled INT DEFAULT 0 NOT NULL,
					controls TEXT NULL,
					result_entered INT DEFAULT 0 NOT NULL,
					verified INT DEFAULT 0 NOT NULL,
					verification_date VARCHAR(50) NULL,
					verification_time VARCHAR(50) NULL,
					date_of_verification VARCHAR(50) NULL,
					test_ready INT DEFAULT 0 NOT NULL,
					pathologists_comment TEXT NOT NULL,
					printed INT DEFAULT 0 NOT NULL,
					zipped INT DEFAULT 0 NOT NULL
				)';
				if($this->db->query($query_str)){
					$query = $this->db->insert($health_facility_table_name,$form_array);
					if($query){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				} 
			}
		}




		public function getPatientInfo($health_facility_patient_db_table){
			$query = $this->db->get_where($health_facility_patient_db_table,array('created' => 1));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getIfPathologistCommentIsAdded($health_facility_patient_db_table,$lab_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('lab_id' => $lab_id,'pathologists_comment' => ''));
			if($query->num_rows() == 1){
				return false;
			}else{
				return true;
			}
		}

		public function getIfResultIsZipped($health_facility_patient_db_table,$lab_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('zipped' => 0,'lab_id' => $lab_id));
				if($query->num_rows() == 1){
					return false;
				}else{
					return true;
				}
		}

		public function getIfUserIsPathologist($health_facility_table_name,$user_id,$dept,$sub_dept){
			$query = $this->db->get_where($health_facility_table_name,array('user_id' => $user_id,'position' => 'personnel', 'personnel' => 'pathologist','dept' => $dept,'sub_dept' => $sub_dept));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getIfUserIsMainAdmin($health_facility_table_name,$user_id){
			$query = $this->db->get_where($health_facility_table_name,array('user_id' => $user_id,'position' => 'admin' , 'is_admin' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getIfUserIsSubAdmin($health_facility_table_name,$user_id,$dept,$sub_dept){
			$query = $this->db->get_where($health_facility_table_name,array('user_id' => $user_id,'position' => 'sub_admin','dept' => $dept,'sub_dept' => $sub_dept));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function zipResult($health_facility_patient_db_table,$lab_id){
			$query = $this->db->update($health_facility_patient_db_table,array('zipped' => 1),array('lab_id' => $lab_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function unzipResult($health_facility_patient_db_table,$lab_id){
			$query = $this->db->update($health_facility_patient_db_table,array('zipped' => 0),array('lab_id' => $lab_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfTestResultsAreReady($health_facility_patient_db_table,$lab_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('lab_id' => $lab_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$test_ready = $row->test_ready;
					if($test_ready == 1){
						return true;
					}else{
						return false;
					}
				}
			}
		}

		public function checkIfTestIsSubmitted($health_facility_main_test_result_table,$test_result_id){
			$query = $this->db->get_where($health_facility_main_test_result_table,array('id' => $test_result_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$submitted = $row->submitted;
					if($submitted == 1){
						return false;
					}else{
						return true;
					}
				}
			}
		}

		public function getPathologistsComment($health_facility_patient_db_table,$lab_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('lab_id' => $lab_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$pathologists_comment = $row->pathologists_comment;
				}
				return $pathologists_comment;
			}
		}

		public function getAllPaidTestsRegisteredZero($health_facility_table_name){
			$query = $this->db->get_where($health_facility_table_name,array('registered' => 0,'paid' => 1));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfRangeIsValid($range){
			if($range == "1-day" || $range == "1-week" || $range == "1-month" || $range == "1-year" || $range == "1-decade"){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfResultIsVerified($health_facility_patient_db_table,$lab_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('lab_id' => $lab_id,'verified' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function deleteAdmin($health_facility_table_name,$user_name,$affiliation_id){
			$query = $this->db->delete($health_facility_table_name,array('id' => $affiliation_id,'user_name' => $user_name));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsATopAdmin($health_facility_table_name,$user_name){
			$query = $this->db->get_where($health_facility_table_name,array('user_name' => $user_name,'is_admin' => 1,'position' => 'admin'));

			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsATopAdmin2($health_facility_table_name,$user_id){
			$query = $this->db->get_where($health_facility_table_name,array('user_id' => $user_id,'is_admin' => 1,'position' => 'admin'));
			
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsAnAdmin1($health_facility_table_name,$user_name){
			$query = $this->db->get_where($health_facility_table_name,array('user_name' => $user_name,'is_admin' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		


		public function getTestSections($sub_dept){
			$this->db->select("*");
			$this->db->from('test_sections');
			$this->db->where('label = "a" OR label = "b" OR label = "f" OR label = "g" OR label = "h" OR label = "i" OR label = "j" OR label = "k" OR label = "l"');
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getClinicalPathologyTestSectionByLabel($label){
			if($label == 'a' || $label == 'b' || $label == 'f' || $label == 'g' || $label == 'h' || $label == 'i' || $label == 'j' || $label == 'k' || $label == 'l'){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfTestIdIsValid($test_id,$health_facility_test_table_name,$id){
			$query = $this->db->get_where($health_facility_test_table_name,array('id' => $id,'test_id' => $test_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkNoOfTestsWithTestId($test_id,$health_facility_test_table_name){
			$query = $this->db->get_where($health_facility_test_table_name,array('test_id' => $test_id));
			return $query->num_rows();
				
		}

		public function getTestById($health_facility_test_table_name,$main_test_id){
			$query = $this->db->get_where($health_facility_test_table_name,array('id' => $main_test_id));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getResultValue($health_facility_main_test_result_table,$test_result_id,$field){
			if($field == "control_1" || $field == "control_2" || $field == "control_3" || $field == "test_result" || $field == "date" || $field == "time"){
				$query = $this->db->get_where($health_facility_main_test_result_table,array('id' => $test_result_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$rVal = $row->$field;
					}
					return $rVal;
				}else{
					return "";
				}
			}else{
				return "";
			}
		}

		public function getTestResultsMain1($health_facility_main_test_result_table,$lab_id){
			$this->db->select("*");
			$this->db->from($health_facility_main_test_result_table);
			$this->db->where('lab_id',$lab_id);
			$this->db->order_by('id','ASC');
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getTestResultsMain5($health_facility_main_test_result_table,$lab_id){
			$this->db->select("*");
			$this->db->from($health_facility_main_test_result_table);
			$this->db->where('lab_id' ,$lab_id);
			
			$this->db->order_by('id','ASC');
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getTestResultsMain2($health_facility_main_test_result_table,$form_array){
			$query = $this->db->get_where($health_facility_main_test_result_table,$form_array);
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfTestResultTestHasSubTests($health_facility_main_test_result_table,$id){
			$query = $this->db->get_where($health_facility_main_test_result_table,array('super_test_id' => $id));
			if($query->num_rows() > 0){
				return false;
			}else{
				return true;
			}
		}

		public function checkIfTestResultTestHasBeenEntered($health_facility_main_test_result_table,$id){
			$this->db->select("*");
			$this->db->from($health_facility_main_test_result_table);
			$this->db->where('id', $id);
			$this->db->where('test_result', NULL);

			$this->db->or_where('images' ,"");
			$query = $this->db->get();
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getTestsBySection($test_section_label,$test_table_name){
			

			if($this->db->table_exists($test_table_name))
			{
			   //DO SOMETHING! IT EXISTS!
				$query = $this->db->get_where($test_table_name,array('section' => $test_section_label));
				if($query->num_rows() > 0){
					return $query->result();
				}
			}
			else
			{
			    //I can't find it...
			    $query = $this->db->get_where('tests',array('section' => $test_section_label));
				if($query->num_rows() > 0){
					return $query->result();
				}
			}
			
		}

		public function trim_text($input, $length, $ellipses = true, $strip_html = true) {
		    //strip tags, if desired
		    if ($strip_html) {
		        $input = strip_tags($input);
		    }
		  
		    //no need to trim, already shorter than trim length
		    if (strlen($input) <= $length) {
		        return $input;
		    }
		  
		    //find last space within length
		    $last_space = strrpos(substr($input, 0, $length), ' ');
		    $trimmed_text = substr($input, 0, $last_space);
		  
		    //add ellipses (...)
		    if ($ellipses) {
		        $trimmed_text .= '...';
		    }
		  
		    return $trimmed_text;
		}

		

		public function checkIfUserIsAdminOrSubAdmin($health_facility_table_name,$user_name){
			// $query = $this->db->query('SELECT * FROM "'.$health_facility_table_name.'" WHERE username = "'.$user_name.'" AND ( position="admin" OR position="sub_admin") ');
			$this->db->select('*');
			$this->db->from($health_facility_table_name);
			$this->db->where('user_name = "'.$user_name.'" AND ( position="admin" OR position="sub_admin")');
			$query = $this->db->get();
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserIsAdminOrSubAdminOrPersonnel($health_facility_table_name,$user_name){
			// $query = $this->db->query('SELECT * FROM "'.$health_facility_table_name.'" WHERE username = "'.$user_name.'" AND ( position="admin" OR position="sub_admin") ');
			$this->db->select('*');
			$this->db->from($health_facility_table_name);
			$this->db->where('user_name = "'.$user_name.'" AND ( position="admin" OR position="sub_admin" OR position="personnel")');
			$query = $this->db->get();
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getIfMainTestHasSubTests($health_facility_main_test_result_table,$form_array2){
			$query = $this->db->get_where($health_facility_main_test_result_table,$form_array2);
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getUserPositionAtSubDept($health_facility_table_name,$user_id,$dept,$sub_dept){
			$query = $this->db->get_where($health_facility_table_name,array('user_id' => $user_id,'dept' => $dept, 'sub_dept' => $sub_dept));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$user_position = $row->position;
				}
				return $user_position;
			}else{
				
				return false;
			}
		}
		public function checkIfUserIsPatient($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name,'is_patient' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getFirstTenHospitals(){
			$query = $this->db->get_where('health_facility',array('facility_structure' => 'hospital'),10);
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function checkIfUserIsRegisteredOnThisFacility($hospital_table_name,$user_name,$facility_name,$user_id){
			// echo $hospital_table_name . ':' . $user_name . ':' . $facility_name . ':' . $user_id ;
			$query = $this->db->get_where($hospital_table_name,array('user_name' => $user_name,'position' => 'patient','user_id' => $user_id,'facility_name' => $facility_name));
			
			if($query->num_rows() == 1){
				$query1 = $this->db->get_where('users',array('id' => $user_id));
				if($query1->num_rows() == 1){
					foreach($query1->result() as $row){
						$affiliated_facilities = $row->affiliated_facilities;
					}
					$affiliated_facilities_arr = explode(",", $affiliated_facilities);
					foreach ($affiliated_facilities_arr as $key => $value) {
                        if (empty($value)) {
                           unset($affiliated_facilities_arr[$key]);
                        }
                    }
                    if(!empty($affiliated_facilities_arr)){
						if(in_array($hospital_table_name, $affiliated_facilities_arr)){
							return true;
						}else{
							// echo "string";
							$affiliated_facilities .= ','.$hospital_table_name;
							// echo $affiliated_facilities.'<br>';
							$user_array = array(
								'affiliated_facilities' => $affiliated_facilities
							);
							if($this->updateUserTable($user_array,$user_id)){
								// echo "string";
								return true;
							}else{
								return false;
							}
						}
					}else{
						$affiliated_facilities = $hospital_table_name;
						$user_array = array(
							'affiliated_facilities' => $affiliated_facilities
						);
						if($this->updateUserTable($user_array,$user_id)){
							return true;
						}else{
							return false;
						}
					}
				}else{
					return false;
				}
				
			}else{
				$query1 = $this->db->get_where('users',array('id' => $user_id));
				if($query1->num_rows() == 1){
					foreach($query1->result() as $row){
						$affiliated_facilities = $row->affiliated_facilities;
					}
					$affiliated_facilities_arr = explode(",", $affiliated_facilities);
					foreach ($affiliated_facilities_arr as $key => $value) {
                        if (empty($value)) {
                           unset($affiliated_facilities_arr[$key]);
                        }
                    }
                    if(!empty($affiliated_facilities_arr)){
						if(in_array($hospital_table_name, $affiliated_facilities_arr)){
							$index = array_search($hospital_table_name,$affiliated_facilities_arr);
							unset($affiliated_facilities_arr[$index]);
							$affiliated_facilities = implode(",", $affiliated_facilities_arr);
							$user_array = array(
								'affiliated_facilities' => $affiliated_facilities
							);
							$this->updateUserTable($user_array,$user_id);
							return false;
						}else{
							return false;
						}
					}else{
						return false;
					}
				}	
			}
		}

		public function confirmUserIsAPatient($health_facility_slug){
			$user_id = $this->getUserIdWhenLoggedIn();
			$query = $this->db->get_where('health_facility',array('slug' => $health_facility_slug));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$table_name = $row->table_name;
				}
				$query = $this->db->get_where($table_name,array('user_id' => $user_id,'is_admin' => 1));
				if($query->num_rows() > 0){
					return false;
				}else{
					return true;
				}
			}else{
				return false;
			}
		}

		public function getFirstSubDept($dept_id){
			$query = $this->db->get_where('sub_dept',array('dept_id' => $dept_id),1);
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getSubDepts($dept_id){
			$query = $this->db->get_where('sub_dept',array('dept_id' => $dept_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getSubDeptsOther($dept_id){
			$this->db->select("*");
			$this->db->from("sub_dept");
			$this->db->where("dept_id",$dept_id);
			$this->db->limit(9,1);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function getNumberOfRegisteredFacilityPatients($hospital_table_name,$facility_name){
			$query = $this->db->get_where($hospital_table_name,array('position' => 'patient','facility_name' => $facility_name));
			
			return $query->num_rows();
		}

		public function getFirstRegisteredPatients($hospital_table_name){
			$query = $this->db->get_where($hospital_table_name,array('position' => 'patient'),7);
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getRemainingRegisteredPatients($hospital_table_name,$offset){
			$query = $this->db->get_where($hospital_table_name,array('position' => 'patient'),7,$offset);
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getUserDpById($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$dp = $row->logo;
				}
				return $dp;
			}else{
				return false;
			}
		}

		public function getSponsorChargeForBasicPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 1));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getCenterLeaderSponsorIncome(){
			$query = $this->db->get_where("mlm_charges",array('id' => 7));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getCenterLeaderSponsorIncomeVat(){
			$query = $this->db->get_where("mlm_charges",array('id' => 7));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function getSponsorChargeForBusinessPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 3));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getPlacementChargeForBasicPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 2));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getPlacementChargeForBusinessPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 4));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getCenterLeaderPlacementBonus(){
			$query = $this->db->get_where("mlm_charges",array('id' => 12));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getSponsorVatChargeForBasicPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 1));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function getAdminSponsorChargeForBasicPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 5));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getCenterLeaderAdminSponsorBonus(){
			$query = $this->db->get_where("mlm_charges",array('id' => 8));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getAdminSponsorChargeForBusinessPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 6));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getSponsorVatChargeForBusinessPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 3));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function getPlacementVatChargeForBasicPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 2));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function getPlacementVatChargeForBusinessPackage(){
			$query = $this->db->get_where("mlm_charges",array('id' => 4));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function getCenterLeaderPlacementBonusVat(){
			$query = $this->db->get_where("mlm_charges",array('id' => 12));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function getCarBonus(){
			$query = $this->db->get_where("mlm_charges",array('id' => 11));
			if($query->num_rows() == 1){
				return $query->result()[0]->amount;
			}
		}

		public function getCarBonusVat(){
			$query = $this->db->get_where("mlm_charges",array('id' => 11));
			if($query->num_rows() == 1){
				return $query->result()[0]->vat;
			}
		}

		public function getUserNameBySlug($slug){
			$query = $this->db->get_where('users',array('slug' => $slug));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$user_name = $row->user_name;
				}
				// echo $user_name;
				return $user_name;
			}else{
				return false;
			}
		}

		public function getUserNameByToken($token){
			$query = $this->db->get_where('users',array('token' => $token));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$user_name = $row->user_name;
				}
				// echo $user_name;
				return $user_name;
			}else{
				return false;
			}
		}

		public function getUserByTokenBoolean($token){
			$query = $this->db->get_where('users',array('token' => $token));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getUserEmailByUserId($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$email = $row->email;
				}
				// echo $user_name;
				return $email;
			}else{
				return false;
			}
		}

		public function getUserTokenByUserId($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$token = $row->token;
				}
				// echo $user_name;
				return $token;
			}else{
				return false;
			}
		}

		public function getUserFullNameByUserId($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$full_name = $row->full_name;
				}
				// echo $user_name;
				return $full_name;
			}else{
				return false;
			}
		}


		public function getUserNameById($slug){
			$query = $this->db->get_where('users',array('id' => $slug));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$user_name = $row->user_name;
				}
				// echo $user_name;
				return $user_name;
			}else{
				return false;
			}
		}

		public function getUserAddressById($slug){
			$query = $this->db->get_where('users',array('id' => $slug));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$address = $row->address;
				}
				// echo $user_name;
				return $address;
			}else{
				return false;
			}
		}

		public function getUserFullNameById($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$full_name = $row->full_name;
				}
				// echo $user_name;
				return $full_name;
			}else{
				return false;
			}
		}

		public function getUserBioById($slug){
			$query = $this->db->get_where('users',array('id' => $slug));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$bio = $row->bio;
				}
				// echo $user_name;
				return $bio;
			}else{
				return false;
			}
		}

		public function getUserLogoById1($slug){
			$query = $this->db->get_where('users',array('id' => $slug));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$logo = $row->logo;
				}
				// echo $user_name;
				if(is_null($logo)){
					$logo = "avatar.jpg";
				}else{

				}
				return $logo;
			}else{
				return false;
			}
		}

		public function getFacilityPatients($hospital_table_name,$facility_name){
			$query = $this->db->get_where($hospital_table_name,array('position' => 'patient','facility_name' => $facility_name,'is_admin' => 0));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getNotifCount($user_id){

			$query = $this->db->get_where('notif',array('receiver' => $user_id,'received' => 0));
			return $query->num_rows();
		}

		public function getAllNotifsCount($user_id){
			$this->db->select("*");
			$this->db->from("notif");
			$this->db->where("receiver",$user_id);
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function getNewNotifsCount(){
			$user_id = $this->getUserIdWhenLoggedIn();
			$this->db->select("*");
			$this->db->from("notif");
			$this->db->where("receiver",$user_id);
			$this->db->where("received",0);
			$query = $this->db->get();
			$num_rows = $query->num_rows();
			if($num_rows > 0){
				return "(" . $num_rows . ")";
			}else{
				return "";
			}
		}

		public function getNewMessagesCount($user_id){
			// $query = $this->db->get_where('messages',array('receiver' => $user_id,'received' => 0));
			$this->db->select('sender');
			$this->db->from('messages');
			$this->db->where('receiver',$user_id);
			$this->db->where('received',0);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				$rows = array();
				foreach($query->result() as $row){
					$sender = $row->sender;
					$rows[] .= $sender;
				}
				
				$rows = array_unique($rows);
				$rows = count($rows);
			}else{
				$rows = 0;
			}
			return $rows;
		}

		public function sortMessagesArrayRows($new_rows,$user_id){
			if(is_array($new_rows)){
				$return_rows = array();
				for($i = 0; $i < count($new_rows); $i++){
					if($this->getIfUserIdIsValid($new_rows[$i])){
						$last_message_by_user = $this->getLastMessageByThisUser($user_id);
					}
				}
			}
		}


		public function getNumberOfNewMessagesFromSender($user_id,$sender){
			$query = $this->db->get_where('messages',array('sender' => $sender,'receiver' => $user_id,'received' => 0));
			if($query->num_rows() > 0 ){
				return "(". $query->num_rows() .")";
			}else{
				return "";
			}
		}

		public function getConversations($user_id){
			// $query = $this->db->get_where('messages',array('receiver' => $user_id,'received' => 0));
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('receiver',$user_id);
			$this->db->or_where('sender',$user_id);
			$this->db->order_by("id","DESC");
			// $this->db->where('received',0);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				// $ret_arr = array('sender' => )
				$rows = array();
				$new_rows = array();
				foreach($query->result() as $row){
					$sender = $row->sender;
					$id = $row->id;
					$date = $row->date;
					$time = $row->time;
					$received = $row->received;
					$date_time = $date . " " . $time;
					$message = $row->message;
					$receiver = $row->receiver;
					$rows[] = array(
						'sender' => $sender,
						'id' => $id,
						'date_time' => $date_time,
						'received' => $received,
						'message' => $message,
						'receiver' => $receiver
					);
				}
				
				// $rows = array_unique($rows,SORT_REGULAR);
				$rows1 = array_unique($this->array_column_manual($rows, 'sender'));
				// var_dump($rows1);
				// print_r(array_intersect_key($array, $tempArr));
				$rows = array_intersect_key($rows,$rows1);
				$rows = array_values($rows);
				$rows = array_slice($rows, 0,20);
				// var_dump($rows);				
			}else{
				$rows = false;
			}
			return $rows;
		}

		public function getConversationsRem($user_id,$offset){
			// $query = $this->db->get_where('messages',array('receiver' => $user_id,'received' => 0));
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('receiver',$user_id);
			// $this->db->where('received',0);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				// $ret_arr = array('sender' => )
				$rows = array();
				$new_rows = array();
				foreach($query->result() as $row){
					$sender = $row->sender;
					$id = $row->id;
					$date = $row->date;
					$time = $row->time;
					$received = $row->received;
					$date_time = $date . " " . $time;
					$message = $row->message;
					$rows[] = array(
						'sender' => $sender,
						'id' => $id,
						'date_time' => $date_time,
						'received' => $received,
						'message' => $message
					);
				}
				
				// $rows = array_unique($rows,SORT_REGULAR);
				$rows1 = array_unique($this->array_column_manual($rows, 'sender'));
				// print_r(array_intersect_key($array, $tempArr));
				$rows = array_intersect_key($rows,$rows1);
				$rows = array_values($rows);
				$slice = $offset * 10;

				$rows = array_slice($rows, $slice,10);
				// var_dump($rows);				
			}else{
				$rows = false;
			}
			return $rows;
		}

		public function array_column_manual($array, $column)
		{
		    $newarr = array();
		    foreach ($array as $row) $newarr[] = $row[$column];
		    return $newarr;
		}

		public function getConversationsRem2($user_id,$offset){
			$this->db->select("*");
			$this->db->from("messages");
			$this->db->where('sender',$user_id);
			$this->db->or_where('receiver',$user_id);
			$this->db->order_by("id","DESC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				// $ret_arr = array('sender' => )
				// echo $this->db->last_query();
				$rows = array();
				$new_rows = array();
				foreach($query->result() as $row){
					$sender = $row->sender;
					$id = $row->id;
					$date = $row->date;
					$time = $row->time;
					$received = $row->received;
					$date_time = $date . " " . $time;
					$message = $row->message;
					$receiver = $row->receiver;
					$rows[] = array(
						'sender' => $sender,
						'id' => $id,
						'date_time' => $date_time,
						'received' => $received,
						'message' => $message,
						'receiver' => $receiver
					);
				}
				
				// $rows = array_unique($rows,SORT_REGULAR);
				$rows1 = array_unique($this->array_column_manual($rows, 'sender'));
				// var_dump($rows1);
				// print_r(array_intersect_key($array, $tempArr));
				$rows = array_intersect_key($rows,$rows1);
				$rows = array_values($rows);
				$slice = $offset * 10;

				$rows = array_slice($rows, $slice,10);
				
			}else{
				$rows = false;
			}
			return $rows;
		}

		public function getConversationsNum($user_id){
			// $query = $this->db->get_where('messages',array('receiver' => $user_id,'received' => 0));
			$this->db->select('*');
			$this->db->from('messages');
			$this->db->where('receiver',$user_id);
			// $this->db->where('received',0);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				// $ret_arr = array('sender' => )
				$rows = array();
				$new_rows = array();
				foreach($query->result() as $row){
					$sender = $row->sender;
					$id = $row->id;
					$date = $row->date;
					$time = $row->time;
					$received = $row->received;
					$date_time = $date . " " . $time;
					$message = $row->message;
					$rows[] = array(
						'sender' => $sender,
						'id' => $id,
						'date_time' => $date_time,
						'received' => $received,
						'message' => $message
					);
				}
				
				// $rows = array_unique($rows,SORT_REGULAR);
				$rows1 = array_unique($this->array_column_manual($rows, 'sender'));
				// print_r(array_intersect_key($array, $tempArr));
				$rows = array_intersect_key($rows,$rows1);
				$rows = array_values($rows);
				// $rows = array_slice($rows, 0,20);
				// var_dump($rows);	
				$rows = count($rows);			
			}else{
				$rows = 0;
			}
			return $rows;
		}

		public function getNotifs($user_id){
			$this->db->select("*");
			$this->db->from('notif');
			$this->db->where('receiver',$user_id);
			$this->db->order_by('id','DESC');
			$this->db->limit(15);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}


		public function getNotifsPerPage($user_id,$page){
			$offset = $page * 10;
			$this->db->select("*");
			$this->db->from('notif');
			$this->db->where('receiver',$user_id);
			$this->db->order_by('id','DESC');
			$this->db->limit(10,$offset);
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getNotifsNum($user_id){
			$this->db->select("*");
			$this->db->from('notif');
			$this->db->where('receiver',$user_id);			
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function deleteMessage($id){
			$query = $this->db->delete('notif',array('id' => $id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function updateNotif($form_array,$id){
			$query = $this->db->update('notif',$form_array,array('id' => $id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function submitPathologistComment($health_facility_patient_db_table,$form_array,$lab_id){
			$query = $this->db->update($health_facility_patient_db_table,$form_array,array('lab_id' => $lab_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getPatientNameByUserName($patient_user_name){
			$query = $this->db->get_where('patients',array('user_name' => $patient_user_name));
			if($query->num_rows() == 1){
				if(is_array($query->result())){
					foreach($query->result() as $row){
						$full_name = $row->full_name;
					}
					return $full_name;
				}
			}else{
				return false;
			}
		}

		public function checkIfTableExists($table_name){
			if($this->db->table_exists($table_name)){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserExists($user_name,$user_id){
			$query = $this->db->get_where('users',array('user_name' => $user_name,'id' => $user_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserExists1($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function registerPatient($table_name,$form_array){
			$query = $this->db->insert($table_name,$form_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getUserIdByToken($token){
			$query = $this->db->get_where('users',array('token' => $token));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$id = $row->id;
				}
				return $id;
			}
		}

		public function unregisterPatient($table_name,$form_array){
			$query = $this->db->delete($table_name,$form_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getAllUserInfo($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$followers = $row->followers;
					$following = $row->following;
					$posts_num = $this->getUserTotalPostsNum($user_id);
					$following_num = $this->getUserTotalFollowingNum($user_id);
					$followers_num = $this->getUserTotalFollowersNum($user_id);
					unset($row->followers);
					unset($row->following);
					$row->following_num = $following_num;
					$row->followers_num = $followers_num;
					$row->posts_num = $posts_num;
				}
				return $query->result();
			}
		}

		public function confirmLoggedIn($check_if_admin = FALSE){
			if(get_cookie('allenexpressrem',true)){
				$cookie = get_cookie('allenexpressrem',true);
				list($user_id,$token,$mac) = explode(':', $cookie);
				if(!isset($user_id) || !isset($token) || !isset($mac) || is_null($user_id) || is_null($mac) || is_null($token) || $user_id == "" || $token == "" || $mac == ""){
					return false;
				}
				$cookie0 = $user_id . ':' .$token;
				
				$decrypt_mac = $this->encryption->decrypt($mac);
				if($decrypt_mac == false){
					return false;
				}
				
				if(!hash_equals($cookie0,$decrypt_mac)){
					return false;
				}
				$usertoken_arr = $this->db->get_where('users',array('id' => $user_id),1);
				$usertoken_arr = $usertoken_arr->result();
				if(is_array($usertoken_arr)){
					foreach($usertoken_arr as $user_token){
						$user_token = $user_token->token;
						// $user_name1 = $user_token->user_name;
					}
					
					if(hash_equals($user_token,$token)){
						$query1 = $this->db->get_where('users',array('id' => $user_id));
						if($query1->num_rows() == 1){
							foreach($query1->result() as $row){
								$created = $row->created;
								$is_admin = $row->is_admin;
								$active = $row->active;
								if($check_if_admin){
									if($created == 1 && $is_admin == 1){
										return true;
									}
								}else{
									// echo "string";
									if($created == 1){
										if($active == 1){
											return true;
										}else{
											delete_cookie('allenexpressrem');			
										}
									}
								}
							}
							
						}
					}else{
						return false;
					}
				}else{
					return false;
				}
			}else{
				if(isset($_POST['allenexpressrem'])){
					$user_id = $_POST['allenexpressrem'];
					if($this->checkIfUserExists1($user_id)){
						return true;
					}
				}
				return false;
			}
		}





		public function getUserIdWhenLoggedIn(){
			if(get_cookie('allenexpressrem',true)){
				$cookie = get_cookie('allenexpressrem',true);
				list($user_id,$token,$mac) = explode(':', $cookie);
				return $user_id;
			}else{
				if(isset($_POST['allenexpressrem'])){
					$user_id = $_POST['allenexpressrem'];
					return $user_id;
				}
				return false;
			}	
		}

		public function timingSafeCompare($safe, $user) {
		    if (function_exists('hash_equals')) {
		        return hash_equals($safe, $user); // PHP 5.6
		    }
		    // Prevent issues if string length is 0
		    $safe .= chr(0);
		    $user .= chr(0);

		    // mbstring.func_overload can make strlen() return invalid numbers
		    // when operating on raw binary strings; force an 8bit charset here:
		    if (function_exists('mb_strlen')) {
		        $safeLen = mb_strlen($safe, '8bit');
		        $userLen = mb_strlen($user, '8bit');
		    } else {
		        $safeLen = strlen($safe);
		        $userLen = strlen($user);
		    }

		    // Set the result to the difference between the lengths
		    $result = $safeLen - $userLen;

		    // Note that we ALWAYS iterate over the user-supplied length
		    // This is to prevent leaking length information
		    for ($i = 0; $i < $userLen; $i++) {
		        // Using % here is a trick to prevent notices
		        // It's safe, since if the lengths are different
		        // $result is already non-0
		        $result |= (ord($safe[$i % $safeLen]) ^ ord($user[$i]));
		    }

		    // They are only identical strings if $result is exactly 0...
		    return $result === 0;
		}

		//Get User Info
		

		public function getSubDeptBySlug($slug){
			$query = $this->db->get_where('sub_dept',array('slug' => $slug));
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}


		
		public function getFacilityBySlug($slug){
			$query = $this->db->get_where('health_facility',array('slug' => $slug));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function createPatientAccount($patient_array){
			$query = $this->db->insert('patients',$patient_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function createMainTestResultTable($health_facility_test_result_table){
			if($this->db->table_exists($health_facility_test_result_table)){
				return false;
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					lab_id TEXT NOT NULL,
					test_id TEXT NOT NULL,
					test_name VARCHAR(500) NOT NULL,
					control_1 VARCHAR(300) NOT NULL,
					control_2 VARCHAR(300) NOT NULL,
					control_3 VARCHAR(300) NOT NULL,
					test_result VARCHAR(300) NOT NULL,
					images TEXT NOT NULL,
					main_test INT DEFAULT 0 NOT NULL,
					sub_test INT DEFAULT 0 NOT NULL,
					super_test_id INT NOT NULL,
					date VARCHAR(50) NOT NULL,
					time VARCHAR(50) NOT NULL,
					submitted INT DEFAULT 0 NOT NULL
				)';
				if($this->db->query($query_str)){
					return true;	
				}
			}
			
		}

		public function changeUserPassword($user_id,$token,$new_password){
			$hashed = sha1($new_password);
			$query = $this->db->update('users',array('hashed' => $hashed,'token' => $token),array('id' => $user_id));
			if($query){
				return true;
			}else{
				return false;
			}	
		}

		public function getImagesInPost($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$images = $row->images;
				}
				return $images;
			}
		}

		public function getPostContentById($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$content = $row->content;
				}
				return $content;
			}
		}

		public function checkIfMobileNoIsForUser($user_id,$mobile_no){
			if($this->checkIfUserExists1($user_id)){
				$query = $this->db->get_where('users',array('id' => $user_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$phone_code = $row->phone_code;
						$phone_number = $row->phone;
					}
					$mobile_no1 = "+".$phone_code."".$phone_number;
				}
				if($mobile_no1 == $mobile_no){
					return true;
				}else{
					return false;
				}
			}
		}

		public function curl($url, $use_post, $post_data=[]){
	        $curl = curl_init();
	        
	        curl_setopt($curl, CURLOPT_URL, $url.'?'.http_build_query($post_data));
	        
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	        
	        if($use_post){
	            curl_setopt($curl, CURLOPT_POST, TRUE);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
	        }
	        //Modify this two lines to suit your needs
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	        $response = curl_exec($curl);
	        curl_close($curl);
	        
	        return $response;
	    }

	    public function vtu_curl($url, $use_post, $post_data=[]){
	        $curl = curl_init();
	        
	        curl_setopt($curl, CURLOPT_URL, $url);
	        
	        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
	        
	        if($use_post){
	            curl_setopt($curl, CURLOPT_POST, TRUE);
	            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));
	        }
	        //Modify this two lines to suit your needs
	        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);//curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
	        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, TRUE);
	        $response = curl_exec($curl);
	        curl_close($curl);
	        
	        return $response;
	    }

	    public function custom_curl($url,$use_post,$post_data=[]){
	    	$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL,$url);
			if($use_post){
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($post_data));
			}
			
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$response = curl_exec($ch);

			curl_close ($ch);

			return $response;
	    }

	    public function storeSuperForexUsers($user_info){
	    	if(is_array($user_info)){
	    		$query = $this->db->insert('mps.super_forex_users',$user_info);
	    		if($query){
	    			return true;
	    		}else{
	    			return false;
	    		}
	    	}
	    }

	    public function phone_unique($phone_code,$phone){
	    	$query = $this->db->get_where('users',array('phone' => $phone,'phone_code' => $phone_code));
	    	if($query->num_rows() > 0){
	    		return false;
	    	}else{
	    		return true;
	    	}
	    }

	    public function getMiniImportationOrderCodeInfo($order_code){
	    	$user_id = $this->getUserIdWhenLoggedIn();
	    	$query = $this->db->get_where("mini_importation_orders",array('order_code' => $order_code,'user_id' => $user_id));
	    	if($query->num_rows() > 0){
	    		return $query->result();
	    	}else{
	    		return false;
	    	}
	    }

	    public function getUserPhoneNumberByUserId($user_id){
	    	$query = $this->db->get_where('users',array('id' => $user_id));
	    	if($query->num_rows() == 1){
	    		foreach($query->result() as $row){
	    			$phone = $row->phone;
	    		}
	    		return $phone;
	    	}else{
	    		return false;
	    	}
	    }

	    public function checkIfLocalGovtIdIsValid($local_government_id){
	    	$query = $this->db->get_where('locals',array('id' => $local_government_id));
	    	if($query->num_rows() == 1){
	    		return true;
	    	}else{
	    		return false;
	    	}
	    }

	    public function getCenterLeadersInLocalGovt($local_government_id){
	    	$query = $this->db->get_where('users',array('center_leader' => 1,'local_government' => $local_government_id));
	    	if($query->num_rows() > 0){
	    		return $query->result();
	    	}else{
	    		return false;
	    	}
	    }

	    public function getUserPhoneCodeByUserId($user_id){
	    	$query = $this->db->get_where('users',array('id' => $user_id));
	    	if($query->num_rows() == 1){
	    		foreach($query->result() as $row){
	    			$phone_code = $row->phone_code;
	    		}
	    		return $phone_code;
	    	}else{
	    		return false;
	    	}
	    }

	    public function objToArray($obj){
	    	if(is_object($obj)){
	    		$arr = json_decode(json_encode($obj), true);
	    	}
	    	return $arr;
		}

	    public function isJson($string) {
		 json_decode($string);
		 return (json_last_error() == JSON_ERROR_NONE);
		}

		public function createTestRecord($array,$health_facility_test_result_table){
			if($this->db->table_exists($health_facility_test_result_table)){
				$query = $this->db->insert($health_facility_test_result_table,$array);
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					main_test_id INT NOT NULL,
					facility_name VARCHAR(100) NOT NULL,
					initiation_code VARCHAR(100) NOT NULL,
					lab_id TEXT NULL,
					
					test_id VARCHAR(1000) NOT NULL,
					receipt_file TEXT NULL,
					patient_name VARCHAR(200) NOT NULL,
					test_name TEXT NOT NULL,
					patient_username VARCHAR(100) NULL,
					price BIGINT(20) NOT NULL,
					ta_time BIGINT(20) NOT NULL,
					date VARCHAR(100) NOT NULL,
					time VARCHAR(100) NOT NULL,
					invalid INT NOT NULL DEFAULT 0,
					paid INT NOT NULL DEFAULT 0,
					date_paid VARCHAR(50) NOT NULL,
					time_paid VARCHAR(50) NOT NULL,
					refund_requested INT NOT NULL DEFAULT 0,
					refund_request_code TEXT NULL,
					payment_initiated INT DEFAULT 0 NOT NULL,
					patient_locked INT DEFAULT 0 NOT NULL,
					registered INT DEFAULT 0

				)';
				if($this->db->query($query_str)){
					$query = $this->db->insert($health_facility_test_result_table,$array);
					if($query){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
			
		}

		public function markPaidTests($id,$form_array,$health_facility_name,$health_facility_test_result_table){
			if($this->db->table_exists($health_facility_test_result_table)){
				$query = $this->db->update($health_facility_test_result_table,$form_array,array('id' => $id,'facility_name' => $health_facility_name));
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					main_test_id INT NOT NULL,
					facility_name VARCHAR(100) NOT NULL,
					initiation_code VARCHAR(100) NOT NULL,
					lab_id TEXT NULL,
					
					test_id VARCHAR(1000) NOT NULL,
					receipt_file TEXT NULL,
					patient_name VARCHAR(200) NOT NULL,
					test_name TEXT NOT NULL,
					patient_username VARCHAR(100) NULL,
					price BIGINT(20) NOT NULL,
					ta_time BIGINT(20) NOT NULL,
					date VARCHAR(100) NOT NULL,
					time VARCHAR(100) NOT NULL,
					invalid INT NOT NULL DEFAULT 0,
					paid INT NOT NULL DEFAULT 0,
					date_paid VARCHAR(50) NOT NULL,
					time_paid VARCHAR(50) NOT NULL,
					refund_requested INT NOT NULL DEFAULT 0,
					refund_request_code TEXT NULL,
					payment_initiated INT DEFAULT 0 NOT NULL,
					patient_locked INT DEFAULT 0 NOT NULL,
					registered INT DEFAULT 0

				)';
				if($this->db->query($query_str)){
					$query = $this->db->udpate($health_facility_test_result_table,$form_array,array('id' => $id,'facility_name' => $health_facility_name));
					if($query){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}

		public function getLastRowTestResult($health_facility_test_result_table,$health_facility_name){
			$this->db->select_max('lab_id');
			$query = $this->db->get_where($health_facility_test_result_table,array('facility_name' => $health_facility_name));
			if($query->num_rows() == 1){
				
				return $query->result();
			}else{
				return false;
			}
		}

		public function getLastRowTestResultRefundId($health_facility_test_result_table,$health_facility_name){
			$this->db->select_max('refund_request_code');
			$query = $this->db->get_where($health_facility_test_result_table,array('facility_name' => $health_facility_name));
			if($query->num_rows() == 1){
				
				return $query->result();
			}else{
				return false;
			}
		}

		public function getTestResultsByLabId($health_facility_main_test_result_table,$lab_id){
			$query = $this->db->get_where($health_facility_main_test_result_table,array('lab_id' => $lab_id));
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getResultId($health_facility_main_test_result_table,$array){
			$query = $this->db->get_where($health_facility_main_test_result_table,$array);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$id = $row->id;
					return $id;
				}
			}else{
				return false;
			}
		}

		public function updateTestResults($form_array,$id,$health_facility_test_result_table){
			$query = $this->db->update($health_facility_test_result_table,$form_array,array('id' => $id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function updateTestRecordsFieldsRefundId($form_array,$refund_id,$health_facility_test_result_table){
			$query = $this->db->update($health_facility_test_result_table,$form_array,array('refund_request_code' => $refund_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function custom_echo($x, $length)
		{
		  if(strlen($x)<=$length)
		  {
		    return $x;
		  }
		  else
		  {
		    $y=substr($x,0,$length) . '...';
		    return $y;
		  }
		}

		//Get Tests
		public function get_first_set_of_tests_clinical_pathology(){
			$query = $this->db->query('SELECT * FROM tests WHERE section = "a" OR section = "b" OR section = "f" OR section = "g" OR section = "h" OR section = "i" OR section = "j" OR section = "k" OR section = "l"');
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function deletePatientTest($health_facility_patient_db_table,$user_name,$id){
			$query = $this->db->delete($health_facility_patient_db_table,array('id' => $id,'patient_username' => $user_name));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getAllInitiationCodesByPatient($health_facility_test_result_table,$patient_username){
			$this->db->select("initiation_code");
			$this->db->from($health_facility_test_result_table);
			$this->db->where('patient_username',$patient_username);
			$this->db->where('paid',0);
			$this->db->order_by('id','DESC');
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function getDateByInitiationCode($health_facility_test_result_table,$initiation_code,$user_name){
			$this->db->select("date");
			$this->db->from($health_facility_test_result_table);
			$this->db->where('initiation_code',$initiation_code);
			$this->db->where('patient_username',$user_name);
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$date = $row->date;
				}
				return $date;
			}else{
				return false;
			}
		}

		public function getTestNumByInitiationCode($health_facility_test_result_table,$initiation_code,$user_name){
			$this->db->select("time");
			$this->db->from($health_facility_test_result_table);
			$this->db->where('initiation_code',$initiation_code);
			$this->db->where('patient_username',$user_name);
			$query = $this->db->get();
			return $query->num_rows();
		}

		public function checkIfInitiationCodeIsValid($health_facility_test_result_table,$code,$user_name){
			$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $code,'patient_username' => $user_name));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getPatientsTotalCostByInitiationCode($health_facility_test_result_table,$code,$user_name){
			$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $code,'patient_username' => $user_name));
			if($query->num_rows() > 0){
				$total_cost = 0;
				foreach($query->result() as $row){
					$cost = $row->price;
					$total_cost += $cost;
				}
				return $total_cost;
			}else{
				return false;
			}
		}

		public function deletePatientBioDataHealthFacility($patient_bio_data_table,$user_id){
			$query = $this->db->delete($patient_bio_data_table,array('user_id' => $user_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getPaidTestsIdsByInitiationCode($health_facility_test_result_table,$initiation_code,$user_name){
			$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $initiation_code,'patient_username' => $user_name));
			if($query->num_rows() > 0){
				$ret_arr = array();
				foreach($query->result() as $row){
					$id = $row->id;
					$ret_arr[] .= $id;
				}
				return $ret_arr;
			}else{
				return false;
			}
		}


		public function getPatientEmail($health_facility_patient_db_table,$user_name,$user_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('user_name' => $user_name,'user_id' => $user_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$email = $row->email;
				}
				return $email;
			}else{
				return false;
			}
		}

		public function getPatientFirstName($health_facility_patient_db_table,$user_name,$user_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('user_name' => $user_name,'user_id' => $user_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$firstname = $row->firstname;
				}
				return $firstname;
			}else{
				return false;
			}
		}

		public function getPatientLastName($health_facility_patient_db_table,$user_name,$user_id){
			$query = $this->db->get_where($health_facility_patient_db_table,array('user_name' => $user_name,'user_id' => $user_id));
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$lastname = $row->lastname;
				}
				return $lastname;
			}else{
				return false;
			}
		}

		public function getPatientAccount($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id,'is_patient' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getTotalPatientTestAmount($health_facility_test_result_table,$code,$user_name){
			$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $code,'patient_username' => $user_name));
			if($query->num_rows() > 0){
				$total_amount = 0;
				foreach($query->result() as $row){
					$amount = $row->price;
					$total_amount += $amount;
				}
				return $total_amount;
			}else{
				return 0;
			}
		}

		public function getTimeByInitiationCode($health_facility_test_result_table,$initiation_code,$user_name){
			$this->db->select("time");
			$this->db->from($health_facility_test_result_table);
			$this->db->where('initiation_code',$initiation_code);
			$this->db->where('patient_username',$user_name);
			$this->db->limit(1);
			$query = $this->db->get();
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$time = $row->time;
				}
				return $time;
			}else{
				return false;
			}
		}

		public function get_set_of_tests_clinical_pathology_by_initiation_code2($health_facility_test_result_table,$user_name,$health_facility_name){
			if($this->db->table_exists($health_facility_test_result_table)){
				
				$this->db->select("initiation_code,date,time");
				$this->db->from($health_facility_test_result_table);
				$this->db->where('patient_locked',1);
				$this->db->where('patient_username',$user_name);
				$this->db->where('facility_name',$health_facility_name);
				$query = $this->db->get();
				if($query->num_rows() > 0){
					return $query->result();
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					main_test_id INT NOT NULL,
					facility_name VARCHAR(100) NOT NULL,
					initiation_code VARCHAR(100) NOT NULL,
					lab_id TEXT NULL,
					
					test_id VARCHAR(1000) NOT NULL,
					receipt_file TEXT NULL,
					patient_name VARCHAR(200) NOT NULL,
					test_name TEXT NOT NULL,
					patient_username VARCHAR(100) NULL,
					price BIGINT(20) NOT NULL,
					ta_time BIGINT(20) NOT NULL,
					date VARCHAR(100) NOT NULL,
					time VARCHAR(100) NOT NULL,
					invalid INT NOT NULL DEFAULT 0,
					paid INT NOT NULL DEFAULT 0,
					date_paid VARCHAR(50) NOT NULL,
					time_paid VARCHAR(50) NOT NULL,
					refund_requested INT NOT NULL DEFAULT 0,
					refund_request_code TEXT NULL,
					payment_initiated INT DEFAULT 0 NOT NULL,
					patient_locked INT DEFAULT 0 NOT NULL,
					registered INT DEFAULT 0

				)';
				if($this->db->query($query_str)){
					$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $initiation_code));
					if($query->num_rows() > 0){
						return $query->result();
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}

		public function get_set_of_tests_clinical_pathology_by_initiation_code1($initiation_code,$health_facility_test_result_table,$user_name,$health_facility_name){
			if($this->db->table_exists($health_facility_test_result_table)){
				$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $initiation_code,'patient_locked' => 1,'patient_username' => $user_name,'facility_name' => $health_facility_name));
				if($query->num_rows() > 0){
					return $query->result();
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					main_test_id INT NOT NULL,
					facility_name VARCHAR(100) NOT NULL,
					initiation_code VARCHAR(100) NOT NULL,
					lab_id TEXT NULL,
					
					test_id VARCHAR(1000) NOT NULL,
					receipt_file TEXT NULL,
					patient_name VARCHAR(200) NOT NULL,
					test_name TEXT NOT NULL,
					patient_username VARCHAR(100) NULL,
					price BIGINT(20) NOT NULL,
					ta_time BIGINT(20) NOT NULL,
					date VARCHAR(100) NOT NULL,
					time VARCHAR(100) NOT NULL,
					invalid INT NOT NULL DEFAULT 0,
					paid INT NOT NULL DEFAULT 0,
					date_paid VARCHAR(50) NOT NULL,
					time_paid VARCHAR(50) NOT NULL,
					refund_requested INT NOT NULL DEFAULT 0,
					refund_request_code TEXT NULL,
					payment_initiated INT DEFAULT 0 NOT NULL,
					patient_locked INT DEFAULT 0 NOT NULL,
					registered INT DEFAULT 0

				)';
				if($this->db->query($query_str)){
					$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $initiation_code));
					if($query->num_rows() > 0){
						return $query->result();
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}

		public function get_set_of_tests_clinical_pathology_by_initiation_code($initiation_code,$health_facility_test_result_table){
			if($this->db->table_exists($health_facility_test_result_table)){
				$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $initiation_code,'patient_locked' => 0));
				if($query->num_rows() > 0){
					return $query->result();
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					main_test_id INT NOT NULL,
					facility_name VARCHAR(100) NOT NULL,
					initiation_code VARCHAR(100) NOT NULL,
					lab_id TEXT NULL,
					
					test_id VARCHAR(1000) NOT NULL,
					receipt_file TEXT NULL,
					patient_name VARCHAR(200) NOT NULL,
					test_name TEXT NOT NULL,
					patient_username VARCHAR(100) NULL,
					price BIGINT(20) NOT NULL,
					ta_time BIGINT(20) NOT NULL,
					date VARCHAR(100) NOT NULL,
					time VARCHAR(100) NOT NULL,
					invalid INT NOT NULL DEFAULT 0,
					paid INT NOT NULL DEFAULT 0,
					date_paid VARCHAR(50) NOT NULL,
					time_paid VARCHAR(50) NOT NULL,
					refund_requested INT NOT NULL DEFAULT 0,
					refund_request_code TEXT NULL,
					payment_initiated INT DEFAULT 0 NOT NULL,
					patient_locked INT DEFAULT 0 NOT NULL,
					registered INT DEFAULT 0

				)';
				if($this->db->query($query_str)){
					$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $initiation_code));
					if($query->num_rows() > 0){
						return $query->result();
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}

		public function get_set_of_tests_clinical_pathology_by_initiation_code_teller($initiation_code,$health_facility_test_result_table){
			if($this->db->table_exists($health_facility_test_result_table)){
				$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $initiation_code,'paid' => 0));
				if($query->num_rows() > 0){
					return $query->result();
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					main_test_id INT NOT NULL,
					facility_name VARCHAR(100) NOT NULL,
					initiation_code VARCHAR(100) NOT NULL,
					lab_id TEXT NULL,
					
					test_id VARCHAR(1000) NOT NULL,
					receipt_file TEXT NULL,
					patient_name VARCHAR(200) NOT NULL,
					test_name TEXT NOT NULL,
					patient_username VARCHAR(100) NULL,
					price BIGINT(20) NOT NULL,
					ta_time BIGINT(20) NOT NULL,
					date VARCHAR(100) NOT NULL,
					time VARCHAR(100) NOT NULL,
					invalid INT NOT NULL DEFAULT 0,
					paid INT NOT NULL DEFAULT 0,
					date_paid VARCHAR(50) NOT NULL,
					time_paid VARCHAR(50) NOT NULL,
					refund_requested INT NOT NULL DEFAULT 0,
					refund_request_code TEXT NULL,
					payment_initiated INT DEFAULT 0 NOT NULL,
					patient_locked INT DEFAULT 0 NOT NULL,
					registered INT DEFAULT 0

				)';
				if($this->db->query($query_str)){
					$query = $this->db->get_where($health_facility_test_result_table,array('initiation_code' => $initiation_code,'paid' => 0));
					if($query->num_rows() > 0){
						return $query->result();
					}else{
						return false;
					}
				}else{
					return false;
				}
			}
		}

		public function updateTestRecordsFields($form_array,$id,$health_facility_test_result_table){
			if($this->db->table_exists($health_facility_test_result_table)){
				$query = $this->db->update($health_facility_test_result_table,$form_array,array('id' => $id));
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					main_test_id INT NOT NULL,
					facility_name VARCHAR(100) NOT NULL,
					initiation_code VARCHAR(100) NOT NULL,
					lab_id TEXT NULL,
					
					test_id VARCHAR(1000) NOT NULL,
					receipt_file TEXT NULL,
					patient_name VARCHAR(200) NOT NULL,
					test_name TEXT NOT NULL,
					patient_username VARCHAR(100) NULL,
					price BIGINT(20) NOT NULL,
					ta_time BIGINT(20) NOT NULL,
					date VARCHAR(100) NOT NULL,
					time VARCHAR(100) NOT NULL,
					invalid INT NOT NULL DEFAULT 0,
					paid INT NOT NULL DEFAULT 0,
					date_paid VARCHAR(50) NOT NULL,
					time_paid VARCHAR(50) NOT NULL,
					refund_requested INT NOT NULL DEFAULT 0,
					refund_request_code TEXT NULL,
					payment_initiated INT DEFAULT 0 NOT NULL,
					patient_locked INT DEFAULT 0 NOT NULL,
					registered INT DEFAULT 0

				)';
				if($this->db->query($query_str)){
					$query = $this->db->update($health_facility_test_result_table,$form_array,array('id' => $id));
					if($query){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}	
		}

		public function updateTestRecordsFieldsDemo($form_array,$id,$health_facility_test_result_table){
			if($this->db->table_exists($health_facility_test_result_table)){
				$query = $this->db->update($health_facility_test_result_table,$form_array,array('lab_id' => $id));
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				$query_str = 'CREATE TABLE ' .$health_facility_test_result_table.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					main_test_id INT NOT NULL,
					facility_name VARCHAR(100) NOT NULL,
					initiation_code VARCHAR(100) NOT NULL,
					lab_id TEXT NULL,
					
					test_id VARCHAR(1000) NOT NULL,
					receipt_file TEXT NULL,
					patient_name VARCHAR(200) NOT NULL,
					test_name TEXT NOT NULL,
					patient_username VARCHAR(100) NULL,
					price BIGINT(20) NOT NULL,
					ta_time BIGINT(20) NOT NULL,
					date VARCHAR(100) NOT NULL,
					time VARCHAR(100) NOT NULL,
					invalid INT NOT NULL DEFAULT 0,
					paid INT NOT NULL DEFAULT 0,
					date_paid VARCHAR(50) NOT NULL,
					time_paid VARCHAR(50) NOT NULL,
					refund_requested INT NOT NULL DEFAULT 0,
					refund_request_code TEXT NULL,
					payment_initiated INT DEFAULT 0 NOT NULL,
					patient_locked INT DEFAULT 0 NOT NULL,
					registered INT DEFAULT 0

				)';
				if($this->db->query($query_str)){
					$query = $this->db->update($health_facility_test_result_table,$form_array,array('lab_id' => $id));
					if($query){
						return true;
					}else{
						return false;
					}
				}else{
					return false;
				}
			}	
		}

		public function testInsert($form_array){
			$query = $this->db->insert('test',$form_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function updateClinicalPathologyTests($form_array,$id,$test_table_name){
			if($this->db->table_exists($test_table_name)){
				$query = $this->db->update($test_table_name,$form_array,array('id' => $id));
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		public function checkIfTestNativeIdExists($id,$health_facility_test_table_name){
			$query = $this->db->get_where($health_facility_test_table_name,array('id' => $id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function deleteTest($id,$health_facility_test_table_name){
			$query = $this->db->delete($health_facility_test_table_name,array('id' => $id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function addClinicalPathologyTests($form_array,$test_table_name){
			if($this->db->table_exists($test_table_name)){
				$query = $this->db->insert($test_table_name,$form_array);
				if($query){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		public function updatePatientTestFields($form_array,$test_table_name,$lab_id){			
			$query = $this->db->update($test_table_name,$form_array,array('lab_id' => $lab_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getLabId($health_facility_main_test_result_table,$form_array){
			$query = $this->db->get_where($health_facility_main_test_result_table,$form_array);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$lab_id = $row->lab_id;
				}
				return $lab_id;
			}
		}

		public function createTableHeaderString($id,$string){
			return substr(strtolower(preg_replace('/[^A-Za-z0-9\-s+]/', '', $id.'_'.$string)),0,10);
		}

		public function createTestTableHeaderString($id,$string){
			return substr(strtolower(preg_replace('/[^A-Za-z0-9\-s+]/', '', 't'.$id.'_'.$string)),0,20);
		}

		public function createTestResultTableHeaderString($id,$string){
			return substr(strtolower(preg_replace('/[^A-Za-z0-9\-s+]/', '', 'tr'.$id.'_'.$string)),0,20);
		}

		public function createTestPatientTableHeaderString($id,$string){
			return substr(strtolower(preg_replace('/[^A-Za-z0-9\-s+]/', '', 'tpb'.$id.'_'.$string)),0,20);
		}

		public function createTestResultMainTableHeaderString($id,$string){
			return substr(strtolower(preg_replace('/[^A-Za-z0-9\-s+]/', '', 'tpbm'.$id.'_'.$string)),0,20);
		}

		public function createpatientBioDataTableString($id,$string){
			return substr(strtolower(preg_replace('/[^A-Za-z0-9\-s+]/', '', 'pbd'.$id.'_'.$string)),0,20);
		}

		public function createAssignedFacilitiesString($affiliated_facilities,$table_name){
			return $affiliated_facilities .',' . $table_name;;
		}

		public function getNewAffiliatedFacilitiesString($table_name,$affiliated_facilities_arr){
			$index = array_search($table_name,$affiliated_facilities_arr);
			$affiliated_facilities = "";
			unset($affiliated_facilities_arr[$index]);
			foreach ($affiliated_facilities_arr as $key => $value) {
	            if(empty($value)) {
	               unset($affiliated_facilities_arr[$key]);
	            }
	        }
	      	if(!empty($affiliated_facilities_arr)){
	      		$affiliated_facilities = implode(",", $affiliated_facilities_arr);
	      	}
	     	return $affiliated_facilities;
	    } 

	    public function checkIfBioDataHasBeenEnteredByPatientFacilityTable($patient_bio_data_table,$user_name,$user_id){
	    	if($this->db->table_exists($patient_bio_data_table)){
	    		$query = $this->db->get_where($patient_bio_data_table,array('user_name' => $user_name,'user_id' => $user_id));
	    		if($query->num_rows() == 1){
	    			return true;
	    		}else{
	    			return false;
	    		}
	    	}else{
	    		return false;
	    	}
	    }

	    public function checkIfBioDataHasBeenEnteredByPatient($user_name,$user_id){	    	
    		$query = $this->db->get_where('patients',array('user_name' => $user_name,'user_id' => $user_id,'data_entered' => 1));
    		if($query->num_rows() == 1){
    			return true;
    		}else{
    			return false;
    		}
	    }	

	    public function createPatientBioDataTable($table_name){
	    	if($this->db->table_exists($table_name)){
	    		return true;
	    	}else{
		    	$query_str = 'CREATE TABLE ' .$table_name.' (
					id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					user_id INT NOT NULL,
					user_name VARCHAR(50) NOT NULL,
					firstname VARCHAR(50) NOT NULL,
					lastname VARCHAR(50) NOT NULL,
					dob VARCHAR(50) NOT NULL,
					age INT NOT NULL,
					age_unit VARCHAR(50) NOT NULL,
					sex VARCHAR(50) NOT NULL,
					fasting INT NOT NULL,
					race VARCHAR(50) NOT NULL,
					mobile_no BIGINT NOT NULL,
					email VARCHAR(50) NOT NULL,
					present_medications TEXT NOT NULL,
					height INT NOT NULL,
					weight INT NOT NULL,
					address TEXT NOT NULL,
					date VARCHAR(50) NOT NULL,
					time VARCHAR(50) NOT NULL
				)';
				if($this->db->query($query_str)){
					return true;	
				}else{
					return false;
				}
			}	
	    }

	    public function getPatientData($user_id,$user_name){	    	
    		$query = $this->db->get_where('patients',array('user_id' => $user_id,'user_name' => $user_name));
    		if($query->num_rows() == 1){
    			return $query->result();
    		}else{
    			return false;
    		}	    		
	    }

	    public function createPatientBioData($form_array,$patient_bio_data_table){
	    	$query = $this->db->insert($patient_bio_data_table,$form_array);
	    	if($query){
	    		return true;
	    	}else{
	    		return false;
	    	}
	    }

	    public function updatePatientBioDataPatientTable($user_id,$user_name,$form_array2){
	    	$query = $this->db->update('patients',$form_array2,array('user_name' => $user_name,'user_id' => $user_id));
	    	if($query){
	    		return true;
	    	}else{
	    		return false;
	    	}
	    }

	    public function updatePatientBioData($form_array,$patient_bio_data_table,$user_id){
	    	$query = $this->db->update($patient_bio_data_table,$form_array,array('user_id' => $user_id));
	    	if($query){
	    		return true;
	    	}else{
	    		return false;
	    	}
	    }

	    public function getPatientName($patient_bio_data_table,$user_id,$user_name){
	    	$query = $this->db->get_where($patient_bio_data_table,array('user_id' => $user_id,'user_name' => $user_name));
	    	if($query->num_rows() == 1){
	    		foreach($query->result() as $row){
	    			$firstname = $row->firstname;
	    			$lastname = $row->lastname;
	    			$full_name = $firstname . ' ' . $lastname;
	    		}
	    		return $full_name;
	    	}else{
	    		return false;
	    	}
	    }

	    public function getPatientBioDataTable($patient_bio_data_table,$user_id,$user_name){
	    	$query = $this->db->get_where($patient_bio_data_table,array('user_id' => $user_id,'user_name' => $user_name));
	    	if($query->num_rows() == 1){
	    		return $query->result();
	    	}else{
	    		return false;
	    	}
	    }

		public function renameFacilityTable($health_facility_table_name,$new_facility_table_name){
			$query = $this->db->query("RENAME TABLE `" . $health_facility_table_name . "` TO `" . $new_facility_table_name . "`");
			if($query){
				return true;
			}else{
				return true;
			}
		}
		public function addTestMainResult($form_array,$health_facility_main_test_result_table){
			$query = $this->db->insert($health_facility_main_test_result_table,$form_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfThisTestHasBeenAdded($health_facility_main_test_result_table,$test_name,$lab_id){
			$query = $this->db->get_where($health_facility_main_test_result_table,array('test_name' => $test_name,'lab_id' => $lab_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfThisTestHasBeenAdded2($health_facility_main_test_result_table,$test_name,$lab_id,$this_id){
			$query = $this->db->get_where($health_facility_main_test_result_table,array('test_name' => $test_name,'lab_id' => $lab_id,'super_test_id' => $this_id));
			if($query->num_rows() > 0){
				return true;
			}else{
				return false;
			}
		}

		public function getTestResultId($health_facility_main_test_result_table,$test_name,$lab_id){
			$query = $this->db->get_where($health_facility_main_test_result_table,array('test_name' => $test_name,'lab_id' => $lab_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$id = $row->id;
					return $id;
				}
			}else{
				return false;
			}
		}

		public function getInitiatedPatientByLabId($health_facility_test_result_table,$lab_id){
			$query = $this->db->get_where($health_facility_test_result_table,array('lab_id' => $lab_id),1);
			if($query->num_rows() == 1){
				return $query->result();
			}else{
				return false;
			}
		}

		public function update_table_name_health_facility($health_facility_id,$table_name){
			$query = $this->db->update('health_facility',array('table_name' => $table_name),array('id' => $health_facility_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function updateAllHealthFacilityTableRows($form_array,$table_name){
			$query = $this->db->update($table_name,$form_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		//Check If User Exists
		public function userExists($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function userExistsAdmin($user_name){
			$query = $this->db->get_where('users',array('user_name' => $user_name,'is_admin' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}


		//Check If User Exists Phone
		public function userExistsPhone($phone){
			$query = $this->db->get_where('users');
			$ret = false;
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$user_phone = "+" . $row->phone_code . "" .$row->phone;
					// echo $user_phone;
					if($user_phone == $phone){
						$ret = true;
						break;
					}
				}
			}else{
				return false;
			}
			return $ret;
		}

		public function getUserNameByFullPhone($phone){
			$query = $this->db->get_where('users');
			$ret = false;
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$user_name = $row->user_name;
					$user_phone = "+" . $row->phone_code . "" .$row->phone;
					// echo $user_phone;
					if($user_phone == $phone){
						$ret = $user_name;
						break;
					}
				}
			}else{
				return false;
			}
			return $ret;
		}

		//Verify Password
		public function password_verify($user_name,$hashed){
			$query = $this->db->get_where('users',array('user_name' => $user_name,'hashed' => $hashed));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		//Check If Sub Admin Exists
		public function checkIfSubAdminExists($health_facility_table_name,$second_addition){
			$query = $this->db->get_where($health_facility_table_name,array('dept' => $second_addition,'position' => 'sub_admin' , 'is_admin' => 1));
			if($query->num_rows() == 1){
				print_r($query->result());
				return true;
			}else{
				return false;
			}
		}

		public function sendMessage($form_array){
			$query = $this->db->insert('notif',$form_array);
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function sendMessageCustom($form_array){
			$query = $this->db->insert('notif',$form_array);
			if($query){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}

		public function getAdminsUsername($health_facility_table_name){
			$query = $this->db->get_where($health_facility_table_name,array('position' => 'admin'));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$admin_username = $row->user_name;
				}
				return $admin_username;
			}
		}

		public function checkIfThisStageIsFull3($type,$stage){
			// echo $stage;
			$previous_stage = $stage - 1;
			
			$query = $this->db->get_where('great_nigeria1',array('stage' => $stage));
			$no_in_child_stage = $query->num_rows();
			$query = $this->db->get_where('great_nigeria1',array('stage' => $previous_stage));
			$no_in_current_stage = $query->num_rows();
			// echo $no_in_child_stage."<br>";
			// echo $no_in_current_stage."<br>";
			$total_amount_supposed_to_be_in_current_stage = $no_in_current_stage * 2;
			// echo $total_amount_supposed_to_be_in_current_stage."<br>";
			if($no_in_child_stage == $total_amount_supposed_to_be_in_current_stage){

				return true;
			}else{
				// echo "string";
				return false;
			}
			
		}

		public function recycleNewNigeria4($record_id,$form_array){
			// echo "string";
			//Get Record Id Info
			$query = $this->db->get_where('great_nigeria1',array('id' => $record_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$main_user_id = $row->user_id;
					$under = $row->under;
					$stage = $row->stage;
				}
				$childrens_stage = $form_array['stage'];
				if($this->checkIfThisStageIsFull3('great_nigeria1',$childrens_stage)){
					// echo "string";
					//Stage Is Full Add To A New Stage Under The First Guy In The Previous Stage
					$new_stage = $stage + 2;
					$query = $this->db->get_where('great_nigeria1',array('stage' => $childrens_stage),1);
					foreach($query->result() as $row){
						$id = $row->id;
						$user_id = $row->user_id;						
					}
					$form_array['stage'] = $new_stage;
					$form_array['under'] = $id;
					// print_r($form_array);
					unset($form_array['referred_by']);
					// print_r($form_array);
					$form_array = array_merge($form_array,array('recycled' => 1));
					$query = $this->db->insert('great_nigeria1',$form_array);
					if($query){
						$this->creditUserGreatNigeria($main_user_id,4000,"great_nigeria");
						return true;
					}else{
						return false;
					}
				}else{
					//Stage Is Not Full Add To The Present Stage Under The Next Guy In This Stage. i.e first guy under the next guy to be added under
					$new_stage = $stage + 1;
					// Get The Last Guy In Previous Stage With 3 under Him. Then Recycle To The Next Available Guy With No One Under Him.
					$query = $this->db->get_where('great_nigeria1',array('stage' => $stage));
					if($query->num_rows() > 0){
						foreach($query->result() as $row){
							$id = $row->id;
							$query = $this->db->get_where('great_nigeria1',array('under' => $id,'stage' => $new_stage));
							if($query->num_rows() < 2){
								$this->session->set_userdata('id1',$id);
								break;
							}
						}
						$form_array['stage'] = $new_stage;
						$form_array['under'] = $this->session->id1;
						unset($_SESSION['id1']);
						$form_array = array_merge($form_array,array('recycled' => 1));
						$query = $this->db->insert('great_nigeria1',$form_array);
						if($query){
							$this->creditUserGreatNigeria($main_user_id,4000,"great_nigeria");
							return true;
						}else{
							return false;
						}
					}
				}
			}
		}

		

		public function performAddingGreatNigeria2($user_id,$date,$time){
			//If Referred Is None Set Reference to Null
			$query = $this->db->get_where('users',array('is_admin' => 1,'user_name' => 'admin'),1);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sponsor_income = $row->sponsor_income;
					$total_income = $row->total_income;
				}

				//Form Array For Inserting New Records
				$form_array = array(
					'user_id' => $user_id,
					'stage' => 0,
					'under' => NULL,
					
					'date' => $date,
					'time' => $time
				);
				//Get All New Nigeria Records
				$query = $this->db->get('great_nigeria1');
				//Get If Rows Are Greater Than 0.
				if($query->num_rows() > 0){
					//Select The Max Stage
					$this->db->select_max('stage');
					$query = $this->db->get('great_nigeria1',1);
					if($query->num_rows() == 1){
						foreach($query->result() as $row){
							// $id = $row->id;
							$stage = $row->stage;
						}
						//If Stage == 0
						if($stage == 0){
							//Just Add This Guy Under The First Guy With Stage Of Stage + 1
							$new_stage = $stage + 1;
							$under = $this->getIdByStage0('great_nigeria1',$stage);
							$form_array['under'] = $under;
							$form_array['stage'] = $new_stage;
							$query = $this->db->insert('great_nigeria1',$form_array);
							if($query){
								return true;
							}else{
								return false;
							}
						}else{
							//Get Next Available Space To Insert This Guy In

							//Check If There Is More Space In This Stage
							//Get The Last Guy In This Stage To See Where To Place This Guy
							$this->db->select("*");
							$this->db->from("great_nigeria1");
							$this->db->where("stage",$stage);
							$this->db->order_by("id","DESC");
							$this->db->limit(1);
							$query = $this->db->get();
							if($query->num_rows() == 1){
								foreach($query->result() as $row){
									$id = $row->id;
									$user_id = $row->user_id;
									$under = $row->under;
								}
								// $previous_stage = $stage - 1;
								$query = $this->db->get_where('great_nigeria1',array('under' => $under));
								$num_under_the_guy_above = $query->num_rows();
								if($query->num_rows() > 0){

									//If This Guy Remains One To Full
									if($num_under_the_guy_above == 1){
										//Then We Add This Guy And Recycle The Oga At The Top
										$form_array['under'] = $under;
										$form_array['stage'] = $stage;
										// echo $form_array['stage'];
										$query = $this->db->insert('great_nigeria1',$form_array);
										if($query){
											if($this->recycleNewNigeria4($under,$form_array)){
												// echo "string";
												return true;
											}else{
												return false;
											}
										}else{
											return false;
										}
									}else{//else That Is This Guy Just Hs One Under Him
										//Then We Just Him Normally
										//Stage Remains The Same
										//You Add Him Under The Oga At The Top
										$form_array['under'] = $under;
										$form_array['stage'] = $stage;
										$query = $this->db->insert('great_nigeria1',$form_array);
										if($query){
											return true;
										}else{
											return false;
										}
									}
								}
							}
						}
					}
				}else{
					$query = $this->db->insert('great_nigeria1',$form_array);
					if($query){
						return true;
					}else{
						return false;
					}
				}
			}	
		}

		public function creditAdminGreatNigeria($amount,$type){
			$query = $this->db->get_where('users',array('is_admin' => 1,'user_name' => 'admin'),1);
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$sponsor_income = $row->sponsor_income;
					$total_income = $row->total_income;
					$new_nigeria_income = $row->new_nigeria_income;
					$great_nigeria_income = $row->great_nigeria_income;
				}
				if($type == "sponsor"){
					$new_sponsor_income = $sponsor_income + $amount;
					$new_total_income = $total_income + $amount;
					$query = $this->db->update('users',array('sponsor_income' => $new_sponsor_income,'total_income' => $new_total_income),array('is_admin' => 1));
					if($query){
						return true;
					}else{
						return false;
					}
				}elseif($type == "great_nigeria"){
					$great_nigeria_income = $great_nigeria_income + $amount;
					$new_total_income = $total_income + $amount;
					$query = $this->db->update('users',array('great_nigeria_income' => $great_nigeria_income,'total_income' => $new_total_income),array('is_admin' => 1));
					if($query){
						return true;
					}else{
						return false;
					}
				}
				
			}		
		}

		public function creditUserGreatNigeria($user_id,$amount,$reason){
			$query = $this->db->get_where('users',array('id' => $user_id));
			if($query->num_rows() == 1){
				$form_array = array();
				foreach($query->result() as $row){
					$new_nigeria_income = $row->new_nigeria_income;
					$great_nigeria_income = $row->great_nigeria_income;
					$sponsor_income = $row->sponsor_income;
					$total_income = $row->total_income;
				}
				if($reason == "sponsor"){
					$sponsor_income = $sponsor_income + $amount;
					$total_income = $total_income + $amount;
					$form_array = array(
						'sponsor_income' => $sponsor_income,
						'total_income' => $total_income
					);
				}elseif($reason == "great_nigeria"){
					$great_nigeria_income = $great_nigeria_income + $amount;
					$total_income = $total_income + $amount;
					$form_array = array(
						'great_nigeria_income' => $great_nigeria_income,
						'total_income' => $total_income
					);
				}

				$this->db->update('users',$form_array,array('id' => $user_id));

			}
		}

		public function checkIfThisStageIsFull2($type,$stage){
			if($type == "great_nigeria1"){
				$table = "great_nigeria";
			}elseif($type == "great_nigeria2"){
				$table = "great_nigeria1";
			}
			$previous_stage = $stage - 1;
			if($table == "great_nigeria"){
				$query = $this->db->get_where($table,array('stage' => $stage));
				$no_in_child_stage = $query->num_rows();
				$query = $this->db->get_where($table,array('stage' => $previous_stage));
				$no_in_current_stage = $query->num_rows();
				$total_amount_supposed_to_be_in_current_stage = $no_in_current_stage * 3;
				if($no_in_child_stage == $total_amount_supposed_to_be_in_current_stage){
					return true;
				}else{
					return false;
				}
			}
		}

		public function recycleNewNigeria3($record_id,$form_array){
			//Get Record Id Info

			$query = $this->db->get_where('great_nigeria',array('id' => $record_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$main_user_id = $row->user_id;
					$under = $row->under;
					$stage = $row->stage;
				}
				$childrens_stage = $form_array['stage'];
				$this->creditUserGreatNigeria($main_user_id,3000,"great_nigeria");
				$this->creditAdminGreatNigeria(1000,"sponsor");
				if($this->checkIfThisStageIsFull2('great_nigeria1',$childrens_stage)){
					//Stage Is Full Add To A New Stage Under The First Guy In The Previous Stage
					$new_stage = $stage + 2;
					$query = $this->db->get_where('great_nigeria',array('stage' => $childrens_stage),1);
					foreach($query->result() as $row){
						$id = $row->id;
						$user_id = $row->user_id;						
					}
					$form_array['stage'] = $new_stage;
					$form_array['under'] = $id;
					$form_array['referred_by'] = NULL;
					$form_array = array_merge($form_array,array('recycled' => 1));
					$query = $this->db->insert('great_nigeria',$form_array);
					if($query){
						if($this->performAddingGreatNigeria2($main_user_id,$form_array['date'],$form_array['time'])){
							return true;
						}
					}else{
						return false;
					}
				}else{
					//Stage Is Not Full Add To The Present Stage Under The Next Guy In This Stage. i.e first guy under the next guy to be added under
					$new_stage = $stage + 1;
					//Get The Last Guy In Previous Stage With 3 under Him. Then Recycle To The Next Available Guy With No One Under Him.
					$query = $this->db->get_where('great_nigeria',array('stage' => $stage));
					if($query->num_rows() > 0){
						foreach($query->result() as $row){
							$id = $row->id;
							$query = $this->db->get_where('great_nigeria',array('under' => $id,'stage' => $new_stage));
							if($query->num_rows() < 3){
								$this->session->set_userdata('id',$id);
								break;
							}
						}
						$form_array['stage'] = $new_stage;
						$form_array['under'] = $this->session->id;
						unset($_SESSION['id']);
						$form_array['referred_by'] = NULL;
						$form_array = array_merge($form_array,array('recycled' => 1));
						$query = $this->db->insert('great_nigeria',$form_array);
						if($query){
							if($this->performAddingGreatNigeria2($main_user_id,$form_array['date'],$form_array['time'])){
								return true;
							}
						}else{
							return false;
						}
					}
				}
			}
		}

		

		public function performAddingGreatNigeria1($user_id,$referred_by,$date,$time,$automatic = FALSE){
			if($automatic){
				$automatic = 1;
			}else{
				$automatic = 0;
			}

			//If Referred Is None Set Reference to Null
			if(!$this->checkIfUserIsAdmin()){
				$query = $this->db->get_where('users',array('is_admin' => 1,'user_name' => 'admin'),1);
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$sponsor_income = $row->sponsor_income;
						$total_income = $row->total_income;
					}

					if($referred_by == "none"){
						$referred_by = NULL;
						//Credit Admin With 800 For Referral
						$new_sponsor_income = $sponsor_income + 1000;
						$new_total_income = $total_income + 1000;
						$query = $this->db->update('users',array('sponsor_income' => $new_sponsor_income,'total_income' => $new_total_income),array('is_admin' => 1));
						if($query){

						}
					}else{
						//Credit Referred By With 800
						$this->creditUserGreatNigeria($referred_by,800,"sponsor");
						$new_sponsor_income = $sponsor_income + 200;
						$new_total_income = $total_income + 200;
						$query = $this->db->update('users',array('sponsor_income' => $new_sponsor_income,'total_income' => $new_total_income),array('is_admin' => 1));
						if($query){

						}
					}
					//Form Array For Inserting New Records
					$form_array = array(
						'user_id' => $user_id,
						'stage' => 0,
						'under' => NULL,
						'referred_by' => $referred_by,
						'date' => $date,
						'time' => $time,
						'automatic' => $automatic
					);
					//Get All New Nigeria Records
					$query = $this->db->get('great_nigeria');
					//Get If Rows Are Greater Than 0.
					if($query->num_rows() > 0){
						//Select The Max Stage
						$this->db->select_max('stage');
						$query = $this->db->get('great_nigeria',1);
						if($query->num_rows() == 1){
							foreach($query->result() as $row){
								// $id = $row->id;
								$stage = $row->stage;
							}
							//If Stage == 0
							if($stage == 0){
								//Just Add This Guy Under The First Guy With Stage Of Stage + 1
								$new_stage = $stage + 1;
								$under = $this->getIdByStage0('great_nigeria',$stage);
								$form_array['under'] = $under;
								$form_array['stage'] = $new_stage;
								$query = $this->db->insert('great_nigeria',$form_array);
								if($query){
									return true;
								}else{
									return false;
								}
							}else{
								//Get Next Available Space To Insert This Guy In

								//Check If There Is More Space In This Stage
								//Get The Last Guy In This Stage To See Where To Place This Guy
								$this->db->select("*");
								$this->db->from("great_nigeria");
								$this->db->where("stage",$stage);
								$this->db->order_by("id","DESC");
								$this->db->limit(1);
								$query = $this->db->get();
								if($query->num_rows() == 1){
									foreach($query->result() as $row){
										$id = $row->id;
										$user_id = $row->user_id;
										$under = $row->under;
									}
									// $previous_stage = $stage - 1;
									$query = $this->db->get_where('great_nigeria',array('under' => $under));
									$num_under_the_guy_above = $query->num_rows();
									if($query->num_rows() > 0){

										//If This Guy Remains One To Full
										if($num_under_the_guy_above == 2){
											//Then We Add This Guy And Recycle The Oga At The Top
											$form_array['under'] = $under;
											$form_array['stage'] = $stage;
											$query = $this->db->insert('great_nigeria',$form_array);
											if($query){
												if($this->recycleNewNigeria3($under,$form_array)){
													return true;
												}else{
													return false;
												}
											}else{
												return false;
											}
										}else{//else That Is This Guy Just Hs One Under Him
											//Then We Just Him Normally
											//Stage Remains The Same
											//You Add Him Under The Oga At The Top
											$form_array['under'] = $under;
											$form_array['stage'] = $stage;
											$query = $this->db->insert('great_nigeria',$form_array);
											if($query){
												return true;
											}else{
												return false;
											}
										}
									}
								}
							}
						}
					}else{
						$query = $this->db->insert('great_nigeria',$form_array);
						if($query){
							return true;
						}else{
							return false;
						}
					}
				}	
			}
		}

		public function getTotalNoOfDirectSubscriptions($user_id,$type){
			if($type == "new_nigeria"){
				$query = $this->db->get_where('new_nigeria',array('user_id' => $user_id));
				return $query->num_rows();
			}elseif($type = "great_nigeria"){
				$query = $this->db->get_where('great_nigeria',array('user_id' => $user_id));
				return $query->num_rows();
			}
		}

		public function getAllUsersEmails(){
			$ret = array();
			$query = $this->db->get_where('users',array('is_admin' => 0));
			if($query->num_rows() > 0){
				foreach($query->result() as $row) {
					$ret[] .= $row->email;
				}
			}
			return $ret;
		}

		public function getUserIdByEmail($email){
			$query = $this->db->get_where('users',array('email' => $email));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$user_id = $row->id;
				}
				return $user_id;
			}else{
				return false;
			}
		}



		public function sendSms($all_mobiles,$message){
			$mobiles = implode(",", $all_mobiles);
			echo $message;
			$user_name = "Meet%20Global%20Resources";
			$password = "44precious44";
			echo "http://goldsms247.com/components/com_spc/smsapi.php?username=". $user_name ."&password=". $password ."&sender=Meet&recipient=". $mobiles ."&message=".$message;
			$response = $this->curl("http://goldsms247.com/components/com_spc/smsapi.php?username=". $user_name ."&password=". $password ."&sender=Meet&recipient=". $mobiles ."&message=".$message,FALSE);
			echo $response;
			if($response !== "" && $response !== "2904" && $response !== "2905" && $response !== "2906"&& $response !== "2907" && $response !== "2908" && $response !== "2909"){
				return true;
			}
		}

		public function sendAdminEmail($recepient_arr,$subject,$message,$otp = FALSE){
			if($otp){


				//Then Filter It To Those Who Have Email Notifications Enabled
				// $recepient_arr = $this->filterSubEmails($recepient_arr);
				if(count($recepient_arr) > 0){

					if($message !== ""){
						$message = "<h3 style='text-transform:capitalize;'>" . $message . "</h3>";
						$year = date("Y");
						$message .= "<h5><a href='Sabicapitalresources.com'>Sabicapital Resources</a> &copy; " . $year . ". All Rights Reserved</h5>";
					}
					if($_SERVER['SERVER_NAME'] !== "localhost"){

						if(is_array($recepient_arr)){

							$mail = $this->phpmailer_lib->load();
        
					        // SMTP configuration
					        $mail->isSMTP();

					        // $mail->Host     = 'smtp.gmail.com';
					        // $mail->SMTPAuth = true;
					        // $mail->Username = 'ikechukwunwogo@gmail.com';
					        // $mail->Password = 'programmer';
					        // $mail->SMTPSecure = 'tsl';
					        // $mail->Port     = 587;
					        
					        // $mail->setFrom('ikechukwunwogo@gmail.com', 'Meet Global Resources');

					        // $mail->Host     = 'smtp.gmail.com';
					        // $mail->SMTPAuth = true;
					        // $mail->Username = 'meetgresources@gmail.com';
					        // $mail->Password = 'dave1614.';
					        // $mail->SMTPSecure = 'tsl';
					        // $mail->Port     = 587;
					        
					        // $mail->setFrom('meetgresources@gmail.com', 'Meet Global Resources');


					        $mail->Host = 'localhost';  // Specify main and backup SMTP servers
						    $mail->SMTPAuth = true;                               // Enable SMTP authentication
						    $mail->Username = 'mgr@Sabicapitalresources.com';                 // SMTP username
						    $mail->Password = 'dave1614._';                           // SMTP password
						    $mail->SMTPSecure = 'pop3';                            // Enable TLS encryption, `ssl` also accepted
						    $mail->Port = 25;                                    // TCP port to connect to
					        
					        $mail->setFrom('mgr@Sabicapitalresources.com', 'Meet Global Resources');
					        // $mail->addReplyTo('info@example.com', 'CodexWorld');
					        
					        // Add a recipient
					        for($i = 0; $i < count($recepient_arr); $i++){
						    	$to_email = $recepient_arr[$i];
						    	// if($this->checkIfEmailHasNotifEnabled($to_email)  && $this->checkIfEmailNotifIsEnabled()){
								    $mail->addAddress($to_email);     // Add a recipient
								// }
							}
					        
					      
					        // Email subject
					        $mail->Subject = $subject;
					        
					        // Set email format to HTML
					        $mail->isHTML(true);
					        
					        // Email body content
					        // $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
					        //     <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
					        $mail->Body = $message;
					        
					        // Send email
					        if(!$mail->send()){
					            // echo 'Message could not be sent.';
					            // echo 'Mailer Error: ' . $mail->ErrorInfo;
					            return false;
					        }else{
					            return true;
					        }
						}
					}else{
						return true;
					}
				}else{
					return true;
				}
			}else{
				return true;
			}	
		}

		public function getAllUsersInfoJson(){
			$ret = array();
			
			$this->db->select("*");
			$this->db->from("users");
			$this->db->where("is_admin",0);
			$this->db->order_by("user_name","ASC");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				foreach($query->result() as $row){
					$user_info = array(
						'user_id' => $row->id,
						'user_name' => $row->user_name,
						'full_name' => $row->full_name,
						'email' => $row->email,
						'phone' => $row->phone,
						'phone_code' => $row->phone_code,
						'logo' => $row->logo,
						'cover_photo' => $row->cover_photo,
						'bio' => $row->bio,
						'country' => $this->getCountryById($row->country_id),
						'address' => $row->address,
						'slug' => $row->slug,
						'post_num' => $this->getUserTotalPostsNum($row->id),
						'posts' => $this->get_user_posts($row->id),
						'followers_num' => $this->socialMediaFormatNum($this->getUserTotalFollowersNum($row->id)),
						'following_num' => $this->socialMediaFormatNum($this->getUserTotalFollowingNum($row->id)),
						'followers' => $this->getUserTotalFollowersUserName($row->id),
						'following' => $this->getUserTotalFollowingUserName($row->id),
						'last_activity' => $row->last_activity
					);
					if(is_array($user_info['posts'])){
						

						foreach($user_info['posts'] as $a){
							// echo $j;
							$images = $a->images;
							$likes = $a->likes;
							if($images !== ""){
								$a->images = explode(",", $images);
								for($b = 0; $b < count($a->images); $b++){
									$a->images[$b] = base_url('assets/images/'.$b);
								}
								
							}else{
								$a->images = NULL;
							}

							if($likes != ""){
								$a->likes = explode(",", $likes);
								for($j = 0; $j < count($a->likes); $j++){
									$a->likes[$j] = $this->getUserNameById($a->likes[$j]);
								}
								$a->likes_num = count($a->likes);
							}else{
								$a->likes = NULL;
								$a->likes_num = 0;
							}

							$a->post_date = $this->getSocialMediaTime($a->date,$a->time);
						}
					}else{
						$user_info['posts'] = null;
					}
					if(!is_null($row->logo)){
						$user_info['logo'] = base_url('assets/images/'.$row->logo);
					}

					if(!is_null($row->cover_photo)){
						$user_info['cover_photo'] = base_url('assets/images/'.$row->cover_photo);
					}
					$ret[] = $user_info;
				}
				return $ret;
			}else{
				return false;
			}
		}

		public function getAllPosts(){
			$this->db->select("*");
			$this->db->from("posts");
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->result();
			}else{
				return false;
			}
		}

		public function updatePost($form_array,$post_id){
			$query = $this->db->update('posts',$form_array,array('id' => $post_id));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function getIfPostIsValid($id,$slug){
			$query = $this->db->get_where('posts',array('id' => $id,'slug' => $slug));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function getPostSlugById($post_id){
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$slug = $row->slug;
				}
				return $slug;
			}else{
				return false;
			}
		}

		public function checkIfEmailHasNotifEnabled($email){
			$query = $this->db->get_where('users',array('email' => $email,'email_enabled' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfSmsHasNotifEnabled($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id,'sms_enabled' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfUserHasNotifEnabled($user_id){
			$query = $this->db->get_where('users',array('id' => $user_id,'notif_enabled' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}		
			

		public function filterSubEmails($all_emails){
			$ret = array();
			if(is_array($all_emails)){
				for($i = 0; $i < count($all_emails); $i++){
					$email = $all_emails[$i];
					if($this->checkIfEmailHasNotifEnabled($email)){
						$ret[] .= $email;
					}
				}
				return $ret;
			}else{
				return false;
			}
		}

		public function filterSubSms($all_mobiles,$all_ids){
			$ret = array();
			if(is_array($all_mobiles)){
				for($i = 0; $i < count($all_mobiles); $i++){
					$mobile = $all_mobiles[$i];
					$id = $all_ids[$i];
					if($this->checkIfSmsHasNotifEnabled($id)){
						$ret[] .= $mobile;
					}
				}
				return $ret;
			}else{
				return false;
			}
		}

		public function filterSubIds($all_ids){
			$ret = array();
			if(is_array($all_ids)){
				for($i = 0; $i < count($all_ids); $i++){					
					$id = $all_ids[$i];
					if($this->checkIfUserHasNotifEnabled($id)){
						$ret[] .= $id;
					}
				}
				return $ret;
			}else{
				return false;
			}
		}


		public function checkIfEmailNotifIsEnabled(){
			$query = $this->db->get_where('users',array('is_admin' => 1,'admin_email_enabled' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function checkIfSmsNotifIsEnabled(){
			$query = $this->db->get_where('users',array('is_admin' => 1,'admin_sms_enabled' => 1));
			if($query->num_rows() == 1){
				return true;
			}else{
				return false;
			}
		}

		public function sendNotif($user_id,$title,$message,$type,$post_id = "",$followed_id = NULL){
			$followers = $this->getUserTotalFollowers($this->getUserIdWhenLoggedIn());
			// print_r($followers);
			if(is_array($followers)){
				$all_emails = array();
				$all_mobiles = array();
				$all_ids = array();
				for($i = 0; $i < count($followers); $i++){
					$follower_id = $followers[$i];
					$follower_email = $this->getUserEmailById($follower_id);
					$follower_user_name = $this->getUserNameById($follower_id);
					$follower_mobile = $this->getFullMobileNoByUserName($follower_user_name);
					$all_emails[] .= $follower_email; 
					$all_mobiles[] .= $follower_mobile;
					$all_ids[] .= $follower_id;
				}

				// print_r($all_ids);

				//First Check If Email Is Enabled By Admin
				if($this->checkIfEmailNotifIsEnabled()){
					//Then Filter It To Those Who Have Email Notifications Enabled
					$all_emails = $this->filterSubEmails($all_emails);
					// print_r($all_emails);
					// if($type == "follow" && !is_null($followed_id)){
					// 	$followed_email = $this->getUserEmailById($followed_id);
					// 	unset($all_emails[$followed_email]);
					// 	$user_name = $this->getUserNameById($this->getUserIdWhenLoggedIn());
					// 	$title = $user_name . " Just Started Following You";
					// 	$message = $user_name . " Just Started Following you.<a href='".site_url('Sabicapital/'.$user_name)."'>View Profile.</a>";
					// 	$this->sendEmail($followed_email,$title,$message);
					// }else{
						$this->sendEmail($all_emails,$title,$message);
					// }
				}


				// //First Check If SMS Is Enabled By Admin
				// if($this->checkIfSmsNotifIsEnabled()){
				// 	// echo "string";
				// 	//Then Filter It To Those Who Have SMS Notifications Enabled
				// 	$all_mobiles = $this->filterSubSms($all_mobiles,$all_ids);
				// 	// print_r($all_mobiles);
				// 	$this->sendSms($all_mobiles,$message);
				// }

				//Send In App Notifs To All Followers
				// if($this->checkIfUserHasNotifEnabled($user_id)){
					// print_r($all_ids);
					$all_ids = $this->filterSubIds($all_ids);
					$this->makeNotif($user_id,$all_ids,$title,$message,$type,$post_id);
				// }				
				
				
				return true;
			}else{
				return true;
			}
		}

		public function makeNotif($sender,$receivers,$title,$message,$type,$post_id = ""){
			
			$date =	date("j M Y");
			$time = date("H:i:s");
			
			if(is_array($receivers)){
				
				$post_maker = $this->getPostSenderId($post_id);
				for($i = 0;$i < count($receivers); $i++){
					$receiver_id = $receivers[$i];
					$form_array = array(
						'sender' => $sender,
						'receiver' => $receiver_id,
						'title' => $title,
						'message' => $message,
						'type' => $type,						
						'post_id' => $post_id,
						'date_sent' => $date,
						'time_sent' => $time 
					);
					if($this->checkIfUserHasNotifEnabled($receiver_id)){
						$query = $this->db->insert('notif',$form_array);	
					}
				}
				return true;
			}
			
		}

		public function makePost($form_array){
			//Send Email To All His Followers
			$query = $this->db->insert('posts',$form_array);
			if($query){
				$user_id = $this->getUserIdWhenLoggedIn();
				$post_id = $this->db->insert_id();
				$post_slug = $this->getPostSlugById($post_id);
				$user_name = $this->getUserNameById($user_id);
				$poster_username = $this->getPostSenderUserName($post_id);
				$title = $user_name . " Just Made A Post";
				$message = $user_name . " Just Made A Post. <a href='".site_url('Sabicapital/index/post/'.$post_id.'/'.$post_slug)."'>View Post.</a>";
				// echo $message;
				if($this->sendNotif($user_id,$title,$message,'post',$post_id)){
					set_cookie('send_post_id',$post_id,36000);
					return true;
				}

			}else{
				return false;
			}
		}

		public function makePostHealth($form_array){
			//Send Email To All His Followers
			$query = $this->db->insert('health_posts',$form_array);
			if($query){
				$user_id = $this->getUserIdWhenLoggedIn();
				$post_id = $this->db->insert_id();
				set_cookie('send_post_id',$post_id,36000);
				return true;
				

			}else{
				return false;
			}
		}

		public function commentOnPost($user_id,$post_id,$content,$date,$time){
			//Send Emails To All Folllowers
			$post_maker_username = $this->getPostSenderUserName($post_id); 
			$post_maker_id = $this->getUserIdByName($post_maker_username);
			$post_slug = $this->getPostSlugById($post_id);
			$query = $this->db->insert('comments',array('sender' => $user_id,'post_id' => $post_id,'content' => $content,'date' => $date,'time' => $time));
			if($query){
				$user_name = $this->getUserNameById($user_id);
				$poster_username = $this->getPostSenderUserName($post_id);

				//Check If This User Owns This This Post
				if($post_maker_id !== $user_id){
					$title = $user_name . " Just Commented On your Post.";
					$message = $user_name . " Just Commented On your Post. <a href='".site_url('Sabicapital/index/post/'.$post_id.'/'.$post_slug)."'>View Post.</a>";
					$post_maker_email = $this->getUserEmailById($post_maker_id);
					$recepient_arr = explode(",", $post_maker_email);
					$recepient_arr_id = explode(",",$post_maker_id);
					if($this->sendEmail($recepient_arr,$title,$message)){
						if($this->makeNotif($user_id,$recepient_arr_id,$title,$message,'comment',$post_id)){
							return true;
						}
					}else{
						return false;
					}
				}
				return true;

			}else{
				return false;
			}
		}

		public function commentOnPostHealth($user_id,$post_id,$content,$date,$time){
			//Send Emails To All Folllowers
			$post_maker_username = $this->getPostSenderUserName($post_id); 
			$post_maker_id = $this->getUserIdByName($post_maker_username);
			$post_slug = $this->getPostSlugById($post_id);
			$query = $this->db->insert('health_comments',array('sender' => $user_id,'post_id' => $post_id,'content' => $content,'date' => $date,'time' => $time));
			if($query){
				return true;
			}else{
				return false;
			}
		}

		public function followUser($user_id,$partner_id){
			$query = $this->db->get_where('users',array('id' => $partner_id));
			if($query->num_rows() == 1){

				foreach($query->result() as $row){
					$followers = $row->followers;
				}
				if($followers == ""){
					$followers = $user_id;
				}else{
					$followers = $followers . ",".$user_id;
				}
				$query = $this->db->get_where('users',array('id' => $user_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$following = $row->following;
					}
					if($following == ""){
						$following = $partner_id;
					}else{
						$following = $following . ",".$partner_id;
					}

					$partner_username = $this->getUserNameById($partner_id);
					$user_name = $this->getUserNameById($user_id);

					if($this->db->update('users',array('followers' => $followers),array('id' => $partner_id))){

						if($this->db->update('users',array('following' => $following),array('id' => $user_id))){
							$title = $user_name . " Just Followed you.";
							$message = $user_name . " Just Followed you.. <a href='".site_url('Sabicapital/'.$user_name)."'>View Profile.</a>";
							$partner_email = $this->getUserEmailById($partner_id);
							$partner_array = array();
							$partner_array[] = $partner_email;
							
							if($this->sendEmail($partner_array,$title,$message)){
								$partner_array = array();
								$partner_array[] = $partner_id;
								if($this->makeNotif($user_id,$partner_array,$title,$message,'follow')){
									return true;
								}
							}else{
								return false;
							}
						}else{
							return false;
						}
					}else{
						return false;
					}
				}else{
					return false;
				}	
			}else{
				return false;
			}
		}

		public function unfollowUser($user_id,$partner_id){
			// echo "string";
			if(!$this->checkIfThisIsAdmin($partner_id)){
				$query = $this->db->get_where('users',array('id' => $partner_id));
				if($query->num_rows() == 1){
					foreach($query->result() as $row){
						$followers = $row->followers;
					}
					if($followers == ""){
						return false;
					}else{
						$followers_arr = explode(",", $followers);
						if(in_array($user_id, $followers_arr)){
							$index = array_search($user_id, $followers_arr);
							unset($followers_arr[$index]);
							// print_r($followers_arr)
							if(empty($followers_arr)){
								$followers = "";
							}else{
								$followers = implode(",", $followers_arr);
							}
						}
					}
					$query = $this->db->get_where('users',array('id' => $user_id));
					if($query->num_rows() == 1){
						foreach($query->result() as $row){
							$following = $row->following;
						}
						if($following == ""){
							return false;
						}else{
							$following_arr = explode(",", $following);
							// print_r($following_arr);
							if(in_array($partner_id, $following_arr)){

								$index = array_search($partner_id, $following_arr);
								// echo $index;
								unset($following_arr[$index]);
								if(empty($following_arr)){
									$following = "";
								}else{
									$following = implode(",", $following_arr);
								}
								// echo $following;
							}
						}

						$partner_username = $this->getUserNameById($partner_id);
						$user_name = $this->getUserNameById($user_id);
						
						if($this->db->update('users',array('followers' => $followers),array('id' => $partner_id))){
							if($this->db->update('users',array('following' => $following),array('id' => $user_id))){
								$title = $user_name . " Just Unfollowed you.";
								$message = $user_name . " Just Unfollowed you.. <a href='".site_url('Sabicapital/'.$user_name)."'>View Profile.</a>";
								$partner_email = $this->getUserEmailById($partner_id);
								$partner_array = array();
								$partner_array[] = $partner_email;
								if($this->sendEmail($partner_array,$title,$message)){
									$partner_array = array();
									$partner_array[] = $partner_id;
									if($this->makeNotif($user_id,$partner_array,$title,$message,'follow')){
										return true;
									}
								}else{
									return false;
								}
							}else{
								return false;
							}
						}else{
							return false;
						}
					}else{
						return false;
					}	
				}else{
					return false;
				}
			}
		}

		public function likePost($user_id,$post_id){
			$user_name = $this->getUserNameById($user_id);
			$post_slug = $this->getPostSlugById($post_id);
			$post_maker_id = $this->getPostSenderId($post_id);
			$post_maker_username = $this->getUserNameById($post_maker_id);
			$post_maker_email = $this->getUserEmailById($post_maker_id);
			$query = $this->db->get_where('posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$likes = $row->likes;
				}
				if($likes == ""){
					$likes = $user_id;
				}else{
					$likes = $likes . ",".$user_id;
				}
				
				if($this->db->update('posts',array('likes' => $likes),array('id' => $post_id))){
					if($user_id !== $post_maker_id){
						$title = $user_name . " Just Liked Your Post.";
						$message = $user_name . " Just Liked Your Post. <a href='".site_url('Sabicapital/index/post/'.$post_id.'/'.$post_slug)."'>View Post.</a>";
						$partner_array = array();
						$partner_array[] = $post_maker_email;
						if($this->sendEmail($partner_array,$title,$message)){
							$partner_array = array();
							$partner_array[] = $post_maker_id;
							if($this->makeNotif($user_id,$partner_array,$title,$message,'like',$post_id)){
									
							}
						}
					}
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}


		public function likePostHealth($user_id,$post_id){
			$user_name = $this->getUserNameById($user_id);
			$post_slug = $this->getPostSlugById($post_id);
			$post_maker_id = $this->getPostSenderId($post_id);
			$post_maker_username = $this->getUserNameById($post_maker_id);
			$post_maker_email = $this->getUserEmailById($post_maker_id);
			$query = $this->db->get_where('health_posts',array('id' => $post_id));
			if($query->num_rows() == 1){
				foreach($query->result() as $row){
					$likes = $row->likes;
				}
				if($likes == ""){
					$likes = $user_id;
				}else{
					$likes = $likes . ",".$user_id;
				}
				
				if($this->db->update('health_posts',array('likes' => $likes),array('id' => $post_id))){
					
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}



	}
?>