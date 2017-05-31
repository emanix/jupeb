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
                  <th>Program Name</th>
                  <!--<th>View Students</th>-->
                </tr>
                </thead>
                
                <tfoot>
                <tr>
                  <th>Serial No</th>
                  <th>Program Name</th>
                  <!--<th>View Students</th>-->
                </tr>
                </tfoot>
                <tbody>
                 <?php
                 if ($programs_table !== "" )
                 {
                    echo $programs_table;
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
      </div>
      <!-- /.row -->
</section>
 