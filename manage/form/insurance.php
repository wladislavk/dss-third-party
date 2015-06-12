<?php namespace Ds3\Libraries\Legacy; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Health Insurance Claim Form</title>
<link rel="stylesheet" href="form.css" type="text/css" />
<style type="text/css">
<!--
.style1 {font-size: 16px}
-->
</style>
</head>

<body>
<table width="1185" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td align="left" valign="top">
			<span><div class="box_bg">1500</div></span>
			<span class="heading1">Health Insurance Claim Form</span><br />
			<span>Approved By National Uniform Claim Committee 08/05</span><br /><br />
			<span>
				<input name="pica1" type="text"  class="inbox_line1" maxlength="1"/>
				<input name="pica2" type="text"  class="inbox_line1" maxlength="1"/>
				<input name="pica3" type="text"  class="inbox_line1" maxlength="1"/>
				PICA
			</span>
		</td>
		<td align="left" valign="top">
			<span></span>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top">
			<table width="1185" border="1" cellspacing="0" cellpadding="2" bordercolor="#333333">
				<tr>
					<td colspan="2" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">
									<span class="num">1.</span> 
									Medicare
								</td>
								<td align="center" valign="top">
									MediCaID
								</td>
								<td align="center" valign="top">
									Tricare Champus
								</td>
								<td align="center" valign="top">
									Chmapva
								</td>
								<td align="center" valign="top">
									Group Health Plan
								</td>
								<td align="center" valign="top">
									Feca blklung
								</td>
								<td align="center" valign="top">
									Other 
								</td>
							</tr>
							<tr>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Medicare" />
									<span class="small_cap">(Medicare #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="MediCaID" />
									<span class="small_cap">(Medicaid #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Tricare Champus" />
									<span class="small_cap">(Sponsor's SSN)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Chmapva" />
									<span class="small_cap">(Member ID #)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Group Health Plan" />
									<span class="small_cap">(SSN or ID)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Feca blklung" />
									<span class="small_cap">(SSN)</span>
								</td>
								<td align="left" valign="top">
									<input name="insurance_type[]" type="checkbox" value="Other" />
									<span class="small_cap">(ID)</span>
								</td>
							</tr>
						</table>
					</td>
					<td width="448" align="left" valign="top">
						<span class="num_a">1a.</span>
						Insured's ID Number 
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<span class="small_cap">(For Program in item 1)</span>
						<br />
						<input type="text" name="insured_id_number" value="" size="60" />
					</td>
				</tr>
				<tr>
					<td width="429" align="left" valign="top">
						<span class="num">2.</span>
						Patient Name 
						<span class="small_cap">(Last Name, first Name, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" name="patient_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" name="patient_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" name="patient_middle" class="inbox_line3" size="3" width="30" />
						</div>
					</td>
					<td width="300" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num">3.</span> 
									Patient's Birth Date
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" name="p_dob_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="p_dob_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="p_dob_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table>
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br /><br />
									M 
									<input type="radio" name="p_sex" value="M" />
									&nbsp;&nbsp;F 
									<input type="radio" name="p_sex" value="F" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">4.</span> 
						Insured's Name &nbsp;
						<span class="small_cap">(Fisrt Name, Last Name, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" name="insured_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" name="insured_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" name="insured_middle" class="inbox_line3" size="3" width="30" />
						</div>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num">5.</span> 
						Patient's Address 
						<span class="small_cap">(No Street)</span>
						<br />
						<input type="text" name="patient_address" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num">6.</span> 
						Patient Relationship To Insured
						<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td align="left" valign="top">
									<span class="small_cap">Self</span>
									<input name="patient_relation_insured" type="radio" value="Self" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Spouse</span>
									<input name="patient_relation_insured" type="radio" value="Spouse" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Child</span>
									<input name="patient_relation_insured" type="radio" value="Child" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Others</span>
									<input name="patient_relation_insured" type="radio" value="Others" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">7.</span>
						Insured's Address 
						<span class="small_cap">(No.Street)</span>
						<br />
						<input name="insured_address" type="text" class="inbox_line3" size="28" />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input name="patient_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input name="patient_state" type="text" class="inbox_line3" size="3" width="30" />
								</td>
							</tr>
						</table>
					</td>
					<td rowspan="2" align="left" valign="top">
						<span class="num">8.</span> 
						Patient Status<br />
						<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td width="25%" align="left" valign="top">
									<span class="small_cap">Single</span>
									<br />
									<input name="patient_status" type="checkbox" value="Single" />
								</td>
								<td width="40%" align="left" valign="top">
									<span class="small_cap">Married</span>
									<br />
									<input name="patient_status" type="checkbox" value="Married" />
								</td>
								<td width="35%" align="left" valign="top">
									<span class="small_cap">Others</span>
									<br />
									<input name="patient_status" type="checkbox" value="Others" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top">
									<span class="small_cap">Employed</span>
									<br />
									<input name="patient_status" type="checkbox" value="Employed" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Full Time Student</span>
									<br />
									<input name="patient_status" type="checkbox" value="Full Time Student" />
								</td>
								<td align="left" valign="top">
									<span class="small_cap">Part Time Student</span>
									<br />
									<input name="patient_status" type="checkbox" value="Part Time Student" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									City<br />
									<input name="insured_city" type="text" class="inbox_line3" size="28"/>
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									State<br />
									<input name="insured_state" type="text" class="inbox_line3" size="3" width="30" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									Zip Code
									<br />
									<input name="patient_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone 
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">(
									<input type="text" name="patient_phone_code" size="3" class="inbox_line3" />
									)</span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" name="patient_phone" class="inbox_line3" size="13"  />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="115" align="left" valign="top">
									Zip Code
									<br />
									<input name="insured_zip" type="text" class="inbox_line3" size="13"  />
								</td>
								<td width="13" align="left" valign="top" class="b_line"></td>
								<td width="196" align="left" valign="top" style="padding-left:4px;">
									Telephone 
									<span class="small_cap">(Include Area Code)</span>
									<br />
									<span class="style1">(
									<input type="text" name="insured_phone_code" size="3" class="inbox_line3" />
									)</span>
									&nbsp;&nbsp;&nbsp;
									<input type="text" name="insured_phone" class="inbox_line3" size="13"  />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num">9.</span>
						Other Insured's Name 
						<span class="small_cap">(Last Name, first, Middle Initial)</span>
						<br />
						<div style="padding-top:7px;">
							<input type="text" name="other_insured_firstname" class="inbox_line3" size="18" />
							&nbsp;
							<input type="text" name="other_insured_lastname" class="inbox_line3" size="18" width="60" />
							&nbsp;
							<input type="text" name="other_insured_middle" class="inbox_line3" size="3" width="30" />
						</div>
					</td>
					<td rowspan="4" align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left" valign="top" style="line-height:33px;">
									<span class="num">10.</span>
									Is paitients Condition Related To :
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">a.</span> 
									Employment? 
									<span class="small_cap">(current Or Previous)</span>
									<br />
									<input type="radio" name="employment" value="YES" />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="employment" value="NO" />
									NO
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">b.</span> 
									Auto Accident? 
									<br />
									<input type="radio" name="auto_accident" value="YES" />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="auto_accident" value="NO" />
									NO
									&nbsp;&nbsp;
									Place<span class="small_cap">(State)</span>
									<input type="text" class="inbox_line3" size="10" name="auto_accident_place" />
								</td>
							</tr>
							<tr>
								<td align="left" valign="top" style="line-height:25px;">
									<span class="num_a">c.</span> 
									Other Accident? 
									<br />
									<input type="radio" name="other_accident" value="YES" />
									Yes
									&nbsp;&nbsp;
									<input type="radio" name="other_accident" value="NO" />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num">11.</span>
						Insured's Policy Group or FECA Number
						<br />
						<input name="insured_policy_group_feca" type="text" class="inbox_line3" size="28"/>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">a.</span>
						Other Insured's policy Or Group Number
						<br />
						<input name="other_insured_policy_group_feca" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num_a">a.</span> 
									Insured's Birth Date
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" name="insured_dob_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="insured_dob_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="insured_dob_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table>
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br /><br />
									M 
									<input type="radio" name="insured_sex" value="M" />
									&nbsp;&nbsp;F 
									<input type="radio" name="insured_sex" value="F" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num_a">b.</span> 
									Other Insured's Birth Date
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" name="other_insured_dob_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="other_insured_dob_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="other_insured_dob_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table>
								</td>
								<td width="42%" align="center" valign="top">
									Sex
									<br /><br />
									M 
									<input type="radio" name="other_insured_sex" value="M" />
									&nbsp;&nbsp;F 
									<input type="radio" name="other_insured_sex" value="F" />
								</td>
							</tr>
						</table>
					</td>
					<td align="left" valign="top">
						<span class="num_a">b.</span>
						Employer's Name or School Name
						<br />
						<input name="insured_employer_school_name" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Employer's Name or School Name
						<br />
						<input name="other_insured_employer_school_name" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">c.</span>
						Insurance Plan Name or Program Name
						<br />
						<input name="insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
				</tr>
				<tr>
					<td align="left" valign="top">
						<span class="num_a">d.</span>
						Insurance Plan Name or Program Name
						<br />
						<input name="other_insured_insurance_plan" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">10d.</span>
						Reserved For local use
						<br />
						<input name="reserved_local_use" type="text" class="inbox_line3" size="28"  />
					</td>
					<td align="left" valign="top">
						<span class="num_a">d.</span> 
						Is there another helth benefit Plan?
						<br />
						<input type="radio" name="another_plan" value="YES" />YES
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="another_plan" value="NO" />NO
						&nbsp;&nbsp;
						<span class="small_cap"><i>if yes, return to and complete item 9 a-d</i></span>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="left" valign="top">
						<center style="text-align:center; font-weight:bold">
							Read Back of Form Before Completing & Signing This Form
						</center>
						<span class="num">12.</span>
						Patient's or Authorized Person's Signature
						<span class="small_cap"> I authorize the release of any medical or other information neccessary to process this claim. I also reuest payment of government benefits either to myself or th the party who accepts assignment below.</span>
						<br /><br /><br />
						
						Signature
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						Date:
						<input type="text" name="insured_signed_date" size="10" class="inbox_line3" />
					</td>
					<td align="left" valign="top">
						<span class="num">13.</span>
						Insured's or Authorized person's Signature
						<span class="small_cap"> I authorize payment of medical benefits to the undersigned physician or supplier for services described below</span>
						<br /><br /><br />
						
						Signature
						
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="58%" align="left" valign="top">
									<span class="num">14.</span> 
									Date of Current
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" name="date_current_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="date_current_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="date_current_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table>
								</td>
								<td width="2%" align="left" valign="top">
									<font size="7"><b>&lt;</b></font>
								</td>
								<td width="40%" align="left" valign="middle">
									Illness
									<span class="small_cap"> (First sympton)</span>
									OR
									<br />
									Injury
									<span class="small_cap"> (Accident)</span>
									OR
									<br />
									Pregnancy
									<span class="small_cap"> (LMP)</span>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">15.</span> 
						If Patient has had same or similar Illness. Give First Date
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" valign="top">MM</td>
								<td rowspan="2" align="left" valign="top" class="dot_line"></td>
								<td align="center" valign="top">DD</td>
								<td rowspan="2" align="left" valign="top" class="dot_line"></td>
								<td align="center" valign="top">YY</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<input type="text" name="same_illness_m" class="inbox_line3" size="3"/>
								</td>
								<td align="center" valign="top">
									<input type="text" name="same_illness_d" class="inbox_line3" size="3"/>
								</td>
								<td align="center" valign="top">
									<input type="text" name="same_illness_y" class="inbox_line3" size="3"/>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">16.</span> 
						Dates Patient unable to work in Current Occupation
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="middle" width="10%">
									From 
								</td>
								<td valign="top" width="40%">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" name="unable_date_from_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="unable_date_from_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="unable_date_from_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table>
								</td>
								
								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" name="unable_date_to_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="unable_date_to_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="unable_date_to_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">17.</span> 
						Name of Referring Provider or Other Source
						<input type="text" name="referring_provider" class="inbox_line3" size="40" />
					</td>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="10%" style="border-bottom: 1px #000000 dashed;">
									<span class="num">17<span class="num_a">a.</span></span> 
								</td>
								<td valign="top" width="10%" style="border-bottom: 1px #000000 dashed;">&nbsp;
									
								</td>
								<td valign="top" width="80%" style="border-bottom: 1px #000000 dashed; padding-bottom:3px;">
									<input type="text" name="field_17a" class="inbox_line3" size="30"/>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<span class="num">17<span class="num_a">b.</span></span> 
								</td>
								<td valign="top">
									NPI
								</td>
								<td valign="top" style="padding-top:3px;">
									<input type="text" name="field_17b" class="inbox_line3" size="30"/>
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">18.</span> 
						Hospitalization Dates Related to Current Services
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="middle" width="10%">
									From 
								</td>
								<td valign="top" width="40%">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" name="hospitalization_date_from_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="hospitalization_date_from_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="hospitalization_date_from_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table>
								</td>
								
								<td valign="middle" align="right" width="10%">
									To
								</td>
								<td valign="top" width="40%">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">MM</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">DD</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">YY</td>
										</tr>
										<tr>
											<td align="center" valign="top">
												<input type="text" name="hospitalization_date_to_m" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="hospitalization_date_to_d" class="inbox_line3" size="3"/>
											</td>
											<td align="center" valign="top">
												<input type="text" name="hospitalization_date_to_y" class="inbox_line3" size="3"/>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<span class="num">19.</span> 
						Reserved for Local Use<br />
						<input type="text" name="reserved_local_use" class="inbox_line3" size="100" />
					</td>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td valign="top" width="40%">
									<span class="num">20.</span> 
									Outside Lab?
									<br />
									<input type="radio" name="outside_lab" value="YES" />
									YES
									&nbsp;&nbsp;
									<input type="radio" name="outside_lab" value="NO" />
									NO
								</td>
								<td valign="top" width="60%">
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									S Charges
									<br />
									<input type="text" name="s_charges" class="inbox_line3" size="30" />
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2" rowspan="2">
						<span class="num">21.</span> 
						Diagnosis or Nature of Illness or Injury 
						<span class="small_cap">
							(Relate Items 1, 2, 3, 4 to Item 24E by line)
						</span>
						
						<table width="100%" cellpadding="0" cellspacing="5" border="0">
							<tr>
								<td valign="top" width="50%">
									<b>1.</b>
									<input type="text" name="diagnosis_1" class="inbox_line3" size="40" />
								</td>
								<td valign="top" width="50%">
									<b>3.</b>
									<input type="text" name="diagnosis_3" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top">
									<b>2.</b>
									<input type="text" name="diagnosis_2" class="inbox_line3" size="40" />
								</td>
								<td valign="top">
									<b>4.</b>
									<input type="text" name="diagnosis_4" class="inbox_line3" size="40" />
								</td>
							</tr>
						</table>
					</td>
					<td valign="top">
						<span class="num">22.</span> 
						Medicaid Resubmission Code
						<input type="text" name="medicaid_resubmission_code" class="inbox_line3" size="30" />
						<br />
						Original Ref. No.
						<input type="text" name="original_ref_no" class="inbox_line3" size="30" />
						
					</td>
				</tr>
				<tr>
					<td valign="top">
						<span class="num">23.</span> 
						Prior Authorization Number
						<br />
						<input type="text" name="prior_authorization_number" class="inbox_line3" size="60" />
					</td>
				</tr>
				
				<tr>
					<td valign="top" colspan="3">
						<span class="num">24.</span> 
						<table width="100%" cellpadding="3" cellspacing="1" border="0" bgcolor="#000000" >
							<tr bgcolor="#FFFFFF">
								<td valign="top" rowspan="2" align="center">
									&nbsp;
								</td>
								<td valign="top" colspan="2" align="center">
									<span class="num_a">A.</span> 
									Date(s) of service
								</td>
								<td valign="top" align="center">
									<span class="num_a">B.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">C.</span>
								</td>
								<td valign="top" colspan="5" align="center">
									<span class="num_a">D.</span>
									Procedures, Services or Supplies
									<br /> 
									<span class="small_cap">
										(Explain Unusual Circumstances)
									</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">E.</span>
								</td>
								<td valign="top" colspan="2" align="center">
									<span class="num_a">F.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">G.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">H.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">I.</span>
								</td>
								<td valign="top" align="center">
									<span class="num_a">J.</span>
								</td>
							</tr>
							
							<tr bgcolor="#FFFFFF">
								<td valign="bottom" align="center">
									<span class="small_cap">
										From
										<br />
										MM
										&nbsp;&nbsp;&nbsp;
										DD
										&nbsp;&nbsp;&nbsp;
										YY
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										To
										<br />
										MM
										&nbsp;&nbsp;&nbsp;
										DD
										&nbsp;&nbsp;&nbsp;
										YY
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										PLACE OF <br />SERVICE
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										EMG
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										CPT/HCPCS
									</span>
								</td>
								<td valign="bottom" align="center" colspan="4">
									<span class="small_cap">
										MODIFIER
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										DIAGNOSIS <br />POINTER
									</span>
								</td>
								<td valign="bottom" align="center" colspan="2">
									<span class="small_cap">
										S CHARGES
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										DAYS <br />OR <br />UNITS
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										EPSDT <br />Family <br />Plan
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										ID. <br />QUAL.
									</span>
								</td>
								<td valign="bottom" align="center">
									<span class="small_cap">
										RENDERING <br />PROVIDER ID. #
									</span>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">1</span>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date1_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date1_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date1_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date1_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date1_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date1_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<input type="text" name="place_of_service1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="emg1" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="cpt_hcpcs1" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier1_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier1_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier1_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier1_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="diagnosis_pointer1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges1_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges1_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="days_or_units1" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="epsdt_family_plan1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="id_qua1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="rendering_provider_id1" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">2</span>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date2_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date2_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date2_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date2_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date2_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date2_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<input type="text" name="place_of_service2" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="emg2" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="cpt_hcpcs2" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier2_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier2_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier2_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier2_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="diagnosis_pointer2" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges2_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges2_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="days_or_units2" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="epsdt_family_plan2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="id_qua2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="rendering_provider_id2" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">3</span>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date3_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date3_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date3_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date3_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date3_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date3_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<input type="text" name="place_of_service3" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="emg3" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="cpt_hcpcs3" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier3_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier3_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier3_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier3_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="diagnosis_pointer3" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges3_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges3_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="days_or_units3" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="epsdt_family_plan3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="id_qua3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="rendering_provider_id3" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">4</span>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date4_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date4_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date4_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date4_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date4_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date4_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<input type="text" name="place_of_service4" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="emg4" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="cpt_hcpcs4" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier4_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier4_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier4_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier4_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="diagnosis_pointer4" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges4_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges4_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="days_or_units4" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="epsdt_family_plan4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="id_qua4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="rendering_provider_id4" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">5</span>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date5_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date5_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date5_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date5_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date5_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date5_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<input type="text" name="place_of_service5" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="emg5" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="cpt_hcpcs5" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier5_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier5_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier5_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier5_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="diagnosis_pointer5" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges5_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges5_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="days_or_units5" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="epsdt_family_plan5" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="id_qua5" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="rendering_provider_id5" class="inbox_line3" size="15"/>
								</td>
							</tr>
							<tr bgcolor="#FFFFFF">
								<td valign="top">
									<span class="num">6</span>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date6_from_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date6_from_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date6_from_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td align="center" valign="top">
												<input type="text" name="service_date6_to_m" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date6_to_d" class="inbox_line3" size="1"/>
											</td>
											<td rowspan="2" align="left" valign="top" class="dot_line"></td>
											<td align="center" valign="top">
												<input type="text" name="service_date6_to_y" class="inbox_line3" size="1"/>
											</td>
										</tr>
									</table>
								</td>
								<td valign="top">
									<input type="text" name="place_of_service6" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="emg6" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="cpt_hcpcs6" class="inbox_line3" size="12"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier6_1" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier6_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier6_3" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="modifier6_4" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="diagnosis_pointer6" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges6_1" class="inbox_line3" size="10"/>
								</td>
								<td valign="top">
									<input type="text" name="s_charges6_2" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="days_or_units6" class="inbox_line3" size="3"/>
								</td>
								<td valign="top">
									<input type="text" name="epsdt_family_plan6" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="id_qua6" class="inbox_line3" size="1"/>
								</td>
								<td valign="top">
									<input type="text" name="rendering_provider_id6" class="inbox_line3" size="15"/>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				
				<tr>
					<td valign="top" colspan="2">
					
						<table width="100%" cellpadding="1" cellspacing="1" border="0" bgcolor="#000000">
							<tr bgcolor="#FFFFFF">
								<td valign="top" width="40%">
									<table width="100%" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td valign="top" width="80%">
												<span class="num">25.</span> 
												Federal Tax I.D.Number
												<br />
												<input type="text" name="federal_tax_id_number" size="20" class="inbox_line3" />
											</td>
											<td valign="top" width="10%" align="center">
												SSN
												<br />
												<input type="checkbox" name="ssn" value="1" />
											</td>
											<td valign="top" width="10%" align="center">
												EIN
												<br />
												<input type="checkbox" name="ein" value="1" />
											</td>
										</tr>
									</table>
								</td>
								<td valign="top" width="30%">
									<span class="num">26.</span> 
									Patient Account No.
									<br />
									<input type="text" name="patient_account_no" class="inbox_line3" size="20" />
								</td>
								<td valign="top" width="30%">
									<span class="num">27.</span> 
									Accept Assignment?
									<br />
									<span class="small_cap">(For govt. claims, see back)</span>
									<br />
									<input type="radio" name="accept_assignment" value="YES" />
									YES
									&nbsp;&nbsp;&nbsp;
									<input type="radio" name="accept_assignment" value="NO" />
									NO
								</td>
							</tr>
						</table>
					</td>
					<td valign="top" colspan="2">
					
						<table width="100%" cellpadding="1" cellspacing="1" border="0" bgcolor="#000000">
							<tr bgcolor="#FFFFFF">
								<td valign="top" width="33%">
									<span class="num">28.</span> 
									Total Charge
									<br />
									$ <input type="text" name="total_charge" class="inbox_line3" size="15" />
								</td>
								<td valign="top" width="33%">
									<span class="num">29.</span> 
									Amount Paid
									<br />
									$ <input type="text" name="amount_paid" class="inbox_line3" size="15" />
								</td>
								<td valign="top" width="33%">
									<span class="num">30.</span> 
									Balance Due
									<br />
									$ <input type="text" name="balance_due" class="inbox_line3" size="15" />
									<br />
									<span class="small_cap">&nbsp;</span>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2">
						<table width="100%" cellpadding="1" cellspacing="1" border="0" bgcolor="#000000">
							<tr bgcolor="#FFFFFF">
								<td valign="top" width="50%">
									<span class="num">31.</span> 
									Signature of Physician or Supplier Including Degrees or Credentals
									<span class="small_cap">
										(I certify that the statements on the reverse apply to this bill and are made a part thereof.)
									</span>
									<br />
									<input type="text" class="inbox_line3" size="40" name="signature_physician" />
									<br /><br />
									Signed
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									Date: 
									<input type="text" name="physician_signed_date" class="inbox_line3" size="10" />
								</td>
								<td valign="top" width="50%">
									<span class="num">32.</span> 
									Service Facility Location Information
									<table width="100%" cellpadding="1" cellspacing="1" border="0">
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">Name:</span>		
											</td>
											<td valign="top" width="90%">
												<input type="text" name="service_facility_info_name" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">Address:</span>		
											</td>
											<td valign="top" width="90%">
												<input type="text" name="service_facility_info_address" class="inbox_line3" size="40" />
											</td>
										</tr>
										<tr>
											<td valign="top" width="10%">
												<span class="small_cap">City/State/Zip:</span>		
											</td>
											<td valign="top" width="90%">
												<input type="text" name="service_facility_info_city" class="inbox_line3" size="40" />
											</td>
										</tr>
									</table>
									<span class="num_a">
										a.
									</span>
									<input type="text" name="service_info_a" class="inbox_line3" size="15" />
									
									<span class="num_a">
										b.
									</span>
									<select name="service_info_dd" class="inbox_line3">
										<option value=""></option>
									</select>
									<input type="text" name="service_info_b_other" class="inbox_line3" size="15" />
								</td>
							</tr>
						</table>
					</td>
					
					<td valign="top" >
						<span class="num">33.</span> 
						Billing Provider Info & Ph#
						<span class="style1">(
						<input type="text" name="billing_provider_phone_code" size="3" class="inbox_line3" />
						)</span>
						&nbsp;&nbsp;&nbsp;
						<input type="text" name="billing_provider_phone" class="inbox_line3" size="13"  />
						<table width="100%" cellpadding="1" cellspacing="1" border="0">
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Name:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" name="billing_provider_name" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">Address:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" name="billing_provider_address" class="inbox_line3" size="40" />
								</td>
							</tr>
							<tr>
								<td valign="top" width="10%">
									<span class="small_cap">City/State/Zip:</span>		
								</td>
								<td valign="top" width="90%">
									<input type="text" name="billing_provider_city" class="inbox_line3" size="40" />
								</td>
							</tr>
						</table>
						<span class="num_a">
							a.
						</span>
						<input type="text" name="billing_provider_a" class="inbox_line3" size="15" />
						
						<span class="num_a">
							b.
						</span>
						<select name="billing_provider_dd" class="inbox_line3">
							<option value=""></option>
						</select>
						<input type="text" name="billing_provider_b_other" class="inbox_line3" size="15" />
					</td>
				</tr>
				
				
				
				
				
			
			</table>
		</td>
	</tr>
</table>

<br /><br />
</body>
</html>
