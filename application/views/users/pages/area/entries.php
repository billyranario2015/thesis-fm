                                        <div class="text-right">
                                            <a href="<?php echo base_url( 'user/area/' . $data['id']  ); ?>" class="btn btn-primary">BACK</a>
                                        </div>
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
                                            <div ng-if="related_file_count > 0">
                                                <div class="header"><h2>RELATIVE UPLOADS</h2></div>
                                                <div ng-repeat="file in related_files  track by $index">
                                                    <pre>
                                                    {{ file.filename }}
                                                    </pre>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ALL FILES -->
                                        <div ng-init="getParameterFiles(<?php echo isset($param_id)?$param_id:0; ?>)">
                                            <div class="header"><h2>UPLOADED FILES</h2></div>
                                            <div ng-repeat="file in parameter_files  track by $index">
                                                {{ file.filename }}
                                            </div>
                                        </div>

                                        <!-- </form> -->
                                        <!-- <div class="form-group">
                                            <input id="input-702" name="file_data" type="file" multiple=true class="file-loading">
                                        </div> -->
