         <!-- End Navbar -->
      <style>
        tr{
          cursor: pointer;
        }
      </style>
      <script>
        function submitSelectedEmails(elem,evt){
          var emails = [];
          var trs = $("#all-users-card table tbody tr");
          var subject = document.querySelector("#email-title").value;
          var message = document.querySelector("#email-content").value;
          var checkedNum = $("#all-users-card table tbody tr input:checked").length;
          if(checkedNum >= 1){
            trs.each(function(index, el) {
              var checkBox = el.querySelector("input");
              var isChecked = checkBox.checked;
              var email = el.getAttribute("data-email");
              if(isChecked){
                emails.push(email);
              }          
            });
            $(".spinner-overlay").show();
            var url = "<?php echo site_url('sabicapital/admin_send_email') ?>";
            // console.log(form_data);
            $.ajax({
              type : "POST",
              dataType : "json",
              responseType : "json",
              url : url,
              data : {
                users : emails,
                subject : subject,
                message : message
              },
              success : function (response) {
                $(".spinner-overlay").hide();
                if(response.success == true){
                  swal({
                    title: 'Success',
                    text: "Email Sent To " + checkedNum + " Users Successfully",
                    type: 'success'
                  }).then(function(){
                    document.location.reload();
                  });
                }
              },error : function(){
                $(".spinner-overlay").hide();
                $.notify({
                  message:"Something Went Wrong And Email Could Not Be Sent Successfully. Please Check Your Internet Connection"
                },{
                    type : "danger"  
                });
              } 
            });   
          }else{
            swal({
              title: 'Error!',
              text: "Sorry At Least One User Must Be Selected",
              type: 'error'                     
            })
          }
        }

        function checkBoxByTrClick(elem,evt){
          
          var checkBox = elem.querySelector('input');
          var isChecked = checkBox.checked;
          if(isChecked){
            checkBox.checked = false;
          }else{
           checkBox.checked = true; 
          }
        }

        function submitSendEmail(elem,evt,status){
          evt.preventDefault();
          console.log(status);

          if(status == true){
            var title = elem.querySelector("#email-title").value;
            var message = elem.querySelector("#email-content").value;
            swal({
              title: 'Choose Action',
              text: "Do You Want To Send This Email To All Users ?",
              type: 'success',
              showCancelButton: true,
              confirmButtonColor: '#9124a36',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes',
              cancelButtonText : "No"         
            }).then(function(){
             // function when confirm button clicked
              $(".spinner-overlay").show();
              var url = "<?php echo site_url('sabicapital/admin_send_email') ?>";
              // console.log(form_data);
              $.ajax({
                type : "POST",
                dataType : "json",
                responseType : "json",
                url : url,
                data : "users=all&subject="+title+"&message="+message,
                success : function (response) {
                  $(".spinner-overlay").hide();
                  console.log(response);
                  if(response.success == true && response.users_num !== ""){
                    var users_num = response.users_num;
                    swal({
                      title: 'Success',
                      text: "Email Sent To All <span class='text-primary' style='font-style: italic;'>" + users_num + "</span> users successfully",
                      type: 'success'
                    }).then(function(){
                      document.location.reload();
                    });
                  }else{
                    $.notify({
                      message:"Something Went Wrong And Email Could Not Be Sent Successfully"
                    },{
                        type : "warning"  
                    });
                  }
                },error : function(){
                  $(".spinner-overlay").hide();
                  $.notify({
                    message:"Something Went Wrong And Email Could Not Be Sent Successfully. Please Check Your Internet Connection"
                  },{
                      type : "danger"  
                  });
                }
              });    
            }, function(dismiss){
             if(dismiss == 'cancel'){
                console.log("cancelled")
                $(".spinner-overlay").show();
                var url = "<?php echo site_url('sabicapital/get_all_users_json') ?>";
                // console.log(form_data);
                $.ajax({
                  type : "POST",
                  dataType : "json",
                  responseType : "json",
                  url : url,
                  data : "get_users=true",
                  success : function (response) {
                    console.log(response)
                    $(".spinner-overlay").hide();
                    if(response.success == true){
                      var users_json = response.users_json;
                      // console.log(users_json);
                      var tbody_content = "";
                      for(var i = 0; i < users_json.length; i++){
                        var full_name = users_json[i].full_name;
                        var user_name = users_json[i].user_name;
                        var email = users_json[i].email;
                        var row = '<tr data-email="' + email + '" onclick="checkBoxByTrClick(this,event)">'+ '<td>'+i+'</td>' + '<td><div class="form-check text-right"><label class="form-check-label"><input class="form-check-input" type="checkbox" value=""><span class="form-check-sign"><span class="check"></span></span></label></div></td>'+'<td>'+full_name+'</td>'+'<td>'+user_name+'</td>'+'<td>'+email+'</td>'+'</tr>';
                        tbody_content += row;
                      }
                      $("#email-content-card").hide();
                      $("#all-users-card table tbody").append(tbody_content);
                      $("#all-users-card").show();
                      $("#send-email").show();
                    }
                  },error : function(){
                    $(".spinner-overlay").hide();
                    $.notify({
                      message:"Something Went Wrong. Please Check Your Internet Connection"
                    },{
                        type : "danger"  
                    });
                  } 
                });   

                

              }
            });  
          }else{
            console.log("not confirmed");
          }
        }
      </script>
      <div class="spinner-overlay" style="display: none;">
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading...">
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <h2 class="text-center">Send Email</h2>
          <div class="row justify-content-center">
            <div class="col-sm-10">
              <div class="card" id="email-content-card">
                <div class="card-header">
                  <h4 class="card-title">Enter Email Content</h4>                 
                </div>
                <div class="card-body">
                  <?php
                    $attr = array('id' => 'sendEmailForm','onsubmit' => 'submitSendEmail(this,event,false)');
                    echo form_open('sabicapital/submit_send_email',$attr);
                  ?>
                    <div class="form-group">
                      <label for="email-title">Enter Email Title: </label>
                      <input type="text" name="email-title" id="email-title" class="form-control" required>
                    </div>

                    <div class="form-group">
                      <label for="email-content">Enter Email Content: </label>
                      <textarea id="email-content" rows="10" name="email-content" class="form-control" required>
                        
                      </textarea>
                    </div>
                    <input type="submit" class="btn btn-primary">
                  </form>
                </div>
              </div>
              <div class="card" id="all-users-card" style="display: none;">
                <div class="card-header">
                  <h2 class="card-title">Select Users</h2>
                </div>
                <div class="card-body">
                    <table class="table table-responsive-sm dt-responsive nowrap hover display" id="" cellspacing="0" width="100%" style="width:100%">
                      <thead style="display: none;">
                        <tr>
                          <th>#</th>
                          <th>CheckBox</th>
                          <th>Full Name</th>
                          <th>UserName</th>
                          <th>Email</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                      </tbody>
                    </table>  
                </div>
              </div>
            </div>
          </div>


          <div rel="tooltip" data-toggle="tooltip" title="Send Email" id="send-email" onclick="submitSelectedEmails(this,event)" style="display: none; cursor: pointer; position: fixed; bottom: 0; right: 0; background: #9124a3; border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
            <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
              <i class='fas fa-paper-plane' style="font-size: 25px; font-weight: normal; color: #fff;" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <!-- <footer>&copy; <?php echo date("Y"); ?> Copyright (sabicapital Issues Global Limited). All Rights Reserved</footer> -->
        </div>
      </footer>
      
      <script>
        $(document).ready(function () {
          // $("table").DataTable();
          $("#email-content").html("");

          $("#email-title").keydown(function(event) {
            var keyPressed = event.keyCode || event.which;
            var email_title = $(this).val();
            var email_title_length = email_title.length;
            console.log(keyPressed)
            // if(keyPressed !== 13){
              if(keyPressed !== 8 && keyPressed !== 9){
                if(email_title_length <= 50){
                  $("#sendEmailForm").attr('onsubmit', 'submitSendEmail(this,event,true)');
                }else{
                  $("#sendEmailForm").attr('onsubmit', 'submitSendEmail(this,event,false)');
                  swal({
                    title: 'Error',
                    html: "This Field Cannot Exceed 50 Characters",
                    type: 'error'
                  })
                }
              }
            // }

          });


          $("#submit-settings").click(function(event) {
            swal({
                title: 'Choose Action',
                html: "Are You Sure You Want To Proceed?",
                type: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText : "No"
            }).then(function(){
              var form_data = {};
              var checkedState = false;
              var name = '';

              $(".settings-table").each(function(index, el) {
                // console.log($(this).find('tbody tr').length)
                $(this).find('tbody tr input').each(function(index, el) {
                  if($(this).is(':checked')){
                    checkedState = true;
                  }else{
                    checkedState = false;
                  }
                  name = $(this).attr('name');
                  form_data[name] = checkedState;
                });
              });
              console.log(form_data);
              var url = "<?php echo site_url('sabicapital/save_settings') ?>";
              // console.log(form_data);
              $.ajax({
                type : "POST",
                dataType : "json",
                responseType : "json",
                url : url,
                data : form_data,
                success : function (response) {
                  console.log(response);
                  if(response.success == true){
                    $.notify({
                      message:"Settings Changed Successfully"
                    },{
                        type : "success"  
                    });
                  }else{
                    $.notify({
                      message:"Something Went Wrong"
                    },{
                        type : "warning"  
                    });
                  }
                },error : function(){
                  $.notify({
                      message:"Something Went Wrong Check Your Internet Connection"
                    },{
                        type : "danger"  
                    });
                }
              }); 
            });
          });


          $("#change-password-from").submit(function (evt) {
            evt.preventDefault();
            var form_data = $(this).serializeArray();
            form_data.push({
              'name' : 'change_password',
              'value' : 'true'
            });
            var url = "<?php echo site_url('sabicapital/process_change_password') ?>";
            // console.log(form_data);
            $.ajax({
              type : "POST",
              dataType : "json",
              responseType : "json",
              url : url,
              data : form_data,
              success : function (response) {
                if(response.success == true){
                  window.location.assign("<?php echo site_url('sabicapital/') ?>");
                }else if(response.wrong_password == true){
                  $.notify({
                    message:"Wrong Password Inputed. Please Try Again"
                  },{
                    type : "warning"  
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
                $.notify({
                message:"Sorry Something Went Wrong"
                },{
                  type : "danger"  
                });
              } 
            });   
          })
        })
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 