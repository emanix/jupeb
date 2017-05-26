<section class="content">
      <div class="row">
         <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo $add_scores; ?></h3>
            </div>
            <!-- /.box-header -->
            
            <!-- form start -->
            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Grades/add_students_scores">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Attendance</label>

                  <div class="col-sm-9">
                    <input  type="number" class="form-control" id="inputEmail3" name="attendance" value="<?php echo $attendance; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Quiz</label>

                  <div class="col-sm-9">
                    <input  type="number" class="form-control" id="inputEmail3" name="quiz" value="<?php echo $quiz; ?>">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">Assignment</label>

                  <div class="col-sm-9">
                    <input  type="number" class="form-control" id="inputEmail3" name="assignment" value="<?php echo $assignment; ?>">
                  </div>
                </div>              
                
                <div class="form-group">
                  <label class="col-sm-3 control-label">Mid Semester</label>

                  <div class="col-sm-9">
                    <input  type="number" class="form-control" id="inputEmail3" name="midsem" value="<?php echo $mid_semester; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Exam</label>

                  <div class="col-sm-9">
                    <input  type="number" class="form-control" id="inputEmail3" name="exam" value="<?php echo $exam; ?>">
                  </div>
                </div>
              </div>                
              
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Submit</button>
              </div>
              <!-- /.box-footer -->
            </form>   
          </div>
        </div>
      </div>
</section>