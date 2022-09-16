
      <!-- 2-Role Footer -->
      <footer class="footer" role="contentinfo">
        <div class="footer-container">

          <nav class="footer-nav" role="navigation">
            <ul>
              <li><a href="">About Us</a></li>
              <li><a href="">Support</a></li>
              <li><a href="">Blog</a></li>
              <li><a href="">Press</a></li>
              <li><a href="">Api</a></li>
              <li><a href="">Jobs</a></li>
              <li><a href="">Privacy</a></li>
              <li><a href="">Terms</a></li>
              <li><a href="">Directory</a></li>
            </ul>
          </nav>

          <span class="footer-logo">&copy; 2022 Instagram</span>
        </div> <!-- Footer container end -->
      </footer>

    </section>
  </span> <!-- Root -->

  <!-- Select Link -->
  <script type="text/javascript">
    function la(src) {
      window.location=src;
    }
  </script>
  <script src="<?=base_url()?>assets/frontend/notificatoin.js"></script>
  <script src="<?=base_url()?>assets/frontend/bootstrap-notify.min.js"></script>
  <script>
  //================================== NOTIFY  ======================================
$(document).ready(function() {
<?php if (!empty($this->session->flashdata('emessage'))) { ?>
 var fail_message = '<?php echo $this->session->flashdata('emessage')?>';
 notifyDark(fail_message);
<?php
$this->session->set_flashdata('emessage');
 } ?>

<?php  if (!empty($this->session->flashdata('validationemessage'))) {
        $valid_errors = $this->session->flashdata('validationemessage');
        $valid_errors = substr($valid_errors, 0, -1); ?>
notifyDark("<?=$valid_errors?>");
<?php
  $this->session->set_flashdata('emessage');
} ?>

<?php if (!empty($this->session->flashdata('smessage'))) { ?>
  var succ_message = '<?php echo $this->session->flashdata('smessage');?>';
  notifyDark(succ_message);
 <?php
$this->session->set_flashdata('smessage');
} ?>

});
  </script>
</body>
</html>
