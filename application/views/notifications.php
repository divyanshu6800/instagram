<main class="main-container">
  <section class="content-container">
    <div class="content refreshit">
      --
      <div class="stories">
        <div class="stories__content">
          <button class="story story--has-story" data-toggle="modal" data-target="#addStory">
            <div class="story__avatar">
              <div class="story__border">
                <svg
                  width="64"
                  height="64"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <circle r="31" cy="32" cx="32" />
                  <defs>
                    <linearGradient
                      y2="0"
                      x2="1"
                      y1="1"
                      x1="0"
                      id="--story-gradient"
                    >
                      <stop offset="0" stop-color="#f09433" />
                      <stop offset="0.25" stop-color="#e6683c" />
                      <stop offset="0.5" stop-color="#dc2743" />
                      <stop offset="0.75" stop-color="#cc2366" />
                      <stop offset="1" stop-color="#bc1888" />
                    </linearGradient>
                  </defs>
                </svg>
              </div>
              <div class="story__picture">
                <?if(empty($user_data[0]->image)){?>
                <img src="<?=base_url()?>assets/frontend/default-user.png" alt="User Picture" />
                <?}else{?>
                <img src="<?=base_url().$user_data[0]->image?>" alt="User Picture" />
                  <?}?>
              </div>
            </div>
          </button>
        </div>
      </div>
    </div>

    <section class="side-menu">
      <div class="side-menu__user-profile">
        <a
          href="javascript:;"
          target="_blank"
          class="side-menu__user-avatar"
        >
          <?if(empty($user_data[0]->image)){?>
          <img src="<?=base_url()?>assets/frontend/default-user.png" alt="User Picture" />
          <?}else{?>
          <img src="<?=base_url().$user_data[0]->image?>" alt="User Picture" />
            <?}?>
        </a>
        <div class="side-menu__user-info">
          <a href="<?=base_url()?>User/profile"><?=$user_data[0]->username?></a>
          <span><?=$user_data[0]->name?></span>
        </div>
        <a href="<?=base_url()?>User/logout"><button class="side-menu__user-button">Logout</button></a>
      </div>

      <div class="side-menu__suggestions-section">
        <div class="side-menu__suggestions-header">
          <h2>Friend Requests</h2>
          <button>See All</button>
        </div>
        <div class="side-menu__suggestions-content">
          <?foreach($requests as $fr_req){
            $requester = $this->db->get_where('tbl_users', array('id' => $fr_req))->result();
            ?>
          <div class="side-menu__suggestion">
            <a href="#" class="side-menu__suggestion-avatar">
              <img src="<?=base_url()?>assets/frontend/default-user.png" alt="User Picture" />
            </a>
            <div class="side-menu__suggestion-info">
              <a href="#"><?=$requester[0]->username?></a>
              <span>Followed by user1, user2 and 9 others</span>
            </div>
            <button class="side-menu__suggestion-button" id="follow<?=$requester[0]->id?>" onclick="followPeople('<?=$requester[0]->id?>')">Accept</button>
            <button class="side-menu__suggestion-button" id="fllow<?=$requester[0]->id?>" onclick="unfollowPeople('<?=$requester[0]->id?>')">X</button>
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
