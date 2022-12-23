<!-- Dashboard Nav -->
<?php
include_once 'layout/dashboardNav.php';
?>
<!-- Dashboard Nav -->

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <?php
        include_once 'layout/sidebar.php';
        ?>
        <!-- Sidebar -->

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <h1 class="h5 pt-5">หน้าหลัก</h1>
            <hr>
            
            <?php
                include_once 'dashboard/profile.php';
                include_once 'dashboard/profileedit.php';
            ?>
            
        </main>
    </div>
</div>