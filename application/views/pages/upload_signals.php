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

          function viewFundAcountHistoryInfoById(elem,evt,id){
            var form_data = {
              "show_records": true,
              "id" : id
            }
            var url = "<?php echo site_url('sabicapital/index/admin/view_more_info_on_superforex_deposit_request'); ?>";
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
                
                if(response.success && response.messages != ""){
                  var messages = response.messages;
                  $("#more-info-superforex-fund-request-card .card-body").html(messages);
                  $("#main-card").hide();
                  $("#more-info-superforex-fund-request-card").show();
                  
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
          }

          function goBackFromMoreInfoSuperforexFundRequestCard (elem,evt) {
            $("#main-card").show();
            $("#more-info-superforex-fund-request-card").hide();
          }

          function performActionOnWithdrawalRequest(elem,evt,id){
            elem = $(elem);
            var full_name = elem.attr("data-full-name");

            var url = "<?php echo site_url('sabicapital/index/admin/view_more_info_on_superforex_withdrawal_request_history') ?>";
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
                  $("#main-card").hide();
                  $("#view-withdrawal-requests-card-info .card-body").html(messages);
                  $("#view-withdrawal-requests-card-info").show();
                }else if(response.invalid_id){
                  swal({
                    title: 'Error',
                    text: "This Request Is Invalid",
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
            $("#main-card").show();
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

          function clearThisSabiAcademyRequest(elem,evt,id){
            swal({
              title: 'Warning',
              text: "Are You Sure You Want To Clear This Request?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
              var url = "<?php echo site_url('sabicapital/index/admin/clear_sabi_academy_request') ?>";
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
                      message:"Request Cleared Successfully"
                    },{
                      type : "success"  
                    });
                    setTimeout(function () {
                      document.location.reload();
                    }, 1500);
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

          function uploadNewSignal (elem,evt) {
            $("#main-card").hide();
            $("#upload-new-signal-card").show();
            $("#upload-new-signal-btn").hide("fast");
          }

          function goBackFromUploadNewSignalCard (elem,evt) {
            $("#main-card").show();
            $("#upload-new-signal-card").hide();
            $("#upload-new-signal-btn").show("fast");
          }

          function deleteThisSignal (elem,evt,id) {
            swal({
              title: 'Warning',
              text: "Are You Sure You Want To Delete This Signal?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes Proceed!',
              cancelButtonText : "No"
            }).then(function(){
              var url = "<?php echo site_url('sabicapital/index/admin/delete_this_signal') ?>";
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
                      message:"Signal Deleted Successfully"
                    },{
                      type : "success"  
                    });
                    setTimeout(function () {
                      document.location.reload();
                    }, 1500);
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

          function editTthisSignal (elem,evt,id) {
            
            var url = "<?php echo site_url('sabicapital/index/admin/get_edit_signal_form') ?>";
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
                
                if(response.success && response.messages != ""){
                  var messages = response.messages;
                  $("#edit-this-signal-card #edit-this-signal-form").html(messages);
                  $("#edit-this-signal-card").show();
                  $("#main-card").hide();
                  $("#upload-new-signal-btn").hide("fast")
                 
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
            
          }

          function goBackFromEditThisSignalCard (elem,evt) {
            
            $("#edit-this-signal-card").hide();
            $("#main-card").show();
            $("#upload-new-signal-btn").show("fast")
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
          <!-- <h2>All Registered Members</h2> -->
          <div class="row justify-content-center">
            

              <div class="card" id="view-withdrawal-requests-card-info" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning btn-round" onclick="goBackFromViewWithdrawalRequestsInfo(this,event)">Go Back</button>
                  <h3 class="card-title">Perform Action On This Pending Superforex Withdrawal Request</h3>
                </div>
                <div class="card-body">
                  
                </div>
              </div>

              <div class="card col-sm-7" id="edit-this-signal-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning" onclick="goBackFromEditThisSignalCard(this,event)">Go Back</button>
                  <h3 class="card-title">Edit This Signal</h3>
                </div>
                <div class="card-body">
                <?php 
                  $attr = array('id' => 'edit-this-signal-form');
                  echo form_open('sabicapital/index/admin/edit_this_signal',$attr);
                ?>

                </form>
                </div>
              </div>

              <div class="card col-sm-7" id="upload-new-signal-card" style="display: none;">
                <div class="card-header">
                  <button class="btn btn-warning" onclick="goBackFromUploadNewSignalCard(this,event)">Go Back</button>
                  <h3 class="card-title">Upload New Signal</h3>
                </div>
                <div class="card-body">
                <?php 
                  $attr = array('id' => 'upload-new-signal-form');
                  echo form_open('sabicapital/index/admin/upload_new_signal',$attr);
                ?>
                  <div class="form-group">
                    <label for="currency_pair">Currency Pair: </label>  
                    <input type="text" name="currency_pair" id="currency_pair" class="form-control">
                    <span class="form-error"></span>
                  </div>

                  <div class="form-group">
                    <label for="buy_val">Buy: </label>  
                    <input type="number" step="any" name="buy_val" id="buy_val" class="form-control">
                    <span class="form-error"></span>
                  </div>

                  <div class="form-group">
                    <label for="buy_tp">Buy TP: </label>  
                    <input type="number" step="any" name="buy_tp" id="buy_tp" class="form-control">
                    <span class="form-error"></span>
                  </div>

                  <div class="form-group">
                    <label for="buy_sl">Buy SL: </label>  
                    <input type="number" step="any" name="buy_sl" id="buy_sl" class="form-control">
                    <span class="form-error"></span>
                  </div>

                  <div class="form-group">
                    <label for="sell_val">Sell: </label>  
                    <input type="number" step="any" name="sell_val" id="sell_val" class="form-control">
                    <span class="form-error"></span>
                  </div>

                  <div class="form-group">
                    <label for="sell_tp">Sell TP: </label>  
                    <input type="number" step="any" name="sell_tp" id="sell_tp" class="form-control">
                    <span class="form-error"></span>
                  </div>

                  <div class="form-group">
                    <label for="sell_sl">Sell SL: </label>  
                    <input type="number" step="any" name="sell_sl" id="sell_sl" class="form-control">
                    <span class="form-error"></span>
                  </div>

                  <input type="submit" class="btn btn-primary col-12" value="Submit">
                </form>
                </div>
              </div>

              <div class="card col-sm-12" id="main-card">
                <div class="card-header">
                  
                  <h3 class="card-title">Todays Signals (<?php echo date("j M Y"); ?>)</h3>
                </div>
                <div class="card-body">
                <?php
                  $response_arr = array('messages' => '');
                  if(isset($rows)){
                    // var_dump($rows);
                    
                   
                    if(is_array($rows)){
                      // var_dump($_GET);
                    
                      $j = 0;
                 
                      $response_arr['messages'] .= '<div class="table-div material-datatables table-responsive" style="">';
                      $response_arr['messages'] .= '<table id="signal-table" class="table table-test table-striped table-bordered nowrap hover display" cellspacing="0" width="100%" style="width:100%">';
                      $response_arr['messages'] .= '<thead>';
                      $response_arr['messages'] .= '<tr>';
                      $response_arr['messages'] .= '<th>#</th>';
                      $response_arr['messages'] .= '<th>Currency Pair</th>';
                      $response_arr['messages'] .= '<th>Buy</th>';
                      $response_arr['messages'] .= '<th>Buy TP</th>';
                      $response_arr['messages'] .= '<th>Buy SL</th>';
                      $response_arr['messages'] .= '<th>Sell </th>';
                      $response_arr['messages'] .= '<th>Sell TP</th>';
                      $response_arr['messages'] .= '<th>Sell SL</th>';
                      $response_arr['messages'] .= '<th>Time</th>';
                      $response_arr['messages'] .= '<th>Actions</th>';
                     
                      $response_arr['messages'] .= '</tr>';
                      $response_arr['messages'] .= '</thead>';
                      $response_arr['messages'] .= '<tbody>';

                      foreach($rows as $row){
                        $j++;
                        
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
                        
                        $response_arr['messages'] .= '<tr onclick="editTthisSignal(this,event,'.$id.')">';

                        $response_arr['messages'] .= '<td>'.$j.'</td>';
                        $response_arr['messages'] .= '<td>'.$currency_pair.'</td>';
                        $response_arr['messages'] .= '<td>'.$buy_val.'</td>';
                        $response_arr['messages'] .= '<td>'.$buy_tp.'</td>';
                        $response_arr['messages'] .= '<td>'.$buy_sl.'</td>';
                        $response_arr['messages'] .= '<td>'.$sell_val.'</td>';
                        $response_arr['messages'] .= '<td>'.$sell_tp.'</td>';
                        $response_arr['messages'] .= '<td>'.$sell_sl.'</td>';
                        $response_arr['messages'] .= '<td>'.$time.'</td>';

                        $response_arr['messages'] .= '<td class="td-actions text-center">';
                        $response_arr['messages'] .= '<button onclick="deleteThisSignal(this,event,'.$id.')" type="button" rel="tooltip" title="Delete This Signal" class="btn btn-danger">';
                        $response_arr['messages'] .= '<i style="color: #fff;" class="fas fa-trash-alt"></i>';
                        $response_arr['messages'] .= '<div class="ripple-container"></div>';
                        $response_arr['messages'] .= '</button>';
                        $response_arr['messages'] .= '</td>';

                        $response_arr['messages'] .= '</tr>';
                          
                      }
                      $response_arr['messages'] .= '</tbody>';
                      $response_arr['messages'] .= '</table>';
                      $response_arr['messages'] .= '</div>';
                                   
                    }else{
                      $response_arr['messages'] .= '<h4 class="text-warning">No Records To Display Here.</h4>';
                    }

                    echo $response_arr['messages'];
                  }
                ?>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div id="upload-new-signal-btn" onclick="uploadNewSignal(this,event)" rel="tooltip" data-toggle="tooltip" title="Upload New Signal" style="background: #9124a3; cursor: pointer; position: fixed; bottom: 0; right: 0;  border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
        <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
          <i class="fas fa-plus" style="font-size: 25px; color: #fff;" aria-hidden="true"></i>
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

          $("#signal-table").DataTable();

          $("#edit-this-signal-form").submit(function (evt) {
            evt.preventDefault();
            var me = $(this);
            
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
                    message:"Signal Edited Successfully"
                  },{
                    type : "success"  
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
                $(".spinner-overlay").hide();
                swal({
                  title: 'Ooops',
                  text: "Something Went Wrong. Please Check Your Internet Connection",
                  type: 'error',                              
                })
              }
            });
            
          })

          $("#upload-new-signal-form").submit(function (evt) {
            evt.preventDefault();
            var me = $(this);
            
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
                    message:"Signal Added Successfully"
                  },{
                    type : "success"  
                  });
                  setTimeout(function () {
                    document.location.reload();
                  }, 1500);
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
            
          })
        })
        
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 