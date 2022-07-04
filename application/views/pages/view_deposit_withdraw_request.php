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
        var global_user_name = "";
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

          function performFunctionOnUser(elem,evt,user_id){
            elem = $(elem);
            var user_name = elem.attr("data-user-name");
            global_user_id = user_id;
            global_user_name = user_name;
            console.log(user_id)
            var url = "<?php echo site_url('sabicapital/index/admin/get_user_info_by_id') ?>";
            var form_data = {
              'show_records' : true,
              'user_id' : global_user_id
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
                  var user_name = response[0].user_name;
                  $("#perform-function-on-user-modal .modal-title").html("Choose Action To Perform On " + user_name);
                  if(response[0].active == 0){
                    $("#perform-function-on-user-modal .activate-deactive-item").html("Activate User");
                    $("#perform-function-on-user-modal .activate-deactive-item").parent().attr("onclick","activateUser(this,event)");
                  }else{
                    $("#perform-function-on-user-modal .activate-deactive-item").html("Deactivate User");
                    $("#perform-function-on-user-modal .activate-deactive-item").parent().attr("onclick","deactivateUser(this,event)");
                  }
                  $("#perform-function-on-user-modal").modal("show");
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

          function editUserProfile (elem,evt) {
            var url = "<?php echo site_url('sabicapital/index/admin/get_user_info_by_id') ?>";
            var form_data = {
              'show_records' : true,
              'user_id' : global_user_id
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
                  var user_name = response[0].user_name;
                  var full_name = response[0].full_name;
                  var phone = response[0].phone;
                  var email = response[0].email;
                  var dob = response[0].dob;
                  var address = response[0].address;
                  
                  
                  $("#perform-function-on-user-modal").modal("hide");
                  $("#edit-user-profile-card .card-title").html("<em class='text-primary'>" + user_name + "'s</em> Profile");
                  $("#edit-user-profile-card #full_name").val(full_name)
                  $("#edit-user-profile-card #phone").val(phone)
                  $("#edit-user-profile-card #email").val(email)
                  $("#edit-user-profile-card #dob").val(dob)
                  $("#edit-user-profile-card #address").val(address)
                  $("#main-card").hide();
                  $("#edit-user-profile-card").show();
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

          function goBackFromEditUserProfileCard (elem,evt) {
            $("#perform-function-on-user-modal").modal("show");
            
            $("#main-card").show();
            $("#edit-user-profile-card").hide();
          }

          function deactivateUser (elem,evt) {
            swal({
              title: 'Warning',
              text: "Are You Sure You Want To Deactivate User?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
              var url = "<?php echo site_url('sabicapital/index/admin/deactivate_user') ?>";
              var form_data = {
                'show_records' : true,
                'user_id' : global_user_id
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
                      message:"User Deactivated Successfully"
                    },{
                      type : "success"  
                    });
                    $("#perform-function-on-user-modal .activate-deactive-item").html("Activate User");
                    $("#perform-function-on-user-modal .activate-deactive-item").parent().attr("onclick","activateUser(this,event)");
                  }else if(response.already_deactivated){
                    swal({
                      title: 'Error',
                      text: "This User Is Already Deactivated",
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
            });
          }

          function activateUser (elem,evt) {
            swal({
              title: 'Warning',
              text: "Are You Sure You Want To Activate User?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
              var url = "<?php echo site_url('sabicapital/index/admin/activate_user') ?>";
              var form_data = {
                'show_records' : true,
                'user_id' : global_user_id
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
                      message:"User Activated Successfully"
                    },{
                      type : "success"  
                    });
                    $("#perform-function-on-user-modal .activate-deactive-item").html("Deactivate User");
                    $("#perform-function-on-user-modal .activate-deactive-item").parent().attr("onclick","deactivateUser(this,event)");
                  }else if(response.already_activated){
                    swal({
                      title: 'Error',
                      text: "This User Is Already Active",
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
            });
          }

          function creditUsersWallet (elem,evt) {
            var url = "<?php echo site_url('sabicapital/index/admin/get_user_info_by_id') ?>";
            var form_data = {
              'show_records' : true,
              'user_id' : global_user_id
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
                  var user_name = response[0].user_name;
                  var full_name = response[0].full_name;
                  var phone = response[0].phone;
                  var email = response[0].email;
                  var dob = response[0].dob;
                  var address = response[0].address;
                  var total_income = response[0].total_income;
                  var withdrawn = response[0].withdrawn;
                  var wallet_balance = total_income - withdrawn;
                  
                  $(".spinner-overlay").show();
                  $("#perform-function-on-user-modal").modal("hide");
                  setTimeout(function () {
                    $(".spinner-overlay").hide();
                    $("#credit-user-modal .wallet-balance").html("Wallet Balance: ₦"+ wallet_balance.toFixed(2));
                    $("#credit-user-modal").modal("show");
                  }, 1500)
                  
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

          function closeCreditUserModal(elem,evt){
            $(".spinner-overlay").show();
            $("#credit-user-modal").modal("hide");
            
            setTimeout(function () {
              $(".spinner-overlay").hide();
              $("#perform-function-on-user-modal").modal("show");
            }, 1500)
          }

          function debitUsersWallet (elem,evt) {
            var url = "<?php echo site_url('sabicapital/index/admin/get_user_info_by_id') ?>";
            var form_data = {
              'show_records' : true,
              'user_id' : global_user_id
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
                  var user_name = response[0].user_name;
                  var full_name = response[0].full_name;
                  var phone = response[0].phone;
                  var email = response[0].email;
                  var dob = response[0].dob;
                  var address = response[0].address;
                  var total_income = response[0].total_income;
                  var withdrawn = response[0].withdrawn;
                  var wallet_balance = total_income - withdrawn;
                  
                  $(".spinner-overlay").show();
                  $("#perform-function-on-user-modal").modal("hide");
                  setTimeout(function () {
                    $(".spinner-overlay").hide();
                    $("#debit-user-modal .wallet-balance").html("Wallet Balance: ₦"+ wallet_balance.toFixed(2));
                    $("#debit-user-modal #amount").attr("max",wallet_balance);
                    $("#debit-user-modal").modal("show");
                  }, 1500)
                  
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

          function closeDebitUserModal(elem,evt){
            $(".spinner-overlay").show();
            $("#debit-user-modal").modal("hide");
            
            setTimeout(function () {
              $(".spinner-overlay").hide();
              $("#perform-function-on-user-modal").modal("show");
            }, 1500)
          }

          function viewUsersDownline (elem,evt) {
            var url = "<?php echo site_url('sabicapital/index/admin/view_members_genealogy_tree') ?>";
            var form_data = {
              'show_records' : true,
              'user_id' : global_user_id
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
                  
                  $("#perform-function-on-user-modal").modal("hide");
                  $("#view-users-downline-card .card-body").html(messages);
                  $("#view-users-downline-card .card-title").html(response.user_name + "'s Downline");

                  $("#view-users-downline-card .tf-tree .tf-nc .user-name").each(function(index, el) {
                    var user_name = $(this).html();
                    var formatted_username = user_name.slice(0,-4);
                    $(this).html(formatted_username);
                  }); 


                  $("#main-card").hide();
                  $("#view-users-downline-card").show();
                  
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

          function goBackFromViewUsersDownlineCard (elem,evt) {
            $("#main-card").show();
            $("#view-users-downline-card").hide();
            $("#perform-function-on-user-modal").modal("show");
          }

          function goDownMlm(elem,event,mlm_db_id,your_mlm_db_id){
            elem = $(elem);
            var package = elem.attr("data-package");
            $(".spinner-overlay").show();
            var form_data = {
              show_records : true,
              mlm_db_id : mlm_db_id,
              your_mlm_db_id : your_mlm_db_id,
              user_id: global_user_id,
              package : package
            }
            console.log(form_data)
            var url = "<?php echo site_url('sabicapital/view_your_genealogy_tree_down'); ?>"
            $.ajax({
              url : url,
              type : "POST",
              responseType : "json",
              dataType : "json",
              data : form_data,
              success : function (response) {
                $(".spinner-overlay").hide();
                if(response.success && response.messages != ""){
                  var messages = response.messages;

                  $("#view-users-downline-card .card-body").html(messages);
                  $("#view-users-downline-card .tf-tree .tf-nc .user-name").each(function(index, el) {
                    var user_name = $(this).html();
                    var formatted_username = user_name.slice(0,-4);
                    $(this).html(formatted_username);
                  }); 
                  $("#body-cont").show();
                }else{
                  swal({
                    title: 'Ooops',
                    text: "Something Went Wrong",
                    type: 'warning'
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

          function goUpMlm(elem,event,mlm_db_id,your_mlm_db_id){
            elem = $(elem);
            var package = elem.attr("data-package");
            $(".spinner-overlay").show();
            var form_data = {
              show_records : true,
              mlm_db_id : your_mlm_db_id,
              user_id: global_user_id,
              package : package
            }
            var url = "<?php echo site_url('sabicapital/view_your_genealogy_tree'); ?>"
            $.ajax({
              url : url,
              type : "POST",
              responseType : "json",
              dataType : "json",
              data : form_data,
              success : function (response) {
                $(".spinner-overlay").hide();
                if(response.success && response.messages != ""){
                  var messages = response.messages;
                  
                  $("#view-users-downline-card .card-body").html(messages);
                  $("#view-users-downline-card .tf-tree .tf-nc .user-name").each(function(index, el) {
                    var user_name = $(this).html();
                    var formatted_username = user_name.slice(0,-4);
                    $(this).html(formatted_username);
                  }); 
                  $("#view-users-downline-card").show();
                }else{
                  swal({
                    title: 'Ooops',
                    text: "Something Went Wrong",
                    type: 'warning'
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

          function approveUsersRequest (elem,evt) {
            var url = "<?php echo site_url('sabicapital/index/admin/get_user_info_by_id') ?>";
            var form_data = {
              'show_records' : true,
              'user_id' : global_user_id
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
                  var user_name = response[0].user_name;
                  var full_name = response[0].full_name;
                  var phone = response[0].phone;
                  var email = response[0].email;
                  var dob = response[0].dob;
                  var address = response[0].address;
                  var total_income = response[0].total_income;
                  var withdrawn = response[0].withdrawn;
                  var wallet_balance = total_income - withdrawn;
                  var super_forex_account_number = response[0].super_forex_account_number;
                  var live_account_request_approved = response[0].live_account_request_approved;

                  if(super_forex_account_number == "" && live_account_request_approved == 0){
                    $(".spinner-overlay").show();
                    $("#perform-function-on-user-modal").modal("hide");
                    setTimeout(function () {
                      $(".spinner-overlay").hide();
                      $("#approve-user-live-account-request-modal").modal("show");
                    }, 1500)
                  }else{
                    swal({
                      title: 'Ooops',
                      text: "This Users Live Account Request Has Already Been Approved",
                      type: 'error',                                          
                    })
                  }
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

          function closeApproveUserLiveAccountRequestModal (elem,evt) {
            $(".spinner-overlay").show();
            $("#approve-user-live-account-request-modal").modal("hide");
            setTimeout(function () {
              $(".spinner-overlay").hide();
              
              $("#perform-function-on-user-modal").modal("show");
            }, 1500)
          }

          function viewDepositRequests (elem,evt) {
            var url = "<?php echo site_url('sabicapital/index/admin/view_superforex_pending_deposit_requests') ?>";
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
                  $("#main-card").hide();
                  $("#view-deposit-requests-card .card-body").html(messages);
                  $("#view-deposit-requests-card #view-deposit-requests-table").DataTable();
                  $("#view-deposit-requests-card").show();
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

          function goBackFromViewDepositRequests (elem,evt) {
            $("#main-card").show();
            $("#view-deposit-requests-card").hide();
          }

          function performActionOnDepositRequest(elem,evt,id){
            elem = $(elem);
            var full_name = elem.attr("data-full-name");

            var url = "<?php echo site_url('sabicapital/index/admin/view_more_info_on_superforex_pending_deposit_request') ?>";
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
                  $("#view-deposit-requests-card").hide();
                  $("#view-deposit-requests-card-info .card-body").html(messages);
                  $("#view-deposit-requests-card-info").show();
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

          function goBackFromViewDepositRequestsInfo (elem,evt) {
            $("#view-deposit-requests-card").show();
            $("#view-deposit-requests-card-info").hide();
          }

          function declineRequest(elem,evt,id){
            elem = $(elem);
            var full_name = elem.attr("data-full-name");
            $("#decline-request-modal .modal-title").html("Enter Reason For Declining "+full_name+" This Request");
            $("#decline-request-form #id").val(id);
            $("#decline-request-modal").modal("show");
          }

          function approveRequest(elem,evt,id){
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
              
              var url = "<?php echo site_url('sabicapital/index/admin/approve_superforex_fund_request') ?>";
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

          function viewAccountFundingAndWithdrawalHistory (elem,evt) {
            var url = "<?php echo site_url('sabicapital/index/admin/') ?>"
            swal({
              title: 'Choose Action: ',
              text: "Do You Want To View: ",
              type: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#4caf50',
              confirmButtonText: 'Funding History',
              cancelButtonText : "Withdrawal History"
            }).then(function(){
              url += "view_account_funding_history";
              window.location.assign(url)
            }, function(dismiss){
             if(dismiss == 'cancel'){
              url += "view_account_withdrawal_history";
              window.location.assign(url)
             }
           });
          }

          function viewWithdrawRequests (elem,evt) {
            var url = "<?php echo site_url('sabicapital/index/admin/view_superforex_pending_withdrawal_requests') ?>";
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
                  $("#main-card").hide();
                  $("#view-withdrawal-requests-card .card-body").html(messages);
                  $("#view-withdrawal-requests-card #view-withdrawal-requests-table").DataTable();
                  $("#view-withdrawal-requests-card").show();
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

          function goBackFromViewWithdrawalRequests (elem,evt) {
            $("#main-card").show();
            $("#view-withdrawal-requests-card").hide();
          }

          function performActionOnWithdrawalRequest(elem,evt,id){
            elem = $(elem);
            var full_name = elem.attr("data-full-name");

            var url = "<?php echo site_url('sabicapital/index/admin/view_more_info_on_superforex_pending_withdrawal_request') ?>";
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
                  $("#view-withdrawal-requests-card").hide();
                  $("#view-withdrawal-requests-card-info .card-body").html(messages);
                  $("#view-withdrawal-requests-card-info").show();
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
            $("#view-withdrawal-requests-card").show();
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
          <h2 class="text-center">View Deposit/ Withdrawal Request</h2>
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

              <div class="card" id="view-withdrawal-requests-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromViewWithdrawalRequests(this,event)">Go Back</button>
                  <h3 class="card-title">Pending Superforex Withdrawal Requests</h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="view-deposit-requests-card-info" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromViewDepositRequestsInfo(this,event)">Go Back</button>
                  <h3 class="card-title">Perform Action On This Pending Superforex Deposit Request</h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="view-deposit-requests-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromViewDepositRequests(this,event)">Go Back</button>
                  <h3 class="card-title">Pending Superforex Deposit Requests</h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="main-card">
                <div class="card-header">
                  
                  <h3 class="card-title">View: </h3>
                </div>
                <div class="card-body" style="margin-top: 40px;">
                  <button class="btn btn-primary" onclick="viewDepositRequests(this,event)">Deposit Requests</button>
                  <button class="btn btn-info" onclick="viewWithdrawRequests(this,event)">Withdrawal Requests</button>
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

      <div class="modal fade" data-backdrop="static" id="decline-request-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
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
              $attr = array('id' => 'decline-request-form');
              echo form_open('sabicapital/index/admin/decline_superforex_fund_request',$attr);
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


      <div id="view-superforex-funding-and-withdrawal-history-btn" onclick="viewAccountFundingAndWithdrawalHistory(this,event)" rel="tooltip" data-toggle="tooltip" title="View Account Funding And Withdrawal History" style="background: #9124a3; cursor: pointer; position: fixed; bottom: 0; right: 0;  border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
        <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
          <i class="fas fa-history" style="font-size: 25px; color: #fff;" aria-hidden="true"></i>
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

          $("#decline-request-form").submit(function (evt) {
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

          
        })
        
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 