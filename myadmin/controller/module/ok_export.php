<?php
class ControllerModuleOKExport extends Controller {
	private $error = array(); 
    
    public function install() {
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('ok_export', array(
			'ok_export_user_email' => '',
			'ok_export_user_pass' => '',
            'ok_export_nomeralb_id' => '',
			'ok_export_nomeralbuser_id' => '',
            'ok_export_group_id' => '',
            'ok_export_wallpost_tpl' => "{name} {model}\n{price}\n{link}",
            'ok_export_products_per_page' => 20,
            'ok_export_http_catalog' => '',
			'ok_export_image_size_x' => '200',
			'ok_export_image_size_y' => '200',
			'ok_export_contry' => '',
			'ok_export_phone' => '',
			'ok_export_photos_hoved' => '1',

        ));
        $this->db->query("DROP TABLE IF EXISTS`" . DB_PREFIX . "ok_export_album`" );    
        $this->db->query("DROP TABLE IF EXISTS`" . DB_PREFIX . "ok_export_photo`" );
							
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ok_export_album` (
                              `category_id` int(11) NOT NULL, 
                              `ok_album_id` varchar(32) NOT NULL, 
                              PRIMARY KEY (`category_id`,`ok_album_id`)
                            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8");               
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "ok_export_photo` (
                              `product_id` int(11) NOT NULL, 
                              `ok_photo_id` varchar(32) NOT NULL,
                              `category_id` int(11) NOT NULL,
                              `date` DATETIME NOT NULL,
							  `location` ENUM( 'albums', 'wall' ) NOT NULL,
                              PRIMARY KEY (`product_id`,`ok_photo_id`)
                            ) ENGINE=MyISAM DEFAULT CHARSET=utf8");                                                         
    }
    public function index() {   
		$this->load->model('setting/setting');
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            if (!isset($this->request->post['ok_export_wall_only_specials'])) {
                $this->request->post['ok_export_wall_only_specials'] = 0;
            }
            if (!isset($this->request->post['ok_export_albums_only_specials'])) {
                $this->request->post['ok_export_albums_only_specials'] = 0;
            }
            if (!isset($this->request->post['ok_export_column_model'])) {
                $this->request->post['ok_export_column_model'] = 0;
            }
            if (!isset($this->request->post['ok_export_column_price'])) {
                $this->request->post['ok_export_column_price'] = 0;
            }
            if (!isset($this->request->post['ok_export_column_quantity'])) {
                $this->request->post['ok_export_column_quantity'] = 0;
            }
            if (!isset($this->request->post['ok_export_column_status'])) {
                $this->request->post['ok_export_column_status'] = 0;
            }
            if (!isset($this->request->post['ok_export_column_date_added'])) {
                $this->request->post['ok_export_column_date_added'] = 0;
            }
            $this->model_setting_setting->editSetting('ok_export', $this->request->post);		
			$this->session->data['success'] = $this->language->get('text_success');
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
		}	
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
        if (isset($this->error['warning_geo'])) {
			$this->data['error_warning_geo'] = $this->error['warning_geo'];
		} else {
			$this->data['error_warning_geo'] = '';
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
			'href'      => $this->url->link('module/ok_export', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		$this->data['action'] = $this->url->link('module/ok_export', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['token'] = $this->session->data['token'];
        $this->load->model('setting/extension');
        if (isset($this->request->post['ok_export_user_email'])) {
			$this->data['ok_export_user_email'] = $this->request->post['ok_export_user_email'];
		} else {
			$this->data['ok_export_user_email'] = $this->config->get('ok_export_user_email');
		}
        if (isset($this->request->post['ok_export_user_pass'])) {
			$this->data['ok_export_user_pass'] = $this->request->post['ok_export_user_pass'];
		} else {
			$this->data['ok_export_user_pass'] = $this->config->get('ok_export_user_pass');
		}
        if (isset($this->request->post['ok_export_nomeralb_id'])) {
			$this->data['ok_export_nomeralb_id'] = $this->request->post['ok_export_nomeralb_id'];
		} else {
			$this->data['ok_export_nomeralb_id'] = $this->config->get('ok_export_nomeralb_id');
		}
        if (isset($this->request->post['ok_export_nomeralbuser_id'])) {
			$this->data['ok_export_nomeralbuser_id'] = $this->request->post['ok_export_nomeralbuser_id'];
		} else {
			$this->data['ok_export_nomeralbuser_id'] = $this->config->get('ok_export_nomeralbuser_id');
		}
        if (isset($this->request->post['ok_export_group_id'])) {
			$this->data['ok_export_group_id'] = $this->request->post['ok_export_group_id'];
		} else {
			$this->data['ok_export_group_id'] = $this->config->get('ok_export_group_id');
		}
        if (isset($this->request->post['ok_export_desc_tpl'])) {
			$this->data['ok_export_desc_tpl'] = $this->request->post['ok_export_desc_tpl'];
		} else {
			$this->data['ok_export_desc_tpl'] = $this->config->get('ok_export_desc_tpl');
		}
        if (isset($this->request->post['ok_export_wallpost_tpl'])) {
			$this->data['ok_export_wallpost_tpl'] = $this->request->post['ok_export_wallpost_tpl'];
		} else {
			$this->data['ok_export_wallpost_tpl'] = $this->config->get('ok_export_wallpost_tpl');
		}
        if (isset($this->request->post['ok_export_cron_user'])) {
			$this->data['ok_export_cron_user'] = $this->request->post['ok_export_cron_user'];
		} else {
			$this->data['ok_export_cron_user'] = $this->config->get('ok_export_cron_user');
		}
        if (isset($this->request->post['ok_export_products_per_page'])) {
			$this->data['ok_export_products_per_page'] = $this->request->post['ok_export_products_per_page'];
		} else {
			$this->data['ok_export_products_per_page'] = $this->config->get('ok_export_products_per_page');
		}
        if (isset($this->request->post['ok_export_only_new'])) {
			$this->data['ok_export_only_new'] = $this->request->post['ok_export_only_new'];
		} else {
			$this->data['ok_export_only_new'] = $this->config->get('ok_export_only_new');
		}
        if (isset($this->request->post['ok_export_http_catalog'])) {
			$this->data['ok_export_http_catalog'] = $this->request->post['ok_export_http_catalog'];
		} else {
			$this->data['ok_export_http_catalog'] = $this->config->get('ok_export_http_catalog');
		}
        if (isset($this->request->post['ok_export_albums_only_specials'])) {
			$this->data['ok_export_albums_only_specials'] = $this->request->post['ok_export_albums_only_specials'];
		} else {
            $this->data['ok_export_albums_only_specials'] = $this->config->get('ok_export_albums_only_specials');
		}
        if (isset($this->request->post['ok_export_wall_only_specials'])) {
			$this->data['ok_export_wall_only_specials'] = $this->request->post['ok_export_wall_only_specials'];
		} else {
            $this->data['ok_export_wall_only_specials'] = $this->config->get('ok_export_wall_only_specials');
		}
        if (isset($this->request->post['ok_export_column_model'])) {
			$this->data['ok_export_column_model'] = $this->request->post['ok_export_column_model'];
		} else {
            $this->data['ok_export_column_model'] = $this->config->get('ok_export_column_model');
		}
        if (isset($this->request->post['ok_export_column_price'])) {
			$this->data['ok_export_column_price'] = $this->request->post['ok_export_column_price'];
		} else {
            $this->data['ok_export_column_price'] = $this->config->get('ok_export_column_price');
		}
        if (isset($this->request->post['ok_export_column_quantity'])) {
			$this->data['ok_export_column_quantity'] = $this->request->post['ok_export_column_quantity'];
		} else {
            $this->data['ok_export_column_quantity'] = $this->config->get('ok_export_column_quantity');
		}
        if (isset($this->request->post['ok_export_column_status'])) {
			$this->data['ok_export_column_status'] = $this->request->post['ok_export_column_status'];
		} else {
            $this->data['ok_export_column_status'] = $this->config->get('ok_export_column_status');
		}
        if (isset($this->request->post['ok_export_column_date_added'])) {
			$this->data['ok_export_column_date_added'] = $this->request->post['ok_export_column_date_added'];
		} else {
            $this->data['ok_export_column_date_added'] = $this->config->get('ok_export_column_date_added');
		}
        if (isset($this->request->post['ok_export_image_size_x'])) {
			$this->data['ok_export_image_size_x'] = $this->request->post['ok_export_image_size_x'];
		} else {
            $this->data['ok_export_image_size_x'] = $this->config->get('ok_export_image_size_x');
		}
        if (isset($this->request->post['ok_export_image_size_y'])) {
			$this->data['ok_export_image_size_y'] = $this->request->post['ok_export_image_size_y'];
		} else {
            $this->data['ok_export_image_size_y'] = $this->config->get('ok_export_image_size_y');
		}
        $this->load->model('catalog/ok_export');
        $categories = $this->model_catalog_ok_export->getAllCategories();
		$this->data['categories'] = $this->getAllCategories($categories);
		$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
	}
    private function getAllCategories($categories, $parent_id = 0, $parent_name = '') {
		$output = array();
		if (array_key_exists($parent_id, $categories)) {
			if ($parent_name != '') {
				$parent_name .= $this->language->get('text_separator');
			}
			foreach ($categories[$parent_id] as $category) {
				$output[$category['category_id']] = array(
					'category_id' => $category['category_id'],
					'name'        => $parent_name . $category['name']
				);
				$output += $this->getAllCategories($categories, $category['category_id'], $parent_name . $category['name']);
			}
		}
		return $output;
	}
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/ok_export')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}	
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>
