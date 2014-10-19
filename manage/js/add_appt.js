function confirm_delete(logins)
{
	d = confirm('Are you sure you want to delete?');
	if(!d) {
		return false;
	}

	if(logins > 0) {
		alert('This user has previously accessed your software. In order to store a record of their activity this user will be marked as INACTIVE. INACTIVE users cannot access your software.');
	}
	
	return d;
}