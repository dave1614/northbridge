
         <!-- End Navbar -->
        <style>
        body{
          /*background: #9124a3;*/
        }
           .avatar img{
       border-radius: 50%;
       width: 50px;
       height: 50px;
    }
     .message-sender .sender-name{
      margin-bottom: 3px;
    }
     .conversation{
      background: #fff;
      cursor: pointer;
      padding-top: 15px;
      padding-bottom: 15px;
      border-bottom: 1px solid #dddddd;
      margin-bottom: 10px;
      border-radius: 5px;
    }
     .conversation:hover{
      background-image: linear-gradient(rgba(29, 33, 41, .04), rgba(29, 33, 41, .04));
    }
     

    span.new-message-num.notification{
      right: -11px;
      top: -8px;
    }

      .small-loader{
      width: 30px;
      height: 30px;
      /*display: none;*/
    }

    .conversation p{
      font-size: 15px;
      font-weight: bold;
    }
    .conversation span{
      font-size: 12px;
      /*font-weight: bold;*/
    }
        </style>
      <div class="content" style="">
        <?php
        
        $page = $page - 1;
        // $conversations = $this->meetglobal_model->getConversationsRem2($user_id,$page);
        // var_dump($conversations);
        $all_notifs = $this->meetglobal_model->getNotifsPerPage($user_id,$page);
        if(is_array($all_notifs)){
        ?>
        <h3 class="text-center">Notifications</h3>
        <div class="container">
        <?php
          foreach($all_notifs as $row){
            $id = $row->id;
            $sender_id = $row->sender;
            $sender = $this->meetglobal_model->getUserNameById($sender_id);
            $notif_id = $row->id;
            $post_id = $row->post_id;
            $notif_title = $row->title;
            $received = $row->received;
            $date_sent = $row->date_sent;
            $time_sent = $row->time_sent;
            $received = $row->received;
            $type = $row->type;
            $site_url = site_url('meetglobal/index');
            if($type == "follow"){
              $site_url .= "/".$sender;
            }else if($type == "post"){
              $slug = $this->meetglobal_model->getPostSlugById($post_id);
              $site_url .= "/post/".$post_id.'/'.$slug;
            }else if($type == "comment"){
              $slug = $this->meetglobal_model->getPostSlugById($post_id);
              $site_url .= "/post/".$post_id.'/'.$slug;
            }else if($type == "like"){
              $slug = $this->meetglobal_model->getPostSlugById($post_id);
              $site_url .= "/post/".$post_id.'/'.$slug;
            }

            $site_url = site_url("meetglobal/mark_notif_as_read?callback_url=".$site_url."&id=".$id);
          ?>
        <div class="conversation row" <?php if($received == 0){ echo "style='background-color: #E8E8E8;'"; } ?> onclick="window.location.assign('<?php echo $site_url; ?>');">
            <div class="col-2 avatar">
              <img src="<?php echo $this->meetglobal_model->getUserLogoById($sender_id); ?>" alt="<?php echo $this->meetglobal_model->getUserNameById($sender); ?>">
            </div>
            <div class="col-6 message-sender">
              <p class="sender-name"><?php echo $sender; ?> &nbsp;
              <?php
                echo $this->meetglobal_model->getNumberOfNewMessagesFromSender($user_id,$sender);
              ?>
              </p>
              <span class="last-message"><?php echo $this->meetglobal_model->custom_echo($notif_title,80); ?></span>
            </div>
            <div class="col-4 time-stamp">
              <span>
                <?php echo $this->meetglobal_model->getSocialMediaTime($date_sent,$time_sent); ?>
              </span>
            </div>
        </div>
        <?php
          }
        ?>
        </div>
        <?php         
          }else{
            echo "<h4 class='text-danger'>You Do Have Any Notifications</h4>";
          }
        ?>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <?php
            echo $str_links;
          ?>
        </div>
      </footer>
      
      <script>
      </script>
    </div>
  </div>
  <!--   Core JS Files   -->
 