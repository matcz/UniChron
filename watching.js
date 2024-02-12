function change(number, url, max)
{
	let checkbox = $('#NUMiU' + number);
	let action;
	let beforeYes;
	let afterNo;

	if (checkbox.is(':checked'))
	{
		action = confirm("Chcete označit i předchozí epizody jako zhlédnuté?");
		beforeYes = action;
	}
	else
	{
		action = confirm("Chcete označit tuto epizodou jako první nezhlédnutou?");
		afterNo = action;
	}

	updateDatabase(number, checkbox.is(':checked'), action, url);
	fixwatch(number, beforeYes, afterNo, max);
}





function updateDatabase(number, isChecked, action, url)
{
	let actionValue;
	if (action)
	{
		actionValue = "LastWatched";
	}
	else
	{
		if (isChecked)
		{
			actionValue = "HardYes";
		}
		else
		{
			actionValue = "HardNot";
		}
	}

  const formData = new FormData();
  formData.append("numInUniverse", number)
  formData.append("action", actionValue)
  formData.append("url", url)
  try {
    fetch("mujtest.php", {
     method: "POST",
     body: formData
    })
  } catch(err) {
    console.error("Doslo k chybe", err)
  }
}

function fixwatch(number, beforeYes, afterNo, max)
{
	//console.log("Number: " + number + ", Max: " + max); // Kontrolní výpis pro ladění
	if (beforeYes)
	{
		for (let x = 1; x <= number; x++)
		{
			let checkbox = document.getElementById("NUMiU" + x);
			if (checkbox !== null)
			{
				checkbox.checked = true;
			}
		}
	}

	if (afterNo)
	{
		for (let x = number; x <= max; x++)
		{
			let checkbox = document.getElementById("NUMiU" + x);
			if (checkbox !== null)
			{
				checkbox.checked = false;
			}
		}
	}
}

