<?php
class ModelShippingDostavkaPlus extends Model {
    private $type = 'shipping';
    private $name = 'dostavkaplus';

    public function getQuote($address, $code = '') {
        $this->language->load($this->type . '/' . $this->name);

        $method_data = array();

        if ($this->config->get($this->name.'_status') == true) {
            $quote_data = array();

            $arr_lock = array();
            $arr_unlock = array();

            if (is_array($this->config->get($this->name.'_module')) and count($this->config->get($this->name.'_module')) > 0) {
                foreach($this->config->get($this->name.'_module') as $key => $module) {
                    $error = '';

                    if ($module['status'] == 1) {

                        if (isset($module['store']) and is_array($module['store']) and in_array((int)$this->config->get('config_store_id'), $module['store'])) {

                            $status = true;
                            $total = $this->cart->getSubTotal();

                            $weight = $this->weight->convert($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $module['weight_class_id']);

                            if (isset($module['geo_zone']) and is_array($module['geo_zone']) and count($module['geo_zone']) > 0 ) {

                                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone
                                    WHERE geo_zone_id IN (" . implode(',', $module['geo_zone']) . ") AND country_id = " . (int)$address['country_id'] . "
                                    AND (zone_id = " . (int)$address['zone_id'] . " OR zone_id = 0)");
                                if ($query->num_rows) {
                                    $status = true;
                                }
                                else {
                                    $status = false;

                                    if ($this->config->get($this->name.'_show_error_text') == 1) {
                                        $error = 'Не доступно в выбранном регионе.';
                                    }
                                }
                            }


                            if (!isset($module['min_weight'])) {
                                $module['min_weight'] = 0;
                            }

                            if (!isset($module['max_weight'])) {
                                $module['max_weight'] = 0;
                            }

                            $module['min_weight'] = (int)$module['min_weight'];
                            $module['max_weight'] = (int)$module['max_weight'];

                            if (($status == true or ($status == false and $error != '')) and
                                (
                                    ($module['min_weight'] > 0 and $module['max_weight'] > 0 and $weight >= $module['min_weight'] and $weight < $module['max_weight']) or
                                    ($module['min_weight'] > 0 and $module['max_weight'] == 0 and $weight >= $module['min_weight']) or
                                    ($module['max_weight'] > 0 and $module['min_weight'] == 0 and $weight < $module['max_weight']) or
                                    ($module['max_weight'] == 0 and $module['min_weight'] == 0)
                                )
                            ) {
                                if ($status == true) {
                                    $status = true;
                                }
                                else {
                                    $status = false;
                                }
                            }
                            else {
                                $status = false;
                            }


                            if (!isset($module['min_total'])) {
                                $module['min_total'] = 0;
                            }

                            if (!isset($module['max_total'])) {
                                $module['max_total'] = 0;
                            }

                            $module['min_total'] = (int)$module['min_total'];
                            $module['max_total'] = (int)$module['max_total'];

                            if ($status == true and
                                (
                                    ($module['min_total'] > 0 and $module['max_total'] > 0 and $total >= $module['min_total'] and $total < $module['max_total']) or
                                    ($module['min_total'] > 0 and $module['max_total'] == 0 and $total >= $module['min_total']) or
                                    ($module['max_total'] > 0 and $module['min_total'] == 0 and $total < $module['max_total']) or
                                    ($module['max_total'] == 0 and $module['min_total'] == 0)
                                )
                            ) {
                                $status = true;
                            }
                            else {
                                $status = false;
                            }


                            if ($status == true) {
                                $price = $module['price'];

                                if ($module['rate'] != '') {
                                    $rates = explode(',', $module['rate']);

                                    if (count($rates) > 0) {
                                        foreach ($rates as $rate) {
                                            $data = explode(':', $rate);

                                            $data[0] = trim($data[0]);

                                            if ($data[0] >= $weight) {
                                                if (isset($data[1])) {
                                                    $price = trim($data[1]);
                                                }

                                                break;
                                            }
                                        }
                                    }
                                }

                                if ($module['city_rate'] != '') {
                                    $rates = explode(',', $module['city_rate']);

                                    if (count($rates) > 0) {
                                        foreach ($rates as $rate) {
                                            $data = trim($rate);

                                            if (mb_strtolower($data, 'UTF-8') == mb_strtolower(trim($address['city']), 'UTF-8')) {
                                                $arr_lock[] = $key;
                                            }
                                        }
                                    }
                                }


                                if ($module['city_rate2'] != '') {
                                    $rates = explode(',', $module['city_rate2']);
                                    //print_r($rates);
                                    if (count($rates) > 0) {
                                        foreach ($rates as $rate) {
                                            $data = trim($rate);

                                            if (mb_strtolower($data, 'UTF-8') == mb_strtolower(trim($address['city']), 'UTF-8')) {
                                                $arr_unlock[] = $key;
                                            }
                                        }
                                    }
                                }


                                if (isset($module['cost']) and $module['cost'] != '') {
                                    $price = $price + (int)$module['cost'];
                                }

                                if (!isset($module['image'])) {
                                    $module['image'] = '';
                                }

                                $title = html_entity_decode($module['title'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');

                                if (isset($module['info'][$this->config->get('config_language_id')])) {
                                    $description = html_entity_decode($module['info'][$this->config->get('config_language_id')]);
                                }
                                else {
                                    $description = '';
                                }


                                if ($price == 0) {
                                    $text = $this->language->get('text_free');
                                }
                                else {
                                    $text = $this->currency->format($price);
                                }


                                if (($code == '' or $code == 'sh'.$key) and !in_array($key,$arr_lock)
                                    and (empty($module['city_rate2']) or (!empty($module['city_rate2']) and in_array($key,$arr_unlock)))
                                ) {
                                    $quote_data['sh'.$key] = array(
                                        'code'            => $this->name.'.sh'.$key,
                                        'title'           => $title,
                                        'image'           => $module['image'],
                                        'cost'            => $price,
                                        'description'     => $description,
                                        'tax_class_id'    => '',
                                        'sort_order'      => $module['sort_order'],
                                        'text'            => $text,
                                        'error'           => $error
                                    );
                                }
                            }
                        }
                    }
                }
            }


            if (isset($quote_data) and count($quote_data) > 0) {
                $sort_by = array();
                foreach ($quote_data as $key => $value) $sort_by[$key] = $value['sort_order'];
                array_multisort($sort_by, SORT_ASC, $quote_data);

                //print_r($quote_data);

                foreach ($quote_data as $q_data) {
                    $error = $q_data['error'];
                    break;
                }
            }


            if ((isset($quote_data) and count($quote_data) > 0) or $error != '') {
                $method_data = array(
                    'code'       => $this->name,
                    'title'      => html_entity_decode($this->config->get($this->name.'_name'), ENT_QUOTES, 'UTF-8'),
                    'quote'      => $quote_data,
                    'error'      => $error,
                    'sort_order' => $error ? ($this->config->get($this->name.'_sort_order') + 100) : $this->config->get($this->name.'_sort_order')
                );
            }
        }

        //print_r($method_data);

        return $method_data;
    }
}
?>