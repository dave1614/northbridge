on - 2
off - ""

other - 

$tests = $this->onehealth_model->get_set_of_all_tests_by_initiation_code($initiation_code,$health_facility_test_result_table);
							$i = 0;
							$title = "Tests Selected";
			        		$message = "This Is To Alert You That The Following Test(s) Where Selected For You In ".$health_facility_name." On " . $date . " At " .$time.'. Choose Payment Method. <p class="text-secondary">Note: Online Payment Includes 7% VAT</p>';
			       	
					       	$message .= '<div class="table-div material-datatables" style="">';
				            $message .= '<table class="table table-test table-striped table-bordered dt-responsive nowrap hover display" id="example" cellspacing="0" width="100%" style="width:100%" data-ini-code="<?php echo $initiation_code; ?>">';
				            $message .= '<thead>';
				            $message .= '<tr>';
				            $message .= '<th>#</th>';
				            
				                    
				            $message .= '<th>Test Name</th>';
				            $message .= '<th>Patient Name</th>';
				            $message .= '<th>Cost(₦)</th>';
				                   
				            $message .= '</tr>';
				            $message .= '</thead>';
				            $message .= '<tbody>';
							$total_price = 0;
							foreach($tests as $test){
								$i++;
								$id = $test->id;
								$patient_name = $test->patient_name;
								$test_id = $test->test_id;
								$test_name = $test->test_name;
								$test_cost = $test->price;
								$ta_time = $test->ta_time;
								$total_price += $test_cost;

				                $message .= '<tr>';

				                $message .= '<td>'.$i.'</td>';
				               
				                $message .= '<td class="test-name">'.$test_name.'</td>';
				                $message .= '<td class="patient-name">'.$patient_name.'</td>';
				                $message .= '<td class="test-cost">'.$test_cost.'</td>';
				                $message .= '</tr>';
		         
							}
							
							$message .= '</tbody>';
			          		$message .= '</table>';      
			        		$message .= '</div>';
			       
			        		$date =	date("j M Y");
							$time = date("H:i:s");

							$btn_1_url = site_url('onehealth/index/'.$addition.'/'.$second_addition.'/'.$third_addition.'/'.$fourth_addition.'/'.'approve-refund-request/'.$refund_code.'/'.$sender);
		            		
		            		$alert_message = "Initiation Code" .$
		            		$btn_1 = "<a class='btn btn-primary'>Online Payment</a>";
		            		$btn_2 = "<button class='btn btn-success' onclick='alert'></button>";

							$form_array = array(
								'sender' => $health_facility_name,
								'receiver' => $patient_username,
								'title' => $title,
								'message' => $message,
								'date_sent' => $date,
								'time_sent' => $time,
								'btn_1' => $btn_1,
								'btn_2' => $btn_2 
							);

			        		if($this->onehealth_model->sendMessage($form_array)){
			        			
			        		}
			        		