<?php 
class ControllerInformationAllpartner extends Controller {
	  
	    
  	public function index() {
		$this->language->load('information/contact');

    	$this->document->setTitle($this->language->get('heading_title'));  
	 
    	 $this->load->model('affiliate/affiliate');
         
 	      
          

      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => 'Главная',
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	);

      	$this->data['breadcrumbs'][] = array(
        	'text'      => 'Все партнеры',
			'href'      => $this->url->link('information/allpartner'),
        	'separator' => $this->language->get('text_separator')
      	);	
			
            if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else { 
			$page = 1;
		}	
         $limit = 40;   
            	$data = array(
				 
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
            
            $this->data['affiliate_info']= $this->model_affiliate_affiliate->getAllAffiliate($data);
         
            $count = $this->model_affiliate_affiliate->getAllAffiliateCount();
            
            
    	    $pagination = new Pagination();
			$pagination->total = $count - 1;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('information/allpartner', 'path=' . $this->request->get['path'] . $url . '&page={page}');
		
			$this->data['pagination'] = $pagination->render();

		 
		 

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/allpartner.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/information/allpartner.tpl';
		} else {
			$this->template = 'default/template/information/allpartner.tpl';
		}
		
		$this->children = array(
		 'common/column_left',
			 
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
				
 		$this->response->setOutput($this->render());		
  	}

   }
?>
