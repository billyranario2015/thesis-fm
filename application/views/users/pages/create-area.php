<?php $this->load->view('header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
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
                                CREATE NEW AREA
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form method="POST" action="<?php echo base_url('area/create') ?>">
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Area Name</h2>
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="hidden" name="course_id" value="<?php echo $this->session->userdata('course_id'); ?>" class="form-control">
                                            <input type="text" name="area_name" class="form-control" required>
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
                                                    <?php if ( $user['user_level'] != 4 ) { ?>
                                                        <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . ' ' . $user['mname']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-sm-12">
                                    <h2 class="card-inside-title">Select Sub Users:</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <select class="form-control show-tick selectpicker" name="assignee_id" multiple>
                                                <option value="">---- Select sub-users to assign area ----</option>
                                                <?php foreach ($users as $key => $user) { ?>
                                                    <?php if ( $user['user_level'] != 4 ) { ?>
                                                        <option value="<?php echo $user['id']; ?>"><?php echo $user['fname'] . ' ' . $user['mname']; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
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