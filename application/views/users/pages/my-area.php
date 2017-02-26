<?php 
/*
| --------------------------------------------------------------------
|   FOR USER_LEVEL 3 ===> SUB CHAIRMAN
| --------------------------------------------------------------------
*/ 
?>

<?php $this->load->view('header'); ?>
    <style type="text/css">
       .input-group-addon:hover {
            cursor: pointer;
       }
       .demo-google-material-icon:hover * {
            color: #00BCD4 !important;
       }
       .list-group-item {
            float: left;
            width: 100%;
        }
       /* li.list-group-item span > span {
            display: inline-block;
            float: left;
        }
        li.list-group-item span > span. {
            margin-left: 15px;
            width: 90%;
        }*/
        .action-icons > span {
            cursor: pointer;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <?php if ( $this->session->flashdata('message') ) { ?>
                <br>
                <div class="alert alert-info">
                    <strong>Success!</strong>  <?php echo $this->session->flashdata('message'); ?>
                </div>
                <?php } ?> 
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
                            <h2>My Areas</h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>LEVEL NAME</th>
                                        <th>AREA NAME</th>
                                        <th>TYPE</th>
                                        <th class="text-right">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- FOR MAIN AREA ASSIGNED TO CURRENT SUB CHAIRMAN -->
                                    <?php if( count($data) > 0 ) { ?>
                                    <!--tr id="main-area">
                                        <th scope="row" style="vertical-align: middle;">1</th>
                                        <td  style="vertical-align: middle;"><?php echo $data['level_name'] ?></td>
                                        <td  style="vertical-align: middle;"><?php echo $data['area_name'] ?></td>
                                        <td  style="vertical-align: middle;"><b>MAIN</b></td>
                                        <td  style="vertical-align: middle;" class="text-right">
                                            <a href="<?php echo base_url('user/level/'.$data['level_id'].'/area/'.$data['area_area_id'].'/edit') ?>" class="btn bg-blue waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        </td>
                                    </tr-->
                                    <?php } ?>

                                    <!-- FOR ALL LINKED MAIN AREAS ASSIGNED TO CURRENT SUB CHAIRMAN -->
                                    <?php 
                                    foreach ($linked_areas as $key => $area) {  ?>
                                    <tr id="area" valign="middle">
                                        <th scope="row"><?php echo $area['level_name'] ?></th>
                                        <td  style="vertical-align: middle;"><?php echo $area['area_name'] ?></td>
                                        <td  style="vertical-align: middle;"><b class="label bg-green">MAIN</b></td>
                                        <td  style="vertical-align: middle;" class="text-right">
                                            <a href="<?php echo base_url('user/level/'.$area['level_id'].'/area/'.$area['area_area_id'].'/edit') ?>" class="btn bg-blue waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                        </td>
                                    </tr>                                        
                                    <?php } ?>

                                    <?php 
                                    foreach ($sub_areas as $key => $area) {  ?>
                                    <tr id="area" valign="middle">
                                        <th scope="row"><?php echo $area['level_name'] ?></th>
                                        <td  style="vertical-align: middle;"><?php echo $area['area_name'] ?></td>
                                        <td  style="vertical-align: middle;"><b class="label bg-orange">ASSOCIATE</b></td>
                                        <td  style="vertical-align: middle;" class="text-right">
                                            <a href="<?php echo base_url('user/level/'.$area['level_id'].'/area/'.$area['area_area_id'].'/edit') ?>" class="btn bg-blue waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
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