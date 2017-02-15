<?php $this->load->view('header'); ?>
    <section class="content" ng-controller="AreasController">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?php echo $data['area_name'] . ' > <span class="font-bold col-pink">' . $param_info['parameter_name'] . '</span>' ?>
                                <small>ENTRY CONTENTS FROM <span class="font-bold col-pink" style="text-transform:uppercase;"><?php echo $chairman_info['fname']. ' ' .$chairman_info['lname'] ?></span></small>
                                <!-- <small>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small> -->

                                <a href="/evaluator/user/<?php echo $chairman_info['id'] ?>/area/<?php echo $area_id ?>" class="btn btn-primary waves-effect btn-lg pull-right" style="position: relative;top: -38px;">
                                    BACK    
                                </a>
                            </h2>
                        </div>
                        <div class="body">
                            <!-- ALL FILES -->
                            <div ng-init="getParameterFiles(<?php echo isset($param_id)?$param_id:0; ?>)">
                                <div class="header"><h2>UPLOADED FILES</h2></div>

                                <div class="body table-responsive">
                                    <table class="table table-condensed table-hovered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>FILENAME</th>
                                                <th>DESCRIPTION</th>
                                                <th class="text-right">ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="file in parameter_files  track by $index" class="row-file-{{ file.id }}">
                                                <th scope="row">{{ $index+1 }}</th>
                                                <td>
                                                    <span>{{file.filename | limitTo: 35}}</span>
                                                    <span>{{file.filename.length > 35 ? '......' : ''}}</span>
                                                </td>
                                                <td>
                                                    <span>{{file.description | limitTo: 35}}</span>
                                                    <span>{{file.description.length > 35 ? '......' : ''}}</span>
                                                </td>
                                                <td class="text-right">
                                                    <a href="/uploads/{{ file.filename }}" download="{{ file.filename }}" class="btn bg-cyan waves-effect">
                                                        <i class="material-icons">file_download</i>
                                                    </a>
                                                    <a style="cursor:pointer" ng-click="editFile(file)" class="btn bg-blue waves-effect" ng-if="file.author_id == <?php echo $this->session->userdata('id') ?>">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <a style="cursor:pointer" ng-click="deleteFile(file)" class="btn bg-pink waves-effect" ng-if="file.author_id == <?php echo $this->session->userdata('id') ?>">
                                                        <i class="material-icons">delete_sweep</i>
                                                    </a> &nbsp;
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>