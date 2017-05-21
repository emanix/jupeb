<section class="content">
      <div class="row">
         <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $add_subjects; ?></h3>
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
            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Subjects_Combination/add_subject_combo">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Subjects:</label>
                  <select class="form-control" name="sub_name" style="width: 80%;">
                    <option>Select Subjects</option>
                    <?php echo $subjects; ?>
                  </select>
                </div>                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right"><?php echo $add_subject; ?></button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
      </div>
      <!-- /.row -->
</section>
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $list_subjects; ?></h3>
            </div>
            <!-- /.box-header -->
            <?php if (isset($_SESSION['failed'])) {?>
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> <?php  echo $_SESSION['failed'];?>
                    </div>
                <?php } ?>

                <?php if (isset($_SESSION['successdelete'])) {?>
                    <div class="alert alert-success">
                        <?php  echo $_SESSION['successdelete'];?>
                    </div>
                <?php } ?>

                <?php if (validation_errors() !="") {?>
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Serial No</th>
                  <th>Subject Name</th>
                  <th>Drop</th>
                </tr>
                </thead>
                
                <tfoot>
                <tr>
                  <th>Serial No</th>
                  <th>Subject Name</th>
                  <th>Drop</th>
                </tr>
                </tfoot>
                <tbody>
                <?php 
                if ($subject_table == "" )
                { ?>
                 <tr>
                    <td colspan="3"><center><h4>No Subject have been added for this Course.</h4></center></td>
                 </tr>    
                <?php 
                }
                else
                { 
                  echo $subject_table;
                } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
         </div>
        </div> 
      <!-- /.row -->
</section>