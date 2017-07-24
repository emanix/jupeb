<div class="adjustbread">
<section class="content-header">
   <ol class="breadcrumb">
     <li><a href="<?php echo base_url(); ?>Admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
     <li><a href="<?php echo base_url(); ?>Grades/manage_subjectgrades"><i class="active"></i> Select session</a></li>
     <li class="active">Subjects list</li>
   </ol>
</section>
</div>
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
                  <!--<th>Serial No</th>-->
                  <th>Subjects Name</th>
                  <th></th>
                </tr>
                </thead>
                
                <tfoot>
                <tr>
                  <!--<th>Serial No</th>-->
                  <th>Subjects Name</th>
                  <th></th>
                </tr>
                </tfoot>
                <tbody>
                 <?php
                 if ($subjects_table !== "" )
                 {
                    echo $subjects_table;
                 }
                 else{
                   ?>
                     <tr>
                          <td colspan="3"><center><h4>No Subjects to display</h4></center></td>
                     </tr>
               	 <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
         </div>
      </div>
      <!-- /.row -->
</section>
 