<section class="content">
      <div class="row">
      	<div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View session to be graded.</h3>
            </div>
            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Grades/manage_grade">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Session: </label>
                  <div class="col-sm-9">
                  <select class="form-control" name="sesid" style="width: 100%;">
                    <option>Select Session</option>
                    <?php echo $sessions; ?>
                  </select>
                  </div>
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">View</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
</section>
<?php 
    if ($semester_table){ ?>
      <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $view_program; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Serial No</th>
                  <th>Semester Name</th>
                  <th>Show Programs</th>
                </tr>
                </thead>
                
                <tfoot>
                <tr>
                  <th>Serial No</th>
                  <th>Semester Name</th>
                  <th>Show Programs</th>
                </tr>
                </tfoot>
                <tbody>
                 <?php
                 if ($semester_table !== "" )
                 {
                    echo $semester_table;
                 }
                 else{
                   ?>
                     <tr>
                          <td colspan="3"><center><h4>No Programs to display</h4></center></td>
                     </tr>
                 <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
         </div>
      <!-- /.row -->
  </section>
<?php  } ?>