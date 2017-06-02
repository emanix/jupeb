<?php 

class Reporting extends MY_Controller{
	
	function __construct(){
		parent:: __construct();
		$this->load->model(['M_Reporting']);
		$this->load->module('Templates');
	}

	function reports(){
    	$data['student_records'] = 'Students Management';
        $data['page_title'] = 'Manage Reports';
        $data['optional_description'] = 'Generate reports for students grades and scores.';
        //$data['add_students'] = 'Add Students';
        $data['semesters'] = $this->semester_select();
        $data['subjects'] = $this->subject_select();
        $data['content_view'] = 'Reporting/generate_report_view';
        $this->templates->call_admin_template($data);
    }

    function semester_select(){

        $semesters = $this->M_Reporting->get_semesters();
        $options = "";
        if (count($semesters)){
            foreach ($semesters as $key => $value){
                $options .= "<option value = '{$value->semid}'>{$value->semester_name}</option>";
            }
        }
        return $options;
    }

    function subject_select(){

        $subjects = $this->M_Reporting->get_subjects();
        $options = "";
        if (count($subjects)){
            foreach ($subjects as $key => $value){
                $options .= "<option value = '{$value->subid}'>{$value->subject_name}</option>";
            }
        }
        return $options;
    }

	function subjects_report(){

		if ($this->input->post()){
			
			$sem = $this->M_Reporting->get_semester_by_id();
			foreach ($sem as $key => $semid) {
				$sem_name = $semid->semester_name;
			}

			$sub = $this->M_Reporting->get_subject_by_id();
			foreach ($sub as $key => $subna) {
				$sub_name = $subna->subject_name;
			}

			require('./fpdf/fpdf.php');
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',12);
            //$pdf->Image('./assets/bu logo2.jpg', 10, 10);
            $pdf->Cell(0, 10, "Babcock University", 0, 1, "L");
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0, 2, "School of Education and Humanities", 0, 1, "L");
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0, 5, "Center for Foundation Studies", 0, 1, "L");
            $pdf->SetFont('Arial','',10);
            $pdf->Cell(0, 3, "Joint University Preliminary Examinations Board (JUPEB) A'Level", 0, 1, "L");
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0, 5, "Subject: $sub_name", 0, 1, "L");
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(0, 5, "Semester: $sem_name", 0, 1, "L");

            // Colors, line width and bold font
            $pdf->SetFont('','B');
        
            // Header
            $header = array('S/N', 'Name', 'Matric.', 'Attn 5%', 'Quiz 20%', 'Assig. 20%', 'Mid. Sem 20%', 'Exam 35%', 'Total 100%', '%tage 5%');
            $w = array(10, 40, 15, 15, 18, 18, 20, 17, 18, 18);
            for($i=0;$i<count($header);$i++)
                $pdf->Cell($w[$i],7,$header[$i],1,0);
            $pdf->Ln();

            $pdf->SetFont('Arial','',10);

			$scores = $this->M_Reporting->get_scores();
			if (count($scores) >= 0) {
				$counter = 1;
				foreach ($scores as $key => $value) {
					$pdf->Cell($w[0], 7, $counter, 1, 0, 'C');
                    $pdf->Cell($w[1], 7, $value->student_name, 1, 0);
                    $pdf->Cell($w[2], 7, $value->matric_no, 1, 0);
                    $pdf->Cell($w[3], 7, $value->attendance, 1, 0);
                    $pdf->Cell($w[4], 7, $value->quiz, 1, 0);
                    $pdf->Cell($w[5], 7, $value->assignment, 1, 0);
                    $pdf->Cell($w[6], 7, $value->mid_semester, 1, 0);
                    $pdf->Cell($w[7], 7, $value->exam, 1, 0);
                    $pdf->Cell($w[8], 7, $value->total, 1, 0);
                    $pdf->Cell($w[9], 7, $value->percentage, 1, 0);

                    $pdf->Ln();

                    $counter++;
				}
				
			}
			 $pdf->Ln();
			$pdf->SetFont('Arial','',12);
            $pdf->Cell(0, 10, "Signature/Date___________", 0, 1, "R");
			$pdf->SetFont('Arial','',12);
            $pdf->Cell(0, 0, "Lecturer: ", 0, 1, "L");
            

            $pdf->Output();
		}
	}
}