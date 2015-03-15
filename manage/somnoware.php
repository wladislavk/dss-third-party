<?php namespace Ds3\Legacy; ?><?php

require_once 'admin/includes/config.php';
$sql = "SELECT * FROM dental_patients WHERE patientid=112";
$q = mysql_query($sql);
$pat = mysql_fetch_assoc($q);


$pm_sql = "SELECT * FROM dental_contact where contactid='".mysql_real_escape_string($pat['p_m_ins_co'])."'";
$pm_q = mysql_query($pm_sql);
$pm = mysql_fetch_assoc($pm_q);

$sm_sql = "SELECT * FROM dental_contact where contactid='".mysql_real_escape_string($pat['s_m_ins_co'])."'";
$sm_q = mysql_query($sm_sql);
$sm = mysql_fetch_assoc($sm_q);

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<DSSReferral>
	<Client_ID>761f41f1-4ff8-4cee-960f-5e5809581db2</Client_ID>
	<REFERRAL_DATA>
		<ReferralNumber>
		</ReferralNumber>
		<ReferralName>'.$pat["firstname"] . ' ' .  $pat["lastname"] . '</ReferralName>
		<SSN>'.$pat["ssn"].'</SSN>
		<HICNumber>
		</HICNumber>
		<MedicaidNumber>
		</MedicaidNumber>
		<Address1>'.$pat['add1'].'</Address1>
		<Address2>'.$pat['add2'].'</Address2>
		<City>'.$pat['city'].'</City>
		<State>'.$pat['state'].'</State>
		<ZipCode>'.$pat['zip'].'</ZipCode>
		<Phone1>'.$pat['home_phone'].'</Phone1>
		<Phone2>'.$pat['cell_phone'].'</Phone2>
		<BirthDate>'.str_replace('/','',$pat['dob']).'</BirthDate>
		<Gender>'.substr($pat['gender'],0,1).'</Gender>
		<MaritalStatus>'.$pat['marital_status'].'</MaritalStatus>
		<Ethnicity>
		</Ethnicity>
		<Height>'.(($pat['feet']*12)+$pat['inches']).'</Height>
		<Weight>'.$pat['weight'].'</Weight>
		<Religion>
		</Religion>
		<StartDate>'.date('mdY',strtotime($pat['adddate'])).'</StartDate>
		<TerminateDate>
		</TerminateDate>
		<MRN></MRN>
		<ContactName>'.$pat["firstname"] . ' ' .  $pat["lastname"] . '</ContactName>
		<ContactPhone>' .  $pat["home_phone"] . '</ContactPhone>
		<PrimaryLanguage>
		</PrimaryLanguage>
		<SecondaryLanguage>
		</SecondaryLanguage>
		<AcceptAssignment>
		</AcceptAssignment>
		<BillingInfo>
			<Name>'.$pat["firstname"] . ' ' .  $pat["lastname"] . '</Name>
	                <Address1>'.$pat['add1'].'</Address1>
        	        <Address2>'.$pat['add2'].'</Address2>
                	<City>'.$pat['city'].'</City>
	                <State>'.$pat['state'].'</State>
        	        <ZipCode>'.$pat['zip'].'</ZipCode>
                	<Phone1>'.$pat['home_phone'].'</Phone1>
                	<Phone2>'.$pat['cell_phone'].'</Phone2>
		</BillingInfo>
		<ShippingInfo>
                        <Name>'.$pat["firstname"] . ' ' .  $pat["lastname"] . '</Name>
                        <Address1>'.$pat['add1'].'</Address1>
                        <Address2>'.$pat['add2'].'</Address2>
                        <City>'.$pat['city'].'</City>
                        <State>'.$pat['state'].'</State>
                        <ZipCode>'.$pat['zip'].'</ZipCode>
                        <Phone1>'.$pat['home_phone'].'</Phone1>
                        <Phone2>'.$pat['cell_phone'].'</Phone2>
		</ShippingInfo>
		<Carriers>
			<REFERRAL_CARRIER>
				<CarrierFor>
				</CarrierFor>
				<CarrierSeq>
				</CarrierSeq>
				<CarrierName>'.$pm['company'].'</CarrierName>
				<CarrierAddress1>'.$pm['add1'].'</CarrierAddress1>
				<CarrierAddress2>'.$pm['add2'].'</CarrierAddress2>
				<CarrierCity>'.$pm['city'].'</CarrierCity>
				<CarrierState>'.$pm['state'].'</CarrierState>
				<CarrierZipCode>'.$pm['zip'].'</CarrierZipCode>
				<CarrierPhone1>'.$pm['phone1'].'</CarrierPhone1>
				<CarrierPhone2>'.$pm['phone2'].'</CarrierPhone2>
				<CarrierType>
				</CarrierType>
				<CarrierEPC>
				</CarrierEPC>
				<REFERRAL_POLICY_INFO>
					<PolicyinfoINSURED_NAME>'.$pat['p_m_partyfname'] . ' ' . $pat['p_m_partylname'] . '</PolicyinfoINSURED_NAME>
					<PolicyinfoINSURED_ADDRESS_1>'.$pat['add1'].'</PolicyinfoINSURED_ADDRESS_1>
					<PolicyinfoINSURED_ADDRESS_2>'.$pat['add2'].'</PolicyinfoINSURED_ADDRESS_2>
					<PolicyinfoINSURED_CITY>'.$pat['city'].'</PolicyinfoINSURED_CITY>
					<PolicyinfoINSURED_STATE>'.$pat['state'].'</PolicyinfoINSURED_STATE>
					<PolicyinfoINSURED_ZIP_CODE>'.$pat['zip'].'</PolicyinfoINSURED_ZIP_CODE>
					<PolicyinfoINSURED_PHONE>'.$pat['home_phone'].'</PolicyinfoINSURED_PHONE>
					<PolicyinfoRELATIONSHIP>'.$pat['p_m_relation'].'</PolicyinfoRELATIONSHIP>
					<PolicyinfoINSURED_GROUP_NUMBER>'.$pat['p_m_ins_grp'].'</PolicyinfoINSURED_GROUP_NUMBER>
					<PolicyinfoPLAN_NAME>'.$pat['p_m_ins_plan'].'</PolicyinfoPLAN_NAME>
					<PolicyinfoINSURED_ID_NUMBER>'.$pat['p_m_ins_id'].'</PolicyinfoINSURED_ID_NUMBER>
					<PolicyinfoINSURED_DATE_OF_BIRTH>'.(($pat['ins_dob']!='')?date('mdY',strtotime($pat['ins_dob'])):'').'</PolicyinfoINSURED_DATE_OF_BIRTH>
					<PolicyinfoINSURED_SEX></PolicyinfoINSURED_SEX>
				</REFERRAL_POLICY_INFO>
			</REFERRAL_CARRIER>
                        <REFERRAL_CARRIER>
                                <CarrierFor>
                                </CarrierFor>
                                <CarrierSeq>
                                </CarrierSeq>
                                <CarrierName>'.$sm['company'].'</CarrierName>
                                <CarrierAddress1>'.$sm['add1'].'</CarrierAddress1>
                                <CarrierAddress2>'.$sm['add2'].'</CarrierAddress2>
                                <CarrierCity>'.$sm['city'].'</CarrierCity>
                                <CarrierState>'.$sm['state'].'</CarrierState>
                                <CarrierZipCode>'.$sm['zip'].'</CarrierZipCode>
                                <CarrierPhone1>'.$sm['phone1'].'</CarrierPhone1>
                                <CarrierPhone2>'.$sm['phone2'].'</CarrierPhone2>
                                <CarrierType>
                                </CarrierType>
                                <CarrierEPC>
                                </CarrierEPC>
                                <REFERRAL_POLICY_INFO>
                                        <PolicyinfoINSURED_NAME>'.$pat['s_m_partyfname'] . ' ' . $pat['s_m_partylname'] . '</PolicyinfoINSURED_NAME>
                                        <PolicyinfoINSURED_ADDRESS_1>'.$pat['add1'].'</PolicyinfoINSURED_ADDRESS_1>
                                        <PolicyinfoINSURED_ADDRESS_2>'.$pat['add2'].'</PolicyinfoINSURED_ADDRESS_2>
                                        <PolicyinfoINSURED_CITY>'.$pat['city'].'</PolicyinfoINSURED_CITY>
                                        <PolicyinfoINSURED_STATE>'.$pat['state'].'</PolicyinfoINSURED_STATE>
                                        <PolicyinfoINSURED_ZIP_CODE>'.$pat['zip'].'</PolicyinfoINSURED_ZIP_CODE>
                                        <PolicyinfoINSURED_PHONE>'.$pat['home_phone'].'</PolicyinfoINSURED_PHONE>
                                        <PolicyinfoRELATIONSHIP>'.$pat['s_m_relation'].'</PolicyinfoRELATIONSHIP>
                                        <PolicyinfoINSURED_GROUP_NUMBER>'.$pat['s_m_ins_grp'].'</PolicyinfoINSURED_GROUP_NUMBER>
                                        <PolicyinfoPLAN_NAME>'.$pat['s_m_ins_plan'].'</PolicyinfoPLAN_NAME>
                                        <PolicyinfoINSURED_ID_NUMBER>'.$pat['s_m_ins_id'].'</PolicyinfoINSURED_ID_NUMBER>
                                        <PolicyinfoINSURED_DATE_OF_BIRTH>'.(($pat['ins_dob2']!='')?date('mdY',strtotime($pat['ins_dob2'])):'').'</PolicyinfoINSURED_DATE_OF_BIRTH>
                                        <PolicyinfoINSURED_SEX></PolicyinfoINSURED_SEX>
                                </REFERRAL_POLICY_INFO>
                        </REFERRAL_CARRIER>
		</Carriers>
		<Order>
			<OrderType>
			</OrderType>
			<Urgency>
			</Urgency>		
		</Order>
		<PhysicianInfo>
			<Name>
			</Name>
			<Address1>
			</Address1>
			<Address2>
			</Address2>
			<City>
			</City>
			<State>
			</State>
			<ZipCode>
			</ZipCode>
			<Phone1>
			</Phone1>
			<Phone2>
			</Phone2>
			<NPI>
			</NPI>
			<MedicaidNumber>
			</MedicaidNumber>
			<LicenseNumber>
			</LicenseNumber>
		</PhysicianInfo>
		<FacilityInfo>
			<Name>
			</Name>
			<Address1>
			</Address1>
			<Address2>
			</Address2>
			<City>
			</City>
			<State>
			</State>
			<ZipCode>
			</ZipCode>
			<Phone1>
			</Phone1>
			<Phone2>
			</Phone2>
		</FacilityInfo>
	</REFERRAL_DATA>
</DSSReferral>
';
header ("Content-Type:text/xml");
echo($xml);






?>
