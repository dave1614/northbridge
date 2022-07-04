         <!-- End Navbar -->
      <script>
        function newNigeria (elem,evt) {
          evt.preventDefault();
           swal({
            title: 'Choose Action',
            text: "Do You Have A Sponsor?",
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText : "No"
          }).then(function(){
             // $(".package-card").hide();
             $(".package-card").hide();
             $("#sponsor-id-card").show();
          }, function(dismiss){
             if(dismiss == 'cancel'){
                 // function when cancel button is clicked
               
                var url = "<?php echo site_url('meetglobal/remove_sponsor_id') ?>"
               
                var form_data = "remove_sponsor_id=true";
                $(".spinner-overlay").show();
                $.ajax({
                  type : "POST",
                  dataType : "json",
                  responseType : "json",
                  url : url,
                  data : form_data,
                  success : function (response) {
                    $(".spinner-overlay").hide();
                   if(response.success == true){
                      $(".spinner-overlay").hide();
                      swal({
                        title: 'Choose Action',
                        text: "Please Select Payment Method",
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Online Payment',
                        cancelButtonText : "Existing Funds"
                      }).then(function(){
                        swal({
                          title: 'Choose Action',
                          text: "Do You Want To Proceed To Online Payment?. Amount To Pay: 2,498",
                          type: 'success',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Yes',
                          cancelButtonText : "No"
                        }).then(function(){
                            $(".spinner-overlay").show();
                            document.location.assign("<?php echo site_url('meetglobal/index/package_payment/new_nigeria') ?>")
                        }, function(dismiss){
                           if(dismiss == 'cancel'){
                               // function when cancel button is clicked

                               document.location.reload();
                           }
                        });    
                      }, function(dismiss){
                         if(dismiss == 'cancel'){
                          console.log('cancelled')
                             // function when cancel button is clicked
                            swal({
                              title: 'Choose Action',
                              text: "Are You Sure You Want To Pay From Your Existing Funds?. Amount To Pay: 2,800",
                              type: 'success',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Yes',
                              cancelButtonText : "No"
                            }).then(function(){
                                $(".spinner-overlay").show();
                                var url = "<?php echo site_url('meetglobal/index/check_if_user_is_buoyant/new_nigeria') ?>"
                                  var form_data = "check_if_user_is_buoyant=true";
                                  $.ajax({
                                    type : "POST",
                                    dataType : "json",
                                    responseType : "json",
                                    url : url,
                                    data : form_data,
                                    success : function (response) {
                                      $(".spinner-overlay").hide();
                                      if(response.success == true && response.bouyant == true){
                                        
                                        $(".spinner-overlay").show();
                                        var url = "<?php echo site_url('meetglobal/index/process-payment-existing/new_nigeria') ?>"
                                        var form_data = "check_if_user_is_buoyant=true";
                                        $.ajax({
                                          type : "POST",
                                          dataType : "json",
                                          responseType : "json",
                                          url : url,
                                          data : form_data,
                                          success : function (response) {
                                            $(".spinner-overlay").hide();
                                            console.log(response)
                                            if(response.success == true && response.bouyant == true){
                                              
                                              document.location.reload();
                                            }else if(response.bouyant == false){
                                              swal({
                                                title: 'Insuffecient Balance',
                                                text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                                                type: 'error',
                                                allowOutsideClick: false,
                                                allowEscapeKey:false,
                                                confirmButtonColor: '#3085d6',
                                                
                                                confirmButtonText: 'Ok'
                                                
                                              }).then(function(){
                                                document.location.reload();
                                              });
                                            }
                                          },error: function () {
                                            
                                          } 
                                        });
                                      }else if(response.bouyant == false && response.success == true){
                                        swal({
                                          title: 'Insuffecient Balance',
                                          text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                                          type: 'error',
                                          allowOutsideClick: false,
                                          allowEscapeKey:false,
                                          confirmButtonColor: '#3085d6',
                                          
                                          confirmButtonText: 'Ok'
                                          
                                        }).then(function(){
                                          document.location.reload();
                                        });
                                      }
                                    },error : function () {
                                      
                                    } 
                                  });   
                                
                            }, function(dismiss){
                               if(dismiss == 'cancel'){
                                   // function when cancel button is clicked
                                   
                                   document.location.reload();
                               }
                            });
                         }
                      }); 
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
                      message:"Sorry Something Went Wrong"
                    },{
                      type : "danger"  
                    });
                  } 
                });
             }
          });
        }

        function submitSponsorName (elem,evt) {
          evt.preventDefault();
          var url = "<?php echo site_url('meetglobal/submit_sponsor_id') ?>"
          var country_code = $("#sponsor_name_form .cc-picker-code").html();
          var phone_number = elem.querySelector("#sponsor-num").value;
          
          var form_data = "sponsor-num="+phone_number+"&sponsor-num_phoneCode="+country_code;
          $(".spinner-overlay").show();
          $.ajax({
            type : "POST",
            dataType : "json",
            responseType : "json",
            url : url,
            data : form_data,
            success : function (response) {
              $(".spinner-overlay").hide();
             if(response.success == true){
                
                swal({
                  title: 'Choose Action',
                  text: "Please Select Payment Method",
                  type: 'success',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Online Payment',
                  cancelButtonText : "Existing Funds"
                }).then(function(){
                  swal({
                    title: 'Choose Action',
                    text: "Do You Want To Proceed To Online Payment?. Amount To Pay: 2,498",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText : "No"
                  }).then(function(){
                      $(".spinner-overlay").show();
                      document.location.assign("<?php echo site_url('meetglobal/index/package_payment/new_nigeria') ?>")
                  }, function(dismiss){
                     if(dismiss == 'cancel'){
                         // function when cancel button is clicked
                         
                         document.location.reload();
                     }
                  });    
                }, function(dismiss){
                   if(dismiss == 'cancel'){
                       // function when cancel button is clicked
                    swal({
                      title: 'Choose Action',
                      text: "Are You Sure You Want To Pay From Your Existing Funds?. Amount To Pay: 2,498",
                      type: 'success',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes',
                      cancelButtonText : "No"
                    }).then(function(){
                        $(".spinner-overlay").show();
                        var url = "<?php echo site_url('meetglobal/index/check_if_user_is_buoyant/new_nigeria') ?>"
                          var form_data = "check_if_user_is_buoyant=true";
                          $.ajax({
                            type : "POST",
                            dataType : "json",
                            responseType : "json",
                            url : url,
                            data : form_data,
                            success : function (response) {
                              $(".spinner-overlay").hide();
                              if(response.success == true && response.bouyant == true){
                                
                                $(".spinner-overlay").show();
                                var url = "<?php echo site_url('meetglobal/index/process-payment-existing/new_nigeria') ?>"
                                var form_data = "check_if_user_is_buoyant=true";
                                $.ajax({
                                  type : "POST",
                                  dataType : "json",
                                  responseType : "json",
                                  url : url,
                                  data : form_data,
                                  success : function (response) {
                                    $(".spinner-overlay").hide();
                                    console.log(response)
                                    if(response.success == true && response.bouyant == true){
                                      
                                      document.location.reload();
                                    }else if(response.bouyant == false){
                                      swal({
                                        title: 'Insuffecient Balance',
                                        text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                                        type: 'error',
                                        allowOutsideClick: false,
                                        allowEscapeKey:false,
                                        confirmButtonColor: '#3085d6',
                                        
                                        confirmButtonText: 'Ok'
                                        
                                      }).then(function(){
                                        document.location.reload();
                                      });
                                    }
                                  },error: function () {
                                    
                                  } 
                                });
                              }else if(response.bouyant == false && response.success == true){
                                swal({
                                  title: 'Insuffecient Balance',
                                  text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                                  type: 'error',
                                  allowOutsideClick: false,
                                  allowEscapeKey:false,
                                  confirmButtonColor: '#3085d6',
                                  
                                  confirmButtonText: 'Ok'
                                  
                                }).then(function(){
                                  document.location.reload();
                                });
                              }
                            },error : function () {
                              
                            } 
                          });   
                        
                    }, function(dismiss){
                       if(dismiss == 'cancel'){
                           // function when cancel button is clicked
                           
                           document.location.reload();
                       }
                    });
                   }
                }); 
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
                message:"Sorry Something Went Wrong"
              },{
                type : "danger"  
              });
            } 
          });   
        }

        function greatNigeria (elem,evt) {
          evt.preventDefault();
           swal({
            title: 'Choose Action',
            text: "Do You Have A Sponsor?",
            type: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText : "No"
          }).then(function(){
             // $(".package-card").hide();
             $(".package-card").hide();
             $("#sponsor-id-card-great").show();
          }, function(dismiss){
             if(dismiss == 'cancel'){
                 // function when cancel button is clicked
               
                var url = "<?php echo site_url('meetglobal/remove_sponsor_id') ?>"
               
                var form_data = "remove_sponsor_id=true";
                $(".spinner-overlay").show();
                $.ajax({
                  type : "POST",
                  dataType : "json",
                  responseType : "json",
                  url : url,
                  data : form_data,
                  success : function (response) {
                    $(".spinner-overlay").hide();
                   if(response.success == true){
                      $(".spinner-overlay").hide();
                      swal({
                        title: 'Choose Action',
                        text: "Please Select Payment Method",
                        type: 'success',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Online Payment',
                        cancelButtonText : "Existing Funds"
                      }).then(function(){
                        swal({
                          title: 'Choose Action',
                          text: "Do You Want To Proceed To Online Payment?. Amount To Pay: 5,300",
                          type: 'success',
                          showCancelButton: true,
                          confirmButtonColor: '#3085d6',
                          cancelButtonColor: '#d33',
                          confirmButtonText: 'Yes',
                          cancelButtonText : "No"
                        }).then(function(){
                            $(".spinner-overlay").show();
                            document.location.assign("<?php echo site_url('meetglobal/index/package_payment/great_nigeria') ?>")
                        }, function(dismiss){
                           if(dismiss == 'cancel'){
                               // function when cancel button is clicked

                               document.location.reload();
                           }
                        });    
                      }, function(dismiss){
                         if(dismiss == 'cancel'){
                          console.log('cancelled')
                             // function when cancel button is clicked
                            swal({
                              title: 'Choose Action',
                              text: "Are You Sure You Want To Pay From Your Existing Funds?. Amount To Pay: 5,300",
                              type: 'success',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Yes',
                              cancelButtonText : "No"
                            }).then(function(){
                                $(".spinner-overlay").show();
                                var url = "<?php echo site_url('meetglobal/index/check_if_user_is_buoyant/great_nigeria') ?>"
                                  var form_data = "check_if_user_is_buoyant=true";
                                  $.ajax({
                                    type : "POST",
                                    dataType : "json",
                                    responseType : "json",
                                    url : url,
                                    data : form_data,
                                    success : function (response) {
                                      $(".spinner-overlay").hide();
                                      if(response.success == true && response.bouyant == true){
                                        
                                        $(".spinner-overlay").show();
                                        var url = "<?php echo site_url('meetglobal/index/process-payment-existing/great_nigeria') ?>"
                                        var form_data = "check_if_user_is_buoyant=true";
                                        $.ajax({
                                          type : "POST",
                                          dataType : "json",
                                          responseType : "json",
                                          url : url,
                                          data : form_data,
                                          success : function (response) {
                                            $(".spinner-overlay").hide();
                                            console.log(response)
                                            if(response.success == true && response.bouyant == true){
                                              
                                              document.location.reload();
                                            }else if(response.bouyant == false){
                                              swal({
                                                title: 'Insuffecient Balance',
                                                text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                                                type: 'error',
                                                allowOutsideClick: false,
                                                allowEscapeKey:false,
                                                confirmButtonColor: '#3085d6',
                                                
                                                confirmButtonText: 'Ok'
                                                
                                              }).then(function(){
                                                document.location.reload();
                                              });
                                            }
                                          },error: function () {
                                            
                                          } 
                                        });
                                      }else if(response.bouyant == false && response.success == true){
                                        swal({
                                          title: 'Insuffecient Balance',
                                          text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                                          type: 'error',
                                          allowOutsideClick: false,
                                          allowEscapeKey:false,
                                          confirmButtonColor: '#3085d6',
                                          
                                          confirmButtonText: 'Ok'
                                          
                                        }).then(function(){
                                          document.location.reload();
                                        });
                                      }
                                    },error : function () {
                                      
                                    } 
                                  });   
                                
                            }, function(dismiss){
                               if(dismiss == 'cancel'){
                                   // function when cancel button is clicked
                                   
                                   document.location.reload();
                               }
                            });
                         }
                      }); 
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
                      message:"Sorry Something Went Wrong"
                    },{
                      type : "danger"  
                    });
                  } 
                });
             }
          });
        }

        function submitSponsorNameGreat (elem,evt) {
          evt.preventDefault();
          var url = "<?php echo site_url('meetglobal/submit_sponsor_id') ?>"
          var country_code = $("#sponsor_name_form_great .cc-picker-code").html();
          var phone_number = elem.querySelector("#sponsor-num").value;
          
          var form_data = "sponsor-num="+phone_number+"&sponsor-num_phoneCode="+country_code;
          $(".spinner-overlay").show();
          $.ajax({
            type : "POST",
            dataType : "json",
            responseType : "json",
            url : url,
            data : form_data,
            success : function (response) {
              $(".spinner-overlay").hide();
             if(response.success == true){
                
                swal({
                  title: 'Choose Action',
                  text: "Please Select Payment Method",
                  type: 'success',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Online Payment',
                  cancelButtonText : "Existing Funds"
                }).then(function(){
                  swal({
                    title: 'Choose Action',
                    text: "Do You Want To Proceed To Online Payment?. Amount To Pay: 5,300",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText : "No"
                  }).then(function(){
                      $(".spinner-overlay").show();
                      document.location.assign("<?php echo site_url('meetglobal/index/package_payment/great_nigeria') ?>")
                  }, function(dismiss){
                     if(dismiss == 'cancel'){
                         // function when cancel button is clicked
                         
                         document.location.reload();
                     }
                  });    
                }, function(dismiss){
                   if(dismiss == 'cancel'){
                       // function when cancel button is clicked
                    swal({
                      title: 'Choose Action',
                      text: "Are You Sure You Want To Pay From Your Existing Funds?. Amount To Pay: 5,300",
                      type: 'success',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes',
                      cancelButtonText : "No"
                    }).then(function(){
                        $(".spinner-overlay").show();
                        var url = "<?php echo site_url('meetglobal/index/check_if_user_is_buoyant/great_nigeria') ?>"
                          var form_data = "check_if_user_is_buoyant=true";
                          $.ajax({
                            type : "POST",
                            dataType : "json",
                            responseType : "json",
                            url : url,
                            data : form_data,
                            success : function (response) {
                              $(".spinner-overlay").hide();
                              if(response.success == true && response.bouyant == true){
                                
                                $(".spinner-overlay").show();
                                var url = "<?php echo site_url('meetglobal/index/process-payment-existing/great_nigeria') ?>"
                                var form_data = "check_if_user_is_buoyant=true";
                                $.ajax({
                                  type : "POST",
                                  dataType : "json",
                                  responseType : "json",
                                  url : url,
                                  data : form_data,
                                  success : function (response) {
                                    $(".spinner-overlay").hide();
                                    console.log(response)
                                    if(response.success == true && response.bouyant == true){
                                      
                                      document.location.reload();
                                    }else if(response.bouyant == false){
                                      swal({
                                        title: 'Insuffecient Balance',
                                        text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                                        type: 'error',
                                        allowOutsideClick: false,
                                        allowEscapeKey:false,
                                        confirmButtonColor: '#3085d6',
                                        
                                        confirmButtonText: 'Ok'
                                        
                                      }).then(function(){
                                        document.location.reload();
                                      });
                                    }
                                  },error: function () {
                                    
                                  } 
                                });
                              }else if(response.bouyant == false && response.success == true){
                                swal({
                                  title: 'Insuffecient Balance',
                                  text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
                                  type: 'error',
                                  allowOutsideClick: false,
                                  allowEscapeKey:false,
                                  confirmButtonColor: '#3085d6',
                                  
                                  confirmButtonText: 'Ok'
                                  
                                }).then(function(){
                                  document.location.reload();
                                });
                              }
                            },error : function () {
                              
                            } 
                          });   
                        
                    }, function(dismiss){
                       if(dismiss == 'cancel'){
                           // function when cancel button is clicked
                           
                           document.location.reload();
                       }
                    });
                   }
                }); 
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
                message:"Sorry Something Went Wrong"
              },{
                type : "danger"  
              });
            } 
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
          <h2>Start Earning</h2>
          <div class="row">
            <div class="col-sm-6 text-center">
              <div class="card package-card">
                <div class="card-header">
                  <h4 class="card-title">Ambassador</h4>
                </div>
                <div class="card-body">
                  <a href="#" onclick="newNigeria(this,event)" class="btn btn-rose">Register</a>
                </div>
              </div>
            </div>

            <div class="col-sm-6 text-center">
              <div class="card package-card">
                <div class="card-header">
                  <h4 class="card-title">Great Ambassador</h4>
                </div>
                <div class="card-body">
                  <a href="#" onclick="greatNigeria(this,event)" class="btn btn-rose">Register</a>
                </div>
              </div>
            </div>

            <p class="text-primary text-center" style="font-style: italic;">Note: Extra Charge Of ₦300 Applies When Using Online Payment.</p>
  
            <div class="col-sm-10 text-center">
              <div class="card" id="sponsor-id-card" style="display: none;">
                <div class="card-header">
                  <h4 class="card-title">Enter Sponsor Id</h4>
                </div>
                <div class="card-body">
                  <?php $attributes = array('id' => 'sponsor_name_form','onsubmit' => '') ?>
                  <?php echo form_open('',$attributes); ?>
                    <div class="form-group">
                      <label class="patient_info_label" id="patient_name_label" for="sponsor-num">Enter Sponsor Phone Number: </label>
                        
                        <input type="number" value="<?php echo $this->meetglobal_model->getUserReferredByForSpons($user_id); ?>" placeholder="e.g 08127027321" id="sponsor-num" name="sponsor-num" class="phone-field form-control"/>
                      <!-- </div> -->
                      <span class="sponsor-name" style="color: red; font-style: italic;"></span>
                      
                    </div>
                    
                    <button type="submit" class="btn btn-primary disabled">Submit</button>
                  <?php echo form_close(); ?>
                </div>
              </div>

              <div class="card" id="sponsor-id-card-great" style="display: none;">
                <div class="card-header">
                  <h4 class="card-title">Enter Sponsor Id</h4>
                </div>
                <div class="card-body">
                  <?php $attributes = array('id' => 'sponsor_name_form_great','onsubmit' => '') ?>
                  <?php echo form_open('',$attributes); ?>
                    <div class="form-group">
                      <label class="patient_info_label" id="patient_name_label" for="sponsor-num">Enter Sponsor Phone Number: </label>
                        
                        <input type="number" placeholder="e.g 08127027321" id="sponsor-num" name="sponsor-num" class="phone-field form-control" value="<?php echo $this->meetglobal_model->getUserReferredByForSpons($user_id); ?>" />
                      <!-- </div> -->
                      <span class="sponsor-name" style="color: red; font-style: italic;"></span>
                      
                    </div>
                    
                    <button type="submit" class="btn btn-primary disabled">Submit</button>
                  <?php echo form_close(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
           <div class="modal fade" data-backdrop="static" id="sponsor-name-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Enter Sponsor Id</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body" id="modal-body">
                
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
        $(document).ready(function() {
          $("#sponsor_name_form #sponsor-num").CcPicker({ countryCode: "<?php echo $this->meetglobal_model->getCountryCodeById($user_id); ?>", dataUrl: "<?php echo base_url('assets/data.json'); ?>", searchPlaceHolder: "Find..." });

          $("#sponsor_name_form_great #sponsor-num").CcPicker({ countryCode: "<?php echo $this->meetglobal_model->getCountryCodeById($user_id); ?>", dataUrl: "<?php echo base_url('assets/data.json'); ?>", searchPlaceHolder: "Find..." });

          $("#sponsor_name_form").submit(function (evt) {
            evt.preventDefault();
          })

          $("#sponsor_name_form_great").submit(function (evt) {
            evt.preventDefault();
          })

          $("#sponsor_name_form #sponsor-num").keyup(function (evt) {
            var country_code = $("#sponsor_name_form .cc-picker-code").html();
            var phone_number = $(this).val();
            
            var url = "<?php echo site_url('meetglobal/get_sponsor_name') ?>"
            var form_data = "sponsor-num="+phone_number+"&sponsor-num_phoneCode="+country_code;
            // $(".spinner-overlay").show();
            console.log(form_data)
            $.ajax({
              type : "POST",
              dataType : "json",
              responseType : "json",
              url : url,
              data : form_data,
              success : function (response) {
               console.log(response)
                if(response.success == true && response.full_name !== "" && response.user_name !== ""){
                  $("#sponsor_name_form button").removeClass("disabled");
                  $("#sponsor_name_form").attr("onsubmit","submitSponsorName(this,event)");
                  $("#sponsor_name_form .sponsor-name").html("Full Name: " + response.full_name + "<br>" + "UserName: " + response.user_name);
                }else if(response.success == false && response.messages !== ""){
                  $("#sponsor_name_form").attr("onsubmit","");
                  $("#sponsor_name_form button").addClass("disabled");
                  $("#sponsor_name_form .sponsor-name").html("");
                  $("#sponsor_name_form").find('.form-error').remove();
                  $.each(response.messages, function (key,value) {

                  var element = $('#sponsor_name_form #'+key);
                  // console.log(value)
                  element = element.closest('div.form-group')
                  
                  element.after(value);                 
                  
                 });
                  
                }else{
                  $("#sponsor_name_form").attr("onsubmit","");
                  $("#sponsor_name_form").find('.form-error').remove();
                  $("#sponsor_name_form button").addClass("disabled");
                  $("#sponsor_name_form .sponsor-name").html("No User With This Mobile Number");
                }
              },
              error : function () {
                $("#sponsor_name_form .sponsor-name").html("");
                $("#sponsor_name_form button").addClass("disabled");
                $.notify({
                  message:"Sorry Something Went Wrong"
                },{
                  type : "danger"  
                });
              }
            });  
          })

          $("#sponsor_name_form_great #sponsor-num").keyup(function (evt) {
            var country_code = $("#sponsor_name_form_great .cc-picker-code").html();
            var phone_number = $(this).val();
            
            var url = "<?php echo site_url('meetglobal/get_sponsor_name') ?>"
            var form_data = "sponsor-num="+phone_number+"&sponsor-num_phoneCode="+country_code;
            // $(".spinner-overlay").show();
            $.ajax({
              type : "POST",
              dataType : "json",
              responseType : "json",
              url : url,
              data : form_data,
              success : function (response) {
                console.log(response)
                if(response.success == true && response.full_name !== "" && response.user_name !== ""){
                  $("#sponsor_name_form_great button").removeClass("disabled");
                  $("#sponsor_name_form_great").attr("onsubmit","submitSponsorNameGreat(this,event)");
                  $("#sponsor_name_form_great .sponsor-name").html("Full Name: " + response.full_name + "<br>" + "UserName: " + response.user_name);
                }else if(response.success == false && response.messages !== ""){
                  $("#sponsor_name_form_great").attr("onsubmit","");
                  $("#sponsor_name_form_great button").addClass("disabled");
                  $("#sponsor_name_form_great .sponsor-name").html("");
                  $("#sponsor_name_form_great").find('.form-error').remove();
                  $.each(response.messages, function (key,value) {

                  var element = $('#sponsor_name_form_great #'+key);
                  // console.log(value)
                  element = element.closest('div.form-group')
                  
                  element.after(value);                 
                  
                 });
                  
                }else{
                  $("#sponsor_name_form_great").attr("onsubmit","");
                  $("#sponsor_name_form_great").find('.form-error').remove();
                  $("#sponsor_name_form_great button").addClass("disabled");
                  $("#sponsor_name_form_great .sponsor-name").html("No User With This Mobile Number");
                }
              },
              error : function () {
                $("#sponsor_name_form_great .sponsor-name").html("");
                $("#sponsor_name_form_great button").addClass("disabled");
                $.notify({
                  message:"Sorry Something Went Wrong"
                },{
                  type : "danger"  
                });
              }
            });  
          })

        <?php
         if($this->session->error && $this->session->error == "wrong"){ 
          unset($_SESSION['error']);
          ?>
          $.notify({
          message:"Something Went Wrong. Please Check Your Internet Connection And Try Again"
          },{
            type : "warning"  
          });
        <?php } ?>  

        <?php
         if($this->session->success && $this->session->success == true){ 
          unset($_SESSION['success']);
          ?>
          $.notify({
          message:"Successfully Registered"
          },{
            type : "success"  
          });
        <?php } ?>  

        <?php
         if($this->session->unsucessful_verification && $this->session->unsucessful_verification == true){ 
          unset($_SESSION['unsucessful_verification']);
          ?>
          $.notify({
          message:"Sorry Your Payment Could Not Be Verified Successfully"
          },{
            type : "warning"  
          });
        <?php } ?>  
         
        });
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 