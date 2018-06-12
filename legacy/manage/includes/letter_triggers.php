<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once('../admin/includes/general.htm');

function trigger_letter5($pid, $info_id) {
        $letterid = '5';
        $topatient = '1';
        $letter = create_letter($letterid, $pid, $info_id, $topatient, '', '', '', '', 'email');
        if (is_numeric($letter)) {
                return $letter;
        }
}

function trigger_letter6($pid, $info_id) {
        $letterid = '6';
        $topatient = '1';
        $letter = create_letter($letterid, $pid, $info_id, $topatient, '', '', '', '', 'paper');
        if (is_numeric($letter)) {
                return $letter;
        }
}

function trigger_letter7($pid, $info_id) {
  $letterid = '7';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
                $letter = create_letter($letterid, $pid, $info_id, '', $md_list, $md_referral_list);
                if (is_numeric($letter)) {
                        return $letter;
                }
}

function trigger_letter8($pid, $info_id) {
  $letterid = '8';
  $topatient = '1';
  $letter = create_letter($letterid, $pid, $info_id, $topatient);
  if (is_numeric($letter)) {
    return $letter;
  }
}

function trigger_letter9($pid, $info_id) {
  $letterid = '9';
  $md_list = '';
  $md_referral_list = get_mdreferralids($pid);

                $letter = create_letter($letterid, $pid, $info_id, '', $md_list, $md_referral_list);
                if (is_numeric($letter)) {
                        return $letter;
                }
}

function trigger_letter10($pid, $info_id) {
  $letterid = '10';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
                $letter = create_letter($letterid, $pid, $info_id, '', $md_list, $md_referral_list);
                if (is_numeric($letter)) {
                        return $letter;
                }
}

function trigger_letter11($pid, $info_id) {
  $letterid = '11';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
                $letter = create_letter($letterid, $pid, $info_id, '', $md_list, $md_referral_list);
                if (is_numeric($letter)) {
                        return $letter;
                }
}

function trigger_letter13($pid, $info_id) {
  $letterid = '13';
  $md_list = get_mdcontactids($pid);
  $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $info_id, '', $md_list, $md_referral_list);
  if (is_numeric($letter)) {
    return $letter;
  }
}

function trigger_letter16($pid, $info_id) {
  $letterid = '16';
  $topatient = '1';
  $md_list = get_mdcontactids($pid);
        $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $info_id, $topatient, $md_list, $md_referral_list);
  if (is_numeric($letter)) {
    return $letter;
  }
}

function trigger_letter17($pid, $info_id) {
  $letterid = '17';
  $topatient = '1';
  $md_list = get_mdcontactids($pid);
        $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $info_id, $topatient, $md_list, $md_referral_list);
  if (is_numeric($letter)) {
    return $letter;
  }
}

function trigger_letter19($pid, $info_id) {
  $letterid = '19';
  $topatient = '1';
  $md_list = get_mdcontactids($pid);
        $md_referral_list = get_mdreferralids($pid);
  $letter = create_letter($letterid, $pid, $info_id, $topatient, $md_list, $md_referral_list);
  if (is_numeric($letter)) {
    return $letter;
  }
}

function trigger_letter20($pid) {
  $letterid = '20';
  $md_list = get_mdcontactids($pid);
        $pt_referral_list = get_ptreferralids($pid);
  $letter = create_letter($letterid, $pid, '', '', $md_list, $pt_referral_list);
  if (is_numeric($letter)) {
    return $letter;
  }
}

function trigger_letter21($pid, $info_id) {
  $letterid = '21';
  $topatient = '1';
  $letter = create_letter($letterid, $pid, $info_id, $topatient, '', '');
  if (is_numeric($letter)) {
    return $letter;
  }
}


function trigger_letter24($pid, $info_id) {
  $letterid = '24';
  $topatient = '1';
  $letter = create_letter($letterid, $pid, $info_id, $topatient);
  if (is_numeric($letter)) {
    return $letter;
  }
}

?>
