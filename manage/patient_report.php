<?php namespace Ds3\Libraries\Legacy; ?><?php include 'includes/top.htm';?>
<br />
<span class="admin_head">
	Patients Report
</span>
<br />
<br />

<form name="patientreportfrm" action="patient_report_res.php" method="post" onsubmit="Javascript: return patientreportabc(this);">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr>
		<td valign="top" class="frmhead" width="20%">
			Select Date
		</td>
		<td valign="top" class="frmdata">
			<select name="d_mm" class="tbox" style="width:70px;">
				<option value="">MM</option>
				<?php  for($i=1 ; $i<=12 ; $i++){?>
					<option value="<?php echo $i;?>" >
						<?php echo $i?>
					</option>
				<?php  }?>
			</select>
			
			&nbsp;&nbsp;
			<select name="d_dd" class="tbox" style="width:70px;">
				<option value="">DD</option>
				<?php  for($i=1 ; $i<=31 ; $i++){?>
					<option value="<?php echo $i;?>" >
						<?php echo $i?>
					</option>
				<?php  }?>
			</select>
			
			&nbsp;&nbsp;
			<select name="d_yy" class="tbox" style="width:70px;">
				<option value="">YYYY</option>
				<?php  for($i=2010 ; $i<=date('Y') ; $i++){?>
					<option value="<?php echo $i;?>" >
						<?php echo $i?>
					</option>
				<?php  }?>
			</select>
			
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>TO</b>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			
			<select name="d_mm1" class="tbox" style="width:70px;">
				<option value="">MM</option>
				<?php  for($i=1 ; $i<=12 ; $i++){?>
					<option value="<?php echo $i;?>" >
						<?php echo $i?>
					</option>
				<?php  }?>
			</select>
			
			&nbsp;&nbsp;
			<select name="d_dd1" class="tbox" style="width:70px;">
				<option value="">DD</option>
				<?php  for($i=1 ; $i<=31 ; $i++){?>
					<option value="<?php echo $i;?>" >
						<?php echo $i?>
					</option>
				<?php  }?>
			</select>
			
			&nbsp;&nbsp;
			<select name="d_yy1" class="tbox" style="width:70px;">
				<option value="">YYYY</option>
				<?php  for($i=2010 ; $i<=date('Y') ; $i++){?>
					<option value="<?php echo $i;?>" >
						<?php echo $i?>
					</option>
				<?php  }?>
			</select>
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead">
			Referred BY
		</td>
		<td valign="top" class="frmdata">
			<?php 
			$referredby_sql = "select * from dental_contact where referrer=1 and status=1 and docid='".$_SESSION['docid']."' order by firstname";
			$referredby_my = $db->getResults($referredby_sql);
			?>
			<select name="referred_by" class="field text addr tbox">
				<option value=""></option>
				<?php  
				if ($referredby_my) foreach ($referredby_my as $referredby_myarray) {
					$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);?>
					<option value="<?php echo st($referredby_myarray['contactid'])?>" >
						<?php echo $ref_name;?>
					</option>
				<?php  }?>
			</select>
		</td>
	</tr>
	<tr>
		<td  colspan="2" align="center">
			<span class="red">
				* Required Fields					
			</span><br />
			<input type="hidden" name="monthlysub" value="1" />
			<input type="submit" value=" Run Report" class="button" />
		</td>
	</tr>
</table>
</form>

<?php  include 'includes/bottom.htm';?>
