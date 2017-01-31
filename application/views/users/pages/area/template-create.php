                                       <style type="text/css">
                                           .input-group-addon:hover {
                                                cursor: pointer;
                                           }
                                           .demo-google-material-icon:hover * {
                                                color: #00BCD4 !important;
                                           }
                                       </style>

                                        <div class="text-right">
                                            <a href="<?php echo base_url( 'user/area/'.$data['id'] . '/templates' ); ?>" class="btn btn-primary">BACK</a>
                                        </div>
                                        <br>
                                        <form method="POST" action="<?php echo base_url('organization/create') ?>">
                                            <div class="col-sm-12">
                                                <h2 class="card-inside-title">Parameter Name</h2>
                                                <div class="input-group">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control date" ng-model="parameter.parameter_name" placeholder="Parameter Name">
                                                    </div>
                                                   <span class="input-group-addon">
                                                        <a style="cursor:pointer" ng-click="createParameter(<?php echo $data['id']; ?>,'parent')" class="btn btn-default">
                                                            <div class="demo-google-material-icon"> 
                                                                <i class="material-icons">add</i> 
                                                                <span class="icon-name" style="position: relative;top: -3px">ADD</span>
                                                            </div>
                                                        </a>
                                                    </span>
                                                </div>
                                                <h2 class="card-inside-title">Sub-Parameter</h2>
                                                <div class="form-group form-float form-group-md">
                                                    <div class="form-line">
                                                        <select class="form-control" ng-model="parameter.parent_id">
                                                            <option value="0">---- Select parent parameter (Leave this field if no parent) ----</option>
                                                            <option ng-repeat="list in parameters" value="{{ list.id }}">{{ list.parameter_name }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn bg-cyan btn-lg waves-effect">NEXT</button>
                                            </div>
                                        </form>