<?php 

class Reporting extends MY_Controller{
	
	function __construct(){
		parent:: __construct();
		$this->load->model(['M_Reporting', 'M_Student', 'M_Subjects', 'M_Grades']);
		$this->load->module('Templates');
	}

	function reports(){
    	$data['student_records'] = 'Students Management';
        $data['page_title'] = 'Manage Reports';
        $data['optional_description'] = 'Generate reports for students grades and scores.';
        //$data['add_students'] = 'Add Students';
        $data['semesters'] = $this->semester_select();
        $data['subjects'] = $this->subject_select();
        $data['programs'] = $this->program_select();
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

    function program_select(){

        $programs = $this->M_Student->get_program();
        $options = "";
        if (count($programs)){
            foreach ($programs as $key => $value){
                $options .= "<option value = '{$value->pid}'>{$value->program_name}</option>";
            }
        }
        return $options;
    }

	function subjects_report(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('semid', 'Select Semester', 'required');
        $this->form_validation->set_rules('subid', 'Select Subject', 'required');
        // if validation fails
        if ($this->form_validation->run() == FALSE){
            $this->reports();
            
        }
        else
        {
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
                $pdf->Image('./assets/bu logo2.jpg', 10, 6);
                $pdf->SetY(7);
                $pdf->SetX(27);
                $pdf->Cell(0, 5, "Babcock University", 0, 1, 30);
                $pdf->SetFont('Arial','',10);
                $pdf->SetX(27);
                $pdf->Cell(0, 2, "School of Education and Humanities", 0, 1, "L");
                $pdf->SetFont('Arial','',10);
                $pdf->SetX(27);
                $pdf->Cell(0, 5, "Center for Foundation Studies", 0, 1, "L");
                $pdf->SetFont('Arial','',10);
                $pdf->SetX(27);
                $pdf->Cell(0, 3, "Joint University Preliminary Examinations Board (JUPEB) A'Level", 0, 1, "L");
                $pdf->SetFont('Arial','B',12);
                $pdf->SetY(30);
                //$pdf->SetX(80);
                $pdf->Cell(0, 5, "Subject: $sub_name", 0, 1, "C");
                $pdf->SetFont('Arial','B',8);
                //$pdf->SetX(85);
                $pdf->Cell(0, 5, "Semester: $sem_name", 0, 1, "C");

                // Colors, line width and bold font
                $pdf->SetFont('','B');
                $pdf->SetY(43);
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
                $pdf->Cell(0, 10, "Lecturer:                                                                                                Signature/Date___________", 0, 1, "L");
    			$pdf->SetFont('Arial','',12);
                $pdf->Cell(0, 20, "Director: Dr. Zoaka Joshua J                                                                Signature/Date___________", 0, 1, "L");
                $pdf->SetY(-35);
                $pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');
                $pdf->Output();
    		}
        }
	}

    function programs_report(){

        $this->load->library('form_validation');

        $this->form_validation->set_rules('semid', 'Select Semester', 'required');
        $this->form_validation->set_rules('progid', 'Select Program', 'required');
        // if validation fails
        if ($this->form_validation->run() == FALSE){
            $this->reports();

        }
        else
        {
        if ($this->input->post()){
            
            $sem = $this->M_Reporting->get_semester_by_id();
            foreach ($sem as $key => $semid) {
                $sem_name = $semid->semester_name;
            }

            $prog = $this->M_Reporting->get_program_by_id();
            foreach ($prog as $key => $prona) {
                $pro_name = $prona->program_name;
            }

            require('./fpdf/fpdf.php');
            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',12);
            $pdf->Image('./assets/bu logo2.jpg', 10, 6);
            $pdf->SetY(7);
            $pdf->SetX(27);
            $pdf->Cell(0, 5, "Babcock University", 0, 1, "L");
            $pdf->SetFont('Arial','',10);
            $pdf->SetX(27);
            $pdf->Cell(0, 2, "School of Education and Humanities", 0, 1, "L");
            $pdf->SetFont('Arial','',10);
            $pdf->SetX(27);
            $pdf->Cell(0, 5, "Center for Foundation Studies", 0, 1, "L");
            $pdf->SetFont('Arial','',10);
            $pdf->SetX(27);
            $pdf->Cell(0, 3, "Joint University Preliminary Examinations Board (JUPEB) A'Level", 0, 1, "L");
            $pdf->SetFont('Arial','B',12);
            $pdf->SetY(30);
            //$pdf->SetX(80);
            $pdf->Cell(0, 5, "Program: $pro_name", 0, 1, "C");
            $pdf->SetFont('Arial','B',8);
            //$pdf->SetX(85);
            $pdf->Cell(0, 5, "Semester: $sem_name", 0, 1, "C");

            // Colors, line width and bold font
            $pdf->SetFont('','B');

            $subjects = $this->M_Subjects->get_subject_pid($this->input->post('progid'));
             $sub = "subs";
            $count = 1;
            foreach ($subjects as $key => $value) {
                $sub_name = $this->M_Subjects->get_subject_by_id($value->sid);
                foreach ($sub_name as $key => $value) {
                    $sublist[$sub.$count] = $value->subject_name;
                    $count++;
                }
            }
            $pdf->SetY(43);
            // Header
            $header = array('S/N', 'Student Name',$sublist['subs1'], $sublist['subs2'], $sublist['subs3']);
            $w = array(10, 60, 40, 40, 40);
            for($i=0;$i<count($header);$i++)
                $pdf->Cell($w[$i],7,$header[$i],1,0);
            $pdf->Ln();

            $pdf->SetFont('Arial','',10);

            //$grades = $this->M_Reporting->get_grades();
            //$grad = "grads";
            //$counting = 1;
            $ses_name = substr($sem_name, 0, 9);
            $sesid = $this->M_Grades->get_sesid_by_name($ses_name);
            foreach ($sesid as $key => $ses) {
                $ses_id = $ses->sid;
            }

            $student = $this->M_Student->get_student_by_programs($this->input->post('progid'), $ses_id);
            if (count($student) >= 0) {
                $counter = 1;
                foreach ($student as $key => $value) {
                    $pdf->Cell($w[0], 7, $counter, 1, 0, 'C');
                    $pdf->Cell($w[1], 7, $value->student_name, 1, 0);
                    $grade = $this->M_Reporting->get_grades_by_stdid($value->stdid);
                    $gradlist = [];
                    foreach ($grade as $key => $value) {
                        $gradlist[] = $value->percentage;
                    }
                    $count = 2;
                    foreach ($gradlist as $row) {
                        $pdf->Cell($w[$count], 7, $row, 1, 0);
                        $count++;
                    }
                    $count = 0;

                    $pdf->Ln();

                    $counter++;
                }
                
            }
             $pdf->Ln();
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(0, 10, "Lecturer:                                                                                                Signature/Date___________", 0, 1, "L");
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(0, 20, "Director: Dr. Zoaka Joshua J                                                                Signature/Date___________", 0, 1, "L");
            $pdf->SetY(-35);
            $pdf->Cell(0,10,'Page '.$pdf->PageNo(),0,0,'C');

            $pdf->Output();
        }
        }
    }
}