<style>
:root {
  --body-bg: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  --msger-bg: #fff;
  --border: 2px solid #ddd;
  --left-msg-bg: #ececec;
  --right-msg-bg: #579ffb;
}

*,
*:before,
*:after {
  margin: 0;
  padding: 0;
  box-sizing: inherit;
}

.msger {
  display: flex;
  flex-flow: column wrap;
  justify-content: space-between;
  width: 100%;
  max-width: 867px;
  margin: 25px 10px;
  height: calc(100% - 50px);
  border: var(--border);
  border-radius: 5px;
  background: var(--msger-bg);
  box-shadow: 0 15px 15px -5px rgba(0, 0, 0, 0.2);
}

.msger-header {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  border-bottom: var(--border);
  background: #eee;
  color: #666;
}

.msger-chat {
  flex: 1;
  overflow-y: auto;
  padding: 10px;
}
.msger-chat::-webkit-scrollbar {
  width: 6px;
}
.msger-chat::-webkit-scrollbar-track {
  background: #ddd;
}
.msger-chat::-webkit-scrollbar-thumb {
  background: #bdbdbd;
}
.msg {
  display: flex;
  align-items: flex-end;
  margin-bottom: 10px;
}
.msg:last-of-type {
  margin: 0;
}
.msg-img {
  width: 50px;
  height: 50px;
  margin-right: 10px;
  background: #ddd;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  border-radius: 50%;
}
.msg-bubble {
  max-width: 450px;
  padding: 15px;
  border-radius: 15px;
  background: var(--left-msg-bg);
}
.msg-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.msg-info-name {
  margin-right: 10px;
  font-weight: bold;
}
.msg-info-time {
  font-size: 0.85em;
}

.left-msg .msg-bubble {
  border-bottom-left-radius: 0;
}

.right-msg {
  flex-direction: row-reverse;
}
.right-msg .msg-bubble {
  background: var(--right-msg-bg);
  color: #fff;
  border-bottom-right-radius: 0;
}
.right-msg .msg-img {
  margin: 0 0 0 10px;
}

.msger-inputarea {
  display: flex;
  padding: 10px;
  border-top: var(--border);
  background: #eee;
}
.msger-inputarea * {
  padding: 10px;
  border: none;
  border-radius: 3px;
  font-size: 1em;
}
.msger-input {
  flex: 1;
  background: #ddd;
}
.msger-send-btn {
  margin-left: 10px;
  background: rgb(0, 196, 65);
  color: #fff;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.23s;
}
.msger-send-btn:hover {
  background: rgb(0, 180, 50);
}

.msger-chat {
  background-color: black;
}

</style>

<main class="main-container">
  <section class="content-container">
    <div class="content">
      <div class="stories">
        <?if(empty($chats)){?>
        <img src="<?=base_url()?>assets/frontend/emptyinbox.jpg" />
        <?}else{?>
          <section class="msger">
            <header class="msger-header">
              <div class="msger-header-title">
                <a href="<?=base_url()?>Home/inbox">
                <svg xmlns="http://www.w3.org/2000/svg" style="float: left; margin-right: 9px;" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
</svg> </a>
<?=$friend_data[0]->name?>
              </div>
            </header>
            <main class="msger-chat refreshit">
              <?foreach($chats->result() as $display_chats){
                if($display_chats->send==$this->session->userdata('user_id')){
                ?>
                <div class="msg right-msg">
                  <!-- <?if(empty($user_data[0]->image)){?>
                  <img src="<?=base_url()?>assets/frontend/default-user.png" alt="User Picture" />
                  <?}else{?>
                    <img src="<?=base_url().$user_data[0]->image?>" alt="User Picture" />
                    <?}?> -->

                  <div class="msg-bubble">
                    <div class="msg-info">
                      <div class="msg-info-name"><?=$user_data[0]->name?></div>
                      <div class="msg-info-time">12:46</div>
                    </div>
                    <div class="msg-text"><?=$display_chats->content?></div>
                  </div>
                </div>
              <?}else{?>
                <div class="msg left-msg">
                  <!-- <?if(empty($friend_data[0]->image)){?>
                  <img src="<?=base_url()?>assets/frontend/default-user.png" alt="User Picture" />
                  <?}else{?>
                    <img src="<?=base_url().$friend_data[0]->image?>" alt="User Picture" />
                    <?}?> -->
                  <div class="msg-bubble">
                    <div class="msg-info">
                      <div class="msg-info-name"><?=$friend_data[0]->name?></div>
                      <div class="msg-info-time">12:45</div>
                    </div>
                    <div class="msg-text"><?=$display_chats->content?></div>
                  </div>
                </div>
              <?}?>
              <?}?>
            </main>

            <form class="msger-inputarea" action="javascript:;">
              <input type="hidden" id="friend_id" name="friend_id" value="<?=$friend_data[0]->id?>">
              <input type="text" class="msger-input" id="message" placeholder="Enter your message...">
              <button type="submit" class="msger-send-btn" onclick="send_message()">Send</button>
            </form>
          </section>
          <?}?>
      </div>
    </div>

    <section class="side-menu">
      <div class="side-menu__suggestions-section">
        <div class="side-menu__suggestions-header">
          <button>Inbox</button>
          <h2>Tap on username to start chatting</h2>
        </div>
        <br />
        <br />
        <div class="side-menu__suggestions-content">
          <?foreach($following as $sendmessage){
            $friend_foll = $this->db->get_where('tbl_users', array('id' => $sendmessage))->result();
            ?>
          <div class="side-menu__suggestion">
            <a href="#" class="side-menu__suggestion-avatar">
              <?if(empty($friend_foll[0]->image)){?>
              <img src="<?=base_url()?>assets/frontend/default-user.png" alt="User Picture" />
              <?}else{?>
                <img src="<?=base_url().$friend_foll[0]->image?>" alt="User Picture" />
                <?}?>                </a>
            <div class="side-menu__suggestion-info">
              <a href="<?=base_url()?>Home/inbox/<?=$friend_foll[0]->username?>"><?=$friend_foll[0]->username?></a>
              <span>Tap to start chatting</span>
            </div>
            <a href="<?=base_url()?>Home/inbox/<?=$friend_foll[0]->username?>">
              <button class="side-menu__suggestion-button" id="follow<?=$friend_foll[0]->id?>">Message</button>
            </a>
            </div>
          <?}?>
        </div>
      </div>

      <div class="side-menu__footer">
        <div class="side-menu__footer-links">
          <ul class="side-menu__footer-list">
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">About</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Help</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Press</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">API</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Jobs</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Privacy</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Terms</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Locations</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Top Accounts</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Hashtag</a>
            </li>
            <li class="side-menu__footer-item">
              <a class="side-menu__footer-link" href="#">Language</a>
            </li>
          </ul>
        </div>

        <span class="side-menu__footer-copyright"
          >&copy; 2021 instagram from thinkpad</span
        >
      </div>
    </section>
  </section>
</main>
<script>
setInterval(function () {$( ".refreshit" ).load(window.location.href + " .refreshit > *" )}, 1000);
</script>
