                                        <div class="text-right">
                                            <a href="<?php echo base_url( 'user/area/' . $data['id']  ); ?>" class="btn btn-primary">BACK</a>
                                        </div>
                                        <br>
                                        <!-- <form action="" ng-submit="submitFileUpload()" method="post" enctype="multipart/form-data"> -->
                                        <div class="form-group">
                                            <input type="file" name="file_data" class="form-control" onchange="angular.element(this).scope().uploadFile(this.files, <?php echo $param_id ?>)" multiple/>
                                        </div>
                                        <div class="text-left">
                                            <button ng-click="submitFileUpload(<?php echo $param_id ?>)" class="btn btn-primary">UPLOAD</button>
                                        </div>
                                        <!-- </form> -->
                                        <!-- <div class="form-group">
                                            <input id="input-702" name="file_data" type="file" multiple=true class="file-loading">
                                        </div> -->