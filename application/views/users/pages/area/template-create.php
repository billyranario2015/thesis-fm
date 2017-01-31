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
                                            <h2 class="card-inside-title">Parameters</h2>
                                            <ul class="list-group">
                                                <li class="list-group-item" ng-repeat="list in parameters"><span ng-bind-html="list.parameter_name"></span></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn bg-cyan btn-lg waves-effect">NEXT</button>
                                        </div>
