<?php 
class ModelExtensionPaymentCnP extends Model {
  	public function getMethod($address, $total) {
		$this->load->language('extension/payment/cnp');
		$currency = $this->session->data['currency'];
		$taxes = $this->cart->getTaxes();
	
		if ($this->config->get('cnp_usd_status')==1 && $this->session->data['currency'] == 'USD') {
		   
      		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		if ($this->config->get('cnp_checkout_total') > 0 && $this->config->get('cnp_checkout_total') > $total_disp_value) {
		 $status = FALSE;
			}elseif (!$this->config->get('cod_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
      	} elseif($this->config->get('cnp_status_euro')==1 && $this->session->data['currency'] == 'EUR') {
        		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		if ($this->config->get('cnp_checkout_total') > 0 && $this->config->get('cnp_checkout_total') > $total_disp_value) {
		 $status = FALSE;
		 } elseif (!$this->config->get('cod_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
      		
		} elseif($this->config->get('cnp_status_pound')==1 && $this->session->data['currency'] == 'GBP'){
		     
		 $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
		if ($this->config->get('cnp_checkout_total') > 0 && $this->config->get('cnp_checkout_total') > $total_disp_value) {
			 $status = FALSE;
		 }elseif (!$this->config->get('cod_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
		} elseif($this->config->get('cnp_cad_status')==1 && $this->session->data['currency'] == 'CAD'){
		     
		 $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
		if ($this->config->get('cnp_checkout_total') > 0 && $this->config->get('cnp_checkout_total') > $total_disp_value) {
			 $status = FALSE;
		 }elseif (!$this->config->get('cod_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
		} elseif($this->config->get('cnp_hkd_status')==1 && $this->session->data['currency'] == 'HKD'){
		     
		 $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get('cod_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");
		
		if ($this->config->get('cnp_checkout_total') > 0 && $this->config->get('cnp_checkout_total') > $total_disp_value) {
			 $status = FALSE;
		 }elseif (!$this->config->get('cod_geo_zone_id')) {
        		$status = TRUE;
      		} elseif ($query->num_rows) {
      		  	$status = TRUE;
      		} else {
     	  		$status = FALSE;
			}	
		} else {
			$status = FALSE;
		}
		
		$method_data = array();

		if ($status) {  
      		$method_data = array( 
        		'code'         => 'cnp',
        		'title'      => $this->language->get('text_title'),
				'terms'      => '',
				'sort_order' => $this->config->get('cnp_sort_order')
      		);
    	}
    	return $method_data;
  	}
	 function getTaxesCnp() {
	
			 $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tax_rate");

		 return $query->rows;
	 }
	 function getCnpTaxClassId() {
	
			 $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tax_class");

		 return $query->rows;
	 }
}
?>