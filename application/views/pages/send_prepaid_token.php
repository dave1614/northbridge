         <!-- End Navbar -->
      <style>
        .sum{
          font-style: italic;
        }

        .settings-table tr{
          cursor: pointer;
        }
      </style>
      <script>
        var token_id = "";
        var data_full_name = "";
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

          function withdrawFunds(elem) {
            $("#withdraw-funds-modal").modal({
              "show" : true,
              "backdrop" : false,
              "keyboard" : false
            })
          }

          function reloadPage (elem) {
            document.location.reload(); 
          }

          function openAdminSettings(elem) {
            $("#admin-info-card").hide("slow");
            $("#notif-settings-card").show("slow");
            $("#submit-settings").show("slow");
          }

          function goDefault () {
            $("#admin-info-card").show("slow");
            $("#notif-settings-card").hide("slow");
            $("#submit-settings").hide("slow");
          }

          function markThisRecordAsRecharged(elem,evt,id){
            if(id != ""){
              $(".spinner-overlay").show();

              var form_data = {
                id : id
              }
              var url = "<?php echo site_url('meetglobal/mark_combo_record_as_recharged'); ?>"
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
                    message:"Combo Record Successfully Marked As Recharged"
                    },{
                      type : "success"  
                    });
                    setTimeout(function () {
                      document.location.reload();
                    }, 1500);
                  }else{
                    swal({
                      title: 'Ooops',
                      text: "Something Went Wrong",
                      type: 'error'
                    })
                  }
                },error : function () {
                  $(".spinner-overlay").hide();
                  swal({
                    title: 'Ooops',
                    text: "Something Went Wrong",
                    type: 'error'
                  })
                } 
              }); 
            } 
          }

          function enterMeterToken(elem,evt,id){
            elem = $(elem);
            if(id != ""){

              token_id = id;
              var full_name = elem.attr("data-full-name")
              data_full_name = full_name;
              $("#enter-meter-token-modal .modal-title").html("Enter Meter Token For "+full_name+" :");
              $("#enter-meter-token-modal").modal("show");
            }
          }
      </script>
      <div class="content">
        <div class="container-fluid">
          <div class="spinner-overlay" style="display: none;">
            <div class="spinner-well">
              <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading..." style="">
            </div>
          </div>
          <h2 class="text-center">Prepaid Token Requests</h2>
          <div class="row justify-content-center">
            <div class="col-sm-12">
              <div class="card" id="main-card">
                <div class="card-header">
                  <h3 class="card-title">New Requests</h3>
                </div>
                <div class="card-body">
                  <?php
                  $new_requests = $this->meetglobal_model->getNewPrepaidRequests();
                  if(is_array($new_requests)){
                    $i = 0;
                  ?>  
                    <div class="table-div material-datatables table-responsive" style="">
                      <table class="table table-striped table-bordered nowrap hover display" id="new-requests-table" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Order Id</th>
                            <th>Disco</th>
                            <th>Meter No.</th>
                            <th>Amount</th>
                            <th>Date / Time</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                  <?php        
                    foreach($new_requests as $row){
                      $i++;
                      $id = $row->id;
                      $vtu_id = $row->vtu_id;
                      $phone_number = $row->phone_number;
                      $email = $row->email;
                      $user_id = $this->meetglobal_model->getVtuTransactionParamById("user_id",$vtu_id);
                      $user_name = $this->meetglobal_model->getUserNameById($user_id);
                      
                      if($phone_number == ""){
                        $phone_number = $this->meetglobal_model->getFullMobileNoByUserName($user_name);
                      }

                      if($email == ""){
                        $email = $this->meetglobal_model->getUserParamById("email",$user_id);
                      }
                      $user_name = $this->meetglobal_model->getUserParamById("user_name",$user_id);
                      $full_name = $this->meetglobal_model->getUserFullNameByUserId($user_id);
                      $slug = $this->meetglobal_model->getUserParamById("slug",$user_id);
                      
                      $order_id = $this->meetglobal_model->getVtuTransactionParamById("order_id",$vtu_id);
                      $disco = $this->meetglobal_model->getVtuTransactionParamById("sub_type",$vtu_id);
                      $meter_no = $this->meetglobal_model->getVtuTransactionParamById("number",$vtu_id);
                      $amount = $this->meetglobal_model->getVtuTransactionParamById("amount",$vtu_id);
                      $date_time = $this->meetglobal_model->getVtuTransactionParamById("date",$vtu_id) . "  " . $this->meetglobal_model->getVtuTransactionParamById("time",$vtu_id);

                      
                  ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><a target="_blank" href="<?php echo site_url('meetglobal/'.$slug) ?>"><?php echo $full_name; ?></a></td>
                            <td><?php echo $phone_number; ?></td>
                            <td><?php echo $email; ?></td>
                            <td><?php echo $order_id; ?></td>
                            <td><?php echo $disco; ?></td>
                            <td><?php echo $meter_no; ?></td>
                            <td><?php echo number_format($amount,2); ?></td>
                            <td><?php echo $date_time; ?></td>
                            <td >
                              <button class="btn btn-success" data-full-name="<?php echo $full_name ?>" onclick="enterMeterToken(this,event,<?php echo $id; ?>)">Enter Meter Token</button>
                            </td>
                          </tr>

                  <?php
                    }
                  ?>
                          </tbody>
                        </table>
                      </div>
                  <?php
                  }else{
                    echo "<h4 class='text-warning'>No New Prepaid Electricity Requests</h4>";
                  }
                  ?>
                </div>
              </div>
            </div>


            <div class="modal fade" data-backdrop="static" id="enter-meter-token-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content" >
                  <div class="modal-header">
                    <h3 class="modal-title">Enter Meter Token For: </h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body" id="modal-body">
                    
                    <?php 
                      $attr = array('id' => 'enter-meter-token-form');
                      echo form_open('meetglobal/enter_meter_token',$attr);
                    ?>

                    <div class="form-group">
                      <label for="meter_token"></label>
                      <input type="number" minlength="" maxlength="" class="form-control" name="meter_token" id="meter_token" required>
                      <span class="form-error"></span> 
                    </div>


                    <input type="submit" class="btn btn-primary" >

                    </form>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <a target="_blank" href="<?php echo site_url('meetglobal/prepaid_electricity_history') ?>" id="view-combo-history-btn" rel="tooltip" data-toggle="tooltip" title="View Prepaid Electricity Recharge History" style="background: #9c27b0; cursor: pointer; position: fixed; bottom: 0; right: 0;  border-radius: 50%; cursor: pointer; display: none; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
              <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
                <i class="fas fa-clipboard-list" style="font-size: 25px; color: #fff;" aria-hidden="true"></i>
              </div>
            </a>


            <div rel="tooltip" data-toggle="tooltip" title="Save Settings" id="submit-settings" style="display: none; cursor: pointer; position: fixed; bottom: 0; right: 0; background: #9124a3; border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
              <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
                <i class="fas fa-save" style="font-size: 25px; font-weight: normal; color: #fff;" aria-hidden="true"></i>
              </div>
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
          $("#enter-meter-token-form").submit(function (evt) {
            evt.preventDefault();
            var me = $(this);
            var meter_token = me.find("#meter_token").val();
            var url = me.attr("action");

            swal({
              title: 'Warning',
              text: "Are You Sure You Want To Send <em class='text-primary'>"+meter_token+"</em> To <em class='text-primary'>"+data_full_name+"</em> As Meter Token?" ,
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No Cancel"
            }).then(function(){
              var form_data = {
                meter_token : meter_token,
                id: token_id
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
                  if(response.success){
                    $.notify({
                    message:"Meter Token Successfully Sent To " + data_full_name
                    },{
                      type : "success"  
                    });
                    setTimeout(function () {
                      document.location.reload()
                    }, 1500);
                  }else{
                    swal({
                      title: 'Ooops',
                      text: "Something Went Wrong.",
                      type: 'error'
                    })
                  }
                },error: function () {
                  $(".spinner-overlay").hide();
                  swal({
                    title: 'Ooops',
                    text: "Something Went Wrong. Please Check Your Internet Connection",
                    type: 'error'
                  })
                }
              });  
            });

          })


          $("#view-combo-history-btn").show("fast");
          $("#new-requests-table").DataTable();
          $(".td-actions button").tooltip();
          
        })
        
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 