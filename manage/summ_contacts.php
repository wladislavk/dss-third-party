
<?php

    $thesql = "select * from dental_patients where patientid='".mysql_real_escape_string($_REQUEST["pid"])."'";
        $themy = mysql_query($thesql);
        $themyarray = mysql_fetch_array($themy);


                $docsleep = st($themyarray["docsleep"]);
                  $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docsleep;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docsleep_id = $d['contactid'];
                  $docsleep_name = $d['firstname']." ".$d['lastname'];
		  $docsleep_phone = $d['phone1'];
		  $docsleep_fax = $d['fax'];

                $docpcp = st($themyarray["docpcp"]);
                  $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docpcp;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
		  $docpcp_id = $d['contactid'];
                  $docpcp_name = $d['firstname']." ".$d['lastname'];
		  $docpcp_phone = $d['phone1'];
		  $docpcp_fax = $d['fax'];

                $docdentist = st($themyarray["docdentist"]);
                  $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docdentist;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docdentist_id = $d['contactid'];
                  $docdentist_name = $d['firstname']." ".$d['lastname'];
		  $docdentist_phone = $d['phone1'];
		  $docdentist_fax = $d['fax'];

                $docent = st($themyarray["docent"]);
                  $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docent;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docent_id = $d['contactid'];
                  $docent_name = $d['firstname']." ".$d['lastname'];
		  $docent_phone = $d['phone1'];
		  $docent_fax = $d['fax'];

                $docmdother = st($themyarray["docmdother"]);
                  $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docmdother;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docmdother_id = $d['contactid'];
                  $docmdother_name = $d['firstname']." ".$d['lastname'];
		  $docmdother_phone = $d['phone1'];
		  $docmdother_fax = $d['fax'];

                $docmdother2 = st($themyarray["docmdother2"]);
                  $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docmdother2;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docmdother2_id = $d['contactid'];
                  $docmdother2_name = $d['firstname']." ".$d['lastname'];
                  $docmdother2_phone = $d['phone1'];
                  $docmdother2_fax = $d['fax'];

                $docmdother3 = st($themyarray["docmdother3"]);
                  $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docmdother3;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docmdother3_id = $d['contactid'];
                  $docmdother3_name = $d['firstname']." ".$d['lastname'];
                  $docmdother3_phone = $d['phone1'];
                  $docmdother3_fax = $d['fax'];
?>
<table width="100%">
  <tr>
    <th>Type</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Fax</th>
    <th></th>
  </tr>
  <tr>
    <td>Primary Care</td>
    <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docpcp_id; ?>'); return false;"><?= $docpcp_name; ?></a></td>
    <td><?= format_phone($docpcp_phone); ?></td>
    <td><?= format_phone($docpcp_fax); ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <tr>
    <td>Sleep Doctor</td>
    <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docsleep_id; ?>'); return false;"><?= $docsleep_name; ?></a></td>
    <td><?= format_phone($docsleep_phone); ?></td>
    <td><?= format_phone($docsleep_fax); ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <tr>
    <td>Dentist</td>
    <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docdentist_id; ?>'); return false;"><?= $docdentist_name; ?></a></td>
    <td><?= format_phone($docdentist_phone); ?></td>
    <td><?= format_phone($docdentist_fax); ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <tr>
    <td>ENT</td>
    <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docent_id; ?>'); return false;"><?= $docent_name; ?></a></td>
    <td><?= format_phone($docent_phone); ?></td>
    <td><?= format_phone($docent_fax); ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <tr>
    <td>MD Other</td>
    <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docmdother_id; ?>'); return false;"><?= $docmdother_name; ?></a></td>
    <td><?= format_phone($docmdother_phone); ?></td>
    <td><?= format_phone($docmdother_fax); ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <?php if($docmdother2!=''){ ?>
  <tr>
    <td>MD Other 2</td>
    <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docmdother2_id; ?>'); return false;"><?= $docmdother2_name; ?></a></td>
    <td><?= format_phone($docmdother2_phone); ?></td>
    <td><?= format_phone($docmdother2_fax); ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <?php
  }
  if($docmdother3!=''){ ?>
  <tr>
    <td>MD Other 3</td>
    <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docmdother3_id; ?>'); return false;"><?= $docmdother3_name; ?></a></td>
    <td><?= format_phone($docmdother3_phone); ?></td>
    <td><?= format_phone($docmdother3_fax); ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <?php } ?>
</table>








