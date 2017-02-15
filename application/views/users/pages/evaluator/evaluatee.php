<?php $this->load->view('header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ENTRY CONTENTS FROM <span class="font-bold col-pink" style="text-transform:uppercase;"><?php echo $chairman_info['fname']. ' ' .$chairman_info['lname'] ?></span>
                                <!-- <small>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small> -->

                                <a href="/evaluator/dashboard" class="btn btn-primary waves-effect btn-lg pull-right" style="position: relative;top: -8px;">
                                    BACK
                                </a>
                            </h2>
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
                                            <a href="<?php echo base_url('evaluator/user/'.$chairman_info['id'].'/area/'.$area['area_id']) ?>" class="btn bg-blue waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <!-- <a href="#" ng-click="deleteArea(<?php echo $area['area_id']; ?>)" class="btn bg-pink waves-effect">
                                                <i class="material-icons">delete_sweep</i>
                                            </a> &nbsp; -->
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