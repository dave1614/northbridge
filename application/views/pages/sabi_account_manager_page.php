
<style>
  img{
    width: 100%;
    height: 350px;
  }

  
  form{
    margin-top: 30px;
    margin-bottom: 30px;
  }

  form label{
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
      <h3 class="text-center heading-text">Sabi Account Manager Request</h3>
      <div class="row justify-content-center">
        <div class="card shadow col-sm-6" style="min-height: 300px; margin-top: 30px;">
          <div class="card-body">
            <?php
            $attr = array('id' => 'sabi-account-manager-request-form');
            echo form_open('sabicapital/process_sabi_account_manager_request',$attr);
            ?>
              <div class="form-group">
                <p style="color: #7ea960; margin-bottom: 0;">It doesn't matter how busy you may be or maybe you don't have the  trading knowledge, you can still make  extra income through forex business. Let Sabi Experts to for you and share profit monthly.</p>
                <p style="color: #7ea960; margin-bottom: 0;">To start fill the form below</p>
              </div>
              <div class="form-group">
                <label for="full_name">Full Name: </label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="<?php if(isset($full_name)){ echo $full_name;  } ?>">
                <span class="form-error"></span>
              </div>
              <div class="form-group">
                <label for="phone">Phone Number: </label>
                <input type="number" id="phone" name="phone" class="form-control" value="<?php if(isset($phone)){ echo $phone;  } ?>">
                <span class="form-error"></span>
              </div>
             
              <div class="form-group">
                <label for="email">Email: </label>
                <input type="email" id="email" name="email" class="form-control" value="<?php if(isset($email)){ echo $email;  } ?>">
                <span class="form-error"></span>
              </div>
              <div class="form-group">
                <label for="super_forex_account_number">Superforex Account Number: </label>
                <input type="text" id="super_forex_account_number" name="super_forex_account_number" class="form-control" value="<?php if(isset($super_forex_account_number)){ echo $super_forex_account_number;  } ?>">
                <span class="form-error"></span>
              </div>
              <div class="form-group">
                <label for="start_capital">Start Capital: </label>
                <input type="number" name="start_capital" id="start_capital" class="form-control" step="any" value="">
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

 
  <script>
    $(document).ready(function () {
      

      $("#sabi-account-manager-request-form").submit(function (evt) {
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
                message:"Request Made Successfully"
              },{
                type : "success"  
              });
              setTimeout(function () {
                document.location.reload();
              }, 1000)
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