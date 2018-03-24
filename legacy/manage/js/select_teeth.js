function fill_up(fa)
{
	var tx = getParameterByName('tx');

	parent.document.q_recipientsfrm.tx.value = fa;
	parent.disablePopupRefClean();
}