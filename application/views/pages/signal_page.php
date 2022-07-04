
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
    $("#sabi-academy-form #naira-equivalent").html("Amount To Pay: ₦" + addCommas(naira_equivalent));

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
      <h3 class="text-center heading-text">Signal Page</h3>
      
      <div class="row justify-content-center">


          <div class="tradingview-widget-container col-sm-12" style="width: 100%; height: 72px;">
            <iframe sandbox="allow-same-origin allow-scripts allow-popups allow-forms" scrolling="no" allowtransparency="true" frameborder="0" src="https://s.tradingview.com/embed-widget/tickers/?locale=en#%7B%22symbols%22%3A%5B%7B%22title%22%3A%22AUD%2FNZD%22%2C%22proName%22%3A%22AUDNZD%22%7D%2C%7B%22title%22%3A%22EUR%2FGBP%22%2C%22proName%22%3A%22EURGBP%22%7D%2C%7B%22title%22%3A%22EUR%2FUSD%22%2C%22proName%22%3A%22EURUSD%22%7D%2C%7B%22title%22%3A%22GBP%2FUSD%22%2C%22proName%22%3A%22GBPUSD%22%7D%2C%7B%22title%22%3A%22USD%2FCHF%22%2C%22proName%22%3A%22USDCHF%22%7D%2C%7B%22title%22%3A%22USD%2FCAD%22%2C%22proName%22%3A%22USDCAD%22%7D%2C%7B%22title%22%3A%22USD%2FJPY%22%2C%22proName%22%3A%22USDJPY%22%7D%2C%7B%22title%22%3A%22AUD%2FUSD%22%2C%22proName%22%3A%22AUDUSD%22%7D%2C%7B%22title%22%3A%22GBP%2FJPY%22%2C%22proName%22%3A%22GBPJPY%22%7D%2C%7B%22title%22%3A%22EUR%2FJPY%22%2C%22proName%22%3A%22EURJPY%22%7D%2C%7B%22title%22%3A%22NZD%2FUSD%22%2C%22proName%22%3A%22NZDUSD%22%7D%2C%7B%22title%22%3A%22GBP%2FAUD%22%2C%22proName%22%3A%22GBPAUD%22%7D%2C%7B%22title%22%3A%22%23CL%20(Crude%20Light%20-%20Oil)%22%2C%22proName%22%3A%22%23CL%20(Crude%20Light%20-%20Oil)%22%7D%2C%7B%22title%22%3A%22XAU%2FUSD%22%2C%22proName%22%3A%22XAUUSD%22%7D%2C%7B%22title%22%3A%22GOLD%20(SPOT)%22%2C%22proName%22%3A%22GOLD%20(SPOT)%22%7D%2C%7B%22title%22%3A%22EUR%2FCHF%22%2C%22proName%22%3A%22EURCHF%22%7D%2C%7B%22title%22%3A%22USD%2FTRY%22%2C%22proName%22%3A%22USDTRY%22%7D%2C%7B%22title%22%3A%22EUR%2FNZD%22%2C%22proName%22%3A%22EURNZD%22%7D%2C%7B%22title%22%3A%22EUR%2FCAD%22%2C%22proName%22%3A%22EURCAD%22%7D%2C%7B%22title%22%3A%22EUR%2FAUD%22%2C%22proName%22%3A%22EURAUD%22%7D%2C%7B%22title%22%3A%22GBP%2FCHF%22%2C%22proName%22%3A%22GBPCHF%22%7D%2C%7B%22title%22%3A%22AUD%2FJPY%22%2C%22proName%22%3A%22AUDJPY%22%7D%2C%7B%22title%22%3A%22GBP%2FCAD%22%2C%22proName%22%3A%22GBPCAD%22%7D%2C%7B%22title%22%3A%22GBP%2FNZD%22%2C%22proName%22%3A%22GBPNZD%22%7D%2C%7B%22title%22%3A%22NZD%2FCHF%22%2C%22proName%22%3A%22NZDCHF%22%7D%2C%7B%22title%22%3A%22CAD%2FJPY%22%2C%22proName%22%3A%22CADJPY%22%7D%2C%7B%22title%22%3A%22AUD%2FCAD%22%2C%22proName%22%3A%22AUDCAD%22%7D%2C%7B%22title%22%3A%22AUD%2FCHF%22%2C%22proName%22%3A%22AUDCHF%22%7D%2C%7B%22title%22%3A%22CHF%2FJPY%22%2C%22proName%22%3A%22CHFJPY%22%7D%2C%7B%22title%22%3A%22NZD%2FJPY%22%2C%22proName%22%3A%22NZDJPY%22%7D%2C%7B%22title%22%3A%22NZD%2FCAD%22%2C%22proName%22%3A%22NZDCAD%22%7D%2C%7B%22title%22%3A%22CAD%2FCHF%22%2C%22proName%22%3A%22CADCHF%22%7D%5D%2C%22width%22%3A%22100%25%22%2C%22height%22%3A72%2C%22utm_source%22%3A%22instafxng.com%22%2C%22utm_medium%22%3A%22widget%22%2C%22utm_campaign%22%3A%22tickers%22%7D" style="box-sizing: border-box; height: 72px; width: 100%;">

            
            </iframe>
          </div>

          <div class="card shadow col-sm-6" id="todays-signals-card" style="display: none; color: #7ea960; margin-top: 40px;">
              <div class="card-header">
                
                <h3 class="card-title text-center"> Signals Today </h3>
              </div>
              <div class="card-body">
              <?php
              if(isset($rows)){
                if(is_array($rows)){
                  foreach($rows as $row){
                      
                    $id = $row->id;
                    
                    $currency_pair = $row->currency_pair;
                    $buy_val = $row->buy_val;
                    $buy_tp = $row->buy_tp;
                    $buy_sl = $row->buy_sl;

                    $sell_val = $row->sell_val;
                    $sell_tp = $row->sell_tp;
                    $sell_sl = $row->sell_sl;
                    $date = $row->date;
                    $time = $row->time;
              ?>
                    <div class="card">
                      <div class="card-body row">
                        <h4 class="text-center col-12"><?php echo $currency_pair; ?></h4>
                        <h5 class="col-6">Buy: </h5><h5 class="col-6"><em class="text-primary"><?php echo $buy_val; ?></em></h5>
                        <h5 class="col-6">TP: </h5><h5 class="col-6"><em class="text-primary"><?php echo $buy_tp; ?></em></h5>
                        <h5 class="col-6">SL: </h5><h5 class="col-6"><em class="text-primary"><?php echo $buy_sl; ?></em></h5> <br><br>

                        <h5 class="col-6">Sell: </h5><h5 class="col-6"><em class="text-primary"><?php echo $sell_val; ?></em></h5>
                        <h5 class="col-6">TP: </h5><h5 class="col-6"><em class="text-primary"><?php echo $sell_tp; ?></em></h5>
                        <h5 class="col-6">SL: </h5><h5 class="col-6"><em class="text-primary"><?php echo $sell_sl; ?></em></h5>
                      </div>
                    </div>
              <?php  

                  }
                        
                }else{
                  echo "<h5 class='text-warning'>No Signals Today</h5>";
                }
              } 
              ?>
              </div>
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

  <div  class="modal fade" data-backdrop="static" id="enter-email-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center" style="color: #7ea960; text-transform: capitalize;">Enter Your Email</h4>
          
        </div>
        <div class="modal-body" id="modal-body">
          <?php 
              $attr = array('class' => 'container','id' => 'enter-email-form');
              echo form_open('sabicapital/check_if_email_is_valid',$attr);
            ?>

              <div class="form-group">
                
                <input type="email" class="form-control shadow-sm" id="email" name="email" placeholder="">
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
  
  
  <!-- <div id="view-superforex-funding-history-btn" onclick="viewAccountWithdrawalHistory(this,event)" rel="tooltip" data-toggle="tooltip" title="View Your Withdrawal History" style="background: #7ea960; cursor: pointer; position: fixed; bottom: 0; right: 0;  border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
    <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
      <i class="fas fa-history" style="font-size: 25px; color: #fff;" aria-hidden="true"></i>
    </div>
  </div> -->

  


  <script>
    $(document).ready(function () {

      $('#enter-email-modal').modal({
          backdrop: 'static',
          keyboard: false,
          show: true
      })

      $('.tradingview-widget-container iframe').click(false);

      $("#enter-email-form").submit(function (evt) {
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
              $('#enter-email-modal').modal("hide");
              $('#todays-signals-card').show();
            }else{
              swal({
                title: 'Ooops',
                text: "Invalid Email",
                type: 'error',                              
              })
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
    })
  </script>