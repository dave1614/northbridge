
<style>
  img{
    width: 100%;
    height: 350px;
  }

  
  #edit-profile-form{
    margin-top: 30px;
    margin-bottom: 30px;
  }

  #edit-profile-form label{
    color: #7ea960;
  }
  /*.btn.btn-primary:focus,
  .btn.btn-primary:active,
  .btn.btn-primary:hover{
    color: #7ea960;
    background-color: #fff;
    border-color: #7ea960;
  }*/

  /*#submit-button:hover {
    background-image:none;
   }

  .btn.btn-primary{
    color: #fff;
    background-color: #7ea960;
    border-color: #7ea960;
    transition: 2s;
  }
*/
  .heading-text{
    color: #7ea960;
    font-size: 35px;
    font-weight: bold;
    margin-top: 35px;
  }

  form .btn.btn-submit{
    background-color: #7ea960;
    border-color: #7ea960;
    color: #fff;

  }

  form .spinner-border{
      display: none;
    }
</style>
<script>
  function openTermsAndConditionsModal (elem,evt) {
    console.log('heheh')
    $("#terms-and-conditions-modal").modal("show");
    
  }

  function openSettingsModal (elem,evt) {
    $("#settings-modal").modal("show");
  }

  function changePasswordSelected(elem,evt){
    evt.preventDefault()
    $("#settings-modal").modal("hide");
    setTimeout(function () {
      $("#change-password-modal").modal("show");
    }, 500);
  }
</script>
<!-- Page Content -->
  <div class="">
    <div class="container-fluid">
      <div class="spinner-overlay" style="display: none;">
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader (2).gif') ?>" alt="Loading..." style="">
        </div>
      </div>
      <h3 class="text-center heading-text">SuperForex Live Account</h3>
      <div class="row justify-content-center">
        <div class="card shadow col-sm-6" style="min-height: 300px; margin-top: 30px;">
          <div class="card-body">
            <?php 
              $super_forex_account_number = $this->sabicapital_model->getUserParamById("super_forex_account_number",$user_id);
              $live_account_request_approved = $this->sabicapital_model->getUserParamById("live_account_request_approved",$user_id);
              $live_account_request_approved_date_time = $this->sabicapital_model->getUserParamById("live_account_request_approved_date_time",$user_id);
              if($super_forex_account_number != "" && $live_account_request_approved == 1){
            ?>

            <h5 style="color: #7ea960;">Super Forex Account Approved On:  <em ><?php echo $live_account_request_approved_date_time; ?></em></h5>
            <h5 style="color: #7ea960;">Super Forex Account Number: <em class="text-primary"><?php echo $super_forex_account_number; ?></em></h5>

            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div style="color: #7ea960;" class="modal fade" data-backdrop="static" id="settings-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center" style="color: #7ea960; text-transform: capitalize;">Choose Action</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body" style="padding: 0;">
          <div class="list-group">
            <a href="<?php echo site_url('sabicapital/fund_superforex_account') ?>" class="list-group-item" style="color: #7ea960;" >Fund Account</a>
            <a href="<?php echo site_url('sabicapital/withdraw_superforex_account') ?>" class="list-group-item" style="color: #7ea960;">Withdraw</a>
            
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
        </div>
      </div>
    </div>
  </div>

  <div  class="modal fade" data-backdrop="static" id="change-password-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center" style="color: #7ea960; text-transform: capitalize;">Change Your Password</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body">
          <?php 
              $attr = array('class' => 'container','id' => 'change-password-form');
              echo form_open('sabicapital/process_sign_in',$attr);
            ?>

              <div class="form-group">
                
                <input type="text" class="form-control shadow-sm" id="old_password" name="old_password" placeholder="Enter Old Password">
                <span class="form-error"></span>
              </div>
              
              <div class="form-group">
                
                <input type="text" class="form-control shadow-sm" id="new_password" name="new_password" placeholder="Enter New Password">
                <span class="form-error"></span>
              </div>
              <button class="btn btn-submit btn-block text-center shadow-sm" type="submit">
                Submit 
                <!-- <div class="clearfix"> -->
                  <div style="margin-bottom:20px;" class="spinner-border spinner-border-sm float-right" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                <!-- </div> -->
              </button>
              
            </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
        </div>
      </div>
    </div>
  </div>
  
  <?php 
    $super_forex_account_number = $this->sabicapital_model->getUserParamById("super_forex_account_number",$user_id);
    $live_account_request_approved = $this->sabicapital_model->getUserParamById("live_account_request_approved",$user_id);
    $live_account_request_approved_date_time = $this->sabicapital_model->getUserParamById("live_account_request_approved_date_time",$user_id);
    if($super_forex_account_number != "" && $live_account_request_approved == 1){
  ?>
  <div id="choose-function-mlm-btn" onclick="openSettingsModal(this,event)" rel="tooltip" data-toggle="tooltip" title="Fund Account Or Withdraw" style="background: #7ea960; cursor: pointer; position: fixed; bottom: 0; right: 0;  border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
    <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
      <i class="fas fa-cog" style="font-size: 25px; color: #fff;" aria-hidden="true"></i>
    </div>
  </div>

  <?php } ?>


  <script>
    $(document).ready(function () {
      
      <?php 
      if(!$this->sabicapital_model->checkIfFullUserDataHasBeenEnteredByUser($user_id)){
      ?>
      swal({
        title: 'Incomplete Information',
        text: "Your Information Is Not Enough To Open A Live Account. Click Ok To Input These Details",
        type: 'info',
        allowOutsideClick: false
      }).then(function(){
        window.location.assign("<?php echo site_url('sabicapital/edit_profile') ?>")
      });
      <?php
      }else{
        if($this->sabicapital_model->checkIfUserHasRequestedToOpenLiveAccount($user_id)){
          if($this->sabicapital_model->checkIfAdminHasApprovedUsersRequestToOpenLiveAccount($user_id)){

          }else{
      $live_account_request_date_time = $this->sabicapital_model->getUserParamById("live_account_request_date_time",$user_id);
      ?>
      swal({
        title: 'Live Account Pending',
        text: "Your Request To Open A Live Account At <?php echo $live_account_request_date_time; ?>  Is Still Pending",
        type: 'info',
        allowOutsideClick: false
      }).then(function(){
        window.location.assign("<?php echo site_url('sabicapital/') ?>")
      });
      // setTimeout(function () {
      //   window.location.assign("<?php echo site_url('sabicapital/') ?>")
      // }, 3000)
      <?php
          }
        }else{
      ?>
        swal({
          title: 'Note',
          text: "To Proceed With Requesting For SuperForex Live Account. Click Ok.",
          type: 'info',
          allowOutsideClick: false
        }).then(function(){
          
          $(".spinner-overlay").show();
          // $("#main-page-col-md-12").hide();
          var form_data = {
            show_records : true
          }
          var url = "<?php echo site_url('sabicapital/request_live_account'); ?>"
          $.ajax({
            url : url,
            type : "POST",
            responseType : "json",
            dataType : "json",
            data : form_data,
            success : function (response) {
              $(".spinner-overlay").hide();
              // $("#main-page-col-md-12").show();
              if(response.success ){
                $.notify({
                  message:"Your Request For Live Account Has Successfully Been Sent To The Admin"
                },{
                  type : "success"  
                });
                setTimeout(function () {
                  window.location.assign("<?php echo site_url('sabicapital') ?>");
                }, 3000)
              }else{
                swal({
                  title: 'Ooops',
                  text: "Something Went Wrong",
                  type: 'warning'
                })
                setTimeout(function () {
                  document.location.reload()
                }, 1000)
              }
            },error : function () {
              $(".spinner-overlay").hide();
              // $("#main-page-col-md-12").show();
              swal({
                title: 'Ooops',
                text: "Something Went Wrong",
                type: 'error'
              })
              setTimeout(function () {
                  document.location.reload()
                }, 1000)
            }
          });
        });
      <?php
        }
      }
      ?>
    })
  </script>