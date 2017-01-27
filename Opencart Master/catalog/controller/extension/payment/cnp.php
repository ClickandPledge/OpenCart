<?php
class ControllerExtensionPaymentCnP extends Controller{

     public function index() {
	    
		$this->language->load('extension/payment/cnp');
		$this->load->model('extension/total/coupon');
		$this->load->model('checkout/order');
		$myvar = $this->cart->getSubTotal();
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		$data['cnp_amount'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);

		
        $data['continue'] = $this->url->link('checkout/success');		
		$data['text_credit_card'] = $this->language->get('text_credit_card');
		$data['entry_cc_owner'] = $this->language->get('entry_cc_owner');
		$data['entry_cc_number'] = $this->language->get('entry_cc_number');
		$data['entry_cc_expire_date'] = $this->language->get('entry_cc_expire_date');
		$data['entry_cc_cvv2'] = $this->language->get('entry_cc_cvv2');

		$data['text_echeck'] = $this->language->get('text_echeck');
		$data['routing_number'] = $this->language->get('routing_number');
		$data['Check_number'] = $this->language->get('Check_number');
		$data['account_number'] = $this->language->get('account_number');
		$data['retype_account_number'] = $this->language->get('retype_account_number');
		$data['account_type'] = $this->language->get('account_type');
		$data['check_type'] = $this->language->get('check_type');
		$data['name_on_account'] = $this->language->get('name_on_account');

		$data['text_invoice'] = $this->language->get('text_invoice');
		$data['text_purchase_order'] = $this->language->get('text_purchase_order');
		$data['purchase_order_number'] = $this->language->get('purchase_order_number');
		$data['button_confirm'] = $this->language->get('button_confirm');
		
		if ($order_info['currency_id']==3) {
			$data['currency_symbol'] = '&euro;';
		}
		if ($order_info['currency_id']==1) {
			$data['currency_symbol'] = '&pound;';
		}
		if ($order_info['currency_id']==2) {
			$data['currency_symbol'] = '$';
		}
		$data['months'] = array();

		for ($i = 1; $i <= 12; $i++) {
			$data['months'][] = array(
				'text'  => strftime('%B', mktime(0, 0, 0, $i, 1, 2000)),
				'value' => sprintf('%02d', $i)
			);
		}

		$today = getdate();

		$data['year_expire'] = array();

		for ($i = $today['year']; $i < $today['year'] + 11; $i++) {
			$data['year_expire'][] = array(
				'text'  => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)),
				'value' => strftime('%y', mktime(0, 0, 0, 1, 1, $i))
			);
		}
		
		$data['defalut_payment'] = $this->config->get('cnp_payment_method');
		
		$data['cnp_creditcard'] = $this->config->get('cnp_creditcard');
		$data['cnp_echeck'] = $this->config->get('cnp_check');
		$data['cnp_invoice'] = $this->config->get('cnp_invoice');
		$data['cnp_purchas_order'] = $this->config->get('cnp_purchas_order');
		
		$data['cnp_recurring_contribution'] = $this->config->get('cnp_recurring_contribution');
		$data['cnp_week'] = $this->config->get('cnp_week');
		$data['cnp_2_weeks'] = $this->config->get('cnp_2_weeks');
		$data['cnp_month'] = $this->config->get('cnp_month');
		$data['cnp_2_months'] = $this->config->get('cnp_2_months');		
		$data['cnp_quarter'] = $this->config->get('cnp_quarter');
		$data['cnp_6_months'] = $this->config->get('cnp_6_months');
		$data['cnp_year'] = $this->config->get('cnp_year');
		$data['cnp_installment'] = $this->config->get('cnp_installment');
		$data['cnp_subscription'] = $this->config->get('cnp_subscription');
		$data['cnp_indefinite'] = $this->config->get('cnp_indefinite');


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/payment/cnp.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/extension/payment/cnp.tpl', $data);
		} else {
			return $this->load->view('extension/payment/cnp.tpl', $data);
		}
     }
	 
	public function floor_dec($number,$precision,$separator)
	{
	if(strstr($number,'.'))
	{
	$numberpart=@explode($separator,$number);
	$ceil_number= array($numberpart[0],substr($numberpart[1],0,2));
	return implode($separator,$ceil_number);
	}
	return $number;
	}
	
	 
	public function confirm() {
		if ($this->session->data['payment_method']['code'] == 'cnp') {
			$this->load->model('checkout/order');
			
			$this->load->model('extension/extension');
			$item_full ='';
			$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
			
			 /***********  opencart Country codes ***************/
			 
			$opencart_country_code = array('1'=>'004','2'=>'008','3'=>'012','4'=>'016','5'=>'020','6'=>'024','7'=>'660','8'=>'010','9'=>'028','10'=>'032',
			'11'=>'051','12'=>'533','13'=>'036','14'=>'040','15'=>'031','16'=>'044','17'=>'048','18'=>'050','18'=>'050','19'=>'052','20'=>'112','21'=>'056','22'=>'084',
			'23'=>'204','24'=>'060','25'=>'064','26'=>'068','27'=>'070','28'=>'072','29'=>'074','30'=>'076','31'=>'086','32'=>'096','33'=>'100','34'=>'854','35'=>'108',
			'36'=>'116','37'=>'120','38'=>'124','39'=>'132','40'=>'136','41'=>'140','42'=>'148','43'=>'152','44'=>'156','45'=>'162','46'=>'166','47'=>'170','48'=>'174',
			'49'=>'178','50'=>'184','51'=>'188','52'=>'384','53'=>'191','54'=>'192','55'=>'196','56'=>'203','57'=>'208','58'=>'262','59'=>'212','60'=>'214','61'=>'626',
			'62'=>'218','63'=>'818','64'=>'222','65'=>'226','66'=>'232','67'=>'233','68'=>'231','69'=>'238','70'=>'234','71'=>'242','72'=>'246','73'=>'250','74'=>'000',
			'75'=>'254','76'=>'258','77'=>'260','78'=>'266','79'=>'270','80'=>'268','81'=>'276','82'=>'288','83'=>'292','84'=>'300','85'=>'304','86'=>'308','87'=>'312',
			'88'=>'316','89'=>'320','90'=>'324','91'=>'624','92'=>'328','93'=>'332','94'=>'334','95'=>'340','96'=>'344','97'=>'348','98'=>'352','99'=>'356','100'=>'360',
			'101'=>'364','102'=>'368','103'=>'372','104'=>'376','105'=>'380','106'=>'388','107'=>'392','108'=>'400','109'=>'398','110'=>'404','111'=>'296','112'=>'408',
			'113'=>'410','114'=>'414','115'=>'417','116'=>'418','117'=>'428','118'=>'422','119'=>'426','120'=>'430','121'=>'434','122'=>'438','123'=>'440','124'=>'442',
			'125'=>'446','126'=>'807','127'=>'450','128'=>'454','129'=>'458','130'=>'462','131'=>'466','132'=>'470','133'=>'584','134'=>'474','135'=>'478','136'=>'480',
			'137'=>'175','138'=>'484','139'=>'583','140'=>'498','141'=>'492','142'=>'496','143'=>'500','144'=>'504','145'=>'508','146'=>'104','147'=>'516','148'=>'520',
			'149'=>'524','150'=>'528','151'=>'000','152'=>'540','153'=>'554','154'=>'558','155'=>'562','156'=>'566','157'=>'570','158'=>'574','159'=>'580','160'=>'578',
			'161'=>'512','162'=>'586','163'=>'585','164'=>'591','165'=>'598','166'=>'600','167'=>'604','168'=>'608','169'=>'612','170'=>'616','171'=>'620','172'=>'630',
			'173'=>'634','174'=>'638','175'=>'642','176'=>'643','177'=>'646','178'=>'659','179'=>'662','180'=>'670','181'=>'882','182'=>'674','183'=>'678','184'=>'682',
			'185'=>'686','186'=>'690','187'=>'694','188'=>'702','189'=>'703','190'=>'705','191'=>'090','192'=>'706','193'=>'710','194'=>'239','195'=>'724','196'=>'144',
			'197'=>'654','198'=>'666','199'=>'729','200'=>'740','201'=>'744','202'=>'748','203'=>'752','204'=>'756','205'=>'760','206'=>'158','207'=>'762','208'=>'834',
			'209'=>'764','210'=>'768','211'=>'772','212'=>'776','213'=>'780','214'=>'788','215'=>'792','216'=>'795','217'=>'796','218'=>'798','219'=>'800','220'=>'804',
			'221'=>'784','222'=>'826','223'=>'840','224'=>'581','225'=>'858','226'=>'860','227'=>'548','228'=>'336','229'=>'862','230'=>'704','231'=>'092','232'=>'850',
			'233'=>'876','234'=>'732','235'=>'887','236'=>'000','237'=>'180','238'=>'894','239'=>'716','240'=>'384','241'=>'688','242'=>'499');
			 
			 /**************************************************/
			 
			 /************ Create Xml File formate ***************/
             
			// Euro currency Account
			 if ($this->session->data['currency'] == 'EUR') {
			     $accountid = $this->config->get('cnp_login_euro');
			     $guid = $this->config->get('cnp_key_euro');
				 $mode = ucfirst($this->config->get('cnp_server_euro'));
			 }
			 // Pound currency Account
			 if ($this->session->data['currency'] == 'GBP') {
			     $accountid = $this->config->get('cnp_login_pound');
			     $guid = $this->config->get('cnp_key_pound');
				 $mode = ucfirst($this->config->get('cnp_server_pound'));
			 }
			 // USD Currency Account
			if ($this->session->data['currency'] == 'USD') {
			  $accountid = $this->config->get('cnp_login');
			  $guid = $this->config->get('cnp_key');
			  $mode = ucfirst($this->config->get('cnp_server'));
			 }
			 // Canadian Dollar currency Account
			 if ($this->session->data['currency'] == 'CAD') {
			     $accountid = $this->config->get('cnp_cad_login');
			     $guid = $this->config->get('cnp_cad_key');
				 $mode = ucfirst($this->config->get('cnp_cad_server'));
			 }
			 // HKD Hong Kong Dollar Currency Account
			if ($this->session->data['currency'] == 'HKD') {
			  $accountid = $this->config->get('cnp_hkd_login');
			  $guid = $this->config->get('cnp_hkd_key');
			  $mode = ucfirst($this->config->get('cnp_hkd_server'));
			 }
			
			 $dom = new DOMDocument('1.0', 'UTF-8');
             $root = $dom->createElement('CnPAPI', '');
             $root->setAttribute("xmlns","urn:APISchema.xsd");
             $root = $dom->appendChild($root);
			 
			 $oc_version = VERSION;
			
			 $version=$dom->createElement("Version","4.0");
    		 $version=$root->appendChild($version);
			 
			 $engine = $dom->createElement('Engine', '');
             $engine = $root->appendChild($engine);
			 
			 $application = $dom->createElement('Application','');
			 $application = $engine->appendChild($application);
    
			 $applicationid=$dom->createElement('ID','Cnp:PaaS:OpenCart');
			 $applicationid=$application->appendChild($applicationid);
			
			 $applicationname=$dom->createElement('Name','Salesforce:CnP_PaaS_SC_OpenCart');
			 $applicationid=$application->appendChild($applicationname);
			 
			 $applicationversion=$dom->createElement('Version',"4.0/OpenCart V ".$oc_version);
			 $applicationversion=$application->appendChild($applicationversion);
    
    		 $request = $dom->createElement('Request', '');
    		 $request = $engine->appendChild($request);
    
    		 $operation=$dom->createElement('Operation','');
    		 $operation=$request->appendChild($operation);
			 
			 $operationtype=$dom->createElement('OperationType','Transaction');
    		 $operationtype=$operation->appendChild($operationtype);
    
    		 $ipaddress=$dom->createElement('IPAddress',$_SERVER['REMOTE_ADDR']);
    		 $ipaddress=$operation->appendChild($ipaddress);
			 
			 $httpreferrer=$dom->createElement('UrlReferrer',$_SERVER['HTTP_REFERER']);
			 $httpreferrer=$operation->appendChild($httpreferrer);
    
			 $authentication=$dom->createElement('Authentication','');
    		 $authentication=$request->appendChild($authentication);
			
    		 $accounttype=$dom->createElement('AccountGuid',htmlentities($guid, ENT_QUOTES, 'UTF-8') ); 
    		 $accounttype=$authentication->appendChild($accounttype);
    
    		 $accountid=$dom->createElement('AccountID',htmlentities($accountid, ENT_QUOTES, 'UTF-8'));
    		 $accountid=$authentication->appendChild($accountid);
			 
			 $order=$dom->createElement('Order','');
    		 $order=$request->appendChild($order);
				
    		 $ordermode=$dom->createElement('OrderMode',$mode);
    		 $ordermode=$order->appendChild($ordermode);
			 
			 $cardholder=$dom->createElement('CardHolder','');
    		 $cardholder=$order->appendChild($cardholder);
			 
			 $billinginfo=$dom->createElement('BillingInformation','');
    		 $billinginfo=$cardholder->appendChild($billinginfo);

			 $billfirst_name=$dom->createElement('BillingFirstName',htmlentities($order_info['payment_firstname'], ENT_QUOTES, 'UTF-8'));
			 $billfirst_name=$billinginfo->appendChild($billfirst_name);
			
			 $billlast_name=$dom->createElement('BillingLastName',htmlentities($order_info['payment_lastname'], ENT_QUOTES, 'UTF-8'));
			 $billlast_name=$billinginfo->appendChild($billlast_name);
		
			 $bill_email=$dom->createElement('BillingEmail',htmlentities($order_info['email'], ENT_QUOTES, 'UTF-8'));
			 $bill_email=$billinginfo->appendChild($bill_email);
			
			 $bill_phone=$dom->createElement('BillingPhone',htmlentities($order_info['telephone'], ENT_QUOTES, 'UTF-8'));
			 $bill_phone=$billinginfo->appendChild($bill_phone);
		
			 $billingaddress=$dom->createElement('BillingAddress','');
			 $billingaddress=$cardholder->appendChild($billingaddress);
		
			 $billingaddress1=$dom->createElement('BillingAddress1',substr(htmlentities($order_info['payment_address_1'], ENT_QUOTES, 'UTF-8'),0,100));
			 $billingaddress1=$billingaddress->appendChild($billingaddress1);
			
			 $billingaddress2=$dom->createElement('BillingAddress2',substr(htmlentities($order_info['payment_address_2'], ENT_QUOTES, 'UTF-8'),0,100));
			 $billingaddress2=$billingaddress->appendChild($billingaddress2);
			
			 $billingaddress3=$dom->createElement('BillingAddress3','');
			 $billingaddress3=$billingaddress->appendChild($billingaddress3);
			
			 $billing_city=$dom->createElement('BillingCity',substr(htmlentities($order_info['payment_city'], ENT_QUOTES, 'UTF-8'),0,40));
			 $billing_city=$billingaddress->appendChild($billing_city);
			 
			 $billing_state=$dom->createElement('BillingStateProvince',htmlentities($order_info['payment_zone'], ENT_QUOTES, 'UTF-8'));
			 $billing_state=$billingaddress->appendChild($billing_state);
				
			 if($order_info['payment_postcode'] != '') {
			 $billing_zip=$dom->createElement('BillingPostalCode',substr(htmlentities($order_info['payment_postcode'], ENT_QUOTES, 'UTF-8'),0,20));
			 $billing_zip=$billingaddress->appendChild($billing_zip);
			 }
			 
			 $billing_country=$dom->createElement('BillingCountryCode',str_pad($opencart_country_code[$order_info['payment_country_id']], 3, "0", STR_PAD_LEFT));
			 $billing_country=$billingaddress->appendChild($billing_country);
			 
			 if($order_info['shipping_firstname'] != ''){
			 $shippinginfo=$dom->createElement('ShippingInformation','');
			 $shippinginfo=$cardholder->appendChild($shippinginfo);
			 
			 $shippingcontact=$dom->createElement('ShippingContactInformation','');
			 $shippingcontact=$shippinginfo->appendChild($shippingcontact);
	
			 $ship_first_name=$dom->createElement('ShippingFirstName',htmlentities($order_info['shipping_firstname'], ENT_QUOTES, 'UTF-8'));
			 $ship_first_name=$shippingcontact->appendChild($ship_first_name);
	
			 $ship_mi=$dom->createElement('ShippingMI', "");
			 $ship_mi=$shippingcontact->appendChild($ship_mi);
	
			 $ship_last_name=$dom->createElement('ShippingLastName',htmlentities($order_info['shipping_lastname'], ENT_QUOTES, 'UTF-8'));
			 $ship_last_name=$shippingcontact->appendChild($ship_last_name);

			 $ship_email=$dom->createElement('ShippingEmail',htmlentities($order_info['email'], ENT_QUOTES, 'UTF-8'));
			 $ship_email=$shippingcontact->appendChild($ship_email);	
	
			 $ship_phone=$dom->createElement('ShippingPhone',htmlentities($order_info['telephone'], ENT_QUOTES, 'UTF-8'));
			 $ship_phone=$shippingcontact->appendChild($ship_phone);    
		
			 $shippingaddress=$dom->createElement('ShippingAddress','');
			 $shippingaddress=$shippinginfo->appendChild($shippingaddress);
			
			 $ship_address1=$dom->createElement('ShippingAddress1',substr(htmlentities($order_info['shipping_address_1'], ENT_QUOTES, 'UTF-8'),0,100));
			 $ship_address1=$shippingaddress->appendChild($ship_address1);
		
			 $ship_address2=$dom->createElement('ShippingAddress2',substr(htmlentities($order_info['shipping_address_2'], ENT_QUOTES, 'UTF-8'),0,100));
			 $ship_address2=$shippingaddress->appendChild($ship_address2);
		
			 $ship_city=$dom->createElement('ShippingCity',substr(htmlentities($order_info['shipping_city'], ENT_QUOTES, 'UTF-8'),0,40));
			 $ship_city=$shippingaddress->appendChild($ship_city);
		
			 $ship_state=$dom->createElement('ShippingStateProvince',htmlentities($order_info['shipping_zone_code'], ENT_QUOTES, 'UTF-8'));
			 $ship_state=$shippingaddress->appendChild($ship_state);
			 
			 if($order_info['shipping_postcode'] != '') {
			 $ship_zip=$dom->createElement('ShippingPostalCode',substr(htmlentities($order_info['shipping_postcode'], ENT_QUOTES, 'UTF-8'),0,20));
			 $ship_zip=$shippingaddress->appendChild($ship_zip);
			 } 
			 $ship_country=$dom->createElement('ShippingCountryCode',str_pad($opencart_country_code[$order_info['shipping_country_id']], 3, "0", STR_PAD_LEFT));
			 $ship_country=$shippingaddress->appendChild($ship_country);
			 }
			 
			 if($order_info['comment'] != '' || $order_info['fax'] !='' || $order_info['payment_company'] != '') {
			 $customfieldlist = $dom->createElement('CustomFieldList','');
             $customfieldlist = $cardholder->appendChild($customfieldlist);
			 }if($order_info['comment'] != ''){
			 $customfield = $dom->createElement('CustomField','');
			 $customfield = $customfieldlist->appendChild($customfield);
			
			 $fieldname = $dom->createElement('FieldName','Comments');
			 $fieldname = $customfield->appendChild($fieldname);
			
			 $fieldvalue = $dom->createElement('FieldValue',substr(htmlentities($order_info['comment'], ENT_QUOTES, 'UTF-8'), 0, 500));
			 $fieldvalue = $customfield->appendChild($fieldvalue);
			 } if($order_info['fax'] !=''){
			 $customfield1 = $dom->createElement('CustomField','');
			 $customfield1 = $customfieldlist->appendChild($customfield1);
			
			 $fieldname1 = $dom->createElement('FieldName','Customer Fax');
			 $fieldname1 = $customfield1->appendChild($fieldname1);
			 
			 $fieldvalue1 = $dom->createElement('FieldValue',substr(htmlentities($order_info['fax'], ENT_QUOTES, 'UTF-8'), 0, 50));
			 $fieldvalue1 = $customfield1->appendChild($fieldvalue1);
			 } if($order_info['payment_company'] != ''){
			 $customfield2 = $dom->createElement('CustomField','');
			 $customfield2 = $customfieldlist->appendChild($customfield2);
			
			 $fieldname2 = $dom->createElement('FieldName','Billing Company');
			 $fieldname2 = $customfield2->appendChild($fieldname2);
			
			 $fieldvalue2 = $dom->createElement('FieldValue',substr(htmlspecialchars ( html_entity_decode ($order_info['payment_company']) , ENT_QUOTES, 'UTF-8'), 0, 50));
			 $fieldvalue2 = $customfield2->appendChild($fieldvalue2);
			 } if($order_info['shipping_company'] != ''){
			 $customfield3 = $dom->createElement('CustomField','');
			 $customfield3 = $customfieldlist->appendChild($customfield3);
	
			 $fieldname3 = $dom->createElement('FieldName','Shipping Company');
			 $fieldname3 = $customfield3->appendChild($fieldname3);
	
			 @$fieldvalue3 = $dom->createElement('FieldValue',substr(htmlspecialchars(html_entity_decode ($order_info['shipping_company']), ENT_QUOTES, 'UTF-8'), 0, 50));
			 $fieldvalue3 = $customfield3->appendChild($fieldvalue3);
			 }
			 
			 $paymentmethod=$dom->createElement('PaymentMethod','');
			 $paymentmethod=$cardholder->appendChild($paymentmethod);
			
			 if($this->request->post['payment_method'] == 'creditcard') {
			
			 $payment_type=$dom->createElement('PaymentType','CreditCard');
			 $payment_type=$paymentmethod->appendChild($payment_type);
			
			 $creditcard=$dom->createElement('CreditCard','');
			 $creditcard=$paymentmethod->appendChild($creditcard);
				
			 $credit_name=$dom->createElement('NameOnCard',$this->request->post['cc_owner']);
			 $credit_name=$creditcard->appendChild($credit_name);
			
			 $credit_number=$dom->createElement('CardNumber',str_replace(' ', '', $this->request->post['cc_number']));
			 $credit_number=$creditcard->appendChild($credit_number);
			
			 $credit_cvv=$dom->createElement('Cvv2',$this->request->post['cc_cvv2']);
			 $credit_cvv=$creditcard->appendChild($credit_cvv);
			 
			 $credit_expdate=$dom->createElement('ExpirationDate',$this->request->post['cc_expire_date_month'] ."/" .$this->request->post['cc_expire_date_year']);
			 $credit_expdate=$creditcard->appendChild($credit_expdate);
			 }
			 if($this->request->post['payment_method'] == 'echeck')
			 {
			 $payment_type=$dom->createElement('PaymentType','Check');
			 $payment_type=$paymentmethod->appendChild($payment_type);
			 
			 $echeck=$dom->createElement('Check','');
			 $echeck=$paymentmethod->appendChild($echeck);
			 
			 $AccountNumber=$dom->createElement('AccountNumber',$this->request->post['account_number']);
			 $AccountNumber=$echeck->appendChild($AccountNumber);
			 
			 $AccountType=$dom->createElement('AccountType',$this->request->post['account_type']);
			 $AccountType=$echeck->appendChild($AccountType);
			 
			 $RoutingNumber=$dom->createElement('RoutingNumber',$this->request->post['routing_number']);
			 $RoutingNumber=$echeck->appendChild($RoutingNumber);
			 
			 $CheckNumber=$dom->createElement('CheckNumber',$this->request->post['Check_number']);
			 $CheckNumber=$echeck->appendChild($CheckNumber);
		
			 $CheckType=$dom->createElement('CheckType',$this->request->post['check_type']);
			 $CheckType=$echeck->appendChild($CheckType);
			 
			 $NameOnAccount=$dom->createElement('NameOnAccount',str_replace('&', '&amp;',$this->request->post['name_on_account']));
			 $NameOnAccount=$echeck->appendChild($NameOnAccount);
			 }			
				
			 if($this->request->post['payment_method'] == 'invoice')
			 {
			 $payment_type=$dom->createElement('PaymentType','Invoice');
			 $payment_type=$paymentmethod->appendChild($payment_type);
			 
			 $invoice=$dom->createElement('Invoice','');
			 $invoice=$paymentmethod->appendChild($invoice);
			 
			 $CheckNumber=$dom->createElement('InvoiceCheckNumber',$this->request->post['Check_number']);
			 $CheckNumber=$invoice->appendChild($CheckNumber);
			 }
			
			 if($this->request->post['payment_method'] == 'purchase_order')
			 {
			 $payment_type=$dom->createElement('PaymentType','PurchaseOrder');
			 $payment_type=$paymentmethod->appendChild($payment_type);
			 
			 $PurchaseOrder=$dom->createElement('PurchaseOrder','');
			 $PurchaseOrder=$paymentmethod->appendChild($PurchaseOrder);
			 
			 $CheckNumber=$dom->createElement('PurchaseOrderNumber',$this->request->post['purchase_order_number']);
			 $CheckNumber=$PurchaseOrder->appendChild($CheckNumber);
			 
			 }
		 
			 $orderitemlist=$dom->createElement('OrderItemList','');
             $orderitemlist=$order->appendChild($orderitemlist);
			 if(isset($this->request->post['indefinite_times']))$number_of_times = $this->request->post['indefinite_times'];
			 else if(isset($this->request->post['number_of_times']))$number_of_times = $this->request->post['number_of_times']; else $number_of_times = 0;
				
			 $product = $this->cart->getProducts();
			 
			 $total=0;
			 $handling_data = 0;
			 $reward_data = 0;
			 $ship_data = 0;
			 $tax_data = 0;
			 $coupon_data = 0;
			 $voucher_data = 0;
			 $subtotal_data = 0;
			 $total_data = 0;
			 $loworderfee_data = 0;
			 $main_tax_oc = 0;
			 $tax_value_handling = 0;
			 $loworderfee_name = 0;
			 $coupon_value = 0;
			 $voucher_value = 0;
			 $shipp_name = 0;
			 $shipp_value = 0;
			 $coupon_tax = 0;
			 $loworderfee_value = 0;
			 $coupon_code = 0;
			 $tax_value_ship = 0;
			 $voucher_code = 0;
			 $discount = 0;
			 $exchange_rate = 0;
			 $exp = 0;
			 $coupon_info = 0;
			 $total_unit_tax = 0;
			 $main_unit_tax = 0;
			 $main_unit_tax_total = 0;
			 $main_unit_tax_total_cnp = 0;
			 $tax_value_low = 0;
			 $handling_name = 0;
			 $handling_value = 0;
			 $main_dicount_cnp_total = 0;
			 $cnp_low_tax_total = 0;
			 $cnp_handling_tax_total = 0;
			 $reward_value = 0;
			
			  $pound = $this->currency->getSymbolLeft('');
			 $dollor = $this->currency->getSymbolRight('');
			 $exp=array($pound,$dollor,",","-");
			 $exchange_rate = number_format($this->currency->getValue($this->session->data['currency']), 4, '.', '');
			
			 $taxes = $this->cart->getTaxes();
			 
			 $totals = array();
			

				// Because __call can not keep var references so we put them into an array.
				$total_data = array(
					'totals' => &$totals,
					'taxes'  => &$taxes,
					'total'  => &$total
				);
			
			if(($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {						 
							
			   $sort_order = array(); 
				
			   $results = $this->model_extension_extension->getExtensions('total');	
			   
	
				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}
				
				array_multisort($sort_order, SORT_ASC, $results);
			   }
			 foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);

						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
						
					}
					$sort_order = array();

					foreach ($totals as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $totals);
				}
			
			foreach($total_data as $totalkey => $totalvalue)
			{
				
				if (is_array($totalvalue) || is_object($totalvalue))
				{
				foreach($totalvalue as $cnptotal)
				{
					// handling data 
					if($cnptotal['code'] == 'handling')
					{
						 $handling_name = $cnptotal['title'];
					     $handling_value = $cnptotal['value']*$exchange_rate;
					   
						 $handling_id ="001";
						 $handling_quantity ="1";
						 $handling_sku="SKUHANDLING";	
					}
					
					// low order free data
					if($cnptotal['code'] == 'low_order_fee')
					{
						 
					     $loworderfee_name  = $cnptotal['title'];
						 $loworderfee_value = $cnptotal['value']*$exchange_rate;
						 $loworderfee_id ="002";
						 $loworderfee_quantity ="1";
						 $loworderfee_sku = "SKUORDERFEE";	
					}
					
					// shipping value data
					if($cnptotal['code'] == 'shipping')
					{
						 $shipp_name  = $cnptotal['title'];
						 $shipp_value = $cnptotal['value']*$exchange_rate;
					}
					
					// Coupon value data
					if($cnptotal['code'] == 'coupon')
					{
						 $coupon_code  = $cnptotal['title'];
						
						 $coupon_value = -$cnptotal['value'];
                         
					}
					
					// Voucher value data
					if($cnptotal['code'] == 'voucher')
					{
						 $voucher_code  = $cnptotal['title'];
						 $voucher_value  = -$cnptotal['value'];	
					}
					// Voucher value data
					if($cnptotal['code'] == 'reward')
					{
						
						 $reward_value  = -$cnptotal['value'];	
					}
					
					// sub_total value data
					if($cnptotal['code'] == 'sub_total')
					{
						 $sub_name  = $cnptotal['title'];
						 $sub_value  = $cnptotal['value'];	
					}
					// sub_total value data
					if($cnptotal['code'] == 'total')
					{
						 $total_name  = $cnptotal['title'];
						 $total_value  = $cnptotal['value']*$exchange_rate;	
					}
								
				}
				}
			}
			
				// Total Taxes 	
			foreach($total_data['taxes'] as $main_taxes)
			{
				$main_tax_oc += $main_taxes*$exchange_rate;
			}
			
			
			// Coupon Info Data
			$this->load->model('extension/total/coupon');
						
			if(isset($this->session->data['coupon']) && !empty($this->session->data['coupon']))
			{			
		    $coupon_info = $this->model_extension_total_coupon->getCoupon($this->session->data['coupon']);
			if(isset($coupon_info) && !empty($coupon_info))
			{
				$discount_total = 0;

				if (!$coupon_info['product']) {
					$sub_total = $this->cart->getSubTotal();
				} else {
					$sub_total = 0;

					foreach ($this->cart->getProducts() as $product_cnp) {
						if (in_array($product_cnp['product_id'], $coupon_info['product'])) {
							$sub_total += $product_cnp['total'];
						}
					}
				}
				if ($coupon_info['type'] == 'F') {
					$coupon_info['discount'] = min($coupon_info['discount'], $sub_total);
				}
				 
			    }
			    }
              // Handling Info Data
			 if(($this->cart->getSubTotal() > $this->config->get('handling_total')) && ($this->cart->getSubTotal() > 0)) {
				$this->load->language('extension/total/handling');
				$handling_data = array(
					'code'       => 'handling',
					'title'      => $this->language->get('text_handling'),
					'value'      => $this->config->get('handling_fee'),
					'sort_order' => $this->config->get('handling_sort_order'),
					'status' => $this->config->get('handling_status')
				);
				}
			
			// Low Order Fee Info Data
			if($this->cart->getSubTotal() && ($this->cart->getSubTotal() < $this->config->get('low_order_fee_total'))) {
			$this->load->language('extension/total/low_order_fee');
			$loworderfee_data = array(
				'code'       => 'low_order_fee',
				'title'      => $this->language->get('text_low_order_fee'),
				'value'      => $this->config->get('low_order_fee_fee'),
				'sort_order' => $this->config->get('low_order_fee_sort_order'),
				'status' 	 => $this->config->get('low_order_fee_status')
				);
			}
			
			// Shipping Data
			if ($this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
			$shipping_method = array(
				'code'       => 'shipping',
				'title'      => $this->session->data['shipping_method']['title'],
				'value'      => $this->session->data['shipping_method']['cost'],
				'sort_order' => $this->config->get('shipping_sort_order')
			);
			}
			
			// All Taxes 
			if(isset($taxes) && !empty($taxes))
			 {   
		         $tax_rates = $this->tax->getRates($this->config->get('handling_fee'), $this->config->get('handling_tax_class_id'));
				 $tax_rates_ship = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
				 $tax_rates_low = $this->tax->getRates($this->config->get('low_order_fee_fee'), $this->config->get('low_order_fee_tax_class_id'));
				
				 // Handling Tax 		
				 if($handling_data['status'] != 0)
				 {			   
					 foreach($tax_rates as $key => $value)
					 { 
					    $tax_value_handling += $value['amount']*$exchange_rate;
					 }
					
				 } else{
			            $tax_value_handling = 000;
					   }
			    
                // Shipping Method Tax				
				if(isset($shipping_method) && !empty($shipping_method))
				 {	
			         foreach($tax_rates_ship as $key => $value)
					 { 
					$tax_value_ship += $value['amount']*$exchange_rate;
					 }
				 } 
				else {
			       $tax_value_ship = 000;
					}
					
                //	Low Order Fee Tax		
				 if($loworderfee_data['status'] != 0)
				 {	 
			         foreach($tax_rates_low as $key => $value)
					 { 
					  	$tax_value_low += $value['amount']*$exchange_rate;
					 }
				 }
				 else{
			            $tax_value_low = 000;
				     }
				}
		
			 
			 $this->load->model('catalog/product');	
			 $tm_amt=0;
			
			 // Handling Data Recurring 
			 if(isset($handling_data) && $handling_name!="" && isset($this->request->post['is_recurring']) && $this->request->post['is_recurring'] == 1 && isset($this->request->post['recurring_method']) && $this->request->post['recurring_method'] == 'Installment'){
			
				 $orderitem=$dom->createElement('OrderItem','');
				 $orderitem=$orderitemlist->appendChild($orderitem);
				 $handling_id = 107100;
				 $itemid=$dom->createElement('ItemID',$handling_id);
				 $itemid=$orderitem->appendChild($itemid);
				 
				 $itemname=$dom->createElement('ItemName',substr($handling_name, 0, 50));
				 $itemname=$orderitem->appendChild($itemname);
				
				 $quntity=$dom->createElement('Quantity',$handling_quantity);
				 $quntity=$orderitem->appendChild($quntity);
                 
				 $cnp_handling = $this->floor_dec($handling_value/$number_of_times,2,'.','');
				 $cnp_handling_total = $cnp_handling*$number_of_times;
				 
				 $round_price = round(($handling_value*$exchange_rate)/$number_of_times, 2);
				 $unitprice=$dom->createElement('UnitPrice',$cnp_handling*100);
				 $unitprice=$orderitem->appendChild($unitprice);
				 
				 $cnp_handling_tax = round(($tax_value_handling/$number_of_times),2);
				 $cnp_handling_tax_total = $cnp_handling_tax*$number_of_times;
				 				 
				  $unit_tax=$dom->createElement('UnitTax',$cnp_handling_tax*100);
				  $unit_tax=$orderitem->appendChild($unit_tax);
				 			
				 
				 $sku_code=$dom->createElement('SKU',substr(htmlentities($handling_sku, ENT_QUOTES, 'UTF-8'), 0, 100));
				 $sku_code=$orderitem->appendChild($sku_code);
				
			}
			// Handling Data 
			if(isset($handling_data) && $handling_name!="" && !(isset($this->request->post['is_recurring']) && $this->request->post['is_recurring'] == 1 && isset($this->request->post['recurring_method']) && $this->request->post['recurring_method'] == 'Installment')){
			
				 $orderitem=$dom->createElement('OrderItem','');
				 $orderitem=$orderitemlist->appendChild($orderitem);
				 $handling_id = 107100;
				 $itemid=$dom->createElement('ItemID',$handling_id);
				 $itemid=$orderitem->appendChild($itemid);
				 
				 $itemname=$dom->createElement('ItemName',substr($handling_name, 0, 50));
				 $itemname=$orderitem->appendChild($itemname);
				
				 $quntity=$dom->createElement('Quantity',$handling_quantity);
				 $quntity=$orderitem->appendChild($quntity);

				 $round_price = round($handling_value*$exchange_rate, 2);
				 $unitprice=$dom->createElement('UnitPrice',($round_price)*100);
				 $unitprice=$orderitem->appendChild($unitprice);
				 
				 $unit_tax=$dom->createElement('UnitTax',round($tax_value_handling,2)*100);
				 $unit_tax=$orderitem->appendChild($unit_tax);
				 			
				 
				 $sku_code=$dom->createElement('SKU',substr(htmlentities($handling_sku, ENT_QUOTES, 'UTF-8'), 0, 100));
				 $sku_code=$orderitem->appendChild($sku_code);
				
			} 
			if(isset($loworderfee_data) && $loworderfee_name!="" && isset($this->request->post['is_recurring']) && $this->request->post['is_recurring'] == 1 && isset($this->request->post['recurring_method']) && $this->request->post['recurring_method'] == 'Installment'){
			
				 $orderitem=$dom->createElement('OrderItem','');
				 $orderitem=$orderitemlist->appendChild($orderitem);
				    if(empty($handling_data))
					{
					 $loworderfee_id = 107100;
					}	else {
					 $loworderfee_id = 107101;
					}
				 $itemid=$dom->createElement('ItemID',$loworderfee_id);
				 $itemid=$orderitem->appendChild($itemid);
				 
				 $itemname=$dom->createElement('ItemName',substr($loworderfee_name, 0, 50));
				 $itemname=$orderitem->appendChild($itemname);
				
				 $quntity=$dom->createElement('Quantity',$loworderfee_quantity);
				 $quntity=$orderitem->appendChild($quntity);
				 
				 $cnp_low_order = $this->floor_dec($loworderfee_value/$number_of_times,2,'.','');
				 $cnp_low_order_total = $cnp_low_order*$number_of_times;
				 
				 $round_price = round(($loworderfee_value*$exchange_rate)/$number_of_times, 2);
				 $unitprice=$dom->createElement('UnitPrice',$cnp_low_order*100);
				 $unitprice=$orderitem->appendChild($unitprice);
				 
				 $cnp_low_tax = round(($tax_value_low/$number_of_times),2);
				 $cnp_low_tax_total = $cnp_low_tax*$number_of_times;
				
				 //cnp
				 $unit_tax=$dom->createElement('UnitTax',$cnp_low_tax*100);
				 $unit_tax=$orderitem->appendChild($unit_tax);
				 			
				 
				 $sku_code=$dom->createElement('SKU',substr(htmlentities($loworderfee_sku, ENT_QUOTES, 'UTF-8'), 0, 100));
				 $sku_code=$orderitem->appendChild($sku_code);
			
			}
			if(isset($loworderfee_data) && $loworderfee_name!="" && !(isset($this->request->post['is_recurring']) && $this->request->post['is_recurring'] == 1 && isset($this->request->post['recurring_method']) && $this->request->post['recurring_method'] == 'Installment')){
					if(empty($handling_data))
					{
					 $loworderfee_id = 107100;
					}	else {
					 $loworderfee_id = 107101;
					}
				 $orderitem=$dom->createElement('OrderItem','');
				 $orderitem=$orderitemlist->appendChild($orderitem);

				 $itemid=$dom->createElement('ItemID',$loworderfee_id);
				 $itemid=$orderitem->appendChild($itemid);
				 
				 $itemname=$dom->createElement('ItemName',substr($loworderfee_name, 0, 50));
				 $itemname=$orderitem->appendChild($itemname);
				
				 $quntity=$dom->createElement('Quantity',$loworderfee_quantity);
				 $quntity=$orderitem->appendChild($quntity);
				
				 $round_price = round($loworderfee_value*$exchange_rate, 2);
				 $unitprice=$dom->createElement('UnitPrice',$round_price*100);
				 $unitprice=$orderitem->appendChild($unitprice);
				  
				   //cnp
				  $unit_tax=$dom->createElement('UnitTax',round($tax_value_low,2)*100);
				  $unit_tax=$orderitem->appendChild($unit_tax);
				 				
				 
				 $sku_code=$dom->createElement('SKU',substr(htmlentities($loworderfee_sku, ENT_QUOTES, 'UTF-8'), 0, 100));
				 $sku_code=$orderitem->appendChild($sku_code);
  
  			}
			if($handling_data=='' || $loworderfee_data=='')
				 {
					$cnpid = 107101;
				 } else {			 
					$cnpid = 107102;
				 } 
			
           
            $total_unit_tax = 0;
            $coupon_count = count($coupon_info['product']);
			$i = 0;
			$cart_value_count = $this->cart->countProducts();
			if(isset($this->request->post['is_recurring']) && $this->request->post['is_recurring'] == 1 && isset($this->request->post['recurring_method']) && $this->request->post['recurring_method'] == 'Installment')
			{
			 foreach($product as $pro)
			 {
				 
				 $product_info = $this->model_catalog_product->getProduct(substr($pro['product_id'], 0, 25));
				 if (sizeof($pro['option']) != 0) {
				 	$item_full = ' -';
					for ($i =0; $i < sizeof($pro['option']);$i++) {					
						 $item_full .= $pro['option'][$i]['name'].'-'.$pro['option'][$i]['value'];
					}
				 }					
					
				 $orderitem=$dom->createElement('OrderItem','');
				 $orderitem=$orderitemlist->appendChild($orderitem);
				

				 $itemid=$dom->createElement('ItemID',$cnpid++);
				 $itemid=$orderitem->appendChild($itemid);
				 
				 $itemname=$dom->createElement('ItemName',substr($pro['name'].$item_full, 0, 50));
				 $itemname=$orderitem->appendChild($itemname);
				
				 $quntity=$dom->createElement('Quantity',$pro['quantity']);
				 $quntity=$orderitem->appendChild($quntity);
				 
				 $cnp_product_price = $this->floor_dec(($pro['price']*$exchange_rate)/$number_of_times,2,'.','');
				 $cnp_product_price_total = $cnp_product_price*$number_of_times;
				 
				 
				 $round_price = round(($pro['price']*$exchange_rate), 2);
				 $unitprice=$dom->createElement('UnitPrice',$cnp_product_price*100);
				 $unitprice=$orderitem->appendChild($unitprice);
				 
				 if(is_array($coupon_info['product']) && in_array($pro['product_id'], $coupon_info['product']))
				 {
					if($coupon_info['type'] == 'F') 
				        {
							$discount = $coupon_info['discount'] * ($pro['total'] / $sub_total);
							
						} else
						if ($coupon_info['type'] == 'P') 
						{
							$discount = $pro['total'] / 100 * $coupon_info['discount'];
						}
			
						 $unit_discountvalue = 0;
						 $main_unit_tax = 0;
						 $cnp_unit_taxes = 0;
						 $coupon_tax_value = 0;
						 $protax_coupon = 0;
						 $unit_discountvalue_ship = 0;
				 $tax_rates = $this->tax->getRates($pro['total'] - ($pro['total'] - $discount), $pro['tax_class_id']);	
				
					foreach($tax_rates as $tax_rate)
								{
								 if ($tax_rate['type'] == 'P') 
									{
										$total_data['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
										
										$unit_discountvalue += ($tax_rate['amount']/$pro['quantity']);
										//$coupon_tax += $tax_rate['amount'];
									}
					            }
					if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					 if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						 $tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
						 foreach ($tax_rates as $tax_rate) {
							 if ($tax_rate['type'] == 'P') {
								 $total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								 $unit_discountvalue_ship += $tax_rate['amount'];
							 }
						
						 }
						
					 }
				    }			
				  $protax =$this->tax->getTax($pro['price'], $pro['tax_class_id']);
                  $protax_unit = $protax*$pro['quantity'];
				  
				
				  $total_unit_tax +=$protax_unit;
				  
				  $discountvalue_ship = $unit_discountvalue_ship*$exchange_rate;
			      $discountvalue = $unit_discountvalue*$exchange_rate;
				  
				  if($coupon_info['product'][0] == $pro['product_id'])
				  {
				  $main_unit_tax = $protax*$exchange_rate - $discountvalue - $discountvalue_ship;
				  }
				  else
				  {
				  $main_unit_tax = $protax*$exchange_rate - $discountvalue_ship; 
				  }
				
				  $main_unit_tax = $this->floor_dec($main_unit_tax/$number_of_times,2,'.','');
				  
				  $main_unit_tax_total = ($main_unit_tax*$pro['quantity'])*$number_of_times;
				  $main_unit_tax_total_cnp += $main_unit_tax_total;
				   
				  if($coupon_info['shipping'] != 0)
				  {
					if($coupon_info['product'][0] == $pro['product_id'])
					  {
					  $dicount_cnp = $this->floor_dec((($discount*$exchange_rate + $shipp_value)/$pro['quantity'])/$number_of_times,2,'.','');	  
                      } else
                      {
					 $dicount_cnp = $this->floor_dec((($discount*$exchange_rate)/$pro['quantity'])/$number_of_times,2,'.','');
					  }						  
                  }
                  else
                  {
				  $dicount_cnp = $this->floor_dec((($discount*$exchange_rate)/$pro['quantity'])/$number_of_times,2,'.','');  
				  }	
			     
                  $dicount_cnp_total = ($dicount_cnp*$pro['quantity'])*$number_of_times;
				  $main_dicount_cnp_total += $dicount_cnp_total; 			
						  
						  $unit_tax=$dom->createElement('UnitTax',$main_unit_tax*100);
						  $unit_tax=$orderitem->appendChild($unit_tax);	
						  
						  $unit_disc=$dom->createElement('UnitDiscount',$dicount_cnp*100);
						  $unit_disc=$orderitem->appendChild($unit_disc);			
								
				 } else if(is_array($coupon_info['product']) && !in_array($pro['product_id'], $coupon_info['product']) && !empty($coupon_info['product']))
				 {
				  $main_unit_tax = 0;
					
				  $protax =$this->tax->getTax($pro['price'], $pro['tax_class_id']);
                  $protax_unit = $protax*$pro['quantity'];
				  
				  
				  $total_unit_tax +=$protax_unit;
				  $main_unit_tax = $protax*$exchange_rate;
				  
				  $main_unit_tax = $this->floor_dec($main_unit_tax/$number_of_times,2,'.','');
				  
				  $main_unit_tax_total = ($main_unit_tax*$pro['quantity'])*$number_of_times;
				  $main_unit_tax_total_cnp += $main_unit_tax_total;
				  		
						  
						  $unit_tax=$dom->createElement('UnitTax',$main_unit_tax*100);
						  $unit_tax=$orderitem->appendChild($unit_tax);	
						  
						  $unit_disc=$dom->createElement('UnitDiscount','000');
						  $unit_disc=$orderitem->appendChild($unit_disc);
					
				 } else if(empty($coupon_info['product']))
				 {		
					   	if($coupon_info['type'] == 'F') 
				        {
							$discount = $coupon_info['discount'] * ($pro['total'] / $sub_total);
							
						} else
						if($coupon_info['type'] == 'P') 
						{
							$discount = $pro['total'] / 100 * $coupon_info['discount'];
						}
			        
				 $unit_discountvalue = 0;
				 $main_unit_tax = 0;
				 $cnp_unit_taxes = 0;
				 $coupon_tax_value = 0;
				 $protax_coupon = 0;
				 $tax_rates = $this->tax->getRates($pro['total'] - ($pro['total'] - $discount), $pro['tax_class_id']);	
				
					foreach($tax_rates as $tax_rate)
								{
								 if ($tax_rate['type'] == 'P') 
									{
										$total_data['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
										
										$unit_discountvalue += ($tax_rate['amount']/$pro['quantity']);
										
									}
					            }
					
					if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					 if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						 $tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
						 foreach ($tax_rates as $tax_rate) {
							 if ($tax_rate['type'] == 'P') {
								 $total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								 $unit_discountvalue_ship += $tax_rate['amount'];
							 }
						
						 }
						
					 }
				    }
					
										
				  $protax =$this->tax->getTax($pro['price'], $pro['tax_class_id']);
                  $protax_unit = $protax*$pro['quantity'];
				  //
				  $discountvalue_voucher = $unit_discountvalue_ship/$cart_value_count;
				  $total_unit_tax +=$protax_unit;
				  if($coupon_info['shipping'] != 0)
				  {
					  $main_unit_tax = $protax*$exchange_rate - $unit_discountvalue*$exchange_rate - $discountvalue_voucher*$exchange_rate;
				  } else
				  {
					$main_unit_tax = $protax*$exchange_rate - $unit_discountvalue*$exchange_rate;  
				  }
				  
				  //
			  
				  //$main_unit_tax = $protax*$exchange_rate - $unit_discountvalue*$exchange_rate;
				  
				  $main_unit_tax = $this->floor_dec($main_unit_tax/$number_of_times,2,'.','');
				  
				  $main_unit_tax_total = ($main_unit_tax*$pro['quantity'])*$number_of_times;
				  $main_unit_tax_total_cnp += $main_unit_tax_total;
				 
                  $dicount_cnp = $this->floor_dec((($discount*$exchange_rate)/$pro['quantity'])/$number_of_times,2,'.','');	
                  $dicount_cnp_total = ($dicount_cnp*$pro['quantity'])*$number_of_times;
				  $main_dicount_cnp_total += $dicount_cnp_total; 
				  
						  $unit_tax=$dom->createElement('UnitTax',$main_unit_tax*100);
						  $unit_tax=$orderitem->appendChild($unit_tax);	
						  
						  $unit_disc=$dom->createElement('UnitDiscount','000');
						  $unit_disc=$orderitem->appendChild($unit_disc);
				
				 }
						 
				if($product_info['sku'] !=""){
				
				$sku_name=$product_info['sku'];
				$sku_code=$dom->createElement('SKU',substr(htmlentities($sku_name, ENT_QUOTES, 'UTF-8'), 0, 100));
				$sku_code=$orderitem->appendChild($sku_code);
				}
				 $tm_amt +=$pro['quantity']*($this->floor_dec(($cnp_product_price_total/$number_of_times),2,'.',''))*100; 
			 }
			 
			 $total_cou_rew =  ($main_dicount_cnp_total + $reward_value +$voucher_value)/$number_of_times;
			 if(empty($coupon_info['product']))
			 {
			 $total_cou_rew = $coupon_value + $reward_value +$voucher_value;
			 $totaldis_value = $coupon_value*$exchange_rate + $reward_value*$exchange_rate;
			 $totaldis_value = $this->floor_dec($totaldis_value/$number_of_times,2,'.','')*100;
			 } else 
			 {
			 $totaldis_value = $this->floor_dec(($main_dicount_cnp_total + $reward_value*$exchange_rate)/$number_of_times,2,'.','')*100;
			 }
			
			}else{
			
			 foreach($product as $pro)
			 {
				 $single_voucher = ($voucher_value/$cart_value_count);
				 
				 $single_voucher = $this->floor_dec($single_voucher,2,'.','');
				 $vouchertax =$this->tax->getTax($single_voucher, $pro['tax_class_id']);
				 
				 $vouchertax = $this->floor_dec(($vouchertax/$pro['quantity'])*$exchange_rate,2,'.','');
				 
				 
				 $product_info = $this->model_catalog_product->getProduct(substr($pro['product_id'], 0, 25));
				 $orderitem=$dom->createElement('OrderItem','');
				 $orderitem=$orderitemlist->appendChild($orderitem);
				 if (sizeof($pro['option']) != 0) {
				 	$item_full = ' -';
					for ($i =0; $i < sizeof($pro['option']);$i++) {					
						 $item_full .= $pro['option'][$i]['name'].'-'.$pro['option'][$i]['value'];
					}
				 }
			 	
				 $itemid=$dom->createElement('ItemID',$cnpid++);
				 $itemid=$orderitem->appendChild($itemid);
				 
				 $itemname=$dom->createElement('ItemName',substr($pro['name'].$item_full, 0, 50));
				 $itemname=$orderitem->appendChild($itemname);
				
				 $quntity=$dom->createElement('Quantity',$pro['quantity']);
				 $quntity=$orderitem->appendChild($quntity);
				 
				 $round_price = round($pro['price']*$exchange_rate, 2);
				 
				 $unitprice=$dom->createElement('UnitPrice',$round_price*100);
				 $unitprice=$orderitem->appendChild($unitprice);	
				 
				
				
				 if(is_array($coupon_info['product']) && in_array($pro['product_id'], $coupon_info['product']))
				 {
					if($coupon_info['type'] == 'F') 
				        {
							$discount = $coupon_info['discount'] * ($pro['total'] / $sub_total);
						} else
						if ($coupon_info['type'] == 'P') 
						{
							$discount = $pro['total'] / 100 * $coupon_info['discount'];
						}
					
					
						 $unit_discountvalue = 0;
						 $main_unit_tax = 0;
						 $cnp_unit_taxes = 0;
						 $coupon_tax_value = 0;
						 $protax_coupon = 0;
						 $unit_discountvalue_ship = 0;
				 $tax_rates = $this->tax->getRates($pro['total'] - ($pro['total'] - $discount), $pro['tax_class_id']);	
				 // print_r($exchange_rate);
					foreach($tax_rates as $tax_rate)
								{
								 if ($tax_rate['type'] == 'P') 
									{
										$total_data['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
										$unit_discountvalue += ($tax_rate['amount']/$pro['quantity']);
										$coupon_tax += $tax_rate['amount'];
									}
					            }
					
                    if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					 if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						 $tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
						 foreach ($tax_rates as $tax_rate) {
							 if ($tax_rate['type'] == 'P') {
								 $total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								 $unit_discountvalue_ship += $tax_rate['amount'];
							 }
						
						 }
						
					 }
				    }
			
				  $protax =$this->tax->getTax($pro['price'], $pro['tax_class_id']);
				  
				  
                  $protax_unit = $protax*$pro['quantity'];
				   
				  
				  $total_unit_tax +=$protax_unit;
				  
			      $discountvalue_ship = $unit_discountvalue_ship*$exchange_rate;
			      $discountvalue = $unit_discountvalue*$exchange_rate;
				  if($coupon_info['shipping'] != 0)
				  {
				  if($coupon_info['product'][0] == $pro['product_id'])
				  {
					//$main_unit_tax = $protax*$exchange_rate + $vouchertax - $discountvalue - $discountvalue_ship; 
					$main_unit_tax = $protax*$exchange_rate - $discountvalue - $discountvalue_ship; 
				  } else 
				  {
					$main_unit_tax = $protax*$exchange_rate - $discountvalue;  
				  }
				  } else
				  {
					$main_unit_tax = $protax*$exchange_rate - $discountvalue;   
				  }
				 
				  $main_unit_tax = $this->floor_dec($main_unit_tax,2,'.','');
				 
				  $main_unit_tax_total = $main_unit_tax*$pro['quantity'];
				  $main_unit_tax_total_cnp += $main_unit_tax_total;
				 
				 
				  if($coupon_info['shipping'] != 0)
				  {
					  if($coupon_info['product'][0] == $pro['product_id'])
					  {
						$dicount_cnp = $this->floor_dec(($discount/$pro['quantity'])*$exchange_rate + $shipp_value/$pro['quantity'] ,2,'.',''); 
						
					  }else
					  {
						$dicount_cnp = $this->floor_dec(($discount/$pro['quantity'])*$exchange_rate ,2,'.','');  
					  }
				  
				  } else
				  {
				  $dicount_cnp = $this->floor_dec(($discount/$pro['quantity'])*$exchange_rate,2,'.','');
				  }
                
                  
				  $main_dicount_cnp_total += $dicount_cnp*$pro['quantity']; 	
                  
						  $unit_tax=$dom->createElement('UnitTax',$main_unit_tax*100);
						  $unit_tax=$orderitem->appendChild($unit_tax);	
						  
						  $unit_disc=$dom->createElement('UnitDiscount',$this->floor_dec($dicount_cnp,2,'.','')*100);
						  $unit_disc=$orderitem->appendChild($unit_disc);				   
								
				 } else 
				if(is_array($coupon_info['product']) && !in_array($pro['product_id'], $coupon_info['product']) && !empty($coupon_info['product']))
				 {
					
				  $main_unit_tax = 0;
								 
				  $protax =$this->tax->getTax($pro['price'], $pro['tax_class_id']);
                  $protax_unit = $protax*$pro['quantity'];
				
				  $total_unit_tax +=$protax_unit;
				  $main_unit_tax = $protax*$exchange_rate;
				  
				  $main_unit_tax = $this->floor_dec($main_unit_tax,2,'.','');
				  
				  $main_unit_tax_total = $main_unit_tax*$pro['quantity'];
				  $main_unit_tax_total_cnp += $main_unit_tax_total;
				  	
                   
						  $unit_tax=$dom->createElement('UnitTax',$main_unit_tax*100);
						  $unit_tax=$orderitem->appendChild($unit_tax);	
									   
								
				 } else if(empty($coupon_info['product']))
				 {		
				   	if($coupon_info['type'] == 'F') 
				        {
							$discount = $coupon_info['discount'] * ($pro['total'] / $sub_total);
						} else
						if ($coupon_info['type'] == 'P') 
						{
							$discount = $pro['total'] / 100 * $coupon_info['discount'];
						}
			        
				 $unit_discountvalue = 0;
				 $main_unit_tax = 0;
				 $cnp_unit_taxes = 0;
				 $coupon_tax_value = 0;
				 $protax_coupon = 0;
				 $tax_rates = $this->tax->getRates($pro['total'] - ($pro['total'] - $discount), $pro['tax_class_id']);	
				
					foreach($tax_rates as $tax_rate)
								{
								 if ($tax_rate['type'] == 'P') 
									{
										$total_data['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
										$unit_discountvalue += ($tax_rate['amount']/$pro['quantity']);
										//$coupon_tax += $tax_rate['amount'];
									}
					            }
				   if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					 if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						 $tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
						 foreach ($tax_rates as $tax_rate) {
							 if ($tax_rate['type'] == 'P') {
								 $total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								 $unit_discountvalue_ship += $tax_rate['amount'];
							 }
						
						 }
						
					 }
				    }
				  $discountvalue_voucher = $unit_discountvalue_ship/$cart_value_count;
				  
				  $protax =$this->tax->getTax($pro['price'], $pro['tax_class_id']);
                  $protax_unit = $protax*$pro['quantity'];
				 
				  $total_unit_tax +=$protax_unit;
				  if($coupon_info['shipping'] != 0)
				  {
					  $main_unit_tax = $protax*$exchange_rate - $unit_discountvalue*$exchange_rate - $discountvalue_voucher*$exchange_rate;
				  } else
				  {
					$main_unit_tax = $protax*$exchange_rate - $unit_discountvalue*$exchange_rate;  
				  }
					  
				  
				  							  
				  $main_unit_tax = $this->floor_dec($main_unit_tax,2,'.','');
				 
				  
				  $main_unit_tax_total = $main_unit_tax*$pro['quantity'];
				  $main_unit_tax_total_cnp += $main_unit_tax_total;
				  
				  $dicount_cnp = $this->floor_dec($discount*$exchange_rate,2,'.','');	
				  
				  $main_dicount_cnp_total += $dicount_cnp; 	
				   
						  $unit_tax=$dom->createElement('UnitTax',$main_unit_tax*100);
						  $unit_tax=$orderitem->appendChild($unit_tax);	
						  
						  $unit_disc=$dom->createElement('UnitDiscount','000');
						  $unit_disc=$orderitem->appendChild($unit_disc);
				 } else 
					 
					 {
						 	if($coupon_info['type'] == 'F') 
				        {
							$discount = $coupon_info['discount'] * ($pro['total'] / $sub_total);
						} else
						if ($coupon_info['type'] == 'P') 
						{
							$discount = $pro['total'] / 100 * $coupon_info['discount'];
						}
			        
				 $unit_discountvalue = 0;
				 $main_unit_tax = 0;
				 $cnp_unit_taxes = 0;
				 $coupon_tax_value = 0;
				 $protax_coupon = 0;
				 $tax_rates = $this->tax->getRates($pro['total'] - ($pro['total'] - $discount), $pro['tax_class_id']);	
				
					foreach($tax_rates as $tax_rate)
								{
								 if ($tax_rate['type'] == 'P') 
									{
										$total_data['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
										$unit_discountvalue += ($tax_rate['amount']/$pro['quantity']);
										//$coupon_tax += $tax_rate['amount'];
									}
					            }
				   if ($coupon_info['shipping'] && isset($this->session->data['shipping_method'])) {
					 if (!empty($this->session->data['shipping_method']['tax_class_id'])) {
						 $tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
						 foreach ($tax_rates as $tax_rate) {
							 if ($tax_rate['type'] == 'P') {
								 $total['taxes'][$tax_rate['tax_rate_id']] -= $tax_rate['amount'];
								 $unit_discountvalue_ship += $tax_rate['amount'];
							 }
						
						 }
						
					 }
				    }
				  
				  $protax =$this->tax->getTax($pro['price'], $pro['tax_class_id']);
                  $protax_unit = $protax*$pro['quantity'];
				 
				  $total_unit_tax +=$protax_unit;
				  $main_unit_tax = $protax*$exchange_rate - $unit_discountvalue*$exchange_rate;
				  							  
				  $main_unit_tax = $this->floor_dec($main_unit_tax,2,'.','');
				 
				  
				  $main_unit_tax_total = $main_unit_tax*$pro['quantity'];
				  $main_unit_tax_total_cnp += $main_unit_tax_total;
				  
				  $dicount_cnp = $this->floor_dec($discount*$exchange_rate,2,'.','');	
				  
				  $main_dicount_cnp_total += $dicount_cnp; 	
				   
						  $unit_tax=$dom->createElement('UnitTax',$main_unit_tax*100);
						  $unit_tax=$orderitem->appendChild($unit_tax);	
						  
						  $unit_disc=$dom->createElement('UnitDiscount','000');
						  $unit_disc=$orderitem->appendChild($unit_disc);
					 }
			
                 					  
				  
				   if($product_info['sku'] != ""){
					    $sku_name=$product_info['sku'];
						$sku_code=$dom->createElement('SKU',substr(htmlentities($sku_name, ENT_QUOTES, 'UTF-8'), 0, 100));
						$sku_code=$orderitem->appendChild($sku_code);					
					}
				 
					$tm_amt +=$pro['quantity']*$round_price*100;
			 }
			
			 if(empty($coupon_info['product']))
			 {
			 $total_cou_rew = $coupon_value + $reward_value +$voucher_value;
			 
			 $totaldis_value = $coupon_value*$exchange_rate + $reward_value*$exchange_rate;
			 $totaldis_value = $this->floor_dec($totaldis_value ,2,'.','');
			 } else 
			 {
			 $total_cou_rew = $coupon_value + $reward_value +$voucher_value;
			 $totaldis_value = $main_dicount_cnp_total + $reward_value*$exchange_rate;
			 $totaldis_value = $this->floor_dec($totaldis_value,2,'.','');
			
			 }
			 }
		
		     if(isset($shipping_method) && !empty($shipping_method)) {
			 $shipping=$dom->createElement('Shipping','');
		     $shipping=$order->appendChild($shipping);
				
			 $shipping_method=$dom->createElement('ShippingMethod',$shipp_name);
			 $shipping_method=$shipping->appendChild($shipping_method);
				if(isset($this->request->post['recurring_method']) && $this->request->post['recurring_method'] == 'Installment')
				{
				
				 $cnp_shipping = $this->floor_dec($shipp_value/$number_of_times,2,'.','');
				 $cnp_shipping_total = $cnp_shipping*$number_of_times;
			
				 $round_shipping_price = round(($shipp_value*$exchange_rate), 2);
				 $shipping_value=$dom->createElement('ShippingValue',$cnp_shipping*100);
				 $shipping_value=$shipping->appendChild($shipping_value);
				 
				 $cnp_shipping_tax = $this->floor_dec(($tax_value_ship/$number_of_times),2,'.','');
				 $cnp_shipping_tax_total = $cnp_shipping_tax*$number_of_times;
				 
				  // Shipping Tax Based on Coupon Shipping
				  if($coupon_info['shipping'] != 0)
				  {
					  if($this->cart->hasShipping() == 1)
					   {
						 
						 $shipping_tax=$dom->createElement('ShippingTax',$this->floor_dec($cnp_shipping_tax,2,'.','')*100);
						 $shipping_tax=$shipping->appendChild($shipping_tax);  
					   } else
					   {
						 $shipping_tax=$dom->createElement('ShippingTax','000');
						 $shipping_tax=$shipping->appendChild($shipping_tax);  
					   }
				  
				  } else
				  {
					  
				  $shipping_tax=$dom->createElement('ShippingTax',$cnp_shipping_tax*100);
				  $shipping_tax=$shipping->appendChild($shipping_tax);  
				  }
				  
				}else{
				 
				  $round_shipping_price = round($shipp_value, 2);
				  $shipping_value=$dom->createElement('ShippingValue',$round_shipping_price*100);
				  $shipping_value=$shipping->appendChild($shipping_value);
				  
				  // Shipping Tax Based on Coupon Shipping
				  if($coupon_info['shipping'] != 0)
				  {
                       if($this->cart->hasShipping() == 1)
					   {
						 
						 $shipping_tax=$dom->createElement('ShippingTax',$this->floor_dec($tax_value_ship,2,'.','')*100);
						 $shipping_tax=$shipping->appendChild($shipping_tax);  
					   } else
					   {
						$shipping_tax=$dom->createElement('ShippingTax','000');
						$shipping_tax=$shipping->appendChild($shipping_tax);    
					   }						   
					  
				  } 
				  else 
				  {
					
				  $shipping_tax=$dom->createElement('ShippingTax',$this->floor_dec($tax_value_ship,2,'.','')*100);
				  $shipping_tax=$shipping->appendChild($shipping_tax);
				  }
				 }
			 }
			 $receipt=$dom->createElement('Receipt','');
			 $receipt=$order->appendChild($receipt);
				 if($this->config->get('cnp_send_receipt') == 'yes') 
				 {
				 $email_sendreceipt =$dom->createElement('SendReceipt',"true");
				 $email_sendreceipt=$receipt->appendChild($email_sendreceipt);
								
				 }
				 else
				 {
				 $email_sendreceipt=$dom->createElement('SendReceipt',"false");
				 $email_sendreceipt=$receipt->appendChild($email_sendreceipt);	
				 }
			
			 $recipt_lang=$dom->createElement('Language','ENG');
			 $recipt_lang=$receipt->appendChild($recipt_lang);
			
			if(trim($this->config->get('cnp_org_info')) != '')
			 {
			 $recipt_org=$dom->createElement('OrganizationInformation',substr(str_replace('&', '&amp;',addslashes(html_entity_decode($this->config->get('cnp_org_info')))),0,1500));
			 $recipt_org=$receipt->appendChild($recipt_org);
			 }
			
			if(trim($this->config->get('cnp_terms_conditions')) != '')
			 {
			 $recipt_terms=$dom->createElement('TermsCondition',substr(str_replace('&','&amp;',addslashes(html_entity_decode($this->config->get('cnp_terms_conditions')))),0,1500));
			 $recipt_terms=$receipt->appendChild($recipt_terms);
			}
			
			 $recipt_email=$dom->createElement('EmailNotificationList','');
			 $recipt_email=$receipt->appendChild($recipt_email);
			 $email_note=$dom->createElement('NotificationEmail','');
			 $email_note=$recipt_email->appendChild($email_note);
			 
			 $transation=$dom->createElement('Transaction','');
	         $transation=$order->appendChild($transation);

	         $trans_type=$dom->createElement('TransactionType','Payment');
	         $trans_type=$transation->appendChild($trans_type);
	        
			 $trans_desc=$dom->createElement('DynamicDescriptor','DynamicDescriptor');
			 $trans_desc=$transation->appendChild($trans_desc); 
			 
			 if(isset($this->request->post['is_recurring']) && $this->request->post['is_recurring'] == 1){
		
			 $trans_recurr=$dom->createElement('Recurring','');
			 $trans_recurr=$transation->appendChild($trans_recurr);
			 
			 $total_installment=$dom->createElement('Installment',$number_of_times);
			 $total_installment=$trans_recurr->appendChild($total_installment);
			 
			 $total_periodicity=$dom->createElement('Periodicity',$this->request->post['Periodicity']);
			 $total_periodicity=$trans_recurr->appendChild($total_periodicity);
			 
			 $total_installment=$dom->createElement('RecurringMethod',$this->request->post['recurring_method']);
			 $total_installment=$trans_recurr->appendChild($total_installment);
			 
			 }
			if(isset($this->request->post['is_recurring']) && $this->request->post['is_recurring'] == 1 && isset($this->request->post['recurring_method']) && $this->request->post['recurring_method'] == 'Installment')
				{
				
				// Tax Based on Coupon and Shipping
			    if($coupon_info['shipping'] != 0)
			    {
					if($this->cart->hasShipping() == 1)
					   {
						$tax_value = $main_unit_tax_total_cnp + $cnp_handling_tax_total + $cnp_low_tax_total + $cnp_shipping_tax_total;
					   }
					   else
					   {
						 $tax_value = $main_unit_tax_total_cnp + $cnp_handling_tax_total + $cnp_low_tax_total;  
					   }
				 
				} else
				{
				$tax_value = $main_unit_tax_total_cnp + $cnp_handling_tax_total + $cnp_low_tax_total + $cnp_shipping_tax_total;	
				}
				
				 $tax_value = round($tax_value,2);
				 $cart_tax = $this->floor_dec($main_tax_oc,2,'.','') - $tax_value;
				 
				 $cart_tax = $this->floor_dec(($cart_tax/$number_of_times)/$pro['quantity'],2,'.','')*100;
				
				 if($handling_value != 0) 
				 $handling_recurring = $this->floor_dec(($cnp_handling_total/$number_of_times),2,'.','')*100;
				 else $handling_recurring = 0;
				  if($loworderfee_value != 0)
					 $loworderfee_value   = $this->floor_dec(($cnp_low_order_total/$number_of_times),2,'.','')*100;
				 else $loworderfee_value = 0;
				 if($shipp_value !=0)
					 $shipp_value = $this->floor_dec(($cnp_shipping_total/$number_of_times),2,'.','')*100;
				 else $shipp_value =0;
				 if($tax_value != 0) 
					 $tax_value =  $this->floor_dec(($tax_value/$number_of_times),2,'.','')*100;
				 else $tax_value =0;
				
				 if($voucher_value != 0) $voucher_value = $this->floor_dec((($voucher_value*$exchange_rate)/$number_of_times),2,'.','')*100;
				 else $voucher_value =0;
				
				 
if(isset($coupon_info) && !empty($coupon_info) && $coupon_info['shipping'] != 0) 
{
$recurring_total = ($handling_recurring + $loworderfee_value + $tm_amt + $shipp_value + $tax_value) - ($totaldis_value + $voucher_value);	
}	else 
{
$recurring_total = ($handling_recurring + $loworderfee_value + $tm_amt + $shipp_value + $tax_value) - ($totaldis_value + $voucher_value);	
}
				
				 $trans_totals=$dom->createElement('CurrentTotals','');
				 $trans_totals=$transation->appendChild($trans_totals);
				
				 $total_discount=$dom->createElement('TotalDiscount',$totaldis_value);
				 $total_discount=$trans_totals->appendChild($total_discount);
				
				 
				 if ($tax_value > 0) {
				 $total_tax=$dom->createElement('TotalTax',$tax_value);
				 $total_tax=$trans_totals->appendChild($total_tax);
				  }
				  
				 $total_ship=$dom->createElement('TotalShipping',$shipp_value);
				 $total_ship=$trans_totals->appendChild($total_ship);
				 
								
				 $total_amount=$dom->createElement('Total',$recurring_total);
				 $total_amount=$trans_totals->appendChild($total_amount);
				 
				 $trans_coupon=$dom->createElement('CouponCode',$coupon_code);
				 $trans_coupon=$transation->appendChild($trans_coupon);
				 
				   if(empty($coupon_info['product']))
				   {
					 
					   $trans_coupon_discount=$dom->createElement('TransactionDiscount',$totaldis_value);
					   $trans_coupon_discount=$transation->appendChild($trans_coupon_discount);
				   }
				 
				 				 
				 $giftcardlist=$dom->createElement('GiftCardList','');
				 $giftcardlist=$transation->appendChild($giftcardlist);
				 
				 $giftcard=$dom->createElement('GiftCard','');
				 $giftcard=$giftcardlist->appendChild($giftcard);
				 
				 $giftcardcode=$dom->createElement('GiftCardCode',$voucher_code);
				 $giftcardcode=$giftcard->appendChild($giftcardcode);
				 
				 $giftcardamount=$dom->createElement('GiftCardAmount',$voucher_value);
				 $giftcardamount=$giftcard->appendChild($giftcardamount); 
				 
				 }
			     else{
				  // Tax Based on Coupon and Shipping				
			      if($coupon_info['shipping'] != 0)
				  {
					  
					  if($this->cart->hasShipping() == 1)
					   {
						  
						  $tax_value = $main_unit_tax_total_cnp + $tax_value_handling + $tax_value_low + $tax_value_ship; 
					   }
					   else
					   {
						 $tax_value = $main_unit_tax_total_cnp + $tax_value_handling + $tax_value_low;   
					   }
				   
				  }	else
				  {
					
				  $tax_value = $main_unit_tax_total_cnp + $tax_value_handling + $tax_value_low + $tax_value_ship;
				  }					  
			     $voucher_value = $this->floor_dec($voucher_value*$exchange_rate,2,'.','');
				 
				 $tax_value = $this->floor_dec($tax_value,2,'.','');
			
				 $grand_total = ($loworderfee_value*100 + $handling_value*100 + $tm_amt + ($round_shipping_price*100) + ($tax_value*100)) - ($totaldis_value*100 + $voucher_value*100);
				 
				 $grand_total = round($grand_total,2);
				
				 $trans_totals=$dom->createElement('CurrentTotals','');
				 $trans_totals=$transation->appendChild($trans_totals);
				 
			     $total_discount=$dom->createElement('TotalDiscount',$totaldis_value*100);
				 $total_discount=$trans_totals->appendChild($total_discount);
				
				 if ($tax_value > 0) {
				 $total_tax=$dom->createElement('TotalTax',$tax_value*100);
				 $total_tax=$trans_totals->appendChild($total_tax);
				 }
				
				 $total_ship=$dom->createElement('TotalShipping',$round_shipping_price*100);
				 $total_ship=$trans_totals->appendChild($total_ship);
					
				 $total_amount=$dom->createElement('Total',$grand_total);
				 $total_amount=$trans_totals->appendChild($total_amount);
				 
				 $trans_coupon=$dom->createElement('CouponCode',$coupon_code);
				 $trans_coupon=$transation->appendChild($trans_coupon);
				 
				   if(empty($coupon_info['product']))
				   {
					   $trans_coupon_discount=$dom->createElement('TransactionDiscount',$totaldis_value*100);
					   $trans_coupon_discount=$transation->appendChild($trans_coupon_discount);
				   } 
				  
			
				 				 
				 $giftcardlist=$dom->createElement('GiftCardList','');
				 $giftcardlist=$transation->appendChild($giftcardlist);
				 
				 $giftcard=$dom->createElement('GiftCard','');
				 $giftcard=$giftcardlist->appendChild($giftcard);
				 
				 $giftcardcode=$dom->createElement('GiftCardCode',$voucher_code);
				 $giftcardcode=$giftcard->appendChild($giftcardcode);
				 
				 $giftcardamount=$dom->createElement('GiftCardAmount',$voucher_value*100);
				 $giftcardamount=$giftcard->appendChild($giftcardamount); 

				 }
			 $response=array();
	         $strParam =$dom->saveXML();
			 //print_r($strParam);exit;
	         $connect = array('soap_version' => SOAP_1_1, 'trace' => 1, 'exceptions' => 0);
			 $client = new SoapClient('https://paas.cloud.clickandpledge.com/paymentservice.svc?wsdl', $connect);
			 $params = array('instruction'=>$strParam);
			 
			 $response = $client->Operation($params);
		     
			 $response_value=$response->OperationResult->ResultData;
	         $result_array=$response->OperationResult->ResultCode;
	         $transation_number=$response->OperationResult->TransactionNumber;
	         $xml_error=explode(":",$response->OperationResult->AdditionalInfo);			 
	         $json = array();
				 if(isset($xml_error['2']))
				 {
						$payment_error=$xml_error['2'];
				 }else{
						$payment_error="";
				 }			 
			 if($payment_error == '')
	         {    
		       
			$response_value = $response->OperationResult->ResultData;
					  
			 $data['title']    = sprintf($this->language->get('heading_title'), $this->config->get('config_name'));
			 if (!isset($this->request->server['HTTPS']) || ($this->request->server['HTTPS'] != 'on')) {
				$data['base'] = HTTP_SERVER;
			 } else {
				$data['base'] = HTTPS_SERVER;
			 }
			if($result_array == '0')
			 {            
		
				$report = "Transaction Id:".$transation_number;
				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 15, $report);
				$message = $response_value;
				$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], 15, $message, FALSE);
				$data['text_payment_wait'] = sprintf($this->language->get('text_payment_wait'));
				$data['continue'] = $this->url->link('checkout/success');
				//$json['redirect'] = $this->url->link('checkout/success');
			 
			 }else{
					 $json['error'] = $response_value;
					 }
				 }else{
					   $json['error'] = $payment_error;
				}	
				}
			}
		}
?>