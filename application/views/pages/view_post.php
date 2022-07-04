
<?php
  $main_user_id = $user_id;
?>       <!-- End Navbar -->
  <style>
    i.liked{
      color: #e91e63;
    }
  </style>
    <script>
      function onScroll () {
        if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
              
          var posts_container = document.querySelector(".posts-container");
          var posts_num = posts_container.children.length;
          var offset = posts_num;
          if(posts_num >= 2){
              var loader = $("#posts .big-loader");
              var last_id = posts_container.lastElementChild.querySelector(".post-card").getAttribute("id");
              // console.log(last_id)
              last_id = last_id.substr(0, last_id.length-5);
              loader.show();
              // console.log(last_id);
              // console.log(offset);
              $.ajax({
                url : "<?php echo site_url('meetglobal/load_more_posts_front') ?>",
                type : "POST",
                responseType : "json",
                dataType : "json",
                async : false,
                data : "offset="+offset+"&last_id="+last_id,
                success : function (response) {
                  // console.log(response)
                  loader.hide();
                  if(response.success == true && response.messages !== ""){
                    var messages = response.messages;
                    $(messages).appendTo(posts_container);
                    $(".owl-demo").owlCarousel({
     
                            // navigation : true, // Show next and prev buttons
                            slideSpeed : 300,
                            paginationSpeed : 400,
                            singleItem:true
                       
                            // "singleItem:true" is a shortcut for:
                            // items : 1, 
                            // itemsDesktop : false,
                            // itemsDesktopSmall : false,
                            // itemsTablet: false,
                            // itemsMobile : false
                       
                        });
                    if(response.last_batch == true){
                      // loader.hide();
                    }
                  }
                },
                error : function(){
                  loader.hide();
                }
              }); 
              // console.log(offset)
          }     
        }
      }

      function round (value, precision, mode) {
      var m, f, isHalf, sgn // helper variables
      // making sure precision is integer
      precision |= 0
      m = Math.pow(10, precision)
      value *= m
      // sign of the number
      sgn = (value > 0) | -(value < 0)
      isHalf = value % 1 === 0.5 * sgn
      f = Math.floor(value)

      if (isHalf) {
        switch (mode) {
          case 'PHP_ROUND_HALF_DOWN':
          // rounds .5 toward zero
            value = f + (sgn < 0)
            break
          case 'PHP_ROUND_HALF_EVEN':
          // rouds .5 towards the next even integer
            value = f + (f % 2 * sgn)
            break
          case 'PHP_ROUND_HALF_ODD':
          // rounds .5 towards the next odd integer
            value = f + !(f % 2)
            break
          default:
          // rounds .5 away from zero
            value = f + (sgn > 0)
        }
      }

      return (isHalf ? value : Math.round(value)) / m
    }
    function loadMoreComments (elem) {
      var comment_section = elem.parentElement.parentElement.querySelector(".comment-section");
      var first_comment = comment_section.firstElementChild.getAttribute("id");
      // console.log(first_comment);
      var loader = elem.parentElement.querySelector("img.loader-img");
      var comment_id = first_comment.substr(0, first_comment.length-8);


      removeClass(loader,"hide");
      $.ajax({
        url : "<?php echo site_url('meetglobal/index/load_more_comments') ?>",
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : "offset="+comment_id,
        success : function (response) {
          console.log(response)
          addClass(loader,"hide");
          if(response.success == true && response.messages !== ""){
            var messages = response.messages;
            $(messages).prependTo(comment_section);
            if(response.last_batch == true){
              addClass(elem,"hide");
            }
          }
        },
        error : function(){
          addClass(loader,"hide");
        }
      });  
    }
    
    function getMorePostContent(elem) {
      var small_content = elem.parentElement.querySelector(".small-content");
      var big_content = elem.parentElement.querySelector(".big-content");
      addClass(small_content,"hide");
      
      removeClass(big_content,"hide");
     
      addClass(elem,"hide");
    }

    function comment (elem) {
      var comment_input = elem.parentElement.parentElement.parentElement.querySelector(".add-comment-section textarea");
      comment_input.focus();
    }

    function commentInputKeypress (evt,elem,id) {
      if(elem.value !== ""){
        if(evt.which == 13){
          elem.value = elem.value.replace(/^\s*$(?:\r\n?|\n)/gm,"");
          var content = elem.value;
          var small_loader = elem.parentElement.querySelector("img.loader-img");
          var comment_section = elem.parentElement.parentElement.parentElement.parentElement.querySelector(".comment-section");
          <?php 
            $main_user_name = $this->meetglobal_model->getUserNameById($main_user_id);
          ?>
          var user_name = "<?php echo $main_user_name; ?>";
          var user_url = "<?php echo site_url('meetglobal/index/'.$main_user_name); ?>";
          removeClass(small_loader,"hide");
          addClass(elem,"disabled");
          $.ajax({
            url : "<?php echo site_url('meetglobal/index/comment') ?>",
            type : "POST",
            responseType : "json",
            dataType : "json",
            data : "post_id="+id+"&content="+content,
            success : function(response){
              removeClass(elem,"disabled");
              addClass(small_loader,"hide");
              if(response.success == true){
                var val = $('<h6><a href="'+user_url+'" style="font-size: 14px; font-weight: 600;">'+user_name+'</a>&nbsp;&nbsp;<small>'+content+'</small></h6>');
                
                val.appendTo(comment_section);
                elem.value = "";
              }
            },error : function () {
              addClass(small_loader,"hide");
              removeClass(elem,"disabled");
            }
          });  
        }
      }
    }
    
    function likePost (elem,id) {
      var i = elem.querySelector("i");
      var temp_likes_elem = elem.parentElement.parentElement.querySelector(".post-likes-temp");
      var temp_likes = elem.parentElement.parentElement.querySelector(".post-likes-temp").innerHTML;
      var likes_num = elem.parentElement.parentElement.querySelector(".likes-num");
      addClass(i,"liked");
      elem.setAttribute("onclick", "unlikePost(this,"+id+")");
      temp_likes++;
      if(temp_likes > 1){
        likes_num.innerHTML = temp_likes + " likes";
      }else if(temp_likes == 1){
        likes_num.innerHTML = temp_likes + " like";
      }
      temp_likes_elem.innerHTML = temp_likes;
      $.ajax({
        url : "<?php echo site_url('meetglobal/index/like_post') ?>",
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : "post_id="+id,
        success : function(response){
          console.log(response)

        },error : function () {
          
        }
      });  
    }

    function unlikePost (elem,id) {
      var i = elem.querySelector("i");
      var temp_likes_elem = elem.parentElement.parentElement.querySelector(".post-likes-temp");
      var temp_likes = elem.parentElement.parentElement.querySelector(".post-likes-temp").innerHTML;
      var likes_num = elem.parentElement.parentElement.querySelector(".likes-num");
      removeClass(i,"liked");
      elem.setAttribute("onclick", "likePost(this,"+id+")");
      temp_likes--;
      if(temp_likes > 1){
        likes_num.innerHTML = temp_likes + " likes";
      }else if(temp_likes == 1){
        likes_num.innerHTML = temp_likes + " like";
      }else if(temp_likes == 0){
        likes_num.innerHTML = "No Likes";
      }
      $.ajax({
        url : "<?php echo site_url('meetglobal/index/unlike_post') ?>",
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : "post_id="+id,
        success : function(response){
          console.log(response)

        },error : function () {
          
        }
      }); 
      temp_likes_elem.innerHTML = temp_likes;
    }

    function sharePost (elem,post_id,user_name) {
      swal({
          title: 'Choose Action',
          html: "Are You Sure You Want To Share This Post?",
          type: 'success',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes',
          cancelButtonText : "No"
      }).then(function(){
        $(".spinner-overlay").show();
        var data = {
          'post_id' : post_id
        };
        $.ajax({
            url : "<?php echo site_url('meetglobal/share_post') ?>",
            type : "POST",
            responseType : "json",
            dataType : "json",
            data : data,
            success : function(response){
              console.log(response)
              $(".spinner-overlay").hide();
              if(response.success == true){
                $.notify({
                    message:"Post Shared To Your Page Successfully"
                  },{
                      type : "success"  
                  });
            setTimeout(function () {
                  window.location.assign("<?php echo site_url('meetglobal/'.$main_user_name.'#compose'); ?>");
                },2000);  
              }else{
                $.notify({
                    message:"Sorry Your Request To Share Could Not Be Processed"
                  },{
                      type : "danger"  
                  })
              }
            },error : function () {
              $(".spinner-overlay").hide();
              $.notify({
                  message:"Sorry Something Went Wrong The SMS Could Not Be Sent. Please Check Your Internet Connection And Try Again"
                },{
                  type : "danger"  
                });
            }
        }); 

      });
    }

    function moreButton (elem,id,slug) {
      $("#choose-action-modal").modal({
        "backdrop" : false,
        "show" : true
      });
      $("#choose-action-modal .modal-body ul.list-group").attr("data-id",id);
      $("#choose-action-modal .modal-body ul.list-group").attr("data-slug",slug);
    }


    function viewPost(elem,evt){
      evt.preventDefault();
      var id = elem.parentElement.parentElement.getAttribute("data-id");
      var slug = elem.parentElement.parentElement.getAttribute("data-slug");
      window.location.assign("<?php echo site_url('meetglobal/index/post/') ?>"+id+"/"+slug);
    }

    function showPostLikes(elem,post_id){
      if(!isNaN(post_id)){
        var post_likes = Number(elem.parentElement.querySelector(".post-likes-temp").innerHTML);
        if(post_likes > 0){
          var url = "<?php echo site_url('meetglobal/get_users_who_liked_post'); ?>";
          $(".spinner-overlay").show();
          $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {post_id: post_id},
          })
          .done(function(response) {
            console.log(response);
            $(".spinner-overlay").hide();
            if(response.success){
              var messages = response.messages;
              if(messages !== ""){
                var ret_str = "";
                for(var i = 0; i < messages.length; i++){
                  var user_info = messages[i];
                  var user_name = user_info.user_name;
                  var user_id = user_info.user_id;
                  var you = user_info.you;
                  var profile_url = user_info.profile_url;
                  var following = user_info.following;
                  ret_str += '<tr><td style="border: 0;">';
                  if(!you){
                    ret_str += '<a href="' + profile_url + '">' + user_name + '</a>';
                  }else{
                    ret_str += '<p class="text-rose">' + user_name + '</p>';
                  }
                  ret_str += '</td>';
                  if(!you){
                    ret_str += '<td style="float: right; border: 0;"><button style="padding: 9px 23px;" class="btn btn-rose btn-round justify-content-center"'; 
                    if(!following){
                      ret_str += 'onclick="followUser(this,' + user_id + ',false)">Follow <img class="follow-loader" src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>" alt="Loading..."> </button></td>';
                    }else{
                      ret_str += 'onclick="unfollowUser(this,' + user_id + ',false)">Following <img class="follow-loader" src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>" alt="Loading..."> </button></td>';
                    }
                         
                  }
                  ret_str += '</tr>';
                }
                console.log(ret_str)
                $("#showLikesModal .modal-body tbody").html(ret_str);
                $("#showLikesModal").modal({
                  "show" : true
                });
              }
            }
          })
          .fail(function() {
            $(".spinner-overlay").hide();
          })     
        }
      }
     } 

    function followUser (elem,user_id,type = true) {
      var loader = elem.querySelector("img.follow-loader");
      var loader_url = '<?php echo base_url("assets/images/ajax-loader.gif"); ?>';
      loader.style.display = 'inline-block';
      addClass(elem,"disabled");
      $.ajax({
        url : "<?php echo site_url('meetglobal/index/follow') ?>",
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : "user_id="+user_id,
        success : function(response){
          if(response.success == true){
            removeClass(elem,"disabled");
            loader.style.display = 'none';
            elem.setAttribute("onclick","unfollowUser(this,"+user_id+")")
            elem.innerHTML = 'Following <img class="follow-loader" src="'+loader_url+'" alt=""> <div class="ripple-container"></div>';
            if(type == true){
              var temp_followers = Number($(".followers_temp").html());
              var new_followes_num = temp_followers + 1;
              $(".followers_temp").html(new_followes_num);
              var new_followes_num = socialMediaFormatNum(new_followes_num);
              $(".follower-num").html(new_followes_num);
            }
          }else{
            loader.style.display = 'none';
            removeClass(elem,"disabled");
          }
        },
        error: function () {
          removeClass(elem,"disabled");
          loader.style.display = 'none';
        }
      });
    }

    function unfollowUser (elem,user_id,type) {
      var loader = elem.querySelector("img.follow-loader");
      var loader_url = '<?php echo base_url("assets/images/ajax-loader.gif"); ?>';
      loader.style.display = 'inline-block';
      addClass(elem,"disabled");
      $.ajax({
        url : "<?php echo site_url('meetglobal/index/unfollow') ?>",
        type : "POST",
        responseType : "json",
        dataType : "json",
        data : "user_id="+user_id,
        success : function(response){
          console.log(response)
          if(response.success == true){
            removeClass(elem,"disabled");
            loader.style.display = 'none';
            elem.setAttribute("onclick","followUser(this,"+user_id+")")
            elem.innerHTML = 'Follow <img class="follow-loader" src="'+loader_url+'" alt=""> <div class="ripple-container"></div>';
            if(type == true){
              var temp_followers = Number($(".followers_temp").html());
              var new_followes_num = temp_followers - 1;
              $(".followers_temp").html(new_followes_num);
              var new_followes_num = socialMediaFormatNum(new_followes_num);
              if(new_followes_num == 0){ new_followes_num = "no followers"; }
              $(".follower-num").html(new_followes_num);
            }
          }else{
            removeClass(elem,"disabled");
            loader.style.display = 'none';
          }
        },
        error: function () {
          removeClass(elem,"disabled");
          loader.style.display = 'none';
        }
      });
    }
    
    function socialMediaFormatNum (num) {
      if(num >= 1000 && num < 1000000){
        num = round(num / 1000,2);
        num = num + 'K';
      }else if(num >= 1000000 && num < 1000000000){
        num = round(num / 1000000,2);
        num = num + 'M';
      }else if(num >= 1000000000 && num < 1000000000000){
        num = round(num / 1000000000,2);
        num = num + 'B';
      }else if(num >= 1000000000000){
        num = round(num / 1000000000000,2);
        num = num + 'T';
      }
      return num;
    }

    function round (value, precision, mode) {
      var m, f, isHalf, sgn // helper variables
      // making sure precision is integer
      precision |= 0
      m = Math.pow(10, precision)
      value *= m
      // sign of the number
      sgn = (value > 0) | -(value < 0)
      isHalf = value % 1 === 0.5 * sgn
      f = Math.floor(value)

      if (isHalf) {
        switch (mode) {
          case 'PHP_ROUND_HALF_DOWN':
          // rounds .5 toward zero
            value = f + (sgn < 0)
            break
          case 'PHP_ROUND_HALF_EVEN':
          // rouds .5 towards the next even integer
            value = f + (f % 2 * sgn)
            break
          case 'PHP_ROUND_HALF_ODD':
          // rounds .5 towards the next odd integer
            value = f + !(f % 2)
            break
          default:
          // rounds .5 away from zero
            value = f + (sgn > 0)
        }
      }

      return (isHalf ? value : Math.round(value)) / m
    }


    </script>
      <div class="spinner-overlay" style="display: none;">
        <div class="spinner-well">
          <img src="<?php echo base_url('assets/images/tests_loader.gif') ?>" alt="Loading...">
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <?php
            $post_sender = $this->meetglobal_model->getPostSender($second_addition);
            // echo $user_id;
            if($post_sender == $user_name){
              $post_sender = "you";
            }else{
              $post_sender = $post_sender;
            }
          ?>
          <h3 class="text-center">Post By <?php echo $post_sender; ?></h3>
          <div class="">
            <div class="">
              <div class="text-center posts-container">
                <?php 
                $posts_by_user = $this->meetglobal_model->getPostById($second_addition);
                
                if(is_array($posts_by_user)){
                  // $posts_by_user = array_reverse($posts_by_user);
                  foreach($posts_by_user as $row){
                    $date = $row->date;
                    $time = $row->time;
                    $post_id = $row->id;
                    $post_content = $row->content;
                    $images = $row->images;
                    $image_arr = explode(",", $images);
                    $likes = $row->likes;
                    $sender = $row->sender;
                    $slug = $row->slug;
                    $sender_username = $this->meetglobal_model->getUserNameById($sender);
                    $likes_num = 0;
                    if($likes !== ""){
                      $likes_arr = explode(",", $likes);
                      if(!empty($likes_arr)){
                        $likes_arr = array_unique($likes_arr);
                        $this->meetglobal_model->updatePostLikes($likes_arr,$post_id);
                        $likes_num = count($likes_arr);
                      }
                    }
                ?>
                <div class="justify-content-center">
                  
                  <div class="card post-card col-sm-8" id="<?php echo $post_id; ?>-post">
                    <div class="card-header text-left">
                      <div class="text-left" style="display: inline-block;">
                        <h4 class="card-title text-left"><img src="<?php echo $this->meetglobal_model->getUserLogoById($sender); ?>" alt="">
                        <span><?php echo $sender_username; ?></span></h4>
                      </div>

                      <div class="text-right float-right" onclick="moreButton(this,<?php echo $post_id; ?>,'<?php echo $slug; ?>')" style="cursor: pointer; display: inline-block;">
                        <i class="fas fa-ellipsis-h"></i>
                      </div>
                      
                    </div>
                    <div class="card-body" >
                      <?php if(!empty($image_arr) && $images !== ""){ ?>
                      <div id="" class="owl-carousel owl-theme owl-demo">
                        <?php for($i = 0; $i < count($image_arr); $i++){ 
                          $current_image = $image_arr[$i];
                        ?>
                        <div class="item"><img class="col-sm-7" src="<?php echo base_url('assets/images/'.$current_image); ?>" alt="<?php echo $post_content; ?>"></div>
                        
                        <?php } ?>
                       
                      </div>
                      <?php } ?>

                      <div class="action-buttons-panel text-left" style="">
                        <div class="row">
                          <div class="col-2 col-xs-2 like-btn" onclick="<?php if($this->meetglobal_model->checkIfUserHasAlreadyLikedPost($main_user_id,$post_id)){  ?>likePost(this,<?php echo $post_id; ?>) <?php }else{ ?> unlikePost(this,<?php echo $post_id; ?>) <?php } ?> ">
                            <i class="far fa-heart <?php if(!$this->meetglobal_model->checkIfUserHasAlreadyLikedPost($main_user_id,$post_id)){ echo 'liked'; } ?>"></i>
                          </div>
                          <div class="col-2 col-xs-2 comment-btn" onclick="comment(this)">
                            <i class="far fa-comment"></i>
                          </div>
                          <?php if($main_user_name !== $sender_username){ ?>
                            <div class="col-2 col-xs-2 share-btn" style="" onclick="sharePost(this,<?php echo $post_id; ?>)">
                              <i class="far fa-share-square"></i>
                            </div>
                          <?php } ?>
                        </div>
                        <p class="likes-num text-left" onclick="showPostLikes(this,<?php echo $post_id; ?>)"><?php if($likes_num == 0){ echo "No Likes"; } else{ if($likes_num == 1){ echo $likes_num . ' like'; }else{ echo $likes_num . ' likes'; } }  ?></p>
                        <span class="post-likes-temp hide"><?php echo $likes_num; ?></span>
                      </div>
                      <div class="post-content text-left">
                        <h6><a style="text-transform: lowercase;" href="<?php echo site_url('meetglobal/index/'.$sender_username); ?>" style="font-size: 14px; font-weight: 600;"><?php echo $sender_username;  ?></a>&nbsp;&nbsp;<small><?php if(strlen($post_content) >= 60){ ?><span class="small-content"><?php echo $this->meetglobal_model->custom_echo($post_content,60); ?></span><span class="hide big-content"><?php echo $post_content; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class='content-more-btn' onclick="getMorePostContent(this)">more</span><?php }else{ ?> <span><?php echo $post_content; ?></span> <?php } ?></small></h6>
                      </div>
                      <div class="get-more-comments text-left">
                        <?php
                          if($this->meetglobal_model->getNoOfCommentsInPost($post_id) !== false){
                            if($this->meetglobal_model->getNoOfCommentsInPost($post_id) > 5){
                              echo "<span class='more-comments-btn' onclick='return loadMoreComments(this,".$post_id.")'>view more comments(".$this->meetglobal_model->getNoOfCommentsInPost($post_id).")</span>";
                              echo  '<img class="loader-img hide" src="'.base_url('assets/images/loading.gif').'" alt="">';
                            }
                          }
                        ?>
                      </div>
                      <div class="comment-section text-left">
                        
                        <?php
                          $comments_on_post = $this->meetglobal_model->getFirstFiveCommentsOnPost($post_id);
                          if(is_array($comments_on_post)){
                            $comments_on_post = array_reverse($comments_on_post); 
                            foreach($comments_on_post as $row){
                              $comment_id = $row->id;
                              $comment_content = $row->content;
                             
                              $likes = $row->likes;
                              $sender = $row->sender;
                              $sender_username = $this->meetglobal_model->getUserNameById($sender);
                              $likes_num = 0;
                              if($likes !== ""){
                                $likes_arr = explode(",", $likes);
                                if(!empty($likes_arr)){
                                  $likes_arr = array_unique($likes_arr);
                                  $this->meetglobal_model->updateCommentLikes($likes_arr,$comment_id);
                                  $likes_num = count($likes_arr);
                                }
                              }
                        ?>
                        <h6 id="<?php echo $comment_id; ?>-comment"><a href="<?php echo site_url('meetglobal/index/'.$sender_username); ?>" style="font-size: 14px; font-weight: 600;"><?php echo $sender_username; ?></a>&nbsp;&nbsp;<small><?php echo $comment_content; ?></small></h6>
                        <?php } } ?>
                        
                      </div>
                      <div class="add-comment-section">
                        <form>
                          <div class="form-group">
                            <textarea style="padding-bottom: 3px;" onkeypress="return commentInputKeypress (event,this,<?php echo $post_id; ?>);" autocomplete="off" name="message"  placeholder="Add A Comment..." class="form-control comment-input col-sm-10">
                            </textarea>
                            <div class="text-right col-sm-1">
                              <img class="loader-img hide" src="<?php echo base_url('assets/images/loading.gif'); ?>" alt="">
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="text-left">
                        <span class="post-time-display"><?php echo $this->meetglobal_model->getSocialMediaTime($date,$time); ?></span>
                      </div>
                    </div>
                  </div>
                 
                </div> 
              <?php } }else{  ?> 
                <h3 class="text-warning">No Posts To Display</h3>
              <?php } ?>
              </div>
              <div class="text-center">
                <img class="big-loader" src="<?php echo base_url('assets/images/loading.gif'); ?>" alt="">
              </div>         
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="showLikesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel">Likes</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body" style="padding-top: 0;">
                    <table class="table">
                      <thead style="display: none;">
                        <tr>
                          <th>Username</th>
                          <th>Follow Button</th>
                        </tr>
                      </thead>
                      <tbody>                        
                        <?php for($i = 0; $i < 200; $i++){ ?>
                        <tr>
                          <td style="border: 0; padding: 0;"><a href="/">admin</a></td>
                          <td style="float: right; border: 0; padding: 0"><button style="padding: 9px 23px;" class="btn btn-rose btn-round justify-content-center" onclick="followUser(this,119,false)">Follow <img class="follow-loader" src="<?php echo base_url('assets/images/ajax-loader.gif'); ?>" alt="Loading..."> </button></td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="modal-footer">
                    
                  </div>
                </div>
              </div>
            </div>

      <div id="choose-action-modal" class="modal fade text-center" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            
            <div class="modal-header" style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">
              <h5 class="modal-title text-rose">Choose Action</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
               
              <ul class="list-group">
                
                <li class="list-group-item"><a href="#" class="text-primary" onclick="viewPost(this,event)">View Post</a></li>
              </ul>  
                
            </div>
            
            <div class="modal-footer text-center">
              
            </div>
          </div>
        </div>
      </div>


      <footer class="footer">
        <div class="container-fluid">
          
        </div>
      </footer>
      
      <script>
        $(document).ready(function() {

        $(".comment-input").val("");
          $(".owl-demo").owlCarousel({
         
              // navigation : true, // Show next and prev buttons
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem:true
         
              // "singleItem:true" is a shortcut for:
              // items : 1, 
              // itemsDesktop : false,
              // itemsDesktopSmall : false,
              // itemsTablet: false,
              // itemsMobile : false
         
          });
      });
        
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 