<main class="main-container">
  <section class="content-container">
    <div class="content refreshit">
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
          <div class="side-menu__user-info" style="margin-top: 18px; margin-left: 30px;">
            <a href="javascript:;"><?=$user_data[0]->username?></a>
            <div class="row text-center" style="margin-top: 8px;">
              <div class="side-menu__user-info col-md-4">
                <a href="javascript:;"><?
                $posts = $this->db->get_where('tbl_posts', array('user_id' => $this->session->userdata('user_id')))->num_rows();
                echo $posts;
                ?></a>
                <span>Posts</span>
              </div>
              <div class="side-menu__user-info col-md-4">
                <a href="javascript:;"><? echo count(unserialize($user_data[0]->followers))?></a>
                <span>Followers</span>
              </div>
              <div class="side-menu__user-info col-md-4">
                <a href="javascript:;"><? echo count(unserialize($user_data[0]->following))?></a>
                <span>Following</span>
              </div>
            </div>
            <br />
              <div class="side-menu__user-info col-md-12">
              <span><?=$user_data[0]->name?></span>
              <span><?=$user_data[0]->username?></span>
              <span><?=$user_data[0]->bio?></span>
              </div>
              <div class="side-menu__user-info col-md-12">
                <button class="edit"  data-toggle="modal" data-target="#editProfile">Edit Profile</button>
              <button class="edit" style="background: grey; border: 1px solid grey;"><a href="<?=base_url()?>User/profile">View Posts</a></button>
              </div>
          </div>
        </div>
      </div>
      <div class="posts" style="flex-direction: row;">
        <!-- ============================================== -->
        <?foreach($posts_data->result() as $posts){
          $post_owner = $this->db->get_where('tbl_users', array('id' => $posts->user_id))->result();
          ?>
        <article class="post" style="max-width: 33.333333%;">
          <div class="post__header">
            <div class="post__profile">
              <a href="#" class="post__avatar">
                <?if(empty($post_owner[0]->image)){?>
                <img src="<?=base_url()?>assets/frontend/default-user.png" alt="User Picture" />
                <?}else{?>
                <img src="<?=base_url().$post_owner[0]->image?>" alt="User Picture" />
                  <?}?>
              </a>
              <a href="<?=base_url()?>Home/inbox/<?=$post_owner[0]->username?>" class="post__user"><?=$post_owner[0]->username?></a>
            </div>

            <button class="post__more-options">
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <circle
                  cx="6.5"
                  cy="11.5"
                  r="1.5"
                  fill="var(--text-dark)"
                />
                <circle cx="12" cy="11.5" r="1.5" fill="var(--text-dark)" />
                <circle
                  cx="17.5"
                  cy="11.5"
                  r="1.5"
                  fill="var(--text-dark)"
                />
              </svg>
            </button>
          </div>

          <div class="post__content">
            <div class="post__medias">
              <img
                class="post__media"
                src="<?=base_url().$posts->image?>"
                alt="Post Content"
              />
              <img
                class="post__media"
                src="<?=base_url()?>assets/frontend/insta-clone.png"
                alt="Post Content"
              />
              <img
                class="post__media"
                src="<?=base_url()?>assets/frontend/insta-clone.png"
                alt="Post Content"
              />
            </div>
          </div>

          <div class="post__footer">

            <div class="post__infos">

              <div class="post__description">
              </div>

              <span class="post__date-time"><?
              $source = date('d-m-Y H:i:s', $posts->date);
                 $date = new DateTime($source);
                 echo $date->format('F j, Y');
              ?>
              </span>
            </div>
          </div>
        </article>
        <?}?>
        <!-- ===================================================================================== -->
      </div>
    </div>
<!-- ===================================== EDIT PROFILE MODAL ================================================ -->
    <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="addStoryLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addStoryLabel">Edit Profile</h5>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button> -->
          </div>
          <form action="<?=base_url()?>User/edit_profile" method="POST" enctype="multipart/form-data">
          <div class="modal-body text-center">
            <div class="row">
              <div class="col-md-6">
                <?if(empty($user_data[0]->image)){?>
                <img src="<?=base_url()?>assets/frontend/default-user.png" id="edit_profile_image" />
                <?}else{?>
                  <img src="<?=base_url().$user_data[0]->image?>" id="edit_profile_image" />
                  <?}?>
                  <br />
                  <br />
                  <input type="file" accept="image/png, image/jpg, image/jpeg" class="form-control" name="image" id="uploadeditImage" />
              </div>
              <div class="col-md-6">
                <input type="text" name="username" value="<?=$user_data[0]->username?>" class="form-control" readonly required ><br />
                <input type="text" name="name" value="<?=$user_data[0]->name?>" class="form-control" required ><br />
                <textarea name="bio" id="Bio" class="form-control" style="height: 130px;" placeholder="Write about yourself..."><?=$user_data[0]->bio?></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
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
          <h2>Suggestions for You</h2>
          <button>See All</button>
        </div>
        <div class="side-menu__suggestions-content">
          <?foreach($sugestions_data->result() as $sugestions){?>
          <div class="side-menu__suggestion">
            <a href="#" class="side-menu__suggestion-avatar">
              <img src="<?=base_url()?>assets/frontend/default-user.png" alt="User Picture" />
            </a>
            <div class="side-menu__suggestion-info">
              <a href="#"><?=$sugestions->username?></a>
              <span>Followed by user1, user2 and 9 others</span>
            </div>
            <? $following = unserialize($user_data[0]->following);
            if(in_array($sugestions->id, $following)){
            ?>
            <button class="side-menu__suggestion-button" id="follow<?=$sugestions->id?>" onclick="unfollowPeople('<?=$sugestions->id?>')">Unfollow</button>
            <?}else{?>
            <button class="side-menu__suggestion-button" id="follow<?=$sugestions->id?>" onclick="followPeople('<?=$sugestions->id?>')">Follow</button>
              <?}?>
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
