<?php $this->load->view('header'); ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                                            <small><?php echo date("M d, Y h:ma", strtotime($log['created_at'])); ?></small>
                                        </p>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Activity Feeds
                            </h2>
                        </div>
                        <div class="body">
                            <p class="lead">
                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.
                            </p>
                            <p>
                                Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget
                            </p>
                            <p>
                                Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc.
                            </p>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>