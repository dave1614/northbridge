
<style>
  img{
    width: 100%;
    height: 350px;
  }

  
  form{
    margin-top: 30px;
    margin-bottom: 30px;
  }

  form label{
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

  function calculateNairaEquivalent(elem,evt) {
    elem = $(elem);
    var amount = elem.val();
    var rate = <?php echo $this->sabicapital_model->getWithdrawExchangeRate(); ?>;
    var naira_equivalent = (amount * rate).toFixed(2);
    console.log(naira_equivalent)
    $("#withdraw-superforex-account-form #naira-equivalent").html("Amount To Pay: ₦" + addCommas(naira_equivalent));

  }

  function viewAccountWithdrawalHistory (elem,evt) {
    $("#view-superforex-funding-history-btn").hide("fast");
    $("#main-card").hide();
    $("#view-your-withdrawal-requests-card").show();

  }

  function goBackFromViewYourWithdrawalRequestsCard (elem,evt) {
    $("#view-your-withdrawal-requests-card").hide();
    $("#view-superforex-funding-history-btn").show("fast");
    $("#main-card").show();
    
  }

  function viewYourPendingWithdrawalRequests (elem,evt) {
    var url = "<?php echo site_url('sabicapital/view_your_pending_superforex_withdrawal_requests') ?>";
    var form_data = {
      'show_records' : true
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
          $("#view-your-withdrawal-requests-card").hide();
          $("#view-pending-withdrawal-requests-card .card-body").html(messages);
          $("#view-pending-withdrawal-requests-card #view-pending-withdrawal-requests-table").DataTable();
          $('[rel=tooltip]').tooltip();
          $("#view-pending-withdrawal-requests-card").show();
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

  function goBackFromViewPendingDepositRequestsCard (elem,evt) {
    $("#view-your-withdrawal-requests-card").show();
    
    $("#view-pending-withdrawal-requests-card").hide();
  }
  


  

  function goBackFromViewApprovedWithdrawalRequestsCard (elem,evt) {
    $("#view-your-withdrawal-requests-card").show();
    $("#view-approved-withdrawal-requests-card").hide();
  }

  function goBackFromViewDeclinedWithdrawalRequestsCard (elem,evt) {
    $("#view-your-withdrawal-requests-card").show();
    $("#view-declined-withdrawal-requests-card").hide();
  }

  function viewPaymentDetailsOfWithdrawalRequest(elem,evt,id){
    var url = "<?php echo site_url('sabicapital/view_payment_details_of_your_withdrawal_request') ?>";
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
          
          $("#view-payment-details-of-withdrawal-request-modal .modal-body").html(messages);
          $("#view-payment-details-of-withdrawal-request-modal").modal("show");
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

  function viewYourApprovedWithdrawalRequests (elem,evt) {
    var url = "<?php echo site_url('sabicapital/view_your_approved_superforex_withdrawal_requests') ?>";
    var form_data = {
      'show_records' : true
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
          $("#view-your-withdrawal-requests-card").hide();
          $("#view-approved-withdrawal-requests-card .card-body").html(messages);
          $("#view-approved-withdrawal-requests-card #view-approved-withdrawal-requests-table").DataTable();
          $('[rel=tooltip]').tooltip();
          $("#view-approved-withdrawal-requests-card").show();
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

  function viewYourDeclinedWithdrawalRequests (elem,evt) {
    var url = "<?php echo site_url('sabicapital/view_your_declined_superforex_withdrawal_requests') ?>";
    var form_data = {
      'show_records' : true
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
          $("#view-your-withdrawal-requests-card").hide();
          $("#view-declined-withdrawal-requests-card .card-body").html(messages);
          $("#view-declined-withdrawal-requests-card #view-declined-withdrawal-requests-table").DataTable();
          $('[rel=tooltip]').tooltip();
          $("#view-declined-withdrawal-requests-card").show();
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
</script>
<!-- Page Content -->
  <div class="">
    <div class="container-fluid">
      <div class="spinner-overlay" style="display: none;">
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader (2).gif') ?>" alt="Loading..." style="">
        </div>
      </div>
      <h3 class="text-center heading-text">Withdraw From Your SuperForex Account</h3>
      
      <div class="row justify-content-center">

        <div class="card shadow col-sm-6" id="view-declined-withdrawal-requests-card" style="display: none; color: #000;">
          <div class="card-header">
            <button class="btn btn-warning" onclick="goBackFromViewDeclinedWithdrawalRequestsCard(this,event)">Go Back</button>
            <h3 class="card-title" style="color: #7ea960;">All Your Declined Funds Withdrawal Requests: </h3>
          </div>
          <div class="card-body">
            
          </div>
        </div>

        <div class="card shadow col-sm-6" id="view-approved-withdrawal-requests-card" style="display: none; color: #000;">
          <div class="card-header">
            <button class="btn btn-warning" onclick="goBackFromViewApprovedWithdrawalRequestsCard(this,event)">Go Back</button>
            <h3 class="card-title" style="color: #7ea960;">All Your Approved Funds Withdrawal Requests: </h3>
          </div>
          <div class="card-body">
            
          </div>
        </div>

        <div class="card shadow col-sm-6" id="view-pending-withdrawal-requests-card" style="display: none; color: #000;">
          <div class="card-header">
            <button class="btn btn-warning" onclick="goBackFromViewPendingDepositRequestsCard(this,event)">Go Back</button>
            <h3 class="card-title" style="color: #7ea960;">All Your Pending Withdrawal Requests: </h3>
          </div>
          <div class="card-body">
            
          </div>
        </div>

        <div class="card shadow col-sm-6" id="view-your-withdrawal-requests-card" style="display: none; color: #7ea960;">
          <div class="card-header">
            <button class="btn btn-warning" onclick="goBackFromViewYourWithdrawalRequestsCard(this,event)">Go Back</button>
            <h3 class="card-title">View Your: </h3>
          </div>
          <div class="card-body" style="margin-top: 40px;">
            <button class="btn btn-primary" onclick="viewYourPendingWithdrawalRequests(this,event)">Pending Requests</button>
            <button class="btn btn-info" onclick="viewYourApprovedWithdrawalRequests(this,event)">Approved Requests</button>
            <button class="btn btn-success" onclick="viewYourDeclinedWithdrawalRequests(this,event)">Declined Requests</button>
          </div>
        </div>

        <div class="card shadow col-sm-6" style="min-height: 300px; margin-top: 30px;" id="main-card">
          <div class="card-body">
            <?php
            $attr = array('id' => 'withdraw-superforex-account-form');
            echo form_open_multipart('sabicapital/withdraw_from_your_superforex_account',$attr);
            ?>
            <p style="color: #7ea960;">Exchange Rate: ₦<?php echo number_format($this->sabicapital_model->getWithdrawExchangeRate(),2); ?></p>
           
              
              <div class="form-group">
                <label for="full_name">Full Name: </label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?php echo $full_name; ?>">
                <span class="form-error"></span>
              </div>
              <div class="form-group">
                <label for="super_forex_account_number">Superforex Account Number: </label>
                <input type="text" id="super_forex_account_number" name="super_forex_account_number" class="form-control" value="<?php echo $super_forex_account_number; ?>">
                <span class="form-error"></span>
              </div>
              <div class="form-group">
                <label for="phone_password ">Phone Password: </label>
                <input type="text" id="phone_password" name="phone_password" class="form-control" value="">
                <span class="form-error"></span>
              </div>
              <div class="form-group">
                <label for="amount">Amount ($): </label>
                <input type="number" id="amount" name="amount" class="form-control" step="any" onkeyup="calculateNairaEquivalent(this,event)">
                <p style="color: #7ea960;" id="naira-equivalent"></p>
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
        </div>
      </div>
    </div>
  </div>

  <div style="color: #7ea960;" class="modal fade" data-backdrop="static" id="view-payment-details-of-withdrawal-request-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center" style="color: #7ea960; text-transform: capitalize;">Payment Details</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body">
          
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
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
  
  
  <div id="view-superforex-funding-history-btn" onclick="viewAccountWithdrawalHistory(this,event)" rel="tooltip" data-toggle="tooltip" title="View Your Withdrawal History" style="background: #7ea960; cursor: pointer; position: fixed; bottom: 0; right: 0;  border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
    <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
      <i class="fas fa-history" style="font-size: 25px; color: #fff;" aria-hidden="true"></i>
    </div>
  </div>

  


  <script>
    $(document).ready(function () {

      $("#withdraw-superforex-account-form").submit(function (evt) {
        evt.preventDefault();
        var me = $(this);
        var url = me.attr("action");
        var form_data = me.serializeArray();
        var spinner = me.find(".spinner-border");
        var submit_btn = me.find("button");

        console.log(form_data)
        spinner.show();
        submit_btn.addClass('disabled');
        submit_btn.css({
          "cursor" : "unset"
        })

        $.ajax({
          url : url,
          type : "POST",
          responseType : "json",
          dataType : "json",
          data : form_data,
          success : function (response) {
            spinner.hide();
            submit_btn.removeClass('disabled');
            submit_btn.css({
              "cursor" : "pointer"
            })
            
            if(response.success){
              me.find(".form-error").html("");
              $.notify({
                message:"Your Request To Withdraw From Your Superforex Has Been Sent To The Admin Successfully. Click The History Button To Track."
              },{
                type : "success"  
              });
              setTimeout(function () {
                document.location.reload()
              }, 2000)
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
            spinner.hide();
            submit_btn.removeClass('disabled');
            submit_btn.css({
              "cursor" : "pointer"
            })   
            swal({
              title: 'Ooops',
              text: "Something Went Wrong. Please Check Your Internet Connection",
              type: 'error',                              
            })
          }
        });

      })

      <?php if(!$this->sabicapital_model->checkIfPayentDetailsHaveInputed($user_id)){ ?>
      swal({
        title: 'Payment Details',
        html: "To Request A Withdrawal, You Have To Input Your Payment Details. <br> <em class='text-primary'>Click OK And Click The Settings Button On Your Edit Profile Page To Add Payment Details</em>",
        type: 'info',
        allowOutsideClick: false
      }).then(function(){
        var url = "<?php echo site_url('sabicapital/edit_profile') ?>";
        window.location.assign(url)
      }); 
      <?php } ?>
    })
  </script>