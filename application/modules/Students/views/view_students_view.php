<div class="adjustbread">
<section class="content-header">
   <ol class="breadcrumb">
     <li><a href="<?php echo base_url(); ?>Admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="<?php echo base_url(); ?>Students/view_students"><i class="active"></i> View students</a></li>
   </ol>
</section>
</div>
<section class="content">
	<div class="row">
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Search students by Matric number.</h3>
            </div>
            <?php if (isset($_SESSION['failed'])) {?>
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> <?php  echo $_SESSION['failed'];?>
                    </div>
                <?php } ?>

                <?php if (isset($_SESSION['success'])) {?>
                    <div class="alert alert-success">
                        <?php  echo $_SESSION['success'];?>
                    </div>
                <?php } ?>

                <?php if (validation_errors() !="") {?>
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Students/search_students_with_matric">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Matric No.</label>

                  <div class="col-sm-9">
                    <input  type="text" class="form-control" id="inputEmail3" name="matric" placeholder="Enter Matric No">
                  </div>
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Search</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row">
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Search students by Program.</h3>
            </div>
            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Students/search_students_with_program">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Program: </label>
                  <div class="col-sm-9">
                  <select class="form-control" name="pid" style="width: 100%;">
                    <option>Select Program</option>
                    <?php echo $programs; ?>
                  </select>
                  </div>
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Search</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
</section>

<?php 
    if ($student_tables){
      echo $student_tables;
      }  
  ?>