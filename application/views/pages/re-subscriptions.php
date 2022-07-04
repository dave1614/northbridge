         <!-- End Navbar -->
      <style>
        .sum{
          font-style: italic;
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

          function acNewPackage (elem,type) {
            if(type == "new_nigeria"){
              $("#add-sub-modal #choose-interval-form").attr("data-type","new_nigeria");
            }else if(type == "great_nigeria"){
              $("#add-sub-modal #choose-interval-form").attr("data-type","great_nigeria");
            }

            var form_data = "type="+type;
            var url = "<?php echo site_url('meetglobal/check_if_there_is_space_resubscription') ?>";
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
                if(response.success == true){
                  $("#add-sub-modal #first-div").hide();
                  $("#add-sub-modal #choose-interval-form").show();
                }else if(response.no_space == true){
                  swal({
                    title: 'Active Resubscription',
                    text: "Sorry You Already Have An Active Resubscription Plan On This Package",
                    type: 'error',
                    allowOutsideClick: false,
                    allowEscapeKey:false,
                    confirmButtonColor: '#3085d6',                       
                    confirmButtonText: 'Ok'
                  });
                }else{
                  $.notify({
                  message:"Sorry Something Went Wrong."
                  },{
                    type : "warning"  
                  });
                }
              },error : function () {
                $.notify({
                message:"Something Went Wrong. Please Check Your Internet Connection And Try Again"
                },{
                  type : "danger"  
                });
              } 
            });   
            
          }

          function exitSub(elem,type) {
            swal({
              title: 'Proceed ?',
              text: "Are You Sure You Want To Proceed ?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Proceed',
              cancelButtonText : "Go Back"
            }).then(function(){
              $(".spinner-overlay").show();
                var url = "<?php echo site_url('meetglobal/exit_active_sub') ?>";
                var form_data = "exit_active_sub=true&type="+type
                $.ajax({
                  type : "POST",
                  dataType : "json",
                  responseType : "json",
                  url : url,
                  data : form_data,
                  success : function (response) {
                    $(".spinner-overlay").hide();
                    console.log(response)
                    if(response.success == true){
                      reloadPage();
                    }else{
                      $.notify({
                    message:"Sorry Something Went Wrong."
                    },{
                      type : "warning"  
                    });
                    }
                  },error : function () {
                    $.notify({
                    message:"Something Went Wrong. Please Check Your Internet Connection And Try Again"
                    },{
                      type : "danger"  
                    });
                  } 
                });     
            });
          }
      </script>
      <div class="content">
        <div class="container-fluid">
          <div class="spinner-overlay" style="display: none;">
            <div class="spinner-well">
              <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading..." style="">
            </div>
          </div>
          <h2>Active Automatic Resubscriptions</h2>
          <div class="row justify-content-center">
            <div class="col-sm-10">
              <div class="card">
                <div class="card-header">
                  
                </div>
                <div class="card-body">
                  <div class="wrap">
                    <h3>New Ambassador</h3>
                    <?php if($this->meetglobal_model->checkIfThereIsActiveResubscription("new_nigeria")){ ?>
                    <p class="text-capital">Active Subscription: <span class="sum text-primary">Yes</span></p>
                    <p class="text-capital">Subscription Interval: <span class="sum text-primary"><?php echo $this->meetglobal_model->getActiveSubscriptionInterval("new_nigeria"); ?></span></p>
                    <p class="text-capital">Start Date: <span class="sum text-primary"><?php echo $this->meetglobal_model->getActiveSubscriptionStart("new_nigeria"); ?></span></p>
                   
                    <?php }else{ ?>
                      <p class="text-warning" style=" font-style: italic;">Sorry You Do Not Have An Active New Ambassador Resubscription Set. Click The Floating Action Button To Set.</p>
                    <?php } ?>
                  </div>

                  <div class="wrap">
                    <h3>Great Ambassador</h3>
                    <?php if($this->meetglobal_model->checkIfThereIsActiveResubscription("great_nigeria")){ ?>
                    <p class="text-capital">Active Subscription: <span class="sum text-primary">Yes</span></p>
                    <p class="text-capital">Subscription Interval: <span class="sum text-primary"><?php echo $this->meetglobal_model->getActiveSubscriptionInterval("great_nigeria"); ?></span></p>
                    <p class="text-capital">Start Date: <span class="sum text-primary"><?php echo $this->meetglobal_model->getActiveSubscriptionStart("great_nigeria"); ?></span></p>
                    <?php }else{ ?>
                      <p class="text-warning" style=" font-style: italic;">Sorry You Do Not Have An Active Great Ambassador Resubscription Set. Click The Floating Action Button To Set.</p>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="modal fade" data-backdrop="false" id="add-sub-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h3 class="modal-title">Activate Subscription</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body" id="modal-body">
                  <div id="first-div">
                    <p>Choose Package: </p>
                    <button class="btn btn-primary" onclick="acNewPackage(this,'new_nigeria')">New Ambassador</button>
                    <button class="btn btn-info" onclick="acNewPackage(this,'great_nigeria')">Great Ambassador</button>
                  </div>

                  <?php 
                    $attr = array('id' => 'choose-interval-form','style' => 'display:none;');
                    echo form_open("",$attr);
                  ?>
                    <div class="form-group col-sm-12">
                      <label for="choose_interval">Choose Interval: </label>
                      <select name="choose_interval" id="choose_interval" class="form-control selectpicker" data-style="btn btn-link" required>
                        
                        <option value="biweekly">Bi-Weekly</option>
                        <option value="monthly">Monthly</option>
                      </select>
                      <span class="form-error"></span>
                    </div>

                    <input type="submit" class="btn btn-success">
    
                  </form>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>  
          </div>
          <div rel="tooltip" data-toggle="modal" data-target="#add-sub-modal" data-toggle="tooltip" title="Activate Subscription" style="cursor: pointer; position: fixed; bottom: 0; right: 0; background: #e91e63; border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
          <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
            <i class="fa fa-plus" style="font-size: 25px; font-weight: normal; color: #fff;" aria-hidden="true"></i>

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
          $("#info-table").DataTable();
          $("#choose-interval-form").submit(function (evt) {
            evt.preventDefault();
            var url = "<?php echo site_url('meetglobal/set_resubscription') ?>";
            var type = $(this).attr("data-type");
            var form_data = $(this).serializeArray();
            form_data.push({"name" : "type","value" : type})
            if(type == "new_nigeria" || type == "great_nigeria"){
              swal({
                title: 'Proceed ?',
                text: "Are You Sure You Want To Proceed ?",
                type: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText : "No"
              }).then(function(){
                console.log(form_data)
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
                    if(response.success == true){
                      reloadPage();
                    }else if(response.bouyant == false){
                      
                      swal({
                        title: 'Insuffecient Balance',
                        text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                        type: 'error',
                        allowOutsideClick: false,
                        allowEscapeKey:false,
                        confirmButtonColor: '#3085d6',                       
                        confirmButtonText: 'Ok'
                        
                      });
                    }else if(response.messags !== ""){
                      $.each(response.messages, function (key,value) {
                        var element = $('#'+key);                       
                        element.closest('div.form-group')                               
                                .find('.form-error').remove();
                        element.after(value);
                      });

                    }else{
                      $.notify({
                      message:"Sorry Something Went Wrong."
                      },{
                        type : "warning"  
                      });
                    }
                  },error : function () {
                    $.notify({
                    message:"Something Went Wrong. Please Check Your Internet Connection And Try Again"
                    },{
                      type : "danger"  
                    });
                  } 
                });   
              }, function(dismiss){
                 if(dismiss == 'cancel'){
                     // function when cancel button is clicked
                     console.log('cancelled');
                 }
              });   
            }else if(type == "great_nigeria"){

            }else{
              reloadPage();
            }
          })

          <?php
           if($this->session->success && $this->session->success == true){ 
            unset($_SESSION['success']);
            ?>
            $.notify({
            message:"Automatic Resubscription Set Successfully"
            },{
              type : "success"  
            });
          <?php } ?>

          <?php
           if($this->session->cancel_success){ 
            $type = $this->session->cancel_success;
            unset($_SESSION['cancel_success']);
            if($type == "new_nigeria"){
              $type = "New Ambassador";
            }elseif($type == "great_nigeria"){
              $type = "Great Ambassador";
            }
            ?>
            $.notify({
            message:"Automatic Resubscription For <?php echo $type; ?> Cancelled Successfully"
            },{
              type : "success"  
            });
          <?php } ?>
        })
        
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 