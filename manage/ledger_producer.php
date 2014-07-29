<?php include 'includes/top.htm';?>
<br />
<span class="admin_head">
	Ledger - Producer Reports
</span>
<br />
<br />
<form name="dailyfrm" action="ledger_producer_report.php<?php echo (isset($_GET['pid']))?"?pid=".$_GET['pid']:''; ?>" method="get" onSubmit="return dailyabc(this)">
<?php if(isset($_GET['pid'])){ ?>
<input type="hidden" name="pid" value="<?= $_GET['pid']; ?>" />
<?php } ?>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr>
		<td colspan="2" class="cat_head">
			Daily Ledger Report
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead" width="30%">
			Select Date
		</td>
		<td valign="top" class="frmdata">
			<select name="d_mm" class="tbox" style="width:70px;">
				<option value="">MM</option>
				<? for($i=1 ; $i<=12 ; $i++)
				{?>
					<option value="<?=$i;?>" <? if(date('m') == $i) echo " selected";?> >
						<?=$i?>
					</option>
				<? 
				}?>
			</select>
			
			&nbsp;&nbsp;
			<select name="d_dd" class="tbox" style="width:70px;">
				<option value="">DD</option>
				<? for($i=1 ; $i<=31 ; $i++)
				{?>
					<option value="<?=$i;?>" <? if(date('d') == $i) echo " selected";?>>
						<?=$i?>
					</option>
				<? 
				}?>
			</select>
			
			&nbsp;&nbsp;
			<select name="d_yy" class="tbox" style="width:70px;">
				<option value="">YYYY</option>
				<? for($i=2010 ; $i<=date('Y') ; $i++)
				{?>
					<option value="<?=$i;?>" <? if(date('Y') == $i) echo " selected";?>>
						<?=$i?>
					</option>
				<? 
				}?>
			</select>
			<span class="red">*</span>
		</td>
	</tr>
	 <tr>
		<td  colspan="2" align="center">
			<span class="red">
				* Required Fields					
			</span><br />
			<input type="hidden" name="dailysub" value="1" />
			<input type="submit" value=" Run Report" class="button" />
		</td>
	</tr>
</table>
</form>

<form name="weeklyfrm" action="ledger_producer_report.php<?php echo (isset($_GET['pid']))?"?pid=".$_GET['pid']:''; ?>" method="get" >
<?php if(isset($_GET['pid'])){ ?>
<input type="hidden" name="pid" value="<?= $_GET['pid']; ?>" />
<?php } ?>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr>
                <td colspan="2" class="cat_head">
                        Weekly Ledger Report
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead" width="30%">
                        Select Date
                </td>
                <td valign="top" class="frmdata">
                        <select name="d_mm" class="tbox" style="width:70px;">
                                <option value="">MM</option>
                                <? for($i=1 ; $i<=12 ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('m') == $i) echo " selected";?> >
                                                <?=$i?>
                                        </option>
                                <?
                            }?>
                        </select>

                        &nbsp;&nbsp;
                        <select name="d_dd" class="tbox" style="width:70px;">
                                <option value="">DD</option>
                                <? for($i=1 ; $i<=31 ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('d') == $i) echo " selected";?>>
                                                <?=$i?>
                                        </option>
                                <?
                                }?>
                        </select>

                        &nbsp;&nbsp;
                        <select name="d_yy" class="tbox" style="width:70px;">
                                <option value="">YYYY</option>
                                <? for($i=2010 ; $i<=date('Y') ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('Y') == $i) echo " selected";?>>
                                                <?=$i?>
                                        </option>
                                <?
                                }?>
                        </select>
                        <span class="red">*</span>
                </td>
        </tr>
         <tr>
                <td  colspan="2" align="center">
                        <span class="red">
                                * Required Fields
                        </span><br />
                        <input type="hidden" name="weeklysub" value="1" />
                        <input type="submit" value=" Run Report" class="button" />
                </td>
        </tr>
</table>
</form>

<br />

<form name="monthlyfrm" action="ledger_producer_report.php<?php echo (isset($_GET['pid']))?"?pid=".$_GET['pid']:''; ?>" method="get" onSubmit="return monthlyabc(this)">
<?php if(isset($_GET['pid'])){ ?>
<input type="hidden" name="pid" value="<?= $_GET['pid']; ?>" />
<?php } ?>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr>
		<td colspan="2" class="cat_head">
			Monthly Ledger Report
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead" width="30%">
			Select Date
		</td>
		<td valign="top" class="frmdata">
			<select name="d_mm" class="tbox" style="width:70px;">
				<option value="">MM</option>
				<? for($i=1 ; $i<=12 ; $i++)
				{?>
					<option value="<?=$i;?>" <? if(date('m') == $i) echo " selected";?> >
						<?=$i?>
					</option>
				<? 
				}?>
			</select>
			
			&nbsp;&nbsp;
			<select name="d_yy" class="tbox" style="width:70px;">
				<option value="">YYYY</option>
				<? for($i=2010 ; $i<=date('Y') ; $i++)
				{?>
					<option value="<?=$i;?>" <? if(date('Y') == $i) echo " selected";?>>
						<?=$i?>
					</option>
				<? 
				}?>
			</select>
			<span class="red">*</span>
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
<br />
<form name="monthlyfrm" action="ledger_producer_report.php<?php echo (isset($_GET['pid']))?"?pid=".$_GET['pid']:''; ?>" method="get" onSubmit="return monthlyabc(this)">
<?php if(isset($_GET['pid'])){ ?>
<input type="hidden" name="pid" value="<?= $_GET['pid']; ?>" />
<?php } ?>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr>
                <td colspan="2" class="cat_head">
                        Date Range Ledger Report
                </td>
        </tr>
        <tr>
                <td valign="top" class="frmhead" width="30%">
                        Select Date
                </td>
                <td valign="top" class="frmdata">
                        <select name="s_d_mm" class="tbox" style="width:70px;">
                                <option value="">MM</option>
                                <? for($i=1 ; $i<=12 ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('m')-1 == $i) echo " selected";?> >
                                                <?=$i?>
                                        </option>
                                <?
                                }?>
                        </select>
                        &nbsp;&nbsp;
                        <select name="s_d_dd" class="tbox" style="width:70px;">
                                <option value="">DD</option>
                                <? for($i=1 ; $i<=31 ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('d') == $i) echo " selected";?>>
                                                <?=$i?>
                                        </option>
                                <?
                                }?>
                        </select>

                        &nbsp;&nbsp;
                        <select name="s_d_yy" class="tbox" style="width:70px;">
                                <option value="">YYYY</option>
                                <? for($i=2010 ; $i<=date('Y') ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('Y') == $i) echo " selected";?>>
                                                <?=$i?>
                                        </option>
                                <?
                                }?>
                        </select>
                        <br />
                        <select name="e_d_mm" class="tbox" style="width:70px;">
                                <option value="">MM</option>
                                <? for($i=1 ; $i<=12 ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('m') == $i) echo " selected";?> >
                                                <?=$i?>
                                        </option>
                                <?
                                }?>
                        </select>
                        &nbsp;&nbsp;
                        <select name="e_d_dd" class="tbox" style="width:70px;">
                                <option value="">DD</option>
                                <? for($i=1 ; $i<=31 ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('d') == $i) echo " selected";?>>
                                                <?=$i?>
                                        </option>
                                <?
                                }?>
                        </select>

                        &nbsp;&nbsp;
                        <select name="e_d_yy" class="tbox" style="width:70px;">
                                <option value="">YYYY</option>
                                <? for($i=2010 ; $i<=date('Y') ; $i++)
                                {?>
                                        <option value="<?=$i;?>" <? if(date('Y') == $i) echo " selected";?>>
                                                <?=$i?>
                                        </option>
                                <?
                                }?>
                        </select>
                        <span class="red">*</span>
                </td>
        </tr>
         <tr>
                <td  colspan="2" align="center">
                        <span class="red">
                                * Required Fields
                        </span><br />
                        <input type="hidden" name="rangesub" value="1" />
                        <input type="submit" value=" Run Report" class="button" />
                </td>
        </tr>
</table>
</form>

<br />

<form name="patfrm" action="<?=$_SERVER['PHP_SELF'];?>?pid=<?php echo $_GET['pid']; ?>" method="get" onSubmit="return patabc(this)">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr>
		<td colspan="2" class="cat_head">
			Patient Report
		</td>
	</tr>
	<tr>
		<td valign="top" class="frmhead" width="30%">
			Patient's Last Name
		</td>
		<td valign="top" class="frmdata">
			<input type="text" name="pt_lastname" value="<?=$_GET['pt_lastname'];?>"  />
			<span class="red">*</span>
			<br />
			(Full / Part Lastname)
		</td>
	</tr>
	 <tr>
		<td  colspan="2" align="center">
			<span class="red">
				* Required Fields					
			</span><br />
			<input type="submit" value=" Search " class="button" />
		</td>
	</tr>
</table>
</form>

<? if($_GET['pt_lastname'] <> '')
{
	$pat_sql = "select * from dental_patients where docid='".mysql_real_escape_string($_SESSION['docid'])."' AND lastname like '%".s_for($_GET['pt_lastname'])."%' and status=1";
	$pat_my = mysql_query($pat_sql);
?>
<a name="pat_list"></a>
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="50%">
			Name
		</td>
		<td valign="top" class="col_head" width="20%">
			Select
		</td>
	</tr>
	<? if(mysql_num_rows($pat_my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center" style="color:#000000;">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		while($pat_myarray = mysql_fetch_array($pat_my))
		{
		?>
			<tr class="tr_active">
				<td valign="top">
					<?=st($pat_myarray["lastname"]);?>&nbsp;
					<?=st($pat_myarray["middlename"]);?>,&nbsp;
					<?=st($pat_myarray["firstname"]);?> 
				</td>
				<td valign="top">
					<a href="ledger_producer_report.php?pid=<?=st($pat_myarray["patientid"]);?>" class="dellink">
						Select</a>
				</td>
			</tr>
		<?
		}
	}?>

</table>
<script type="text/javascript">
	window.location = "#pat_list";
</script>
<? }?>

<br /><br />
<? include 'includes/bottom.htm';?>
