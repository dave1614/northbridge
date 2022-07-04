         <!-- End Navbar -->
<style>
  tr{
    cursor: pointer;
  }
</style>
<script>
  var data_combo = false;
  var productCode = "";

  function loadAirtime(elem,evt){
    $("#choose-action-card").hide();
    $("#airtime-operator-card").show();
  }

  function  goBackFromSelectOperatorAirtimeCard (elem,evt) {
    $("#choose-action-card").show();
    $("#airtime-operator-card").hide();
  }

  function selectedAirtimeOperator (elem,evt) {
    elem = $(elem);
    var id = elem.attr("id");
    $("#enter-amount-airtime-form").attr("data-type",id);
    $("#enter-amount-airtime-modal").modal("show");
  }

  function loadData (elem,evt) {
    $("#choose-action-card").hide();
    $("#data-operator-card").show();
  }

  function goBackFromSelectOperatorDataCard (elem,evt) {
    $("#choose-action-card").show();
    $("#data-operator-card").hide(); 

  }

  function selectedDataOperator (elem,evt) {
    elem = $(elem);
    var type = elem.attr("id");
    if(type == "9mobile-data"){
      swal({
        title: 'Choose Option',
        text: "Choose Recharge Option: ",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#4caf50',
        confirmButtonText: 'Normal Recharge',
        cancelButtonText : "Combo Recharge"
      }).then(function(){
        var url = "<?php echo site_url('meetglobal/get_data_bundles_for_operator_vtu') ?>";
        var form_data = {
          show_records : true,
          type : type
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
            if(response.success && response.messages != "" && response.network != ""){
              var messages = response.messages;
              var network = response.network;
              $("#data-bundle-card .card-title").html("Data Bundles For: " + network);
              $("#data-bundle-card .card-body").html(messages);
              $("#data-bundle-card #data-bundles-table").DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
              });
              $("#data-bundle-card").show();
              $("#data-operator-card").hide();
            }else{
              $(".spinner-overlay").hide();
              $.notify({
                message:"Sorry Something Went Wrong."
                },{
                  type : "warning" 
              });
            }
          },error: function () {
            $(".spinner-overlay").hide();
            $.notify({
              message:"Sorry Something Went Wrong. Please Check Your Internet Connection"
              },{
                type : "danger" 
            });
          }
        });
      },function(dismiss){
        if(dismiss == 'cancel'){
          var url = "<?php echo site_url('meetglobal/get_data_bundles_for_9mobile_combo') ?>";
          var form_data = {
            show_records : true,
            type : type
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
              if(response.success && response.messages != "" && response.network != ""){
                var messages = response.messages;
                var network = response.network;
                $("#data-bundle-card .card-title").html("Data Bundles For: " + network);
                $("#data-bundle-card .card-body").html(messages);
                $("#data-bundle-card #data-bundles-table").DataTable({
                  aLengthMenu: [
                      [25, 50, 100, 200, -1],
                      [25, 50, 100, 200, "All"]
                  ],
                  iDisplayLength: -1
                });
                $("#data-bundle-card").show();
                $("#data-operator-card").hide();
              }else{
                $(".spinner-overlay").hide();
                $.notify({
                  message:"Sorry Something Went Wrong."
                  },{
                    type : "warning" 
                });
              }
            },error: function () {
              $(".spinner-overlay").hide();
              $.notify({
                message:"Sorry Something Went Wrong. Please Check Your Internet Connection"
                },{
                  type : "danger" 
              });
            }
          });
        }
      });  
    }else{
      var url = "<?php echo site_url('meetglobal/get_data_bundles_for_operator_vtu') ?>";
      var form_data = {
        show_records : true,
        type : type
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
          if(response.success && response.messages != "" && response.network != ""){
            var messages = response.messages;
            var network = response.network;
            $("#data-bundle-card .card-title").html("Data Bundles For: " + network);
            $("#data-bundle-card .card-body").html(messages);
            $("#data-bundle-card #data-bundles-table").DataTable({
              aLengthMenu: [
                  [25, 50, 100, 200, -1],
                  [25, 50, 100, 200, "All"]
              ],
              iDisplayLength: -1
            });
            $("#data-bundle-card").show();
            $("#data-operator-card").hide();
          }else{
            $(".spinner-overlay").hide();
            $.notify({
              message:"Sorry Something Went Wrong."
              },{
                type : "warning" 
            });
          }
        },error: function () {
          $(".spinner-overlay").hide();
          $.notify({
            message:"Sorry Something Went Wrong. Please Check Your Internet Connection"
            },{
              type : "danger" 
          });
        }
      });
    }
  }

  function selectDataBundle(elem,evt,combo = false){
    elem = $(elem);
    if(combo){
      data_combo = true;
    }else{
      data_combo = false;
    }
    var product_id = elem.attr("data-product-id");
    var type = elem.attr("data-type");
    var product_name = elem.attr("data-product-name");
    var amount = elem.attr("data-amount");
    console.log(product_id);


    $("#enter-mobile-no-data-form").attr("data-product-id",product_id);
    $("#enter-mobile-no-data-form").attr("data-type",type);
    $("#enter-mobile-no-data-form").attr("data-product-name",product_name);
    $("#enter-mobile-no-data-form").attr("data-amount",amount);
    $("#enter-mobile-no-data-modal").modal("show");
  }

  function goBackDataBundleCard (elem,evt) {
    $("#data-bundle-card").hide();
    $("#data-operator-card").show(); 
  }

  function loadCableTv (elem,evt) {
    $("#choose-action-card").hide();
    $("#tv-operator-card").show();
  }

  function goBackFromSelectOperatorTvCard (elem,evt) {
    $("#choose-action-card").show();
    $("#tv-operator-card").hide();
  }

  function selectedTvOperator (elem,evt) {
    elem = $(elem);
    var type = elem.attr("id");
    
    if(type == "dstv" || type == "startimes"){
      $("#enter-iuc-no-data-modal .modal-title").html("Enter Smart Card Number");
      $("#enter-iuc-no-data-form .form-group label").html("Smart Card Number: ");
    }else if(type == "gotv"){
      $("#enter-iuc-no-data-modal .modal-title").html("Enter IUC Number");
      $("#enter-iuc-no-data-form .form-group label").html("IUC Card Number: ");
    }
    $("#enter-iuc-no-data-form").attr("data-type",type)
    $("#enter-iuc-no-data-modal").modal("show");
  }

  function goBackTvPackageCard (elem,evt) {
    $("#tv-operator-card").show();
    $("#enter-iuc-no-data-modal").modal("show");
    $("#tv-package-card").hide();
  }

  function selectTVPackage(elem,evt){
    elem = $(elem);
    var url = "<?php echo site_url('meetglobal/recharge_decoder') ?>";
    var type = elem.attr("data-type");
    var iuc_no = elem.attr("data-iuc-no");
    var package_name = elem.attr("data-package-name");
    var amount = elem.attr("data-amount");
    var package_id = elem.attr("data-package-id");

    var form_data = {
      "multichoice_type" : type,
      "smart_card_no" : iuc_no,
      "amount" : amount,
      "product_code" : package_id,
      "package_name" : package_name
    }
                    
    swal({
      title: 'Info',
      text: "You Are About To Credit "+ type +" Decoder With Number: <em class='text-primary'>" + iuc_no + "</em> With " + package_name +" Package On <span style='text-transform: capitalize;'>" + type + "</span>. Are You Sure You Want To Proceed? <p><em>Note You Would Be Debited Of ₦" + addCommas(amount) + "</em></p>" ,
      type: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes Proceed!',
      cancelButtonText : "No"
    }).then(function(){
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
          if(response.success && response.order_id !== ""){
            var order_id = response.order_id;
            swal({
              title: 'Info',
              text: "You Have Successfully Recharged Decoder With Number: <em class='text-primary'>" + iuc_no + ".</em> The Order Id For This Transaction Is <em class='text-primary'>" +order_id + "</em>",
              type: 'info',
              confirmButtonColor: '#3085d6'
            }).then(function(){
              document.location.reload();
            });
          }else if(response.invalid_no){
            swal({
              title: 'Ooops',
              text: "Invalid Smart Card No. Was Entered. Your Money Has Been Refunded",
              type: 'error'
            })
          }else if(response.insuffecient_funds){
            swal({
              title: 'Ooops',
              text: "Sorry You Do Not Have Suffecient Funds To Complete This Transaction.",
              type: 'error'
            })
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
            text: "Something Went Wrong. Please Check Your Internet Connection",
            type: 'error'
          })
        } 
      });
    });
    
  }

  function loadElectricity (elem,evt) {
    $("#choose-action-card").hide();
    $("#disco-card").show();
  }

  function goBackFromSelectDiscoCard (elem,evt) {
    $("#choose-action-card").show();
    $("#disco-card").hide(); 
  }

  function selectedDisco (elem,evt) {
    elem = $(elem);
    var type = elem.attr("id");
    var name = elem.find("img").attr("alt");
    var meter_type = "";
    var form_data = {
      show_records : true,
      disco: type
    }

    var url = "<?php echo site_url('meetglobal/index/check_if_disco_is_available'); ?>";
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
        if(response.success){
          swal({
            title: 'Choose Action: ',
            text: "Please Select Meter Type",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Prepaid',
            cancelButtonText : "Postpaid"
          }).then(function(){
            meter_type = "prepaid";
            proceedToEnterMeterNoAndAmount(meter_type,type)
          },function(dismiss){
            if(dismiss == 'cancel'){
              meter_type = "postpaid";
              proceedToEnterMeterNoAndAmount(meter_type,type)
            }
          });
        }else{
          swal({
            title: 'Error',
            text: "<em class='text-primary'>" + name + "</em> Disco Is Not Available At The Moment",
            type: 'error'
          })
        }
      },error : function () {
        $(".spinner-overlay").hide();
        $.notify({
        message:"Sorry Something Went Wrong Please Check Your Internet Connection"
        },{
          type : "danger"  
        });
      } 
    });

     
    
  }

  function proceedToEnterMeterNoAndAmount(meter_type,type) {
    $("#enter-amount-electricity-form").attr("data-meter-type",meter_type);
    $("#enter-amount-electricity-form").attr("data-disco",type);

    $("#enter-amount-electricity-modal .modal-title").html("Disco: " + type.replace(/_/g, ' ') + " Meter Type: " + meter_type);
    $("#enter-amount-electricity-modal").modal("show");
  }

  function viewTransactionHistory (elem,evt) {
    var form_data = {
      show_records : true
    }   
    var url = "<?php echo site_url('meetglobal/index/view_vtu_transaction_history'); ?>";
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
        if(response.success == true && response.messages !== ""){
          var messages = response.messages;
          $("#transaction-history-card .card-body").html(messages);
          $("#transaction-history-card #transaction-history-table").DataTable();
          $("#choose-action-card").hide();
          $("#transaction-history-card").show();
        }else{
          $.notify({
          message:"Sorry Something Went Wrong"
          },{
            type : "warning"  
          });
        }
      },error : function () {
        $(".spinner-overlay").hide();
        $.notify({
        message:"Sorry Something Went Wrong Please Check Your Internet Connection"
        },{
          type : "danger"  
        });
      } 
    });
  }

  function goBackFromTransactionHistoryCard (elem,evt) {
    $("#choose-action-card").show();
    $("#transaction-history-card").hide();
  }

  function showNormalAndComboEtisalat (url,type,form_data,type_str,amount,mobile_no,amount_to_debit_user) {
    swal({
      title: 'Choose Option',
      text: "Choose Recharge Option: ",
      type: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#4caf50',
      confirmButtonText: 'Normal Recharge',
      cancelButtonText : "Combo Recharge"
    }).then(function(){
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
          if(response.success && response.order_id !== ""){
            var order_id = response.order_id;
            swal({
              title: 'Info',
              text: "You Have Successfully Credited <em class='text-primary'>" + mobile_no + "</em> With Airtime Worth ₦" + addCommas(amount) + " On <span style='text-transform: capitalize;'>" + type_str + "</span> Network. Note You Have Been Debited Of ₦" + addCommas(amount)  + ". The Order Id For This Transaction Is <em class='text-primary'>" +order_id + "</em>",
              type: 'info',
              confirmButtonColor: '#3085d6'
            }).then(function(){
              document.location.reload();
            });
          }else if(response.invalid_amount){
            swal({
              title: 'Ooops',
              text: "Invalid Amount Was Entered. Your Money Has Been Refunded",
              type: 'error'
            })
          }else if(response.invalid_recipient){
            swal({
              title: 'Ooops',
              text: "Invalid Mobile Number Was Entered. Your Money Has Been Refunded",
              type: 'error'
            })
          }else if(response.insuffecient_funds){
            swal({
              title: 'Ooops',
              text: "Sorry You Do Not Have Suffecient Funds To Complete This Transaction.",
              type: 'error'
            })
          }else{
            $.each(response.messages, function (key,value) {

            var element = me.find("#"+key);
            
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
            text: "Something Went Wrong",
            type: 'error'
          })
        } 
      });
    },function(dismiss){
      if(dismiss == 'cancel'){
        form_data = form_data.concat({
          "name" : "combo",
          "value" : true
        });
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
             
              swal({
                title: 'Info',
                text: "Your Combo Recharge Request To Credit <em class='text-primary'>" + mobile_no + "</em> With Airtime Worth ₦" + addCommas(amount) + " On <span style='text-transform: capitalize;'>" + type_str + "</span> Network Has Been Sent To The Admin. You Would Be Credited Shortly . Note You Have Been Debited Of ₦" + addCommas(amount)  + ".",
                type: 'info',
                confirmButtonColor: '#3085d6'
              }).then(function(){
                document.location.reload();
              });
            }else if(response.insuffecient_funds){
              swal({
                title: 'Ooops',
                text: "Sorry You Do Not Have Suffecient Funds To Complete This Transaction.",
                type: 'error'
              })
            }else{
              $.each(response.messages, function (key,value) {

              var element = me.find("#"+key);
              
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
              text: "Something Went Wrong",
              type: 'error'
            })
          } 
        });
      }
    });
  }

  function trackThisOrderPayscribe (elem,evt) {
    elem = $(elem);
    var order_id = elem.attr("data-order-id");
    var form_data = {
      show_records : true,
      order_id : order_id
    }
    var url = "<?php echo site_url('meetglobal/track_payscribe_vtu_order') ?>";
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
          swal({
            title: 'Information On Order Id: '+order_id,
            text: messages ,
            type: 'success'
          });
        }else{
          swal({
            title: 'Error',
            text: "Something Went Wrong." ,
            type: 'error'
          });
        }
      },error : function () {
        $(".spinner-overlay").hide();
        swal({
          title: 'Error',
          text: "Something Went Wrong. Please Check Your Internet Connection" ,
          type: 'error'
        });
      }
    });  
  }
</script>
      <div class="spinner-overlay" style="display: none;">
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading...">
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <h2 class="text-center">Recharge Vtu</h2>
          

          <div class="" style="margin-top: 80px;">
            
            <div class="card" id="transaction-history-card" style="display: none;">
              <div class="card-header">
                <button class="btn btn-warning btn-round" onclick="goBackFromTransactionHistoryCard(this,event)">Go Back</button>
                <h3 class="card-title">Transaction History</h3>
              </div>
              <div class="card-body">
                
              </div>
            </div>

            <div class="card " id="choose-action-card">
              <div class="card-header">
                <h3 class="card-title">Recharge Options: </h3>
              </div>
              <div class="card-body">
                <div class="container">
                  <div class="row">

                    <div class="card col-sm-3" style="cursor: pointer;" onclick="loadAirtime(this,event)">
                      <div class="card-body">
                        <div style="height: 25px; background: #ff9800; border-radius: 12px; margin-bottom: 9px;">
                          <p class="text-center" style="color: #fff; font-weight: bold;">2% Cashback</p>
                        </div>
                        <div class="text-center">
                          <i class="material-icons" style="font-size: 100px; color: #ff9800;">
                          stay_current_portrait
                          </i>
                          <h4 >Buy Airtime</h4>
                        </div>
                      </div>
                    </div>
                    <div class="card col-sm-3" style="cursor: pointer;" onclick="loadData(this,event)">
                      <div class="card-body">
                        <div style="height: 25px; background: #ff9800; border-radius: 12px; margin-bottom: 9px;">
                          <p class="text-center" style="color: #fff; font-weight: bold;">2% Cashback</p>
                        </div>
                        <div class="text-center">
                          <i class="material-icons" style="font-size: 100px; color: #ff9800;">
                          speaker_phone
                          </i>
                          <h4 >Buy Databundle</h4>
                        </div>
                      </div>
                    </div>
                    <div class="card col-sm-3" style="cursor: pointer;" onclick="loadCableTv(this,event)">
                      <div class="card-body">
                        <div style="height: 25px; background: #ff9800; border-radius: 12px; margin-bottom: 9px;">
                          <p class="text-center" style="color: #fff; font-weight: bold;">1% Cashback</p>
                        </div>
                        <div class="text-center">
                          <i class="material-icons" style="font-size: 100px; color: #ff9800;">
                          tv
                          </i>
                          <h4 >Cable Tv Subscription</h4>
                        </div>
                      </div>
                    </div>
                    <div class="card col-sm-3" style="cursor: pointer;" onclick="loadElectricity(this,event)">
                      <div class="card-body">
                        <div style="height: 25px; background: #ff9800; border-radius: 12px; margin-bottom: 9px;">
                          <p class="text-center" style="color: #fff; font-weight: bold;">1% Cashback</p>
                        </div>
                        <div class="text-center">
                          <i class="material-icons" style="font-size: 100px; color: #ff9800;">
                          flash_on
                          </i>
                          <h4>Electricity Bill Payment</h4>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                
                <div class="text-center">
                  <button class="btn btn-primary" onclick="viewTransactionHistory(this,event)">View Transaction History</button>
                </div>
              </div>
            </div>

            <div class="card" style="display: none;" id="airtime-operator-card">
              <div class="card-header">
                <button class="btn btn-warning btn-round" onclick="goBackFromSelectOperatorAirtimeCard(this,event)">Go Back</button>
                <h3 class="card-title">Select Operator For Airtime: </h3>
              </div>
              <div class="card-body">
                <div class="container">
                  <div class="row">

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="mtn-airtime" onclick="selectedAirtimeOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/mtn_logo.png') ?>" style="width: 100%; height: 160px;" alt="MTN">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">MTN</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="glo-airtime" onclick="selectedAirtimeOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/glo_logo.jpg') ?>" style="width: 100%; height: 160px;" alt="GLO">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">GLO</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="airtel-airtime" onclick="selectedAirtimeOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/airtel_logo.png') ?>" style="width: 100%; height: 160px;" alt="AIRTEL">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">AIRTEL</h4>
                        </div>
                      </div>
                    </div>


                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/9mobile-1.png') ?>" id="9mobile-airtime" onclick="selectedAirtimeOperator(this,event)" style="width: 100%; height: 160px;" alt="9 MOBILE">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">9 MOBILE</h4>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>
            
            <div class="card" style="display: none;" id="data-operator-card">
              <div class="card-header">
                <button class="btn btn-warning btn-round" onclick="goBackFromSelectOperatorDataCard(this,event)">Go Back</button>
                <h3 class="card-title">Select Operator For Data Bundle: </h3>
              </div>
              <div class="card-body">
                <div class="container">
                  <div class="row">

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="mtn-data" onclick="selectedDataOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/mtn_logo.png') ?>" style="width: 100%; height: 160px;" alt="MTN">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">MTN</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="glo-data" onclick="selectedDataOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/glo_logo.jpg') ?>" style="width: 100%; height: 160px;" alt="GLO">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">GLO</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="airtel-data" onclick="selectedDataOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/airtel_logo.png') ?>" style="width: 100%; height: 160px;" alt="AIRTEL">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">AIRTEL</h4>
                        </div>
                      </div>
                    </div>


                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/9mobile-1.png') ?>" id="9mobile-data" onclick="selectedDataOperator(this,event)" style="width: 100%; height: 160px;" alt="9 MOBILE">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">9 MOBILE</h4>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>

            <div class="card" style="display: none;" id="tv-operator-card">
              <div class="card-header">
                <button class="btn btn-warning btn-round" onclick="goBackFromSelectOperatorTvCard(this,event)">Go Back</button>
                <h3 class="card-title">Select Operator For Cable Tv: </h3>
              </div>
              <div class="card-body">
                <div class="container">
                  <div class="row">

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="dstv" onclick="selectedTvOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/dstv_logo.jpg') ?>" style="width: 100%; height: 160px;" alt="DSTV">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">DSTV</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="gotv" onclick="selectedTvOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/gotv_logo.jpg') ?>" style="width: 100%; height: 160px;" alt="GOTV">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">GOTV</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="startimes" onclick="selectedTvOperator(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/startimes_logo.jpg') ?>" style="width: 100%; height: 160px;" alt="STARTIMES">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">STARTIMES</h4>
                        </div>
                      </div>
                    </div>


                  </div>
                </div>
              </div>
            </div>

            <div class="card" style="display: none;" id="disco-card">
              <div class="card-header">
                <button class="btn btn-warning btn-round" onclick="goBackFromSelectDiscoCard(this,event)">Go Back</button>
                <h3 class="card-title">Select Your Disco: </h3>
              </div>
              <div class="card-body">
                <div class="container">
                  <div class="row">

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="IKEJA_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/ikeja_logo.png') ?>" style="width: 100%; height: 160px;" alt="Ikeja Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">Ikeja Electric</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="EKO_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/eko_logo.jpg') ?>" style="width: 100%; height: 160px;" alt="Eko Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">Eko Electric</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="ABUJA_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/abuja_logo.jpg') ?>" style="width: 100%; height: 160px;" alt="Abuja Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">Abuja Electric</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="KANO_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/kano_logo.png') ?>" style="width: 100%; height: 160px;" alt="Kano Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">Kano Electric</h4>
                        </div>
                      </div>
                    </div>


                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="JOS_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/jos_logo.png') ?>" style="width: 100%; height: 160px;" alt="Jos Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">Jos Electric</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>
                    

                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="IBADAN_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/ibadan_logo.png') ?>" style="width: 100%; height: 160px;" alt="Ibadan Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">Ibadan Electric</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>


                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="ENUGU_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/enugu_logo.jpg') ?>" style="width: 100%; height: 160px;" alt="ENUGU Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">ENUGU Electric</h4>
                        </div>
                      </div>
                    </div>

                    <div class="offset-sm-1">
          
                    </div>


                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="PHC_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/PHEDC.jpg') ?>" style="width: 100%; height: 160px;" alt="PHC Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">Port Harcourt Electric</h4>
                        </div>
                      </div>
                    </div>


                    <div class="offset-sm-1">
          
                    </div>


                    <div class="card col-sm-2" style="padding: 0; cursor: pointer;" id="KADUNA_ELECTRIC" onclick="selectedDisco(this,event)">
                      <div class="card-body" style="padding: 0;">
                        <img src="<?php echo base_url('assets/images/kaduna-electric.jpg') ?>" style="width: 100%; height: 160px;" alt="Kaduna Electric">
                        <div class="" style="margin-top: 10px;">
                          <h4 class="text-center" style="font-size: 20px; font-weight: bold;">Kaduna Electric</h4>
                        </div>
                      </div>
                    </div>



                  </div>
                </div>
              </div>
            </div>

            <div class="card" style="display: none;" id="data-bundle-card">
              <div class="card-header">
                <button class="btn btn-warning btn-round" onclick="goBackDataBundleCard(this,event)">Go Back</button>
                <h3 class="card-title">Select Data Bundle</h3>
              </div>
              <div class="card-body">
                
              </div>
            </div>

            <div class="card" style="display: none;" id="tv-package-card">
              <div class="card-header">
                <button class="btn btn-warning btn-round" onclick="goBackTvPackageCard(this,event)">Go Back</button>
                <h3 class="card-title">Select Tv Package</h3>
              </div>
              <div class="card-body">
                
              </div>
            </div>

          </div>
        </div>
      </div>
      
      <div class="modal fade" data-backdrop="static" id="enter-amount-electricity-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content" >
            <div class="modal-header">
              <h3 class="modal-title">Enter Account Info And Amount</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body" id="modal-body">
              <p class="text-primary"><em>Note: Minimum Credit Balance Is ₦1000 And Maximum Is ₦20,000</em></p>
              <?php 
                $attr = array('id' => 'enter-amount-electricity-form');
                echo form_open('meetglobal/buy_electricity_vtu',$attr);
              ?>
              

              <div class="form-group">
                <label for="meter_no">Meter No. To Credit</label>
                <input type="number" class="form-control" name="meter_no" id="meter_no" required>
                <span class="form-error"></span> 
              </div>


              <div class="form-group">
                <label for="amount">Amount: </label>
                <input type="number" min="1000" max="20000" class="form-control" name="amount" id="amount" placeholder="In Naira(₦)" required>
                <span class="form-error"></span> 
              </div>

              <div class="form-group">
                <label for="phone_number">Mobile Number: </label>
                <input type="number" class="form-control" name="phone_number" id="phone_number" placeholder="e.g 08127027321" required>
                <span class="form-error"></span> 
              </div>


              <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" class="form-control" name="email" id="email" required>
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

      <div class="modal fade" data-backdrop="static" id="enter-amount-airtime-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content" >
            <div class="modal-header">
              <h3 class="modal-title">Enter Amount</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body" id="modal-body">
              <p class="text-primary"><em>Note: Minimum Credit Balance Is ₦100 And Maximum Is ₦20,000</em></p>
              <?php 
                $attr = array('id' => 'enter-amount-airtime-form');
                echo form_open('meetglobal/buy_airtime_vtu',$attr);
              ?>
              
              <div class="form-group">
                <label for="amount">Amount: </label>
                <input type="number" min="100" max="20000" class="form-control" name="amount" id="amount" placeholder="In Naira(₦)" required>
                <span class="form-error"></span> 
              </div>

              <div class="form-group">
                <label for="mobile_no">Mobile No. To Credit</label>
                <input type="number" minlength="6" maxlength="15" class="form-control" name="mobile_no" id="mobile_no" placeholder="e.g 08127027321" required>
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


      <div class="modal fade" data-backdrop="static" id="enter-mobile-no-data-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content" >
            <div class="modal-header">
              <h3 class="modal-title">Enter Mobile No.</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body" id="modal-body">
              
              <?php 
                $attr = array('id' => 'enter-mobile-no-data-form');
                echo form_open('meetglobal/buy_data_vtu',$attr);
              ?>

              <div class="form-group">
                <label for="mobile_no">Mobile No. To Credit</label>
                <input type="number" minlength="6" maxlength="15" class="form-control" name="mobile_no" id="mobile_no" placeholder="e.g 08127027321" required>
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

      <div class="modal fade" data-backdrop="static" id="enter-iuc-no-data-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content" >
            <div class="modal-header">
              <h3 class="modal-title">Enter Your IUC No.</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body" id="modal-body">
              
              <?php 
                $attr = array('id' => 'enter-iuc-no-data-form');
                echo form_open('meetglobal/recharge_decoder',$attr);
              ?>

              <div class="form-group">
                <label for="iuc_no"></label>
                <input type="number" minlength="" maxlength="" class="form-control" name="iuc_no" id="iuc_no" required>
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


      <footer class="footer">
        <div class="container-fluid">
          <!-- <footer>&copy; <?php echo date("Y"); ?> Copyright (meetglobal Issues Global Limited). All Rights Reserved</footer> -->
        </div>
      </footer>
      
      <script>
        $(document).ready(function () {
          $("#enter-amount-electricity-form").submit(function (evt) {
            evt.preventDefault();
            var elem = $(this);
            var disco = elem.attr("data-disco");
            var meter_type = elem.attr("data-meter-type");
            var form_data = elem.serializeArray();
            form_data = form_data.concat({
              "name" : "disco",
              "value" : disco
            })
            form_data = form_data.concat({
              "name" : "meter_type",
              "value" : meter_type
            })
            
            var amount = elem.find("#amount").val();
            var meter_no = elem.find('#meter_no').val();
            var amount_to_debit_user = amount;
            console.log(form_data)
            var url = "<?php echo site_url('meetglobal/verify_electricity_details'); ?>";
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
                if(response.success && response.customer_name !== ""){
                  var customer_name = response.customer_name;
                  swal({
                    title: 'Info',
                    text: "Is This Your Name ? <br> <em class='text-center text-primary'>"+customer_name+"</em>" ,
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes Proceed!',
                    cancelButtonText : "No"
                  }).then(function(){
                    var url = elem.attr("action");
                    
                    swal({
                      title: 'Info',
                      text: "You Are About To Credit Your " + meter_type + " <em class='text-primary'>" + disco.replace(/_/g, ' ') + "</em> With Meter Number: <em class='text-primary'>"+ meter_no +"</em> Account With ₦" + addCommas(amount) +". Are You Sure You Want To Proceed? <p><em>Note You Would Be Debited Of ₦" + addCommas(amount_to_debit_user) + "</em></p>" ,
                      type: 'info',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes Proceed!',
                      cancelButtonText : "No"
                    }).then(function(){
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
                          if(response.success && response.order_id !== ""){
                            var order_id = response.order_id;

                            var text = "You Have Successfully Credited Your " + meter_type + " <em class='text-primary'>" + disco.replace(/_/g, ' ') + "</em> With Meter Number: <em class='text-primary'>"+ meter_no +"</em> Account With ₦" + addCommas(amount) + ".";

                            if(meter_type == "prepaid"){
                              if(response.metertoken != ""){
                                var metertoken = response.metertoken;
                                text += " Your Meter Token Is: <em class='text-primary'>"+metertoken+"</em>";
                              }else{
                                text += " Your Meter Token Will be Sent To Your Email And Notification Panel Soon.";
                              }
                            }
                            swal({
                              title: 'Info',
                              text: text,
                              type: 'info',
                              confirmButtonColor: '#3085d6'
                            }).then(function(){
                              document.location.reload();
                            });
                          }else if(response.invalid_meterno){
                            swal({
                              title: 'Ooops',
                              text: "An invalid Meter number was entered. Your Money Has Been Refunded",
                              type: 'error'
                            })
                          }else if(response.meter_type_not_available){
                            swal({
                              title: 'Ooops',
                              text: "Selected MeterType is not currently available. Your Money Has Been Refunded",
                              type: 'error'
                            })
                          }else if(response.insuffecient_funds){
                            swal({
                              title: 'Ooops',
                              text: "Sorry You Do Not Have Suffecient Funds To Complete This Transaction.",
                              type: 'error'
                            })
                          }else{
                            $.each(response.messages, function (key,value) {

                            var element = me.find("#"+key);
                            
                            element.closest('div.form-group')
                                    
                                    .find('.form-error').remove();
                            element.after(value);
                            
                           });
                            $.notify({
                            message:"Something Went Wrong. Please Try Again"
                            },{
                              type : "warning"  
                            });
                          }
                        },error : function () {
                          $(".spinner-overlay").hide();
                          swal({
                            title: 'Ooops',
                            text: "Something Went Wrong. Please Check Your Internet Connection",
                            type: 'error'
                          })
                        } 
                      });
                    });
                  });
                }else if(response.invalid_user){
                  swal({
                    title: 'Error!',
                    text: "The Details Entered Were Invalid. Please Try Again." ,
                    type: 'error'
                  })
                }else{
                  swal({
                    title: 'Error!',
                    text: "Sorry Something Went Wrong" ,
                    type: 'error'
                  })
                }
              },error : function () {
                $(".spinner-overlay").hide();
                swal({
                  title: 'Error!',
                  text: "Sorry Something Went Wrong. Please Check Your Internet Connection" ,
                  type: 'error'
                })
              }
            });
          })

          $("#enter-iuc-no-data-form").submit(function (evt) {
            evt.preventDefault();
            var elem = $(this);
            var type = elem.attr("data-type");
            var form_data = elem.serializeArray();
            var smart_card_no = elem.find('#iuc_no').val();
            form_data = form_data.concat({
              "name" : "type",
              "value" : type
            })

            form_data = form_data.concat({
              "name" : "smart_card_no",
              "value" : smart_card_no
            })
            
            
            console.log(form_data)
            var url = "<?php echo site_url('meetglobal/verify_decoder_number'); ?>";
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
                if(response.success && response.customer_name !== "" && response.messages != "" && response.productCode != ""){
                  var customer_name = response.customer_name;
                  var messages = response.messages;
                  productCode = response.productCode
                  swal({
                    title: 'Info',
                    text: "Is This Your Name ? <br> <em class='text-center text-primary'>"+customer_name+"</em>" ,
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes Proceed!',
                    cancelButtonText : "No"
                  }).then(function(){
                    $("#tv-package-card .card-body").html(messages);
                    $("#tv-package-card #packages-table").DataTable({
                      "paging":   false,
                      "info":     false,
                      "bSort" : false
                    });
                    $("#tv-operator-card").hide();
                    $("#enter-iuc-no-data-modal").modal("hide");
                    $("#tv-package-card").show();
                  });  
                }else if(response.invalid_user){
                  swal({
                    title: 'Error!',
                    text: "The Details Entered Were Invalid. Please Try Again." ,
                    type: 'error'
                  })
                }else{
                  swal({
                    title: 'Error!',
                    text: "Sorry Something Went Wrong" ,
                    type: 'error'
                  })
                }
              },error : function () {
                $(".spinner-overlay").hide();
                swal({
                  title: 'Error!',
                  text: "Sorry Something Went Wrong. Please Check Your Internet Connection" ,
                  type: 'error'
                })
              }
            });
          })



          

          $("#enter-mobile-no-data-form").submit(function (evt) {
            evt.preventDefault();
            var elem = $(this);
            var url = elem.attr("action");
            var type = elem.attr("data-type");
            var product_id = elem.attr("data-product-id");
            var product_name = elem.attr("data-product-name");
            var amount = elem.attr("data-amount");
            console.log(amount)
            amount = Number(amount);
            console.log(amount)
            var form_data = elem.serializeArray();
            form_data = form_data.concat({
              "name" : "type",
              "value" : type
            })

            form_data = form_data.concat({
              "name" : "product_id",
              "value" : product_id
            })
            var type_str = type.slice(0, -5);
            
            var mobile_no = elem.find('#mobile_no').val();

            if(data_combo){
              form_data = form_data.concat({
                "name" : "combo",
                "value" : true
              })
              text_html = "You Are About To Credit <em class='text-primary'>" + mobile_no + "</em> With Combo Data Woth " + product_name +" On <span style='text-transform: capitalize;'>" + type_str + "</span> Network. Are You Sure You Want To Proceed? <p><em>Note You Would Be Debited Of ₦" + addCommas(amount) + "</em></p>"
            }else{
              text_html = "You Are About To Credit <em class='text-primary'>" + mobile_no + "</em> With " + product_name +" Worth Of Data On <span style='text-transform: capitalize;'>" + type_str + "</span> Network. Are You Sure You Want To Proceed? <p><em>Note You Would Be Debited Of ₦" + addCommas(amount) + "</em></p>";
            }

            

            swal({
              title: 'Info',
              text: text_html ,
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
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
                    var order_id = response.order_id;

                    if(data_combo){
                      var text_html = "Your Combo Recharge Request To Credit <em class='text-primary'>" + mobile_no + "</em> With Data Worth " + product_name + " On <span style='text-transform: capitalize;'>" + type_str + "</span> Network Has Been Sent To The Admin. You Would Be Credited Shortly . Note You Have Been Debited Of ₦" + addCommas(amount)  + "."
                    }else{
                      // var text_html = "Your Request To Top Up <em class='text-primary'>" + mobile_no + "</em> With Data Worth " + product_name + " On <span style='text-transform: capitalize;'>" + type_str + "</span> Network Is Processing. Note You Have Been Debited Of ₦" + addCommas(amount)  + ". The Order Id For This Transaction Is <em class='text-primary'>" +order_id + "</em>. Track This Order In The Vtu Transaction History Section";

                      var text_html = "Your Request To Top Up <em class='text-primary'>" + mobile_no + "</em> With Data Worth " + product_name + " On <span style='text-transform: capitalize;'>" + type_str + "</span> Network Is Successful. Note You Have Been Debited Of ₦" + addCommas(amount)  + ". The Order Id For This Transaction Is <em class='text-primary'>" +order_id + "</em>.";
                    }
                    swal({
                      title: 'Info',
                      text: text_html,
                      type: 'info',
                      confirmButtonColor: '#3085d6'
                    }).then(function(){
                      document.location.reload();
                    });
                  }else if(response.invalid_data_plan){
                    swal({
                      title: 'Ooops',
                      text: "Invalid Data Plan Was Entered. Your Money Has Been Refunded",
                      type: 'error'
                    })
                  }else if(response.invalid_recipient){
                    swal({
                      title: 'Ooops',
                      text: "Invalid Mobile Number Was Entered. Your Money Has Been Refunded",
                      type: 'error'
                    })
                  }else if(response.insuffecient_funds){
                    swal({
                      title: 'Ooops',
                      text: "Sorry You Do Not Have Suffecient Funds To Complete This Transaction.",
                      type: 'error'
                    })
                  }else{
                    $.each(response.messages, function (key,value) {

                    var element = me.find("#"+key);
                    
                    element.closest('div.form-group')
                            
                            .find('.form-error').remove();
                    element.after(value);
                    
                   });
                    $.notify({
                    message:"Something Went Wrong. Please Try Again"
                    },{
                      type : "warning"  
                    });
                  }
                },error : function () {
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

          $("#enter-amount-airtime-form").submit(function (evt) {
            evt.preventDefault();
            var elem = $(this);
            var url = elem.attr("action");
            var type = elem.attr("data-type");
            var form_data = elem.serializeArray();
            form_data = form_data.concat({
              "name" : "type",
              "value" : type
            })
            var type_str = type.slice(0, -8);
            var amount = elem.find("#amount").val();
            var mobile_no = elem.find('#mobile_no').val();
            var amount_to_debit_user = amount - (0.03 * amount);



            swal({
              title: 'Info',
              text: "You Are About To Credit <em class='text-primary'>" + mobile_no + "</em> With Airtime Worth ₦" + addCommas(amount) + " On <span style='text-transform: capitalize;'>" + type_str + "</span> Network. Are You Sure You Want To Proceed? <p><em>Note You Would Be Debited Of ₦" + addCommas(amount) + "</em></p>" ,
              type: 'info',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
              if(type_str != "9mobile"){

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
                    if(response.success && response.order_id !== ""){
                      var order_id = response.order_id;
                      swal({
                        title: 'Info',
                        text: "You Have Successfully Credited <em class='text-primary'>" + mobile_no + "</em> With Airtime Worth ₦" + addCommas(amount) + " On <span style='text-transform: capitalize;'>" + type_str + "</span> Network. Note You Have Been Debited Of ₦" + addCommas(amount)  + ". The Order Id For This Transaction Is <em class='text-primary'>" +order_id + "</em>",
                        type: 'info',
                        confirmButtonColor: '#3085d6'
                      }).then(function(){
                        document.location.reload();
                      });
                    }else if(response.invalid_amount){
                      swal({
                        title: 'Ooops',
                        text: "Invalid Amount Was Entered. Your Money Has Been Refunded",
                        type: 'error'
                      })
                    }else if(response.invalid_recipient){
                      swal({
                        title: 'Ooops',
                        text: "Invalid Mobile Number Was Entered. Your Money Has Been Refunded",
                        type: 'error'
                      })
                    }else if(response.insuffecient_funds){
                      swal({
                        title: 'Ooops',
                        text: "Sorry You Do Not Have Suffecient Funds To Complete This Transaction.",
                        type: 'error'
                      })
                    }else{
                      $.each(response.messages, function (key,value) {

                      var element = me.find("#"+key);
                      
                      element.closest('div.form-group')
                              
                              .find('.form-error').remove();
                      element.after(value);
                      
                     });
                      $.notify({
                      message:"Something Went Wrong. Please Try Again"
                      },{
                        type : "warning"  
                      });
                    }
                  },error : function () {
                    $(".spinner-overlay").hide();
                    swal({
                      title: 'Ooops',
                      text: "Something Went Wrong. Please Check Your Internet Connection",
                      type: 'error'
                    })
                  } 
                });
              }else{
                showNormalAndComboEtisalat(url,type,form_data,type_str,amount,mobile_no,amount_to_debit_user);
              }
            });
          })
        })
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 