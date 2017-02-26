<?php $this->load->view('header'); ?>
    <section class="content" ng-controller="UsersController">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Activity Feeds
                                <small>List of user activities.</small>
                            </h2>
                        </div>
                        <div class="body">
                            <ul class="list-group">
                                <?php foreach ($logs as $key => $log) { ?>
                                    <li class="list-group-item">   
                                        <?php if( isset($log['link']) && $log['link'] != null ) { ?> 
                                        <a href="<?php echo $log['link']; ?>">
                                            <?php echo $log['message']; ?>
                                        </a>
                                        <?php } else { ?>
                                        <div>
                                            <?php echo $log['message']; ?>
                                        </div>
                                        <?php } ?>
                                        
                                        <p style="margin:0">
                                            <small><?php echo date("M d, Y H:i a", strtotime($log['created_at'])); ?></small>
                                        </p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header bg-red">
                            <h2>
                                Incomplete Parameters
                                <small>List of parameters not yet completed.</small>
                            </h2>
                        </div>
                        <div class="body">
                            <ul class="list-group">
                                <li ng-repeat="list in parameter_lists" class="list-group-item item-paramater-{{list.id}} item-paramater-parent-{{list.parent_id}}" ng-if="list.parameter_status == 'incomplete'">
                                    <a href="<?php  echo base_url( 'user/level/{{ list.level_info.id }}/area/{{ list.area_id }}/parameter/{{list.area_parameter_id}}' ) ?>"  style="text-decoration: none;">
                                        <span ng-bind-html="list.parameter_name"></span>
                                        
                                        <small ng-bind="list.level_info.level_name" class="label bg-pink"></small>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>