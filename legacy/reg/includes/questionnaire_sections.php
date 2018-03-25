<?php
namespace Ds3\Libraries\Legacy;

if (!function_exists('questionnaireCompletedSections')) {
    function questionnaireCompletedSections ($patientId) {
        $db = new Db();

        $patientId = intval($patientId);

        $s = "SELECT last_reg_sect
            FROM dental_patients
            WHERE parent_patientid = '$patientId'
                OR patientid = '$patientId'
            ORDER BY last_reg_sect DESC";

        $r = $db->getRow($s);
        $qp = $r['last_reg_sect'] >= 5 ? 1 : 0;

        $s = "SELECT *
            FROM dental_q_page1
            WHERE patientid = '$patientId'
                OR parent_patientid = '$patientId'";
        $q1 = $db->getNumberRows($s) > 0 ? 1 : 0;

        $s = "SELECT *
            FROM dental_q_sleep
            WHERE patientid = '$patientId'
              OR parent_patientid = '$patientId'";
        $qs = $db->getNumberRows($s) > 0 ? 1 : 0;

        $s = "SELECT *
            FROM dental_q_page2
            WHERE patientid = '$patientId'
                OR parent_patientid = '$patientId'";
        $q2 = $db->getNumberRows($s) > 0 ? 1 : 0;

        $s = "SELECT *
            FROM dental_q_page3
            WHERE patientid = '$patientId'
                OR parent_patientid = '$patientId'";
        $q3 = $db->getNumberRows($s) > 0 ? 1 : 0;

        $comp = array();
        $comp['symptoms'] = $q1;
        $comp['epworth'] = $qs;
        $comp['treatments'] = $q2;
        $comp['history'] = $q3;
        $comp['registered'] = $qp;

        return $comp;
    }

    function show_section_completed($pid){
      $db = new Db();

      $links_title = "<p>The section you are trying to access has been completed. Please click any of the sections below to complete your Questionnaire:</p>";
      $links = '';

      $r = questionnaireCompletedSections($pid);

      if($r['symptoms']==0){
        $links .= "<p><a href=\"symptoms.php\">Symptoms</a></p>";
      }

      if($r['epworth']==0){ //includes symptoms check since ESS and TSS is updated on that page in FO.
        $links .= "<p><a href=\"sleep.php\">Epworth/Thorton Scale</a></p>";
      }

      if($r['treatments']==0){
        $links .= "<p><a href=\"treatments.php\">Treatments</a></p>";
      }

      if($r['history']==0){
        $links .= "<p><a href=\"history.php\">History</a></p>";
      }

      if($links==''){
        $s = "SELECT u.name, u.phone FROM dental_users u
            JOIN dental_patients p ON u.userid=p.docid
            WHERE p.patientid='".$db->escape($_SESSION['pid'])."'";
        $r = $db->getRow($s);
        echo "<p>All sections of questionnaire has been completed. Please <a href=\"index.php\">click here</a> to return to the home page. If you need to make changes to the questionnaire please contact ".$r['name']." at ".format_phone($r['phone'])."</p>";
      }else{
        echo $links_title . $links;
      }
    }
}
