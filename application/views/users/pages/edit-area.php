<?php $this->load->view('header'); ?>

    <section class="content" ng-controller="AreasController" ng-init="getParameters(<?php echo $data['id'] ?>);getCleanParameters(<?php echo $data['id'] ?>)">
        <div class="container-fluid">
            <div class="block-header">
                <?php if ( $this->session->flashdata('message') ) { ?>
                <br>
                <div class="alert alert-info">
                    <strong>Success!</strong>  <?php echo $this->session->flashdata('message'); ?>
                </div>
                <?php } ?> 
                <?php if ( $this->session->userdata('err_message') ) { ?>
                <br>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('err_message'); ?>
                </div>
                <?php } ?>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $data['area_name'] ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <li role="presentation" class="<?php if( $tab == 'templates' ) echo 'active'; ?>">
                                    <a href="<?php echo base_url('user/area/'.$data['id']) ?>">TEMPLATES</a>
                                </li>
                                <!-- <li role="presentation" class="">
                                    <a href="#profile" data-toggle="tab">PROFILE</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#messages" data-toggle="tab">MESSAGES</a>
                                </li> -->
                                <!-- <li role="presentation" class="<?php if( $tab == 'entries' ) echo 'active'; ?>">
                                    <a href="<?php echo base_url('user/area/'.$data['id'].'/entries') ?>">ENTRIES</a>
                                </li> -->
                                <li role="presentation" class="<?php if( $tab == 'settings' ) echo 'active'; ?>">
                                    <a href="<?php echo base_url('user/area/'.$data['id'].'/settings') ?>">SETTINGS</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content " style="overflow:hidden">
                                <div role="tabpanel" class="tab-pane <?php if( $tab == 'templates' ) echo 'active'; ?> fade in" id="templates">
                                    <div class="body table-responsive">
                                        <?php 
                                        if( $tab == 'templates' && $action == 'templates' ) { 
                                            $this->load->view( 'users/pages/area/templates' );
                                        } elseif( $tab == 'templates' && $action == 'template-create' ) {
                                            $this->load->view( 'users/pages/area/template-create' );
                                         } elseif( $tab == 'entries' && $action == 'entries' ) {
                                            $this->load->view( 'users/pages/area/entries' );
                                        }
                                        ?>
                                    </div>                                    
                                </div>
                                <div role="tabpanel" class="tab-pane <?php if( $tab == 'entries' ) echo 'active'; ?> fade in" id="entries">
                                    <?php $this->load->view( 'users/pages/area/entries' ); ?>
                                </div>
                                 <!--  <div role="tabpanel" class="tab-pane  fade" id="messages">
                                    <b>Message Content</b>
                                    <p>
                                        Lorem ipsum dolor sit amet, ut duo atqui exerci dicunt, ius impedit mediocritatem an. Pri ut tation electram moderatius.
                                        Per te suavitate democritum. Duis nemore probatus ne quo, ad liber essent aliquid
                                        pro. Et eos nusquam accumsan, vide mentitum fabellas ne est, eu munere gubergren
                                        sadipscing mel.
                                    </p>
                                </div> -->
                                <div role="tabpanel" class="tab-pane <?php if( $tab == 'settings' ) echo 'active'; ?> fade in" id="settings">
                                    <br>
                                    <form method="POST" action="<?php echo base_url('area/update') ?>">
                                        <div class="col-sm-12">
                                            <h2 class="card-inside-title">Area Name</h2>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" class="form-control">
                                                    <input type="text" name="area_name" value="<?php echo $data['area_name'] ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <h2 class="card-inside-title">Assign Area to:</h2>
                                            <div class="form-group form-float form-group-md">
                                                <div class="form-line">
                                                    <select class="form-control show-tick selectpicker" name="assignee_id" required>
                                                        <option value="">---- Select user to assign area ----</option>
                                                        <?php foreach ($users as $key => $user) { ?>
                                                        <option value="<?php echo $user['id']; ?>" <?php if( $data['assignee_id'] == $user['id'] ) echo "selected"; ?>>
                                                            <?php echo $user['fname'] . ' ' . $user['mname']; ?>
                                                        </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn bg-cyan btn-lg waves-effect">UPDATE</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>