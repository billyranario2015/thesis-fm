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

                                        <div class="text-right">
                                            <a href="<?php echo base_url( 'user/area/'.$data['id'] . '/templates' ); ?>" class="btn btn-primary">BACK</a>
                                        </div>
                                        <br>
                                        <div class="col-sm-4">
                                            <form ng-submit="createParameter(<?php echo $data['id']; ?>)">
                                                <h2 class="card-inside-title">Select Parent Parameter</h2>
                                                <div class="form-group form-float form-group-md">
                                                    <div class="form-line">
                                                        <select class="form-control" ng-model="parameter.parent_id">
                                                            <option value="0">---- No Parent ----</option>
                                                            <option ng-repeat="list in parameters" value="{{ list.id }}">{{ list.parameter_name }}</option>
                                                        </select>
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
                                        </div>
                                        <div class="col-sm-8">
                                            <h2 class="card-inside-title">
                                                <span class="pull-left">Parameters</span>
                                                <span class="pull-right">
                                                   No. of Completed Parameters <span class="text-success" ng-bind="completedParentParameters"></span> / <span class="text-success" ng-bind="totalParentParameters"></span>
                                                </span>
                                                <div style="clear:both"></div>
                                            </h2>
                                            <ul class="list-group">
                                                <li ng-repeat="list in cleanParameters" class="list-group-item item-paramater-{{list.id}} item-paramater-parent-{{list.parent_id}}">
                                                    <span ng-bind-html="list.parameter_name"></span>
                                                    <span class="pull-right action-icons">
                                                        <span class="label bg-green" style="position: relative;bottom: 9px;cursor:default;margin-right: 5px;" ng-if="list.parameter_status == 'complete'">Complete</span>

                                                        <span class="label bg-red" style="position: relative;bottom: 9px;cursor:default;margin-right: 5px;" ng-if="list.parameter_status == 'incomplete'">In-complete</span>

                                                        <a href="<?php  echo base_url( 'user/area/' .$data['id'] . '/parameter/{{list.id}}' ) ?>" class="col-green" style="text-decoration: none;">
                                                           <i class="material-icons">folder_shared</i>
                                                        </a>
                                                        <span class="col-cyan" ng-click="edit_parameter(list)">
                                                           <i class="material-icons">mode_edit</i>
                                                        </span>
                                                        <span class="col-pink" ng-click="delete_parameter(list)">
                                                           <i class="material-icons">delete_forever</i>
                                                        </span>

                                                        <!-- parameter status -->

                                                        <!-- <span class="" ng-if="checkIfHasFiles(list) > 0" style="cursor:default">
                                                            <i class="material-icons text-success">check_circle</i> 
                                                        </span>
                                                        <span class="" title="In-completed" ng-if="checkIfHasFiles(list) == 0" style="cursor:default">
                                                            <i class="material-icons text-danger">not_interested</i> 
                                                        </span> -->
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- <div class="col-sm-12">
                                            <a href="<?php echo base_url( 'user/area/' .$data['id'] . '/entries' ) ?>" class="btn bg-cyan btn-lg waves-effect">
                                                GO TO ENTRIES
                                            </a>
                                        </div> -->


                                        <div class="modal fade" id="modal-edit-parameter" tabindex="-1" role="dialog">
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
                                                       </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-link waves-effect" ng-click="updateParameter()">SAVE CHANGES</button>
                                                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>