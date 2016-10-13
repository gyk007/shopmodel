<?php  
class ControllerModuleGoogleTranslate extends Controller {
	protected function index($setting) {
		$this->language->load('module/google_translate');
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['type'] = $setting['type'];
		$this->data['current_language_code'] = $this->session->data['language'];

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/google_translate.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/google_translate.tpl';
		} else {
			$this->template = 'default/template/module/google_translate.tpl';
		}
		
		$this->render();
	}
}
?>