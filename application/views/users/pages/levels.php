<?php $this->load->view('header'); ?>
    <section class="content" ng-controller="AreasController">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LISTS OF LEVELS
                            </h2>
                            <?php if( $this->session->userdata( 'user_level' ) == 2 ) { ?>                            
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url( 'user/create-level' ); ?>" class=" waves-effect waves-block">Add Level</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <?php } ?>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>LEVEL NAME</th>
                                        <th class="text-right">
                                            <?php if ( isset($_GET['action']) && $_GET['action'] == 'trash'  ) { ?>
                                                <a href="<?php echo base_url('user/levels'); ?>">VIEW ALL</a> 
                                            <?php } else { ?>
                                                <a href="?action=trash">VIEW TRASH</a> 
                                            <?php } ?>
                                            | ACTION
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ( isset($_GET['action']) && $_GET['action'] == 'trash'  ) { ?>
                                        <?php foreach ($trash as $key => $level) { ?>
                                        <tr id="level_id-<?php echo $level['id']; ?>">
                                            <td><?php echo ++$key; ?></td>
                                            <td><?php echo $level['level_name']; ?></td>
                                            <td class="text-right">

                                                <?php if( $this->session->userdata( 'user_level' ) == 2 ) { ?> 
                                                <a href="<?php echo base_url('user/level/'.$level['id'].'/restore') ?>" title="Restore Level" class="btn bg-green waves-effect">
                                                    <i class="material-icons">restore</i>
                                                </a>

                                                <!-- DELETE PERMANENTLY -->
                                                <a href="#" ng-click="deleteLevel(<?php echo $level['id']; ?>)" title="Delete Permanently" class="btn bg-red waves-effect">
                                                    <i class="material-icons">delete_sweep</i>
                                                </a> &nbsp;
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } else { ?> 
                                        <?php foreach ($levels as $key => $level) { ?>
                                        <tr id="level_id-<?php echo $level['id']; ?>">
                                            <td><?php echo ++$key; ?></td>
                                            <td><?php echo $level['level_name']; ?></td>
                                            <td class="text-right">

                                                <a href="<?php echo base_url('user/level/'.$level['id'].'/areas') ?>" class="btn bg-green waves-effect" title="View Contents">
                                                    <i class="material-icons">link</i>
                                                </a>

                                                <?php if( $this->session->userdata( 'user_level' ) == 2 ) { ?> 
                                                <a href="<?php echo base_url('user/level/'.$level['id'].'/edit') ?>" class="btn bg-blue waves-effect">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                <a href="#" ng-click="trashLevel(<?php echo $level['id']; ?>)" class="btn bg-pink waves-effect">
                                                    <i class="material-icons">delete_sweep</i>
                                                </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>


                        <div class="col-xs-12">
                            <?php if ( $this->session->flashdata('message') ) { ?>
                            <div class="alert alert-info">
                                <strong>Success!</strong>  <?php echo $this->session->flashdata('message'); ?>
                            </div>
                            <?php } ?> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>