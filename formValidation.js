// TODO: Add validation for the to and from text boxes

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

// Check location entry isn't empty
var toVal = document.getElementById("to-input").value;
var fromVal = document.getElementById("from-input").value;

if (!(toVal && fromVal))
{
	return false;
}

return true;

}
