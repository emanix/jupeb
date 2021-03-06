<div class="adjustbread">
<section class="content-header">
   <ol class="breadcrumb">
     <li><a href="<?php echo base_url(); ?>Admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="<?php echo base_url(); ?>Students/view_students"><i class="active"></i> View students</a></li>
     <li class="active">Edit student</li>
   </ol>
</section>
</div>
<section class="content">
      <div class="row">
         <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $update_student; ?></h3>
            </div>
            <!-- /.box-header -->
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
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Students/update_student">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label" id="mat">Matric No.</label>

                  <?php 
                    if ($matric_field !==""){
                      echo $matric_field;
                    }
                   ?>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Students Name</label>

                  <?php 
                    if ($student_field !==""){
                      echo $student_field;
                    }
                   ?>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Session:</label>
                  <div class="col-sm-9">
                  <?php echo $session; ?>
                  <?php echo $sessionss; ?>
                  <!--<select class="form-control" name="sid" id="sess" style="width: 80%;" onclick="populate_session()">
                    <option value="">Select Session</option>
                    <?php echo $session; ?>
                  </select>-->
                  </div>
                </div>                
                
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Program: </label>
                  <div class="col-sm-9">
                  <?php echo $program; ?>
                  <?php echo $programss; ?>
                  <!--<select class="form-control" name="pid" id="progs" style="width: 80%;" onclick="populate_program()">
                    <option value="">Select Program</option>
                    <?php echo $program; ?>
                  </select>-->
                  </div>
                </div>                
              
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Update</button>
              </div>
              <!-- /.box-footer -->
            </div>
            </form>   
        </div>
      </div>
      <!-- /.row -->
</section> 
<script type="text/javascript">
    function populate_session(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "<?php echo base_url(); ?>Students/get_sessions?session="+document.getElementById("mat").value, false);
        xmlhttp.send(null);
        document.getElementById("sess").innerHTML=xmlhttp.responseText;
    }

    function populate_program(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "<?php echo base_url(); ?>Students/get_programs?programs="+document.getElementById("mat").value, false);
        xmlhttp.send(null);
        document.getElementById("progs").innerHTML=xmlhttp.responseText;
    }
</script>