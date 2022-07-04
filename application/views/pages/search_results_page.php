<script>
  function followUser (elem,user_id,type = true) {
     $(".spinner-overlay").show();
      $.ajax({
        url : "<?php echo site_url('meetglobal/follow') ?>",
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : "user_id="+user_id,
        success : function(response){
          $(".spinner-overlay").hide();
          if(response.success == true){
            
            elem.setAttribute("onclick","unfollowUser(this,"+user_id+")");
            elem.innerHTML = 'Following';
            if(type == true){
              var temp_followers = Number($(".followers_temp").html());
              var new_followes_num = temp_followers + 1;
              $(".followers_temp").html(new_followes_num);
              var new_followes_num = socialMediaFormatNum(new_followes_num);
              $(".follower-num").html(new_followes_num);
            }
          }else{
            $.notify({
            message:"Sorry Something Went Wrong."
            },{
              type : "warning"  
            });
          }
        },
        error: function () {
          $(".spinner-overlay").hide();
          $.notify({
          message:"Sorry Something Went Wrong. Please Check Your Internet Connection"
          },{
            type : "danger"  
          });
        }
      });
    }

    function unfollowUser (elem,user_id,type) {
        $(".spinner-overlay").show();
        $.ajax({
          url : "<?php echo site_url('meetglobal/unfollow') ?>",
          type : "POST",
          responseType : "json",
          dataType : "json",
          data : "user_id="+user_id,
          success : function(response){
            console.log(response)
            $(".spinner-overlay").hide();
            if(response.success == true){
             
              elem.setAttribute("onclick","followUser(this,"+user_id+")")
              elem.innerHTML = 'Follow';
              if(type == true){
                var temp_followers = Number($(".followers_temp").html());
                var new_followes_num = temp_followers - 1;
                $(".followers_temp").html(new_followes_num);
                var new_followes_num = socialMediaFormatNum(new_followes_num);
                if(new_followes_num == 0){ new_followes_num = "no followers"; }
                $(".follower-num").html(new_followes_num);
              }
            }else{
              $.notify({
              message:"Sorry Something Went Wrong."
              },{
                type : "warning"  
              });
            }
          },
          error: function () {
            $(".spinner-overlay").hide();
            $.notify({
            message:"Sorry Something Went Wrong. Please Check Your Internet Connection"
            },{
              type : "danger"  
            });
          }
        });
    }

  function registerPatient (elem) {
      var facility_table_name = String(elem.getAttribute("data-hospital-name1"));
      var hospital_name = String(elem.getAttribute("data-hospital-name"));
      var hospital_id = elem.getAttribute("data-hosid");
      var url = "<?php echo site_url('meetglobal/index/register_patient'); ?>";
      var data = "table_name="+facility_table_name+"&facility_name="+hospital_name;
       var str = "#"+hospital_id+"-count";
      $.ajax({
        url : url,
        type : "POST",
        responseType : "text",
        dataType : "text",
        data : data,
        success : function(response){
          if(response == "values_messed"){
            $.notify({
            message:"Sorry Something Went Wrong"
            },{
              type : "warning"  
            });
          }else if(response == "could not register patient"){
           $.notify({
            message:"Sorry You Could Not Be Registered"
            },{
              type : "warning"  
            });
          }else if(response == "already_registered"){
           $.notify({
            message:"Sorry You've Already Registered On This Facility"
            },{
              type : "warning"  
            });
          }else if(response == "successful"){
            
           elem.classList.remove("btn-primary");
           elem.classList.add("btn-danger");
           
           elem.setAttribute("onclick","unRegisterPatient(this)");
           // var old_num =  document.getElementById(str).innerHTML;
           // var new_num = Number(old_num) + 1;
           // document.getElementById(str).innerHTML = new_num;
           elem.querySelector("i").setAttribute("class","fas fa-user-minus font-awesome")
          }
        },
        error: function () {
           $.notify({
            message:"Sorry You Could Not Be Registered"
            },{
              type : "danger"  
            });
        }
      })
    }

    function unRegisterPatient (elem) {
      var facility_table_name = String(elem.getAttribute("data-hospital-name1"));
      var hospital_name = String(elem.getAttribute("data-hospital-name"));
      var hospital_id = elem.getAttribute("data-hosid");
      var url = "<?php echo site_url('meetglobal/index/unregister_patient'); ?>";
      var data = "table_name="+facility_table_name+"&facility_name="+hospital_name;
       var str = "#"+hospital_id+"-count";
      $.ajax({
        url : url,
        type : "POST",
        responseType : "text",
        dataType : "text",
        data : data,
        success : function(response){
          if(response == "values_messed"){
            $.notify({
            message:"Sorry Something Went Wrong"
            },{
              type : "warning"  
            });
          }else if(response == "could not register patient"){
           $.notify({
            message:"Sorry You Could Not Be Registered"
            },{
              type : "warning"  
            });
          }else if(response == "already_registered"){
           $.notify({
            message:"Sorry You've Not Registered On This Facility"
            },{
              type : "warning"  
            });
          }else if(response == "successful"){
            
           elem.classList.remove("btn-danger");
           elem.classList.add("btn-primary");
           
           elem.setAttribute("onclick","unRegisterPatient(this)");
           // var old_num =  document.getElementById(str).innerHTML;
           // var new_num = Number(old_num) + 1;
           // document.getElementById(str).innerHTML = new_num;
           elem.querySelector("i").setAttribute("class","fas fa-user-plus font-awesome");
          }
        },
        error: function () {
           $.notify({
            message:"Sorry You Could Not Be Registered"
            },{
              type : "danger"  
            });
        }
      })
    }
</script>

<div class="spinner-overlay" style="display: none;">
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading...">
        </div>
      </div>
      <!-- End Navbar -->
      <div class="content">
        <span id="search-val-con" style="display: none;"><?php echo $search_val; ?></span>
        <div class="container-fluid">
          <h2 class="text-center">Search Results For '<?php echo urldecode($search_val); ?>': </h2>
          <div class="row">
            <div class="col-sm-10">
              <div class="card">

                <div class="card-header card-header-tabs card-header-warning">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <h4 class="nav-tabs-title"></h4>
                      <ul class="nav nav-tabs" data-tabs="tabs">
                        
                        <li class="nav-item">
                          <a href="#users" id="users-link" class="nav-link" data-toggle="tab">
                            <i class="fas fa-users" style="font-size: 20px;"></i>
                            Users
                            <div class="ripple-container"></div>
                          </a>
                        </li>
                        
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="tab-content">                
                    <div class="tab-pane" id="users" style="display: block;">
                      <?php
                      $first_users = $this->meetglobal_model->getFirstUsers($search_val);
                      if(is_array($first_users)){
                        $i = 0;
                              
                      ?>
                      <h3 class="text-center">Users</h3>
                      <div class="table-responsive">
                        <table class="table table-test table-striped table-bordered nowrap hover display" id="full-user-results-table" cellspacing="0" width="100%" style="width:100%">
                          <thead style="display: none;">
                            <tr>
                              <th>#</th>
                              <th>Profile Picture</th>
                              <th>Name</th>
                              <th>Full Name</th>
                              <th>Follow</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              foreach($first_users as $user){
                                $i++;
                                  $partner_id = $user->id;
                                  $user_name = $user->user_name;
                                  $email = $user->email;
                                  $phone = $user->phone;
                                  $followers = $user->followers;
                                  $address = $user->address;
                                  $user_slug = $user->slug;
                                  $date = $user->date;
                                  $time = $user->time;
                                  $logo = $user->logo;
                                  $full_name = $user->full_name;
                                  
                                  $is_admin = $user->is_admin;
                                  
                                  if(is_null($logo)){
                                    $logo = "avatar.jpg";
                                  }
                            ?>
                              <tr>
                                <td><?php echo $i; ?>.</td>
                                <td><img src="<?php echo base_url('assets/images/'.$logo); ?>" alt="" width="30" class='img-round'></td>
                                <td><a href="<?php echo site_url('meetglobal/index/'.$user_name) ?>" id="edit-test-card-link" class="text-primary list-group-item list-group-item-action"><?php echo $this->meetglobal_model->custom_echo($user_name,35); ?></a></td>

                                <td><?php echo $this->meetglobal_model->custom_echo($full_name,50); ?></a></td>
                                
                                <td>
                                  <?php
                                   if($this->meetglobal_model->checkIfUserIsFollowingUser($user_id,$partner_id)){ ?>
                                  <button class="btn btn-rose btn-round justify-content-center" onclick="followUser(this,<?php echo $partner_id; ?>,false)">Follow </button>
                                  <?php }else{ ?>
                                    <button class="btn btn-rose btn-round justify-content-center" onclick="unfollowUser(this,<?php echo $partner_id; ?>,false)">Following </button>
                                  <?php } ?>
                                </td>
                              </tr>
                            
                            <?php    
                              
                            }
                           ?>
                          </tbody>
                         
                        </table>
                      </div>
                      <?php
                       }else{
                        echo "<h3 class='text-warning'>Your Search Doesn't Match With Any Results</h3>";
                       }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          
        </div>
      </footer>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      var user_result_table = $("#full-user-results-table").DataTable();

       $("#users-link").click(function () {
        var url = "<?php echo site_url('meetglobal/index/get_users_tab') ?>";
        var search_val = $("#search-val-con").html();
        $(".spinner-overlay").show();
        $.ajax({
          url : url,
          type : "POST",
          responseType : "text",
          dataType : "text",
          data : "get_users_tab=true&search_val="+search_val,
          // data : {
          //   "get_health_facility_tab" : true,
          //   "search_val" : search_val,
          //   "offset" : 0
          // },
          success : function(response){
            $(".spinner-overlay").hide();
            if(response !== ""){
              $("#users").html(response);
              $("#full-user-results-table").DataTable();
            }else{
              var response = "<h3 class='text-warning'>Your Search Doesn't Match With Any Results</h3>";
              $("#users").html(response);
            }  
          },
          error : function () {
            $(".spinner-overlay").hide();
            var response = "<h3 class='text-warning'>Unable To Connect. Please Check Your Connection.</h3>";
            $("#users").html(response);
          }
        }); 
      });
    });     

  </script>