function themTheLoai()
{
	var cbTheLoai = document.getElementById("cbTheLoai");
	if (cbTheLoai.value=="")
		return;
		
	var objTheloai = document.getElementById("theloai");
	var objCategory = document.getElementById("category");
	var theloai = objTheloai.value;
	var category = objCategory.value;
	if (theloai != "")
	{
		objTheloai.value = theloai  + ", " + cbTheLoai.options[cbTheLoai.selectedIndex].text;
		objCategory.value = category  + ", " + cbTheLoai.value;
	}
	else
	{
		objTheloai.value = theloai  + cbTheLoai.options[cbTheLoai.selectedIndex].text;
		objCategory.value = category  + cbTheLoai.value;	
	}
	
	return true;
}

function xoaTheLoai()
{
	var objTheloai = document.getElementById("theloai");
	var objCategory = document.getElementById("category");
	objTheloai.value = "";
	objCategory.value = "";
	return false;
}

function getControlValue(ctrId)
{
	var x=document.getElementById(ctrId);
	return x.value;
}