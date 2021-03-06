                                        <!-- <div class="text-left">
                                            <a href="<?php echo base_url( 'user/area/'.$data['id'].'/template-create' ); ?>" class="btn btn-primary btn-lg">CREATE TEMPLATE</a>
                                        </div>
                                        <br>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Template</th>
                                                    <th class="text-right">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table> -->

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
                                            span.pull-right.action-icons {
                                                float: none !important;
                                                display: block;
                                                text-align: right;
                                            }
                                       </style>

                                        <!-- <div class="text-right">
                                            <a href="<?php echo base_url( 'user/area/'.$data['id'] . '/templates' ); ?>" class="btn btn-primary">BACK</a>
                                        </div> -->
                                        <br>
                                        <?php if( $this->session->userdata('user_level') == 2 ){ ?>
                                        <div class="col-sm-12">
                                            <form ng-submit="createParameter(<?php echo $level_info['id']; ?>,<?php echo $data['id']; ?>)">
                                                <h2 class="card-inside-title">Select Parent Parameter</h2>
                                                <div class="form-group form-float form-group-md">
                                                    <div class="form-line">
                                                        <select class="form-control" ng-model="parameter.parent_id">
                                                            <option value="0">---- No Parent ----</option>
                                                            <option ng-repeat="list in parameters" value="{{ list.id }}">{{ list.parameter_name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <h2 class="card-inside-title">Set total documents to be uploaded 
                                                    <small>Default number of total files to be uploaded is <b>10</b></small>
                                                </h2>
                                                <div class="form-group">
                                                    <div class="form-line">
                                                        <input type="number" class="form-control date" ng-model="parameter.total_files" placeholder="Parameter Total Files" min="1">
                                                    </div>
                                                </div>
                                                <h2 class="card-inside-title">Parameter Name</h2>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control date" ng-model="parameter.parameter_name" placeholder="Parameter Name" required>
                                                    </div>
                                                   <span class="input-group-addon">
                                                        <button style="cursor:pointer" class="btn btn-default">
                                                            <div class="demo-google-material-icon"> 
                                                                <i class="material-icons">add</i> 
                                                                <span class="icon-name" style="position: relative;top: -3px">ADD</span>
                                                            </div>
                                                        </button>
                                                    </span>
                                                </div>
                                            </form>
                                            <hr style="border-top: 1px dashed #656565;margin-top: 45px;margin-bottom: 30px;">
                                        </div>
                                        <?php } ?>
                                        <div class="col-sm-12">
                                            <h2 class="card-inside-title">
                                                <span class="pull-left">Parameters</span>
                                                <span class="pull-right">
                                                    <?php if ( isset($_GET['action']) && $_GET['action'] == 'trash'  ) { ?>
                                                        <a href="<?php echo base_url('user/level/'.$level_info['id'].'/area/' . $data['id'] . '/edit' ); ?>">VIEW ALL</a> &nbsp;&nbsp;  |  &nbsp;&nbsp;
                                                        Trashed Parameters 
                                                    <?php } else { ?>
                                                        <a href="?action=trash">VIEW TRASH</a> &nbsp;&nbsp;  |  &nbsp;&nbsp;
                                                        No. of Completed Parameters <span class="text-success" ng-bind="completedParentParameters"></span> / <span class="text-success" ng-bind="totalParentParameters"></span>
                                                    <?php } ?>
                                                    
                                                </span>
                                                <div style="clear:both"></div>
                                            </h2>
                                            <ul class="list-group">
                                                <?php if ( isset($_GET['action']) && $_GET['action'] == 'trash'  ) { ?>
                                                <li ng-repeat="list in trashedCleanParameters" class="list-group-item item-paramater-{{list.id}} item-paramater-parent-{{list.parent_id}}">
                                                    <span ng-bind-html="list.parameter_name"></span>
                                                    
                                                    <span class="pull-right action-icons" style="margin-top: 15px;">

                                                        <div class="tags pull-left">
                                                            <span ng-repeat="tag in extractTag(list.tags) track by $index" class="label {{ randomColor() }}" ng-bind="tag" style="margin-right:5px;"></span>
                                                        </div>


                                                        <?php if( $this->session->userdata('user_level') == 2 ){ ?>
                                                        <a href="<?php  echo base_url( 'user/level/'.$level_info['id'].'/area/'.$data['id'] .'/parameter/{{list.id}}/restore' ) ?>" class="col-green" style="text-decoration: none;">
                                                           <i class="material-icons">restore</i>
                                                        </a>
                                                        <span class="col-pink" ng-click="delete_parameter(list)">
                                                           <i class="material-icons">delete_forever</i>
                                                        </span>
                                                        <?php } ?>

                                                        <div style="clear:both"></div>
                                                        <!-- parameter status -->

                                                        <!-- <span class="" ng-if="checkIfHasFiles(list) > 0" style="cursor:default">
                                                            <i class="material-icons text-success">check_circle</i> 
                                                        </span>
                                                        <span class="" title="In-completed" ng-if="checkIfHasFiles(list) == 0" style="cursor:default">
                                                            <i class="material-icons text-danger">not_interested</i> 
                                                        </span> -->
                                                    </span>
                                                </li>
                                                <?php } else {  ?>
                                                <li ng-repeat="list in cleanParameters" class="list-group-item item-paramater-{{list.id}} item-paramater-parent-{{list.parent_id}}">
                                                    <span ng-bind-html="list.parameter_name"></span>
                                                    <span class="pull-right action-icons" style="margin-top: 15px;">

                                                        <div class="tags pull-left">
                                                            <span ng-repeat="tag in extractTag(list.tags) track by $index" class="label {{ randomColor() }}" ng-bind="tag" style="margin-right:5px;"></span>
                                                        </div>

                                                        <span class="label bg-green" style="position: relative;bottom: 9px;cursor:default;margin-right: 5px;" ng-if="list.parameter_status == 'complete'">
                                                            Complete &nbsp; 
                                                            <span ng-if="list.child_param_count == 0 ">
                                                                {{ list.count_files }} / {{ list.total_files }}
                                                            </span>
                                                        </span>

                                                        <span class="label bg-red" style="position: relative;bottom: 9px;cursor:default;margin-right: 5px;" ng-if="list.parameter_status == 'incomplete'">
                                                            In-complete &nbsp; 
                                                            <span ng-if="list.child_param_count == 0 ">
                                                                {{ list.count_files }} / {{ list.total_files }}
                                                            </span>
                                                        </span>

                                                        
                                                        <a href="<?php  echo base_url( 'user/level/'.$level_info['id'].'/area/'.$data['id'] .'/parameter/{{list.id}}' ) ?>" class="col-green" style="text-decoration: none;">
                                                           <i class="material-icons">folder_shared</i>
                                                        </a>
                                                        <?php if( $this->session->userdata('user_level') == 2 ){ ?>
                                                        <span class="col-cyan" ng-click="edit_parameter(list)">
                                                           <i class="material-icons">mode_edit</i>
                                                        </span>
                                                        <span class="col-pink" ng-click="trash_parameter(list)">
                                                           <i class="material-icons">delete_forever</i>
                                                        </span>
                                                        <?php } ?>

                                                        <div style="clear:both"></div>
                                                        <!-- parameter status -->

                                                        <!-- <span class="" ng-if="checkIfHasFiles(list) > 0" style="cursor:default">
                                                            <i class="material-icons text-success">check_circle</i> 
                                                        </span>
                                                        <span class="" title="In-completed" ng-if="checkIfHasFiles(list) == 0" style="cursor:default">
                                                            <i class="material-icons text-danger">not_interested</i> 
                                                        </span> -->
                                                    </span>
                                                </li> 
                                                <?php }  ?>
                                            </ul>
                                        </div>
                                        <!-- <div class="col-sm-12">
                                            <a href="<?php echo base_url( 'user/area/' .$data['id'] . '/entries' ) ?>" class="btn bg-cyan btn-lg waves-effect">
                                                GO TO ENTRIES
                                            </a>
                                        </div> -->


                                        <div class="modal fade" id="modal-edit-parameter" tabindex="-1" role="dialog" ng-init=" parameter_edit.level_id = <?php if( !empty($level_info) ) echo $level_info['id']; ?>">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="defaultModalLabel">Edit Parameter</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                       <form ng-submit="updateParameter()">
                                                            <h2 class="card-inside-title">Select Parent Parameter</h2>
                                                            <div class="form-group form-float form-group-md">
                                                                <div class="form-line">
                                                                    <select class="form-control" ng-model="parameter_edit.parent_id">
                                                                        <option value="0">---- No Parent ----</option>
                                                                        <option ng-repeat="list in parameters" value="{{ list.id }}" ng-if="list.id != parameter_edit.id">{{ list.parameter_name }}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <h2 class="card-inside-title">Parameter Name</h2>
                                                            <div class="form-group form-float form-group-md">
                                                                <div class="form-line">
                                                                    <input type="text" class="form-control date" ng-model="parameter_edit.parameter_name" placeholder="Parameter Name" required>
                                                                </div>
                                                            </div>
                                                            <?php if ( $this->session->userdata('user_level') == 2 ) { ?>
                                                            <h2 class="card-inside-title">Set total documents to be uploaded 
                                                                <small>Default number of total files to be uploaded is <b>10</b></small>
                                                            </h2>
                                                            <div class="form-group">
                                                                <div class="form-line">
                                                                    <input type="number" class="form-control date" ng-model="parameter_edit.total_files" placeholder="Parameter Total Files" min="1">
                                                                </div>
                                                            </div>                                                                
                                                            <h2 class="card-inside-title">Tags <small>Separate tags by comma(,)</small></h2>
                                                            <div class="form-group form-float form-group-md">
                                                                <div class="form-line">
                                                                    <textarea class="form-control" ng-model="parameter_edit.tags"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="tags">
                                                                <span ng-repeat="tag in extractTag(parameter_edit.tags) track by $index" class="label {{ randomColor() }}" ng-bind="tag" style="margin-right:5px;"></span>
                                                            </div>
                                                            <?php } ?>
                                                       </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link waves-effect" ng-click="updateParameter()">SAVE CHANGES</button>
                                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>