<?php 
/*
| --------------------------------------------------------------------
|	FOR USER_LEVEL 3 ===> SUB CHAIRMAN
| --------------------------------------------------------------------
*/ 
?>

<?php $this->load->view('header'); ?>
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
  	</style>
    <section class="content" ng-controller="AreasController" ng-init="getParameters(<?php echo $data['id'] ?>);getCleanParameters(<?php echo $data['id'] ?>)">
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
                                <?php echo $data['area_name'] ?>
                                <?php if ($this->session->userdata('user_level') == 3 ) { ?>
                                <!-- NOT YET SUBMITTED -->
                                <button class="btn bg-deep-purple waves-effect btn-lg pull-right" style="position: relative;top: -8px;" 
                                    ng-click="submitToChairman()" ng-if="submission_data == 0">
                                        Submit Entries
                                </button>

                                <button class="btn bg-deep-purple waves-effect btn-lg pull-right" style="position: relative;top: -8px;" ng-if="submission_data > 0">
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
                                <li role="presentation" class="active">
                                    <a href="<?php echo base_url('user/my-area'); ?>">TEMPLATES</a>
                                </li>
                                <!-- <li role="presentation" class="">
                                    <a href="#profile" data-toggle="tab">PROFILE</a>
                                </li>
                                <li role="presentation" class="">
                                    <a href="#messages" data-toggle="tab">MESSAGES</a>
                                </li> -->
                                <!-- <li role="presentation" class="<?php if( $tab == 'entries' ) echo 'active'; ?>">
                                    <a href="<?php echo base_url('user/area/'.$data['id'].'/entries') ?>">ENTRIES</a>
                                </li> -->
                                <!-- <li role="presentation" class="<?php if( $tab == 'settings' ) echo 'active'; ?>">
                                    <a href="<?php echo base_url('user/area/'.$data['id'].'/settings') ?>">SETTINGS</a>
                                </li> -->
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content " style="overflow:hidden">
                                <div role="tabpanel" class="tab-pane active fade in" id="entries">
                                    <?php //$this->load->view( 'users/pages/area/entries' ); ?>
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
	                                        <li ng-repeat="list in cleanParameters" class="list-group-item item-paramater-{{list.id}} item-paramater-parent-{{list.parent_id}}" >
	                                            <span ng-bind-html="list.parameter_name"></span>
	                                            <span class="pull-right action-icons">
	                                                
	                                                <a href="<?php  echo base_url( 'user/area/' .$data['id'] . '/parameter/{{list.id}}' ) ?>" class="col-green" style="text-decoration: none;">
	                                                   <i class="material-icons">folder_shared</i>
	                                                </a>
	                                                <span class="col-cyan" ng-click="edit_parameter(list)">
	                                                   <i class="material-icons">mode_edit</i>
	                                                </span>
	                                                <span class="col-pink" ng-click="delete_parameter(list)">
	                                                   <i class="material-icons">delete_forever</i>
	                                                </span>
	                                            </span>
	                                        </li>
	                                    </ul>
	                                </div>
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
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
                                            <img class="media-object" ng-src="<?php echo base_url('assets/admin/images/user.png') ?>" width="64" height="64">
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
                        <p class="alert alert-info" ng-if="is_success">
                            File successfully updated.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" ng-click="updateFile()">SAVE CHANGES</button>
                        <button type="button" class="btn btn-link waves-effect" ng-click="close_modal_file(<?php echo $data['id'] ?>)">CLOSE</button>
                    </div>
                </div>
            </div>
        </div>    
    </section>

<?php $this->load->view('footer'); ?>