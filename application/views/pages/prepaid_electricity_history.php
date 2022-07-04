         <!-- End Navbar -->
<style>
  tr{
    cursor: pointer;
  }
</style>
<script>
  var use_as_sponsor_id;
  var use_as_placement_id;
  var use_as_position;
  var package;
  function viewMlmAccounts (elem,evt) {
    evt.preventDefault();
    swal({
      title: 'Choose Action: ',
      text: "Do You Want To View Your: ",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#4caf50',
      confirmButtonText: 'Basic Accounts',
      cancelButtonText : "Business Accounts"
    }).then(function(){
      var form_data = {
        show_records : true
      };
      $(".spinner-overlay").show();
      var url = "<?php echo site_url('meetglobal/load_users_basic_accounts'); ?>"
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
            $("#choose-action-card").hide();
            $("#users-basic-accounts-card .card-body").html(messages);
            $("#users-basic-accounts-card #users-basic-accounts-table").DataTable();
            $("#users-basic-accounts-card").show();
            $("#users-basic-accounts-card .genealogy-btn").tooltip();
            $("#users-basic-accounts-card .sponsor-btn").tooltip();
            $("#users-basic-accounts-card .upgrade-to-business-btn").tooltip();
            
            $("#add-new-basic-account-btn").show("fast");
            
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
    },function(dismiss){
      if(dismiss == 'cancel'){
        var form_data = {
          show_records : true
        };
        $(".spinner-overlay").show();
        var url = "<?php echo site_url('meetglobal/load_users_business_accounts'); ?>"
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
              $("#choose-action-card").hide();
              $("#users-business-accounts-card .card-body").html(messages);
              $("#users-business-accounts-card #users-business-accounts-table").DataTable();
              $("#users-business-accounts-card").show();
              // if(response.add_another_account){
                $("#add-new-busines-account-btn").show("fast");
              // }
              $("#users-business-accounts-card .genealogy-btn").tooltip();
              $("#users-business-accounts-card .sponsor-btn").tooltip();
              // $("#users-basic-accounts-card .upgrade-to-business-btn").tooltip();
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
    });      
    
  }

  function goBackFromViewYourBusinessAccountsCard (elem,evt) {
    $("#choose-action-card").show();
    
    $("#users-business-accounts-card").hide();
    $("#add-new-busines-account-btn").hide("fast");
  }

  function goBackFromViewYourBasicAccountsCard (elem,evt) {
    $("#choose-action-card").show();
    
    $("#users-basic-accounts-card").hide();
    $("#add-new-basic-account-btn").hide("fast");
  }

  function viewGenealogyTree(elem,evt,id){
    elem = $(elem);
    var package = elem.attr("data-package");

    viewRealGenealogyTree(id,package);
  }

  function viewSponsorTree(elem,evt,id){
    elem = $(elem);
    var package = elem.attr("data-package");
    viewRealSponsorTree(id,package);
  }

  function viewRealSponsorTree(id,package){
    $(".spinner-overlay").show();
    var form_data = {
      show_records : true,
      mlm_db_id : id
    }
    var url = "<?php echo site_url('meetglobal/view_your_sponsor_tree'); ?>"
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

          if(package == "basic"){
            $("#users-basic-accounts-card").hide();

          }else{
            $("#users-business-accounts-card").hide();
          }

          $("#sponsor-tree-card .go-back").attr("onclick","goBackFromSponsorTreeCard(this,event,'"+package+"')");

          $("#users-basic-accounts-card").hide();
          $("#sponsor-tree-card .card-body").html(messages);
          
          $("#sponsor-tree-card").show();
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

  function goBackFromSponsorTreeCard (elem,evt,package) {
    if(package == "basic"){
      $("#users-basic-accounts-card").show();
    }else{
      $("#users-business-accounts-card").show();
    }
    
    $("#sponsor-tree-card").hide();
  }

  function viewRealGenealogyTree(id,package){
    $(".spinner-overlay").show();
    var form_data = {
      show_records : true,
      mlm_db_id : id,
      package : package
    }
    var url = "<?php echo site_url('meetglobal/view_your_genealogy_tree'); ?>"
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
          if(package == "basic"){
            $("#users-basic-accounts-card").hide();

          }else{
            $("#users-business-accounts-card").hide();
          }

          $("#genealogy-tree-card .go-back").attr("onclick","goBackFromGenealogyTreeCard(this,event,'"+package+"')");
          
          $("#genealogy-tree-card .card-body").html(messages);
          
          $("#genealogy-tree-card").show();
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

  function goDownMlm(elem,event,mlm_db_id,your_mlm_db_id){
    elem = $(elem);
    var package = elem.attr("data-package");
    $(".spinner-overlay").show();
    var form_data = {
      show_records : true,
      mlm_db_id : mlm_db_id,
      your_mlm_db_id : your_mlm_db_id,
      package : package
    }
    var url = "<?php echo site_url('meetglobal/view_your_genealogy_tree_down'); ?>"
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
          if(package == "basic"){
            $("#users-basic-accounts-card").hide();

          }else{
            $("#users-business-accounts-card").hide();
          }

          $("#genealogy-tree-card .go-back").attr("onclick","goBackFromGenealogyTreeCard(this,event,'"+package+"')");
         
          $("#genealogy-tree-card .card-body").html(messages);
          
          $("#genealogy-tree-card").show();
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
      package : package
    }
    var url = "<?php echo site_url('meetglobal/view_your_genealogy_tree'); ?>"
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
          if(package == "basic"){
            $("#users-basic-accounts-card").hide();

          }else{
            $("#users-business-accounts-card").hide();
          }

          $("#genealogy-tree-card .go-back").attr("onclick","goBackFromGenealogyTreeCard(this,event,'"+package+"')");
         
          $("#genealogy-tree-card .card-body").html(messages);
          
          $("#genealogy-tree-card").show();
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

  function goBackFromGenealogyTreeCard (elem,evt,package) {
    if(package == "basic"){
      $("#users-basic-accounts-card").show();
    }else{
      $("#users-business-accounts-card").show();
    }
    $("#genealogy-tree-card").hide();
  }

  function updgradeToBusiness (elem,evt,id) {
    elem = $(elem);
    swal({
      title: 'Note!',
      text: "Are You Sure You Want To Upgrade Your Package For This Account To Business? <p><em class='text-primary'>Note You'll Pay A Sum Of ₦10,000 To Fully Upgrade This Account.</em></p>",
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
      var url = "<?php echo site_url('meetglobal/upgrade_mlm_account_to_business'); ?>"
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
              cancelButtonText : "Your Meetglobal Account"
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
                var url = "<?php echo site_url('meetglobal/upgrade_mlm_account_to_business_through_meetglobal_account'); ?>"
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

  

  function addNewBasicAccount (elem,evt) {
    swal({
      title: 'Confirm? ',
      text: "Are You Sure You Want To Add Another Mlm Account?",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText : "No"
    }).then(function(){
      $("#enter-sponsor-and-placement-modal").modal("show");
      // var form_data = {
      //   show_records : true
      // };
      // $(".spinner-overlay").show();
      // var url = "<?php echo site_url('meetglobal/'); ?>"
      // $.ajax({
      //   url : url,
      //   type : "POST",
      //   responseType : "json",
      //   dataType : "json",
      //   data : form_data,
      //   success : function (response) {
      //     $(".spinner-overlay").hide();
      //     if(response.success && response.messages != ""){

      //     }else{

      //     }
      //   },error : function () {
          
      //   } 
      // });
    });     
  }

  function loadMlmAccountsOfUser(elem,evt,type){
    evt.preventDefault();
    elem = $(elem);
    var val = elem.find("input").val();
    
    if(val != ""){
      if(type == "sponsor"){
        var form_display_span = elem.find('.form-display');
        var spinner = elem.find(".spinner");
        var form_data = {
          show_records : true,
          val : val,
          type : type
        };
        // $(".spinner-overlay").show();
        spinner.show();
        var url = "<?php echo site_url('meetglobal/get_user_name_mlm_accounts_for_this_user_sponsor'); ?>";
        $.ajax({
          url : url,
          type : "POST",
          responseType : "json",
          dataType : "json",
          data : form_data,
          success : function (response) {

            console.log(response)
            spinner.hide();
            if(response.success && response.messages != ""){
              var messages = response.messages;
              form_display_span.html("");
              $("#enter-sponsor-and-placement-modal .select-user-as-sponsor-div").html(messages);
              $("#enter-sponsor-and-placement-modal #select-sponsor-table").DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
              });
            }else if(response.invalid_username){
              form_display_span.html("<em class='text-warning'>No User With This Username.</em>");
              $("#enter-sponsor-and-placement-modal .select-user-as-sponsor-div").html("");
            }else{
              $("#enter-sponsor-and-placement-modal .select-user-as-sponsor-div").html("");
              form_display_span.html("<em class='text-danger'>Something Is Not Right.</em>");
            }
          },error : function () {
            spinner.hide();
            form_display_span.html("<em class='text-danger'>Something Went Wrong. Please Check Your Internet Connection</em>");
          } 
        });
      }else if(type == "placement"){
        if(use_as_sponsor_id != ""){
          var form_display_span = elem.find('.form-display');
          var spinner = elem.find(".spinner");
          var form_data = {
            show_records : true,
            val : val,
            type : type
          };
          // $(".spinner-overlay").show();
          spinner.show();
          var url = "<?php echo site_url('meetglobal/get_user_name_mlm_accounts_for_this_user_placement'); ?>";
          $.ajax({
            url : url,
            type : "POST",
            responseType : "json",
            dataType : "json",
            data : form_data,
            success : function (response) {

              console.log(response)
              spinner.hide();
              if(response.success && response.messages != ""){
                var messages = response.messages;
                form_display_span.html("");
                $("#enter-sponsor-and-placement-modal .select-user-as-placement-div").html(messages);
                $("#enter-sponsor-and-placement-modal #select-placement-table").DataTable({
                  aLengthMenu: [
                      [25, 50, 100, 200, -1],
                      [25, 50, 100, 200, "All"]
                  ],
                  iDisplayLength: -1
                });
              }else if(response.invalid_username){
                form_display_span.html("<em class='text-warning'>No User With This Username.</em>");
                $("#enter-sponsor-and-placement-modal .select-user-as-placement-div").html("");
              }else{
                $("#enter-sponsor-and-placement-modal .select-user-as-placement-div").html("");
                form_display_span.html("<em class='text-danger'>Something Is Not Right.</em>");
              }
            },error : function () {
              spinner.hide();
              form_display_span.html("<em class='text-danger'>Something Went Wrong. Please Check Your Internet Connection</em>");
            } 
          });
        }
      }
    }else{
      swal({
        title: 'Error',
        text: "You Must Enter Value In The Sponsor Username Field",
        type: 'error'
      })
    }
  }

  function selectThisUserAsSponsor (elem,evt) {
    elem = $(elem);
    var str = elem.attr("data-str");
    var id = elem.attr("data-mlm-db-id");
    swal({
      title: 'Confirm? ',
      text: "Are You Sure You Want To Proceed With " + str + " As Sponsor?",
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes Proceed!',
      cancelButtonText : "No Cancel"
    }).then(function(){
      use_as_sponsor_id = id;
      selectPlacement();
    });
  }

  function selectPlacement(){
    if(use_as_sponsor_id != ""){
      $("#enter-sponsor-and-placement-modal .select-user-as-sponsor-div").html("");
      $("#enter-sponsor-and-placement-modal .form-display").html("");
      $("#placement-user-name-form").show();
      $("#sponsor-user-name-form").hide();
      $(".reselect-sponsor").show();
    }else{
      swal({
        title: 'Error ',
        text: "Something Went Wrong",
        type: 'error'
      })
    }
  }

  function reselectSposor(elem,evt){
    elem = $(elem);
    elem.hide();
    $("#enter-sponsor-and-placement-modal .select-user-as-placement-div").html("");
    $("#enter-sponsor-and-placement-modal .form-display").html("");
    $("#placement-user-name-form").hide();
    $("#sponsor-user-name-form").show();
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
      var url = "<?php echo site_url('meetglobal/select_positioning_for_mlm'); ?>"
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
            $("#placement-user-name-form .select-placement-table-div").hide();
            $("#placement-user-name-form .select-placement-position-table-div").html(messages);
            $("#placement-user-name-form .select-placement-position-table-div #select-placement-position-table").DataTable({
                aLengthMenu: [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                iDisplayLength: -1
              });
            $("#placement-user-name-form .select-placement-position-table-div").show();
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

  function reselectPlacement(elem,evt){
    $("#placement-user-name-form .select-placement-table-div").show();
   
    $("#placement-user-name-form .select-placement-position-table-div").hide();
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
      }).then(function(){
        use_as_placement_id = placement_id;
        use_as_position = placement_position;
        performFinalPackageChoice();
      });  
    }
  }

  function performFinalPackageChoice (elem,evt) {
    
    package = "basic";
    performFinalPaymentMethod ();
     
  }

  function performFinalPaymentMethod () {
    if(use_as_sponsor_id != "" && use_as_placement_id != "" && use_as_position != "" &&  package != ""){
      var form_data = {
        sponsor_id : use_as_sponsor_id,
        placement_id : use_as_placement_id,
        positioning : use_as_position,
        package : package
      };
      swal({
        title: 'Choose Payment Method: ',
        text: "Do You Want To Pay Through: ",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#4caf50',
        confirmButtonText: 'Online Payment',
        cancelButtonText : "Your Meetglobal Account"
      }).then(function(){
        
        $(".spinner-overlay").show();
        var url = "<?php echo site_url('meetglobal/online_payment_take_another_slot_choosing'); ?>";
        $.ajax({
          url : url,
          type : "POST",
          responseType : "json",
          dataType : "json",
          data : form_data,
          success : function (response) {
            console.log(response)
            $(".spinner-overlay").hide();
            if(response.success && response.url != ""){
              var url = response.url;
              $.notify({
              message:"Redirecting To Secure Payment Page........."
              },{
                type : "success"  
              });
              setTimeout(function () {
                window.location.assign(url);
              }, 1500);
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
      },function(dismiss){
        if(dismiss == 'cancel'){
          $(".spinner-overlay").show();
          var url = "<?php echo site_url('meetglobal/verify_take_another_slot_meetglobal_account'); ?>";
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
                document.location.reload();
              }else if(response.not_enough_money){
                swal({
                  title: 'Error!',
                  text: "Sorry You Do Not Have Enough Funds To Complete This Transaction",
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
      }); 
    }   
  }

  function viewEarnings(elem,evt){
    $(".spinner-overlay").show();
    var form_data = {
      show_records : true
    }
    var url = "<?php echo site_url('meetglobal/view_your_mlm_earnings'); ?>";
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
          $("#all-earnings-card .card-body").html(messages);
          $("#all-earnings-table").DataTable({
            aLengthMenu: [
                [25, 50, 100, 200, -1],
                [25, 50, 100, 200, "All"]
            ],
            iDisplayLength: -1
          });
          $("#all-earnings-card").show();
          $("#choose-action-card").hide();
          $("#view-income-history-btn").show("fast");
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

  function goBackFromAllEarningsCard (elem,evt) {
    $("#all-earnings-card").hide();
    $("#choose-action-card").show();
    $("#view-income-history-btn").hide("fast");
  }

  function transferToMainAcct(elem,evt){
    $("#transfer-to-main-acct-modal").modal("show");
  }

</script>
<link href="<?php echo base_url('assets/css/treeflex.css') ?>" rel="stylesheet">
  <style>
    .tf-tree{
      text-align: center;
      /*cursor: col-resize;*/
    }
  
    .tf-tree .tf-nc .name{
      font-size: 13px;
    }

    .tf-tree .tf-nc {
      width: 120px;
      height: 220px;
      background: #fff;
      border: 0;
      border-radius: 4px;
      
      /*cursor: pointer;*/

    }

    .tf-tree .tf-nc .icons-div{
      /*margin-top: 10px;
      margin-bottom: 20px;*/
    }

    .tf-nc.business{
      border: 5px solid #89229b;
      box-shadow: 0 2px 6px 0 #89229b;
    }

    .tf-nc.basic{
      border: 5px solid #4caf50;
      box-shadow: 0 2px 6px 0 #4caf50;
    }

    .tf-nc.basic .package{
      color: #4caf50;
      text-transform: uppercase;
      font-weight: 700;
    }

    .tf-nc.business .package{
      color: #89229b;
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
      font-size: 12px;
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
  </style>

      <div class="spinner-overlay" style="display: none; z-index: 20000000" >
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading...">
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <h2 class="text-center">Prepaid Electricity History</h2>
          
          <div class="" style="margin-top: 80px;">
            <a href="<?php echo site_url('meetglobal/send_prepaid_token') ?>" class="btn btn-warning"> < < Go Back</a>
            <div class="card " id="main-card">
              <div class="card-body">
              <?php
              // var_dump($rows);
                if(is_array($rows)){
                  $i = 0;
              ?>
              <div class="table-responsive">
              <table class="table table-hover table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Phone Number</th>
                    <th>Order Id</th>
                    <th>Meter Token</th>
                    <th>Disco</th>
                    <th>Meter No.</th>
                    <th>Amount</th>
                    <th>Date / Time</th>
                    
                  </tr>
                </thead>
                <tbody>
              <?php
                  foreach($rows as $row){
                    $i++;
                    $id = $row['id'];
                    $vtu_id = $row['vtu_id'];
                    $meter_token = $row['meter_token'];
                    $date_time = $row['date_time'];

                    $phone_number = $row['phone_number'];
                    $email = $row['email'];
                    $user_id = $this->meetglobal_model->getVtuTransactionParamById("user_id",$vtu_id);
                    $user_name = $this->meetglobal_model->getUserNameById($user_id);
                    if($phone_number == ""){
                      $phone_number = $this->meetglobal_model->getFullMobileNoByUserName($user_name);
                    }

                    if($email == ""){
                      $email = $this->meetglobal_model->getUserParamById("email",$user_id);
                    }

                    
                    $user_name = $this->meetglobal_model->getUserParamById("user_name",$user_id);
                    $full_name = $this->meetglobal_model->getUserFullNameByUserId($user_id);
                    $slug = $this->meetglobal_model->getUserParamById("slug",$user_id);
                    $phone_number = $this->meetglobal_model->getFullMobileNoByUserName($user_name);
                    $order_id = $this->meetglobal_model->getVtuTransactionParamById("order_id",$vtu_id);
                    $disco = $this->meetglobal_model->getVtuTransactionParamById("sub_type",$vtu_id);
                    $meter_no = $this->meetglobal_model->getVtuTransactionParamById("number",$vtu_id);
                    $amount = $this->meetglobal_model->getVtuTransactionParamById("amount",$vtu_id);
                    
              ?>
                  <tr>
                    <td><?php echo $i; ?></td>
                    <td><a target="_blank" href="<?php echo site_url('meetglobal/'.$slug) ?>"><?php echo $full_name; ?></a></td>
                    <td><?php echo $phone_number; ?></td>
                    <td><?php echo $order_id; ?></td>
                    <td><?php echo $meter_token; ?></td>
                    <td><?php echo $disco; ?></td>
                    <td><?php echo $meter_no; ?></td>
                    <td><?php echo number_format($amount,2); ?></td>
                    <td><?php echo $date_time; ?></td>
                    
                  </tr>
              
              <?php
                }
              ?>
                </tbody>
              </table>
              </div>

              <?php
                echo $str_links;
               }else{
                echo "<h4 class='text-warning'>No History To Display</h4>";
               } 
              ?>
              </div>
            </div>

          </div>
        </div>
      </div>


      <footer class="footer">
        <div class="container-fluid">
          <!-- <footer>&copy; <?php echo date("Y"); ?> Copyright (meetglobal Issues Global Limited). All Rights Reserved</footer> -->
        </div>
      </footer>
      
      <script>
        $(document).ready(function () {

        })
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 