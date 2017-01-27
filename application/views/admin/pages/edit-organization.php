<?php $this->load->view('header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ORGANIZATIONS</h2>

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
                                EDIT ORGANIZATION
                            </h2>

                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url( 'organization/' .$data['id']. '/delete' ); ?>" class=" waves-effect waves-block">Delete Organization</a></li>
                                    </ul>
                                </li>
                            </ul>

                        </div>
                        <div class="body table-responsive">
                            <form method="POST" action="<?php echo base_url('organization/update') ?>">
                                <div class="col-sm-12">
                                    <div class="form-group form-float form-group-lg">
                                        <div class="form-line focused">
                                            <input type="hidden" name="id" value="<?php echo $data['id']; ?>" class="form-control">
                                            <input type="text" name="organization_name" value="<?php echo $data['organization_name']; ?>" class="form-control">
                                            <label class="form-label">Organization Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success btn-lg waves-effect">UPDATE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>