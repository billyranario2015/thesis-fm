<?php $this->load->view('header'); ?>
    <section class="content" ng-controller="AreasController">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ENTRIES
                            </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>ROLE</th>
                                            <th>LEVEL NAME</th>
                                            <th>STATUS</th>
                                            <th>CONTENT</th>
                                            <th>ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($submitted_entry as $key => $entry) { ?>
                                        <tr>
                                            <th scope="row"><?php echo $key + 1; ?></th>
                                            <td><?php echo $entry['fname'].' '.$entry['lname']; ?></td>
                                            <td><?php echo $entry['role']; ?></td>
                                            <th><?php echo $entry['level_info']['level_name']; ?></th>
                                            <td>
                                                <?php if ( $entry['submission_status'] == 1 ) { // APPROVED ?>
                                                <label class="label label-success">APPROVED</label>
                                                <?php } elseif (  $entry['submission_status'] == 2 ) { // NEEDs TO REVISE ?>
                                                <label class="label label-warning">NEEDs REVISIONS</label>
                                                <?php } elseif (  $entry['submission_status'] == 3 ) { // UNAPPROVED ?> 
                                                <label class="label label-default">UNAPPROVED</label>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="/evaluator/user/<?php echo $entry['u_user_id']; ?>/level/<?php echo $entry['level_info']['id']; ?>/areas/">
                                                    VIEW
                                                </a>
                                            </td>
                                            <td>
                                                
                                                <select class="form-control" ng-model="submission_status" ng-change="updateEntryStatus(<?php echo $entry['submission_id'] ?> , <?php echo $entry['u_user_id']; ?>)">
                                                    <option value="1">Approve Entry</option>
                                                    <option value="3">Mark as Unapproved</option>
                                                </select>
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
        </div>
    </section>
<?php $this->load->view('footer'); ?>