function fill_up(fa)
{
	var fr = getParameterByName('fr');
	var tx = getParameterByName('tx');

	parent.document.fr.tx.value = fa;
	parent.disablePopupRefClean();
}