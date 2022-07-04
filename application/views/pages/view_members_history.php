         <!-- End Navbar -->
      <style>
        tr{
          cursor: pointer;
        } 
      </style>
      <script>
        var global_user_name = "";
        var global_full_name = "";
        var global_user_id = "";

        
        var global_search = false;
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

          function selectUser(elem,id) {
            var user_name = elem.getAttribute("data-user-name");
            var full_name = elem.getAttribute("data-full-name");
            var modal_title = $("#fundUserModal .modal-title").html();
            $("#fundUserModal .modal-title").html(modal_title + "" + user_name);
            $("#fundUserModal #enter_amount_form").attr("data-id",id);
            $("#fundUserModal #enter_amount_form").attr("data-name",full_name);
            $("#fundUserModal").modal({
              "show" : true,
              "backdrop" : false,
              "keyboard" : false
            })
          }

          function reloadPage (elem) {
            document.location.reload(); 
          }

          function viewAllMembers (elem,evt) {
          
            $(".spinner-overlay").show();
            var url = "<?php echo site_url('meetglobal/load_users_for_viewing_history'); ?>";
            
            $.ajax({
              url : url,
              type : "POST",
              responseType : "json",
              dataType : "json",
              data : "show_records=true",
              success : function(response){
                $(".spinner-overlay").hide();
                if(response.success && response.messages != ""){
                  $("#display-users-card .card-body").html(response.messages);
                  $("#display-users-card #full-user-results-table").DataTable();
                  $("#main-card").hide();
                  $("#display-users-card").show();
                }else{
                  $.notify({
                  message:"Sorry Something Went Wrong"
                  },{
                    type : "warning"  
                  });
                }  
              },
              error : function () {
                $(".spinner-overlay").hide();
                $.notify({
                message:"Something Went Wrong Please Check Your Internet Connection"
                },{
                  type : "danger"  
                });
              }
            }); 
          }

          function goBackFromDisplayUsersCard (elem,evt) {
            $("#main-card").show();
            $("#display-users-card").hide();
          }

          function goBackFromDisplayUsersCardSearch (elem,evt) {
            $("#search-users-card").show();
            $("#display-users-card-search").hide();
          }

          function searchMembers (elem,evt) {
            $("#main-card").hide();
            $("#search-users-card").show();

          }

          function goBackFromSearchUsersCard (elem,evt) {
            $("#main-card").show();
            $("#search-users-card").hide();
          }

          function viewUserHistory (elem,evt,search = false) {
            elem = $(elem);
            var user_name = elem.attr("data-user-name");
            var full_name = elem.attr("data-full-name");
            var user_id = elem.attr("data-user-id");

            if(user_name != "" && full_name != "" && user_id != ""){
              global_user_name = user_name;
              global_full_name = full_name;
              global_user_id = user_id;

              if(search){
                global_search = true;
              }

              $("#choose-history-to-view-modal .modal-title").html("Choose History To View For <em class='text-primary'>"+global_full_name+"</em>");
              $("#choose-history-to-view-modal").modal("show");
            }
          }

          function viewHistoryForThisMember(elem,evt,type){
            $(".spinner-overlay").show();
            var url = "<?php echo site_url('meetglobal/load_days_for_user_selected_history'); ?>";
            
            $.ajax({
              url : url,
              type : "POST",
              responseType : "json",
              dataType : "json",
              data : "show_records=true&type="+type+"&user_id="+global_user_id,
              success : function(response){
                $(".spinner-overlay").hide();
                if(response.success && response.messages != "" && response.title != ""){
                  var title = response.title;
                  $("#user-history-dates-card .card-body").html(response.messages);
                  $("#user-history-dates-card #user-history-dates-table").DataTable();
                  $("#choose-history-to-view-modal").modal("hide");
                  if(!global_search){
                    $("#display-users-card").hide();
                  }else{
                    $("#display-users-card-search").hide();
                  }
                  $("#user-history-dates-card .card-title").html(title);
                  $("#user-history-dates-card").show();
                }else{
                  $.notify({
                  message:"Sorry Something Went Wrong"
                  },{
                    type : "warning"  
                  });
                }  
              },
              error : function () {
                $(".spinner-overlay").hide();
                $.notify({
                message:"Something Went Wrong Please Check Your Internet Connection"
                },{
                  type : "danger"  
                });
              }
            }); 
          }

          function goBackFromUserHistoryDatesCard(elem,evt){
            $("#choose-history-to-view-modal").modal("show");
            if(!global_search){
              $("#display-users-card").show();
            }else{
              $("#display-users-card-search").show();
            }
            
            $("#user-history-dates-card").hide();
          }

          function loadAccountCredithistoryByDate(elem,evt){
            elem = $(elem);
            var date = elem.attr("data-date");
            if(date != ""){
              $(".spinner-overlay").show();
              var url = "<?php echo site_url('meetglobal/load_account_credit_history_for_user_by_date'); ?>";
              
              $.ajax({
                url : url,
                type : "POST",
                responseType : "json",
                dataType : "json",
                data : "show_records=true&date="+date+"&user_id="+global_user_id,
                success : function(response){
                  $(".spinner-overlay").hide();
                  if(response.success && response.messages != ""){
                    $("#account-credit-history-card .card-body").html(response.messages);
                    $("#account-credit-history-card .card-title").html("Account Credit History <br> Full Name: <em class='text-primary'>"+global_full_name+"</em><br> User Name: <em class='text-primary'>"+global_user_name+"</em><br> Date: <em class='text-primary'>"+date+"</em>");
                    $("#account-credit-history-card #account-credit-history-table").DataTable();
                    
                    
                    $("#user-history-dates-card").hide();
                    $("#account-credit-history-card").show();
                  }else{
                    $.notify({
                    message:"Sorry Something Went Wrong"
                    },{
                      type : "warning"  
                    });
                  }  
                },
                error : function () {
                  $(".spinner-overlay").hide();
                  $.notify({
                  message:"Something Went Wrong Please Check Your Internet Connection"
                  },{
                    type : "danger"  
                  });
                }
              }); 
            }
          }

          function goBackFromAccountCreditHistoryCard (elem,evt) {
            $("#user-history-dates-card").show();
            $("#account-credit-history-card").hide();
          }

          function loadWithdrawalhistoryByDate(elem,evt){
            elem = $(elem);
            var date = elem.attr("data-date");
            if(date != ""){
              $(".spinner-overlay").show();
              var url = "<?php echo site_url('meetglobal/load_withdrawal_history_for_user_by_date'); ?>";
              
              $.ajax({
                url : url,
                type : "POST",
                responseType : "json",
                dataType : "json",
                data : "show_records=true&date="+date+"&user_id="+global_user_id,
                success : function(response){
                  $(".spinner-overlay").hide();
                  if(response.success && response.messages != ""){
                    $("#withdrawal-history-card .card-body").html(response.messages);
                    $("#withdrawal-history-card .card-title").html("Withdrawal History <br> Full Name: <em class='text-primary'>"+global_full_name+"</em><br> User Name: <em class='text-primary'>"+global_user_name+"</em><br> Date: <em class='text-primary'>"+date+"</em>");
                    $("#withdrawal-history-card #withdrawal-history-table").DataTable();
                    
                    
                    $("#user-history-dates-card").hide();
                    $("#withdrawal-history-card").show();
                  }else{
                    $.notify({
                    message:"Sorry Something Went Wrong"
                    },{
                      type : "warning"  
                    });
                  }  
                },
                error : function () {
                  $(".spinner-overlay").hide();
                  $.notify({
                  message:"Something Went Wrong Please Check Your Internet Connection"
                  },{
                    type : "danger"  
                  });
                }
              }); 
            }
          }

          function goBackFromWithdrawalHistoryCard (elem,evt) {
            $("#user-history-dates-card").show();
            $("#withdrawal-history-card").hide();
          }

          function loadVtuHistoryByDate(elem,evt){
            elem = $(elem);
            var date = elem.attr("data-date");
            if(date != ""){
              $(".spinner-overlay").show();
              var url = "<?php echo site_url('meetglobal/load_vtu_history_for_user_by_date'); ?>";
              
              $.ajax({
                url : url,
                type : "POST",
                responseType : "json",
                dataType : "json",
                data : "show_records=true&date="+date+"&user_id="+global_user_id,
                success : function(response){
                  $(".spinner-overlay").hide();
                  if(response.success && response.messages != ""){
                    $("#vtu-history-card .card-body").html(response.messages);
                    $("#vtu-history-card .card-title").html("VTU Transactions History <br> Full Name: <em class='text-primary'>"+global_full_name+"</em><br> User Name: <em class='text-primary'>"+global_user_name+"</em><br> Date: <em class='text-primary'>"+date+"</em>");
                    $("#vtu-history-card #vtu-history-table").DataTable();
                    
                    
                    $("#user-history-dates-card").hide();
                    $("#vtu-history-card").show();
                  }else{
                    $.notify({
                    message:"Sorry Something Went Wrong"
                    },{
                      type : "warning"  
                    });
                  }  
                },
                error : function () {
                  $(".spinner-overlay").hide();
                  $.notify({
                  message:"Something Went Wrong Please Check Your Internet Connection"
                  },{
                    type : "danger"  
                  });
                }
              }); 
            }
          }

          function goBackFromVtuHistoryCard (elem,evt) {
            $("#user-history-dates-card").show();
            $("#vtu-history-card").hide();
          }

          function loadTransferHistoryByDate(elem,evt){
            elem = $(elem);
            var date = elem.attr("data-date");
            if(date != ""){
              $(".spinner-overlay").show();
              var url = "<?php echo site_url('meetglobal/load_transfer_history_for_user_by_date'); ?>";
              
              $.ajax({
                url : url,
                type : "POST",
                responseType : "json",
                dataType : "json",
                data : "show_records=true&date="+date+"&user_id="+global_user_id,
                success : function(response){
                  $(".spinner-overlay").hide();
                  if(response.success && response.messages != ""){
                    $("#transfer-history-card .card-body").html(response.messages);
                    $("#transfer-history-card .card-title").html("Transfers History <br> Full Name: <em class='text-primary'>"+global_full_name+"</em><br> User Name: <em class='text-primary'>"+global_user_name+"</em><br> Date: <em class='text-primary'>"+date+"</em>");
                    $("#transfer-history-card #transfer-history-table").DataTable();
                    
                    
                    $("#user-history-dates-card").hide();
                    $("#transfer-history-card").show();
                  }else{
                    $.notify({
                    message:"Sorry Something Went Wrong"
                    },{
                      type : "warning"  
                    });
                  }  
                },
                error : function () {
                  $(".spinner-overlay").hide();
                  $.notify({
                  message:"Something Went Wrong Please Check Your Internet Connection"
                  },{
                    type : "danger"  
                  });
                }
              }); 
            }
          }

          function goBackFromTransferHistoryCard (elem,evt) {
            $("#user-history-dates-card").show();
            $("#transfer-history-card").hide();
          }

          function loadAdminCreditHistoryByDate(elem,evt){
            elem = $(elem);
            var date = elem.attr("data-date");
            if(date != ""){
              $(".spinner-overlay").show();
              var url = "<?php echo site_url('meetglobal/load_admin_credit_history_for_user_by_date'); ?>";
              
              $.ajax({
                url : url,
                type : "POST",
                responseType : "json",
                dataType : "json",
                data : "show_records=true&date="+date+"&user_id="+global_user_id,
                success : function(response){
                  $(".spinner-overlay").hide();
                  if(response.success && response.messages != ""){
                    $("#admin-credit-history-card .card-body").html(response.messages);
                    $("#admin-credit-history-card .card-title").html("Admin Credit History <br> Full Name: <em class='text-primary'>"+global_full_name+"</em><br> User Name: <em class='text-primary'>"+global_user_name+"</em><br> Date: <em class='text-primary'>"+date+"</em>");
                    $("#admin-credit-history-card #admin-credit-history-table").DataTable();
                    
                    
                    $("#user-history-dates-card").hide();
                    $("#admin-credit-history-card").show();
                  }else{
                    $.notify({
                    message:"Sorry Something Went Wrong"
                    },{
                      type : "warning"  
                    });
                  }  
                },
                error : function () {
                  $(".spinner-overlay").hide();
                  $.notify({
                  message:"Something Went Wrong Please Check Your Internet Connection"
                  },{
                    type : "danger"  
                  });
                }
              }); 
            }
          }

          function goBackFromAdminCreditHistoryCard (elem,evt) {
            $("#user-history-dates-card").show();
            $("#admin-credit-history-card").hide();
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

          function debitMember (elem,evt) {
            elem = $(elem);
            
            var form_data = {
              show_records : true,
              user_id : global_user_id
            }
            var url = "<?php echo site_url('meetglobal/get_current_users_account_balance') ?>";
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
                if(response.success && response.account_balance != false){
                  var account_balance = response.account_balance;
                  $("#debit-member-card .card-title").html("Debit Member: <br> Full Name: <em class='text-primary'>" + global_full_name + "</em><br> User Name: <em class='text-primary'>" + global_user_name + "</em>")
                  $("#debit-member-card #debit-member-form label").html("Enter Amount To Debit User. Max (N"+addCommas(
                    account_balance)+")");
                  $("#debit-member-card #debit-member-form input#amount").attr("max",account_balance);
                  $("#choose-history-to-view-modal").modal("hide");
                  $("#display-users-card-search").hide();
                  $("#debit-member-card").show();
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

          function goBackFromDebitMemberCard (elem,evt) {
            
            $("#choose-history-to-view-modal").modal("show");
            $("#display-users-card-search").show();
            $("#debit-member-card").hide();
          }
      </script>
      <div class="content">
        <div class="container-fluid">
          <div class="spinner-overlay" style="display: none;">
            <div class="spinner-well">
              <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading..." style="">
            </div>
          </div>
          <h2 class="text-center" style="margin-bottom: 50px;">View Members History</h2>
          <div class="row">
            <div class="col-sm-12">

              <div class="row justify-content-center">
                <div class="card col-sm-6" id="debit-member-card" style="display: none;">
                  <div class="card-header">
                    <button class="btn btn-warning btn-round" onclick="goBackFromDebitMemberCard(this,event)">Go Back</button>
                    <h3 class="card-title"></h3>
                  </div>
                  <div class="card-body">
                    <?php
                    $attr = array('id' => 'debit-member-form');
                    echo form_open('meetglobal/debit_member',$attr);
                    ?>
                      <div class="form-group">
                        <label for="amount">Enter Amount To Debit User</label>
                        <input type="number" class="form-control" name="amount" id="amount" max="" step="any" required>
                      </div>
                      <input type="submit" class="btn btn-primary">
                    </form>
                  </div>
                </div>
              </div>

              <div class="card" id="admin-credit-history-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromAdminCreditHistoryCard(this,event)">Go Back</button>
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>


              <div class="card" id="transfer-history-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromTransferHistoryCard(this,event)">Go Back</button>
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>


              <div class="card" id="vtu-history-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromVtuHistoryCard(this,event)">Go Back</button>
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="withdrawal-history-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromWithdrawalHistoryCard(this,event)">Go Back</button>
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="account-credit-history-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromAccountCreditHistoryCard(this,event)">Go Back</button>
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="user-history-dates-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromUserHistoryDatesCard(this,event)">Go Back</button>
                  <h3 class="card-title"></h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>
              
              <div class="card" id="main-card">
                <div class="card-header">
                  <h3 class="card-title">Choose Action: </h3>
                </div>
                <div class="card-body" style="padding-top: 60px;">
                  <button class="btn btn-primary" onclick="viewAllMembers(this,event)">View All Members</button>
                  <button class="btn btn-success" onclick="searchMembers(this,event)">Search Members</button>
                </div>
              </div>

              <div class="card" id="search-users-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromSearchUsersCard(this,event)">Go Back</button>
                  <h3 class="card-title">Enter User Name</h3>
                </div>
                <div class="card-body">
                  <?php 
                    $attr = array('id' => 'user_name_form');
                    echo form_open("meetglobal/load_users_for_viewing_history",$attr);
                  ?>

                    <div class="form-group">
                      <input type="text" placeholder="User Name" id="user_name" name="user_name" class="form-control" required>
                    </div>
                    <input type="submit" class="btn btn-primary">
                  </form>
                </div>
              </div>

              <div class="card" id="display-users-card-search" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromDisplayUsersCardSearch(this,event)">Go Back</button>
                  <!-- <h3 class="card-title">Registered Members</h3> -->
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card" id="display-users-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromDisplayUsersCard(this,event)">Go Back</button>
                  <h3 class="card-title">Registered Members</h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>
            </div>



            <div class="modal fade" id="choose-history-to-view-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Choose History To View  For dave1614</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <table class="table">
                      <tbody>
                        <tr onclick="viewHistoryForThisMember(this,event,'account_credit')">
                          <td>1</td>
                          <td>Account Credit History</td>
                        </tr>
                        <tr onclick="viewHistoryForThisMember(this,event,'withdrawal')">
                          <td>2</td>
                          <td>Withdrawal History</td>
                        </tr>
                        <tr onclick="viewHistoryForThisMember(this,event,'vtu')">
                          <td>3</td>
                          <td>VTU History</td>
                        </tr>
                        <tr onclick="viewHistoryForThisMember(this,event,'transfer')">
                          <td>4</td>
                          <td>Transfer History</td>
                        </tr>
                        <tr onclick="viewHistoryForThisMember(this,event,'admin_credit')">
                          <td>5</td>
                          <td>Admin Credit History</td>
                        </tr>
                        <tr onclick="debitMember(this,event)">
                          <td class="text-danger">6</td>
                          <td class="text-danger">Debit User</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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

          $("#debit-member-form").submit(function (evt) {
            evt.preventDefault();
            var me = $(this);
            var url = me.attr("action");
            var amount = me.find("input#amount").val();
            swal({
              title: 'Warning',
              text: "You Are About To Debit <em class='text-primary'>" + global_user_name + "</em> Of N" + addCommas(amount) + ".<br> Are You Sure You Want To Proceed?",
              type: 'warning',
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
                data : "user_id="+global_user_id+"&amount="+amount,
                success : function(response){
                  $(".spinner-overlay").hide();
                  if(response.success){
                    $.notify({
                      message: global_user_name +" Has Been Successfully Debited Of N" + addCommas(amount)
                    },{
                      type : "success"  
                    });

                    setTimeout(function () {
                      document.location.reload();
                    }, 1500);
                  }else if(response.exceeds_max && response.account_balance != false){
                    var account_balance = response.account_balance;
                    $("#debit-member-card #debit-member-form label").html("Enter Amount To Debit User. Max (N"+addCommas(
                      account_balance)+")");
                    $("#debit-member-card #debit-member-form input#amount").attr("max",account_balance);
                    swal({
                      title: 'Error',
                      text: "Amount Entered Surpasses The Account Balance Of This Member.",
                      type: 'error'
                    });
                  }else{
                    swal({
                      title: 'Error',
                      text: "Sorry Something Went Wrong",
                      type: 'error'
                    });
                  }
                },error : function () {
                  $(".spinner-overlay").hide();
                  swal({
                    title: 'Error',
                    text: "Sorry Something Went Wrong. Please Check Your Internet Connection",
                    type: 'error'
                  });
                } 
              }); 
            });
          })

          
          $("#user_name_form").submit(function (evt) {
            evt.preventDefault();
            var  me = $(this);
            $(".spinner-overlay").show();
            var user_name = me.find('#user_name').val();
            var url = "<?php echo site_url('meetglobal/load_users_for_viewing_history'); ?>";
            
            $.ajax({
              url : url,
              type : "POST",
              responseType : "json",
              dataType : "json",
              data : "show_records=true&user_name="+user_name,
              success : function(response){
                $(".spinner-overlay").hide();
                if(response.success && response.messages != ""){
                  $("#display-users-card-search .card-body").html(response.messages);
                  $("#display-users-card-search #full-user-results-table").DataTable();
                  $("#search-users-card").hide();
                  $("#display-users-card-search").show();
                }else{
                  $.notify({
                  message:"Sorry Something Went Wrong"
                  },{
                    type : "warning"  
                  });
                }  
              },
              error : function () {
                $(".spinner-overlay").hide();
                $.notify({
                message:"Something Went Wrong Please Check Your Internet Connection"
                },{
                  type : "danger"  
                });
              }
            }); 
          })

        <?php
         if($this->session->credit_success && $this->session->amount && $this->session->full_name){ 
          $amount = $this->session->amount;
          $full_name = $this->session->full_name;
          unset($_SESSION['credit_success']);
          unset($_SESSION['amount']);
          ?>
          
          swal({
            title: 'Success',
            text: "You Have Successfully Credited <?php echo $full_name; ?> With ₦<?php echo number_format($amount); ?>",
            type: 'success'
          })
        <?php } ?>
        })
        
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 