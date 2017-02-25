<?php $this->load->view('header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">

                <?php if ( $this->session->userdata('err_message') ) { ?>
                <br>
                <div class="alert alert-danger">
                    <strong>Oops!</strong>  <?php echo $this->session->flashdata('err_message'); ?>
                </div>
                <?php } ?>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CREATE NEW LEVEL
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form method="POST" action="<?php echo base_url('level/create') ?>">
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Level Name</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">

                                            <input type="hidden" name="course_id" value="<?php echo $this->session->userdata('course_id') ?>" class="form-control">
                                            <input type="text" name="level_name" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <button type="submit" class="btn bg-cyan btn-lg waves-effect">CREATE</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 
<?php $this->load->view('footer'); ?>