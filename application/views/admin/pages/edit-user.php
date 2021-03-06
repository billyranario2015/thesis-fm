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

                <?php if ( $this->session->userdata('message') ) { ?>
                <br>
                <div class="alert alert-info">
                    <?php echo $this->session->flashdata('message'); ?>
                </div>
                <?php } ?>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                UPDATE USER
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form method="POST" action="<?php echo base_url('user/update') ?>">
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">First Name</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="hidden" name="id" value="<?php echo $data['id'] ?>" class="form-control">
                                            <input type="text" name="fname" value="<?php echo $data['fname'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Middle Name</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="mname" value="<?php echo $data['mname'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Last Name</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="lname" value="<?php echo $data['lname'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <?php if ( ($this->session->userdata('user_level') == 1)  || ($this->session->userdata('user_level') == 2) && $hide_fields == 0 ) { ?>
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Select Course</h2>
                                    <div class="form-group form-float form-group-md">
                                        <select class="form-control show-tick selectpicker" name="course_id">
                                            <?php foreach ($courses as $key => $course) { ?>
                                                <option value="<?php echo $course['course_id']; ?>" <?php if ( $data['course_id'] == $course['course_id'] ) echo 'selected' ?>>
                                                    <?php echo $course['course_name'] . ' (' . $course['organization_name']. ')'  ; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if ( ($this->session->userdata('user_level') == 1)  || ($this->session->userdata('user_level') == 2) && $hide_fields == 0 ) { ?>
                                <div class="col-sm-6">
                                    <h2 class="card-inside-title">Role/Position</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="role" value="<?php echo $data['role'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div> 
                                <?php } ?>

                                <div class="col-sm-6">
                                    <h2 class="card-inside-title">User Level</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <select class="form-control show-tick selectpicker" name="user_level" required>
                                                <option value="1" disabled>Superadmin</option>
                                                <option value="2" <?php if ( $data['user_level'] == 2 ) echo 'selected' ?>>Admin</option>
                                                <option value="5" <?php if ( $data['user_level'] == 5 ) echo 'selected' ?>>Over All Chairman</option>
                                                <option value="4" <?php if ( $data['user_level'] == 4 ) echo 'selected' ?>>In-house Evaluator</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Email</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="email" value="<?php echo $data['email'] ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h2 class="card-inside-title">Password</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h2 class="card-inside-title">Confirm Password</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="password" name="confirm_password" class="form-control">
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