<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
      if(!isset($title)) $title = "PT.PAL Help Desk";
      if(!isset($TAG)) $TAG = "laporan";
    ?>
    <title>{{$title}}</title>
    <!-- Bootstrap -->
    <link href="/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/build/css/custom.min.css" rel="stylesheet">
    @yield('style')
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title">
                <i class="fa fa-question-circle"></i>
                <span> 
                @if(session('role')=='intern')
                  PAL ADMIN
                @else
                  PAL HELPDESK
                @endif
                </span>
              </a>
            </div>

            <div class="clearfix"></div>
            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Menu</h3>
                <ul class="nav side-menu">
                  <li class="<?=$TAG=='laporan'?'active':''?>"><a href="{{route(session('role')=='intern'?'intern.laporan':'laporan')}}"><i class="fa fa-calendar-minus-o"></i> Laporan</a></li>
                  @if(session('role')=='intern')
                  <li class="<?=$TAG=='summary'?'active':''?>"><a href="{{route('intern.summary')}}"><i class="fa fa-area-chart"></i> Laporan Summary</a></li>
                  @endif
                  <li class="<?=$TAG=='pengumuman'?'active':''?>"><a href="{{route(session('role')=='intern'?'intern.pengumuman':'pengumuman')}}"><i class="fa fa-bullhorn"></i> Pengumuman</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                @if(session('role')=='intern')
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    Administrator
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="login.html"><i class="fa fa-gears pull-right"></i> Pengaturan</a></li>
                    <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
                @else
                <li data-toggle="modal" data-target="#login-modal"><a href="#"><i class="fa fa-sign-in"></i> Masuk </a></li>
                @endif
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        @yield('content')
        <!-- /page content -->
        @if(session('role')!='intern')
          <div id="login-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel2">Login Form</h4>
                </div>
                <div class="modal-body">
                  <form id="form-login" class="form-horizontal">
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input type="text" id="username-login" class="form-control has-feedback-left" placeholder="Username">
                      <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                      <input type="password" id="password-login" class="form-control has-feedback-left" placeholder="Password">
                      <span class="fa fa-asterisk form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-md-12">
                      <button type="submit" id="button-login" class="btn btn-primary btn-sm pull-right">Masuk</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
        @endif
        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="/vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <!--
    <script src="/vendors/Flot/jquery.flot.js"></script>
    <script src="/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="/vendors/Flot/jquery.flot.time.js"></script>
    <script src="/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="/vendors/Flot/jquery.flot.resize.js"></script>
    -->
    <!-- Flot plugins -->
    <!--
    <script src="/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="/vendors/flot.curvedlines/curvedLines.js"></script>
    -->
    <!-- DateJS -->
    <script src="/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <!--
    <script src="/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    -->
    <!-- bootstrap-daterangepicker -->
    <script src="/vendors/moment/min/moment.min.js"></script>
    <script src="/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="/build/js/custom.min.js"></script>
    @if(session('role')!='intern')
      <script type="text/javascript">
        $(function(){
          $("#menu_toggle").trigger( "click" );
          $("#menu_toggle").remove();
        });
        $("#form-login").submit(function(e){
          e.preventDefault();
          var username = $("#username-login").val().trim();
          var password = $("#password-login").val().trim();
          $("#button-login").addClass('disable');
          $.ajax({
            url:"{{route('login')}}",
            method:"POST",
            data:{username:username,password:password,_token:"{{csrf_token()}}"},
            success:function(res){
              $("#button-login").removeClass('disable');
              console.log(res);
            }
          });
        });
      </script>
    @endif
    @yield('scripts')
  </body>
</html>
