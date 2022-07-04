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
      </script>
      <div class="content">
        <div class="container-fluid">
          <div class="spinner-overlay" style="display: none;">
            <div class="spinner-well">
              <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading..." style="">
            </div>
          </div>
          <h2 class="text-center">VTU Recharge Combo Requests</h2>
          <div class="row justify-content-center">
            <div class="col-sm-10">
              <div class="card" id="main-card">
                <div class="card-header">
                  <h3 class="card-title">New Requests</h3>
                </div>
                <div class="card-body">
                  <?php
                  $new_requests = $this->meetglobal_model->getNewRechargeComboRequests();
                  if(is_array($new_requests)){
                    $i = 0;
                  ?>  
                    <div class="table-div material-datatables table-responsive" style="">
                      <table class="table table-striped table-bordered nowrap hover display" id="new-requests-table" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Members Name</th>
                            <th>Amount ()</th>
                            <th>Mobile Number</th>
                            <th>Date / Time</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                  <?php        
                    foreach($new_requests as $row){
                      $i++;
                      $id = $row->id;
                      $user_id = $row->user_id;
                      $number = $row->number;
                      $amount = $row->amount;
                      $date = $row->date;
                      $time = $row->time;
                      $credited = $row->credited;

                      $full_name = $this->meetglobal_model->getUserFullNameByUserId($user_id);
                      $slug = $this->meetglobal_model->getUserParamById("slug",$user_id);
                  ?>
                          <tr>
                            <td><?php echo $i; ?></td>
                            <td><a target="_blank" href="<?php echo site_url('meetglobal/'.$slug) ?>"><?php echo $full_name; ?></a></td>
                            <td><?php echo $amount; ?></td>
                            <td><?php echo $number; ?></td>
                            <td><?php echo $date . " / " . $time; ?></td>
                            <td class="td-actions">
                              <button class="btn btn-success" rel="tooltip" title="Mark This Record As Recharged" onclick="markThisRecordAsRecharged(this,event,<?php echo $id; ?>)">
                                <i class="fas fa-check"></i>
                              </button>
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
                    echo "<h4 class='text-warning'>No New Recharge Combo Requests</h4>";
                  }
                  ?>
                </div>
              </div>
            </div>

            <a target="_blank" href="<?php echo site_url('meetglobal/combo_recharge_history') ?>" id="view-combo-history-btn" rel="tooltip" data-toggle="tooltip" title="View Combo Recharge History" style="background: #9c27b0; cursor: pointer; position: fixed; bottom: 0; right: 0;  border-radius: 50%; cursor: pointer; display: none; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
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
          $("#view-combo-history-btn").show("fast");
          $("#new-requests-table").DataTable();
          $(".td-actions button").tooltip();
          
        })
        
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 