<?php $this->load->view('header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>ORGANIZATIONS</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                CREATE NEW ORGANIZATION
                            </h2>
                        </div>
                        <div class="body table-responsive">
                            <form method="POST" action="<?php echo base_url('organization/create') ?>">
                                <div class="col-sm-12">
                                    <div class="form-group form-float form-group-lg">
                                        <div class="form-line">
                                            <input type="text" name="organization_name" class="form-control">
                                            <label class="form-label">Organization Name</label>
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