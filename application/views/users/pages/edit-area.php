<?php $this->load->view('header'); ?>
    <section class="content">
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
                                UPDATE AREA
                            </h2>
                        </div>
                        <div class="body table-responsive">
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>