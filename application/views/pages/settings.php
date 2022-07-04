         <!-- End Navbar -->
      <style>
        tr{
          cursor: pointer;
        }
      </style>
      <script>
        
      </script>
      <div class="spinner-overlay" style="display: none;">
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading...">
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <h2 class="text-center">Settings</h2>
          <div class="row justify-content-center">
            <div class="col-sm-10">
              <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Notifications</h4>
                  <h6>View Notifications From Users You Are following</h6>
                </div>
                <div class="card-body">
                    <table class="table table-test dt-responsive nowrap hover display settings-table" cellspacing="0" width="100%" style="width:100%">
                      <thead style="display: none;">
                        <tr>
                          <th>Setting</th>
                          <th>CheckBox</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>SMS Notifications</td>
                          <td>
                            <div class="form-check text-right">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="sms_enabled" id="sms-notif" <?php if($this->meetglobal_model->checkIfSmsHasNotifEnabled($user_id)){ echo "checked"; } ?> type="checkbox" value="">
                                    <!-- Option one is this and that&mdash;be sure to include why it's great -->
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>In App Notifications</td>
                          <td>
                            <div class="form-check text-right">
                                <label class="form-check-label">
                                    <input class="form-check-input" name="notif_enabled" id="in-app-notif" <?php if($this->meetglobal_model->checkIfUserHasNotifEnabled($user_id)){ echo "checked"; } ?>  type="checkbox" value="">
                                    <!-- Option one is this and that&mdash;be sure to include why it's great -->
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>Email Notifications</td>
                          <td>
                            <div class="form-check text-right">
                                <label class="form-check-label">
                                    <input class="form-check-input" <?php if($this->meetglobal_model->checkIfEmailHasNotifEnabled($email)){ echo "checked"; } ?>  name="email_enabled" id="email-notif" type="checkbox" value="">
                                    <!-- Option one is this and that&mdash;be sure to include why it's great -->
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>  
                </div>
              </div>
            </div>
          </div>


          <div rel="tooltip" data-toggle="tooltip" title="Save Settings" id="submit-settings" style="cursor: pointer; position: fixed; bottom: 0; right: 0; background: #9124a3; border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
            <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
              <i class="fas fa-save" style="font-size: 25px; font-weight: normal; color: #fff;" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <!-- <footer>&copy; <?php echo date("Y"); ?> Copyright (meetglobal Issues Global Limited). All Rights Reserved</footer> -->
        </div>
      </footer>
      
      <script>
        $(document).ready(function () {
          // $("table").DataTable();

          $("#submit-settings").click(function(event) {
            swal({
                title: 'Choose Action',
                html: "Are You Sure You Want To Proceed?",
                type: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText : "No"
            }).then(function(){
              var form_data = {};
              var checkedState = false;
              var name = '';

              $(".settings-table").each(function(index, el) {
                // console.log($(this).find('tbody tr').length)
                $(this).find('tbody tr input').each(function(index, el) {
                  if($(this).is(':checked')){
                    checkedState = true;
                  }else{
                    checkedState = false;
                  }
                  name = $(this).attr('name');
                  form_data[name] = checkedState;
                });
              });
              form_data['admin'] = false;
              console.log(form_data);
              var url = "<?php echo site_url('meetglobal/save_settings') ?>";
              // console.log(form_data);
              $.ajax({
                type : "POST",
                dataType : "json",
                responseType : "json",
                url : url,
                data : form_data,
                success : function (response) {
                  console.log(response);
                  if(response.success == true){
                    $.notify({
                      message:"Settings Changed Successfully"
                    },{
                        type : "success"  
                    });
                  }else{
                    $.notify({
                      message:"Something Went Wrong"
                    },{
                        type : "warning"  
                    });
                  }
                },error : function(){
                  $.notify({
                      message:"Something Went Wrong Check Your Internet Connection"
                    },{
                        type : "danger"  
                    });
                }
              }); 
            });
          });

          $(".settings-table tbody tr").click(function(){
            var checkBox = $(this).find('input');
            if(checkBox.is(':checked')){
              checkBox.prop('checked', false);
            }else{
             checkBox.prop('checked', true); 
            }
          });

          $("#change-password-from").submit(function (evt) {
            evt.preventDefault();
            var form_data = $(this).serializeArray();
            form_data.push({
              'name' : 'change_password',
              'value' : 'true'
            });
            var url = "<?php echo site_url('meetglobal/process_change_password') ?>";
            // console.log(form_data);
            $.ajax({
              type : "POST",
              dataType : "json",
              responseType : "json",
              url : url,
              data : form_data,
              success : function (response) {
                if(response.success == true){
                  window.location.assign("<?php echo site_url('meetglobal/') ?>");
                }else if(response.wrong_password == true){
                  $.notify({
                    message:"Wrong Password Inputed. Please Try Again"
                  },{
                    type : "warning"  
                  });
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
                $.notify({
                message:"Sorry Something Went Wrong"
                },{
                  type : "danger"  
                });
              } 
            });   
          })
        })
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 