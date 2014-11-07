function validate()
{
	returnval = true;
	if ($('#contacttypeid').val() == '') {
		alert('Contact type is a required field.');
		return false;
	}
	return returnval;
}