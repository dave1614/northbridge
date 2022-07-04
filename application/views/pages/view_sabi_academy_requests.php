         <!-- End Navbar -->
      <style>
        .sum{
          font-style: italic;
        }
      </style>
      <link href="<?php echo base_url('assets/css/treeflex.css') ?>" rel="stylesheet">
  <style>
    .ratio{
      font-weight: bold;
    }
    .tf-tree{
      text-align: center;
      /*cursor: col-resize;*/
    }
  
    .tf-tree .tf-nc .name{
      font-size: 20px;
    }

    .tf-tree .tf-nc {
      width: 150px;
      height: 220px;
      background: #fff;
      border: 0;
      border-radius: 4px;
      position: relative;
      padding-bottom: 10px;
      /*cursor: pointer;*/

    }

    .tf-tree .tf-nc .icons-div{
      /*margin-top: 10px;
      margin-bottom: 20px;*/
      /*position: absolute; 
      bottom: 0px; */
    }

    .tf-nc.business{
      border: 5px solid #7ea960;
      box-shadow: 0 2px 6px 0 #7ea960;
    }

    .tf-nc.basic{
      border: 5px solid #7ea960;
      box-shadow: 0 2px 6px 0 #7ea960;
    }

    .tf-nc.basic .package{
      color: #7ea960;
      text-transform: uppercase;
      font-weight: 700;
    }

    .tf-nc.business .package{
      color: #7ea960;
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
      font-size: 18px;
      font-style: italic;
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

    .tf-tree{
      color: #7ea960;
    }

    .tf-tree img{
      display: none;
    }

    .tf-tree .package{
      display: none;
    }
  </style>
      <script>
        var global_user_id = "";
         function addCommas(nStr)
          {
              nStr += '';
              x = nStr.split('.');
              x1 = x[0];
              x2 = x.length > 1 ? '.' + x[1] : '';
              var rgx = /(\d+)(\d{3})/;
              while (rgx.test(x1)) {
                  x1 = x1.replace(rgx, '$1' + ',' + '$2');
              }
              return x1 + x2;
          }

          

          function reloadPage (elem) {
            document.location.reload(); 
          }

          function viewFundAcountHistoryInfoById(elem,evt,id){
            var form_data = {
              "show_records": true,
              "id" : id
            }
            var url = "<?php echo site_url('sabicapital/index/admin/view_more_info_on_superforex_deposit_request'); ?>";
            $(".spinner-overlay").show();
            $.ajax({
              type : "POST",
              dataType : "json",
              responseType : "json",
              url : url,
              data : form_data,
              success : function (response) {
                $(".spinner-overlay").hide();
                console.log(response)
                
                if(response.success && response.messages != ""){
                  var messages = response.messages;
                  $("#more-info-superforex-fund-request-card .card-body").html(messages);
                  $("#main-card").hide();
                  $("#more-info-superforex-fund-request-card").show();
                  
                }else{
                  swal({
                    title: 'Ooops',
                    text: "Something Went Wrong.",
                    type: 'error',                              
                  })
                }
              },error : function () {
                $(".spinner-overlay").hide();
                swal({
                  title: 'Ooops',
                  text: "Something Went Wrong. Please Check Your Internet Connection",
                  type: 'error',                              
                })
              } 
            });
          }

          function goBackFromMoreInfoSuperforexFundRequestCard (elem,evt) {
            $("#main-card").show();
            $("#more-info-superforex-fund-request-card").hide();
          }

          function performActionOnWithdrawalRequest(elem,evt,id){
            elem = $(elem);
            var full_name = elem.attr("data-full-name");

            var url = "<?php echo site_url('sabicapital/index/admin/view_more_info_on_superforex_withdrawal_request_history') ?>";
            var form_data = {
              'show_records' : true,
              'id' : id
            }
            $(".spinner-overlay").show();
    
            $.ajax({
              url : url,
              type : "POST",
              responseType : "json",
              dataType : "json",
              data : form_data,
              success : function (response) {
                console.log(response)
                $(".spinner-overlay").hide();
                if(response.success && response.messages != ""){
                  var messages = response.messages;
                  $("#main-card").hide();
                  $("#view-withdrawal-requests-card-info .card-body").html(messages);
                  $("#view-withdrawal-requests-card-info").show();
                }else if(response.invalid_id){
                  swal({
                    title: 'Error',
                    text: "This Request Is Invalid",
                    type: 'error',                                          
                  })
                }else{
                  swal({
                    title: 'Error',
                    text: "Sorry Something Went Wrong.",
                    type: 'error',                                          
                  })
                }
              },error : function () {
                $(".spinner-overlay").hide();
                
                swal({
                  title: 'Error',
                  text: "Sorry Something Went Wrong. Please Check Your Internet Connection And Try Again",
                  type: 'error',                                          
                })
              }
            });
          }

          function goBackFromViewWithdrawalRequestsInfo (elem,evt) {
            $("#main-card").show();
            $("#view-withdrawal-requests-card-info").hide();
          }

          function approveWithdrawalRequest(elem,evt,id){
            elem = $(elem);
            swal({
              title: 'Warning',
              text: "Are You Sure You Want To Approve This Request?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
              
              var url = "<?php echo site_url('sabicapital/index/admin/approve_withdrawal_superforex_fund_request') ?>";
              var form_data = {
                id: id
              }

              console.log(form_data)
              $(".spinner-overlay").show();

              $.ajax({
                url : url,
                type : "POST",
                responseType : "json",
                dataType : "json",
                data : form_data,
                success : function (response) {
                  $(".spinner-overlay").hide();
                  
                  if(response.success){
                    
                    $.notify({
                      message:"Request Approved Successfully"
                    },{
                      type : "success"  
                    });
                    setTimeout(function () {
                      document.location.reload();
                    }, 1500);
                  }else if(response.invalid_id){
                    swal({
                      title: 'Error',
                      text: "This Request Is Invalid",
                      type: 'error',                                          
                    })
                  }else if(response.action_already_taken){
                    swal({
                      title: 'Error',
                      text: "Action Has Already Been Carried Out On This Request.",
                      type: 'error',                                          
                    })
                  }else{
                    swal({
                      title: 'Ooops',
                      text: "Something Went Wrong.",
                      type: 'error',                              
                    })
                  }
                },error : function () {
                  $(".spinner-overlay").hide();
                  swal({
                    title: 'Ooops',
                    text: "Something Went Wrong. Please Check Your Internet Connection",
                    type: 'error',                              
                  })
                }
              });
            });
          }

          function declineRequestWithdrawal(elem,evt,id){
            elem = $(elem);
            var full_name = elem.attr("data-full-name");
            $("#decline-withdrawal-request-modal .modal-title").html("Enter Reason For Declining "+full_name+" This Request");
            $("#decline-withdrawal-request-modal #id").val(id);
            $("#decline-withdrawal-request-modal").modal("show");
          }

          function clearThisSabiAcademyRequest(elem,evt,id){
            swal({
              title: 'Warning',
              text: "Are You Sure You Want To Clear This Request?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
              var url = "<?php echo site_url('sabicapital/index/admin/clear_sabi_academy_request') ?>";
              var form_data = {
                id: id
              }

              console.log(form_data)
              $(".spinner-overlay").show();

              $.ajax({
                url : url,
                type : "POST",
                responseType : "json",
                dataType : "json",
                data : form_data,
                success : function (response) {
                  $(".spinner-overlay").hide();
                  
                  if(response.success){
                    
                    $.notify({
                      message:"Request Cleared Successfully"
                    },{
                      type : "success"  
                    });
                    setTimeout(function () {
                      document.location.reload();
                    }, 1500);
                  }else{
                    swal({
                      title: 'Ooops',
                      text: "Something Went Wrong.",
                      type: 'error',                              
                    })
                  }
                },error : function () {
                  $(".spinner-overlay").hide();
                  swal({
                    title: 'Ooops',
                    text: "Something Went Wrong. Please Check Your Internet Connection",
                    type: 'error',                              
                  })
                }
              });
            });
          }
          
      </script>
      <style>
        tr{
          cursor: pointer;
        }
      </style>
      <div class="content">
        <div class="container-fluid">
          <div class="spinner-overlay" style="display: none;">
            <div class="spinner-well">
              <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading..." style="">
            </div>
          </div>
          <!-- <h2>All Registered Members</h2> -->
          <div class="row justify-content-center">
            <div class="col-sm-12">

              <div class="card" id="view-withdrawal-requests-card-info" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromViewWithdrawalRequestsInfo(this,event)">Go Back</button>
                  <h3 class="card-title">Perform Action On This Pending Superforex Withdrawal Request</h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="more-info-superforex-fund-request-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning" onclick="goBackFromMoreInfoSuperforexFundRequestCard(this,event)">Go Back</button>
                  <h3 class="card-title">Superforex Deposit Request</h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="main-card">
                <div class="card-header">
                  
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                <?php
                  $response_arr = array('messages' => '');
                  if(isset($rows)){
                    // var_dump($rows);
                    
                    $response_arr['messages'] .= "<div class='row justify-content-center'>";
                    $attr = array('id' => 'filter-rows-form','class' => 'col-sm-6','style' => 'margin-bottom: 35px;');
                    $response_arr['messages'] .= form_open('',$attr);

                    $response_arr['messages'] .= "<div class='form-group'>";
                    $response_arr['messages'] .= "<input type='text' class='form-control' name='full_name' id='full_name' placeholder='Full Name'";

                    if(isset($_GET['full_name'])){
                      $response_arr['messages'] .= "value='" . $_GET['full_name'] . "'";
                    }

                    $response_arr['messages'] .= ">";
                    $response_arr['messages'] .= "</div>";


                    $response_arr['messages'] .= "<div class='form-group'>";
                    $response_arr['messages'] .= "<input type='number' class='form-control' name='phone' id='phone' placeholder='Phone Number'";

                    if(isset($_GET['phone'])){
                      $response_arr['messages'] .= "value='" .  $_GET['phone'] . "'";
                    }

                    $response_arr['messages'] .= ">";
                    $response_arr['messages'] .= "</div>";


                    $response_arr['messages'] .= "<div class='form-group'>";
                    $response_arr['messages'] .= "<input type='text' class='form-control' name='super_forex_account_number' id='super_forex_account_number' placeholder='SuperForex Account Number'";

                    if(isset($_GET['super_forex_account_number'])){
                      $response_arr['messages'] .= "value='" . $_GET['super_forex_account_number'] . "'";
                    }

                    $response_arr['messages'] .= ">";
                    $response_arr['messages'] .= "</div>";
                    
                    

                    $response_arr['messages'] .= "<div class='form-group'>";
                    $response_arr['messages'] .= "<input type='date' class='form-control' name='date' id='date' placeholder='Date'";

                    if(isset($_GET['date'])){
                      $response_arr['messages'] .= "value='" . $_GET['date'] . "'";
                    }

                    $response_arr['messages'] .= ">";


                    $response_arr['messages'] .= "</div>";



                    $response_arr['messages'] .= "<button type='submit' class='btn btn-primary'>Filter Results</button>";
                    $response_arr['messages'] .= "<button type='button' class='btn btn-secondary' id='clear-filter-rows-form'>Clear</button>";
                    $response_arr['messages'] .= "</form>";
                    $response_arr['messages'] .= "</div>";

                    if(is_array($rows)){
                      // var_dump($_GET);
                    
                      $j = 0;
                 
                      $response_arr['messages'] .= '<div class="table-div material-datatables table-responsive" style="">';
                      $response_arr['messages'] .= '<table id="all-registered-users-table" class="table table-test table-striped table-bordered nowrap hover display" cellspacing="0" width="100%" style="width:100%">';
                      $response_arr['messages'] .= '<thead>';
                      $response_arr['messages'] .= '<tr>';
                      $response_arr['messages'] .= '<th>#</th>';
                      $response_arr['messages'] .= '<th>Full Name</th>';
                      $response_arr['messages'] .= '<th>SuperForex Account Number</th>';
                      $response_arr['messages'] .= '<th>Phone Number</th>';
                      $response_arr['messages'] .= '<th>Date / Time</th>';
                      $response_arr['messages'] .= '<th>Actions</th>';
                     
                      $response_arr['messages'] .= '</tr>';
                      $response_arr['messages'] .= '</thead>';
                      $response_arr['messages'] .= '<tbody>';

                      foreach($rows as $row){
                        $j++;
                        if($third_addition > 1){
                          $row_num = ($third_addition - 1);
                          $row_num *= 10;
                          $row_num += $j;
                        }else{
                          $row_num = $j;
                        }


                        $id = $row->id;
                        
                        $full_name = $row->full_name;
                        $super_forex_account_number = $row->super_forex_account_number;
                        $phone = $row->phone;
                        
                        $date_time = $row->date_time;
                        
                        $response_arr['messages'] .= '<tr >';

                        $response_arr['messages'] .= '<td>'.$row_num.'</td>';
                        $response_arr['messages'] .= '<td style="text-transform: capitalize;">'.$full_name.'</td>';
                        $response_arr['messages'] .= '<td><em class="text-primary">'.$super_forex_account_number.'</em></td>';
                        $response_arr['messages'] .= '<td><em class="text-primary">'.$phone.'</em></td>';
                        $response_arr['messages'] .= '<td class="date">'.$date_time.'</td>';

                        $response_arr['messages'] .= '<td class="td-actions text-center">';
                        $response_arr['messages'] .= '<button onclick="clearThisSabiAcademyRequest(this,event,'.$id.')" type="button" rel="tooltip" title="Clear This Request" class="btn btn-success">';
                        $response_arr['messages'] .= '<i style="color: #fff;" class="fas fa-check"></i>';
                        $response_arr['messages'] .= '<div class="ripple-container"></div>';
                        $response_arr['messages'] .= '</button>';
                        $response_arr['messages'] .= '</td>';

                        $response_arr['messages'] .= '</tr>';
                          
                      }
                      $response_arr['messages'] .= '</tbody>';
                      $response_arr['messages'] .= '</table>';
                      $response_arr['messages'] .= '</div>';
                                   
                        
                      $response_arr['messages'] .= $str_links;
                      $no_of_pages = round($total_rows / 10);
                      $response_arr['messages'] .=  "<h4 class='text-primary' style='font-weight: bold;'>". $total_rows . " Total Entries</h4>";
                    }else{
                      $response_arr['messages'] .= '<h4 class="text-warning">No Records To Display Here.</h4>';
                    }

                    echo $response_arr['messages'];
                  }
                ?>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="modal fade" data-backdrop="static" id="decline-withdrawal-request-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title text-center" style="text-transform: capitalize;">Enter Reason For Declining This Request </h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="modal-body">
              
              <?php
              $attr = array('id' => 'decline-withdrawal-request-form');
              echo form_open('sabicapital/index/admin/decline_superforex_withdrawal_request',$attr);
              ?>
              <input type="hidden" id="id" name="id" value="">
                
                <div class="form-group">
                  <label for="reason">Reason: </label>
                  <textarea name="reason" id="reason" cols="30" rows="10" class="form-control"></textarea>
                  <span class="form-error"></span>
                </div>
                <input type="submit" class="btn btn-primary">
              </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

           
          </div>
        </div>
      <footer class="footer">
        <div class="container-fluid">
          <footer></footer>
        </div>
      </footer>
      
      <script>
        $(document).ready(function () {

          $("#decline-withdrawal-request-form").submit(function (evt) {
            evt.preventDefault();
            var me = $(this);
            swal({
              title: 'Warning',
              text: "Are You Sure You Want To Proceed With Declining This Request?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
              
              var url = me.attr("action");
              var form_data = me.serializeArray();

              console.log(form_data)
              $(".spinner-overlay").show();

              $.ajax({
                url : url,
                type : "POST",
                responseType : "json",
                dataType : "json",
                data : form_data,
                success : function (response) {
                  $(".spinner-overlay").hide();
                  
                  if(response.success){
                    
                    $.notify({
                      message:"Request Declined Successfully"
                    },{
                      type : "success"  
                    });
                    setTimeout(function () {
                      document.location.reload();
                    }, 1500);
                  }else if(response.invalid_id){
                    swal({
                      title: 'Error',
                      text: "This Request Is Invalid",
                      type: 'error',                                          
                    })
                  }else if(response.action_already_taken){
                    swal({
                      title: 'Error',
                      text: "Action Has Already Been Carried Out On This Request.",
                      type: 'error',                                          
                    })
                  }else{
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
                },error : function () {
                  $(".spinner-overlay").hide();
                  swal({
                    title: 'Ooops',
                    text: "Something Went Wrong. Please Check Your Internet Connection",
                    type: 'error',                              
                  })
                }
              });
            });
          })
          
          $("#main-card #filter-rows-form").submit(function (evt) {
            evt.preventDefault()
            var me  = $(this)
            var form_data = me.serializeArray()
            console.log(form_data)
            // var full_name = me.find("#full_name").val()
            var full_name = me.find("#full_name").val()
            var phone = me.find("#phone").val()
            var super_forex_account_number = me.find("#super_forex_account_number").val()
            

           
            
            var date = me.find("#date").val()

            
            var url = "<?php echo site_url('sabicapital/index/'.$addition.'/'.$second_addition); ?>?full_name="+full_name+"&phone="+phone+"&super_forex_account_number="+super_forex_account_number+"&date="+date;
            

            window.location.assign(url)
          })

          $("#main-card #clear-filter-rows-form").click(function(evt){
            var me = $(this);
            $("#main-card #filter-rows-form input").val("")
            $("#main-card #none"). prop("checked", true);
          })

        })
        
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 