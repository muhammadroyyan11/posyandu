<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
  <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
  <meta name="author" content="PIXINVENT">
  <title>Login Page</title>
  <link rel="apple-touch-icon" href="<?= base_url() ?>assets/app-assets/images/ico/apple-icon-120.png">
  <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>assets/app-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

  <!-- BEGIN: Vendor CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/vendors/css/vendors.min.css">
  <!-- END: Vendor CSS-->

  <!-- BEGIN: Theme CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/bootstrap-extended.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/colors.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/components.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/themes/dark-layout.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/themes/semi-dark-layout.css">

  <!-- BEGIN: Page CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/core/menu/menu-types/vertical-menu.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/core/colors/palette-gradient.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/app-assets/css/pages/authentication.css">
  <!-- END: Page CSS-->

  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/assets/css/style.css">
  <!-- END: Custom CSS-->

</head>
<!-- END: Head-->
<style>
    img {
        width: 30%;
        height: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
  <!-- BEGIN: Content-->
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">

        <section class="row flexbox-container">
          <div class="col-xl-8 col-11 d-flex justify-content-center">
            <div class="card bg-authentication rounded-0 mb-0">
              <div class="row m-0">
<!--                <div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">-->
<!--                  <img src="--><?php //= base_url() ?><!--assets/app-assets/images/pages/login.png" alt="branding logo">-->
<!--                </div>-->
                <div class="col-lg-12 col-12 p-0">
                  <div class="card rounded-0 mb-0 px-2">
                    <div class="card-header pb-1">
                      <div class="card-title">
                          <center><h4 class="mb-0" >Login</h4></center>
                      </div>
                    </div>
                      <center><p class="px-2">Desa Labuan Panimba Kec. Labuan Kab. Donggala</p></center>
                      <img src="<?= base_url()?>assets/img/logo.png" alt="Logo" >
                    <div class="card-content">
                      <div class="card-body pt-1">
                        <?= $this->session->flashdata('pesan'); ?>
                        <form class="pt-3" action="<?= site_url(LOGIN_ROUTE . "/action") ?>" id="form">
                          <fieldset class="form-label-group form-group position-relative has-icon-left">
                            <input type="hidden" name="token" class="form-control" value="<?= $this->session->token ?>">
                            <input type="text" class="form-control" id="user-name" placeholder="Email" id="email" name="email" required autocomplete="off">
                            <div class="form-control-position">
                              <i class="feather icon-user"></i>
                            </div>
                            <label for="user-name">Username</label>
                          </fieldset>
                          <fieldset class="form-label-group position-relative has-icon-left">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required autocomplete="off">
                            <div class="form-control-position">
                              <i class="feather icon-lock"></i>
                            </div>
                            <label for="user-password">Password</label>
                          </fieldset>
                          <!-- <a href="<?= site_url('admin/auth/register') ?>" class="btn btn-outline-primary float-left btn-inline">Register</a> -->
                          <button type="submit" name="submit" id="submit" class="btn btn-primary float-right btn-inline">Login</button>
                        </form>
                      </div>
                    </div>
                    <div class="login-footer">
                      <div class="divider">
                        <div class="divider-text">&copy; Posyandu Kabupaten Dongala</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- END: Content-->



  <!-- BEGIN: Vendor JS-->
  <script src="<?= base_url() ?>assets/app-assets/vendors/js/vendors.min.js"></script>
  <!-- BEGIN Vendor JS-->

  <!-- BEGIN: Page Vendor JS-->
  <!-- END: Page Vendor JS-->

  <!-- BEGIN: Theme JS-->
  <script src="<?= base_url() ?>assets/app-assets/js/core/app-menu.js"></script>
  <script src="<?= base_url() ?>assets/app-assets/js/core/app.js"></script>
  <script src="<?= base_url() ?>assets/app-assets/js/scripts/components.js"></script>
  <script src="<?= base_url() ?>_temp/backend/vendors/sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url() ?>_temp/backend/vendors/js/vendor.bundle.base.js"></script>
  <script src="<?= base_url() ?>_temp/backend/js/off-canvas.js"></script>
  <script src="<?= base_url() ?>_temp/backend/js/hoverable-collapse.js"></script>
  <script src="<?= base_url() ?>_temp/backend/js/template.js"></script>
  <script src="<?= base_url() ?>_temp/backend/js/settings.js"></script>
  <script src="<?= base_url() ?>_temp/backend/js/todolist.js"></script>
  <script src="<?= base_url() ?>_temp/backend/vendors/sweetalert/sweetalert.min.js"></script>
  <!-- END: Theme JS-->



  <script type="text/javascript">
    $("#form").submit(function(e) {
      e.preventDefault();
      var me = $(this);
      $("#submit").prop('disabled', true).html('Loading...');
      $(".form-group").find('.text-danger').remove();
      $.ajax({
        url: me.attr('action'),
        type: 'post',
        data: new FormData(this),
        contentType: false,
        cache: false,
        dataType: 'JSON',
        processData: false,
        success: function(json) {
          if (json.success == true) {
            if (json.valid == true) {
              window.location.href = json.url;
            } else {
              $("#submit").prop('disabled', false)
                .html('LOGIN');
              $("input[type=password]").val("");
              swal({
                icon: 'error',
                title: 'Info',
                text: 'Username Atau Password Salah.',
                button: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "btn btn-primary"
                }
              });
              $('input[name="token"]').val(json.token);
            }
          } else {
            $("#submit").prop('disabled', false)
              .html('Log In');
            $.each(json.alert, function(key, value) {
              var element = $('#' + key);
              $(element)
                .closest('.form-group')
                .find('.text-danger').remove();
              $(element).after(value);
            });
          }
        }
      });
    });
  </script>

  <!-- BEGIN: Page JS-->
  <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>