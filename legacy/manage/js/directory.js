function LinkUp() 
{
	var number = document.DropDown.DDlinks.selectedIndex;
	location.href = document.DropDown.DDlinks.options[number].value;
}