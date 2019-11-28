function hideInstructions()
{

var instructionsElem = document.getElementById("instructions");
var instructionsArr = document.getElementById("instructions-arrow");

if (instructionsElem.classList.contains("closed")) // Closed, to be opened
{
instructionsElem.classList.remove("closed");

// Style arrow appropriately
//instructionsArr.classList.add("fa-arrow-alt-circle-up");
//instructionsArr.classList.remove("fa-arrow-alt-circle-down");

instructionsArr.classList.add("fa-minus-square");
instructionsArr.classList.remove("fa-plus-square");

}
else // Open, to be closed
{
instructionsElem.classList.add("closed");

// Style arrow appropriately
instructionsArr.classList.add("fa-plus-square");
instructionsArr.classList.remove("fa-minus-square");

}

}
