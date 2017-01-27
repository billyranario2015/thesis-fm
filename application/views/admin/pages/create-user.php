<?php $this->load->view('header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>USER</h2>

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
                                CREATE NEW USER
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form method="POST" action="<?php echo base_url('user/create') ?>">
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">First Name</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="fname" value="<?php echo $this->session->flashdata('fname') ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Middle Name</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="mname" value="<?php echo $this->session->flashdata('mname') ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <h2 class="card-inside-title">Last Name</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="lname" value="<?php echo $this->session->flashdata('lname') ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Select Course</h2>
                                    <div class="form-group form-float form-group-md">
                                        <select class="form-control show-tick selectpicker" name="course_id">
                                            <?php foreach ($courses as $key => $course) { ?>
                                                <option value="<?php echo $course['course_id']; ?>" <?php if ( $this->session->flashdata('course_id') == $course['course_id'] ) echo 'selected' ?>>
                                                    <?php echo $course['course_name'] . ' (' . $course['organization_name']. ')'  ; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h2 class="card-inside-title">Role/Position</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="role" value="<?php echo $this->session->flashdata('role') ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>  
                                <div class="col-sm-6">
                                    <h2 class="card-inside-title">User Level</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <select class="form-control show-tick selectpicker" name="user_level" required>
                                                <option value="1" disabled>Superadmin</option>
                                                <option value="2" <?php if ( $this->session->flashdata('user_level') == 2 ) echo 'selected' ?>>Admin</option>
                                                <option value="3" <?php if ( $this->session->flashdata('user_level') == 3 ) echo 'selected' ?>>User</option>
                                                <option value="4" <?php if ( $this->session->flashdata('user_level') == 4 ) echo 'selected' ?>>Guest</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>          
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Email</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="email" value="<?php echo $this->session->flashdata('email') ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h2 class="card-inside-title">Password</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h2 class="card-inside-title">Confirm Password</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="password" name="confirm_password" class="form-control" required>
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