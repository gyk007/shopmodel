<?php 
class ControllerPaymentAssistRu extends Controller {
	private $error = array();
	
	public function index() {
		$this->load->language('payment/assist_ru');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
			$this->load->model('setting/setting');
			
			$this->model_setting_setting->editSetting('assist_ru', $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		
		$this->data['entry_account'] = $this->language->get('entry_account');
		$this->data['entry_test'] = $this->language->get('entry_test');
		$this->data['entry_test_result'] = $this->language->get('entry_test_result');
		$this->data['entry_secret'] = $this->language->get('entry_secret');
		$this->data['entry_order_status_initial'] = $this->language->get('entry_order_status_initial');
		$this->data['entry_order_status_paid'] = $this->language->get('entry_order_status_paid');
		$this->data['entry_order_status_error'] = $this->language->get('entry_order_status_error');
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
		$this->data['tab_general'] = $this->language->get('tab_general');
		
		$this->data['error_warning'] = (isset ($this->error['warning'])) ? $this->error['warning'] : FALSE;
		
		$this->data['error_account'] = (isset ($this->error['account'])) ? $this->error['account'] : FALSE;
		
		$this->data['error_test_result'] = (isset ($this->error['test_result'])) ? $this->error['test_result'] : FALSE;
		
		$this->data['breadcrumbs'] = array (
			array (
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => FALSE
			),
			array (
				'text'      => $this->language->get('text_payment'),
				'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			),
			array (
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('payment/assist_ru', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			)
		);
		
		$this->data['action'] = $this->url->link('payment/assist_ru', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['assist_ru_account'])) {
			$this->data['assist_ru_account'] = $this->request->post['assist_ru_account'];
		} else {
			$this->data['assist_ru_account'] = $this->config->get('assist_ru_account');
		}
		
		if (isset($this->request->post['assist_ru_test'])) {
			$this->data['assist_ru_test'] = $this->request->post['assist_ru_test'];
		} else {
			$this->data['assist_ru_test'] = $this->config->get('assist_ru_test');
		}
		
		if (isset($this->request->post['assist_ru_test_result'])) {
			$this->data['assist_ru_test_result'] = $this->request->post['assist_ru_test_result'];
		} else {
			$this->data['assist_ru_test_result'] = $this->config->get('assist_ru_test_result');
		}
		
		if (isset($this->request->post['assist_ru_secret'])) {
			$this->data['assist_ru_secret'] = $this->request->post['assist_ru_secret'];
		} else {
			$this->data['assist_ru_secret'] = $this->config->get('assist_ru_secret');
		}
		
		if (isset($this->request->post['assist_ru_order_status_initial'])) {
			$this->data['assist_ru_order_status_initial'] = $this->request->post['assist_ru_order_status_initial'];
		} else {
			$this->data['assist_ru_order_status_initial'] = $this->config->get('assist_ru_order_status_initial'); 
		}
		
		if (isset($this->request->post['assist_ru_order_status_paid'])) {
			$this->data['assist_ru_order_status_paid'] = $this->request->post['assist_ru_order_status_paid'];
		} else {
			$this->data['assist_ru_order_status_paid'] = $this->config->get('assist_ru_order_status_paid'); 
		}
		
		if (isset($this->request->post['assist_ru_order_status_error'])) {
			$this->data['assist_ru_order_status_error'] = $this->request->post['assist_ru_order_status_error'];
		} else {
			$this->data['assist_ru_order_status_error'] = $this->config->get('assist_ru_order_status_error'); 
		}
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['assist_ru_geo_zone_id'])) {
			$this->data['assist_ru_geo_zone_id'] = $this->request->post['assist_ru_geo_zone_id'];
		} else {
			$this->data['assist_ru_geo_zone_id'] = $this->config->get('assist_ru_geo_zone_id'); 
		}
		
		$this->load->model('localisation/geo_zone');
		
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['assist_ru_status'])) {
			$this->data['assist_ru_status'] = $this->request->post['assist_ru_status'];
		} else {
			$this->data['assist_ru_status'] = $this->config->get('assist_ru_status');
		}
		
		if (isset($this->request->post['assist_ru_sort_order'])) {
			$this->data['assist_ru_sort_order'] = $this->request->post['assist_ru_sort_order'];
		} else {
			$this->data['assist_ru_sort_order'] = $this->config->get('assist_ru_sort_order');
		}
		
		$this->template = 'payment/assist_ru.tpl';
		
		$this->children = array(
			'common/header',
			'common/footer'
		);
		
		$this->response->setOutput($this->render(TRUE), $this->config->get('config_compression'));
	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'payment/assist_ru')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['assist_ru_account']) {
			$this->error['account'] = $this->language->get('error_account');
		}
		
		if ($this->request->post['assist_ru_test'] == 1 && !$this->request->post['assist_ru_test_result']) {
			$this->error['test_result'] = $this->language->get('error_test_result');
		}
		
		return (!$this->error) ? TRUE : FALSE;
	}
}
?>