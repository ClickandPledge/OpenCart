<?php echo $header; ?>
<style>
input[type="radio"], input[type="checkbox"] {
	margin: 2px 5px -2px;
}
.nav > li > a
{
	    padding: 10px 8px !important;
}
</style>
<?php echo $column_left; ?>
<div id="content">
	<div class="page-header">
		<div class="container-fluid">
		  <div class="pull-right">
			<button type="button" form="form-cnp" data-toggle="tooltip" onClick="validation();" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
			<a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
		  <h1><?php echo $heading_title; ?></h1>
		  <ul class="breadcrumb">
			<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
			<?php } ?>
		  </ul>
		</div>
	  </div>			
		
	<div class="container-fluid">
	<?php if ($error_warning) { ?>
	<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
	<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>		
		<div class="panel-body">
			<form action="<?php echo $action; ?>" name="clickandpledgesettings" method="post" enctype="multipart/form-data" id="form-cnp" class="form-horizontal" >
				<div role="tabpanel">
				
				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#usd" aria-controls="usd" role="tab" data-toggle="tab">USD($) Account Settings</a></li>
					<li role="presentation"><a href="#euro" aria-controls="euro" role="tab" data-toggle="tab">Euro(&euro;) Account Settings</a></li>
					<li role="presentation"><a href="#pound" aria-controls="pound" role="tab" data-toggle="tab">Pound(&pound;) Account Settings</a></li>
					<li role="presentation"><a href="#cadusd" aria-controls="cadusd" role="tab" data-toggle="tab">CAD - Canadian Dollar(C$) Account Settings</a></li>
					<li role="presentation"><a href="#hkdusd" aria-controls="hkdusd" role="tab" data-toggle="tab">HKD - Hong Kong Dollar(HK$) Account Settings</a></li>
				  </ul>
				
				  <!-- Tab panes -->
				  <div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="usd">					
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_login">USD($) <?php echo $entry_login; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_login" value="<?php echo $cnp_login; ?>" placeholder="<?php echo $entry_login; ?>" id="input-cnp_login" class="form-control" />
								<?php if ($error_login) { ?>
								<div class="text-danger"><?php echo $error_login; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_key">USD($) <?php echo $entry_key; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_key" value="<?php echo $cnp_key; ?>" placeholder="<?php echo $entry_key; ?>" id="input-cnp_key" class="form-control" />
								<?php if ($error_key) { ?>
								<div class="text-danger"><?php echo $error_key; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_mode"><?php echo $entry_mode; ?></label>
							<div class="col-sm-10">
								<select name="cnp_server" class="form-control">
									  <?php if ($cnp_server == 'production') { ?>
									  <option value="production" selected="selected"><?php echo $text_live; ?></option>
									  <?php } else { ?>
									  <option value="production"><?php echo $text_live; ?></option>
									  <?php } ?>
									  <?php if ($cnp_server == 'test') { ?>
									  <option value="test" selected="selected"><?php echo $text_test; ?></option>
									  <?php } else { ?>
									  <option value="test"><?php echo $text_test; ?></option>
									  <?php } ?>
								</select>								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="cnp_usd_status" class="form-control">
								  <?php if ($cnp_usd_status) { ?>
								  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								  <option value="0"><?php echo $text_disabled; ?></option>
								  <?php } else { ?>
								  <option value="1"><?php echo $text_enabled; ?></option>
								  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								  <?php } ?>
								</select>
							</div>
						</div>					
					</div>
					<div role="tabpanel" class="tab-pane" id="euro">
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_login">Euro(&euro;) <?php echo $entry_login; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_login_euro" value="<?php echo $cnp_login_euro; ?>" placeholder="<?php echo $entry_login; ?>" id="input-cnp_login_euro" class="form-control" />
								<?php if ($error_login) { ?>
								<div class="text-danger"><?php echo $error_login; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_key">Euro(&euro;) <?php echo $entry_key; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_key_euro" value="<?php echo $cnp_key_euro; ?>" placeholder="<?php echo $entry_key; ?>" id="input-cnp_key_euro" class="form-control" />
								<?php if ($error_key) { ?>
								<div class="text-danger"><?php echo $error_key; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_mode"><?php echo $entry_mode; ?></label>
							<div class="col-sm-10">
								<select name="cnp_server_euro" class="form-control">
								  <?php if ($cnp_server_euro == 'production') { ?>
								  <option value="production" selected="selected"><?php echo $text_live; ?></option>
								  <?php } else { ?>
								  <option value="production"><?php echo $text_live; ?></option>
								  <?php } ?>
								  <?php if ($cnp_server_euro == 'test') { ?>
								  <option value="test" selected="selected"><?php echo $text_test; ?></option>
								  <?php } else { ?>
								  <option value="test"><?php echo $text_test; ?></option>
								  <?php } ?>
								</select>							
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="cnp_status_euro" class="form-control">
								  <?php if ($cnp_status_euro) { ?>
								  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								  <option value="0"><?php echo $text_disabled; ?></option>
								  <?php } else { ?>
								  <option value="1"><?php echo $text_enabled; ?></option>
								  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								  <?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane" id="pound">
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_login">Pound(&pound;) <?php echo $entry_login; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_login_pound" value="<?php echo $cnp_login_pound; ?>" placeholder="<?php echo $entry_login; ?>" id="input-cnp_login_pound" class="form-control" />
								<?php if ($error_login) { ?>
								<div class="text-danger"><?php echo $error_login; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_key">Pound(&pound;) <?php echo $entry_key; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_key_pound" value="<?php echo $cnp_key_pound; ?>" placeholder="<?php echo $entry_key; ?>" id="input-cnp_key_pound" class="form-control" />
								<?php if ($error_key) { ?>
								<div class="text-danger"><?php echo $error_key; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_mode"><?php echo $entry_mode; ?></label>
							<div class="col-sm-10">
								<select name="cnp_server_pound" class="form-control">
								  <?php if ($cnp_server_pound == 'production') { ?>
								  <option value="production" selected="selected"><?php echo $text_live; ?></option>
								  <?php } else { ?>
								  <option value="production"><?php echo $text_live; ?></option>
								  <?php } ?>
								  <?php if ($cnp_server_pound == 'test') { ?>
								  <option value="test" selected="selected"><?php echo $text_test; ?></option>
								  <?php } else { ?>
								  <option value="test"><?php echo $text_test; ?></option>
								  <?php } ?>
								</select>							
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="cnp_status_pound" class="form-control">
								  <?php if ($cnp_status_pound) { ?>
								  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								  <option value="0"><?php echo $text_disabled; ?></option>
								  <?php } else { ?>
								  <option value="1"><?php echo $text_enabled; ?></option>
								  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								  <?php } ?>
								</select>
							</div>
						</div>					
					</div>
					<div role="tabpanel" class="tab-pane" id="cadusd">					
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_login">CAD(C$) <?php echo $entry_login; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_cad_login" value="<?php echo $cnp_cad_login; ?>" placeholder="<?php echo $entry_login; ?>" id="input-cnp_cad_login" class="form-control" />
								<?php if ($error_login) { ?>
								<div class="text-danger"><?php echo $error_login; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_key">CAD(C$) <?php echo $entry_key; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_cad_key" value="<?php echo $cnp_cad_key; ?>" placeholder="<?php echo $entry_key; ?>" id="input-cnp_cad_key" class="form-control" />
								<?php if ($error_key) { ?>
								<div class="text-danger"><?php echo $error_key; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_mode"><?php echo $entry_mode; ?></label>
							<div class="col-sm-10">
								<select name="cnp_cad_server" class="form-control">
									  <?php if ($cnp_cad_server == 'production') { ?>
									  <option value="production" selected="selected"><?php echo $text_live; ?></option>
									  <?php } else { ?>
									  <option value="production"><?php echo $text_live; ?></option>
									  <?php } ?>
									  <?php if ($cnp_cad_server == 'test') { ?>
									  <option value="test" selected="selected"><?php echo $text_test; ?></option>
									  <?php } else { ?>
									  <option value="test"><?php echo $text_test; ?></option>
									  <?php } ?>
								</select>								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="cnp_cad_status" class="form-control">
								  <?php if ($cnp_cad_status) { ?>
								  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								  <option value="0"><?php echo $text_disabled; ?></option>
								  <?php } else { ?>
								  <option value="1"><?php echo $text_enabled; ?></option>
								  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								  <?php } ?>
								</select>
							</div>
						</div>					
					</div>
					<div role="tabpanel" class="tab-pane" id="hkdusd">					
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_login">HKD(HK$) <?php echo $entry_login; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_hkd_login" value="<?php echo $cnp_hkd_login; ?>" placeholder="<?php echo $entry_login; ?>" id="input-cnp_hkd_login" class="form-control" />
								<?php if ($error_login) { ?>
								<div class="text-danger"><?php echo $error_login; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group required">
							<label class="col-sm-2 control-label" for="input-cnp_hkd_key">HKD(HK$) <?php echo $entry_key; ?></label>
							<div class="col-sm-10">
								<input type="text" name="cnp_hkd_key" value="<?php echo $cnp_hkd_key; ?>" placeholder="<?php echo $entry_key; ?>" id="input-cnp_hkd_key" class="form-control" />
								<?php if ($error_key) { ?>
								<div class="text-danger"><?php echo $error_key; ?></div>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_mode"><?php echo $entry_mode; ?></label>
							<div class="col-sm-10">
								<select name="cnp_hkd_server" class="form-control">
									  <?php if ($cnp_hkd_server == 'production') { ?>
									  <option value="production" selected="selected"><?php echo $text_live; ?></option>
									  <?php } else { ?>
									  <option value="production"><?php echo $text_live; ?></option>
									  <?php } ?>
									  <?php if ($cnp_hkd_server == 'test') { ?>
									  <option value="test" selected="selected"><?php echo $text_test; ?></option>
									  <?php } else { ?>
									  <option value="test"><?php echo $text_test; ?></option>
									  <?php } ?>
								</select>								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" for="input-entry_status"><?php echo $entry_status; ?></label>
							<div class="col-sm-10">
								<select name="cnp_hkd_status" class="form-control">
								  <?php if ($cnp_hkd_status) { ?>
								  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
								  <option value="0"><?php echo $text_disabled; ?></option>
								  <?php } else { ?>
								  <option value="1"><?php echo $text_enabled; ?></option>
								  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
								  <?php } ?>
								</select>
							</div>
						</div>					
					</div>
				</div>
				<hr/>
				</div>
				<h1>Other Settings<hr/></h1>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="input-entry_status"><?php echo $entry_method; ?></label>
					<div class="col-sm-10">
						<select name="cnp_status" class="form-control">
						  <?php if ($cnp_status) { ?>
						  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						  <option value="0"><?php echo $text_disabled; ?></option>
						  <?php } else { ?>
						  <option value="1"><?php echo $text_enabled; ?></option>
						  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						  <?php } ?>
						</select>
					</div>
				</div>	
				<div class="form-group">
				<label class="col-sm-2 control-label" for="input-entry_sort_order"><?php echo $entry_sort_order; ?></label>
				<div class="col-sm-10">
				  <input type="text" name="cnp_sort_order" value="<?php echo $cnp_sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="cnp_sort_order" class="form-control" />						
				</div>
				</div>
				<div class="form-group">
				<label class="col-sm-2 control-label" for="input-cnp_checkout_total"><span data-toggle="tooltip" data-html="true" data-trigger="click" title="<?php echo htmlspecialchars($entry_total_help); ?>"><?php echo $entry_total; ?></span></label>
				<div class="col-sm-10">
					<input type="text" name="cnp_checkout_total" value="<?php echo $cnp_checkout_total; ?>" placeholder="<?php echo $entry_total; ?>" id="cnp_checkout_total" class="form-control total_amount" />						
				</div>
			    </div>
				<div class="form-group">
				<label class="col-sm-2 control-label" for="input-receipt_setting"><?php echo $receipt_setting; ?></label>
				<div class="col-sm-10">	
                	<label class="checkbox-inline">			  
				  	<input type="checkbox" value="yes" <?php if ($cnp_send_receipt == 'yes') { echo 'checked="checked"';?>  <?php } ?> id="cnp_send_receipt" name="cnp_send_receipt" onclick="show_receipt_data(this.checked);">
					</label>
                </div>
				</div>
				<!--<div class="form-group">
				<label class="col-sm-2 control-label" for="input-organization_information"><?php echo $organization_information; ?></label>
				<div class="col-sm-10">
				  <textarea rows="5" id="cnp_org_info" name="cnp_org_info" class="form-control" maxlength="1500"><?php echo $cnp_org_info; ?></textarea>
				  (Max length 1500 characters)
				</div>
			   </div> -->
			  <div class="form-group">
				<label class="col-sm-2 control-label" for="input-terms_conditions"><?php echo $terms_conditions; ?></label>
				<div class="col-sm-10">
				  <textarea rows="5" id="cnp_terms_conditions" name="cnp_terms_conditions" class="form-control" maxlength="1500"><?php echo $cnp_terms_conditions; ?></textarea>
				  (Max length 1500 characters)
				  <xmp>(The following HTML tags are allowed: <P></P><BR/><OL></OL><LI></LI><UL></UL>)</xmp>
				</div>
			  </div>
              
              <div class="form-group form">
              	<label class="col-sm-2 control-label" for="input-terms_conditions"><?php echo $payment_methods; ?></label>
                <div class="col-sm-10">
                	<?php if(!$cnp_install){ ?>
                    <table cellpadding="5" cellspacing="3" style="font-weight:bold;" >
                    <tbody>
                    <tr><td></td>
                      <td><?php echo $payment_method_default;?></td></tr>                    
                    <tr>
                    <td width="200"><input type="checkbox" id="cnp_creditcard" value="Credit Card" name="cnp_creditcard" checked="checked" onclick="block_creditcard(this.checked);" disabled="disabled" > Credit Card</td>
                    <td><input type="radio" name="cnp_payment_method" value="Creditcard" checked="checked" onclick="defalut_payment(this.value);"></td>
                    </tr>
                    <tr>
                    <td><input type="checkbox" value="eCheck" id="cnp_check" name="cnp_check" onclick="block_echek(this.checked);"> eCheck</td>
                    <td><input type="radio" name="cnp_payment_method" value="eCheck" onclick="defalut_payment(this.value);"></td>
                    </tr>
                    <!--<tr>
                    <td><input type="checkbox" value="Invoice" id="cnp_invoice" name="cnp_invoice"> Invoice</td>
                    <td><input type="radio" name="cnp_payment_method" value="Invoice" onclick="defalut_payment(this.value);"></td>
                    </tr> -->
                    <tr>
                    <td><input type="checkbox" value="Purchase Order" id="cnp_purchas_order" name="cnp_purchas_order"> Custom Payment</td>
                    <td><input type="radio" name="cnp_payment_method" value="PurchaseOrder" onclick="defalut_payment(this.value);">
                      <input type="hidden" name="cnp_install" value="yes"/>
                    </td>
                    </tr>
                    </tbody></table>
                    <?php }else { ?>
                    <table cellpadding="5" cellspacing="3" style="font-weight:bold;">
                    <tbody><tr><td></td>
                      <td><?php echo $payment_method_default;?></td>
                    </tr><tr>
                    <td width="200"><input type="checkbox" id="cnp_creditcard" class="checkbox_active" value="CreditCard" name="cnp_creditcard"  onclick="block_creditcard(this.checked);" <?php if($cnp_creditcard == 'CreditCard') echo 'checked="checked"'; if($cnp_payment_method == 'Creditcard') echo 'checked="checked" disabled="disabled"'; ?>> Credit Card</td>
                    <td><input type="radio" name="cnp_payment_method" value="Creditcard" onclick="defalut_payment(this.value);" <?php if($cnp_payment_method == 'Creditcard') echo 'checked="checked"'; ?>></td>
                    </tr>
                    <tr>
                    <td><input type="checkbox" value="eCheck" id="cnp_check" class="checkbox_active" name="cnp_check" onclick="block_echek(this.checked);" <?php if($cnp_check == 'eCheck') echo 'checked="checked"';  if($cnp_payment_method == 'eCheck') echo 'checked="checked" disabled="disabled"'; ?>> eCheck</td>
                    <td><input type="radio" name="cnp_payment_method" value="eCheck" onclick="defalut_payment(this.value);" <?php if($cnp_payment_method == 'eCheck') echo 'checked="checked"'; ?>></td>
                    </tr>
                    <!--<tr>
                    <td><input type="checkbox" value="Invoice" id="cnp_invoice" class="checkbox_active" name="cnp_invoice" <?php if($cnp_invoice == 'Invoice') echo 'checked="checked"'; if($cnp_payment_method == 'Invoice') echo 'checked="checked" disabled="disabled"'; ?> > Invoice</td>
                    <td><input type="radio" name="cnp_payment_method" value="Invoice" onclick="defalut_payment(this.value);" <?php if($cnp_payment_method == 'Invoice') echo 'checked="checked"'; ?>></td>
                    </tr> -->
                    <tr>
                    <td><input type="checkbox" value="Purchase Order" class="checkbox_active" id="cnp_purchas_order" name="cnp_purchas_order" <?php if($cnp_purchas_order == 'Purchase Order') echo 'checked="checked"'; if($cnp_payment_method == 'PurchaseOrder') echo 'checked="checked" disabled="disabled"'; ?>> Custom Payment</td>
                    <td><input type="radio" name="cnp_payment_method" value="PurchaseOrder" onclick="defalut_payment(this.value);" <?php if($cnp_payment_method == 'PurchaseOrder') echo 'checked="checked"'; ?>>
                      <input type="hidden" name="cnp_install" value="yes"/>
                    </td>
                    </tr>
                  </tbody></table>
                    <?php } ?>
                </div>
              </div>
              
              <div class="form-group" id="myDiv3" style="display:none">
              	<label for="cnp_recurring_contribution" class="col-sm-2 control-label">Recurring Contributions</label><?php // echo $cnp_recurring_contribution; ?>
                <div class="col-sm-10">
                      <div class="margin-form">
                      <label class="checkbox-inline">
                      <input type="checkbox" name="cnp_recurring_contribution" onclick =block_recurring(this.checked);  <?php if($cnp_recurring_contribution == 'on') echo 'checked="checked"'; ?> /> (Supported for Credit card and eCheck)
                      </label>
                      <br><br>
                      <div id="myDiv" style="display:none">
                      <strong>Supported recurring periodicity</strong>
                      <table cellpadding="5" cellspacing="3" class="table table-bordered">
                      <tr>
                      <td><input type="checkbox" value="Week" name="cnp_week" <?php if($cnp_week == 'Week') echo 'checked="checked"'; ?>/> Week</td>
                      <td><input type="checkbox" value="2 Weeks" name="cnp_2_weeks" <?php if($cnp_2_weeks == '2 Weeks') echo 'checked="checked"'; ?>/> 2 Weeks </td>
                      <td><input type="checkbox" value="Month" name="cnp_month" <?php if($cnp_month == 'Month') echo 'checked="checked"'; ?>/> Month</td>
                      <td><input type="checkbox" value="2 Months" name="cnp_2_months" <?php if($cnp_2_months == '2 Months') echo 'checked="checked"'; ?>/> 2 Months</td>
                      <td><input type="checkbox" value="Quarter" name="cnp_quarter" <?php if($cnp_quarter == 'Quarter') echo 'checked="checked"'; ?>/> Quarter</td>
                      <td><input type="checkbox" value="6 Months" name="cnp_6_months" <?php if($cnp_6_months == '6 Months') echo 'checked="checked"'; ?>/> 6 Months</td>
                      <td><input type="checkbox" value="Year" name="cnp_year" <?php if($cnp_year == 'Year') echo 'checked="checked"'; ?>/> Year</td>
                      </tr>
                      </table>
                      <strong>Recurring Method</strong>
                      <table cellpadding="5" cellspacing="3" class="table table-bordered">
                      <tr><td><input type="checkbox" value="Installment" name="cnp_installment" <?php if($cnp_installment == 'Installment') echo 'checked="checked"'; ?>/> Installment (example: Split $1000 into 10 payments of $100 each)</td></tr>
                      <tr><td><input type="checkbox" value="Subscription" name="cnp_subscription" onclick =block_subscription(this.checked); <?php if($cnp_subscription == 'Subscription') echo 'checked="checked"'; ?>/> Subscription (example: Pay $10 every month for 20 times) </td></tr>
                      </table>
                      <div id="myDiv1"style="display:none">
                      <strong>Enable Indefinite Recurring</strong>
                      <table cellpadding="5" cellspacing="3" class="table table-bordered">
                          <tr><td>
                          <input type="checkbox" value="999" name="cnp_indefinite" <?php if($cnp_indefinite == 999) echo 'checked="checked"'; ?>/> Indefinite (~)<span style="color: #080;"> optional</span>
                          </td></tr>
                      </table>
                      </div>
                      </div>
                      </div>
                </div>
              </div>
			</form>
		</div>
	   </div>
	</div>
</div>
<script type="text/javascript" src="view/javascript/new_js.js"></script>
		<script>
		var creditcard = document.clickandpledgesettings.cnp_creditcard.checked;
		var echeck = document.clickandpledgesettings.cnp_check.checked;
		
		/*if(document.getElementById("clickandpledge_send_receipt").checked == false){
		show_receipt_data(false);
		}
		function show_receipt_data(is_checked_info){
		 if(is_checked_info) { document.getElementById("receipt_setting_info").style.display = 'block';}
		 else {document.getElementById("receipt_setting_info").style.display = 'none';}
		}
		*/
		function defalut_payment(mess)
		{
		 if(mess == "Creditcard")
		 {
		   document.getElementById("cnp_creditcard").checked = true;
		   document.getElementById("myDiv3").style.display="block";
		   document.getElementById("cnp_creditcard").disabled = true;
		   
		   document.getElementById("cnp_check").disabled=false;
		   //document.getElementById("cnp_invoice").disabled=false;
		   document.getElementById("cnp_purchas_order").disabled=false;
		 }
		 if(mess == "eCheck")
		 {
		   document.getElementById("cnp_check").checked = true;
		   document.getElementById("myDiv3").style.display="block";
		   document.getElementById("cnp_check").disabled=true;
		   
		   document.getElementById("cnp_creditcard").disabled=false;
		   //document.getElementById("cnp_invoice").disabled=false;
		   document.getElementById("cnp_purchas_order").disabled=false;
		 }
		 
		 // if(mess == "Invoice")
		 // {
		   // document.getElementById("cnp_invoice").checked = true;
		   // document.getElementById("cnp_invoice").disabled=true;
		   
		   // document.getElementById("cnp_check").disabled=false;
		   // document.getElementById("cnp_creditcard").disabled=false;
		   // document.getElementById("cnp_purchas_order").disabled=false;
		 // }
		 if(mess == "PurchaseOrder")
		 {
		   document.getElementById("cnp_purchas_order").checked = true;
		   document.getElementById("cnp_purchas_order").disabled=true;
		   
		   document.getElementById("cnp_creditcard").disabled=false;
		   //document.getElementById("cnp_invoice").disabled=false;
		   document.getElementById("cnp_check").disabled=false;
		 }
		}
		if(creditcard || echeck)
		{
		document.getElementById("myDiv3").style.display="block";
		}
		if(document.clickandpledgesettings.cnp_recurring_contribution.checked)
		{
		block_recurring(document.clickandpledgesettings.cnp_recurring_contribution.checked)
		}
		if(document.clickandpledgesettings.cnp_subscription.checked)
		{
		block_subscription(document.clickandpledgesettings.cnp_subscription.checked)
		}
		if(document.clickandpledgesettings.cnp_creditcard.checked)
		{
		block_creditcard(document.clickandpledgesettings.cnp_creditcard.checked)
		}
		
			$("#cnp_sort_order").keypress(function(e) {
			// between 0 and 9
			if (e.which < 48 || e.which > 57) {
			alert("Please enter only numeric values.");
			$('#cnp_sort_order').focus();
			//showAdvice(this, "Integer values only");
			return false;  // stop processing
			}
			});
		$(".total_amount").keypress(function(event) { return isNumber(event) });
		function isNumber(evt) {		
			var charCode = (evt.which) ? evt.which : event.keyCode
			
			if (charCode != 45 && (charCode != 46 || 
			$(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57))
			return false;
			
			return true;
		}    
		function validation() {
			
			var recurring_contribution = document.clickandpledgesettings.cnp_recurring_contribution.checked;
			var week = document.clickandpledgesettings.cnp_week.checked;
			var week2 = document.clickandpledgesettings.cnp_2_weeks.checked;
			var month = document.clickandpledgesettings.cnp_month.checked;
			var months2 = document.clickandpledgesettings.cnp_2_months.checked;
			var quarter = document.clickandpledgesettings.cnp_quarter.checked;
			var months6 = document.clickandpledgesettings.cnp_6_months.checked;
			var year = document.clickandpledgesettings.cnp_year.checked;

			var recurring_installment = document.clickandpledgesettings.cnp_installment.checked;
			var recurring_subscription = document.clickandpledgesettings.cnp_subscription.checked;
			
			var creditcard = document.clickandpledgesettings.cnp_creditcard.checked;
			var echeck = document.clickandpledgesettings.cnp_check.checked;
			//var invoice = document.clickandpledgesettings.cnp_invoice.checked;
			var purchaseorder = document.clickandpledgesettings.cnp_purchas_order.checked;
			
			var status = document.clickandpledgesettings.cnp_status;
			var status_euro = document.clickandpledgesettings.cnp_status_euro;
			var status_pound = document.clickandpledgesettings.cnp_status_pound;
			
			//var cnp_org_info =  $("#cnp_org_info").val().length;
			//var cnp_thank_you =  $("#cnp_thank_you").val().length;
			var cnp_terms_conditions = $("#cnp_terms_conditions").val().length;
			var valid = true;
			if (isNaN($('#cnp_sort_order').val())){
			alert("Please enter only numeric values.");
			$('#cnp_sort_order').focus();
			valid = false;
			//return false;
			}
			
			//if(cnp_org_info > 1500) { alert('Receipt Header Message should be less than 1500 Characters'); $("#cnp_org_info").focus(); valid = false;}
			//if(cnp_thank_you > 500) { alert('Thank you Message should be less than 500 Characters '); $("#cnp_thank_you").focus();return false;}
			if(cnp_terms_conditions > 1500) { alert('Terms & conditions Message should be less than 1500 Characters'); $("#cnp_terms_conditions").focus();valid = false;}

			if(recurring_contribution && (creditcard || echeck))
			{
			if(!week && !week2 && !month && !months2 && !quarter && !months6 && !year)
			{
			alert("Select at least one recurring periodicity");
			valid = false;
			}
			}
			if(recurring_contribution && (week || week2 || month || months2 || quarter || months6 || year))
			{
				if(!recurring_installment && !recurring_subscription)
				{
				alert("Select at least one recurring method");
				valid = false;
				}
			
			}

			if(((!creditcard && !echeck && !purchaseorder) && status) || ((!creditcard && !echeck && !purchaseorder) && status_euro) || ((!creditcard && !echeck && !purchaseorder) && status_pound))
			{
				alert("Select at least one payment method");
				valid = false;
			}
			if (valid){
				$("input").removeAttr("disabled");
				$(clickandpledgesettings).submit();
			}
		}
		</script>
<?php echo $footer; ?>