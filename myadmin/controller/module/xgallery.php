<?php
class ControllerModuleXGallery extends Controller {
	private $error = array(); 
	 
	public function index() {   
		$this->load->language('module/xgallery');
		
		$this->load->model('tool/image');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('xgallery', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled']                  = $this->language->get('text_enabled');
		$this->data['text_disabled']             	 = $this->language->get('text_disabled');
		$this->data['text_content_top']          	 = $this->language->get('text_content_top');
		$this->data['text_content_bottom']        	 = $this->language->get('text_content_bottom');		
		$this->data['text_column_left']              = $this->language->get('text_column_left');
		$this->data['text_column_right']             = $this->language->get('text_column_right');
		$this->data['text_preset_central_expand'] 	 = $this->language->get('text_preset_central_expand');
		$this->data['text_preset_zoomer']         	 = $this->language->get('text_preset_zoomer');
		$this->data['text_preset_fade_three']     	 = $this->language->get('text_preset_fade_three');
		$this->data['text_preset_simple_fade']       = $this->language->get('text_preset_simple_fade');
		$this->data['text_preset_gslider']     		 = $this->language->get('text_preset_gslider');
		$this->data['text_preset_vslider']     		 = $this->language->get('text_preset_vslider');
		$this->data['text_preset_slide_from_left']   = $this->language->get('text_preset_slide_from_left');
		$this->data['text_preset_slide_from_top']    = $this->language->get('text_preset_slide_from_top');
		$this->data['text_preset_diagonal_fade']     = $this->language->get('text_preset_diagonal_fade');
		$this->data['text_preset_diagonal_expand']   = $this->language->get('text_preset_diagonal_expand');
		$this->data['text_preset_fade_from_center']  = $this->language->get('text_preset_fade_from_center');
		$this->data['text_preset_zabor']     		 = $this->language->get('text_preset_zabor');
		$this->data['text_preset_vertival_lines']    = $this->language->get('text_preset_vertival_lines');
		$this->data['text_preset_gorizontal_lines']  = $this->language->get('text_preset_gorizontal_lines');
		$this->data['text_banner_preset_from_left']  = $this->language->get('text_banner_preset_from_left');
		$this->data['text_banner_preset_from_right'] = $this->language->get('text_banner_preset_from_right');
		$this->data['text_banner_preset_from_top']   = $this->language->get('text_banner_preset_from_top');
		$this->data['text_banner_preset_from_bottom']= $this->language->get('text_banner_preset_from_bottom');
		
		$this->data['entry_banner_id'] 	  	         = $this->language->get('entry_banner_id');
		$this->data['entry_image_dimension'] 	  	 = $this->language->get('entry_image_dimension');
		$this->data['entry_show_thumbnail']  	  	 = $this->language->get('entry_show_thumbnail');
		$this->data['entry_thumbnail_dimension'] 	 = $this->language->get('entry_thumb_dimension');
		$this->data['entry_preset']          	  	 = $this->language->get('entry_preset');
		$this->data['entry_duration']        	  	 = $this->language->get('entry_duration');
		$this->data['entry_pagination']      	  	 = $this->language->get('entry_pagination');
		$this->data['entry_pagination_axis'] 	  	 = $this->language->get('entry_pagination_axis');
		$this->data['entry_pagination_rows'] 	  	 = $this->language->get('entry_pagination_rows');
		$this->data['entry_pagination_show'] 	  	 = $this->language->get('entry_pagination_show');
		$this->data['entry_pagination_shift']	  	 = $this->language->get('entry_pagination_shift');
		$this->data['entry_pagination_step'] 	  	 = $this->language->get('entry_pagination_step');
		$this->data['entry_pagination_clickable'] 	 = $this->language->get('entry_pagination_clickable');
		$this->data['entry_pagination_block_at_end'] = $this->language->get('entry_pagination_block_at_end');
		$this->data['entry_pagination_duration']  	 = $this->language->get('entry_pagination_duration');
		$this->data['entry_pag_nums']             	 = $this->language->get('entry_pag_nums');
		$this->data['entry_num_status']           	 = $this->language->get('entry_num_status');
		$this->data['entry_slideshow']            	 = $this->language->get('entry_slideshow');
		$this->data['entry_banners']              	 = $this->language->get('entry_banners');
		$this->data['entry_pause_on_hover']       	 = $this->language->get('entry_pause_on_hover');
		$this->data['entry_wait_banner_animation']	 = $this->language->get('entry_wait_banner_animation');
		
		$this->data['entry_layout'] 				 = $this->language->get('entry_layout');
		$this->data['entry_position'] 				 = $this->language->get('entry_position');
		$this->data['entry_status'] 			     = $this->language->get('entry_status');
		$this->data['entry_sort_order'] 			 = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] 					 = $this->language->get('button_save');
		$this->data['button_cancel'] 				 = $this->language->get('button_cancel');
		$this->data['button_add_module'] 			 = $this->language->get('button_add_module');
		$this->data['button_remove'] 				 = $this->language->get('button_remove');
		
		$this->data['tab_module'] = $this->language->get('tab_module');
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100,100);
		
		$this->data['token'] = $this->session->data['token'];

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['banner_id'])) {
			$this->data['error_banner_id'] = $this->error['banner_id'];
		} else {
			$this->data['error_banner_id'] = array();
		}
		
		if (isset($this->error['image_dimension'])) {
			$this->data['error_image_dimension'] = $this->error['image_dimension'];
		} else {
			$this->data['error_image_dimension'] = array();
		}
		
		if (isset($this->error['thumbnail_dimension'])) {
			$this->data['error_thumbnail_dimension'] = $this->error['thumbnail_dimension'];
		} else {
			$this->data['error_thumbnail_dimension'] = array();
		}
		
		if (isset($this->error['duration'])) {
			$this->data['error_duration'] = $this->error['duration'];
		} else {
			$this->data['error_duration'] = array();
		}
		
		if (isset($this->error['slideshow'])) {
			$this->data['error_slideshow'] = $this->error['slideshow'];
		} else {
			$this->data['error_slideshow'] = array();
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/xgallery', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		$this->data['action'] = $this->url->link('module/xgallery', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['xgallery_module'])) {
			$this->data['modules'] = $this->request->post['xgallery_module'];
		} elseif ($this->config->get('xgallery_module')) { 
			$this->data['modules'] = $this->config->get('xgallery_module');
		} else {
			$this->data['modules'] = array();
		}
				
		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('design/banner');
		
		$this->data['banners'] = $this->model_design_banner->getBanners();

		$this->template = 'module/xgallery.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
	
	private function validate() {
		
		if (!$this->user->hasPermission('modify', 'module/xgallery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (isset($this->request->post['xgallery_module'])) {
			foreach ($this->request->post['xgallery_module'] as $key => $value) {

				if (!$value['banner_id']) {
					$this->error['banner_id'][$key] = $this->language->get('error_banner_id');
				}
				
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['image_dimension'][$key] = $this->language->get('error_image_dimension');
				}
				
				if ($value['show_thumbnail'] == 1){
					if (!$value['thumbnail_width'] || !$value['thumbnail_height']) {
						$this->error['thumbnail_dimension'][$key] = $this->language->get('error_thumbnail_dimension');
					}
				}
				
				if (!is_numeric($value['duration']) || $value['duration'] < 999) {
					$this->error['duration'][$key] = $this->language->get('error_duration');
				}
				
				if (!is_numeric($value['slideshow']) || $value['slideshow'] < 999) {
					$this->error['slideshow'][$key] = $this->language->get('error_slideshow');
				}
			}
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>