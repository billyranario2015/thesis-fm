<?php 
    if ( empty($this->session->userdata('id')) && empty($this->session->userdata('is_logged_in')) ) {
        redirect( base_url('login') );
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Admin</title>
    <!-- Favicon-->
    <!-- <link rel="icon" href="../../favicon.ico" type="image/x-icon"> -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <!-- <link href="/assets/admin/MaterialDesign-Webfont-master/css/materialdesignicons.min.css" rel="stylesheet" type="text/css"> -->

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url('/assets/admin/plugins/bootstrap/css/bootstrap.css'); ?>" rel="stylesheet">
    
    <!-- Bootstrap Select Css -->
    <link href="<?php echo base_url('/assets/admin/plugins/bootstrap-select/css/bootstrap-select.css') ?>" rel="stylesheet" />

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url('/assets/admin/plugins/node-waves/waves.css'); ?>" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url('/assets/admin/plugins/animate-css/animate.css'); ?>" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="<?php echo base_url('/assets/admin/css/style.css'); ?>" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url('/assets/admin/css/themes/all-themes.css'); ?>" rel="stylesheet" />

    <!-- Dropzone -->
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url( 'assets/admin/plugins/dropzone/dropzone.css' ) ?>"> -->
    
    <!-- CUSTOM STYLESHEETS -->
    <?php echo isset( $styles ) ? $styles : ''; ?>
    
    <!-- Jquery Core Js -->
    <script src="<?php echo base_url( '/assets/admin/plugins/jquery/jquery.min.js' ); ?>"></script>
</head>

<body class="theme-red" ng-app="MUSTFM" ng-controller="MainController">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Please wait...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="START TYPING...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="<?php echo base_url( 'admin/dashboard' ) ?>">MUST - File Manager</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li class="hide"><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <!-- Notifications -->
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">notifications</i>
                            <span class="label-count" ng-if="notifications.length > 0" ng-bind="notifications.length"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <!-- IF CHAIRMAN -->
                                    <li ng-repeat="notif in notifications" ng-if="userdata.user_level == 2">
                                        <!-- 
                                            ===== SUBMISSION
                                         -->
                                        <a href="/goto/user/{{ notif.u_user_id }}/area?notification=seened&id={{notif.notification_id}}" ng-if="notif.notification_type == 2">
                                            <div class="icon-circle bg-light-green" ng-if="notif.notification_type == 2">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4 ng-if="notif.notification_type == 2">{{ notif.fname }} submitted an entry</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{ dateParser(notif.notification_created_at) | date: "MMM dd, yyyy ' ' hh:mma" : '+08' }}
                                                </p>
                                            </div>
                                        </a>
                                        <!-- 
                                            ===== COMMENTS
                                         -->
                                        <a href="/goto/user/{{ notif.u_user_id }}/area?notification=seened&id={{notif.notification_id}}" ng-if="notif.notification_type == 1">
                                            <div class="icon-circle bg-blue-grey" ng-if="notif.notification_type == 1">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4 ng-if="notif.notification_type == 1">{{ notif.fname }} commented on an entry</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{ dateParser(notif.notification_created_at) | date: "MMM dd, yyyy ' ' hh:mma" : '+08' }}
                                                </p>
                                            </div>
                                        </a>

                                        <!-- 
                                            ===== ENTRY STATUS
                                         -->
                                        <a href="/user/area?notification=seened&id={{notif.notification_id}}" ng-if="notif.notification_type == 3">
                                            <div class="icon-circle bg-green">
                                                <i class="material-icons">thumb_up</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4>{{ notif.fname }} updated your entry status</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{ dateParser(notif.notification_created_at) | date: "MMM dd, yyyy ' ' hh:mma" : '+08' }}
                                                </p>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- IF SUB-CHAIRMAN -->
                                    <li ng-repeat="notif in notifications" ng-if="userdata.user_level == 3">
                                        <a href="/user/area/{{ belongsToArea.id }}?notification=seened&id={{notif.notification_id}}" ng-if="notif.notification_type == 2">
                                            <div class="icon-circle bg-light-green" ng-if="notif.notification_type == 2">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4 ng-if="notif.notification_type == 2">{{ notif.fname }} submitted an entry</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{ dateParser(notif.notification_created_at) | date: "MMM dd, yyyy ' ' hh:mma" : '+08' }}
                                                </p>
                                            </div>
                                        </a>

                                        <a href="/user/area/{{ belongsToArea.id }}?notification=seened&id={{notif.notification_id}}#comments" ng-if="notif.notification_type == 1">
                                            <div class="icon-circle bg-blue-grey" ng-if="notif.notification_type == 1">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4 ng-if="notif.notification_type == 1">{{ notif.fname }} commented on an entry</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{ dateParser(notif.notification_created_at) | date: "MMM dd, yyyy ' ' hh:mma" : '+08' }}
                                                </p>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- IF IN-HOUSE EVALUATOR -->
                                    <li ng-repeat="notif in notifications" ng-if="userdata.user_level == 4">
                                        <a href="/evaluator/user/{{ notif.u_user_id }}/area/?notification=seened&id={{notif.notification_id}}" ng-if="notif.notification_type == 2">
                                            <div class="icon-circle bg-light-green" ng-if="notif.notification_type == 2">
                                                <i class="material-icons">mode_edit</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4 ng-if="notif.notification_type == 2">{{ notif.fname }} submitted an entry</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{ dateParser(notif.notification_created_at) | date: "MMM dd, yyyy ' ' hh:mma" : '+08' }}
                                                </p>
                                            </div>
                                        </a>

                                        <a href="/evaluator/user/{{ notif.u_user_id }}/area/?notification=seened&id={{notif.notification_id}}#comments" ng-if="notif.notification_type == 1">
                                            <div class="icon-circle bg-blue-grey" ng-if="notif.notification_type == 1">
                                                <i class="material-icons">comment</i>
                                            </div>
                                            <div class="menu-info">
                                                <h4 ng-if="notif.notification_type == 1">{{ notif.fname }} commented on an entry</h4>
                                                <p>
                                                    <i class="material-icons">access_time</i> {{ dateParser(notif.notification_created_at) | date: "MMM dd, yyyy ' ' hh:mma" : '+08' }}
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Notifications -->
                    <!-- Tasks -->
                    <li class="dropdown hide">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="material-icons">flag</i>
                            <span class="label-count">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">TASKS</li>
                            <li class="body">
                                <ul class="menu tasks">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Footer display issue
                                                <small>32%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Make new buttons
                                                <small>45%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Create new dashboard
                                                <small>54%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Solve transition issue
                                                <small>65%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <h4>
                                                Answer GitHub questions
                                                <small>92%</small>
                                            </h4>
                                            <div class="progress">
                                                <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Tasks</a>
                            </li>
                        </ul>
                    </li>
                    <!-- #END# Tasks -->
                    <li class="pull-right hide"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->

    <?php $this->load->view('sidebar'); ?>