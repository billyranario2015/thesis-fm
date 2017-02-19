<?php $this->load->view('header'); ?>
    <section class="content" ng-controller="UsersController">
        <div class="container-fluid">
            <div class="block-header">
                <h2>USERS</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LISTS OF USERS
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url( 'user/create-user' ); ?>" class=" waves-effect waves-block">Add User</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>NAME</th>
                                        <th>ROLE</th>
                                        <th class="text-right">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $key => $user) { ?>
                                    <tr id="user-<?php echo $user['id']; ?>">
                                        <th scope="row"><?php echo ++$key; ?></th>
                                        <td><?php echo $user['fname'] . ' ' . $user['mname'] . ' ' . $user['lname'] ?></td>
                                        <td><b><?php echo $user['role']; ?></b></td>
                                        <td class="text-right">
                                            <?php if( $this->session->userdata('id') != $user['id'] ) { ?>
                                                <?php if ( $user['user_level'] != 4 ) { ?>
                                                    <a href="<?php echo base_url('user/'.$user['id'].'/edit') ?>" class="btn bg-blue waves-effect">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a href="#" ng-click="deleteUser(<?php echo $user['id']; ?>)" class="btn bg-pink waves-effect">
                                                        <i class="material-icons">delete_sweep</i>
                                                    </a> &nbsp;
                                                <?php } else { ?>
                                                    <b>It's the In-House Evaluator!</b>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <b>It's you!</b>
                                            <?php } ?>
                                        </td>
                                    </tr>
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