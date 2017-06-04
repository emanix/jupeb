<div class="adjustbread">
<section class="content-header">
   <ol class="breadcrumb">
     <li><a href="<?php echo base_url(); ?>Admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="<?php echo base_url(); ?>Grades/manage_grades"><i class="active"></i> Select session</a></li>
     <li><a href="<?php echo base_url(); ?>Grades/semester_select/<?php echo $this->session->userdata('semest_id'); ?>"><i class="active"></i> Show programs</a></li>
     <li><a href="<?php echo base_url(); ?>Grades/view_students_grades/<?php echo $this->session->userdata('proid'); ?>"><i class="active"></i> View students</a></li>
     <li><a href="<?php echo base_url(); ?>Grades/add_students_grades/<?php echo $this->session->userdata('student_id'); ?>"><i class="active"></i> View scores</a></li>
     <li class="active">Edit scores</li>
   </ol>
</section>
</div>
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