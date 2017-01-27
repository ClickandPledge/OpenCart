function check_is_recurring(res,name_file)
{
if(res == true)
{
var xmlhttp;
document.getElementById("myDiv").innerHTML= "<img src='../modules/clickandpledge/loading.gif' width='16px' height='16px'>";
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("myDiv").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",name_file+"?action=recurring",true);
xmlhttp.send();
}else{
document.getElementById("myDiv").innerHTML= "";
}
}
function block_recurring(res)
{
	if(res == true)
	document.getElementById("myDiv").style.display="block";
	else
	document.getElementById("myDiv").style.display="none";
}
function block_subscription(res)
{
	if(res == true)
	document.getElementById("myDiv1").style.display="block";
	else
	document.getElementById("myDiv1").style.display="none";
}
function block_creditcard(res)
{
	if(res == true)
	{
	document.getElementById("myDiv3").style.display="block";
	}
	else
	{
	if(document.getElementById("clickandpledge_check").checked == false)
	document.getElementById("myDiv3").style.display="none";
	}
}
function block_echek(res)
{
	if(res == true)
	document.getElementById("myDiv3").style.display="block";
	else
	if(document.getElementById("clickandpledge_creditcard").checked == false)
	document.getElementById("myDiv3").style.display="none";
}
function check_idefinite(mess)
{
if(mess == "Subscription")
document.getElementById("indefinite_id").innerHTML= '<div style="margin-bottom:10px;"><input type="checkbox" name="indefinite_times" value="999" onclick="is_validating(this.checked)" id="indefinite_times"> <label class="option" for="indefinite_times"><span></span>Indefinite Recurring</lable></div>';
else
document.getElementById("indefinite_id").innerHTML= '';
is_validating(false);
}
function recurring_setup(mess,install,subcri,vv,indefinite)
{
if(mess == 1)
{
var html ='<h4>Recurring Method</h4>';
if(install == 'Installment')
{
	html +='<div style="margin-bottom:10px; margin-top:10px;"><input type="radio" id="installment" name="recurring_method" value="Installment" checked="checked" onclick="check_idefinite(this.value)"><label class="option" for="installment"><span></span> Installment (example: Split $1000 into 10 payments of $100 each)</div>'; 
}
if(subcri == 'Subscription')
{
	if(install == '') var cc= 'checked="checked"';else cc ='';
	html +='<div style="margin-bottom:10px; margin-top:10px;"><input type="radio" id="subscription" name="recurring_method" value="Subscription" onclick="check_idefinite(this.value)" '+cc+'><label class="option" for="subscription"><span></span> Subscription (example: Pay $10 every month for 20 times)</div>'; 
	
	if(indefinite == 999)
	{
	html +='<div id="indefinite_id"></div>';
	}
	if(cc != '')
	{
	setTimeout("check_idefinite('Subscription')", 50);	
	}
	
}
	if(install == 'Installment' || subcri == 'Subscription')
	{	add='';
		html +='<div style="margin-bottom:10px;"><b>every</b> <select name="Periodicity">';
		
		vv= vv.filter(function(e){return e});
		for (var i=0;i<vv.length;i++)
		{
		add += '<option value="'+vv[i]+'">'+vv[i]+'</option>';	
		}
		html +=add+'</select>&nbsp;&nbsp;<span id="times">&nbsp;<b>for</b>&nbsp;<input type="text" name="number_of_times" size="3" maxlength="3">&nbsp;<b>times</b></span><span id="enable" style="display:none;color:green">Until Cancelled </span></div>'; 
		document.getElementById("method_display").innerHTML= html;
	}
	else{
		document.getElementById("method_display").innerHTML= '';
	}
}
if(mess == 0)
{
document.getElementById("method_display").innerHTML= '';	
}
}
function is_validating(mess)
{
if(mess)
{
	document.getElementById("times").style.display = 'none';
	document.getElementById("enable").style.display = 'inline';
}
else
{
	document.getElementById("times").style.display = 'inline';
	document.getElementById("enable").style.display = 'none';
}
}