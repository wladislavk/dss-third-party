
<?php

    $thesql = "select * from dental_patients where patientid='".mysql_real_escape_string($_REQUEST["pid"])."'";
        $themy = mysql_query($thesql);
        $themyarray = mysql_fetch_array($themy);


                $docsleep = st($themyarray["docsleep"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docsleep;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docsleep_name = $d['firstname']." ".$d['lastname'];
		  $docsleep_phone = $d['phone1'];
		  $docsleep_fax = $d['fax'];

                $docpcp = st($themyarray["docpcp"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docpcp;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docpcp_name = $d['firstname']." ".$d['lastname'];
		  $docpcp_phone = $d['phone1'];
		  $docpcp_fax = $d['fax'];

                $docdentist = st($themyarray["docdentist"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docdentist;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docdentist_name = $d['firstname']." ".$d['lastname'];
		  $docdentist_phone = $d['phone1'];
		  $docdentist_fax = $d['fax'];

                $docent = st($themyarray["docent"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docent;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docent_name = $d['firstname']." ".$d['lastname'];
		  $docent_phone = $d['phone1'];
		  $docent_fax = $d['fax'];

                $docmdother = st($themyarray["docmdother"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docmdother;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docmdother_name = $d['firstname']." ".$d['lastname'];
		  $docmdother_phone = $d['phone1'];
		  $docmdother_fax = $d['fax'];

                $docmdother2 = st($themyarray["docmdother2"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docmdother2;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $docmdother2_name = $d['firstname']." ".$d['lastname'];
                  $docmdother2_phone = $d['phone1'];
                  $docmdother2_fax = $d['fax'];

                $docmdother3 = st($themyarray["docmdother3"]);
                  $dsql = "SELECT dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
                                LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
                        WHERE contactid=".$docmdother3;
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
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
    <td><?= $docpcp_name; ?></td>
    <td><?= $docpcp_phone; ?></td>
    <td><?= $docpcp_fax; ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <tr>
    <td>Sleep Doctor</td>
    <td><?= $docsleep_name; ?></td>
    <td><?= $docsleep_phone; ?></td>
    <td><?= $docsleep_fax; ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <tr>
    <td>Dentist</td>
    <td><?= $docdentist_name; ?></td>
    <td><?= $docdentist_phone; ?></td>
    <td><?= $docdentist_fax; ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <tr>
    <td>ENT</td>
    <td><?= $docent_name; ?></td>
    <td><?= $docent_phone; ?></td>
    <td><?= $docent_fax; ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <tr>
    <td>MD Other</td>
    <td><?= $docmdother_name; ?></td>
    <td><?= $docmdother_phone; ?></td>
    <td><?= $docmdother_fax; ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <?php if($docmdother2!=''){ ?>
  <tr>
    <td>MD Other 2</td>
    <td><?= $docmdother2_name; ?></td>
    <td><?= $docmdother2_phone; ?></td>
    <td><?= $docmdother2_fax; ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <?php
  }
  if($docmdother3!=''){ ?>
  <tr>
    <td>MD Other 3</td>
    <td><?= $docmdother3_name; ?></td>
    <td><?= $docmdother3_phone; ?></td>
    <td><?= $docmdother3_fax; ?></td>
    <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
  </tr>
  <?php } ?>
</table>








