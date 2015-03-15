<?php namespace Ds3\Legacy; ?><h3 class="sect_header">Treatment Summary</h3>
<div class="box">
<?php include 'appointment_summary.php'; ?>
</div>

<h3 class="sect_header">Previous Treatments</h3>
<div class="box">

<?php

$sql = "select * from dental_q_page2 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
$myarray = $db->getRow($sql);

$other_therapy = st($myarray['other_therapy']);
$dd_wearing = st($myarray['dd_wearing']);
$dd_prev = st($myarray['dd_prev']);
$dd_otc = st($myarray['dd_otc']);
$dd_fab = st($myarray['dd_fab']);
$dd_who = st($myarray['dd_who']);
$dd_experience = st($myarray['dd_experience']);
$surgery = st($myarray['surgery']);

if($dd_wearing == '' &&
    $dd_prev == '' &&
    $dd_otc == '' &&
    $dd_fab == '' &&
    $dd_who == '' &&
    $dd_experience == '' &&
    $surgery == '' &&
    $other_therapy == ''){
?>
<p>No previous treatments documented.</p>

<?php
}else{  
?>
    <label class="desc" id="title0" for="Field0">
        Dental Devices
    </label>
<?php if($dd_wearing != ''){ ?>
    <div>
        <span>
            Are you currently wearing a dental device?
            <?php echo $dd_wearing; ?>
        </span>
    </div>
    <?php } 
    if($dd_prev != ''){ ?>
    <div>
        <span>
            Have you previously tried a dental device?
            <?php echo $dd_prev; ?>
        </span>
    </div>
    <?php 
    } 
    if($dd_otc != ''){ ?>
    <div class="dd_options">
        <span>
            Was it over-the-counter (OTC)?
            <?php echo $dd_otc; ?>
        </span>
    </div>
    <?php 
    }
    if($dd_fab != ''){ ?>
    <div class="dd_options">
        <span>
            Was it fabricated by a dentist?
            <?php echo $dd_fab; ?>
        <span>
    </div>
    <?php 
    }
    if($dd_who != ''){ ?>
    <div class="dd_options">
        <span>
            Who: <?php echo $dd_who; ?>
        </span>
    </div>
    <?php 
    } 
    if($dd_experience != ''){ ?>
    <div class="dd_options">
        <span>
            Describe your experience<br />
            <?php echo $dd_experience; ?>
        </span>
    </div>
    <?php } ?>
    <label class="desc" id="title0" for="Field0">
        Surgery
    </label>
    <?php if($surgery != ''){ ?>
    <div>
        <span>
            Have you had surgery for snoring or sleep apnea?
            <?php echo $surgery; ?>
        </span>
    </div>
    <?php }

    $s_sql = "SELECT * FROM dental_q_page2_surgery WHERE patientid='".mysqli_real_escape_string($con,$_REQUEST['pid'])."'";
    $s_q = $db->getResults($s_sql);
    $s_num = count($s_q);
    if($s_num != 0){ ?>
    <div class="s_options">
        <span>
            Please list any nose, palatal, throat, tongue, or jaw surgeries you have had.  (each is individual text field in SW)
            <table id="surgery_table">
                <tr>
                    <th>Date</th>
                    <th>Surgeon</th>
                    <th>Surgery</th>
                    <th></th>
                </tr>
        <?php
            $s_count = 0;
            foreach ($s_q as $s_row) { ?>
                <tr id="surgery_row_<?php echo $s_count; ?>">
                    <td><?php echo $s_row['surgery_date']; ?></td>
                    <td><?php echo $s_row['surgeon']; ?></td>
                    <td><?php echo $s_row['surgery']; ?></td>
                </tr>
        <?php
                $s_count++;
            } ?>
            </table>
        </span>
    </div>
    <?php }
    if($other_therapy != ''){ ?>
    <label class="desc" id="title0" for="Field0">
        OTHER ATTEMPTED THERAPIES
    </label>
    <div>
        <span>
            <?php echo $other_therapy;?>
        </span>
    </div>
	<?php } 
} ?>
</div>
