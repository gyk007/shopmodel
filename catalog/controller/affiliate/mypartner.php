<?php
class ControllerAffiliateMypartner extends Controller {
	private $error = array();

	public function index() {
		if (!$this->affiliate->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('affiliate/mypartner', '', 'SSL');

			$this->redirect($this->url->link('affiliate/login', '', 'SSL'));
		}
        
		$this->language->load('affiliate/mypartner');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('affiliate/affiliate');
		
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$this->model_affiliate_affiliate->editPayment($this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('affiliate/account', '', 'SSL'));
		}

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),     	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('affiliate/account', '', 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('affiliate/payment', '', 'SSL'),       	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['mypartnertitle'] = $this->language->get('heading_title');
		$this->data['text_your_payment'] = $this->language->get('text_your_payment');
	 
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');
	 
		$this->data['action'] = $this->url->link('affiliate/payment', '', 'SSL');

		if ($this->request->server['REQUEST_METHOD'] != 'POST') {
			$affiliate_info = $this->model_affiliate_affiliate->getAffiliate($this->affiliate->getId());
		}

		  
		 	$this->data['mypartner1'] = $this->model_affiliate_affiliate->getAffiliateMypartner1($affiliate_info['email']);
           
           $this->data['mypartner2'] = $this->model_affiliate_affiliate->getAffiliateMypartner2($affiliate_info['email']);
           
           $this->data['mypartner3'] = $this->model_affiliate_affiliate->getAffiliateMypartner3($affiliate_info['email']);
           
           $this->data['mypartner4'] = $this->model_affiliate_affiliate->getAffiliateMypartner4($affiliate_info['email']);   
                
               
          
            
		$this->data['back'] = $this->url->link('affiliate/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/affiliate/mypartner.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/affiliate/mypartner.tpl';
		} else {
			$this->template = 'default/template/affiliate/payment.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
						
		$this->response->setOutput($this->render());		
	}
}
?>