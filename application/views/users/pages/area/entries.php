                                        <style type="text/css">
                                        .scroll-table-list::-webkit-scrollbar {
                                            width: 6px;
                                        }
                                         
                                        .scroll-table-list::-webkit-scrollbar-track {
                                            -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
                                        }
                                         
                                        .scroll-table-list::-webkit-scrollbar-thumb {
                                          background-color: darkgrey;
                                          outline: 1px solid slategrey;
                                        }
                                        </style>


                                        <?php if( $this->session->userdata('user_level') != 3 ) { ?>
                                        <!--div class="text-right">
                                            <a href="<?php echo base_url( 'user/area/' . $data['id']  ); ?>" class="btn btn-primary">BACK</a>
                                        </div-->
                                        <?php } else { ?>
                                        <!--div class="text-right">
                                            <a href="<?php echo base_url('user/my-area/'); ?>" class="btn btn-primary">BACK</a>
                                        </div -->
                                        <?php } ?>

                                        <br>
                                        <!-- <form action="" ng-submit="submitFileUpload()" method="post" enctype="multipart/form-data"> -->
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="file" name="file_data" ng-model="file_data" class="form-control" onchange="angular.element(this).scope().uploadFile(this.files, <?php echo isset($param_id) ? $param_id : '' ?>)" multiple/>
                                            </div>
                                        </div>

                                        <div class="text-left">
                                            <button ng-click="submitFileUpload(<?php echo isset($param_id)?$param_id:0; ?>)" class="btn btn-primary">UPLOAD</button>
                                            <span class="pull-right" style="position: relative;">
                                                <a style="cursor:pointer" ng-click="clearSearch()" class="btn bg-red waves-effect btn-sm" id="btn-copy">
                                                    Clear
                                                </a>
                                                <a style="cursor:pointer" ng-click="dispayAllAvailableFiles()" class="btn bg-cyan waves-effect btn-sm" >
                                                    Display Available Results
                                                </a>
                                            </span>
                                        </div>

                                        <hr>

                                        <!-- SUGGESTED FILES -->
                                        <div ng-init="getParameterFiles(<?php echo isset($param_id)?$param_id:0; ?>)">
                                            <div>
                                                <div class="header">
                                                    <div class="row">
                                                        <div class="col-sm-5" style="margin: 0;">
                                                            <h2 class="col-pink" style=" position: relative;top: 30px;">
                                                                RELATED UPLOADS 
                                                            </h2>
                                                        </div>
                                                        <div class="col-sm-7 text-right" style="margin: 0;">
                                                            <form ng-submit="searchRelatedFiles()">
                                                                <div class="input-group" style="margin: 0;position: relative;top: 20px;">
                                                                    <div class="form-line">
                                                                        <input type="text" class="form-control date" ng-model="searchQuery" placeholder="Search Related files" required>
                                                                    </div>
                                                                   <span class="input-group-addon">
                                                                        <button type="submit" style="cursor:pointer" class="btn btn-default">
                                                                            <div class="demo-google-material-icon"> 
                                                                                <i class="material-icons">search</i> 
                                                                                <span class="icon-name" style="position: relative;top: -3px">SEARCH</span>
                                                                            </div>
                                                                        </button>
                                                                    </span>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

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
                                                
                                                <div class="scroll-table-list" style="max-height:500px;overflow-y:scroll;">
                                                    <div class="body table-responsive" ng-if="related_file_count > 0">

                                                        <table class="table table-condensed table-hovered">
                                                            <thead>
                                                                <tr >
                                                                    <th>#</th>
                                                                    <th>FILENAME</th>
                                                                    <th>DESCRIPTION</th>
                                                                    <th>TAGS</th>
                                                                    <th>COURSE GROUP</th>
                                                                    <th style="width: 140px;" class="text-right">ACTIONS</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr ng-repeat="file in related_files" ng-if="(file.shared_status == 1) || (file.shared_status == 3 &&  <?php echo $this->session->userdata('course_id') ?> == file.course_id )" >
                                                                    <th scope="row">{{ $index+1 }}</th>
                                                                    <td>
                                                                        <span>{{file.filename | limitTo: 35}}</span>
                                                                        <span>{{file.filename.length > 35 ? '......' : ''}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{file.description | limitTo: 35}}</span>
                                                                        <span>{{file.description.length > 35 ? '......' : ''}}</span>
                                                                    </td>
                                                                    <td>
                                                                        <span ng-repeat="tag in extractTag(file.tags)" class="label {{ randomColor() }}" ng-bind="tag" style="margin-right:5px;"></span>
                                                                    </td>
                                                                    <td>
                                                                        <span>{{ file.course_name }}</span>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <a href="/uploads/{{ file.filename }}" download="{{ file.filename }}" class="btn bg-cyan waves-effect" title="Download File">
                                                                            <i class="material-icons">file_download</i>
                                                                        </a>
                                                                        <a style="cursor:pointer" ng-click="copyFile(file,<?php echo isset($param_id)?$param_id:0; ?>)" class="btn bg-blue waves-effect" title="Copy File">
                                                                            <i class="material-icons">content_copy</i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                            <tbody hidden="">
                                                                <tr ng-repeat="file in related_files  |  groupBy :'upload_id'" ng-if="(file[0].shared_status == 1) || (file[0].shared_status == 3 &&  <?php echo $this->session->userdata('course_id') ?> == file[0].course_id )" >
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
                                                                        <span ng-repeat="tag in extractTag(file[0].tags)" class="label {{ randomColor() }}" ng-bind="tag" style="margin-right:5px;"></span>
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
                                                <br>
                                                <br>
                                                <br>
                                            </div>
                                        </div>


                                        <!-- ALL FILES -->
                                        <div ng-init="getParameterFiles(<?php echo isset($param_id)?$param_id:0; ?>)">
                                            <div class="header"><h2>UPLOADED FILES</h2></div>

                                            <div class="scroll-table-list" style="max-height:500px;overflow-y:scroll;">
                                                <div class="body table-responsive">
                                                    <table class="table table-condensed table-hovered">
                                                        <thead>
                                                            <tr >
                                                                <th>#</th>
                                                                <th>FILENAME</th>
                                                                <th>DESCRIPTION</th>
                                                                <th>TAGS</th>
                                                                <th style="width: 200px;" class="text-right">ACTIONS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="file in parameter_files  track by $index" class="row-file-{{ file.id }}" >
                                                                <th scope="row">{{ $index+1 }}</th>
                                                                <td>
                                                                    <span>{{file.filename | limitTo: 35}}</span>
                                                                    <span>{{file.filename.length > 35 ? '......' : ''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span>{{file.description | limitTo: 35}}</span>
                                                                    <span>{{file.description.length > 35 ? '......' : ''}}</span>
                                                                </td>
                                                                <td>
                                                                    <span ng-repeat="tag in extractTag(file.tags)" class="label {{ randomColor() }}" ng-bind="tag" style="margin-right:5px;"></span>
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

