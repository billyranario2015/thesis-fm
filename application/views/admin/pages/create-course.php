<?php $this->load->view('header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>COURSES</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CREATE COURSE
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form method="POST" action="<?php echo base_url('course/create') ?>">
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Course Name</h2>
                                    <div class="form-group form-float form-group-md">
                                        <div class="form-line">
                                            <input type="text" name="course_name" value="<?php echo $this->session->flashdata('course_name') ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <h2 class="card-inside-title">Select Organization</h2>
                                    <div class="form-group form-float form-group-md">
                                        <select class="form-control show-tick selectpicker" name="organization_id" required>
                                            <?php foreach ($orgs as $key => $org) { ?>
                                                <option value="<?php echo $org['id']; ?>" <?php if ( $this->session->flashdata('organization_id') == $org['id'] ) echo 'selected' ?>>
                                                    <?php echo $org['organization_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
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