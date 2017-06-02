<section class="content">
	<div class="row">
		<div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Select Subject and semester to be generated.</h3>
            </div>
            <form class="form-horizontal" method="POST" action="<?php echo base_url(); ?>Reporting/subjects_report">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Semester: </label>
                  <div class="col-sm-9">
                  <select class="form-control" name="semid" style="width: 100%;">
                    <option>Select Semester</option>
                    <?php echo $semesters; ?>
                  </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label">Subject: </label>
                  <div class="col-sm-9">
                  <select class="form-control" name="subid" style="width: 100%;">
                    <option>Select Subject</option>
                    <?php echo $subjects; ?>
                  </select>
                  </div>
                </div>
                <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Generate Report</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
</section>