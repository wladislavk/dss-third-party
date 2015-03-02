<!DOCTYPE html>
<html>
	<head>
		<meta charset='utf-8'>

		{!! HTML::style('/css/manage/admin.css') !!}
		{!! HTML::style('/css/manage/form.css') !!}

		{!! HTML::script('/js/jquery-1.6.2.min.js') !!}
		{!! HTML::script('/js/3rdParty/jquery.maskedinput-1.3.min.js') !!}
		{!! HTML::script('/js/manage/validation.js') !!}
		{!! HTML::script('/js/manage/masks.js') !!}
		{!! HTML::script('/js/manage/wufoo.js') !!}
		{!! HTML::script('/js/manage/preferred_contact.js') !!}
		{!! HTML::script('/js/manage/contact.js') !!}
		{!! HTML::script('/js/manage/add_contact.js') !!}
	</head>
	<body>

		@if (!empty($message))
			<div align="center" class="red">
				{!! $message !!}
			</div>
		@endif

		<form name="contactfrm" action="{!! $path !!}/add/1/activePat/{!! $this->request['activePat'] !!}/from/{!! $this->request['from'] !!}/from_id/{!! $this->request['from_id'] !!}/in_field/{!! $this->request['in_field'] !!}/id_field/{!! $this->request['id_field'] !!}" method="post" onSubmit="return contactabc(this)" style="width:99%;">
			<input type="hidden" id="physician_types" value="{!! $physicianTypes !!}" />
			<input type="hidden" name="contact_type" value="{!! $ctype !!}" />
			<table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
				<tr>
					<td colspan="2" class="cat_head">

						@if (!empty($ctype) && $ctype == 'ins')
							Add Insurance Company
						@else
							{!! $butText !!}{!! $heading or '' !!}Contact

							@if (!empty($contactInfo['name']))
								&quot;{!! $contactInfo['name'] !!}&quot;
							@endif
						@endif

					</td>
				</tr>
				<tr>
					<td valign="top" colspan="2" class="frmhead">
						<ul>
							<li id="foli8" class="complex">
								<div>
									<span>
										<select id="contacttypeid" name="contacttypeid" class="field text addr tbox" tabindex="20">
											<option value="">Select a contact type</option>

											@if (!empty($contactTypes))
												@foreach ($contactTypes as $contactType)
													@if (!empty($contact->contacttypeid) && $contact->contacttypeid == $contactType->contacttypeid || !empty($type) && $contact->contacttypeid == $type || !empty($ctypeeq) && $contact->contacttypeid == '11')
														<option selected value="{!! $contactType->contacttypeid or '' !!}">
													@else
														<option value="{!! $contactType->contacttypeid or '' !!}">
													@endif

														{!! $contactType->contacttype !!}
													</option>
												@endforeach
											@endif

										</select>
										<label for="contacttype">Contact Type</label>
									</span>
								</div>
							</li>
						</ul>
					</td>
				</tr>
				<tr class="content physician other">
					<td valign="top" colspan="2" class="frmhead">
						<ul>
							<li id="foli8" class="complex">	
								<label class="desc" id="title0" for="Field0">
									Name

									@if (!empty($ctype) && $ctype != 'ins')
										<span id="req_0" class="req">*</span>
									@endif
								</label>
								<div>
									<span>
										<select name="salutation" id="salutation" class="field text addr tbox" tabindex="1" style="width:80px;" >
											<option value=""></option>
											<option value="Dr." {!! ($contactInfo['salutation'] == 'Dr.') ? " selected" : '' !!}>Dr.</option>
											<option value="Mr." {!! ($contactInfo['salutation'] == 'Mr.') ? " selected" : '' !!}>Mr.</option>
											<option value="Mrs." {!! ($contactInfo['salutation'] == 'Mrs.') ? " selected" : '' !!}>Mrs.</option>
											<option value="Miss." {!! ($contactInfo['salutation'] == 'Miss.') ? " selected" : '' !!}>Miss.</option>
										</select>
										<label for="salutation">Salutation</label>
									</span>
									<span>
										<input id="firstname" name="firstname" type="text" class="field text addr tbox" value="{!! $contactInfo['firstname'] !!}" tabindex="2" maxlength="255" />
										<label for="firstname">First Name</label>
									</span>
									<span>
										<input id="lastname" name="lastname" type="text" class="field text addr tbox" value="{!! $contactInfo['lastname'] !!}" tabindex="3" maxlength="255" />
										<label for="lastname">Last Name</label>
									</span>
									<span>
										<input id="middlename" name="middlename" type="text" class="field text addr tbox" value="{!! $contactInfo['middlename'] !!}" tabindex="4" style="width:50px;" maxlength="1" />
										<label for="middlename">Middle <br />Init</label>
									</span>
								</div>   
							</li>
						</ul>
					</td>
				</tr>
				<tr class="content physician insurance other"> 
					<td valign="top" colspan="2" class="frmhead">
						<ul>
							<li id="foli8" class="complex">	
								<label class="desc" id="title0" for="Field0">
									<span>
										<span style="color:#000000">
											Company
											
											@if (!empty($ctype) && $ctype != 'ins')
												<span id="req_0" class="req">*</span>
											@endif
										</span>
										<input id="company" name="company" type="text" class="field text addr tbox" value="{!! $contactInfo['company'] !!}" tabindex="5" style="width:575px;"  maxlength="255"/>
									</span>
								</label>
							</li>
						</ul>
					</td>
				</tr>
				<tr class="content physician insurance other"> 
					<td valign="top" colspan="2" class="frmhead">
						<ul>
							<li id="foli8" class="complex">	
								<label class="desc" id="title0" for="Field0">
									Address
									<span id="req_0" class="req">*</span>
								</label>
								<div>
									<span>
										<input id="add1" name="add1" type="text" class="field text addr tbox" value="{!! $contactInfo['add1'] !!}" tabindex="6" style="width:325px;"  maxlength="255"/>
										<label for="add1">Address1</label>
									</span>
									<span>
										<input id="add2" name="add2" type="text" class="field text addr tbox" value="{!! $contactInfo['add2'] !!}" tabindex="7" style="width:325px;" maxlength="255" />
										<label for="add2">Address2</label>
									</span>
								</div>
								<div>
									<span>
										<input id="city" name="city" type="text" class="field text addr tbox" value="{!! $contactInfo['city'] !!}" tabindex="8" style="width:200px;" maxlength="255" />
										<label for="city">City</label>
									</span>
									<span>
										<input id="state" name="state" type="text" class="field text addr tbox" value="{!! $contactInfo['state'] !!}" tabindex="9" style="width:80px;" maxlength="255" />
										<label for="state">State</label>
									</span>
									<span>
										<input id="zip" name="zip" type="text" class="field text addr tbox" value="{!! $contactInfo['zip'] !!}" tabindex="10" style="width:80px;" maxlength="255" />
										<label for="zip">Zip / Post Code </label>
									</span>
								</div>
							</li>
						</ul>
					</td>
				</tr>
				<tr class="content physician insurance other"> 
					<td valign="top" colspan="2" class="frmhead">
						<ul>
							<li id="foli8" class="complex">	
								<div>
									<span>
										<input id="phone1" name="phone1" type="text" class="extphonemask field text addr tbox" value="{!! $contactInfo['phone1'] !!}" tabindex="11" maxlength="255" style="width:200px;" />
										<label for="phone1">Phone 1</label>
									</span>
									<span>
										<input id="phone2" name="phone2" type="text" class="extphonemask field text addr tbox" value="{!! $contactInfo['phone2'] !!}" tabindex="12" maxlength="255" style="width:200px;" />
										<label for="phone2">Phone 2</label>
									</span>
									<span>
										<input id="fax" name="fax" type="text" class="phonemask field text addr tbox" value="{!! $contactInfo['fax'] !!}" tabindex="13" maxlength="255" style="width:200px;" />
										<label for="fax">Fax</label>
									</span>
								</div>
								<div>
									<span>
										<input id="email" name="email" type="text" class="field text addr tbox" value="{!! $contactInfo['email'] !!}" tabindex="14" maxlength="255" style="width:325px;" />
										<label for="email">Email</label>
									</span>
								</div>
							</li>
						</ul>
					</td>
				</tr>
				<tr class="content physician">
					<td valign="top" colspan="2" class="frmhead">
						<ul>
							<li id="foli8" class="complex">
								<div>
									<span>
										<input id="dea_number" name="dea_number" type="text" class="field text addr tbox" value="{!! $contactInfo['dea_number'] !!}" tabindex="11" maxlength="255" style="width:200px;" />
										<label for="dea_number">DEA License Number</label>
									</span>
								</div>
							</li>
						</ul>
					</td>
				</tr>
				<tr class="content physician"> 
					<td valign="top" colspan="2" class="frmhead">
						<ul>
							<li id="foli8" class="complex">	
								<div>
									<span style="font-size:10px;">
										These fields required for Medicare referring physicians.
									</span><br />
									<span>
										National Provider ID (NPI)
										<input id="national_provider_id" name="national_provider_id" type="text" class="field text addr tbox" value="{!! $contactInfo['national_provider_id'] !!}" tabindex="15" maxlength="255" style="width:200px;" />
									</span>
								</div>
							</li>
							<li id="foli8" class="complex">	
								<label class="desc" id="title0" for="Field0">
									Other ID For Claim Forms
								</label>
								<div>
									<span>
										<select id="qualifier" name="qualifier" class="field text addr tbox" tabindex="16">
											<option value="0"></option>

											@if (!empty($qualifiers))
												@foreach ($qualifiers as $qualifier)
													<option value="{!! $qualifier->qualifierid !!}">
														{!! $qualifier->qualifier !!}
													</option>
												@endforeach
											@endif

										</select>
										<label for="qualifier">Qualifier</label>
									</span>
									<span>
										<input id="qualifierid" name="qualifierid" type="text" class="field text addr tbox" value="{!! $contactInfo['qualifierid'] !!}" tabindex="17" maxlength="255" style="width:200px;" />
										<label for="qualifierid">ID</label>
									</span>
								</div>
							</li>     
						</ul>
					</td>
				</tr>
				<tr class="content physician insurance other"> 
					<td valign="top" colspan="2" class="frmhead">
						<ul>
							<li id="foli8" class="complex">	
								<label class="desc" id="title0" for="Field0">
									Notes:
								</label>
								<div>
									<span class="full">
										<textarea name="notes" id="notes" class="field text addr tbox" tabindex="21" style="width:600px; height:150px;">{!! $contactInfo['notes'] !!}</textarea>
									</span>
								</div>
							</li>
						</ul>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF" class="content physician insurance other">
					<td valign="top" class="frmhead">
						Preferred Contact Method
					</td>
					<td valign="top" class="frmdata">
						<select id="preferredcontact" name="preferredcontact" class="tbox" tabindex="22">
							<option value="fax" {!! ($contactInfo['preferredcontact'] == 'fax') ? " selected" : '' !!}>Fax</option>
							<option value="paper" {!! ($contactInfo['preferredcontact'] == 'paper') ? " selected" : '' !!}>Paper Mail</option>
							<option value="email" {!! ($contactInfo['preferredcontact'] == 'email') ? " selected" : '' !!}>Email</option>
						</select>
						<br />&nbsp;
					</td>
				</tr>
				<tr bgcolor="#FFFFFF" class="content physician insurance other">
					<td valign="top" class="frmhead">
						Status
					</td>
					<td valign="top" class="frmdata">
						<select name="status" class="tbox" tabindex="22">
							<option value="1" {!! ($contactInfo['status'] == 1) ? " selected" : ''>Active</option>
							<option value="2" {!! ($contactInfo['status'] == 2) ? " selected" : ''>In-Active</option>
						</select>
						<br />&nbsp;
					</td>
				</tr>
				<tr class="content physician insurance other">
					<td  colspan="2" align="center">
						<span class="red">* Required Fields</span><br />
						<input type="hidden" name="contactsub" value="1" />
						<input type="hidden" name="ed" value="{!! $contact->contactid !!}" />
						<a href="#" id="google_link" target="_blank" style="float:left;" />Google</a>
						<input type="submit" value=" {!! $butText !!} Contact" class="button" />

						@if (!empty($contact->contactid))
							<a style="float:right;" href="duplicate_contact/winner/{!! $contact->contactid !!}" title="Duplicate">
								Is This a Duplicate? 
							</a>
							<br />

							{{-- CODE ... --}}

						@endif

					</td>
				</tr>
			</table>
		</form>
	</body>
</html>