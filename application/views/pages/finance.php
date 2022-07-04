
<style>
  img{
    width: 100%;
    height: 350px;
  }

  
  #edit-profile-form{
    margin-top: 30px;
    margin-bottom: 30px;
  }

  #edit-profile-form label{
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

  function editPaymentDetails (elem,evt) {
    evt.preventDefault();
    var form_data = {
      "show_records": true
    }
    var url = "<?php echo site_url('sabicapital/get_edit_payment_details_form_for_user'); ?>";
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
          $("#edit-bank-details-modal .modal-body").html(messages);
          $("#settings-modal").modal("hide");
          $(".spinner-overlay").show();
          setTimeout(function () {
            $(".spinner-overlay").hide();
            $("#edit-bank-details-modal").modal("show");
          }, 2000)
          
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

  function submitBankDetailsForm (elem,evt) {
    elem = $(elem);

    evt.preventDefault();
    var me = elem;
    var form_data = me.serializeArray();
    
    console.log(form_data)
    var url = "<?php echo site_url('sabicapital/process_edit_payment_details'); ?>";
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
        if(response.success == true && response.account_name !== ""){
          account_name = response.account_name;
          swal({
            title: 'Payment Details Edited Successfully',
            html: "Your Account Name Is <span class='text-primary' style='font-style: italic;'>" + response.account_name + "</span>",
            type: 'success',
            allowOutsideClick: false
          }).then(function(){
            document.location.reload();
          });    
        }else if(response.invalid_account == true){
          swal({
            title: 'Invalid Account Details',
            text: "Sorry These Account Details Are Not Linked To Any Bank Account",
            type: 'error'                
          });
        }else if(response.messages !== ""){
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
        }else if(response.bouyant == false){
           swal({
            title: 'Insuffecient Balance',
            text: "Sorry You Do Not Have Enough Funds In Your Account To Complete This Transaction",
            type: 'error',
            confirmButtonColor: '#3085d6',                    
            confirmButtonText: 'Ok'                   
          });
        }else if(response.no_refer == true){
           swal({
            title: 'No Referrals',
            text: "You Need To Sponsor At Least One Ambassador Or One Great Ambassador To Be Eligible For Your First Withdrawal. Each Sponsorship Earns You ₦400 Commission",
            type: 'error',
            confirmButtonColor: '#3085d6',                    
            confirmButtonText: 'Ok'                   
          });
        }else{
          $.notify({
          message:"Sorry Something Went Wrong Please Check Your Internet Connection"
          },{
            type : "danger"  
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
</script>
<!-- Page Content -->
  <div class="">
    <div class="container-fluid">
      <div class="spinner-overlay" style="display: none;">
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader (2).gif') ?>" alt="Loading..." style="">
        </div>
      </div>
      <h3 class="text-center heading-text">Finance</h3>
      <div class="row justify-content-center">
        <div class="card shadow col-sm-6" style="min-height: 300px; margin-top: 30px;">
          <div class="card-body">
            <?php 
            $total_income = $this->sabicapital_model->getUserParamById("total_income",$user_id);
            $withdrawn = $this->sabicapital_model->getUserParamById("withdrawn",$user_id);
            $balance = $total_income - $withdrawn;

            ?>
            <h4 style="color: #7ea960;">Your Wallet Balance Is ₦<?php echo number_format($balance,2); ?></h4>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div style="color: #7ea960;" class="modal fade" data-backdrop="static" id="edit-bank-details-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center" style="color: #7ea960; text-transform: capitalize;">Edit Your Payment Details</h4>
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
          <h4 class="modal-title text-center" style="color: #7ea960; text-transform: capitalize;">Profile Settings</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body" style="padding: 0;">
          <div class="list-group">
            <a href="#" class="list-group-item" style="color: #7ea960;" onclick="changePasswordSelected(this,event)">Change Your Password</a>
            <a href="#" class="list-group-item" style="color: #7ea960;" onclick="editPaymentDetails(this,event)">Edit Payment Details</a>
            <!-- <a href="#" class="list-group-item" style="color: #7ea960;">Third item</a> -->
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
        </div>
      </div>
    </div>
  </div>

  <div  class="modal fade" data-backdrop="static" id="change-password-modal" data-focus="true" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center" style="color: #7ea960; text-transform: capitalize;">Change Your Password</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body">
          <?php 
              $attr = array('class' => 'container','id' => 'change-password-form');
              echo form_open('sabicapital/process_sign_in',$attr);
            ?>

              <div class="form-group">
                
                <input type="text" class="form-control shadow-sm" id="old_password" name="old_password" placeholder="Enter Old Password">
                <span class="form-error"></span>
              </div>
              
              <div class="form-group">
                
                <input type="text" class="form-control shadow-sm" id="new_password" name="new_password" placeholder="Enter New Password">
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

        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal" >Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- <div id="open-user-settings-modal-btn" onclick="openSettingsModal(this,event)" rel="tooltip" data-toggle="tooltip" title="User Settings" style="background: #7ea960; cursor: pointer; position: fixed; bottom: 0; right: 0;  border-radius: 50%; cursor: pointer; fill: #fff; height: 56px; outline: none; overflow: hidden; margin-bottom: 24px; margin-right: 24px; text-align: center; width: 56px; z-index: 4000;box-shadow: 0 8px 10px 1px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);">
    <div class="" style="display: inline-block; height: 24px; position: absolute; top: 16px; left: 16px; width: 24px;">
      <i class="fas fa-cog" style="font-size: 25px; color: #fff;" aria-hidden="true"></i>
    </div>
  </div>
 -->

  <script>
    $(document).ready(function () {
      $("#change-password-form").submit(function (evt) {
        evt.preventDefault();
        var me = $(this);
        var form_data = me.serializeArray();
        form_data.push({
          'name' : 'change_password',
          'value' : 'true'
        });
        var url = "<?php echo site_url('sabicapital/process_change_password') ?>";
        // console.log(form_data);
        var spinner = me.find(".spinner-border");
        var submit_btn = me.find("button");

        console.log(form_data)
        spinner.show();
        submit_btn.addClass('disabled');
        submit_btn.css({
          "cursor" : "unset"
        })

        $.ajax({
          type : "POST",
          dataType : "json",
          responseType : "json",
          url : url,
          data : form_data,
          success : function (response) {
            spinner.hide();
            submit_btn.removeClass('disabled');
            submit_btn.css({
              "cursor" : "pointer"
            })
            if(response.success){
              swal({
                title: 'Success',
                text: "Your Password Has Been Changed Successfully",
                type: 'success'
              }).then(function(){
                document.location.reload();
              });
            }else if(response.wrong_password){
              
              swal({
                title: 'Ooops',
                text: "Wrong Password Inputed. Please Try Again",
                type: 'warning'
              })
            }else{
              $.each(response.messages, function (key,value) {

                var element = $('#'+key);
                
                element.closest('div.form-group')
                        
                        .find('.form-error').remove();
                element.after(value);
                
              });

              swal({
                title: 'Ooops',
                text: "Some Values Where Not Valid. Please Enter Valid Values",
                type: 'warning'
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
              text: "Sorry Something Went Wrong. Please Check Your Internet Connection",
              type: 'error'
            })
          } 
        });   
      })

      $("#edit-profile-form").submit(function (evt) {
        evt.preventDefault();
        var me = $(this);
        var url = me.attr("action");
        var form_data = me.serializeArray();
        

        console.log(form_data)
        // $("#spinner-overlay").show();
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
              $.notify({
                message:"Your Profile Has Been Edited Successfully"
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