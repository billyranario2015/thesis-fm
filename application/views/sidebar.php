     <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url('profile/'.$this->session->userdata('profile_image')) ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span ng-bind="userdata.fname"></span>&nbsp;
                        <span ng-bind="userdata.lname"></span>
                    </div>
                    <div class="email">
                        <span ng-bind="userdata.role"></span>&nbsp; - &nbsp;
                        <span ng-bind="userdata.email"></span>
                    </div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <?php if ( $this->session->userdata( 'user_level' ) != 1 ) { ?>
                            <li><a href="<?php echo base_url('/profile/'.$this->session->userdata('id').'/edit'); ?>"><i class="material-icons">person</i>Profile</a></li>    
                            <?php } else { ?>
                            <li><a href="<?php echo base_url('/profile/'.$this->session->userdata('id').'/edit'); ?>"><i class="material-icons">person</i>Profile</a></li>
                            <?php } ?>
                            <li role="seperator" class="divider"></li>
                            <li><a href="<?php echo base_url('/logout'); ?>"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->

            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>

                    <!-- USER_LEVEL == 1 -->
                    <?php if( $this->session->userdata( 'user_level' ) == 1 ) { ?>
                    <!--li class="<?php if( isset( $tpl ) && $tpl == 'dashboard' ) echo 'active'; ?>">
                        <a href="<?php echo base_url( 'admin/dashboard' ); ?>">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li -->
                    
                    <li class="<?php if( isset( $tpl ) && $tpl == 'organizations' ) echo 'active'; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">widgets</i>
                            <span>Colleges</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'organizations' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'admin/organizations' ); ?>">
                                    <span>All Colleges</span>
                                </a>
                            </li>
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'create-organizations' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'admin/create-organization' ); ?>">
                                    <span>New College</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php if( isset( $tpl ) && $tpl == 'courses' ) echo 'active'; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">school</i>
                            <span>Programs</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'courses' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'admin/courses' ); ?>">
                                    <span>All Programs</span>
                                </a>
                            </li>
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'create-course' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'admin/create-course' ); ?>">
                                    <span>New Program</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="<?php if( isset( $tpl ) && $tpl == 'users' ) echo 'active'; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Users</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'users' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'admin/users' ); ?>">
                                    <span>All Users</span>
                                </a>
                            </li>
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'create-user' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'admin/create-user' ); ?>">
                                    <span>New User</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                     <!-- USER_LEVEL == 2 -->
                    <?php } elseif( $this->session->userdata( 'user_level' ) == 2 ) { ?>
                    <li class="<?php if( isset( $tpl ) && $tpl == 'dashboard' ) echo 'active'; ?>">
                        <a href="<?php echo base_url( 'user/dashboard' ); ?>">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="<?php if( isset( $tpl ) && $tpl == 'levels' ) echo 'active'; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">poll</i>
                            <span>Levels</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'level' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'user/levels' ); ?>">
                                    <span>All Levels</span>
                                </a>
                            </li>
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'create-level' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'user/create-level' ); ?>">
                                    <span>New Level</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                     <!-- USER_LEVEL == 3 -->
                    <?php } elseif( $this->session->userdata( 'user_level' ) == 3 ) { ?>
                    <li class="active">
                        <a href="<?php echo base_url( 'user/my-area' ); ?>">
                            <i class="material-icons">home</i>
                            <span>Assigned Areas</span>
                        </a>
                    </li>

                     <!-- USER_LEVEL == 4 -->
                    <?php } elseif( $this->session->userdata( 'user_level' ) == 4 ) { ?>
                    <li class="active">
                        <a href="<?php echo base_url( 'evaluator/dashboard/' ); ?>">
                            <i class="material-icons">home</i>
                            <span>Entries</span>
                        </a>
                    </li>

                     <!-- USER_LEVEL == 5 -->
                    <?php } elseif ( $this->session->userdata( 'user_level' ) == 5 ) { ?>
                    <li class="<?php if( isset( $tpl ) && $tpl == 'levels' ) echo 'active'; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">poll</i>
                            <span>Levels</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'level' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'user/levels' ); ?>">
                                    <span>All Levels</span>
                                </a>
                            </li>
                            <!--li class="<?php if( isset($tpl2) && $tpl2 == 'create-level' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'user/create-level' ); ?>">
                                    <span>New Level</span>
                                </a>
                            </li-->
                        </ul>
                    </li>                        
                    <li class="<?php if( isset( $tpl ) && $tpl == 'users' ) echo 'active'; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Users</span>
                        </a>

                        <ul class="ml-menu">
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'users' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'user/users' ); ?>">
                                    <span>All Users</span>
                                </a>
                            </li>
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'create-user' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'user/create-user' ); ?>">
                                    <span>New User</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- #Menu -->

            <!-- Footer -->
                <!-- <div class="legal">
                    <div class="copyright">
                        &copy; 2016 <a href="javascript:void(0);">AdminBSB - Material Design</a>.
                    </div>
                    <div class="version">
                        <b>Version: </b> 1.0.4
                    </div>
                </div> -->
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
    </section>        