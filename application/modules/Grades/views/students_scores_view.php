<div class="adjustbread">
<section class="content-header">
   <ol class="breadcrumb">
     <li><a href="<?php echo base_url(); ?>Admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="<?php echo base_url(); ?>Grades/manage_grades"><i class="active"></i> Select session</a></li>
     <li><a href="<?php echo base_url(); ?>Grades/semester_select/<?php echo $this->session->userdata('semest_id'); ?>"><i class="active"></i> Show programs</a></li>
     <li><a href="<?php echo base_url(); ?>Grades/view_students_grades/<?php echo $this->session->userdata('proid'); ?>"><i class="active"></i> View students</a></li>
     <li class="active">Subjects list</li>
   </ol>
</section>
</div>
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $view_students; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Serial No</th>
                  <th>Subject Name</th>
                  <th>Attendance</th>
                  <th>Quiz</th>
                  <th>Assignment</th>
                  <th>Mid. Semester</th>
                  <th>Exam</th>
                  <th>Total</th>
                  <th>Percentage (5%)</th>
                </tr>
                </thead>
                
                <tfoot>
                <tr>
                  <th>Serial No</th>
                  <th>Subject Name</th>
                  <th>Attendance</th>
                  <th>Quiz</th>
                  <th>Assignment</th>
                  <th>Mid. Semester</th>
                  <th>Exam</th>
                  <th>Total</th>
                  <th>Percentage (5%)</th>
                </tr>
                </tfoot>
                <tbody>
                 <?php echo $scores_table; ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
         </div>
      <!-- /.row -->
</section>
<section class="content">
  <?php if($scores_field !== ""){ ?>
      <div class="row">
         <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Scores <?php echo $add_scores; ?></h3>
            </div>
            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Grades/input_students_scores">
          <?php } ?>    
              <?php echo $scores_field; ?>

</section>
 