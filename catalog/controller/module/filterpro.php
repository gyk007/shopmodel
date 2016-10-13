<?php
class ControllerModuleFilterPro extends Controller {
	private $k = 1;

	protected function index($setting) {
		if($setting['type'] == 1) {
			$this->language->load('product/filter');
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_list'] = $this->language->get('text_list');
			$this->data['text_grid'] = $this->language->get('text_grid');
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');

			$sort = 'p.sort_order';
			$order = 'ASC';
			$limit = $this->config->get('config_catalog_limit');

			$url = '';

			if(isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->data['sorts'] = array();

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href' => $this->url->link('product/filter', 'sort=p.sort_order&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href' => $this->url->link('product/filter', 'sort=pd.name&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href' => $this->url->link('product/filter', 'sort=pd.name&order=DESC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href' => $this->url->link('product/filter', 'sort=p.price&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href' => $this->url->link('product/filter', 'sort=p.price&order=DESC' . $url)
			);

			if($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href' => $this->url->link('product/filter', 'sort=rating&order=DESC' . $url)
				);

				$this->data['sorts'][] = array(
					'text' => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href' => $this->url->link('product/filter', 'sort=rating&order=ASC' . $url)
				);
			}

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href' => $this->url->link('product/filter', 'sort=p.model&order=ASC' . $url)
			);

			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href' => $this->url->link('product/filter', 'sort=p.model&order=DESC' . $url)
			);

			$url = '';

			if(isset($this->request->get['sort'])) {
				$url .= 'sort=' . $this->request->get['sort'];
			}

			if(isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$this->data['limits'] = array();

			$this->data['limits'][] = array(
				'text' => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href' => $this->url->link('product/filter', $url . '&limit=' . $this->config->get('config_catalog_limit'))
			);

			$this->data['limits'][] = array(
				'text' => 25,
				'value' => 25,
				'href' => $this->url->link('product/filter', $url . '&limit=25')
			);

			$this->data['limits'][] = array(
				'text' => 50,
				'value' => 50,
				'href' => $this->url->link('product/filter', $url . '&limit=50')
			);

			$this->data['limits'][] = array(
				'text' => 75,
				'value' => 75,
				'href' => $this->url->link('product/filter', $url . '&limit=75')
			);

			$this->data['limits'][] = array(
				'text' => 100,
				'value' => 100,
				'href' => $this->url->link('product/filter', $url . '&limit=100')
			);


			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;

			if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filterpro_container.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/filterpro_container.tpl';
			} else {
				$this->template = 'default/template/module/filterpro_container.tpl';
			}
		} else {
			$this->language->load('module/filterpro');

			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');
			$this->data['text_price_range'] = $this->language->get('text_price_range');
			$this->data['text_manufacturers'] = $this->language->get('text_manufacturers');
			$this->data['text_tags'] = $this->language->get('text_tags');
			$this->data['text_categories'] = $this->language->get('text_categories');
			$this->data['text_attributes'] = $this->language->get('text_attributes');
			$this->data['text_all'] = $this->language->get('text_all');
			$this->data['clear_filter'] = $this->language->get('clear_filter');
			$this->data['text_instock'] = $this->language->get('text_instock');

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['pds_sku'] = $this->language->get('pds_sku');
			$this->data['pds_upc'] = $this->language->get('pds_upc');
			$this->data['pds_location'] = $this->language->get('pds_location');
			$this->data['pds_model'] = $this->language->get('pds_model');
			$this->data['pds_brand'] = $this->language->get('pds_brand');
			$this->data['pds_stock'] = $this->language->get('pds_stock');
			$this->data['symbol_right'] = $this->currency->getSymbolRight();
			$this->data['symbol_left'] = $this->currency->getSymbolLeft();

			$this->data['setting'] = $setting;

			if(VERSION == '1.5.0') {
				$filterpro_setting = unserialize($this->config->get('filterpro_setting'));
			} else {
				$filterpro_setting = $this->config->get('filterpro_setting');
			}

			$category_id = false;
			$this->data['path'] = "";
			if(isset($this->request->get['path'])) {
				$this->data['path'] = $this->request->get['path'];
				$parts = explode('_', (string)$this->request->get['path']);
				$category_id = array_pop($parts);
			}

			$manufacturer_id = false;
			if(isset($this->request->get['manufacturer_id'])) {
				$manufacturer_id = $this->request->get['manufacturer_id'];
			$data = array(
					'filter_manufacturer_id' => $this->request->get['manufacturer_id']
				);
			} else {
				$data = array(
				'filter_category_id' => $category_id,
				'filter_sub_category' => false
			);
			}

			$this->load->model('catalog/product');
			$product_total = $this->model_catalog_product->getTotalProducts($data);
			if($product_total < 2) {
				return;
			}

			$this->data['category_id'] = $category_id;

			$data = array('category_id' => $category_id, 'manufacturer_id' => $manufacturer_id);

			$this->load->model('module/filterpro');

			$this->data['manufacturers'] = false;
			if(isset($this->request->get['manufacturer_id'])) {
				$this->data['manufacturer_id'] = $this->request->get['manufacturer_id'];
			} else {
				if($filterpro_setting['display_manufacturer'] != 'none') {
					$this->data['manufacturers'] = $this->model_module_filterpro->getManufacturers($data);
					$this->data['display_manufacturer'] = $filterpro_setting['display_manufacturer'];
					$this->data['expanded_manufacturer'] = isset($filterpro_setting['expanded_manufacturer']) ? 1 : 0;
				}
			}
			$this->data['options'] = $this->model_module_filterpro->getOptions($data);
			$this->load->model('tool/image');
			foreach($this->data['options'] as $i => $option) {
				if(!isset($filterpro_setting['display_option_' . $option['option_id']])) {
					$filterpro_setting['display_option_' . $option['option_id']] = 'none';
				}
				$display_option = $filterpro_setting['display_option_' . $option['option_id']];
				if($display_option != 'none') {
					$this->data['options'][$i]['display'] = $display_option;
					$this->data['options'][$i]['expanded'] = isset($filterpro_setting['expanded_option_' . $option['option_id']]) ? 1 : 0;
					foreach($this->data['options'][$i]['option_values'] as $j => $option_value) {
						$this->data['options'][$i]['option_values'][$j]['thumb'] = $this->model_tool_image->resize($this->data['options'][$i]['option_values'][$j]['image'], 20, 20);
					}
				} else {
					unset($this->data['options'][$i]);
				}
			}
			$this->data['tags'] = array();
			$version = array_map("intVal", explode(".", VERSION));
			if($version[2] < 4 && $filterpro_setting['display_tags'] != 'none') {
				$this->data['tags'] = $this->model_module_filterpro->getTags($data);
				$this->data['expanded_tags'] = isset($filterpro_setting['expanded_tags']) ? 1 : 0;
			}

			$this->data['categories'] = false;
			if($filterpro_setting['display_categories'] != 'none') {
				$this->data['categories'] = $this->model_module_filterpro->getSubCategories($data);
				$this->data['expanded_categories'] = isset($filterpro_setting['expanded_categories']) ? 1 : 0;
			}

			$this->data['attributes'] = $this->model_module_filterpro->getAttributes($data);


			foreach($this->data['attributes'] as $j => $attribute_group) {
				foreach($attribute_group['attribute_values'] as $attribute_id => $attribute) {
					if(!isset($filterpro_setting['display_attribute_' . $attribute_id])) {
						$filterpro_setting['display_attribute_' . $attribute_id] = 'none';
					}
					$display_attribute = $filterpro_setting['display_attribute_' . $attribute_id];
					if($display_attribute != 'none') {
						if($display_attribute == 'slider') {
							$values = $this->data['attributes'][$j]['attribute_values'][$attribute_id]['values'];
							$first = $values[0];
							$this->data['attributes'][$j]['attribute_values'][$attribute_id]['suffix'] = preg_replace("/^[0-9]*/", '', $first);

							$values = array_map('intVal', $values);
							$values = array_unique($values);
							sort($values);
							$this->data['attributes'][$j]['attribute_values'][$attribute_id]['values'] = $values;
						}
						$this->data['attributes'][$j]['attribute_values'][$attribute_id]['display'] = $display_attribute;
						$this->data['attributes'][$j]['attribute_values'][$attribute_id]['expanded'] = isset($filterpro_setting['expanded_attribute_' . $attribute_id])?1:0;
					} else {
						unset($this->data['attributes'][$j]['attribute_values'][$attribute_id]);
						if(!$this->data['attributes'][$j]['attribute_values']) {
							unset($this->data['attributes'][$j]);
						}
					}
				}
			}

			$this->data['price_slider'] = $filterpro_setting['price_slider'];
			$this->data['attr_group'] = $filterpro_setting['attr_group'];

			$this->data['instock_checked'] = isset($filterpro_setting['instock_checked']) ? 1 : 0;
			$this->data['instock_visible'] = isset($filterpro_setting['instock_visible']) ? 1 : 0;

			if($this->data['options'] || $this->data['manufacturers'] || $this->data['attributes'] || $this->data['price_slider']) {
				$this->document->addScript('catalog/view/javascript/jquery/jquery.tmpl.min.js');
				$this->document->addScript('catalog/view/javascript/jquery/jquery.deserialize.min.js');
				$this->document->addScript('catalog/view/javascript/jquery/jquery.loadmask.min.js');
				$this->document->addScript('catalog/view/javascript/filterpro.min.js');
				$this->document->addStyle('catalog/view/theme/default/stylesheet/filterpro.css');
				$this->document->addStyle('catalog/view/theme/default/stylesheet/jquery.loadmask.css');
			}

			if(file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/filterpro.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/filterpro.tpl';
			} else {
				$this->template = 'default/template/module/filterpro.tpl';
			}
		}
		$this->render();
	}

	private function array_clean(array $array) {
		foreach($array as $key => $value) {
			if(is_array($value)) {
				$array[$key] = $this->array_clean($value);
				if(!count($array[$key])) {
					unset($array[$key]);
				}
			} elseif(is_string($value)) {
				$value = trim($value);
				if(!$value) {
					unset($array[$key]);
				}
			}
		}
		return $array;
	}

	public function getProducts() {

		//		$cache = md5(http_build_query($this->request->post));
		//		$json = $this->cache->get('filterpro.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache);
		//		if(!$json) {

		$this->language->load('module/filterpro');

		if(VERSION == '1.5.0') {
			$filterpro_setting = unserialize($this->config->get('filterpro_setting'));
		} else {
			$filterpro_setting = $this->config->get('filterpro_setting');
		}


		if((float)$filterpro_setting['tax'] > 0) {
			$this->k = 1+(float)$filterpro_setting['tax']/100;
		}

		$page = 1;
		if(isset($this->request->post['page'])) {
			$page = (int)$this->request->post['page'];
		}

		if(isset($this->request->post['sort'])) {
			$sort = $this->request->post['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if(isset($this->request->post['order'])) {
			$order = $this->request->post['order'];
		} else {
			$order = 'ASC';
		}

		if(isset($this->request->post['limit'])) {
			$limit = $this->request->post['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}


		$this->load->model('module/filterpro');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$manufacturer = false;
		if(isset($this->request->post['manufacturer'])) {
			$manufacturer = $this->array_clean($this->request->post['manufacturer']);
			if(!count($manufacturer)) {
				$manufacturer = false;
			}
		}
		$manufacturer_id = false;
		if(isset($this->request->post['manufacturer_id'])) {
			$manufacturer_id = $this->request->post['manufacturer_id'];
			$manufacturer = array($manufacturer_id);
		}

		$option_value = false;
		if(isset($this->request->post['option_value'])) {
			$option_value = $this->array_clean($this->request->post['option_value']);
			if(!count($option_value)) {
				$option_value = false;
			}
		}

		$attribute_value = false;
		if(isset($this->request->post['attribute_value'])) {
			$attribute_value = $this->array_clean($this->request->post['attribute_value']);
			if(!count($attribute_value)) {
				$attribute_value = false;
			}
		}

		$instock = false;
		if(isset($this->request->post['instock'])) {
			$instock = true;
		}

		$tags = false;
		if(isset($this->request->post['tags'])) {
			$tags = $this->array_clean($this->request->post['tags']);
			if(!count($tags)) {
				$tags = false;
			}
		}

		$categories = false;
		if(isset($this->request->post['categories'])) {
			$categories = $this->array_clean($this->request->post['categories']);
			if(!count($categories)) {
				$categories = false;
			}
		}

		$category_id = 0;
		if(isset($this->request->post['category_id'])) {
			$category_id = $this->request->post['category_id'];
		}
		if(!$categories && $category_id) {
			$categories = array($category_id);
		}

		$attr_slider = isset($this->request->post['attr_slider']) ? $this->request->post['attr_slider'] : false;

        $data = array(
			'instock' => $instock,
			'option_value' => $option_value,
			'manufacturer' => $manufacturer,
			'attribute_value' => $attribute_value,
			'tags' => $tags,
			'categories' => $categories,
			'attr_slider' => $attr_slider,
			'min_price' => $this->request->post['min_price']/ $this->k,
			'max_price' => $this->request->post['max_price']/ $this->k,
			'start' => ($page - 1) * $limit,
			'limit' => $limit,
			'sort' => $sort,
			'order' => $order
		);

		$product_total = $this->model_module_filterpro->getTotalProducts($data);

		if(isset($this->request->post['manufacturer_id']) || ($filterpro_setting['display_manufacturer'] == 'none')) {
			$totals_manufacturers = false;
		} else {
			$totals_manufacturers = $this->model_module_filterpro->getTotalManufacturers($data);
		}

		$totals_options = $this->model_module_filterpro->getTotalOptions($data);

		$totals_attributes = $this->model_module_filterpro->getTotalAttributes($data);

		$version = array_map("intVal", explode(".", VERSION));
		if($version[2] >= 4) {
			$totals_tags = array();
		} else {
			$totals_tags = $this->model_module_filterpro->getTotalTags($data);
		}
		$totals_categories = $this->model_module_filterpro->getTotalCategories($data, $category_id);

		$products = $this->model_module_filterpro->getProducts($data);


		$result = array();

		$min_price = false;
		$max_price = false;

		if(isset($this->request->post['getPriceLimits']) && $this->request->post['getPriceLimits']) {
			$priceLimits = $this->model_module_filterpro->getPriceLimits(array('category_id' => $category_id, 'manufacturer_id' => $manufacturer_id));
			$min_price = $priceLimits['min_price'];
			$max_price = $priceLimits['max_price'];
		}

		foreach($products as $product) {
			if($product['image']) {
				$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
			} else {
				$image = false;
			}

			if(($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$price = false;
			}
			if((float)$product['special']) {
				$special = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id'], $this->config->get('config_tax')));
			} else {
				$special = false;
			}

			if($this->config->get('config_tax')) {
				$tax = $this->currency->format((float)$product['special'] ? $product['special'] : $product['price']);
			} else {
				$tax = false;
			}

			if($this->config->get('config_review_status')) {
				$rating = (int)$product['rating'];
			} else {
				$rating = false;
			}

			$description = function_exists('utf8_substr') ? utf8_substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..' :
					substr(strip_tags(html_entity_decode($product['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..';

			if($product['quantity'] <= 0) {
				$rstock = $product['stock_status'];
			} elseif($this->config->get('config_stock_display')) {
				$rstock = $product['quantity'];
			} else {
				$rstock = $this->language->get('text_instock');
			}

			$path = isset($this->request->post['path']) ? 'path=' . $this->request->post['path'] : '';

			$result[] = array(
				'sku' => $filterpro_setting['sku_display'] ? $product['sku'] : false,
				'model' => $filterpro_setting['model_display'] ? $product['model'] : false,
				'brand' => $filterpro_setting['brand_display'] ? $product['manufacturer'] : false,
				'location' => $filterpro_setting['location_display'] ? $product['location'] : false,
				'upc' => $filterpro_setting['upc_display'] ? $product['upc'] : false,
				'stock' => $filterpro_setting['stock_display'] ? $rstock : false,

				'product_id' => $product['product_id'],
				'image' => $image,
				'thumb' => $image,
				'special' => $special,
				'tax' => $tax,
				'rating' => $rating,
				'name' => $product['name'],
				'description' => $description,
				'price' => $price,
				'href' => $this->url->link('product/product', $path . '&product_id=' . $product['product_id'])
			);
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = 'page={page}';

		$min_price = $this->currency->convert($min_price* $this->k, $this->config->get('config_currency'), $this->currency->getCode());
		$max_price = $this->currency->convert($max_price* $this->k, $this->config->get('config_currency'), $this->currency->getCode());
		$json = json_encode(array('result' => $result, 'min_price' => $min_price, 'max_price' => $max_price, 'pagination' => $pagination->render(),
								 'totals_data' => array('manufacturers' => $totals_manufacturers,
														'options' => $totals_options,
														'attributes' => $totals_attributes,
														'categories' => $totals_categories,
														'tags' => $totals_tags)));

		//			$this->cache->set('filterpro.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $cache, $json);
		//		}

		$this->response->setOutput($json);
	}
}

?>