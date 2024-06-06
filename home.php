
 
 <!-- Header-->
 <header class="bg-dark py-5 d-flex align-items-center" id="main-header">

 <?php require_once('./classes/SystemSettings.php'); ?>

    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Welcome Back !!!</h1>
            <p class="lead fw-normal text-white-50 mb-0 mt-4">
                <a class="btn btn-default btn-lg bg-lightblue" href='<?php echo base_url.'admin'?>'>Login</a>
                <a class="btn btn-default btn-lg bg-orange"  data-toggle="modal" data-target="#aboutModal">About</a>
            </p>
        </div>
    </div>



    <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title text-primary">About</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body text-dark">
                <p ><?php 
                echo $_settings->info('about');
                ?></p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary bg-danger" data-dismiss="modal">Close</button>
                <!-- Additional buttons if needed -->
            </div>
        </div>
    </div>
</div>


</header>
<!-- Section-->
<style>
    .book-cover{
        object-fit:contain !important;
        height:auto !important;
    }
</style>
<section class="py-0">
    <!-- Remove About Page -->
    <!-- <div class="container px-4 px-lg-5 mt-5">
        <?php //require_once('about.html') ?>
    </div> -->
</section>


