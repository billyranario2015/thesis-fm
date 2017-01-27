<?php $this->load->view('header'); ?>
    <section class="content" ng-controller="CourseController">
        <div class="container-fluid">
            <div class="block-header">
                <h2>COURSE</h2>
                <?php if ( $this->session->flashdata('message') ) { ?>
                <br>
                <div class="alert alert-info">
                    <strong>Success!</strong>  <?php echo $this->session->flashdata('message'); ?>
                </div>
                <?php } ?> 
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                LISTS OF COURSES
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="<?php echo base_url( 'admin/create-course' ); ?>" class=" waves-effect waves-block">Add Course</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>COURSE</th>
                                        <th>ORGANIZATION</th>
                                        <th class="text-right">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $key => $course) { ?>
                                    <tr id="course-<?php echo $course['course_id'] ?>">
                                        <th scope="row"><?php echo ++$key; ?></th>
                                        <td><?php echo $course['course_name'] ?></td>
                                        <td><?php echo $course['organization_name'] ?></td>
                                        <td class="text-right">
                                            <a href="<?php echo base_url('admin/course/'.$course['course_id'].'/edit') ?>" class="btn bg-blue waves-effect">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="#" ng-click="deleteCourse(<?php echo $course['course_id']; ?>)" class="btn bg-pink waves-effect">
                                                    <i class="material-icons">delete_sweep</i>
                                            </a> &nbsp;
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $this->load->view('footer'); ?>