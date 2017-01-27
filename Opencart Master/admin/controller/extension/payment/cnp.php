<?php
class ControllerExtensionPaymentCnP extends Controller{

     private $error = array(); 

     public function index() {
		
		$this->load->language('extension/payment/cnp');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->model_setting_setting->editSetting('cnp', $this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
        
		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_all_zones'] = $this->language->get('text_all_zones');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_live'] = $this->language->get('text_live');
		$data['text_test'] = $this->language->get('text_test');
		
		$data['entry_login'] = $this->language->get('entry_login');
		$data['entry_key'] = $this->language->get('entry_key');
		$data['entry_mode'] = $this->language->get('entry_mode');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_method'] = $this->language->get('entry_method');
		$data['entry_total'] = $this->language->get('entry_total');
		$data['entry_total_help'] = $this->language->get('entry_total_help');
		
		//Other settings
		//$data['organization_information'] = $this->language->get('organization_information');
		$data['terms_conditions'] = $this->language->get('terms_conditions');
		$data['receipt_setting'] = $this->language->get('receipt_setting');
		$data['payment_methods'] = $this->language->get('payment_methods');
		$data['payment_method_default'] = $this->language->get('payment_method_default');
		
		//recurring contribuction
		$data['cnp_recurring_contribution'] = $this->language->get('cnp_recurring_contribution');

		$data['cnp_week'] = $this->language->get('cnp_week');
		$data['cnp_2_weeks'] = $this->language->get('cnp_2_weeks');
		$data['cnp_month'] = $this->language->get('cnp_month');
		$data['cnp_2_months'] = $this->language->get('cnp_2_months');
		$data['cnp_quarter'] = $this->language->get('cnp_quarter');
		$data['cnp_6_months'] = $this->language->get('cnp_6_months');
		$data['cnp_year'] = $this->language->get('cnp_year');
		
		$data['cnp_installment'] = $this->language->get('cnp_installment');
		$data['cnp_subscription'] = $this->language->get('cnp_subscription');
		$data['cnp_indefinite'] = $this->language->get('cnp_indefinite');
		
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		
		$data['tab_general'] = $this->language->get('tab_general');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['login'])) {
			$data['error_login'] = $this->error['login'];
		} else {
			$data['error_login'] = '';
		}
		
		if (isset($this->error['key'])) {
			$data['error_key'] = $this->error['key'];
		} else {
			$data['error_key'] = '';
		}
		
		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL')      		
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL')      		
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/payment/cnp', 'token=' . $this->session->data['token'], 'SSL')      		
   		);
		
		$data['action'] = $this->url->link('extension/payment/cnp', 'token=' . $this->session->data['token'], 'SSL');		
		$data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		
		//USD
		if (isset($this->request->post['cnp_login'])) {
			$data['cnp_login'] = $this->request->post['cnp_login'];
		} else {
			$data['cnp_login'] = $this->config->get('cnp_login');
		}
		if (isset($this->request->post['cnp_key'])) {
			$data['cnp_key'] = $this->request->post['cnp_key'];
		} else {
			$data['cnp_key'] = $this->config->get('cnp_key');
		}
		if (isset($this->request->post['cnp_server'])) {
			$data['cnp_server'] = $this->request->post['cnp_server'];
		} else {
			$data['cnp_server'] = $this->config->get('cnp_server');
		}
		if (isset($this->request->post['cnp_usd_status'])) {
			$data['cnp_usd_status'] = $this->request->post['cnp_usd_status'];
		} else {
			$data['cnp_usd_status'] = $this->config->get('cnp_usd_status');
		}
		//EURO
		if (isset($this->request->post['cnp_login_euro'])) {
			$data['cnp_login_euro'] = $this->request->post['cnp_login_euro'];
		} else {
			$data['cnp_login_euro'] = $this->config->get('cnp_login_euro');
		}
		if (isset($this->request->post['cnp_key_euro'])) {
			$data['cnp_key_euro'] = $this->request->post['cnp_key_euro'];
		} else {
			$data['cnp_key_euro'] = $this->config->get('cnp_key_euro');
		}
		if (isset($this->request->post['cnp_server_euro'])) {
			$data['cnp_server_euro'] = $this->request->post['cnp_server_euro'];
		} else {
			$data['cnp_server_euro'] = $this->config->get('cnp_server_euro');
		}
		if (isset($this->request->post['cnp_status_euro'])) {
			$data['cnp_status_euro'] = $this->request->post['cnp_status_euro'];
		} else {
			$data['cnp_status_euro'] = $this->config->get('cnp_status_euro');
		}
		
		//POUND		
		if (isset($this->request->post['cnp_login_pound'])) {
			$data['cnp_login_pound'] = $this->request->post['cnp_login_pound'];
		} else {
			$data['cnp_login_pound'] = $this->config->get('cnp_login_pound');
		}
		if (isset($this->request->post['cnp_key_pound'])) {
			$data['cnp_key_pound'] = $this->request->post['cnp_key_pound'];
		} else {
			$data['cnp_key_pound'] = $this->config->get('cnp_key_pound');
		}
		if (isset($this->request->post['cnp_server_pound'])) {
			$data['cnp_server_pound'] = $this->request->post['cnp_server_pound'];
		} else {
			$data['cnp_server_pound'] = $this->config->get('cnp_server_pound');
		}
		if (isset($this->request->post['cnp_status_pound'])) {
			$data['cnp_status_pound'] = $this->request->post['cnp_status_pound'];
		} else {
			$data['cnp_status_pound'] = $this->config->get('cnp_status_pound');
		}
		//CAD
		if (isset($this->request->post['cnp_cad_login'])) {
			$data['cnp_cad_login'] = $this->request->post['cnp_cad_login'];
		} else {
			$data['cnp_cad_login'] = $this->config->get('cnp_cad_login');
		}
		if (isset($this->request->post['cnp_cad_key'])) {
			$data['cnp_cad_key'] = $this->request->post['cnp_cad_key'];
		} else {
			$data['cnp_cad_key'] = $this->config->get('cnp_cad_key');
		}
		if (isset($this->request->post['cnp_cad_server'])) {
			$data['cnp_cad_server'] = $this->request->post['cnp_cad_server'];
		} else {
			$data['cnp_cad_server'] = $this->config->get('cnp_cad_server');
		}
		if (isset($this->request->post['cnp_cad_status'])) {
			$data['cnp_cad_status'] = $this->request->post['cnp_cad_status'];
		} else {
			$data['cnp_cad_status'] = $this->config->get('cnp_cad_status');
		}
		//HKD
		if (isset($this->request->post['cnp_hkd_login'])) {
			$data['cnp_hkd_login'] = $this->request->post['cnp_hkd_login'];
		} else {
			$data['cnp_hkd_login'] = $this->config->get('cnp_hkd_login');
		}
		if (isset($this->request->post['cnp_hkd_key'])) {
			$data['cnp_hkd_key'] = $this->request->post['cnp_hkd_key'];
		} else {
			$data['cnp_hkd_key'] = $this->config->get('cnp_hkd_key');
		}
		if (isset($this->request->post['cnp_hkd_server'])) {
			$data['cnp_hkd_server'] = $this->request->post['cnp_hkd_server'];
		} else {
			$data['cnp_hkd_server'] = $this->config->get('cnp_hkd_server');
		}
		if (isset($this->request->post['cnp_hkd_status'])) {
			$data['cnp_hkd_status'] = $this->request->post['cnp_hkd_status'];
		} else {
			$data['cnp_hkd_status'] = $this->config->get('cnp_hkd_status');
		}
		
		if (isset($this->request->post['cnp_status'])) {
			$data['cnp_status'] = $this->request->post['cnp_status'];
		} else {
			$data['cnp_status'] = $this->config->get('cnp_status');
		}
		//Other setting

		if (isset($this->request->post['cnp_sort_order'])) {
			$data['cnp_sort_order'] = $this->request->post['cnp_sort_order'];
		} else {
			$data['cnp_sort_order'] = $this->config->get('cnp_sort_order');
		}
		if (isset($this->request->post['cnp_checkout_total'])) {
			$data['cnp_checkout_total'] = $this->request->post['cnp_checkout_total'];
		} else {
			$data['cnp_checkout_total'] = $this->config->get('cnp_checkout_total');
		}
		
		// if (isset($this->request->post['cnp_org_info'])) {
			// $data['cnp_org_info'] = $this->request->post['cnp_org_info'];
		// } else {
			// $data['cnp_org_info'] = $this->config->get('cnp_org_info');
		// }
		
		/*if (isset($this->request->post['cnp_thank_you'])) {
			$data['cnp_thank_you'] = $this->request->post['cnp_thank_you'];
		} else {
			$data['cnp_thank_you'] = $this->config->get('cnp_thank_you');
		}*/
		
		if (isset($this->request->post['cnp_terms_conditions'])) {
			$data['cnp_terms_conditions'] = $this->request->post['cnp_terms_conditions'];
		} else {
			$data['cnp_terms_conditions'] = $this->config->get('cnp_terms_conditions');
		}
		
		if (isset($this->request->post['cnp_send_receipt'])) {
			$data['cnp_send_receipt'] = $this->request->post['cnp_send_receipt'];
		} else {
			$data['cnp_send_receipt'] = $this->config->get('cnp_send_receipt');
		}
		
		//install
		if (isset($this->request->post['cnp_install'])) {
			$data['cnp_install'] = $this->request->post['cnp_install'];
		} else {
			$data['cnp_install'] = $this->config->get('cnp_install');
		}
		
		if (isset($this->request->post['cnp_creditcard'])) {
			$data['cnp_creditcard'] = $this->request->post['cnp_creditcard'];
		} else {
			$data['cnp_creditcard'] = $this->config->get('cnp_creditcard');
		}
		
		if (isset($this->request->post['cnp_check'])) {
			$data['cnp_check'] = $this->request->post['cnp_check'];
		} else {
			$data['cnp_check'] = $this->config->get('cnp_check');
		}

		// if (isset($this->request->post['cnp_invoice'])) {
			// $data['cnp_invoice'] = $this->request->post['cnp_invoice'];
		// } else {
			// $data['cnp_invoice'] = $this->config->get('cnp_invoice');
		// }

		if (isset($this->request->post['cnp_purchas_order'])) {
			$data['cnp_purchas_order'] = $this->request->post['cnp_purchas_order'];
		} else {
			$data['cnp_purchas_order'] = $this->config->get('cnp_purchas_order');
		}
		
		if (isset($this->request->post['cnp_payment_method'])) {
			$data['cnp_payment_method'] = $this->request->post['cnp_payment_method'];
		} else {
			$data['cnp_payment_method'] = $this->config->get('cnp_payment_method');
		}
		
		if (isset($this->request->post['cnp_recurring_contribution'])) {
			$data['cnp_recurring_contribution'] = $this->request->post['cnp_recurring_contribution'];
		} else {
			$data['cnp_recurring_contribution'] = $this->config->get('cnp_recurring_contribution');
		}

		if (isset($this->request->post['cnp_week'])) {
			$data['cnp_week'] = $this->request->post['cnp_week'];
		} else {
			$data['cnp_week'] = $this->config->get('cnp_week');
		}
		
		if (isset($this->request->post['cnp_2_weeks'])) {
			$data['cnp_2_weeks'] = $this->request->post['cnp_2_weeks'];
		} else {
			$data['cnp_2_weeks'] = $this->config->get('cnp_2_weeks');
		}
	
		if (isset($this->request->post['cnp_month'])) {
			$data['cnp_month'] = $this->request->post['cnp_month'];
		} else {
			$data['cnp_month'] = $this->config->get('cnp_month');
		}

		if (isset($this->request->post['cnp_2_months'])) {
			$data['cnp_2_months'] = $this->request->post['cnp_2_months'];
		} else {
			$data['cnp_2_months'] = $this->config->get('cnp_2_months');
		}
		
		if (isset($this->request->post['cnp_quarter'])) {
			$data['cnp_quarter'] = $this->request->post['cnp_quarter'];
		} else {
			$data['cnp_quarter'] = $this->config->get('cnp_quarter');
		}
		
		if (isset($this->request->post['cnp_6_months'])) {
			$data['cnp_6_months'] = $this->request->post['cnp_6_months'];
		} else {
			$data['cnp_6_months'] = $this->config->get('cnp_6_months');
		}

		if (isset($this->request->post['cnp_year'])) {
			$data['cnp_year'] = $this->request->post['cnp_year'];
		} else {
			$data['cnp_year'] = $this->config->get('cnp_year');
		}
		
		if (isset($this->request->post['cnp_installment'])) {
			$data['cnp_installment'] = $this->request->post['cnp_installment'];
		} else {
			$data['cnp_installment'] = $this->config->get('cnp_installment');
		}
		
		if (isset($this->request->post['cnp_subscription'])) {
			$data['cnp_subscription'] = $this->request->post['cnp_subscription'];
		} else {
			$data['cnp_subscription'] = $this->config->get('cnp_subscription');
		}
		
		if (isset($this->request->post['cnp_indefinite'])) {
			$data['cnp_indefinite'] = $this->request->post['cnp_indefinite'];
		} else {
			$data['cnp_indefinite'] = $this->config->get('cnp_indefinite');
		}
		
		
		/*$this->template = 'payment/cnp.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		$this->response->setOutput($this->render());*/
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/payment/cnp.tpl', $data));
		
    }
	 protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/payment/cnp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['cnp_login'] && !$this->request->post['cnp_login_euro'] && !$this->request->post['cnp_login_pound'] && !$this->request->post['cnp_cad_login'] && !$this->request->post['cnp_hkd_login']) {
			$this->error['login'] = $this->language->get('error_login');
		}

		if (!$this->request->post['cnp_key'] && !$this->request->post['cnp_key_euro'] && !$this->request->post['cnp_key_pound'] && !$this->request->post['cnp_cad_key'] && !$this->request->post['cnp_hkd_key']) {
			$this->error['key'] = $this->language->get('error_key');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
}