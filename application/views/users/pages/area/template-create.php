                                        <div class="text-right">
                                            <a href="<?php echo base_url( 'user/area/'.$data['id'] . '/templates' ); ?>" class="btn btn-primary">BACK</a>
                                        </div>
                                        <br>
                                        <form method="POST" action="<?php echo base_url('organization/create') ?>">
                                            <div class="col-sm-12">
                                                <h2 class="card-inside-title">Template Name</h2>
                                                <div class="form-group form-float">
                                                    <div class="form-line">
                                                        <input type="text" name="template_name" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="submit" class="btn bg-cyan btn-lg waves-effect">CREATE</button>
                                            </div>
                                        </form>