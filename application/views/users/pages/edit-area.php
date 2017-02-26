<?php $this->load->view('header'); ?>

    <section class="content" ng-controller="AreasController" ng-init="getParameters(<?php echo $data['id'] ?>);getCleanParameters(<?php echo $data['id'] ?>);getSubmissionStatus(<?php echo $data['id'] ?>)">
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
                            <h2>
                                <span class="text-success"><?php echo $level_info['level_name'] ?></span> > <?php echo $data['area_name']; ?>
                                <?php if( isset($param_info) ) echo ' > ' . $param_info['parameter_name'] ?>
                                

                                <?php if( isset($param_info) ) { ?>
                                    <a href="<?php echo base_url('user/level/'.$level_info['id'].'/area/'.$data['id'] . '/edit') ?>" class="btn btn-primary pull-right">BACK</a>
                                <?php } else { ?>
                                   <?php if( $this->session->userdata('user_level') != 3 ) { ?>
                                        <a href="<?php echo base_url('user/level/'.$level_info['id'].'/areas') ?>" class="btn btn-primary pull-right">BACK</a>
                                    <?php } ?>
                                <?php } ?>
                                

                                <?php if ($this->session->userdata('user_level') == 3 ) { ?>
                                <!-- NOT YET SUBMITTED -->
                                <button class="btn bg-deep-purple waves-effect btn-lg pull-right" style="position: relative;top: -8px;" 
                                    ng-click="submitToChairman(<?php echo $level_info['id'] ?>,<?php echo $data['id'] ?>)" ng-if="submission_count == 0">
                                        Submit Entries
                                </button>

                                <button class="btn bg-deep-purple waves-effect btn-lg pull-right" style="position: relative;top: -8px;" ng-if="submission_count > 0">
                                        <span ng-if="submission_data.submission_status != 1">Entry Submitted on {{ dateParser(submission_data.created_at) | date: "MMM dd, yyyy ' ' hh:mma" : '+08' }}</span>
                                        <span ng-if="submission_data.submission_status == 1">ENTRY APPROVED</span>
                                </button>
                                <!-- SUBMITTED -->
                                <?php } ?>
                            </h2>
                        </div>
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                                <?php if( $this->session->userdata('user_level') != 3 ) { ?>
                                <li role="presentation" class="<?php if( $tab == 'templates' ) echo 'active'; ?>">
                                    <a href="<?php echo base_url('user/level/'.$data['level_id'].'/area/'.$data['id'].'/edit') ?>">TEMPLATES</a>
                                </li>
                                <li role="presentation" class="<?php if( $tab == 'settings' ) echo 'active'; ?>">
                                    <a href="<?php echo base_url('user/level/'.$data['level_id'].'/area/'.$data['id'].'/settings') ?>">SETTINGS</a>
                                </li>
                                <?php } else { ?>
                                <li role="presentation" class="active">
                                    <a href="<?php echo base_url('user/my-area/') ?>">TEMPLATES</a>
                                </li>
                                <?php } ?>
                                
                                <!-- <li role="presentation" class="">
                                    <a href="#profile" data-toggle="tab">PROFILE</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#messages" data-toggle="tab">MESSAGES</a>
                                </li> -->
                                <!-- <li role="presentation" class="<?php if( $tab == 'entries' ) echo 'active'; ?>">
                                    <a href="<?php echo base_url('user/area/'.$data['id'].'/entries') ?>">ENTRIES</a>
                                </li> -->
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content " style="overflow:hidden">
                                <div role="tabpanel" class="tab-pane <?php if( $tab == 'templates' ) echo 'active'; ?> fade in" id="templates">
                                    <div class="body table-responsive">
                                        <?php 
                                        if( $tab == 'templates' && $action == 'templates' ) { 
                                            $this->load->view( 'users/pages/area/templates' );
                                        } elseif( $tab == 'templates' && $action == 'template-create' ) {
                                            $this->load->view( 'users/pages/area/template-create' );
                                         } elseif( $tab == 'entries' && $action == 'entries' ) {
                                            $this->load->view( 'users/pages/area/entries' );
                                        }
                                        ?>
                                    </div>                                    
                                </div>
                                <div role="tabpanel" class="tab-pane <?php if( $tab == 'entries' ) echo 'active'; ?> fade in" id="entries">
                                    <?php $this->load->view( 'users/pages/area/entries' ); ?>
                                </div>

                                <div role="tabpanel" class="tab-pane <?php if( $tab == 'settings' ) echo 'active'; ?> fade in" id="settings">
                                    <br>
                                    <form method="POST" action="<?php echo base_url('area/update') ?>">
                                        <div class="col-sm-12">
                                            <h2 class="card-inside-title">Area Name</h2>
                                            <div class="form-group form-float">
                                                <div class="form-line">
                                                    <input type="hidden" name="id" value="<?php echo $data['id'] ?>" class="form-control">
                                                    <input type="hidden" name="level_id" value="<?php echo $data['level_id'] ?>" class="form-control">
                                                    <input type="text" name="area_name" value="<?php echo $data['area_name'] ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <h2 class="card-inside-title">Assign Area to: </h2>
                                            <div class="form-group form-float form-group-md">
                                                <div class="form-line">
                                                    <select class="form-control show-tick selectpicker" name="assignee_id" required>
                                                        <option value="">---- Select user to assign area ----</option>
                                                        <?php foreach ($users as $key => $user) { ?>
                                                            <?php if( $user['user_level'] != 4 ) { ?>
                                                            <option value="<?php echo $user['id']; ?>" <?php if( $data['assignee_id'] == $user['id'] ) echo "selected"; ?>>
                                                                <?php echo $user['fname'] . ' ' . $user['mname']; ?>
                                                            </option>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <h2 class="card-inside-title">Select Sub-Users to manage this area: (Optional)</h2>
                                            <div class="form-group form-float form-group-md">
                                                <div class="form-line">
                                                    <select class="form-control show-tick selectpicker" name="sub_assignee_id[]" multiple>
                                                        <option value="">---- Select user to assign area ----</option>
                                                        <?php foreach ($users as $key => $user) { ?>
                                                            <?php if( $user['user_level'] != 4 ) { 
                                                                    if( $data['assignee_id'] != $user['id'] ) {
                                                                ?>

                                                                    <option value="<?php echo $user['id']; ?>" <?php 

                                                                        foreach ($sub_users as $key2 => $sub) {
                                                                            if ($sub['user_id'] == $user['id']) {
                                                                                echo 'selected';
                                                                            }
                                                                         } 

                                                                    ?>>
                                                                        <?php echo $user['fname'] . ' ' . $user['mname']; ?> 
                                                                        <?php if ( $data['assignee_id'] == $user['id'] ) echo '<b>(Main Area User)</b>'; ?>
                                                                    </option>
                                                                    <?php
                                                                    } 
                                                                  } ?>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn bg-cyan btn-lg waves-effect">UPDATE</button>
                                        </div>
                                        <div class="clearfix"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row clearfix" id="comments">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                COMMENTS                                
                            </h2>
                        </div>
                        <div class="body">  
                            <div class="comment-form-section">
                                <form ng-submit="addComment(1,<?php echo $data['id'] ?>)">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <!-- Comment Type: Area -->
                                            <textarea rows="3" class="form-control no-resize" ng-model="commentFields.comment" placeholder="Add comment..."></textarea>
                                        </div>
                                    </div>
                                    <button class="btn btn-default btn-lg">SUBMIT</button>
                                </form>
                            </div>
                            <br>
                            <br>
                            <br>
                            <div class="comments-section" ng-init="getComments(<?php echo $data['id'] ?>)">
                                <div class="media" ng-repeat="comment in comments">
                                    <div class="media-left">
                                        <a href="javascript:void(0);">
                                            <img class="media-object" ng-src="<?php echo base_url('profile') ?>/{{ comment.profile_image }}" width="64" height="64">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading">{{ comment.fname }} {{ comment.lname }}</h4>
                                        <p>
                                            {{ comment.comment }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- MODAL EDIT FILE INFO -->
        <div class="modal fade" id="modal-edit-file" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">{{ edit_options.filename }}</h4>
                    </div>
                    <div class="modal-body">
                        <br>
                        <br>
                        <div class="form-group form-float form-group-md">
                            <label>File Restrictions</label>
                            <div class="form-line">
                                <select class="form-control" ng-model="edit_options.shared_status">
                                    <option value="1">Everyone can view this file</option>
                                    <!-- <option value="2">Only my organization can view this file</option> -->
                                    <option value="3">Only my course can view this file</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group form-float form-group-md">
                            <label>File Description</label>
                            <div class="form-line">
                                <textarea class="form-control" ng-model="edit_options.description"></textarea>
                            </div>
                        </div>

                        <div class="form-group form-float form-group-md">
                            <label>Tags <small style="width:100%;display:block">Separate tags by comma(,)s</label>
                            <div class="form-line">
                                <textarea class="form-control" ng-model="edit_options.tags"></textarea>
                            </div>
                        </div>
                        <div class="tags">
                            <span ng-repeat="tag in extractTag(edit_options.tags)" class="label {{ randomColor() }}" ng-bind="tag" style="margin-right:5px;"></span>
                        </div>
                        <br>                    
                        <p class="alert alert-info" ng-if="is_success">
                            File successfully updated.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" ng-click="updateFile()">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" ng-click="close_modal_file(edit_options.parameter_id)">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>    
    </section>

<?php $this->load->view('footer'); ?>