                                        <?php if( $this->session->userdata('user_level') != 3 ) { ?>
                                        <div class="text-right">
                                            <a href="<?php echo base_url( 'user/area/' . $data['id']  ); ?>" class="btn btn-primary">BACK</a>
                                        </div>
                                        <?php } else { ?>
                                        <div class="text-right">
                                            <a href="<?php echo base_url('user/my-area/'); ?>" class="btn btn-primary">BACK</a>
                                        </div>
                                        <?php } ?>

                                        <br>
                                        <!-- <form action="" ng-submit="submitFileUpload()" method="post" enctype="multipart/form-data"> -->
                                        <div class="form-group">
                                            <input type="file" name="file_data" ng-model="file_data" class="form-control" onchange="angular.element(this).scope().uploadFile(this.files, <?php echo isset($param_id) ? $param_id : '' ?>)" multiple/>
                                        </div>
                                        

                                        <div class="text-left">
                                            <button ng-click="submitFileUpload(<?php echo isset($param_id)?$param_id:0; ?>)" class="btn btn-primary">UPLOAD</button>
                                        </div>

                                        <hr>

                                        <!-- SUGGESTED FILES -->
                                        <div ng-init="getParameterFiles(<?php echo isset($param_id)?$param_id:0; ?>)">
                                            <div class="preloader pl-size-xl" ng-if="loader_search">
                                                <div class="spinner-layer">
                                                    <div class="circle-clipper left">
                                                        <div class="circle"></div>
                                                    </div>
                                                    <div class="circle-clipper right">
                                                        <div class="circle"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div ng-if="related_file_count > 0">
                                                <div class="header">
                                                    <h2 class="col-pink">
                                                        RELATED UPLOADS 
                                                        <span class="pull-right" style="position: relative;top: -15px;">
                                                            <a style="cursor:pointer" ng-click="clearSearch()" class="btn bg-blue waves-effect btn-lg" id="btn-copy">
                                                                Clear
                                                            </a>
                                                        </span>
                                                    </h2>
                                                </div>
                                                <div class="body table-responsive">
                                                    <table class="table table-condensed table-hovered">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>FILENAME</th>
                                                                <th>DESCRIPTION</th>
                                                                <th>COURSE GROUP</th>
                                                                <th class="text-right">ACTIONS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="file in related_files  |  groupBy :'upload_id'" ng-if="(file[0].shared_status == 1) || (file[0].shared_status == 3 &&  <?php echo $this->session->userdata('course_id') ?> == file[0].course_id )">
                                                                <th scope="row">{{ $index+1 }}</th>
                                                                <td>
                                                                    <span>{{file[0].filename | limitTo: 35}}</span>
                                                                    <span>{{file[0].filename.length > 35 ? '......' : ''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span>{{file[0].description | limitTo: 35}}</span>
                                                                    <span>{{file[0].description.length > 35 ? '......' : ''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span>{{ file[0].course_name }}</span>
                                                                </td>
                                                                <td class="text-right">
                                                                    <a href="/uploads/{{ file[0].filename }}" download="{{ file[0].filename }}" class="btn bg-cyan waves-effect">
                                                                        <i class="material-icons">file_download</i>
                                                                    </a>
                                                                    <!-- Default -->
                                                                    <a style="cursor:pointer" ng-click="copyFile(file[0],<?php echo isset($param_id)?$param_id:0; ?>)" class="btn bg-blue waves-effect btn-lg" id="btn-copy">
                                                                        Copy file
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


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

