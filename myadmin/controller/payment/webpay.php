<?php
class ControllerPaymentWebPay extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('payment/webpay');

	$this->document->setTitle = $this->language->get('heading_title');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('webpay', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect(HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token']);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['entry_shop_id'] = $this->language->get('entry_shop_id');
		$this->data['entry_shop_name'] = $this->language->get('entry_shop_name');
		$this->data['entry_soap_lib'] = $this->language->get('entry_soap_lib');
		$this->data['entry_shop_key'] = $this->language->get('entry_shop_key');
		$this->data['entry_shop_mes'] = $this->language->get('entry_shop_mes');
$this->data['entry_byr_en'] = $this->language->get('entry_byr_en');

		$this->data['entry_result_url'] = $this->language->get('entry_result_url');
		$this->data['entry_success_url'] = $this->language->get('entry_success_url');
		$this->data['entry_fail_url'] = $this->language->get('entry_fail_url');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');

		$this->data['entry_order_status'] = $this->language->get('entry_order_status');
		$this->data['entry_order_status_cancel'] = $this->language->get('entry_order_status_cancel');
		$this->data['entry_order_status_progress'] = $this->language->get('entry_order_status_progress');
		$this->data['entry_lifetime'] = $this->language->get('entry_lifetime');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['shop_id'])) {
			$this->data['error_shop_id'] = $this->error['shop_id'];
		} else {
			$this->data['error_shop_id'] = '';
		}

		if (isset($this->error['shop_name'])) {
			$this->data['error_shop_name'] = $this->error['shop_name'];
		} else {
			$this->data['error_shop_name'] = '';
		}

		if (isset($this->error['shop_key'])) {
			$this->data['error_shop_key'] = $this->error['shop_key'];
		} else {
			$this->data['error_shop_key'] = '';
		}

		if (isset($this->error['lifetime'])) {
			$this->data['error_lifetime'] = $this->error['lifetime'];
		} else {
			$this->data['error_lifetime'] = '';
		}

				$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/webpay', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = HTTPS_SERVER . 'index.php?route=payment/webpay&token=' . $this->session->data['token'];

		$this->data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&token=' . $this->session->data['token'];


		// Номер магазина
		if (isset($this->request->post['webpay_shop_id'])) {
			$this->data['webpay_shop_id'] = $this->request->post['webpay_shop_id'];
		} else {
			$this->data['webpay_shop_id'] = $this->config->get('webpay_shop_id');
		}

		if (isset($this->request->post['webpay_shop_name'])) {
			$this->data['webpay_shop_name'] = $this->request->post['webpay_shop_name'];
		} else {
			$this->data['webpay_shop_name'] = $this->config->get('webpay_shop_name');
		}

		if (isset($this->request->post['webpay_shop_key'])) {
			$this->data['webpay_shop_key'] = $this->request->post['webpay_shop_key'];
		} else {
			$this->data['webpay_shop_key'] = $this->config->get('webpay_shop_key');
		}

		if (isset($this->request->post['webpay_shop_mes'])) {
			$this->data['webpay_shop_mes'] = $this->request->post['webpay_shop_mes'];
		} else {
			$this->data['webpay_shop_mes'] = $this->config->get('webpay_shop_mes');
		}

		// URL
		$this->data['webpay_result_url'] 		= HTTP_CATALOG . 'index.php?route=payment/webpay/callback';
		$this->data['webpay_success_url'] 	= HTTP_CATALOG . 'index.php?route=payment/webpay/success';
		$this->data['webpay_fail_url'] 		= HTTP_CATALOG . 'index.php?route=payment/webpay/fail';


		if (isset($this->request->post['webpay_order_status_id'])) {
			$this->data['webpay_order_status_id'] = $this->request->post['webpay_order_status_id'];
		} else {
			$this->data['webpay_order_status_id'] = $this->config->get('webpay_order_status_id');
		}

		if (isset($this->request->post['webpay_order_status_cancel_id'])) {
			$this->data['webpay_order_status_cancel_id'] = $this->request->post['webpay_order_status_cancel_id'];
		} else {
			$this->data['webpay_order_status_cancel_id'] = $this->config->get('webpay_order_status_cancel_id');
		}

		if (isset($this->request->post['webpay_order_status_progress_id'])) {
			$this->data['webpay_order_status_progress_id'] = $this->request->post['webpay_order_status_progress_id'];
		} else {
			$this->data['webpay_order_status_progress_id'] = $this->config->get('webpay_order_status_progress_id');
		}

		if (isset($this->request->post['webpay_lifetime'])) {
			$this->data['webpay_lifetime'] = (int)$this->request->post['webpay_lifetime'];
		} elseif( $this->config->get('webpay_lifetime') ) {
			$this->data['webpay_lifetime'] = (int)$this->config->get('webpay_lifetime');
		} else {
			$this->data['webpay_lifetime'] = 24;
		}

		// Проверка на наличие SOAP сервера
		if( class_exists('SoapServer') ) {
			$this->data['flag_soap'] = 1;
		} else {
			$this->data['flag_soap'] = 0;
		}


		$this->load->model('localisation/currency');

		$results = $this->model_localisation_currency->getCurrencies();	
		$this->data['flag_byr'] = 0;

		foreach ($results as $result) {
			if ($result['code'] == 'BYR') {
				$this->data['flag_byr'] = 1;
   			
			}
		}


		$this->load->model('localisation/order_status');

		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		if (isset($this->request->post['webpay_geo_zone_id'])) {
			$this->data['webpay_geo_zone_id'] = $this->request->post['webpay_geo_zone_id'];
		} else {
			$this->data['webpay_geo_zone_id'] = $this->config->get('webpay_geo_zone_id');
		}

		$this->load->model('localisation/geo_zone');

		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		if (isset($this->request->post['webpay_status'])) {
			$this->data['webpay_status'] = $this->request->post['webpay_status'];
		} else {
			$this->data['webpay_status'] = $this->config->get('webpay_status');
		}

		if (isset($this->request->post['webpay_sort_order'])) {
			$this->data['webpay_sort_order'] = $this->request->post['webpay_sort_order'];
		} else {
			$this->data['webpay_sort_order'] = $this->config->get('webpay_sort_order');
		}

		$this->template = 'payment/webpay.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/webpay')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}


		// TODO проверку на валидность номера!
		if (!$this->request->post['webpay_shop_id']) {
			$this->error['shop_id'] = $this->language->get('error_shop_id');
		}

		if (!$this->request->post['webpay_shop_name']) {
			$this->error['shop_name'] = $this->language->get('error_shop_name');
		}

		if (!$this->request->post['webpay_shop_key']) {
			$this->error['shop_key'] = $this->language->get('error_shop_key');
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>