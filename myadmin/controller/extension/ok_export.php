<?php
class ControllerExtensionOKExport extends Controller
{
    private $error = array();
    public function index()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $this->load->model('setting/extension');
        $extensions = $this->model_setting_extension->getInstalled('module');
        if (!in_array('ok_export', $extensions)) {
            $this->not_installed();
        } else {
            $this->getList();
        }
    }
    public function not_installed()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->data['breadcrumbs']   = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        $this->template              = 'extension/ok_export_no.tpl';
        $this->children              = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }
    public function exportuser()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/ok_export');
        if (isset($this->request->post['selected']) && $this->validateOkExport()) {
            session_write_close();
            $report  = array();
            $success = 0;
            $total   = count($this->request->post['selected']);
            $this->flushProgress();
            $login = trim($this->request->post['login']);
            $password = trim($this->request->post['password']);
            $album_group = trim($this->request->post['albumuser_group']);
            foreach ($this->request->post['selected'] as $key => $product_id) {
			    if (!$this->config->get('ok_export_user_email')) {
					$report[] = 'Заполните поле ввода логина!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_user_pass')) {
					$report[] = 'Заполните поле ввода пароля!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_nomeralbuser_id')) {
					$report[] = 'Заполните поле альбома пользователя группы!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_wallpost_tpl')) {
					$report[] = 'Заполните поле ввода шаблона сообщения для экспорта!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    sleep(2);
                $p           = $this->model_catalog_ok_export->getProduct($product_id);
                $category_id = $this->request->post['album'][$product_id];
                $name = $this->request->post['names'][$product_id];
                $image  = $this->request->post['images'][$product_id];
                if (!$p['image']) {
                    $report[] = 'Товар "' . $p['name'] . '" не имеет изображения';
                    continue;
                }
				if ($this->config->get('ok_export_photos_count') >= 1) {
				$this->load->model('tool/image');
        
				$product_images = $this->model_catalog_product->getProductImages($product_id);
				$images_in = array();
				$i = 1;
				foreach ($product_images as $img) {
					if (pathinfo($img['image'], PATHINFO_BASENAME) == $p['sku'] . '.jpg') {
						continue;
					}
					$i++;
					$img['image'] = $this->model_tool_image->resize($img['image'], $this->config->get('ok_export_image_size_x'), $this->config->get('ok_export_image_size_y'));
					$img['image'] = DIR_IMAGE . str_replace(HTTP_CATALOG, '', $img['image']);
					$img['image'] = str_replace('/image/image/', '/image/', $img['image']);
					$images_in[] = $img['image'];
				}
				}
                if ( !function_exists('curl_redir_exec') ) {
				function curl_redir_exec($curl, $redirects = 0) {
					curl_setopt($curl, CURLOPT_HEADER, true);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
					$data = curl_exec($curl);
					$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
					if (($http_code == 301 || $http_code == 302) && ++$redirects < 10) {
						preg_match('/(Location:|URI:)(.*?)\n/', $data, $matches);
						if (isset($matches[2])) {
							$redirect_url = trim($matches[2]);
							if ($redirect_url !== '') {
								curl_setopt($curl, CURLOPT_URL, $redirect_url);
								return curl_redir_exec($curl, $redirects);
							}
						}
					}
					return $data;
				}
                }
                $cookie = tempnam(DIR_CACHE, 'cookie');
                if( $curl = curl_init() ) {
                curl_setopt($curl, CURLOPT_URL, 'http://m.odnoklassniki.ru');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'form action="')+13;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, 'http://m.odnoklassniki.ru');
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.needCaptcha=&fr.login=".$login."&fr.password=".$password."&button_login=%D0%92%D0%BE%D0%B9%D1%82%D0%B8");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                if (strpos($out,'Неверный логин или пароль')===false)
                {
				    $out = curl_redir_exec($curl);
                } else {
					$report[] = 'Неверный логин или пароль для входа в одноклассники!';
					
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
                if (strpos($out,'Безопасность - это ОК')===false)
                {
				    $out = curl_redir_exec($curl);
                } else {
					$report[] = 'Ваш аккаунт временно заблокирован. Требуется пройти авторизацию по смс! Вверху страницы нажмите на кнопку "Настройки" и выберите пункт "Проверка доступности аккаунта"';
					
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
				if ($this->config->get('ok_export_photos_hoved') >= 1) {
				$out = curl_redir_exec($curl);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru/dk?st.cmd=userAddAlbumPhoto&amp;st.albId=$album_group";
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                    $post = array(
                        "fr.posted" => "set",
                        "fr.file" => "@".$image
                    );
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.msg=".$name."&button_save=%D0%A1%D0%BE%D1%85%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D1%8C");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
				$out = curl_redir_exec($curl);
				}
                $out = curl_redir_exec($curl);
				if ($this->config->get('ok_export_photos_count') >= 1) {
				foreach ($images_in as $img) {
                $out = curl_redir_exec($curl);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru/dk?st.cmd=userAddAlbumPhoto&amp;st.albId=$album_group";
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                    $post = array(
                        "fr.posted" => "set",
                        "fr.file" => "@".$img
                    );
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.msg=".$name."&button_save=%D0%A1%D0%BE%D1%85%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D1%8C");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
				}
				}
				$out = curl_redir_exec($curl);
				curl_setopt($curl, CURLOPT_POSTFIELDS, "");
				$old_linka = $linka;
                $linka = 'http://m.odnoklassniki.ru/dk?bk=Logoff&st.cmd=logoff&_prevCmd=logoff';
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&button_logoff=%D0%92%D1%8B%D0%B9%D1%82%D0%B8");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                curl_close($curl);
                }
                $error              = false;
                $this->errorMessage = '';
                if (!$this->makeLoad($product_id, $p, $category_id)) {
                    $error = true;
                }
                if ($this->errorMessage) {
                    $report[] = $this->errorMessage;
                }
                if (!$error) {
                    $success++;
                }
                $this->writeProgress($success);
            }
            $msg = '';
            $ok_export_report = array();
            if ($success) {
                $msg = $this->language->get('text_ok_export_success');
                $msg = sprintf($msg, $success, $total);
                $ok_export_report['success'] = $msg;
            }
            if ($report) {
                $ok_export_report['warning'] = implode('<br>', $report);
            }
            if ($ok_export_report) {
                $this->cache->set('ok_export_report', $ok_export_report);
            }
            $url = '';
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }
            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model=' . $this->request->get['filter_model'];
            }
            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . $this->request->get['filter_price'];
            }
            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }
            if (isset($this->request->get['filter_category'])) {
                $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            if (isset($this->request->get['filter_export_albums'])) {
                $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
            }
            if (isset($this->request->get['filter_export_wall'])) {
                $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getList();
    }
    public function export()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/ok_export');
        if (isset($this->request->post['selected']) && $this->validateOkExport()) {
            session_write_close();
            $report  = array();
            $success = 0;
            $total   = count($this->request->post['selected']);
            $this->flushProgress();
            $login = trim($this->request->post['login']);
            $password = trim($this->request->post['password']);
            $number_group = trim($this->request->post['number_group']);
            $album_group = trim($this->request->post['album_group']);
            foreach ($this->request->post['selected'] as $key => $product_id) {
			    if (!$this->config->get('ok_export_user_email')) {
					$report[] = 'Заполните поле ввода логина!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_user_pass')) {
					$report[] = 'Заполните поле ввода пароля!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_group_id')) {
					$report[] = 'Заполните поле ввода группы!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_nomeralb_id')) {
					$report[] = 'Заполните поле альбома группы!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_wallpost_tpl')) {
					$report[] = 'Заполните поле ввода шаблона сообщения для экспорта!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    sleep(2);
                $p           = $this->model_catalog_ok_export->getProduct($product_id);
                $category_id = $this->request->post['album'][$product_id];
                $name = $this->request->post['names'][$product_id];
                $image  = $this->request->post['images'][$product_id];
                if (!$p['image']) {
                    $report[] = 'Товар "' . $p['name'] . '" не имеет изображения';
                    continue;
                }
				if ($this->config->get('ok_export_photos_count') >= 1) {
				$this->load->model('tool/image');
        
				$product_images = $this->model_catalog_product->getProductImages($product_id);
				$images_in = array();
				$i = 1;
				foreach ($product_images as $img) {
					if (pathinfo($img['image'], PATHINFO_BASENAME) == $p['sku'] . '.jpg') {
						continue;
					}
					$i++;
					$img['image'] = $this->model_tool_image->resize($img['image'], $this->config->get('ok_export_image_size_x'), $this->config->get('ok_export_image_size_y'));
					$img['image'] = DIR_IMAGE . str_replace(HTTP_CATALOG, '', $img['image']);
					$img['image'] = str_replace('/image/image/', '/image/', $img['image']);
					$images_in[] = $img['image'];
				}
				}
                if ( !function_exists('curl_redir_exec') ) {
				function curl_redir_exec($curl, $redirects = 0) {
					curl_setopt($curl, CURLOPT_HEADER, true);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
					$data = curl_exec($curl);
					$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
					if (($http_code == 301 || $http_code == 302) && ++$redirects < 10) {
						preg_match('/(Location:|URI:)(.*?)\n/', $data, $matches);
						if (isset($matches[2])) {
							$redirect_url = trim($matches[2]);
							if ($redirect_url !== '') {
								curl_setopt($curl, CURLOPT_URL, $redirect_url);
								return curl_redir_exec($curl, $redirects);
							}
						}
					}
					return $data;
				}
                }
                $cookie = tempnam(DIR_CACHE, 'cookie');
                if( $curl = curl_init() ) {
                curl_setopt($curl, CURLOPT_URL, 'http://m.odnoklassniki.ru');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'form action="')+13;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, 'http://m.odnoklassniki.ru');
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.needCaptcha=&fr.login=".$login."&fr.password=".$password."&button_login=%D0%92%D0%BE%D0%B9%D1%82%D0%B8");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                if (strpos($out,'Неверный логин или пароль')===false)
                {
				    $out = curl_redir_exec($curl);
                } else {
					$report[] = 'Неверный логин или пароль для входа в одноклассники!';
					
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
                if (strpos($out,'Безопасность - это ОК')===false)
                {
				    $out = curl_redir_exec($curl);
                } else {
					$report[] = 'Ваш аккаунт временно заблокирован. Требуется пройти авторизацию по смс! Вверху страницы нажмите на кнопку "Настройки" и выберите пункт "Проверка доступности аккаунта"';
					
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
				if ($this->config->get('ok_export_photos_hoved') >= 1) {
				$out = curl_redir_exec($curl);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru/dk?st.cmd=altGroupAddAlbumPhoto&amp;st.groupId=$number_group&amp;st.albId=$album_group";
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                    $post = array(
                        "fr.posted" => "set",
                        "fr.file" => "@".$image
                    );
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.msg=".$name."&button_save=%D0%A1%D0%BE%D1%85%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D1%8C");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
				$out = curl_redir_exec($curl);
				}
                $out = curl_redir_exec($curl);
				if ($this->config->get('ok_export_photos_count') >= 1) {
				foreach ($images_in as $img) {
                $out = curl_redir_exec($curl);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru/dk?st.cmd=altGroupAddAlbumPhoto&amp;st.groupId=$number_group&amp;st.albId=$album_group";
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
				curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                    $post = array(
                        "fr.posted" => "set",
                        "fr.file" => "@".$img
                    );
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.msg=".$name."&button_save=%D0%A1%D0%BE%D1%85%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D1%8C");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
				}
				}
				$out = curl_redir_exec($curl);
				curl_setopt($curl, CURLOPT_POSTFIELDS, "");
				$old_linka = $linka;
                $linka = 'http://m.odnoklassniki.ru/dk?bk=Logoff&st.cmd=logoff&_prevCmd=logoff';
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&button_logoff=%D0%92%D1%8B%D0%B9%D1%82%D0%B8");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                curl_close($curl);
                }
                $error              = false;
                $this->errorMessage = '';
                if (!$this->makeLoad($product_id, $p, $category_id)) {
                    $error = true;
                }
                if ($this->errorMessage) {
                    $report[] = $this->errorMessage;
                }
                if (!$error) {
                    $success++;
                }
                $this->writeProgress($success);
            }
            $msg = '';
            $ok_export_report = array();
            if ($success) {
                $msg = $this->language->get('text_ok_export_success');
                $msg = sprintf($msg, $success, $total);
                $ok_export_report['success'] = $msg;
            }
            if ($report) {
                $ok_export_report['warning'] = implode('<br>', $report);
            }
            if ($ok_export_report) {
                $this->cache->set('ok_export_report', $ok_export_report);
            }
            $url = '';
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }
            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model=' . $this->request->get['filter_model'];
            }
            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . $this->request->get['filter_price'];
            }
            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }
            if (isset($this->request->get['filter_category'])) {
                $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            if (isset($this->request->get['filter_export_albums'])) {
                $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
            }
            if (isset($this->request->get['filter_export_wall'])) {
                $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getList();
    }
    public function wallpost()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/ok_export');
        if (isset($this->request->post['selected']) && $this->validateOkExport()) {
            session_write_close();
            $report  = array();
            $success = 0;
            $total   = count($this->request->post['selected']);
            $this->flushProgress();
			$login = trim($this->request->post['login']);
            $password = trim($this->request->post['password']);
            $number_group = trim($this->request->post['number_group']);
            foreach ($this->request->post['selected'] as $key => $product_id) {
			    if (!$this->config->get('ok_export_user_email')) {
					$report[] = 'Заполните поле ввода логина!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_user_pass')) {
					$report[] = 'Заполните поле ввода пароля!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_group_id')) {
					$report[] = 'Заполните поле ввода группы!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_wallpost_tpl')) {
					$report[] = 'Заполните поле ввода шаблона сообщения для экспорта!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_image_size_x')) {
					$report[] = 'Укажите ширину изображения в настройках!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_image_size_y')) {
					$report[] = 'Укажите высоту изображения в настройках!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}    	
			    sleep(2);
                $p            = $this->model_catalog_ok_export->getProduct($product_id);
                $category_id  = $this->request->post['album'][$product_id];
				if (!$p['image']) {
                    $report[] = 'Товар "' . $p['name'] . '" не имеет изображения';
                    continue;
                }
				$name = $this->request->post['names'][$product_id];
                $image = trim($this->request->post['images'][$product_id]);
				if ($this->config->get('ok_export_photos_count') >= 1) {
				$this->load->model('tool/image');
        
				$product_images = $this->model_catalog_product->getProductImages($product_id);
				$images_in = array();
				$i = 1;
				foreach ($product_images as $img) {
					if (pathinfo($img['image'], PATHINFO_BASENAME) == $p['sku'] . '.jpg') {
						continue;
					}
					$i++;
					$img['image'] = $this->model_tool_image->resize($img['image'], $this->config->get('ok_export_image_size_x'), $this->config->get('ok_export_image_size_y'));
					$img['image'] = DIR_IMAGE . str_replace(HTTP_CATALOG, '', $img['image']);
					$img['image'] = str_replace('/image/image/', '/image/', $img['image']);
					$images_in[] = $img['image'];
				}
				}
                if ( !function_exists('curl_redir_exec') ) {
				function curl_redir_exec($curl, $redirects = 0) {
					curl_setopt($curl, CURLOPT_HEADER, true);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
					$data = curl_exec($curl);
					$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
					if (($http_code == 301 || $http_code == 302) && ++$redirects < 20) {
						preg_match('/(Location:|URI:)(.*?)\n/', $data, $matches);
						if (isset($matches[2])) {
							$redirect_url = trim($matches[2]);
							if ($redirect_url !== '') {
								curl_setopt($curl, CURLOPT_URL, $redirect_url);
								return curl_redir_exec($curl, $redirects);
							}
						}
					}
					return $data;
				}
                }
                $cookie = tempnam(DIR_CACHE, 'cookie');
                if( $curl = curl_init() ) {
                curl_setopt($curl, CURLOPT_URL, 'http://m.odnoklassniki.ru');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'form action="')+13;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, 'http://m.odnoklassniki.ru');
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.needCaptcha=&fr.login=".$login."&fr.password=".$password."&button_login=%D0%92%D0%BE%D0%B9%D1%82%D0%B8");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                if (strpos($out,'Неверный логин или пароль')===false)
                {
				    $out = curl_redir_exec($curl);
                } else {
					$report[] = 'Неверный логин или пароль для входа в одноклассники!';
					
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
                if (strpos($out,'Безопасность - это ОК')===false)
                {
				    $out = curl_redir_exec($curl);
                } else {
					$report[] = 'Ваш аккаунт временно заблокирован. Требуется пройти авторизацию по смс! Вверху страницы нажмите на кнопку "Настройки" и выберите пункт "Проверка доступности аккаунта"';
					
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru/dk?st.cmd=altGroupCreateMediaTopic&st.groupId=$number_group";
				$linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
				curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'/dk?st.cmd=altGroupEditMediaTopicText');
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
				$linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
				curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'<form action="')+14;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.msg=".$name."&button_save=%D0%A1%D0%BE%D1%85%D1%80%D0%B0%D0%BD%D0%B8%D1%82%D1%8C");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
				$out = curl_redir_exec($curl);
				if ($this->config->get('ok_export_photos_hoved') >= 1) {
				$out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                $temp_pos_st = strpos($out,'http://up.odnoklassniki.ru');
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                $post = array("fr.uf.posted"=>"set",
                    "fr.photoFile"=>"@".$image,
	            ); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
				$out = curl_redir_exec($curl);
				}
                $out = curl_redir_exec($curl);
				if ($this->config->get('ok_export_photos_count') >= 1) {
				foreach ($images_in as $img) {
                $out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                $temp_pos_st = strpos($out,'http://up.odnoklassniki.ru');
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = str_replace("&amp;","&",$linka);
                curl_setopt($curl, CURLOPT_URL, $linka);
 	            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	            curl_setopt($curl, CURLOPT_REFERER, $old_linka);
	            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
	            curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                $post = array("fr.uf.posted"=>"set",
                    "fr.photoFile"=>"@".$img,
	            ); 
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
				}
				}
				$out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
	            $temp_pos_st = strpos($out,'/dk?bk=MediaTopicForm');
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                $linka = 'http://m.odnoklassniki.ru'.str_replace("&amp;","&",$linka);
	            $temp_pos_st = strpos($out,'tfr.topicId" value="')+20;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $old_linka = $linka;
                $cod_val = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.photoFile=&button_save=%D0%A1%D0%BE%D0%B7%D0%B4%D0%B0%D1%82%D1%8C+%D1%82%D0%B5%D0%BC%D1%83&tfr.sf.posted=set&tfr.topicId=".$cod_val);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
				curl_setopt($curl, CURLOPT_POSTFIELDS, "");
				$old_linka = $linka;
                $linka = 'http://m.odnoklassniki.ru/dk?bk=Logoff&st.cmd=logoff&_prevCmd=logoff';
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&button_logoff=%D0%92%D1%8B%D0%B9%D1%82%D0%B8");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "");
                curl_close($curl);
				}
                $error              = false;
                $this->errorMessage = '';
                if (!$this->makeLoadWall($product_id, $p, $category_id)) {
                    $error = true;
                }
                if ($this->errorMessage) {
                    $report[] = $this->errorMessage;
                }
                if (!$error) {
                    $success++;
                }
                $this->writeProgress($success);
            }
            $msg              = '';
            $ok_export_report = array();
            if ($success) {
                $msg                         = $this->language->get('text_ok_wallpost_success');
                $msg                         = sprintf($msg, $success, $total);
                $ok_export_report['success'] = $msg;
            }
            if ($report) {
                $ok_export_report['warning'] = implode('<br>', $report);
            }
            if ($ok_export_report) {
                $this->cache->set('ok_export_report', $ok_export_report);
            }
            $url = '';
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }
            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model=' . $this->request->get['filter_model'];
            }
            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . $this->request->get['filter_price'];
            }
            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }
            if (isset($this->request->get['filter_category'])) {
                $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            if (isset($this->request->get['filter_export_albums'])) {
                $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
            }
            if (isset($this->request->get['filter_export_wall'])) {
                $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getList();
    }
	public function smscheck() 
	{
            $report  = array();
            $success = 0;
            $this->flushProgress();
            if ($this->validateOkExport()) {
			$login = trim($this->request->post['login']);
            $password = trim($this->request->post['password']);
			    if (!$this->config->get('ok_export_user_email')) {
					$report[] = 'Заполните поле ввода логина!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
			    if (!$this->config->get('ok_export_user_pass')) {
					$report[] = 'Заполните поле ввода пароля!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
			    if (!$this->config->get('ok_export_phone')) {
					$report[] = 'Заполните поле ввода телефона!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
			    if (!$this->config->get('ok_export_contry')) {
					$report[] = 'Выберите страну и нажмите кнопку сохранить настройки!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
				}
                if ( !function_exists('curl_redir_exec') ) {
				function curl_redir_exec($curl, $redirects = 0) {
					curl_setopt($curl, CURLOPT_HEADER, true);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
					$data = curl_exec($curl);
					$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
					if (($http_code == 301 || $http_code == 302) && ++$redirects < 10) {
						preg_match('/(Location:|URI:)(.*?)\n/', $data, $matches);
						if (isset($matches[2])) {
							$redirect_url = trim($matches[2]);
							if ($redirect_url !== '') {
								curl_setopt($curl, CURLOPT_URL, $redirect_url);
								return curl_redir_exec($curl, $redirects);
							}
						}
					}
					return $data;
				}
                }
                if (isset($this->request->post['code'])) {
				    $code = trim($this->request->post['code']);
					if( $curl = curl_init() ) {
					curl_setopt($curl, CURLOPT_URL, 'http://m.odnoklassniki.ru');
					curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
					curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
					curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
					curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
					$out = curl_redir_exec($curl);
					$temp_pos_st = strpos($out,'form action="')+13;
					$temp_pos_end = strpos($out,'"',$temp_pos_st);
					$linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
					curl_setopt($curl, CURLOPT_URL, $linka);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
					curl_setopt($curl, CURLOPT_REFERER, 'http://m.odnoklassniki.ru');
					curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
					curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
					curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
					curl_setopt($curl, CURLOPT_HEADER, true);
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.needCaptcha=&fr.login=".$login."&fr.password=".$password."&button_login=%D0%92%D0%BE%D0%B9%D1%82%D0%B8");
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
					$out = curl_redir_exec($curl);
					$temp_pos_st = strpos($out,'<form action="')+14;
					$temp_pos_end = strpos($out,'"',$temp_pos_st);
					$old_linka = $linka;
					$linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
					$linka = str_replace("&amp;","&",$linka);
					curl_setopt($curl, CURLOPT_URL, $linka);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
					curl_setopt($curl, CURLOPT_REFERER, $old_linka);
					curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
					curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
					curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
					curl_setopt($curl, CURLOPT_HEADER, true);
					curl_setopt($curl, CURLOPT_POST, true);
					curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.att=2&fr.code=".$code."&button_continue=%D0%9F%D1%80%D0%BE%D0%B4%D0%BE%D0%BB%D0%B6%D0%B8%D1%82%D1%8C");
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
					$out = curl_redir_exec($curl);
					
					$report[] = 'Вы успешно ввели код телефона, и прошли авторизацию!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['success'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
					
				    }
					curl_close($curl);
				}
                if( $curl = curl_init() ) {
                curl_setopt($curl, CURLOPT_URL, 'http://m.odnoklassniki.ru');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
                curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
                $out = curl_redir_exec($curl);
                $temp_pos_st = strpos($out,'form action="')+13;
                $temp_pos_end = strpos($out,'"',$temp_pos_st);
                $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
                curl_setopt($curl, CURLOPT_URL, $linka);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl, CURLOPT_REFERER, 'http://m.odnoklassniki.ru');
                curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
                curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
                curl_setopt($curl, CURLOPT_HEADER, true);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.needCaptcha=&fr.login=".$login."&fr.password=".$password."&button_login=%D0%92%D0%BE%D0%B9%D1%82%D0%B8");
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                $out = curl_redir_exec($curl);
                if (strpos($out,'Безопасность - это ОК')===false)
                {
					$report[] = 'Вы успешно авторизированы, ввод кода не требуется!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['success'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
                } else {
						$phone = trim($this->request->post['phone']);
						$contry = trim($this->request->post['contry']);
						$login = trim($this->request->post['login']);
						$password = trim($this->request->post['password']);
						curl_setopt($curl, CURLOPT_URL, 'http://m.odnoklassniki.ru');
						curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
						curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
						curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
						curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
						$out = curl_redir_exec($curl);
						$temp_pos_st = strpos($out,'form action="')+13;
						$temp_pos_end = strpos($out,'"',$temp_pos_st);
						$linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
						curl_setopt($curl, CURLOPT_URL, $linka);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
						curl_setopt($curl, CURLOPT_REFERER, 'http://m.odnoklassniki.ru');
						curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
						curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
						curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
						curl_setopt($curl, CURLOPT_HEADER, true);
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.needCaptcha=&fr.login=".$login."&fr.password=".$password."&button_login=%D0%92%D0%BE%D0%B9%D1%82%D0%B8");
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
						$out = curl_redir_exec($curl);
						if (strpos($out,'/dk?bk=PhoneRegistration')===false) {
						    $out = curl_redir_exec($curl);
						} else {
							$temp_pos_st = strpos($out,'/dk?bk=PhoneRegistration');
							$temp_pos_end = strpos($out,'"',$temp_pos_st);
							$old_linka = $linka;
							$linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
							$linka = 'http://m.odnoklassniki.ru'.str_replace("&amp;","&",$linka);
							curl_setopt($curl, CURLOPT_URL, $linka);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
							curl_setopt($curl, CURLOPT_REFERER, $old_linka);
							curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
							curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
							curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
							$out = curl_redir_exec($curl);
						}
                        $temp_pos_st = strpos($out,'/dk?st.cmd=selectPhoneCountry');
                        $temp_pos_end = strpos($out,'"',$temp_pos_st);
                        $old_linka = $linka;
                        $linka = substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
						$linka = 'http://m.odnoklassniki.ru'.str_replace("&amp;","&",$linka);
                        curl_setopt($curl, CURLOPT_URL, $linka);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                        curl_setopt($curl, CURLOPT_REFERER, $old_linka);
                        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
                        curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
                        curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
						$out = curl_redir_exec($curl);
						$temp_pos_st = strpos($out,'<form action="')+14;
						$temp_pos_end = strpos($out,'"',$temp_pos_st);
						$old_linka = $linka;
						$linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
						$linka = str_replace("&amp;","&",$linka);
						curl_setopt($curl, CURLOPT_URL, $linka);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
						curl_setopt($curl, CURLOPT_REFERER, $old_linka);
						curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
						curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
						curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
						curl_setopt($curl, CURLOPT_HEADER, true);
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.selCountry=".$contry."&button_select=%D0%A1%D0%BC%D0%B5%D0%BD%D0%B8%D1%82%D1%8C");
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
						$out = curl_redir_exec($curl);
						$temp_pos_st = strpos($out,'<form action="')+14;
						$temp_pos_end = strpos($out,'"',$temp_pos_st);
						$old_linka = $linka;
						$linka = "http://m.odnoklassniki.ru".substr($out,$temp_pos_st,$temp_pos_end-$temp_pos_st);
						$linka = str_replace("&amp;","&",$linka);
						curl_setopt($curl, CURLOPT_URL, $linka);
						curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
						curl_setopt($curl, CURLOPT_REFERER, $old_linka);
						curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla Firefox 3 (compatible; MSIE 6.0; LAS Linux)");
						curl_setopt($curl, CURLOPT_COOKIEJAR, DIR_CACHE."sms.txt");
						curl_setopt($curl, CURLOPT_COOKIEFILE, DIR_CACHE."sms.txt");
						curl_setopt($curl, CURLOPT_HEADER, true);
						curl_setopt($curl, CURLOPT_POST, true);
						curl_setopt($curl, CURLOPT_POSTFIELDS, "fr.posted=set&fr.phn=".$phone."&button_continue=%D0%9F%D1%80%D0%BE%D0%B4%D0%BE%D0%BB%D0%B6%D0%B8%D1%82%D1%8C");
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
						curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
						$out = curl_redir_exec($curl);
						if (strpos($out,'К сожалению, вы не прошли проверку по телефону')===false)
						{
						} else {
						
						$report[] = 'Ваш аккаунт заблокирован на 24 часа! Причина: неправильно ввели 3 раза код. Через 24 часа попробуйте снова!';
					
						$ok_export_report = array();
						if ($report) {
							$ok_export_report['warning'] = implode('<br>', $report);
						}
						if ($ok_export_report) {
							$this->cache->set('ok_export_report', $ok_export_report);
						}
						
						$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
						
						}
						
					    $report[] = 'Введите полученый код, который пришёл вам по СМС!<br />У вас есть три попытки ввода кода, если все три введены неверно, Вы будете заблокированы на сутки! Будте внимательны!<br /><form action="'.$this->url->link('extension/ok_export/smscheck', 'token=' . $this->session->data['token'], 'SSL').'" method="post"><input name="code" value="" /><input type="hidden" value="'.urlencode($this->config->get('ok_export_user_email')).'" name="login"><input type="hidden" value="'.urlencode($this->config->get('ok_export_user_pass')).'" name="password"><input type="hidden" value="'.$this->config->get('ok_export_phone').'" name="phone"><input type="hidden" value="'.$this->config->get('ok_export_contry').'" name="contry"><input type="submit" value="Отправить"></form>';
					
                        $ok_export_report = array();
					    if ($report) {
							$ok_export_report['warning'] = implode('<br>', $report);
						}
						if ($ok_export_report) {
							$this->cache->set('ok_export_report', $ok_export_report);
						}
						
						$this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));
						}
						curl_close($curl);
					}
				}
				$this->getList();
	}
    private function flushProgress()
    {
        $this->cache->set('ok_export_progress', 0);
    }
    private function writeProgress($val)
    {
        $this->cache->set('ok_export_progress', $val);
    }
    public function progress()
    {
        echo $this->cache->get('ok_export_progress');
        exit();
    }
    private function makeLoad($product_id, $rand, $category_id)
    {
        $rand = date('d.m.y H:i:u').rand(1, 10000000000);
        $this->model_catalog_ok_export->setProductExport($product_id, $rand, $category_id);
        return true;
    }
    private function sleep_export()
    {
        $rand = rand(6000000, 7500000);
    }
    private function makeLoadWall($product_id, $rand, $category_id)
    {
        $rand = date('d.m.y H:i:u').rand(1, 1000000000);
        $this->model_catalog_ok_export->setProductWallExport($product_id, $rand, $category_id);
        return true;
    }
    public function delete_single()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/ok_export');
        if (isset($this->request->get['photo_id']) && isset($this->request->get['location']) && isset($this->request->get['product_id']) && $this->validateOkExport()) {
            $product_id       = $this->request->get['product_id'];
            $photo_id         = $this->request->get['photo_id'];
            $p                = $this->model_catalog_ok_export->getProduct($product_id);
            $ok_export_report = array();
            if ($this->request->get['location'] == 'albums') {
                $p = explode('_', $photo_id);
                $this->model_catalog_ok_export->deleteAlbumsExportOne($product_id, $photo_id);
                $ok_export_report['success'] = $this->language->get('text_albums_export_deleted');
            } else {
                $p = explode('_', $photo_id);
                $this->model_catalog_ok_export->deleteWallExportOne($product_id, $photo_id);
                $ok_export_report['success'] = $this->language->get('text_wall_export_deleted');
            }
            if ($ok_export_report) {
                $this->cache->set('ok_export_report', $ok_export_report);
            }
            $url = '';
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }
            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model=' . $this->request->get['filter_model'];
            }
            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . $this->request->get['filter_price'];
            }
            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }
            if (isset($this->request->get['filter_category'])) {
                $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            if (isset($this->request->get['filter_export_albums'])) {
                $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
            }
            if (isset($this->request->get['filter_export_wall'])) {
                $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getList();
    }
    public function clear()
    {
		$dirPath = DIR_CACHE;
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath директория");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
			    continue;
			} else {
				unlink($file);
			}
		}
    }
    public function delete()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/ok_export');
        if (isset($this->request->post['selected']) && $this->validateOkExport()) {
            session_write_close();
            $success            = 0;
            $total_pics_deleted = 0;
            $total              = count($this->request->post['selected']);
            foreach ($this->request->post['selected'] as $product_id) {
                $p      = $this->model_catalog_ok_export->getProduct($product_id);
                $export = $this->model_catalog_ok_export->getAlbumsExport($product_id);
                foreach ($export as $photo) {
                    $total_pics_deleted++;
                }
                $this->model_catalog_ok_export->deleteAlbumsExport($product_id);
                $success++;
            }
            $msg                         = $this->language->get('text_ok_delete_success');
            $msg                         = sprintf($msg, $success, $total, $total_pics_deleted);
            $ok_export_report['success'] = $msg;
            $url                         = '';
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }
            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model=' . $this->request->get['filter_model'];
            }
            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . $this->request->get['filter_price'];
            }
            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }
            if (isset($this->request->get['filter_category'])) {
                $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            if (isset($this->request->get['filter_export_albums'])) {
                $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
            }
            if (isset($this->request->get['filter_export_wall'])) {
                $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getList();
    }
    public function delete_wall()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/ok_export');
        if (isset($this->request->post['selected']) && $this->validateOkExport()) {
            $success = 0;
            $total   = count($this->request->post['selected']);
            foreach ($this->request->post['selected'] as $product_id) {
                $p      = $this->model_catalog_ok_export->getProduct($product_id);
                $export = $this->model_catalog_ok_export->getWallExport($product_id);
                foreach ($export as $photo) {
                    $vp = explode('_', $photo['ok_photo_id']);
                }
                $this->model_catalog_ok_export->deleteWallExport($product_id);
                $success++;
            }
            $msg                            = $this->language->get('text_wall_delete_success');
            $msg                            = sprintf($msg, $success, $total);
            $this->session->data['success'] = $msg;
            $url                            = '';
            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . $this->request->get['filter_name'];
            }
            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model=' . $this->request->get['filter_model'];
            }
            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . $this->request->get['filter_price'];
            }
            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }
            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }
            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }
            if (isset($this->request->get['filter_category'])) {
                $url .= '&filter_category=' . $this->request->get['filter_category'];
            }
            if (isset($this->request->get['filter_export_albums'])) {
                $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
            }
            if (isset($this->request->get['filter_export_wall'])) {
                $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
            }
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        $this->getList();
    }
    public function export_history()
    {
        $this->load->language('extension/ok_export');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('catalog/ok_export');
        $url = '';
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }
        if (isset($this->request->get['filter_model'])) {
            $url .= '&filter_model=' . $this->request->get['filter_model'];
        }
        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price=' . $this->request->get['filter_price'];
        }
        if (isset($this->request->get['filter_quantity'])) {
            $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }
        if (isset($this->request->get['filter_category'])) {
            $url .= '&filter_category=' . $this->request->get['filter_category'];
        }
        if (isset($this->request->get['filter_export_albums'])) {
            $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
        }
        if (isset($this->request->get['filter_export_wall'])) {
            $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
        }
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        if ($this->request->get['type'] == 'albums') {
            $albums_export = array();
            $export        = $this->model_catalog_ok_export->getAlbumsExport($this->request->get['product_id']);
            foreach ($export as $case) {
                $albums_export_date = date('d.m.y H:i', strtotime($case['date']));
                $albums_category_id = $case['category_id'];
                $albums_export[]    = array(
                    'date' => $albums_export_date,
                    'category_id' => $albums_category_id,
                    'delete_link' => $this->url->link('extension/ok_export/delete_single', 'token=' . $this->session->data['token'] . '&location=albums&product_id=' . $this->request->get['product_id'] . '&photo_id=' . $case['ok_photo_id'] . $url, 'SSL')
                );
            }
            $this->data['export'] = $albums_export;
        } else {
            $wall_export = array();
            $export      = $this->model_catalog_ok_export->getWallExport($this->request->get['product_id']);
            foreach ($export as $case) {
                $wall_export_date = date('d.m.y H:i', strtotime($case['date']));
                $wall_category_id = $case['category_id'];
                $wall_export[]    = array(
                    'date' => $wall_export_date,
                    'category_id' => $wall_category_id,
                    'delete_link' => $this->url->link('extension/ok_export/delete_single', 'token=' . $this->session->data['token'] . '&location=wall&product_id=' . $this->request->get['product_id'] . '&photo_id=' . $case['ok_photo_id'] . $url, 'SSL')
                );
            }
            $this->data['export'] = $wall_export;
        }
        $this->template = 'extension/ok_export_history.tpl';
        $this->response->setOutput($this->render());
    }
	
    private function getList()
    {
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
            if (!isset($this->request->post['ok_export_photos_count'])) {
                $this->request->post['ok_export_photos_count'] = 0;
            }
            
            $this->model_setting_setting->editSetting('ok_export', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
            
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL'));

		}
				
		$this->data['heading_title'] = $this->language->get('heading_title');

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
		
        $this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['entry_user_email'] = $this->language->get('entry_user_email');
		$this->data['entry_user_pass'] = $this->language->get('entry_user_pass');
		$this->data['entry_nomeralb_id'] = $this->language->get('entry_nomeralb_id');
		$this->data['entry_nomeralbuser_id'] = $this->language->get('entry_nomeralbuser_id');
		$this->data['entry_products_per_page'] = $this->language->get('entry_products_per_page');
        $this->data['entry_group_id'] = $this->language->get('entry_group_id');
        $this->data['text_desc_tpl'] = $this->language->get('text_desc_tpl');
        $this->data['entry_wallpost_tpl'] = $this->language->get('entry_wallpost_tpl');
        $this->data['text_all'] = $this->language->get('text_all');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['entry_http_catalog'] = $this->language->get('entry_http_catalog');
        $this->data['text_desc_http_catalog'] = $this->language->get('text_desc_http_catalog');
        $this->data['entry_colums'] = $this->language->get('entry_colums');
        $this->data['text_model'] = $this->language->get('text_model');
        $this->data['text_price'] = $this->language->get('text_price');
        $this->data['text_quantity'] = $this->language->get('text_quantity');
        $this->data['text_status'] = $this->language->get('text_status');
        $this->data['text_date_added'] = $this->language->get('text_date_added');
        $this->data['entry_delete_out_of_stock'] = $this->language->get('entry_delete_out_of_stock');
        $this->data['entry_delete_disabled'] = $this->language->get('entry_delete_disabled');
        
		$this->data['action'] = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'], 'SSL');
		
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
        
        if (isset($this->request->post['ok_export_wallpost_tpl'])) {
			$this->data['ok_export_wallpost_tpl'] = $this->request->post['ok_export_wallpost_tpl'];
		} else {
			$this->data['ok_export_wallpost_tpl'] = $this->config->get('ok_export_wallpost_tpl');
		}
        
        if (isset($this->request->post['ok_export_products_per_page'])) {
			$this->data['ok_export_products_per_page'] = $this->request->post['ok_export_products_per_page'];
		} else {
			$this->data['ok_export_products_per_page'] = $this->config->get('ok_export_products_per_page');
		}
        
        if (isset($this->request->post['ok_export_http_catalog'])) {
			$this->data['ok_export_http_catalog'] = $this->request->post['ok_export_http_catalog'];
		} else {
			$this->data['ok_export_http_catalog'] = $this->config->get('ok_export_http_catalog');
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

        if (isset($this->request->post['ok_export_contry'])) {
			$this->data['ok_export_contry'] = $this->request->post['ok_export_contry'];
		} else {
            $this->data['ok_export_contry'] = $this->config->get('ok_export_contry');
		}
		
        if (isset($this->request->post['ok_export_phone'])) {
			$this->data['ok_export_phone'] = $this->request->post['ok_export_phone'];
		} else {
            $this->data['ok_export_phone'] = $this->config->get('ok_export_phone');
		}
		
        if (isset($this->request->post['ok_export_photos_count'])) {
			$this->data['ok_export_photos_count'] = $this->request->post['ok_export_photos_count'];
		} else {
            $this->data['ok_export_photos_count'] = $this->config->get('ok_export_photos_count');
		}
		
        if (isset($this->request->post['ok_export_photos_hoved'])) {
			$this->data['ok_export_photos_hoved'] = $this->request->post['ok_export_photos_hoved'];
		} else {
            $this->data['ok_export_photos_hoved'] = $this->config->get('ok_export_photos_hoved');
		}
		
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }
        if (isset($this->request->get['filter_model'])) {
            $filter_model = $this->request->get['filter_model'];
        } else {
            $filter_model = null;
        }
        if (isset($this->request->get['filter_price'])) {
            $filter_price = $this->request->get['filter_price'];
        } else {
            $filter_price = null;
        }
        if (isset($this->request->get['filter_quantity'])) {
            $filter_quantity = $this->request->get['filter_quantity'];
        } else {
            $filter_quantity = null;
        }
        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }
        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }
        if (isset($this->request->get['filter_category'])) {
            $filter_category = $this->request->get['filter_category'];
        } else {
            $filter_category = null;
        }
        if (isset($this->request->get['filter_export_albums'])) {
            $filter_export_albums = $this->request->get['filter_export_albums'];
        } else {
            $filter_export_albums = null;
        }
        if (isset($this->request->get['filter_export_wall'])) {
            $filter_export_wall = $this->request->get['filter_export_wall'];
        } else {
            $filter_export_wall = null;
        }
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'pd.name';
        }
        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        $url = '';
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }
        if (isset($this->request->get['filter_model'])) {
            $url .= '&filter_model=' . $this->request->get['filter_model'];
        }
        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price=' . $this->request->get['filter_price'];
        }
        if (isset($this->request->get['filter_quantity'])) {
            $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }
        if (isset($this->request->get['filter_category'])) {
            $url .= '&filter_category=' . $this->request->get['filter_category'];
        }
        if (isset($this->request->get['filter_export_albums'])) {
            $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
        }
        if (isset($this->request->get['filter_export_wall'])) {
            $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
        }
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $this->data['breadcrumbs']        = array();
        $this->data['breadcrumbs'][]      = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][]      = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );
        $this->data['ok_export']          = $this->url->link('extension/ok_export/export', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['ok_exportuser']      = $this->url->link('extension/ok_export/exportuser', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['ok_wallpost']        = $this->url->link('extension/ok_export/wallpost', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['ok_export_progress'] = $this->url->link('extension/ok_export/progress', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['ok_clear']           = $this->url->link('extension/ok_export/clear', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['ok_smscheck']        = $this->url->link('extension/ok_export/smscheck', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['ok_sms']             = $this->url->link('extension/ok_export/sms', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['ok_delete']          = $this->url->link('extension/ok_export/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['ok_delete_wall']     = $this->url->link('extension/ok_export/delete_wall', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['export_history']     = $this->url->link('extension/ok_export/export_history', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['products']           = array();
        $data                             = array(
            'filter_name' => $filter_name,
            'filter_model' => $filter_model,
            'filter_price' => $filter_price,
            'filter_quantity' => $filter_quantity,
            'filter_status' => $filter_status,
            'filter_date_added' => $filter_date_added,
            'filter_category' => $filter_category,
            'filter_export_albums' => $filter_export_albums,
            'filter_export_wall' => $filter_export_wall,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('ok_export_products_per_page'),
            'limit' => $this->config->get('ok_export_products_per_page')
        );
        $this->load->model('tool/image');
        $this->load->model('catalog/ok_export');
        $this->load->model('catalog/category');
        $categories     = $this->model_catalog_category->getCategories(0);
        $categories_tmp = array();
        foreach ($categories as $category) {
            $categories_tmp[$category['category_id']] = $category['name'];
        }
        $categories = $categories_tmp;
        unset($categories_tmp);
        $this->data['category_select'] = $this->createSelect($_GET, 'filter_category', array(
            '*' => ''
        ) + $categories);
        $categories                    = array(
            'Не выбран'
        ) + $categories;
        $results                       = $this->model_catalog_ok_export->getProducts($data);
        $product_total                 = $this->model_catalog_ok_export->getFoundRows($data);
        foreach ($results as $result) {

			if (isset($this->request->post['product_category'])) {
				$categories = $this->request->post['product_category'];
			} elseif (isset($result['product_id'])) {		
				$categories = $this->model_catalog_product->getProductCategories($result['product_id']);
			} else {
				$categories = array();
			}

			foreach ($categories as $category_id) {
				$category_info = $this->model_catalog_category->getCategory($category_id);
			}
            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
                $image = $this->model_tool_image->resize($result['image'], 40, 40);
            } else {
                $image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
            }
            if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
			    if (!$this->config->get('ok_export_image_size_x')) {
					$report[] = 'Укажите ширину изображения в настройках!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}
			    if (!$this->config->get('ok_export_image_size_y')) {
					$report[] = 'Укажите высоту изображения в настройках!';
                    $ok_export_report = array();
					if ($report) {
						$ok_export_report['warning'] = implode('<br>', $report);
					}
					if ($ok_export_report) {
						$this->cache->set('ok_export_report', $ok_export_report);
					}
					break;
				}				
                $eximage = $this->model_tool_image->resize($result['image'], $this->config->get('ok_export_image_size_x'), $this->config->get('ok_export_image_size_y'));
				$eximage = DIR_IMAGE . str_replace(HTTP_CATALOG, '', $eximage);
                $eximage = str_replace('/image/image/', '/image/', $eximage);
            } else {
                $eximage = $this->model_tool_image->resize('no_image.jpg', 200, 200);
            }
            $special          = false;
            $product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);
            foreach ($product_specials as $product_special) {
                if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
                    $special = $product_special['price'];
                    break;
                }
            }
            $albums_export      = array();
            $wall_export        = array();
            $export             = $this->model_catalog_ok_export->getExport($result['product_id']);
            $albums_category_id = false;
            foreach ($export as $case) {
                if ($case['location'] == 'albums') {
                    $albums_export_date = date('d.m.y H:i', strtotime($case['date']));
                    if (!$albums_category_id) {
                        $albums_category_id = $case['category_id'];
                    }
                    $albums_export[] = array(
                        'date' => $albums_export_date,
                        'category_id' => $albums_category_id,
                        'delete_link' => $this->url->link('extension/ok_export/delete_single', 'token=' . $this->session->data['token'] . '&location=albums&product_id=' . $result['product_id'] . '&photo_id=' . $case['ok_photo_id'] . $url, 'SSL')
                    );
                } else if ($case['location'] == 'wall') {
                    $wall_export_date = date('d.m.y H:i', strtotime($case['date']));
                    $wall_category_id = $case['category_id'];
                    $wall_export[]    = array(
                        'date' => $wall_export_date,
                        'category_id' => $wall_category_id,
                        'delete_link' => $this->url->link('extension/ok_export/delete_single', 'token=' . $this->session->data['token'] . '&location=wall&product_id=' . $result['product_id'] . '&photo_id=' . $case['ok_photo_id'] . $url, 'SSL')
                    );
                }
            }
            $selected_album = 0;
            if ($filter_category) {
                $selected_album = $filter_category;
            } else if ($albums_category_id) {
                $selected_album = $albums_category_id;
            } else if (method_exists($this->model_catalog_product, 'getProductMainCategoryId')) {
                $selected_album = $this->model_catalog_product->getProductMainCategoryId($result['product_id']);
            }
            if (!$selected_album) {
                $product_categories = $this->model_catalog_product->getProductCategories($result['product_id']);
                $selected_album     = array_pop($product_categories);
            }
			
			$lang_id = $this->config->get('config_language_id');
			
            $this->load->model('catalog/attribute');
            $attributes_data = $this->model_catalog_product->getProductAttributes($result['product_id']);
            $attributes = array();
            foreach ($attributes_data as $attr) {
				$attr_desc = $this->model_catalog_attribute->getAttributeDescriptions($attr['attribute_id']);
				$attr_name = (isset($attr_desc[$lang_id])) ? $attr_desc[$lang_id] : reset($attr_desc);
				$attr_name = $attr_name['name'];
				if (isset($attr['product_attribute_description'][$lang_id]['text'])) {
					$attr_value = $attr['product_attribute_description'][$lang_id]['text'];
				}
				else {
					$attr_value = reset($attr['product_attribute_description']);
					$attr_value = $attr_value['text'];
				}
				$attributes[] = str_replace(array('{name}', '{value}'), array($attr_name, $attr_value), '{name}: {value}');
			}
			$attributes = implode(',', $attributes);
			$attributes = str_replace('{br}', PHP_EOL, $attributes);

			$this->load->model('catalog/option');
			$options = $this->model_catalog_product->getProductOptions($result['product_id']);
			$options_output = '';
			foreach ($options as $opt) {
			if (!isset($opt['product_option_value'])) {
				continue;
			}
			$option_desc = $this->model_catalog_option->getOptionDescriptions($opt['option_id']);
			$option_name = (isset($option_desc[$lang_id])) ? $option_desc[$lang_id] : reset($option_desc);
			$option_name = $option_name['name'];
			$options_output .= $option_name . ': ';
			$option_values = array();
				foreach ($opt['product_option_value'] as $opt_val) {
					$option_values[$opt_val['option_value_id']] = $this->model_catalog_ok_export->getProductOptionValueName($opt_val['option_value_id']);
				}
			sort($option_values);
			$options_output .= implode(', ', $option_values) . PHP_EOL;
			}
			if ($this->config->get('ok_export_http_catalog')) {
				$http_catalog = $this->config->get('ok_export_http_catalog');
            } else {
                $http_catalog = HTTP_CATALOG;
            }
			$category_id = false;
			if (method_exists($this->model_catalog_product, 'getProductMainCategoryId')) {
				$category_id = $this->model_catalog_product->getProductMainCategoryId($result['product_id']);
			}
			$p = $this->model_catalog_ok_export->getProduct($result['product_id']);

            $link = $http_catalog . 'index.php?route=product/product&product_id=' . $result['product_id'];
            if ($this->config->get('config_seo_url') && isset($category_id) && $p['keyword']) {
                $link = $http_catalog;
                if ($this->config->get('config_seo_url_include_path') !== 0) {
                    $category = $this->model_catalog_category->getCategory($category_id);
                    $tmpcat   = array();
                    if (isset($category['keyword'])) {
                        if ($category['keyword']) {
                            $tmpcat[] = urlencode($category['keyword']);
                        }
                    }
                    if (isset($category['parent_id'])) {
                        while ($category['parent_id']) {
                            $category = $this->model_catalog_category->getCategory($category['parent_id']);
                            if ($category['keyword']) {
                                $tmpcat[] = urlencode($category['keyword']);
                            }
                        }
                    }
                    if ($tmpcat) {
                        $link .= implode('/', array_reverse($tmpcat)) . '/';
                    }
                }
                $link .= urlencode($p['keyword']) . $this->config->get('config_seo_url_postfix');
            }
			$p['price'] = $this->currency->format($p['price']);
			$special = false;
			$product_specials = $this->model_catalog_product->getProductSpecials($p['product_id']);
			foreach ($product_specials  as $product_special) {
				if ($product_special['customer_group_id'] != 1) continue;
			
				if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d'))
					&& ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
					$special = $product_special['price'];
        
					break;
				}					
			}
			if ($special) {
				$special = $this->currency->format($special);
				$special_text = $this->language->get('text_ok_export_special_price');
				$special_text = sprintf($special_text, $special, $p['price']);
			}
			else {
				$special_text = $this->language->get('text_price').$p['price'];
			}
            $vars                     = array(
                '{base_price}' => $p['price'],
                '{name}' => $result['name'],
                '{model}' => $result['model'],
                '{desc}' => $result['description'],
                '{attr}' => $attributes,
                '{options}' => $options_output,
                '{link}' => $link,
                '{stock}' => $result['quantity'],
				'{producer}' => $p['manufacturer'],
                '{price}' => $special_text,
                '{meta_description}' => $result['meta_description']
            );
            $message                  = str_replace(array_keys($vars), array_values($vars), $this->config->get('ok_export_wallpost_tpl'));
            $message                  = strip_tags(html_entity_decode($message, ENT_COMPAT, 'UTF-8'));
            $message                  = str_replace(array(
                '&nbsp;'
            ), array(
                ' '
            ), $message);
            $this->data['products'][] = array(
                'product_id' => $result['product_id'],
                'names' => $result['name'],
				'name' => $message,
                'model' => $result['model'],
                'price' => $this->currency->format($result['price']),
                'date_added' => date('d.m.y', strtotime($result['date_added'])),
                'href' => $this->url->link('catalog/product/update', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'], 'SSL'),
                'special' => $special,
				'smallimg' => $image,
                'image' => $eximage,
                'quantity' => $result['quantity'],
                'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                'albums_export' => $albums_export,
                'wall_export' => $wall_export,
                'selected' => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
				'category' => $category_info['name'],
				'category_id' =>  $category_info['category_id'],
            );
        }
        $this->data['heading_title']      = $this->language->get('heading_title');
        $this->data['text_enabled']       = $this->language->get('text_enabled');
        $this->data['text_disabled']      = $this->language->get('text_disabled');
        $this->data['text_no_results']    = $this->language->get('text_no_results');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
        $this->data['text_ok_export_off'] = $this->language->get('text_ok_export_off');
        $this->data['text_ok_export_on']  = $this->language->get('text_ok_export_on');
        $this->data['column_image']       = $this->language->get('column_image');
        $this->data['column_name']        = $this->language->get('column_name');
        $this->data['column_model']       = $this->language->get('column_model');
        $this->data['column_price']       = $this->language->get('column_price');
        $this->data['column_quantity']    = $this->language->get('column_quantity');
        $this->data['column_status']      = $this->language->get('column_status');
        $this->data['column_date_added']  = $this->language->get('column_date_added');
        $this->data['column_ok_export']   = $this->language->get('column_ok_export');
        $this->data['column_action']      = $this->language->get('column_action');
        $this->data['column_album']       = $this->language->get('column_album');
        $this->data['column_albums']      = $this->language->get('column_albums');
        $this->data['column_wall']        = $this->language->get('column_wall');
        $this->data['button_delete']      = $this->language->get('button_delete');
        $this->data['button_filter']      = $this->language->get('button_filter');
        $this->data['token']              = $this->session->data['token'];
        $this->data['success']            = '';
        $this->data['warning']            = '';
        if ($report = $this->cache->get('ok_export_report')) {
            if (isset($report['success'])) {
                $this->data['success'] = $report['success'];
            }
            if (isset($report['warning'])) {
                $this->data['warning'] = $report['warning'];
            }
            $this->cache->delete('ok_export_report');
        }
        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];
            unset($this->session->data['success']);
        }
        if (isset($this->session->data['warning'])) {
            $this->data['warning'] = $this->session->data['warning'];
            unset($this->session->data['warning']);
        }
        $url = '';
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }
        if (isset($this->request->get['filter_model'])) {
            $url .= '&filter_model=' . $this->request->get['filter_model'];
        }
        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price=' . $this->request->get['filter_price'];
        }
        if (isset($this->request->get['filter_quantity'])) {
            $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }
        if (isset($this->request->get['filter_category'])) {
            $url .= '&filter_category=' . $this->request->get['filter_category'];
        }
        if (isset($this->request->get['filter_export_albums'])) {
            $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
        }
        if (isset($this->request->get['filter_export_wall'])) {
            $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
        }
        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }
        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }
        $this->data['sort_name']          = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
        $this->data['sort_model']         = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, 'SSL');
        $this->data['sort_price']         = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
        $this->data['sort_quantity']      = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
        $this->data['sort_status']        = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
        $this->data['sort_date_added']    = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=p.date_added' . $url, 'SSL');
        $this->data['sort_export_albums'] = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=export_albums' . $url, 'SSL');
        $this->data['sort_export_wall']   = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=export_wall' . $url, 'SSL');
        $this->data['sort_order']         = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');
        $url                              = '';
        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . $this->request->get['filter_name'];
        }
        if (isset($this->request->get['filter_model'])) {
            $url .= '&filter_model=' . $this->request->get['filter_model'];
        }
        if (isset($this->request->get['filter_price'])) {
            $url .= '&filter_price=' . $this->request->get['filter_price'];
        }
        if (isset($this->request->get['filter_quantity'])) {
            $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
        }
        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }
        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }
        if (isset($this->request->get['filter_category'])) {
            $url .= '&filter_category=' . $this->request->get['filter_category'];
        }
        if (isset($this->request->get['filter_export_albums'])) {
            $url .= '&filter_export_albums=' . $this->request->get['filter_export_albums'];
        }
        if (isset($this->request->get['filter_export_wall'])) {
            $url .= '&filter_export_wall=' . $this->request->get['filter_export_wall'];
        }
        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }
        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        $pagination                         = new Pagination();
        $pagination->total                  = $product_total;
        $pagination->page                   = $page;
        $pagination->limit                  = $this->config->get('ok_export_products_per_page');
        $pagination->text                   = $this->language->get('text_pagination');
        $pagination->url                    = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        $this->data['pagination']           = $pagination->render();
        $this->data['filter_name']          = $filter_name;
        $this->data['filter_model']         = $filter_model;
        $this->data['filter_price']         = $filter_price;
        $this->data['filter_quantity']      = $filter_quantity;
        $this->data['filter_status']        = $filter_status;
        $this->data['filter_date_added']    = $filter_date_added;
        $this->data['filter_category']      = $filter_category;
        $this->data['filter_export_albums'] = $filter_export_albums;
        $this->data['filter_export_wall']   = $filter_export_wall;
        $this->data['sort']                 = $sort;
        $this->data['order']                = $order;
        $this->data['clear_extra']          = $this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url . '&clear_extra');
        $this->data['hide_clear_extra']     = '';
        $this->data['extra_album_error']    = '';
        if (isset($this->error['extra_album_error'])) {
            $this->data['extra_album_error'] = $this->error['extra_album_error'];
        }
        if (isset($this->request->get['clear_extra'])) {
            unset($this->session->data['ok_export_extra_settings']);
            unset($this->session->data['ok_export_extra_album']);
            $this->redirect($this->url->link('extension/ok_export', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }
        if (isset($this->session->data['ok_export_extra_settings'])) {
            $this->data['extra_settings'] = '';
            $this->data['extra_album']    = htmlentities($this->session->data['ok_export_extra_album']);
        } else {
            $this->data['extra_album']      = '';
            $this->data['extra_settings']   = 'display:none;';
            $this->data['hide_clear_extra'] = ' style="display:none;"';
        }
        $this->data['show_column_model']      = $this->config->get('ok_export_column_model');
        $this->data['show_column_price']      = $this->config->get('ok_export_column_price');
        $this->data['show_column_quantity']   = $this->config->get('ok_export_column_quantity');
        $this->data['show_column_status']     = $this->config->get('ok_export_column_status');
        $this->data['show_column_date_added'] = $this->config->get('ok_export_column_date_added');
        $this->template                       = 'extension/ok_export.tpl';
        $this->children                       = array(
            'common/header',
            'common/footer'
        );
        $this->response->setOutput($this->render());
    }
    private function validateOkExport()
    {
        if (!$this->user->hasPermission('modify', 'extension/ok_export')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }
    private function createSelect($source, $name, $options, $key = false, $extra = false, $default = false)
    {
        if (!$key) {
            $key = $name;
        }
        $output      = "<select name=\"$name\" " . ((isset($extra['attributes'])) ? $extra['attributes'] : '') . ">\n";
        $current_val = (isset($source[$key])) ? $source[$key] : ($default ? $default : false);
        foreach ($options as $opt_val => $opt_name) {
            $output .= "<option value=\"$opt_val\"";
            if ($current_val == $opt_val) {
                $output .= ' selected';
            }
            $output .= ">$opt_name</option>\n";
        }
        $output .= "</select>\n";
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
    public function autocomplete()
    {
        $json = array();
        if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
            $this->load->model('catalog/product');
            if (isset($this->request->get['filter_name'])) {
                $filter_name = $this->request->get['filter_name'];
            } else {
                $filter_name = '';
            }
            if (isset($this->request->get['filter_model'])) {
                $filter_model = $this->request->get['filter_model'];
            } else {
                $filter_model = '';
            }
            if (isset($this->request->get['filter_category_id'])) {
                $filter_category_id = $this->request->get['filter_category_id'];
            } else {
                $filter_category_id = '';
            }
            if (isset($this->request->get['filter_sub_category'])) {
                $filter_sub_category = $this->request->get['filter_sub_category'];
            } else {
                $filter_sub_category = '';
            }
            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 20;
            }
            $data    = array(
                'filter_name' => $filter_name,
                'filter_model' => $filter_model,
                'filter_category_id' => $filter_category_id,
                'filter_sub_category' => $filter_sub_category,
                'start' => 0,
                'limit' => $limit
            );
            $results = $this->model_catalog_product->getProducts($data);
            foreach ($results as $result) {
                $option_data     = array();
                $product_options = $this->model_catalog_product->getProductOptions($result['product_id']);
                foreach ($product_options as $product_option) {
                    if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
                        $option_value_data = array();
                        foreach ($product_option['product_option_value'] as $product_option_value) {
                            $option_value_data[] = array(
                                'product_option_value_id' => $product_option_value['product_option_value_id'],
                                'option_value_id' => $product_option_value['option_value_id'],
                                'price' => (float) $product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
                                'price_prefix' => $product_option_value['price_prefix']
                            );
                        }
                        $option_data[] = array(
                            'product_option_id' => $product_option['product_option_id'],
                            'option_id' => $product_option['option_id'],
                            'name' => $product_option['name'],
                            'type' => $product_option['type'],
                            'option_value' => $option_value_data,
                            'required' => $product_option['required']
                        );
                    } else {
                        $option_data[] = array(
                            'product_option_id' => $product_option['product_option_id'],
                            'option_id' => $product_option['option_id'],
                            'name' => $product_option['name'],
                            'type' => $product_option['type'],
                            'option_value' => $product_option['option_value'],
                            'required' => $product_option['required']
                        );
                    }
                }
                $json[] = array(
                    'product_id' => $result['product_id'],
                    'name' => html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'),
                    'model' => $result['model'],
                    'option' => $option_data,
                    'price' => $result['price']
                );
            }
        }
        $this->response->setOutput(json_encode($json));
    }
}
?>