

    <!-- Bootstrap Core Js -->
    <script src="<?php echo base_url( '/assets/admin/plugins/bootstrap/js/bootstrap.js' ); ?>"></script>

    <!-- Select Plugin Js -->
    <!-- <script src="<?php echo base_url( '/assets/admin/plugins/bootstrap-select/js/bootstrap-select.js' ); ?>"></script> -->

    <!-- Slimscroll Plugin Js -->
    <script src="<?php echo base_url( '/assets/admin/plugins/jquery-slimscroll/jquery.slimscroll.js' ); ?>"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="<?php echo base_url( '/assets/admin/plugins/node-waves/waves.js' ); ?>"></script>

    <!-- DropZone -->
    <!-- <script type="text/javascript" src="<?php echo base_url('assets/admin/plugins/dropzone/dropzone.js') ?>"></script> -->

    <script type="text/javascript">

        // Dropzone.autoDiscover = false;
        // var file= new Dropzone(".dropzone",{
        //     url: "<?php echo base_url('upload/upload_files') ?>",
        //     // maxFilesize: 2,  // maximum size to uplaod 
        //     method:"post",
        //     // acceptedFiles:"image/*", // allow only images
        //     paramName:"userfile",
        //     // dictInvalidFileType:"Image files only allowed", // error message for other files on image only restriction 
        //     addRemoveLinks:true,
        //     autoProcessQueue: false
        // });
        // //Upload file onchange 

        // file.on("sending",function(a,b,c){
        //     a.token=Math.random();
        //     c.append("token",a.token); //Random Token generated for every files 
        // });


        // // delete on upload 

        // file.on("removedfile",function(a){
        //     var token=a.token;
        //     $.ajax({
        //         type:"post",
        //         data:{token:token},
        //         url:"<?php echo base_url('upload/delete') ?>",
        //         cache:false,
        //         dataType: 'json',
        //         success: function(res){
        //             // alert('Selected file removed !');            

        //         }

        //     });
        // });
    </script>

    <!-- Custom Js -->
    <script src="<?php echo base_url( '/assets/admin/js/admin.js' ); ?>"></script>

    <!-- Demo Js -->
    <script src="<?php echo base_url( '/assets/admin/js/demo.js' ); ?>"></script>

    <!-- Angular JS -->
    <script src="<?php echo base_url( '/assets/admin/js/angularjs/angular.min.js' ); ?>"></script>
    <script src="<?php echo base_url( '/assets/admin/js/angularjs/angular-sanitize.min.js' ); ?>"></script>
    <script src="<?php echo base_url( '/assets/admin/js/angularjs/angular-filter.js' ); ?>"></script>
    
    <script src="<?php echo base_url( '/assets/admin/js/angularjs/app.js' ); ?>"></script>

    <!-- CUSTOM SCRIPT -->
    <?php echo isset( $scripts ) ? $scripts : ''; ?>


</body>

</html>