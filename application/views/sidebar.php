     <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img src="<?php echo base_url('assets/admin/images/user.png') ?>" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata( 'fname' ) . ' ' . $this->session->userdata( 'lname' ); ?></div>
                    <div class="email"><?php echo $this->session->userdata( 'role' ) . ' - ' .$this->session->userdata( 'email' ); ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="javascript:void(0);"><i class="material-icons">person</i>Profile</a></li>
                            <li role="seperator" class="divider"></li>
                            <li><a href="javascript:void(0);"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->

            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
                    <li class="<?php if( $tpl == 'dashboard' ) echo 'active'; ?>">
                        <a href="<?php echo base_url( 'admin/dashboard' ); ?>">
                            <i class="material-icons">home</i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="<?php if( $tpl == 'organizations' ) echo 'active'; ?>">
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">widgets</i>
                            <span>Organizations</span>
                        </a>
                        <ul class="ml-menu">
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'organizations' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'admin/organizations' ); ?>">
                                    <span>All Organizations</span>
                                </a>
                            </li>
                            <li class="<?php if( isset($tpl2) && $tpl2 == 'create-organizations' ) echo 'active'; ?>">
                                <a href="<?php echo base_url( 'admin/create-organization' ); ?>">
                                    <span>New Organization</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">people</i>
                            <span>Users</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="javascript:void(0);">
                                    <span>All Users</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <span>New User</span>
                                </a>
                            </li>
                        </ul>
                    </li>
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