<script src="catalog/view/javascript/jquery.validate.js"></script>
<div role="tabpanel">
	  <!-- Nav tabs -->
	  
	  <ul class="nav nav-tabs" role="tablist">
	  	<?php if ($cnp_creditcard != '' && $cnp_creditcard != null) { ?>
		<li role="presentation" <?php if ($defalut_payment == 'Creditcard') { ?>class="active" <?php } ?>><a href="#CreditCard" aria-controls="usd" role="tab" data-toggle="tab">Credit Card</a></li>
		<?php } if ($cnp_echeck != '' && $cnp_echeck != null) { ?>
		<li role="presentation" <?php if ($defalut_payment == 'eCheck') { ?>class="active" <?php } ?>><a href="#eCheck" aria-controls="eCheck" role="tab" data-toggle="tab">eCheck</a></li>
		<?php } if ($cnp_invoice != '' && $cnp_invoice != null) { ?>
		<li role="presentation" <?php if ($defalut_payment == 'Invoice') { ?>class="active" <?php } ?>><a href="#Invoice" aria-controls="Invoice" role="tab" data-toggle="tab">Invoice</a></li>
		<?php } if ($cnp_purchas_order != '' && $cnp_purchas_order != null) { ?>
		<li role="presentation" <?php if ($defalut_payment == 'PurchaseOrder') { ?>class="active" <?php } ?>><a href="#PurchaseOrder" aria-controls="PurchaseOrder" role="tab" data-toggle="tab">Custom Payment</a></li>
	 	<?php } ?>
	  </ul>
	  <div class="tab-content">
	 
		<div role="tabpanel" class="tab-pane  <?php if ($defalut_payment == 'Creditcard') { ?> active <?php } ?>" id="CreditCard">
			<form id="creditcard_payment" class="form-horizontal">
			  <fieldset>
			 
				<legend><?php echo $text_credit_card; ?></legend>
				<?php if($cnp_recurring_contribution == 'on') { ?>
				<script type="text/javascript">var recurring_units= new Array(); recurring_units = ["<?php  echo $cnp_week; ?>","<?php  echo $cnp_2_weeks; ?>","<?php  echo $cnp_month; ?>","<?php  echo $cnp_2_months; ?>","<?php  echo $cnp_quarter; ?>","<?php  echo $cnp_6_months; ?>","<?php  echo $cnp_year; ?>"]; var indefinite = "<?php echo $cnp_indefinite;?>"</script>
					
					<div class="form-group">
					<?php if($cnp_amount != 0 ) { ?>
                    <label class="col-sm-2 control-label" for="">Payment Options</label>
                    <div class="col-sm-10">
					<table>
						<tr>
							<td><input type="radio" id="is_recurring" name="is_recurring" checked="checked" value="0" onclick="recurring_setup(this.value,'method_display_creditcard');">
							</td>
							<td>&nbsp;<label for="input-one-time">I want to make a one-time payment</label></td>
						</tr>
						<tr>
							<td><input type="radio" id="is_recurring" name="is_recurring" value="1" onclick="recurring_setup(this.value,'method_display_creditcard','<?php echo $cnp_installment; ?>','<?php echo $cnp_subscription; ?>',recurring_units,indefinite);"></td>
							<td>&nbsp;<label for="input-recurring">I want to make a recurring payment</label></td>
						</tr>
					</table>
					
                    </div>
					<?php } ?>
                    </div>
					<div id="method_display_creditcard" class="form-group"></div>				  
				<?php } ?>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-cc-owner"><?php echo $entry_cc_owner; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="cc_owner" value="" placeholder="<?php echo $entry_cc_owner; ?>" id="input-cc-owner" class="form-control NameOnCard required"  maxlength="100"/>				  	
				  </div>
				</div>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-cc-number"><?php echo $entry_cc_number; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="cc_number" value="" placeholder="<?php echo $entry_cc_number; ?>" id="input-cc-number" class="form-control onlyinteger CardNumber required" maxlength="17"/>
				  </div>
				</div>
                
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-cc-expire-date"><?php echo $entry_cc_expire_date; ?></label>
				  <div class="col-sm-3">
					<select name="cc_expire_date_month" id="input-cc-expire-date" class="form-control correct_month">
					  <?php foreach ($months as $month) { if (date("m") == $month['value']) { ?>
							<option value="<?php echo $month['value']; ?>" selected><?php echo $month['text']; ?></option>
					   <?php } else { ?>
						  <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
						<?php } ?>
					  <?php } ?>
					</select>
				   </div>
				   <div class="col-sm-3">
					<select name="cc_expire_date_year" class="form-control select_year">
					  <?php foreach ($year_expire as $year) { ?>
					  <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
					  <?php } ?>
					</select>
				  </div>
				</div>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-cc-cvv2"><?php echo $entry_cc_cvv2; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="cc_cvv2" value="" placeholder="<?php echo $entry_cc_cvv2; ?>" id="input-cc-cvv2" class="form-control Cvv2 required onlyinteger" maxlength="4"/>
				  </div>
				</div>
			  </fieldset>
			  <input type="hidden" name="payment_method" value="creditcard"/>
			</form>
			<div class="buttons">
			  <div class="pull-right">
				<input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" data-loading-text="Processing ..." class="btn btn-primary" />
			  </div>
			</div>
			<script type="text/javascript"><!--
			var NameOnCard_reg = /^([a-zA-Z0-9\.\,\#\-\ \']){2,50}$/;
			var CardNumber_reg = /^([0-9]){15,17}$/;
			var Cvv2_reg = /^([0-9]){3,4}$/;
			var numberof = /^([0-9]){1,3}$/;
			$('#button-confirm').on('click', function() {
				$.validator.addMethod("NameOnCard", function(value, element) {
				return this.optional(element) || ( NameOnCard_reg.test(value));
				},"Invalid Name on card.");
				$.validator.addMethod("CardNumber", function(value, element) {
				return this.optional(element) || ( CardNumber_reg.test(value));
				}, "Invalid Card Number.");
				$.validator.addMethod("Cvv2", function(value, element) {
				return this.optional(element) || ( Cvv2_reg.test(value));
				}, "Invalid CVV.");
				$.validator.addMethod("correct_month", function(value, element) {
				var check = new Date();
				var current_mo = (check.getMonth()+1);
				var current_ye=(check.getFullYear() + '').toString().substr(2,2);
				var selected_yr = $('.select_year').val();
				if (!(value < current_mo && selected_yr == current_ye))
				return true; return false; }, "Please Select Valid Month");
				$.validator.addMethod("number_of_times", function(value, element) {
				if (!numberof.test(value)) {
				 	 $.validator.messages.number_of_times = "Please Enter Valid Number Of Recurrings";
					 return false;
				 } else if (value <= 1) {
				 	 $.validator.messages.number_of_times = "Please Enter the Installments Morethan 1";
					 return false;
				 } else if ($('input:radio[name=recurring_method]:checked').val() == 'Installment' && value > 998) {
				 	 $.validator.messages.number_of_times = "Max Installments should be maximum 998";
					 return false;
				 } else { return true; }
				 
				},$.validator.messages.number_of_times);
				
			 if ($("#creditcard_payment").valid()) {
				$.ajax({ 
					type: 'post',
					data: $('#creditcard_payment input[type=\'radio\']:checked,#creditcard_payment input[type=\'text\'],#creditcard_payment input[type=\'checkbox\']:checked,#creditcard_payment input[type=\'hidden\'],#creditcard_payment select'),
					url: 'index.php?route=extension/payment/cnp/confirm',
					cache: false,
					beforeSend: function() {
					
						$('#button-confirm').button('loading');
					},
					complete: function() {
			
						$('#button-confirm').button('reset');
					},		
					success: function(json) {			
										
						location = '<?php echo $continue; ?>';
					  
					}
				});
			  }
			});
			//--></script>			
		</div> 
		<!-- creditcard tab closed echeck started -->
		<div role="tabpane2" class="tab-pane <?php if ($defalut_payment == 'eCheck') { ?> active <?php } ?>" id="eCheck"> 
			<form id="echeck_payment" class="form-horizontal">
			  <fieldset>
				<legend><?php echo $text_echeck; ?></legend>
				<?php if ($cnp_recurring_contribution == 'on') { ?>
				<script type="text/javascript">var recurring_units= new Array(); recurring_units = ["<?php  echo $cnp_week; ?>","<?php  echo $cnp_2_weeks; ?>","<?php  echo $cnp_month; ?>","<?php  echo $cnp_2_months; ?>","<?php  echo $cnp_quarter; ?>","<?php  echo $cnp_6_months; ?>","<?php  echo $cnp_year; ?>"]; var indefinite = "<?php echo $cnp_indefinite;?>"</script>
					<div class="form-group">
					<?php if($cnp_amount != 0 ) { ?>
                    <label class="col-sm-2 control-label" for="">Payment Options</label>
                    <div class="col-sm-10">
					<table>
						<tr>
							<td><input type="radio" id="is_recurring" name="is_recurring" checked="checked" value="0" onclick="recurring_setup(this.value,'method_display_echeck');">
							</td>
							<td>&nbsp;<label for="input-one-time">I want to make a one-time payment</label></td>
						</tr>
						<tr>
							<td><input type="radio" id="is_recurring" name="is_recurring" value="1" onclick="recurring_setup(this.value,'method_display_echeck','<?php echo $cnp_installment; ?>','<?php echo $cnp_subscription; ?>',recurring_units,indefinite);"></td>
							<td>&nbsp;<label for="input-recurring">I want to make a recurring payment</label></td>
						</tr>
					</table>
                    </div>
					<?php  } ?>
                    </div>
					<div id="method_display_echeck" class="form-group"></div>				  
				<?php } ?>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-name_on_account"><?php echo $name_on_account; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="name_on_account" value="" placeholder="<?php echo $name_on_account; ?>" id="input-name_on_account" class="form-control required" />
				  </div>
				</div>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-Check_number"><?php echo $Check_number; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="Check_number" value="" placeholder="<?php echo $Check_number; ?>" id="input-Check_number" class="form-control CheckNumber required onlyinteger" maxlength="10"/>
				</div>
				</div>
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-account_type"><?php echo $account_type; ?></label>
				  <div class="col-sm-3">
					<select name="account_type" id="input-account_type" class="form-control">
							<option value="SavingsAccount" selected>Savings Account</option>
						  <option value="CheckingAccount">Checking Account</option>
					</select>
				   </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-check_type"><?php echo $check_type; ?></label>
				  <div class="col-sm-3">
					<select name="check_type" id="input-check_type" class="form-control">
							<option value="Company" selected>Company</option>
						  <option value="Personal">Personal</option>
					</select>
				   </div>
				</div>
				
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-routing_number"><?php echo $routing_number; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="routing_number" value="" placeholder="<?php echo $routing_number; ?>" id="input-routing_number" class="form-control RoutingNumber required onlyinteger" maxlength="9"/>				  	
				  </div>
				</div>
				
				
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-cc-account_number"><?php echo $account_number; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="account_number" value="" placeholder="<?php echo $account_number; ?>" id="input-account_number" class="form-control AccountNumber required onlyinteger" maxlength="17"/>
				  </div>				   
				</div>
				<div class="form-group required">
				  <label class="col-sm-2 control-label" for="input-retype_account_number"><?php echo $retype_account_number; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="retype_account_number" value="" placeholder="<?php echo $retype_account_number; ?>" id="input-retype_account_number" class="form-control required onlyinteger accountMatch" maxlength="17"/>
				  </div>
				</div>
				
				
			  </fieldset>
			  <input type="hidden" name="payment_method" value="echeck"/>
			 </form>
			<div class="buttons">
			  <div class="pull-right">
				<input type="button" value="<?php echo $button_confirm; ?>" id="echeck-button-confirm" data-loading-text="Processing ..." class="btn btn-primary" />
			  </div>
			</div>
			<script type="text/javascript"><!--
				var AccountNumber_reg = /^([0-9]){1,17}$/;
				var RoutingNumber_reg = /^([0-9]){9}$/;
				var CheckNumber_reg = /^([0-9]){1,10}$/;
				var NameonAccount_reg = /^([a-zA-Z0-9]){0,100}$/;
			$('#echeck-button-confirm').on('click', function() {
				
				$.validator.addMethod("AccountNumber", function(value, element) {
				return this.optional(element) || ( AccountNumber_reg.test(value));
				}, "Invalid Account Number."); 
				$.validator.addMethod("RoutingNumber", function(value, element) {
				return this.optional(element) || ( RoutingNumber_reg.test(value));
				}, "Invalid Routing Number.Routing Number Must contain 9 digits");
				$.validator.addMethod("CheckNumber", function(value, element) {
				return this.optional(element) || ( CheckNumber_reg.test(value));
				}, "Invalid Check Number."); 
				$.validator.addMethod("NameOnAccount", function(value, element) {
				return this.optional(element) || ( NameOnAccount_reg.test(value));
				}, "Invalid Name On Account.");
				$.validator.addMethod("IdType", function(value, element) {
				return this.optional(element) || ( in_array(value, allowed_IdTypes ));
				}, "Invalid Id Type.");
				jQuery.validator.addMethod( 'accountMatch', function(value, element) {
				var account_number = $("#input-account_number").val();
				var retype_account_number = $("#input-retype_account_number").val();
				if (account_number != retype_account_number ) {
					return false;
				} else {
					return true;
				}
				}, "Account Number and Retype Account Number Must be same");				
			 if($("#echeck_payment").valid()) {
				$.ajax({ 
					type: 'post',
					data: $('#echeck_payment :input[type=\'text\'],input[type=\'radio\']:checked,#echeck_payment input[type=\'hidden\'],#echeck_payment select'),
					url: 'index.php?route=extension/payment/cnp/confirm',
					cache: false,
					beforeSend: function() {
					
						$('#echeck-button-confirm').button('loading');
					},
					complete: function() {
			
						$('#echeck-button-confirm').button('reset');
					},		
					success: function(json) {			
										
						location = '<?php echo $continue; ?>';
						
					}
				});
			  }
			});
			//--></script>
		</div>
		<!-- eCheck tab closed echeck started -->
		<div role="tabpane3" class="tab-pane <?php if ($defalut_payment == 'Invoice') { ?> active <?php } ?>" id="Invoice"> 
			<form id="invoice_payment" class="form-horizontal">
			  <fieldset>
				<legend><?php echo $text_invoice; ?></legend>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-Check_number"><?php echo $Check_number; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="Check_number" value="" placeholder="<?php echo $Check_number; ?>" id="input-Check_number" class="form-control CheckNumber onlyinteger"  maxlength="50"/>				  	
				  </div>
				</div>				
			  </fieldset>
			  <input type="hidden" name="payment_method" value="invoice"/>
			 </form>
			<div class="buttons">
			  <div class="pull-right">
				<input type="button" value="<?php echo $button_confirm; ?>" id="invoice-button-confirm" data-loading-text="Processing ..." class="btn btn-primary" />
			  </div>
			</div>
			<script type="text/javascript"><!--
			$('#invoice-button-confirm').on('click', function() {
				var CheckNumber_reg = /^([0-9]){1,50}$/;
				$.validator.addMethod("CheckNumber", function(value, element) {
				return this.optional(element) || ( CheckNumber_reg.test(value));
				}, "Invalid Check Number.");
			 if ($("#invoice_payment").valid()) {
				$.ajax({ 
					type: 'post',
					data: $('#invoice_payment :input[type=\'text\'],#invoice_payment :input[type=\'hidden\']'),
					url: 'index.php?route=extension/payment/cnp/confirm',
					cache: false,
					beforeSend: function() {
					
						$('#button-confirm').button('loading');
					},
					complete: function() {
			
						$('#button-confirm').button('reset');
					},		
					success: function(json) {			
										
						location = '<?php echo $continue; ?>';
						
					}
				});
			  }
			});
			//--></script>			
		</div>
		<!-- Invoice tab closed PurchaseOrder started -->
		<div role="tabpane4" class="tab-pane <?php if ($defalut_payment == 'PurchaseOrder') { ?> active <?php } ?>" id="PurchaseOrder"> 
			<form id="purchase_order_payment" class="form-horizontal">
			  <fieldset>
				<legend><?php echo $text_purchase_order; ?></legend>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="input-purchase_order_number"><?php echo $purchase_order_number; ?></label>
				  <div class="col-sm-10">
					<input type="text" name="purchase_order_number" value="" placeholder="<?php echo $purchase_order_number; ?>" id="input-purchase_order_number" class="form-control PurchaseOrderNumber" maxlength="50" />				  	
				  </div>
				</div>				
			  </fieldset>
			  <input type="hidden" name="payment_method" value="purchase_order"/>
			 </form>
			<div class="buttons">
			  <div class="pull-right">
				<input type="button" value="<?php echo $button_confirm; ?>" id="purchase-order-button-confirm" data-loading-text="Processing ..." class="btn btn-primary" />
			  </div>
			</div>
		</div>
			<script type="text/javascript"><!--
			$('#purchase-order-button-confirm').on('click', function() {
				var PurchaseOrderNumber_reg = /^([a-zA-Z0-9]){1,50}$/;
				$.validator.addMethod("PurchaseOrderNumber", function(value, element) {
				return this.optional(element) || ( PurchaseOrderNumber_reg.test(value));
				}, "Invalid Purchase Order Number.");
			 if ($("#purchase_order_payment").valid()) {
				$.ajax({ 
					type: 'post',
					data: $('#purchase_order_payment :input[type=\'text\'],#purchase_order_payment :input[type=\'hidden\']'),
					url: 'index.php?route=extension/payment/cnp/confirm',
					cache: false,
					beforeSend: function() {
					
						$('#purchase-order-button-confirm').button('loading');
					},
					complete: function() {
			
						$('#purchase-order-button-confirm').button('reset');
					},		
					success: function(json) {			
										
						location = '<?php echo $continue; ?>';
						
					}
				});
			  }
			});
			//--></script>		
	  </div>
</div>
<style>
label.error {color:red;}
input.error{border-color: #a94442;-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);box-shadow: inset 0 1px 1px rgba(0,0,0,.075);}
</style>
<script type="text/javascript">
$(".onlyinteger").keypress(function (e) {
   if($('.remove_label').length > 0) $('.remove_label').remove();
 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	 //$('#'+$(this).attr('id')).addClass('error');
	 return false;
  } 
});

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
function check_idefinite(mess) { 
is_validating(false);
if(mess == "Subscription"){
if($("#indefinite_id").length >= 1) {
	document.getElementById("indefinite_id").style.display = 'block';
	document.getElementById("indefinite_id").innerHTML= '<div style="margin-bottom:10px;"><input type="checkbox" name="indefinite_times" value="999" onclick="is_validating(this.checked)" id="indefinite_times"> <label class="option" for="indefinite_times"><span></span>Indefinite Recurring</lable></div>';
}
} else {
if($("#indefinite_id").length >= 1)document.getElementById("indefinite_id").style.display = 'none';
if(document.getElementById("enable").style.display != 'none') { document.getElementById("indefinite_id").innerHTML= ''; }
is_validating(false);
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
function recurring_setup(mess,id_name,install,subcri,vv,indefinite)
{
if(mess == 1)
{
var html ='<label class="col-sm-2 control-label">Recurring Method</label><div class="col-sm-10">';
if(install == 'Installment')
{	
	html +='<div style="margin-top:10px;"><input type="radio" id="installment" name="recurring_method" value="Installment" checked="checked" onclick="check_idefinite(this.value)"> <label class="option" for="installment"><span></span> Installment (example: Split '+"<?php echo $currency_symbol;?>"+'1000 into 10 payments of '+"<?php echo $currency_symbol;?>"+'100 each)</div>'; 
}
if(subcri == 'Subscription')
{
	if(install == '') var cc= 'checked="checked"';else cc ='';
	html +='<div style=""><input type="radio" id="subscription" name="recurring_method" value="Subscription" onclick="check_idefinite(this.value)" '+cc+'> <label class="option" for="subscription"><span></span> Subscription (example: Pay '+"<?php echo $currency_symbol;?>"+'10 every month for 20 times)</div>'; 
	
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
		html +=add+'</select>&nbsp;&nbsp;<span id="times">&nbsp;<b>for</b>&nbsp;<input type="text" name="number_of_times" class="number_of_times required" size="3" maxlength="3">&nbsp;<b>times</b></span><span id="enable" style="display:none;color:green">Until Cancelled </span></div></div>'; 
		document.getElementById(id_name).innerHTML= html;
	}
	else{
		document.getElementById(id_name).innerHTML= '';
	}
}
if(mess == 0)
{
document.getElementById(id_name).innerHTML= '';	
}
}
</script>