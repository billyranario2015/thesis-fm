<?php $this->load->view('header'); ?>

    <section class="content" ng-controller="AreasController" ng-init="getCleanParameters(<?php echo $area_id ?>)">
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
                                 <small>ENTRY CONTENTS FROM <span class="font-bold col-pink" style="text-transform:uppercase;"><?php echo $chairman_info['fname']. ' ' .$chairman_info['lname'] ?></span></small>
                                

                                <a href="/evaluator/user/<?php echo $chairman_info['id'] ?>/area" class="btn btn-primary waves-effect btn-lg pull-right" style="position: relative;top: -38px;">
                                    BACK
                                </a>

                            </h2>
                        </div>
                        <div class="body">
                            <h2 class="card-inside-title">Parameters</h2>
                            <ul class="list-group">
                                <li ng-repeat="list in cleanParameters" class="list-group-item item-paramater-{{list.id}} item-paramater-parent-{{list.parent_id}}" >
                                    <span ng-bind-html="list.parameter_name"></span>
                                    <span class="pull-right action-icons">
                                        
                                        <a href="<?php  echo base_url( 'evaluator/user/'.$chairman_info['id'].'/area/' .$data['id'] . '/parameter/{{list.id}}' ) ?>" class="col-green" style="text-decoration: none;">
                                           <i class="material-icons">folder_shared</i>
                                        </a>
                                        <!-- <span class="col-cyan" ng-click="edit_parameter(list)">
                                           <i class="material-icons">mode_edit</i>
                                        </span>
                                        <span class="col-pink" ng-click="delete_parameter(list)">
                                           <i class="material-icons">delete_forever</i>
                                        </span> -->
                                    </span>
                                </li>
                            </ul>
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
    </section>

<?php $this->load->view('footer'); ?>