<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="../../assets/img/apple-icon.png">
<link rel="icon" type="image/png" href="../../assets/img/favicon.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title>
     
     Allen Express Shipping Company Admin
</title>
<!-- <link rel="preload" href="https://cdn.shareaholic.net/assets/pub/shareaholic.js" as="script" />
<meta name="shareaholic:site_id" content="5867ee1e631cfcddacf637057c0c658b" />
<script data-cfasync="false" async src="https://cdn.shareaholic.net/assets/pub/shareaholic.js"></script> -->

<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />


<!-- Extra details for Live View on GitHub Pages -->
<!-- Canonical SEO -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
<link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
<link href="<?php echo base_url('assets/css/fine-uploader-new.min.css') ?>" rel="stylesheet">

<link rel="stylesheet" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

<!--     Fonts and icons     -->
<!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" /> -->
<link href="https://fonts.googleapis.com/css?family=Roboto|Roboto+Slab" rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/css/component.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/custom_file_input.css') ?>">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.11/css/dataTables.checkboxes.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/owl.carousel.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/owl.theme.css'); ?>">

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('assets/css/jquery.ccpicker.css') ?>" rel="stylesheet" type="text/css">
<!-- CSS Files -->
<style>
  span.last-message{
    font-size: 11px;
    font-style: italic;
  }
  #notification_li2
      {
      position:relative
      }
  #notification_li
      {
      position:relative
      }
      #notificationContainer 
      {
      background-color: #fff;
      border: 1px solid rgba(100, 100, 100, .4);
      -webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
      overflow: visible;
      position: absolute;
      top: 40px;
      /*margin-left: -170px;*/
      right: -12px;
      width: 400px;
      z-index: -1;
      /*display: none; // Enable this after jquery implementation */
      }
      #notificationContainer2
      {
      background-color: #fff;
      border: 1px solid rgba(100, 100, 100, .4);
      -webkit-box-shadow: 0 3px 8px rgba(0, 0, 0, .25);
      overflow: visible;
      position: absolute;
      top: 40px;
      /*margin-left: -170px;*/
      right: -12px;
      width: 400px;
      z-index: -1;
      /*display: none; // Enable this after jquery implementation */
      }
      // Popup Arrow
      #notificationContainer:before {
      content: '';
      display: block;
      position: absolute;
      width: 0;
      height: 0;
      color: transparent;
      border: 10px solid black;
      border-color: transparent transparent white;
      margin-top: -20px;
      margin-left: 188px;
      }
      // Popup Arrow
      #notificationContainer2:before {
      content: '';
      display: block;
      position: absolute;
      width: 0;
      height: 0;
      color: transparent;
      border: 10px solid black;
      border-color: transparent transparent white;
      margin-top: -20px;
      margin-left: 188px;
      }
      #notificationTitle
      {
      font-weight: bold;
      padding: 8px;
      font-size: 13px;
      background-color: #ffffff;
      position: fixed;
      z-index: 1000;
      width: 384px;
      border-bottom: 1px solid #dddddd;
      }

      #notificationTitle2
      {
      font-weight: bold;
      padding: 8px;
      font-size: 13px;
      background-color: #ffffff;
      position: fixed;
      z-index: 1000;
      width: 384px;
      border-bottom: 1px solid #dddddd;
      }
      #notificationsBody
      {
      padding: 0px 0px 0px 0px !important;
      margin-top: 48px;
      min-height:300px;
      }

       #notificationsBody2
      {
      padding: 0px 0px 0px 0px !important;
      margin-top: 48px;
      min-height:300px;
      }


      #notificationsBody p{
        font-size: 13px;
        font-weight: bold;
      }
      #notificationsBody span{
        font-size: 12px;
        /*font-weight: bold;*/
      }

      #notificationsBody2 p{
        font-size: 13px;
        font-weight: bold;
      }
      #notificationsBody2 span{
        font-size: 12px;
        /*font-weight: bold;*/
      }

      #notificationFooter
      {
      background-color: #e9eaed;
      text-align: center;
      font-weight: bold;
      padding: 8px;
      font-size: 12px;
      border-top: 1px solid #dddddd;
      }



    #notification_count 
    {
    padding: 3px 7px 3px 7px;
    background: #cc0000;
    color: #ffffff;
    font-weight: bold;
    margin-left: 77px;
    border-radius: 9px;
    -moz-border-radius: 9px; 
    -webkit-border-radius: 9px;
    position: absolute;
    margin-top: -11px;
    font-size: 11px;
    }

    #notificationsBody .avatar img{
       border-radius: 50%;
       width: 50px;
       height: 50px;
    }
    #notificationsBody .message-sender .sender-name{
      margin-bottom: 3px;
    }
    #notificationsBody .conversation{
      cursor: pointer;
      padding-top: 5px;
      padding-bottom: 5px;
      border-bottom: 1px solid #dddddd;
    }
    #notificationsBody .conversation:hover{
      background-image: linear-gradient(rgba(29, 33, 41, .04), rgba(29, 33, 41, .04));
    }
    #notificationsBody .container{
      max-height: 300px;
      overflow-y: scroll;
    }


    #notificationsBody2 .avatar img{
       border-radius: 50%;
       width: 50px;
       height: 50px;
    }
    #notificationsBody2 .message-sender .sender-name{
      margin-bottom: 3px;
    }
    #notificationsBody2 .conversation{
      height: 80px;
      cursor: pointer;
      padding-top: 5px;
      padding-bottom: 5px;
      border-bottom: 2px solid #F0F0F0 ;
    }
    #notificationsBody2 .conversation:hover{
      background-image: linear-gradient(rgba(29, 33, 41, .04), rgba(29, 33, 41, .04));
    }
    #notificationsBody2 .container{
      max-height: 300px;
      overflow-y: scroll;
    }

    span.new-message-num.notification{
      right: -11px;
      top: -8px;
    }

    #notificationsBody  .small-loader{
      width: 30px;
      height: 30px;
      /*display: none;*/
    }

    .follow-loader{
      width:20px;
      margin-left: 13px;
      display: none;
    }

    .post-time-display{
      font-size: 12px;
      font-weight: bold;
      font-style: italic;
      color: #707070;
    }
        
</style>
<link href="<?php echo base_url('assets/css/treeflex.css') ?>" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/css/perfect-scrollbar.css') ?>">

<link href="<?php echo base_url('assets/css/material-dashboard.min.css?v=2.0.2') ?>" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url('assets/css/bs-pagination.min.css');?>">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/emojify.js/1.1.0/css/basic/emojify.min.css" />



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo base_url('assets/js/jquery.fine-uploader.js'); ?>"></script>
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/styles.css') ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/fileinput.css') ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/datejs/1.0/date.min.js" integrity="sha512-/n/dTQBO8lHzqqgAQvy0ukBQ0qLmGzxKhn8xKrz4cn7XJkZzy+fAtzjnOQd5w55h4k1kUC+8oIe6WmrGUYwODA==" crossorigin="anonymous"></script>
<script>
  
  function seeAll (elem,evt) {
    evt.preventDefault();
    document.location.assign("<?php echo site_url('allenexpress/index/messages'); ?>");
  }

   function notificationLinkClick2(elem,evt)
  {
    evt.preventDefault();
    if($(window).width() >= 500){
      if($("#notificationContainer2").hasClass("hide")){ 
        if(!$("#notificationContainer").hasClass("hide")){
          addClass(document.querySelector("#notificationContainer"),"hide")
        }       
        removeClass(document.querySelector("#notificationContainer2"),"hide");
      }else{
        addClass(document.querySelector("#notificationContainer2"),"hide");
      }
      $("#notification_count").fadeOut("slow");
    }else{
       document.location.assign("<?php echo site_url('allenexpress/index/messages'); ?>");
    }
    // return false;
  }

  function notificationLinkClick(elem,evt)
  {
    evt.preventDefault();
    if($(window).width() >= 500){
      if($("#notificationContainer").hasClass("hide")){
        if(!$("#notificationContainer2").hasClass("hide")){
          addClass(document.querySelector("#notificationContainer2"),"hide")
        }
        removeClass(document.querySelector("#notificationContainer"),"hide");
      }else{
        addClass(document.querySelector("#notificationContainer"),"hide");
      }
      
      $("#notification_count").fadeOut("slow");
    }else{
       document.location.assign("<?php echo site_url('allenexpress/index/messages'); ?>");
    }
    // return false;
  }
  $(document).ready(function () {
    // $("#notificationsBody .container").perfectScrollbar();


      //Document Click hiding the popup 
      $(document).click(function()
      {
        // $("#notificationContainer").hide();
      });

      //Popup on click
      $("#notificationContainer").click(function()
      {
        return false;
      });

      $("#notificationContainer2").click(function()
      {
        return false;
      });

    var requeue = function() {
      setTimeout(login, 10000);
    };

    function login () {
      // body... 
      $.ajax({
        url : "<?php echo site_url('allenexpress/userlogin'); ?>",
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : "login=true",
        success: function (response) {
          // console.log(response)
          if(response.success == true && response.online_users_html !== "" && response.total_online_users !== ""){
            var online_users_html = response.online_users_html;
            var total_online_users = response.total_online_users;
            $("#online-users-num").html("("+total_online_users+")");
            $("#online-users").html(online_users_html);
            requeue();
          }else{
            alert("Error")
          }
        },
        error : function () {
          clearTimeout(login);
        }
      });  

    }
    setTimeout(login, 10000);

    $("#myInput").keyup(function (e) {
      var search_val = $(this).val().toLowerCase();
      
      if(search_val !== ""){
        var get_tests_url = "<?php echo site_url('allenexpress/index/cl_admin/get_all_names'); ?>";
        $.ajax({
          url : get_tests_url,
          type : "POST",
          responseType : "json",
          dataType : "json",
          data : "get_all_names=true&search_val="+search_val,
          success : function (response) {                     
            $(".spinner-overlay").hide();
            // console.log(response);
            if(response.error == true){

            }else if(response.success == true){
              autocomplete1(document.getElementById("myInput"),Object.values(response.array),search_val);
            }
            
          },
          error : function () {
          $(".spinner-overlay").hide();
          }  
        });
      }else{
        $("#myInputautocomplete-list").hide();
      }
    });


  })
  
  var getDataUrl = function (img) {
  var canvas = document.createElement('canvas')
  var ctx = canvas.getContext('2d')

  canvas.width = img.width
  canvas.height = img.height
  ctx.drawImage(img, 0, 0)

  // If the image is not png, the format
  // must be specified here
  return canvas.toDataURL()
}
// console.log(getDataUrl("http://localhost/allenexpress/assets/images/avatar.jpg"))
var str = "data-ioioo";
var substr = str.substring(0,4);
console.log(substr);
  function showReferralCode(elem,evt) {
    <?php
      $user_slug = $this->allenexpress_model->getUserParamById("slug",$user_id);
    ?>
    evt.preventDefault();
    swal({
      title: 'Referral Link',
      text: "Your Referral Link Is <span class='text-primary' style='font-style: italic;'>https://allenexpressresources.com/login_page?id=<?php echo $user_slug; ?></span>",
      type: 'success'
    })
  }

  function upgradeToBusiness(elem,evt) {
    elem = $(elem);
    evt.preventDefault();
    
    var id = <?php echo $this->allenexpress_model->getUsersFirstMlmDbId($user_id); ?>;

    swal({
      title: 'Note!',
      text: "Are You Sure You Want To Upgrade Your Package For This Account To Business? <p><em class='text-primary'>Note You'll Pay A Sum Of ₦6,500 To Fully Upgrade This Account.</em></p>",
      type: 'info',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText : "No"
    }).then(function(){
      $(".spinner-overlay").show();
      var form_data = {
        mlm_db_id : id
      }
      var url = "<?php echo site_url('allenexpress/upgrade_mlm_account_to_business'); ?>"
      $.ajax({
        url : url,
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : form_data,
        success : function (response) {
          $(".spinner-overlay").hide();
          if(response.success && response.url != ""){

            var url = response.url;
            swal({
              title: 'Choose Payment Method: ',
              text: "Do You Want To Pay Through: ",
              type: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#4caf50',
              confirmButtonText: 'Online Payment',
              cancelButtonText : "Your allenexpress Account"
            }).then(function(){
              $.notify({
              message:"Redirecting To Secure Payment Page...."
              },{
                type : "success"  
              });
              setTimeout(function () {
                window.location.assign(url)
              }, 2000);
            },function(dismiss){
              if(dismiss == 'cancel'){
                $(".spinner-overlay").show();
                var form_data = {
                  mlm_db_id : id
                }
                var url = "<?php echo site_url('allenexpress/upgrade_mlm_account_to_business_through_allenexpress_account'); ?>"
                $.ajax({
                  url : url,
                  type : "POST",
                  responseType : "json",
                  dataType : "json",
                  data : form_data,
                  success : function (response) {
                    $(".spinner-overlay").hide();
                    if(response.success && response.date != "" && response.time != ""){
                      $.notify({
                      message:"Your Basic Package Account Has Been Successfully Upgraded To Business."
                      },{
                        type : "success"  
                      });
                      $("#add-new-basic-account-btn").show("fast");
                      var date = response.date;
                      var time = response.time;

                      elem.parent().parent().find(".package").html("Business");
                      elem.parent().parent().find(".date").html(date);
                      elem.parent().parent().find(".time").html(time);
                      elem.remove();
                      swal({
                        title: 'Success!',
                        text: "Your Account Has Been Successfully Upgraded To Business",
                        type: 'success'
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
                      text: "Something Went Wrong",
                      type: 'error'
                    })
                  } 
                });  
              }
            })
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
    });
  }

</script>
</head>

<body id="body">
  <div id="sound" style="visibility: hidden;"></div>
  <div class="wrapper ">
    <div class="sidebar" data-color="orange" data-background-color="black" data-image="<?php  echo base_url('assets/images/sidebar-img.jpeg'); ?>">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->

    <div class="sidebar-wrapper">
        
        <div class="user">
            <div class="photo">
              
                <img src="<?php echo base_url('assets/images/avatar.jpg') ?>" class="small-profile-img" />
            </div>
            <div class="user-info">
                <a data-toggle="collapse" href="#collapseExample" class="username">
                    <span style="text-transform: capitalize;">
                       <?php echo $user_name; ?> 
                      <b class="caret"></b>
                    </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        
                        

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo site_url('allenexpress/change_password'); ?>">
                              <span class="sidebar-mini"> CP </span>
                              <span class="sidebar-normal"> Change Admin Password </span>
                            </a>
                        </li>

                          
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">

            <li class="nav-item active ">
                <a class="nav-link" href="<?php echo site_url('allenexpress/admin') ?>">
                    <i class="material-icons">home</i>
                    <p> Home </p>
                </a>
            </li>
            
        </ul>
        

        
    </div>
</div>
<div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="#pablo">Dashboard</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form" action="<?php echo site_url('allenexpress/index/search/top') ?>" id="main-search-form">
              <div class="input-group no-border">
                
                <div class="autocomplete">
                  <input type="text" value="<?php if($this->uri->segment(3,0) == "search" && $this->uri->segment(4,0) == "top"){ echo urldecode($this->uri->segment(6)); } ?>" class="form-control" placeholder="Search..." autocomplete="off" id="myInput" name="my-input">
                </div>
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
               
            
            <ul class="navbar-nav">
              
              <li id="noti_Container">
                  <li id="notification_li">
                    <a href="#" id="notificationLink" onclick="return notificationLinkClick(this,event)" style="color: unset;"><i class="fab fa-facebook-messenger" style="font-size: 25px; margin: 20px;">
                   <?php
                   if($this->allenexpress_model->getNewMessagesCount($user_id) > 0){?><span class="new-message-num notification"><?php echo $this->allenexpress_model->getNewMessagesCount($user_id); ?></span><?php } 
                   ?></i></a>
                      <div id="notificationContainer" class="hide">
                      <div id="notificationTitle">Recent</div>
                      <div id="notificationsBody" class="notifications">
                        <div class="container">
                          <?php
                            $all_notifs = $this->allenexpress_model->getConversations($user_id);
                            if(is_array($all_notifs)){
                              foreach($all_notifs as $row){
                                $receiver = $row['receiver'];
                                $sender = $row['sender'];
                                $last_message_id = $row['id'];
                                $received = $row['received'];
                                $date_time = $row['date_time'];
                                $date_time = new DateTime($date_time);
                                $date = $date_time->format('j M Y');
                                $time = $date_time->format('h:i:sa');
                                $post_date = $this->allenexpress_model->getSocialMediaTime($date,$time);
                                $message = $row['message'];
                                if($sender == $user_id){
                                  $partner = $receiver;
                                }elseif ($receiver == $user_id) {
                                  $partner = $sender;
                                }else{
                                  $partner = "";
                                }
                                if($partner !== ""){
                          ?>
                          <div class="conversation row" onclick="register_popup(<?php echo $sender; ?>, '<?php echo $this->allenexpress_model->getUserNameById($sender); ?>','<?php echo site_url('allenexpress/index/get_messages') ?>','<?php echo site_url('allenexpress/index/get_status') ?>','<?php echo base_url('assets/audio/notif-sound.mp3') ?>','<?php echo site_url('allenexpress/index/send_message') ?>','<?php echo site_url('allenexpress/index/get_last_chats') ?>','<?php echo site_url('allenexpress/index/'.$user_id.'/messaging') ?>','<?php echo base_url('assets/images/small-loader.gif'); ?>','<?php echo base_url('assets/images/small-loader.gif'); ?>')">
                            <div class="col-sm-2 avatar">
                              <img src="<?php echo $this->allenexpress_model->getUserLogoById($sender); ?>" alt="<?php echo $this->allenexpress_model->getUserNameById($sender); ?>">
                            </div>
                            <div class="col-sm-6 message-sender">
                              <p class="sender-name"><?php echo $this->allenexpress_model->getUserNameById($sender); ?> &nbsp;
                              <?php
                                echo $this->allenexpress_model->getNumberOfNewMessagesFromSender($user_id,$sender);
                              ?>
                              </p>
                              <span class="last-message"><?php echo $this->allenexpress_model->custom_echo($message,30); ?></span>
                            </div>
                            <div class="col-sm-4 time-stamp">
                              <span>
                                <?php echo $post_date; ?>
                              </span>
                            </div>
                          </div>
                          <?php } } }else{
                            echo "<p class='text-danger'>You Do Have Not Sent Or Received Any Messages. Please Go To A Users Profile To Send A Message</p>";
                          } ?>
                        </div>
                        <div class="text-center">
                          <img src="<?php echo base_url('assets/images/small-loader.gif'); ?>" class="small-loader hide" alt="">
                        </div>
                      </div>

                      <div id="notificationFooter"><a href="#" onclick="seeAll(this,event)">See All(<?php echo $this->allenexpress_model->getConversationsNum($user_id); ?>)</a></div>
                      </div>

                  </li>

              </li>

              <li id="noti_Container2">
                  <li id="notification_li2">
                    <a href="#" id="notificationLink2" onclick="return notificationLinkClick2(this,event)" style="color: unset;"><i class="material-icons">notifications</i>
                   <?php
                   $noti_count = $this->allenexpress_model->getNotifCount($user_id);
                   if($noti_count > 99){
                    $noti_count = "99+";
                   }

                   if($this->allenexpress_model->getNotifCount($user_id) > 0){?><span class="new-message-num notification"><?php echo $noti_count; ?></span><?php } 
                   ?></i></a>
                      <div id="notificationContainer2" class="hide">
                      <div id="notificationTitle2">Notifications</div>
                      <div id="notificationsBody2" class="notifications">
                        <div class="container">
                          <?php
                          $all_notifs = $this->allenexpress_model->getNotifs($user_id);
                            if(is_array($all_notifs)){
                              foreach($all_notifs as $row){
                                $id = $row->id;
                                $sender_id = $row->sender;
                                $sender = $this->allenexpress_model->getUserNameById($sender_id);
                                $notif_id = $row->id;
                                $post_id = $row->post_id;
                                $notif_title = $row->title;
                                $received = $row->received;
                                $date_sent = $row->date_sent;
                                $time_sent = $row->time_sent;
                                $received = $row->received;
                                $type = $row->type;
                                $site_url = site_url('allenexpress/index');
                                if($type == "follow"){
                                  $site_url .= "/".$sender;
                                }else if($type == "post"){
                                  $slug = $this->allenexpress_model->getPostSlugById($post_id);
                                  $site_url .= "/post/".$post_id.'/'.$slug;
                                }else if($type == "comment"){
                                  $slug = $this->allenexpress_model->getPostSlugById($post_id);
                                  $site_url .= "/post/".$post_id.'/'.$slug;
                                }else if($type == "like"){
                                  $slug = $this->allenexpress_model->getPostSlugById($post_id);
                                  $site_url .= "/post/".$post_id.'/'.$slug;
                                }else if($type == "mini_importation"){
                                  $slug = $this->allenexpress_model->getPostSlugById($post_id);
                                  $site_url .= "/mini_importation";
                                }else if($type == "misc"){
                                  $slug = $this->allenexpress_model->getPostSlugById($post_id);
                                  $site_url .= "/notification/".$id;
                                }

                                $site_url = site_url("allenexpress/mark_notif_as_read?callback_url=".$site_url."&id=".$id);
                          ?>
                          <div class="conversation row" <?php if($received == 0){ echo "style='background-color: #D0D0D0;'"; } ?> onclick="window.location.assign('<?php echo $site_url; ?>');">
                            <div class="col-sm-2 avatar">
                              <img src="<?php echo $this->allenexpress_model->getUserLogoById($sender_id); ?>" alt="<?php echo $this->allenexpress_model->getUserNameById($sender); ?>">
                            </div>
                            <div class="col-sm-6 message-sender">
                              <p class="sender-name"><?php echo $sender; ?> &nbsp;
                              <?php
                                echo $this->allenexpress_model->getNumberOfNewMessagesFromSender($user_id,$sender);
                              ?>
                              </p>
                              <span class="last-message"><?php echo $this->allenexpress_model->custom_echo($notif_title,80); ?></span>
                            </div>
                            <div class="col-sm-4 time-stamp">
                              <span>
                                <?php echo $this->allenexpress_model->getSocialMediaTime($date_sent,$time_sent); ?>
                              </span>
                            </div>
                          </div>
                          <?php } }else{
                            echo "<p class='text-danger'>You Do Have Any Notifications</p>";
                          } ?>
                        </div>
                        <div class="text-center">
                          <img src="<?php echo base_url('assets/images/small-loader.gif'); ?>" class="small-loader hide" alt="">
                        </div>
                      </div>

                      <div id="notificationFooter"><a href="#" onclick="seeAll(this,event)">See All(<?php echo $this->allenexpress_model->getNotifsNum($user_id); ?>)</a></div>
                      </div>

                  </li>

              </li>

              <li class="nav-item" data-toggle="tooltip" title="Logout">
                <a class="nav-link" href="<?php echo site_url('allenexpress/index/logout') ?>">
                  <i class="fas fa-sign-out-alt" style="font-size: 15px;"></i>
                  <p class="d-lg-none d-md-block">
                    Logout
                  </p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>