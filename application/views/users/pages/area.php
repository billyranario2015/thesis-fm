<?php $this->load->view('header'); ?>
    <section class="content" ng-controller="AreasController">
        <div class="container-fluid">
            <div class="block-header">
                <?php if ( $this->session->flashdata('message') ) { ?>
                <br>
                <div class="alert alert-info">
                    <strong>Success!</strong>  <?php echo $this->session->flashdata('message'); ?>
                </div>
                <?php } ?> 
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LISTS OF AREAS
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url( 'user/create-area' ); ?>" class=" waves-effect waves-block">Add Area</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>AREA NAME</th>
                                        <th>ASSIGNED TO</th>
                                        <th class="text-right">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($areas as $key => $area) { ?>
                                    <tr id="area-<?php echo $area['area_id'] ?>">
                                        <th scope="row"><?php echo ++$key; ?></th>
                                        <td><?php echo $area['area_name'] ?></td>
                                        <td><?php echo $area['fname'] . ' ' . $area['lname']; ?></td>
                                        <td class="text-right">
                                            <a href="<?php echo base_url('user/area/'.$area['area_id'].'/edit') ?>" class="btn bg-blue waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="#" ng-click="deleteArea(<?php echo $area['area_id']; ?>)" class="btn bg-pink waves-effect">
                                                <i class="material-icons">delete_sweep</i>
                                            </a> &nbsp;
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>