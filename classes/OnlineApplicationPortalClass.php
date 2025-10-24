<?php
// EduPack Online Application Portal Module
// Features: Multi-step application forms, Secure document upload, Application status tracking

class OnlineApplicationPortal {
    private $db;

    public function __construct($db_connection) {
        $this->db = $db_connection;
    }

    public function createApplication($applicant_data) {
        $stmt = $this->db->prepare("INSERT INTO student_applications (id, name, gender, dob, placeob, address, studentmobile, email, religion, state, lga, class, arm, session, term, schoolname, schooladdress, hobbies, lastclass, sickle, challenge, emergency, familydoc, docaddress, docmobile, polio, tuberculosis, measles, tetanus, whooping, gname, mobile, goccupation, gaddress, grelationship, hostel, bloodtype, bloodgroup, height, weight, photo, status, password, result, passport_path, transcript_path, admission_status, entrance_exam_scheduled, entrance_exam_date, entrance_exam_time, entrance_exam_location) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $id = $applicant_data['id'];
        $name = $applicant_data['name'];
        $gender = $applicant_data['gender'];
        $dob = $applicant_data['dob'];
        $placeob = $applicant_data['placeob'];
        $address = $applicant_data['address'];
        $studentmobile = $applicant_data['studentmobile'];
        $email = $applicant_data['email'];
        $religion = $applicant_data['religion'];
        $state = $applicant_data['state'];
        $lga = $applicant_data['lga'];
        $class = $applicant_data['class'];
        $arm = $applicant_data['arm'];
        $session = $applicant_data['session'];
        $term = $applicant_data['term'];
        $schoolname = $applicant_data['schoolname'];
        $schooladdress = $applicant_data['schooladdress'];
        $hobbies = $applicant_data['hobbies'];
        $lastclass = $applicant_data['lastclass'];
        $sickle = $applicant_data['sickle'];
        $challenge = $applicant_data['challenge'];
        $emergency = $applicant_data['emergency'];
        $familydoc = $applicant_data['familydoc'];
        $docaddress = $applicant_data['docaddress'];
        $docmobile = $applicant_data['docmobile'];
        $polio = $applicant_data['polio'];
        $tuberculosis = $applicant_data['tuberculosis'];
        $measles = $applicant_data['measles'];
        $tetanus = $applicant_data['tetanus'];
        $whooping = $applicant_data['whooping'];
        $gname = $applicant_data['gname'];
        $mobile = $applicant_data['mobile'];
        $goccupation = $applicant_data['goccupation'];
        $gaddress = $applicant_data['gaddress'];
        $grelationship = $applicant_data['grelationship'];
        $hostel = $applicant_data['hostel'];
        $bloodtype = $applicant_data['bloodtype'];
        $bloodgroup = $applicant_data['bloodgroup'];
        $height = $applicant_data['height'];
        $weight = $applicant_data['weight'];
        $photo = $applicant_data['photo'];
        $status = $applicant_data['status'];
        $password = $applicant_data['password'];
        $result = $applicant_data['result'];
        $passport_path = $applicant_data['passport_path'];
        $transcript_path = $applicant_data['transcript_path'];
        $admission_status = $applicant_data['admission_status'];
        $entrance_exam_scheduled = $applicant_data['entrance_exam_scheduled'];
        $entrance_exam_date = $applicant_data['entrance_exam_date'];
        $entrance_exam_time = $applicant_data['entrance_exam_time'];
        $entrance_exam_location = $applicant_data['entrance_exam_location'];

        $stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssisssssisss",
            $id, $name, $gender, $dob, $placeob, $address, $studentmobile, $email, $religion, $state, $lga,
            $class, $arm, $session, $term, $schoolname, $schooladdress, $hobbies, $lastclass, $sickle,
            $challenge, $emergency, $familydoc, $docaddress, $docmobile, $polio, $tuberculosis, $measles,
            $tetanus, $whooping, $gname, $mobile, $goccupation, $gaddress, $grelationship, $hostel,
            $bloodtype, $bloodgroup, $height, $weight, $photo, $status, $password, $result,
            $passport_path, $transcript_path, $admission_status, $entrance_exam_scheduled,
            $entrance_exam_date, $entrance_exam_time, $entrance_exam_location
        );

        if ($stmt->execute()) {
            return $id;
        }
        error_log("Create application failed: " . $stmt->error);
        return false;
    }

    public function updateApplicationStatus($application_id, $new_status) {
        $stmt = $this->db->prepare("UPDATE student_applications SET admission_status = ? WHERE id = ?");
        $stmt->bind_param("ss", $new_status, $application_id);
        if ($stmt->execute()) {
            return true;
        }
        error_log("Update application status failed: " . $stmt->error);
        return false;
    }

    public function getAllApplications() {
        $stmt = $this->db->query("SELECT * FROM student_applications ORDER BY id DESC");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    public function getStudentApplicationById($application_id) {
        $stmt = $this->db->prepare("SELECT * FROM student_applications WHERE id = ?");
        $stmt->bind_param("s", $application_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function assignAdminDetailsAndApprove($application_id, $student_id, $class, $arm, $hostel, $password) {
        // Update student_applications with admin assigned details and set status to approved
        $stmt_update_student_app = $this->db->prepare("UPDATE student_applications SET assigned_student_id = ?, assigned_class = ?, assigned_arm = ?, assigned_hostel = ?, password = ?, admission_status = 'approved' WHERE id = ?");
        $stmt_update_student_app->bind_param("ssssss", $student_id, $class, $arm, $hostel, $password, $application_id);
        if (!$stmt_update_student_app->execute()) {
            error_log("Update student_applications failed: " . $stmt_update_student_app->error);
            return false;
        }

        // Retrieve the updated student application data
        $student_app_data = $this->getStudentApplicationById($application_id);
        if (!$student_app_data) {
            error_log("Failed to retrieve student application data for ID: " . $application_id);
            return false;
        }

        // Insert into the students table
        $stmt_insert_student = $this->db->prepare("INSERT INTO students (id, name, gender, dob, placeob, address, studentmobile, email, religion, state, lga, class, arm, session, term, schoolname, schooladdress, hobbies, lastclass, sickle, challenge, emergency, familydoc, docaddress, docmobile, polio, tuberculosis, measles, tetanus, whooping, gname, mobile, goccupation, gaddress, grelationship, hostel, bloodtype, bloodgroup, height, weight, photo, status, password, result) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $s_id = $student_app_data['assigned_student_id'];
        $s_name = $student_app_data['name'];
        $s_gender = $student_app_data['gender'];
        $s_dob = $student_app_data['dob'];
        $s_placeob = $student_app_data['placeob'];
        $s_address = $student_app_data['address'];
        $s_studentmobile = $student_app_data['studentmobile'];
        $s_email = $student_app_data['email'];
        $s_religion = $student_app_data['religion'];
        $s_state = $student_app_data['state'];
        $s_lga = $student_app_data['lga'];
        $s_class = $student_app_data['assigned_class'];
        $s_arm = $student_app_data['assigned_arm'];
        $s_session = $student_app_data['session'];
        $s_term = $student_app_data['term'];
        $s_schoolname = $student_app_data['schoolname'];
        $s_schooladdress = $student_app_data['schooladdress'];
        $s_hobbies = $student_app_data['hobbies'];
        $s_lastclass = $student_app_data['lastclass'];
        $s_sickle = $student_app_data['sickle'];
        $s_challenge = $student_app_data['challenge'];
        $s_emergency = $student_app_data['emergency'];
        $s_familydoc = $student_app_data['familydoc'];
        $s_docaddress = $student_app_data['docaddress'];
        $s_docmobile = $student_app_data['docmobile'];
        $s_polio = $student_app_data['polio'];
        $s_tuberculosis = $student_app_data['tuberculosis'];
        $s_measles = $student_app_data['measles'];
        $s_tetanus = $student_app_data['tetanus'];
        $s_whooping = $student_app_data['whooping'];
        $s_gname = $student_app_data['gname'];
        $s_mobile = $student_app_data['mobile'];
        $s_goccupation = $student_app_data['goccupation'];
        $s_gaddress = $student_app_data['gaddress'];
        $s_grelationship = $student_app_data['grelationship'];
        $s_hostel = $student_app_data['assigned_hostel'];
        $s_bloodtype = $student_app_data['bloodtype'];
        $s_bloodgroup = $student_app_data['bloodgroup'];
        $s_height = $student_app_data['height'];
        $s_weight = $student_app_data['weight'];
        $s_photo = $student_app_data['passport_path']; // Use passport_path for photo
        $s_status = 0; // status = 0 for active student
        $s_password = $student_app_data['password'];
        $s_result = $student_app_data['result'];

        $stmt_insert_student->bind_param("ssssssssssssssssssssssssssssssssssssssssssis",
            $s_id, $s_name, $s_gender, $s_dob, $s_placeob, $s_address, $s_studentmobile, $s_email, $s_religion, $s_state, $s_lga,
            $s_class, $s_arm, $s_session, $s_term, $s_schoolname, $s_schooladdress, $s_hobbies, $s_lastclass, $s_sickle,
            $s_challenge, $s_emergency, $s_familydoc, $s_docaddress, $s_docmobile, $s_polio, $s_tuberculosis, $s_measles,
            $s_tetanus, $s_whooping, $s_gname, $s_mobile, $s_goccupation, $s_gaddress, $s_grelationship, $s_hostel,
            $s_bloodtype, $s_bloodgroup, $s_height, $s_weight, $s_photo, $s_status, $s_password, $s_result
        );

        if ($stmt_insert_student->execute()) {
            return true;
        }
        error_log("Insert into students failed: " . $stmt_insert_student->error);
        return false;
    }

    public function scheduleEntranceExam($application_id, $exam_date, $exam_time, $exam_location) {
        $stmt = $this->db->prepare("INSERT INTO entrance_exams (application_id, exam_date, exam_time, exam_location, status) VALUES (?, ?, ?, ?, 'scheduled')");
        $stmt->bind_param("ssss", $application_id, $exam_date, $exam_time, $exam_location);
        if (!$stmt->execute()) {
            error_log("Schedule entrance exam failed: " . $stmt->error);
            return false;
        }

        // Update student_applications table
        $stmt_update_app = $this->db->prepare("UPDATE student_applications SET entrance_exam_scheduled = 1, entrance_exam_date = ?, entrance_exam_time = ?, entrance_exam_location = ?, admission_status = 'exam_scheduled' WHERE id = ?");
        $stmt_update_app->bind_param("ssss", $exam_date, $exam_time, $exam_location, $application_id);
        if (!$stmt_update_app->execute()) {
            error_log("Update student_applications for exam scheduling failed: " . $stmt_update_app->error);
            return false;
        }
        return true;
    }

    public function getEntranceExamDetails($application_id) {
        $stmt = $this->db->prepare("SELECT * FROM entrance_exams WHERE application_id = ? ORDER BY exam_id DESC LIMIT 1");
        $stmt->bind_param("s", $application_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function recordAdmissionTransaction($application_id, $amount, $payment_method, $status = 'Completed', $notes = null) {
        $transaction_date = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO admission_transactions (application_id, amount, transaction_date, payment_method, status, notes) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sdssss", $application_id, $amount, $transaction_date, $payment_method, $status, $notes);
            if ($stmt->execute()) {
                return true;
            } else {
                error_log("Error recording admission transaction: " . $stmt->error);
                return false;
            }
            $stmt->close();
        } else {
            error_log("Error preparing admission transaction statement: " . $this->db->error);
            return false;
        }
    }
}
?>
