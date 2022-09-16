/*!
 * bootstrap-notify.min.js
 * to include
 *
 * include jquery-cdn and notify.min.js in header
 *   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script src="<?=base_url()?>assets/frontend/js/bootstrap-notify.min.js"></script>
 *
 * include script in footer
 * <script src="<?=base_url()?>assets/frontend/js/bootstrap-notify.min.js"></script>
 * above script should be included at the end of footer
 */

      // ----------------------------SUCCESS ALERT----------------------------------------
      function notifySuccess(message){
        $.notify({
                  icon: 'bi-check-circle-fill',
                  // title: 'Alert!',
                  message: message
              },{
                  element: 'body',
                  position: null,
                  type: "success",
                  allow_dismiss: true,
                  newest_on_top: false,
                  showProgressbar: true,
                  placement: {
                      from: "top",
                      align: "right"
                  },
                  offset: 20,
                  spacing: 10,
                  z_index: 999999,
                  delay: 5000,
                  animate: {
                      enter: 'animated fadeInDown',
                      exit: 'animated fadeOutUp'
                  },
                  icon_type: 'class',
                  template: '<div data-notify="container" class=" mobalert col-xs-11 col-sm-3 alert alert-success  alert-dismissible fade show alert-{0} " role="alert">' +
                  '<button type="button" class="btn-close xcross" data-dismiss="alert" aria-label="Close">&times;</button>' +
                  '<span data-notify="icon"></span> ' +
                  '<span data-notify="title">{1}</span> ' +
                  '<span data-notify="message">{2}</span>' +
                  '<a href="{3}" target="{4}" data-notify="url"></a>' +
                  '</div>'
              });
      }

      // -----------------------------FAILURE ALERT--------------------------------------
      function notifyError(message){
        $.notify({
                    icon: 'bi-exclamation-octagon-fill',
                    // title: 'Alert!',
                    message: message
                },{
                    element: 'body',
                    position: null,
                    type: "danger",
                    allow_dismiss: true,
                    newest_on_top: false,
                    showProgressbar: true,
                    placement: {
                        from: "top",
                        align: "right"
                    },
                    offset: 20,
                    spacing: 10,
                    z_index: 999999,
                    delay: 5000,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    },
                    icon_type: 'class',
                    template: '<div data-notify="container" class=" mobalert col-xs-11 col-sm-3 alert alert-danger  alert-dismissible fade show alert-{0}  " role="alert">' +
                    '<button type="button" class="btn-close xcross" data-dismiss="alert" aria-label="Close">&times;</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
                });
      }


      // ----------------------------INSTAGRAM ALERT----------------------------------------
      function notifyDark(message){
        $.notify({
                  icon: 'bi-check-circle-fill',
                  // title: 'Alert!',
                  message: message
              },{
                  element: 'body',
                  position: null,
                  type: "dark",
                  allow_dismiss: true,
                  newest_on_top: false,
                  showProgressbar: true,
                  placement: {
                      from: "bottom",
                      align: "right"
                  },
                  offset: 20,
                  spacing: 10,
                  z_index: 9999999,
                  delay: 5000,
                  animate: {
                    enter: 'animated fadeOutUp',
                      exit: 'animated fadeInDown'
                  },
                  icon_type: 'class',
                  template: '<div data-notify="container" class=" mobalert col-xs-11 col-sm-3 alert alert-dark  alert-dismissible fade show alert-{0} " role="alert">' +
                  // '<button type="button" class="btn-close xcross" data-dismiss="alert" aria-label="Close">&times;</button>' +
                  '<span data-notify="icon"></span> ' +
                  '<span data-notify="title">{1}</span> ' +
                  '<span data-notify="message">{2}</span>' +
                  '<a href="{3}" target="{4}" data-notify="url"></a>' +
                  '</div>'
              });
      }
