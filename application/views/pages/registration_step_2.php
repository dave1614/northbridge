<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login V1</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
  <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css'); ?>">
<!--===============================================================================================-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/animate/animate.css') ?>">
<!--===============================================================================================-->  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/css-hamburgers/hamburgers.min.css'); ?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendor/select2/select2.min.css')?>">
<!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_css/util.css'); ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/login_css/main.css'); ?>">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/swal-forms.css'); ?>">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
  <link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
  <style>
    tr{
      cursor: pointer;
    }
  </style>
<!--===============================================================================================-->
<script>
  
  var submit_btn1;
  var submit_btn_spinner1;
  var sponsor_id = "";
  var registrar_user_name = "";

  var use_as_sponsor_username;
  var use_as_placement_id;
  var use_as_position;
  var package;

  function registration2CallBack(response) {
    console.log(response);
    if(response.status === "PARTIALLY_AUTHENTICATED") {
        var code = response.code;
        var state = response.state;
        console.log(code)
        var form_data = {
            code : code,
            state : state,
            user_name : "<?php echo $second_addition; ?>"
        };
        console.log(form_data)
        submit_btn_spinner1.show();
        submit_btn1.addClass("disabled");
        <?php if(isset($_GET['id'])){ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registration_step_2_otp?id='.$_GET['id']) ?>";
        <?php }else{ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registration_step_2_otp') ?>";
        if(sponsor_id != ""){
          url += "?id="+sponsor_id;
        }
        <?php } ?>

        $.ajax({
            url : url,
            type : "POST",
            responseType : "json",
            dataType : "json",
            data : form_data,
            success : function (response) {
                submit_btn_spinner1.hide();
                submit_btn1.removeClass("disabled");
                console.log(response)
                if(response.success && response.url != ""){
                   swal({
                    title: 'Success',
                    html: "You Have Been Successfully Verified. You Will Be Redirected To Secure Payment Page To Pay 3,500. Are You Sure You Want To Proceed",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText : "No"
                  }).then((result) => {
                    if (result.value) {
                      swal({
                        title: 'Choose Action: ',
                        html: "Do You Want To  ?",
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#4caf50',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Pay With Online Payment',
                        cancelButtonText : "Use Insider Account For Payment"
                      }).then((result) => {
                        if (result.value) {
                          var url = response.url;
                          window.location.assign(url);
                        }
                        else if (
                          // Read more about handling dismissals
                          result.dismiss === Swal.DismissReason.cancel
                        ) {
                          $("#main-div").hide("slow");
                          $("#login-form1").show("slow");
                        }
                      });
                    }   
                    
                  });  
                }else if(response.phone_change){
                  swal({
                    title: 'Error',
                    text: "The Phone Number Was Changed! Try Again And Don't Change It",
                    type: 'error',                              
                  })
                }
            },error : function (jqXHR,error, errorThrown) {
                submit_btn_spinner1.hide();
                submit_btn1.removeClass("disabled");
                $.notify({
                  message:"Sorry Something Went Wrong."
                  },{
                    type : "danger"  
                  });
            }
        });  
    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      console.log("Authentication failure");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
      console.log("Bad parameters");
    }
  }

  function forgotPass (elem,evt) {
      $("#login-form").hide("fast");
      $("#enter-username-form").show("fast");
  }

  function signInForgot (elem,evt) {
    $("#login-form").show("fast");
    $("#enter-username-form").hide("fast");
  }

  function proceed (elem,evt){
    elem = $(elem);
    <?php if(isset($_GET['id'])){ ?>
    var sponsor_username = "<?php echo $_GET['id']; ?>";
    <?php }else{ ?>
    var sponsor_username = $('input#user_name').val();
    <?php } ?>
    console.log(sponsor_username);
    if(sponsor_username != ""){
      submit_btn1 = elem;
      submit_btn_spinner1 = elem.find(".spinner");
      elem.addClass('disabled');
      submit_btn_spinner1.show();
      var url = "<?php echo site_url('meetglobal/index/get_if_user_is_valid_for_registration_2/'.$second_addition); ?>";
      var form_data = {
        show_records : true,
        sponsor_username : sponsor_username
      }
      $.ajax({
        url : url,
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : form_data,
        success : function (response) {
          elem.removeClass('disabled');
          submit_btn_spinner1.hide();
          if(response.success && response.user_profile_img != "" && response.sponsor_full_name != "" && response.sponsor_phone_num){
            var text_html = "";
            var user_profile_img = response.user_profile_img;
            var sponsor_full_name = response.sponsor_full_name;
            var sponsor_phone_num = response.sponsor_phone_num;
            text_html = "<div class='container'>";
            text_html += "<h3 style='font-size: 18px;'>Are You Sure These Are The Details Of Your Sponsor?</h3>";
            text_html += "<div class='row' style='margin-top: 22px;'>";
            text_html += user_profile_img;
            text_html += "<div class='col-sm-8'>";
            text_html += "<p class='text-left' style='font-size: 16px; font-weight: 700;'>Full Name: <em>"+sponsor_full_name+"</em></p>";
            text_html += "<p class='text-left' style='font-size: 16px; font-weight: 700;'>User Name: <em>"+sponsor_username+"</em></p>";
            text_html += "<p class='text-left' style='font-size: 16px; font-weight: 700;'>Phone Number: <em>"+sponsor_phone_num+"</em></p>";
            text_html += "</div>";
            text_html += "</div>";
            text_html += "</div>";
            swal({
              title: 'Check',
              html: text_html,
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText : "No"
            }).then((result) => {
              if (result.value) {
                swal({
                  title: 'Info',
                  html: "Do You Have A Placement Position In Mind?",
                  type: 'question',
                  showCancelButton: true,
                  confirmButtonColor: '#4caf50',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes',
                  cancelButtonText : "No"
                }).then((result) => {
                  if (result.value) {
                    $("#select-sponsor-div").hide("slow");
                    $("#select-placement-div").show("slow");
                    use_as_sponsor_username = sponsor_username;
                  }else if (
                      // Read more about handling dismissals
                      result.dismiss === Swal.DismissReason.cancel
                    ) {
                    var code = "+" + elem.attr("data-code");
                    var phone_number = "0" + elem.attr("data-phone");
                    sponsor_id = $("#user_name").val();
                    verifyUserAgain(code,phone_number);
                  }
                });
              }else if (
                  // Read more about handling dismissals
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                swal({
                  title: 'No Problem!',
                  html: "Just Verify The Sponsor's UserName And Try Again",
                  type: 'info'
                })
              }   
            }); 

          }else if(response.you_cant_be_sponsor){
            swal({
              title: 'Error!',
              html: "Sorry You Cannot Enter Yourself As Sponsor.",
              type: 'error'
            })
          }else if(response.user_name_does_not_exist){
            swal({
              title: 'Error!',
              html: "Sorry Sponsor Username Entered Does Not Exist.",
              type: 'error'
            })
          }else{
            swal({
              title: 'Error!',
              html: "Something Went Wrong.",
              type: 'error'
            })
          }  
        },error : function () {
          elem.removeClass('disabled');
          submit_btn_spinner1.hide();
          swal({
            title: 'Error!',
            html: "Something Went Wrong Please Check Your Internet Connection! ",
            type: 'error'
          })
        } 
      });
    }else{
      
      swal({
        title: 'Error!',
        html: "You Must Enter Sponsor Username To Proceed",
        type: 'error'
      })
    }  
  }

  function proceedPlacementUsername (elem,evt){
    elem = $(elem);
    
    var placement_user_name = $('input#placement_user_name').val();
    
    console.log(placement_user_name);
    if(placement_user_name != ""){
      submit_btn1 = elem;
      submit_btn_spinner1 = elem.find(".spinner");
      elem.addClass('disabled');
      submit_btn_spinner1.show();
      var url = "<?php echo site_url('meetglobal/index/get_if_user_is_valid_for_registration_2/'.$second_addition); ?>";
      var form_data = {
        show_records : true,
        sponsor_username : placement_user_name
      }
      $.ajax({
        url : url,
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : form_data,
        success : function (response) {
          elem.removeClass('disabled');
          submit_btn_spinner1.hide();
          if(response.success && response.user_profile_img != "" && response.sponsor_full_name != "" && response.sponsor_phone_num){
            var text_html = "";
            var user_profile_img = response.user_profile_img;
            var sponsor_full_name = response.sponsor_full_name;
            var sponsor_phone_num = response.sponsor_phone_num;
            text_html = "<div class='container'>";
            text_html += "<h3 style='font-size: 18px;'>Are You Sure These Are The Details Of Your Placement?</h3>";
            text_html += "<div class='row' style='margin-top: 22px;'>";
            text_html += user_profile_img;
            text_html += "<div class='col-sm-8'>";
            text_html += "<p class='text-left' style='font-size: 16px; font-weight: 700;'>Full Name: <em>"+sponsor_full_name+"</em></p>";
            text_html += "<p class='text-left' style='font-size: 16px; font-weight: 700;'>User Name: <em>"+placement_user_name+"</em></p>";
            text_html += "<p class='text-left' style='font-size: 16px; font-weight: 700;'>Phone Number: <em>"+sponsor_phone_num+"</em></p>";
            text_html += "</div>";
            text_html += "</div>";
            text_html += "</div>";
            swal({
              title: 'Check',
              html: text_html,
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText : "No"
            }).then((result) => {
              if (result.value) {
                elem.addClass('disabled');
                submit_btn_spinner1.show();
                
                
                var url = "<?php echo site_url('meetglobal/index/get_user_name_mlm_accounts_for_this_user_placement_new_user/'.$second_addition); ?>";
                var form_data = {
                  show_records : true,
                  val : placement_user_name
                }
                $.ajax({
                  url : url,
                  type : "POST",
                  responseType : "json",
                  dataType : "json",
                  data : form_data,
                  success : function (response) {
                    elem.removeClass('disabled');
                    submit_btn_spinner1.hide();
                    if(response.success && response.messages != ""){
                      var messages = response.messages;
                      
                      $("#select-mlm-account-for-placement-div .div-body").html(messages);
                      $("#select-mlm-account-for-placement-div #select-placement-table").DataTable({
                        aLengthMenu: [
                            [25, 50, 100, 200, -1],
                            [25, 50, 100, 200, "All"]
                        ],
                        iDisplayLength: -1
                      });
                      
                      $("#select-placement-div").hide("fast");
                      $("#select-mlm-account-for-placement-div").show("fast");
                    }else if(response.invalid_username){
                      swal({
                        title: 'Error!',
                        html: "Invalid Username Entered",
                        type: 'error'
                      })
                    }else{
                      swal({
                        title: 'Error!',
                        html: "Something Is Not Right.",
                        type: 'error'
                      })
                    }
                  },error : function () {
                    elem.removeClass('disabled');
                    submit_btn_spinner1.hide();
                    swal({
                      title: 'Error!',
                      html: "Something Went Wrong Please Check Your Internet Connection And Try Again.",
                      type: 'error'
                    })
                  }
                });  
              }else if (
                  // Read more about handling dismissals
                  result.dismiss === Swal.DismissReason.cancel
                ) {
                swal({
                  title: 'OK!',
                  html: "You Can Enter New Placement And Proceed",
                  type: 'info'
                })
              }
            }); 

          }else if(response.you_cant_be_sponsor){
            swal({
              title: 'Error!',
              html: "Sorry You Cannot Enter Yourself As Placement.",
              type: 'error'
            })
          }else if(response.user_name_does_not_exist){
            swal({
              title: 'Error!',
              html: "Sorry Placement Username Entered Does Not Exist.",
              type: 'error'
            })
          }else{
            swal({
              title: 'Error!',
              html: "Something Went Wrong.",
              type: 'error'
            })
          }  
        },error : function () {
          elem.removeClass('disabled');
          submit_btn_spinner1.hide();
          swal({
            title: 'Error!',
            html: "Something Went Wrong Please Check Your Internet Connection! ",
            type: 'error'
          })
        } 
      });
    }else{
      
      swal({
        title: 'Error!',
        html: "You Must Enter Sponsor Username To Proceed",
        type: 'error'
      })
    }  
  }

  function verifyUserAgain (code,phone_number) {
    
    // console.log(code + " " + phone_number)
    // AccountKit.login('PHONE', {
    //   countryCode: code, phoneNumber: phone_number
    // }, // will use default values if this is not specified
    // registration2CallBack); 
    submit_btn_spinner1.show();
    submit_btn1.addClass("disabled");
    <?php if(isset($_GET['id'])){ ?>
    var url = "<?php echo site_url('meetglobal/verify_user_registration_step_2_otp?id='.$_GET['id']) ?>";
    <?php }else{ ?>
    var url = "<?php echo site_url('meetglobal/verify_user_registration_step_2_otp') ?>";
    if(sponsor_id != ""){
      url += "?id="+sponsor_id;
    }
    <?php } ?>

    var form_data = {
      user_name : "<?php echo $second_addition; ?>"
    }

    
    swal({
      title: 'Success',
      html: "You Have Been Successfully Verified. Your Registration Is About To Be Processed. Are You Sure You Want To Proceed?",
      type: 'success',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText : "No"
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url : url,
          type : "POST",
          responseType : "json",
          dataType : "json",
          data : form_data,
          success : function (response) {
            submit_btn_spinner1.hide();
            submit_btn1.removeClass("disabled");
            console.log(response)
            if(response.success){
              window.location.assign("<?php echo site_url('meetglobal/admin_page') ?>");
            }else{
              swal({
                title: 'Error',
                text: "Sorry Something Went Wrong.",
                type: 'error',                              
              })
            }
          },error : function (jqXHR,error, errorThrown) {
            submit_btn_spinner1.hide();
            submit_btn1.removeClass("disabled");
            $.notify({
            message:"Sorry Something Went Wrong."
            },{
              type : "danger"  
            });
          }
        }); 
      }   
    });  
            
  }

  function verifyUser2CallBack(response) {
    console.log(response);
    if(response.status === "PARTIALLY_AUTHENTICATED") {
        var code = response.code;
        var state = response.state;
        console.log(code)
        var form_data = {
            code : code,
            state : state,
            user_name : registrar_user_name
        };
        console.log(form_data)
        <?php if(isset($_GET['id'])){ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registrar_otp?id='.$_GET['id']) ?>";
        <?php }else{ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registrar_otp') ?>";
        if(sponsor_id != ""){
          url += "?id="+sponsor_id;
        }
        <?php } ?>

        $.ajax({
            url : url,
            type : "POST",
            responseType : "json",
            dataType : "json",
            data : form_data,
            success : function (response) {
                
                console.log(response)
                if(response.success && response.url != ""){
                   swal({
                    title: 'Success',
                    html: "This Account Has Been Successfully Verified. 3,500 Will Be Subtracted From This Account. Are You Sure You Want To Proceed",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText : "No"
                  }).then(function(){

                    <?php if(isset($_GET['id'])){ ?>
                    var url = "<?php echo site_url('meetglobal/index/verify_registration_payment_registrar/'.$second_addition.'?id='.$_GET['id']) ?>";
                    <?php }else{ ?>
                    var url = "<?php echo site_url('meetglobal/index/verify_registration_payment_registrar/'.$second_addition) ?>";
                    if(sponsor_id != ""){
                      url += "?id="+sponsor_id;
                    }
                    <?php } ?>

                    var form_data = {
                      registrar_user_name : registrar_user_name
                    };

                    $.ajax({
                      url : url,
                      type : "POST",
                      responseType : "json",
                      dataType : "json",
                      data : form_data,
                      success : function (response) {
                        if(response.success){
                          window.location.assign(response.url);
                        }
                      },error : function (jqXHR,error, errorThrown) {
                        
                        $.notify({
                          message:"Sorry Something Went Wrong."
                        },{
                          type : "danger"  
                        });

                      }

                    }); 


                  });  
                }else if(response.phone_change){
                  swal({
                    title: 'Error',
                    text: "The Phone Number Was Changed! Try Again And Don't Change It",
                    type: 'error',                              
                  })
                }
            },error : function (jqXHR,error, errorThrown) {
                submit_btn_spinner1.hide();
                submit_btn1.removeClass("disabled");
                $.notify({
                  message:"Sorry Something Went Wrong."
                  },{
                    type : "danger"  
                  });
            }
        });  
    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      console.log("Authentication failure");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
      console.log("Bad parameters");
    }
  }

  function reenterPlacement (elem,evt) {
    swal({
      title: 'Reenter Placement ? ',
      html: "Are You Sure You Want To Re enter Placement?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText : "No"
    }).then((result) => {
      if (result.value) {
        $("#select-placement-div").show("fast");
        $("#select-mlm-account-for-placement-div").hide("fast");
      }
    });    
  }

  function selectThisUserAsPlacement (elem,evt) {
    elem = $(elem);
    var str = elem.attr("data-str");
    var id = elem.attr("data-mlm-db-id");
    
    selectPositioning(id);
  }

  function selectPositioning(id){
    if(id != ""){
      $(".spinner-overlay").show();
      var url = "<?php echo site_url('meetglobal/index/select_positioning_for_mlm/'.$second_addition); ?>";
      var form_data = {
        show_records : true,
        id : id
      }
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
            $("#select-mlm-account-for-placement-div").hide("slow");
            $("#select-position-for-placement-div .div-body").html(messages);
            $("#select-position-for-placement-div .select-placement-position-table-div #select-placement-position-table").DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
              });
            $("#select-position-for-placement-div").show("slow");
          }else if(response.no_available_position){
            swal({
              title: 'No Available Position',
              text: "Sorry No Available Position Under This Account.",
              type: 'error'
            })
          }else{
            swal({
              title: 'Error!',
              text: "Something Went Wrong.",
              type: 'error'
            })
          }
        },error : function () {
          $(".spinner-overlay").hide();
          swal({
            title: 'Error!',
            text: "Something Went Wrong Please Check Your Internet Connection! ",
            type: 'error'
          })
        } 
      });   
    }
  }

  function reselectPlacement (elem,evt) {
    swal({
      title: 'Reselect Placement ? ',
      html: "Are You Sure You Want To Reselect Placement?",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText : "No"
    }).then((result) => {
      if (result.value) {
        $("#select-mlm-account-for-placement-div").show("slow");
        $("#select-position-for-placement-div").hide("slow");
      }
    });    
  }

  function selectThisPositionPlacement(elem,evt){
    elem = $(elem);
    var placement_id = elem.attr("data-mlm-db-id");
    var placement_position = elem.attr("data-position");
    
    if(placement_id != "" && placement_position != ""){
      swal({
        title: 'Confirm?',
        text: "Are You Sure You Want To Select Position " + placement_position + "?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText : "No"
      }).then((result) => {
        if (result.value) {
          use_as_placement_id = placement_id;
          use_as_position = placement_position;
          performFinalPackageChoice();
        }
      });  
    }
  }

  function performFinalPackageChoice () {
    
    package = "basic";
    performFinalPaymentMethod ();
     
  }

  function performFinalPaymentMethod () {
    if(use_as_placement_id != "" && use_as_position != ""){
      var form_data = {
        sponsor_id : use_as_sponsor_username,
        placement_id : use_as_placement_id,
        positioning : use_as_position,
        package : package
      };

      var code = "+" + $("#proceed-btn").attr("data-code");
      var phone_number = "0" + $("#proceed-btn").attr("data-phone");
      sponsor_id = use_as_sponsor_username;
      

      var form_data = {
            
            user_name : "<?php echo $second_addition; ?>",
            sponsor_id : use_as_sponsor_username,
            placement_id : use_as_placement_id,
            positioning : use_as_position,
            package : package
        };
        console.log(form_data)
        submit_btn_spinner1.show();
        submit_btn1.addClass("disabled");
        <?php if(isset($_GET['id'])){ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registration_step_2_otp_placement_selected?id='.$_GET['id']) ?>";
        <?php }else{ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registration_step_2_otp_placement_selected') ?>";
        if(use_as_sponsor_username != ""){
          url += "?id="+use_as_sponsor_username;
        }
        <?php } ?>

        
        swal({
          title: 'Success',
          html: "You Have Been Successfully Verified. Your Registration Is About To Be Processed. Are You Sure You Want To Proceed?",
          type: 'success',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText : "No"
        }).then((result) => {
          if (result.value) {
            $.ajax({
              url : url,
              type : "POST",
              responseType : "json",
              dataType : "json",
              data : form_data,
              success : function (response) {
                submit_btn_spinner1.hide();
                submit_btn1.removeClass("disabled");
                console.log(response)
                if(response.success){
                  window.location.assign("<?php echo site_url('meetglobal/admin_page'); ?>");
                }else{
                  $.notify({
                    message:"Sorry Something Went Wrong."
                  },{
                    type : "warning"  
                  });
                }
              },error : function (jqXHR,error, errorThrown) {
                submit_btn_spinner1.hide();
                submit_btn1.removeClass("disabled");
                $.notify({
                  message:"Sorry Something Went Wrong."
                },{
                  type : "danger"  
                });
              }
            });   

          }   
        });  
    }   
  }

  function registration2CallBack2(response) {
    console.log(response);
    if(response.status === "PARTIALLY_AUTHENTICATED") {
        var code = response.code;
        var state = response.state;
        console.log(code)
        var form_data = {
            code : code,
            state : state,
            user_name : "<?php echo $second_addition; ?>",
            sponsor_id : use_as_sponsor_username,
            placement_id : use_as_placement_id,
            positioning : use_as_position,
            package : package
        };
        console.log(form_data)
        submit_btn_spinner1.show();
        submit_btn1.addClass("disabled");
        <?php if(isset($_GET['id'])){ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registration_step_2_otp_placement_selected?id='.$_GET['id']) ?>";
        <?php }else{ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registration_step_2_otp_placement_selected') ?>";
        if(use_as_sponsor_username != ""){
          url += "?id="+use_as_sponsor_username;
        }
        <?php } ?>

        $.ajax({
            url : url,
            type : "POST",
            responseType : "json",
            dataType : "json",
            data : form_data,
            success : function (response) {
                submit_btn_spinner1.hide();
                submit_btn1.removeClass("disabled");
                console.log(response)
                if(response.success && response.url != ""){
                   swal({
                    title: 'Success',
                    html: "You Have Been Successfully Verified. You Will Be Redirected To Secure Payment Page To Pay 3,500. Are You Sure You Want To Proceed",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText : "No"
                  }).then((result) => {
                    if (result.value) {
                      swal({
                        title: 'Choose Action: ',
                        html: "Do You Want To  ?",
                        type: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#4caf50',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Pay With Online Payment',
                        cancelButtonText : "Use Insider Account For Payment"
                      }).then((result) => {
                        if (result.value) {
                          var url = response.url;
                          window.location.assign(url);
                        }
                        else if (
                          // Read more about handling dismissals
                          result.dismiss === Swal.DismissReason.cancel
                        ) {
                          $("#main-div").hide("slow");
                          $("#login-form2").show("slow");
                        }
                      });
                    }   
                    
                  });  
                }else if(response.phone_change){
                  swal({
                    title: 'Error',
                    text: "The Phone Number Was Changed! Try Again And Don't Change It",
                    type: 'error',                              
                  })
                }
            },error : function (jqXHR,error, errorThrown) {
                submit_btn_spinner1.hide();
                submit_btn1.removeClass("disabled");
                $.notify({
                  message:"Sorry Something Went Wrong."
                  },{
                    type : "danger"  
                  });
            }
        });  
    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      console.log("Authentication failure");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
      console.log("Bad parameters");
    }
  }

  function verifyUserAgain2 (code,phone_number) {
    
    
    AccountKit.login('PHONE', {
      countryCode: code, phoneNumber: phone_number
    }, // will use default values if this is not specified
    registration2CallBack2); 
    
  }


  function verifyUser2CallBack2(response) {
    console.log(response);
    if(response.status === "PARTIALLY_AUTHENTICATED") {
        var code = response.code;
        var state = response.state;
        console.log(code)
        var form_data = {
          code : code,
          state : state,
          user_name : registrar_user_name,
          <?php if(isset($_GET['id'])){ ?>
          sponsor_id : "<?php echo $_GET['id']; ?>",
          <?php }else{ ?>
          sponsor_id : use_as_sponsor_username,
          <?php } ?>
          placement_id : use_as_placement_id,
          positioning : use_as_position,
          package : package
        };
        console.log(form_data)
        <?php if(isset($_GET['id'])){ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registrar_otp_placement_selected?id='.$_GET['id']) ?>";
        <?php }else{ ?>
        var url = "<?php echo site_url('meetglobal/verify_user_registrar_otp_placement_selected') ?>";
        if(use_as_sponsor_username != ""){
          url += "?id="+use_as_sponsor_username;
        }
        <?php } ?>

        $.ajax({
            url : url,
            type : "POST",
            responseType : "json",
            dataType : "json",
            data : form_data,
            success : function (response) {
                
                console.log(response)
                if(response.success && response.url != ""){
                   swal({
                    title: 'Success',
                    html: "This Account Has Been Successfully Verified. 3,500 Will Be Subtracted From This Account. Are You Sure You Want To Proceed",
                    type: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText : "No"
                  }).then(function(){
                    var sponsor_id = response.sponsor_id;
                    var sponsor_username = response.sponsor_username;
                    var placement_id = response.placement_id;
                    var package = response.package;
                    var positioning = response.positioning;
                    var date = response.date;
                    var time = response.time;

                    var url = "<?php echo site_url('meetglobal/index/verify_registration_payment_placement_selected_1/'.$second_addition)?>" + "?sponsor_id="+sponsor_id+"&placement_id="+placement_id+"&package="+package+"&positioning="+positioning+"&date="+date+"&time="+time;


                    var form_data = {
                      registrar_user_name : registrar_user_name
                    };

                    $.ajax({
                      url : url,
                      type : "POST",
                      responseType : "json",
                      dataType : "json",
                      data : form_data,
                      success : function (response) {
                        if(response.success){
                          window.location.assign(response.url);
                        }else if(response.not_enough_money){
                          swal({
                            title: 'Error',
                            text: "There's Not Enough Money In This Account To Create Proceed With This Transaction.",
                            type: 'error',                              
                          })
                        }else {
                          $.notify({
                            message:"Sorry Something Went Wrong."
                          },{
                            type : "warning"  
                          });
                        }
                      },error : function (jqXHR,error, errorThrown) {
                        
                        $.notify({
                          message:"Sorry Something Went Wrong."
                        },{
                          type : "danger"  
                        });

                      }
                    }); 
                  });  
                }else if(response.phone_change){
                  swal({
                    title: 'Error',
                    text: "The Phone Number Was Changed! Try Again And Don't Change It",
                    type: 'error',                              
                  })
                }
            },error : function (jqXHR,error, errorThrown) {
                submit_btn_spinner1.hide();
                submit_btn1.removeClass("disabled");
                $.notify({
                  message:"Sorry Something Went Wrong."
                  },{
                    type : "danger"  
                  });
            }
        });  
    }
    else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      console.log("Authentication failure");
    }
    else if (response.status === "BAD_PARAMS") {
      // handle bad parameters
      console.log("Bad parameters");
    }
  }

</script>
<style>
  /*.center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;
  }*/
</style>
</head>
<body>
  
  <div class="limiter">

    <div class="container-login100">


      <div class="wrap-login100">
        <div class="text-center" style="width: 100%;">
          <img src="<?php echo base_url('assets/images/logo-img.jpeg'); ?>" style="width: 150px; height: 150px; border-radius: 50%;">
        </div>
        <!-- <h3 class="text-center" style="width: ">Lorem ipsum dolor sit amet.</h3> -->
        <div class="login100-pic js-tilt" data-tilt>
          <img src="<?php echo base_url('assets/login_images/img-01.png'); ?>" alt="IMG">
        </div>

        
        
          
          <div class="login100-form validate-form animated swing" id="main-div">
        
            <span class="login100-form-title" style="padding-bottom: 10px;">
              Step 2 Of Registration
            </span>
            <h4 style="margin-bottom: 40px;">You're About To Complete Registration For <em class="text-warning"><?php echo $second_addition; ?></em></h4>

            <!-- <p class="text-warning" style="text-transform: capitalize; margin-bottom: 30px;">You're Required To Pay A Sum Of 3,500 For Registration. But We'll Be Verifying <em class="text-warning">+<?php echo $phone_code . " " . $phone; ?></em> Which Is The Number Associated With This Account.</p> -->

            <div id="select-sponsor-div">
              
              <div class="wrap-input100 validate-input" data-validate = "" style="<?php if(isset($_GET['id'])){ ?> display: none; <?php } ?>">
                <input class="input100" type="text" id="user_name" placeholder="Enter Sponsor Username" name="user_name" >
                <span class="focus-input100"></span>
                <span class="symbol-input100">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </span>
              </div>
              <div class="container-login100-form-btn">
                <button class="login100-form-btn" id="proceed-btn" data-code="<?php echo $phone_code; ?>" data-phone="<?php echo $phone; ?>" onclick="proceed(this,event)" style="position: relative;">
                  PROCEED
                  <i class="fas fa-arrow-right m-l-5" aria-hidden="true"></i>
                  <img src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>"  class="spinner">
                </button>
              </div>

            </div>


            <div id="select-placement-div" style="display: none;" class="animated bounceInDown">
              <div class="wrap-input100 validate-input" data-validate = "" >
                <input class="input100" type="text" id="placement_user_name" placeholder="Enter Placement Username" name="placement_user_name" >
                <span class="focus-input100"></span>
                <span class="symbol-input100">
                  <i class="fa fa-user" aria-hidden="true"></i>
                </span>
              </div>
              <div class="container-login100-form-btn">
                <button class="login100-form-btn" data-code="<?php echo $phone_code; ?>" data-phone="<?php echo $phone; ?>" onclick="proceedPlacementUsername(this,event)" style="position: relative;">
                  PROCEED
                  <i class="fas fa-arrow-right m-l-5" aria-hidden="true"></i>
                  <img src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>"  class="spinner">
                </button>
              </div>

            </div>

            <div id="select-mlm-account-for-placement-div" style="display: none;" class="animated bounceInDown">
              <button class="btn btn-warning" style="margin-bottom: 20px; color: #fff;" onclick="reenterPlacement(this,event)">&lt; &lt; Need To Reenter Placement ?</button>
              <div class="div-body">
                
              </div>
            </div>


            <div id="select-position-for-placement-div" style="display: none;" class="animated bounceInDown">
              <button class="btn btn-warning" style="margin-bottom: 20px; color: #fff;" onclick="reselectPlacement(this,event)">&lt; &lt; Need To Reselect Placement ?</button>
              <div class="div-body">
                
              </div>
            </div>


          </div>

          <?php
          $attr = array('class' => 'login100-form validate-form animated swing','id' => 'login-form1','style' => 'display: none;') ;
          echo form_open("meetglobal/index/verify_user_name_and_password",$attr); 
        ?>
         <span class="login100-form-title">
            Enter Username And Password
          </span>
          <div class="wrap-input100 validate-input" data-validate = "">
            <input class="input100" type="text" id="user_name_login" name="user_name_login" placeholder="Username" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate = "">
            <input class="input100" type="password" id="password_login" placeholder="Password" name="password_login" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>
          
          <div class="container-login100-form-btn">
            <button class="login100-form-btn" style="position: relative;">
              Proceed
              <i class="fas fa-arrow-right m-l-5" aria-hidden="true"></i>
              <img src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>"  class="spinner">
            </button>
          </div>
        </form>


        <?php
          $attr = array('class' => 'login100-form validate-form animated swing','id' => 'login-form2','style' => 'display: none;') ;
          echo form_open("meetglobal/index/verify_user_name_and_password",$attr); 
        ?>
         <span class="login100-form-title">
            Enter Username And Password
          </span>
          <div class="wrap-input100 validate-input" data-validate = "">
            <input class="input100" type="text" id="user_name_login" name="user_name_login" placeholder="Username" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate = "">
            <input class="input100" type="password" id="password_login" placeholder="Password" name="password_login" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>
          
          <div class="container-login100-form-btn">
            <button class="login100-form-btn" style="position: relative;">
              Proceed
              <i class="fas fa-arrow-right m-l-5" aria-hidden="true"></i>
              <img src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>"  class="spinner">
            </button>
          </div>
        </form>




      </div>
    </div>
  </div>
<!--===============================================================================================-->  
  <script src="<?php echo base_url('assets/vendor/jquery/jquery-3.2.1.min.js');?>"></script>
<!--===============================================================================================-->
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/popper.js') ?>"></script>
  <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.min.js') ?>"></script>
<!--===============================================================================================-->
  <script src="<?php echo base_url('assets/vendor/select2/select2.min.js') ?>"></script>
<!--===============================================================================================-->
  <script src="<?php echo base_url('assets/vendor/tilt/tilt.jquery.min.js') ?>"></script>
  <script >
    $('.js-tilt').tilt({
      scale: 1.1
    })
    $(document).ready(function () {
      $("#login-form2").submit(function (evt) {
        evt.preventDefault();
        var me = $(this);
        var form_data = me.serializeArray();
        var url = me.attr("action");
        var spinner = me.find(".spinner");
        var btn  = me.find('button');

        btn.addClass('disabled');
        spinner.show();
        $.ajax({
          url : url,
          type : "POST",
          responseType : "json",
          dataType : "json",
          data : form_data,
          success : function (response) {
            btn.removeClass('disabled');
            spinner.hide();

            if(response.success){
              var code = response.code;
              var phone_number = response.phone;
              swal({
                title: 'Success',
                html: `We'll Be Verifying <em class="text-warning">+`+code+` `+ phone_number +`</em> Which Is The Number Associated With This Account. Do You Want To Proceed?`,
                type: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText : "No"
              }).then((result) => {
                sponsor_id = $("#user_name").val();
                registrar_user_name = response.user_name;
                code = "+" + code;
                phone_number = "0" + phone_number;
                console.log(code + " " + phone_number)
                AccountKit.login('PHONE', {
                  countryCode: code, phoneNumber: phone_number
                }, // will use default values if this is not specified
                  verifyUser2CallBack2);     
              });
            }else if(!response.user_exists){
              swal({
                title: 'Error',
                html: "This Username Does Not Exist",
                type: 'error'
              })
            }else if(response.invalid_password){
              swal({
                title: 'Error',
                html: "Incorrect Username Password Combination",
                type: 'error'
              })
            }else if(response.not_enough_money){
              swal({
                title: 'Error',
                html: "There Is Not Enough Money In This Account. You Need At Least 3,500 For Registration",
                type: 'error'
              })
            }
          },error : function () {
            btn.removeClass('disabled');
            spinner.hide();
            $.notify({
            message:"Sorry Something Went Wrong."
            },{
              type : "danger"  
            });
          }
        }); 
      })

      $("#login-form1").submit(function (evt) {
        evt.preventDefault();
        var me = $(this);
        var form_data = me.serializeArray();
        var url = me.attr("action");
        var spinner = me.find(".spinner");
        var btn  = me.find('button');

        btn.addClass('disabled');
        spinner.show();
        $.ajax({
          url : url,
          type : "POST",
          responseType : "json",
          dataType : "json",
          data : form_data,
          success : function (response) {
            btn.removeClass('disabled');
            spinner.hide();

            if(response.success){
              var code = response.code;
              var phone_number = response.phone;
              swal({
                title: 'Success',
                html: `We'll Be Verifying <em class="text-warning">+`+code+` `+ phone_number +`</em> Which Is The Number Associated With This Account. Do You Want To Proceed?`,
                type: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText : "No"
              }).then((result) => {
                sponsor_id = $("#user_name").val();
                registrar_user_name = response.user_name;
                code = "+" + code;
                phone_number = "0" + phone_number;
                console.log(code + " " + phone_number)
                AccountKit.login('PHONE', {
                  countryCode: code, phoneNumber: phone_number
                }, // will use default values if this is not specified
                  verifyUser2CallBack);     
              });
            }else if(!response.user_exists){
              swal({
                title: 'Error',
                html: "This Username Does Not Exist",
                type: 'error'
              })
            }else if(response.invalid_password){
              swal({
                title: 'Error',
                html: "Incorrect Username Password Combination",
                type: 'error'
              })
            }else if(response.not_enough_money){
              swal({
                title: 'Error',
                html: "There Is Not Enough Money In This Account. You Need At Least 3,500 For Registration",
                type: 'error'
              })
            }
          },error : function () {
            btn.removeClass('disabled');
            spinner.hide();
            $.notify({
            message:"Sorry Something Went Wrong."
            },{
              type : "danger"  
            });
          }
        }); 
      })


    });
      
  
  </script>
<!--===============================================================================================-->
  <script src="<?php echo base_url('assets/login_js/main.js'); ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap-notify.js')?> "></script>
  <script src="<?php echo base_url('assets/js/sweetalert2.all.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/sweetalert2.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/swal-forms.js') ?>"></script>
  <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
  
  <script src="https://sdk.accountkit.com/en_EN/sdk.js"></script>
  <script>
    AccountKit_OnInteractive = function(){
    AccountKit.init(
      {
        appId:320429851941197,         
        state:"abcd", 
        version:"v1.1"
      }
      //If your Account Kit configuration requires app_secret, you have to include ir above
    );
  };
  </script>


</body>
</html>