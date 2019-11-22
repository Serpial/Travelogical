function validateMainForm()
{

// Check an engine type has been checked
var engineSelected = document.querySelector("input[name='enginetype']:checked");
if (engineSelected==null)
{
	return false;
}

// Check a fuel type has been checked
var fuelSelected = document.querySelector("input[name='fueltype']:checked");
if (fuelSelected==null)
{
	return false;
}

return true;

}