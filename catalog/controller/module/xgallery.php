<?php  
class ControllerModuleXGallery extends Controller {
	protected function index($setting) {
		static $module = 0;
	
		$this->language->load('module/xgallery');
		
		$this->load->model('design/banner');
		$this->load->model('tool/image');
		
		$this->document->addScript('catalog/view/javascript/jquery/jquery.easing.1.3.js');
		$this->document->addScript('catalog/view/javascript/jquery/uCarousel.js');
		$this->document->addScript('catalog/view/javascript/jquery/tms-0.4.1.js');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/xgallery.css')) {
			$this->document->addStyle('catalog/view/theme/' .  $this->config->get('config_template') . '/stylesheet/xgallery.css');
		} else {
			$this->document->addStyle('catalog/view/theme/default/stylesheet/xgallery.css');
		}		
		
		$this->data['text_prev'] = $this->language->get('text_prev');
		$this->data['text_next'] = $this->language->get('text_next');
		$this->data['text_play'] = $this->language->get('text_play');
		$this->data['text_stop'] = $this->language->get('text_stop');
		
		$this->data['banners'] = array();
		
		if (isset($setting['banner_id'])) {
			$results = $this->model_design_banner->getBanner($setting['banner_id']);
			  
			foreach ($results as $result) {
				if (file_exists(DIR_IMAGE . $result['image'])) {
					$this->data['banners'][] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['image_width'], $setting['image_height']),
						'thumb' => $this->model_tool_image->resize($result['image'], $setting['thumbnail_width'], $setting['thumbnail_height']) 
					);
				}
			}
		}
		
		$total_images = count($this->data['banners']);
		
		$this->data['image_width'] = $setting['image_width'];
		$this->data['image_height'] = $setting['image_height'];
		$this->data['show_thumbnail'] = $setting['show_thumbnail'];
		$this->data['thumbnail_width'] = $setting['thumbnail_width'];
		$this->data['thumbnail_height'] = $setting['thumbnail_height'];
		$this->data['preset'] = $setting['preset'];
		$this->data['duration'] = $setting['duration'];
		$this->data['pag_nums'] = $setting['pag_nums'];
		$this->data['num_status'] = $setting['num_status'];
		$this->data['slideshow'] = $setting['slideshow'];
		$this->data['banners_effect'] = $setting['banners'];
		$this->data['pause_on_hover'] = $setting['pause_on_hover'];
		$this->data['wait_banner_animation'] = $setting['wait_banner_animation'];
		
		$pag_show_elem = ($setting['image_width'] - 50) / ($setting['thumbnail_width'] + 15);
		
		if ($pag_show_elem > $total_images){
			$pag_show_elem = $total_images;
		}
		
		$this->data['pag_show_elem'] = $pag_show_elem;

		$this->data['module'] = $module++;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/xgallery.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/xgallery.tpl';
		} else {
			$this->template = 'default/template/module/xgallery.tpl';
		}
		
		$this->render();
	}
}
?>