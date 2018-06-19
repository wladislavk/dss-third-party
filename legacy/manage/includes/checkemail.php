<?php
namespace Ds3\Libraries\Legacy;

function checkEmail($e, $i)
{
    $db = new Db();

    if(trim($e) == ''){
        $n = 0;
    }else{
        $s = "SELECT patientid FROM dental_patients WHERE 
            email='".$db->escape($e)."' AND 
            ((patientid!='".$db->escape($i)."' AND 
            parent_patientid!='".$db->escape($i)."') OR 
            (patientid!='".$db->escape($i)."' AND 
            parent_patientid IS NULL)) ";
        $n = $db->getNumberRows($s);
    }
    return $n;
}

function checkUserEmail($e, $i)
{
    $db = new Db();

    if(trim($e) == ''){
        $n = 0;
    } else {
        $s = "SELECT userid FROM dental_users WHERE 
            email='".$db->escape($e)."' AND 
            userid!='".$db->escape($i)."'";
        $n = $db->getNumberRows($s);
    }
    return $n;
}

function checkUsername($u, $i)
{
    $db = new Db();
    
    if(trim($u) == ''){
        $n = 0;
    }else{
        $s = "SELECT userid FROM dental_users WHERE 
            username='".$db->escape(trim($u))."' AND 
            userid!='".$db->escape($i)."'";
        $n = $db->getNumberRows($s);
    }
    return $n;
}
