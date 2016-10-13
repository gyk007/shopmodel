<?php
class ControllerPaymentWebPay extends Controller {
	protected function index() {
    	$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');

		$this->data['wsb_test'] = 0; // 1 - for test

		if ($this->data['wsb_test'] == 1)
			$this->data['action'] = 'https://secure.sandbox.webpay.by'; // для тестовой среды
				else
			$this->data['action'] = 'https://payment.webpay.by'; // для реальной среды
  

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

		$this->load->language('payment/webpay');

		$this->data['sub_text_info'] = $this->language->get('sub_text_info');
		$this->data['sub_text_info_phone'] = $this->language->get('sub_text_info_phone');
       	$this->data['description'] = $this->config->get('config_store') . ' ' . $order_info['payment_firstname'] . ' ' . $order_info['payment_address_1'] . ' ' . $order_info['payment_address_2'] . ' ' . $order_info['payment_city'] . ' ' . $order_info['email'];
		$this->data['total_text'] = html_entity_decode($this->language->get('total_mes'), ENT_QUOTES, 'UTF-8');

		// Переменные

		$this->data['success_url'] = $this->config->get('webpay_success_url');
		$this->data['cancel_url'] = $this->config->get('webpay_fail_url'); 

		$this->data['notify_url'] = $this->config->get('webpay_result_url');

		$this->data['shop_mes'] = $this->config->get('webpay_shop_mes');


		$this->data['shop_id'] = $this->config->get('webpay_shop_id');
		$this->data['shop_name'] = $this->config->get('webpay_shop_name');
		$this->data['order_id'] = $this->session->data['order_id'];

		$this->data['currency_id'] = 'BYR';        
		$this->data['summ'] = $this->ConvertToByr($order_info['total'],$order_info['currency_code'],$this->data['currency_id'],$order_info['currency_value']);
		$this->data['com'] = html_entity_decode($this->data['description'], ENT_QUOTES, 'UTF-8');
		$this->data['lifetime'] = $this->config->get('webpay_lifetime');

		srand ((int)((double)microtime()*1000003));

		$this->data['seed'] = rand();

		$this->data['hash'] = $this->CreateAuthorizationKey ($this->data['seed'],$this->data['shop_id'],$this->data['order_id'],$this->data['wsb_test'],$this->data['currency_id'],$this->data['summ'],$this->config->get('webpay_shop_key') );


		if ($this->cart->hasShipping())
		{
			$this->data['wsb_shipping_price'] = $this->ConvertToByr($this->session->data['shipping_method']['cost'],$order_info['currency_code'],$this->data['currency_id'],$order_info['currency_value']);
			$this->data['wsb_shipping_name'] = $this->session->data['shipping_method']['title'];
		}
		else
		{
			$this->data['wsb_shipping_price'] = 0;
			$this->data['wsb_shipping_name'] = "";
		}


			$total_data = array();
			$total = 0;
			$taxes = $this->cart->getTaxes();
			 
			$this->load->model('setting/extension');
			
			$sort_order = array(); 
			
			$results = $this->model_setting_extension->getExtensions('total');
			
			foreach ($results as $key => $value) {
				$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
			}
			
			array_multisort($sort_order, SORT_ASC, $results);
			
			foreach ($results as $result) {
				if ($this->config->get($result['code'] . '_status')) {
					$this->load->model('total/' . $result['code']);
		
					$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
				}
			}
		
		$this->data['wsb_discount_price'] = 0;

		foreach ($total_data as $total) {       
			if ($total['code']=='coupon')
			$this->data['wsb_discount_price'] = $this->data['wsb_discount_price'] + $total['value'];
		 }

		$this->data['wsb_discount_price'] = abs($this->ConvertToByr($this->data['wsb_discount_price'],$order_info['currency_code'],$this->data['currency_id'],$order_info['currency_value']));


	
		$this->data['wsb_email'] = $order_info['email'];
		$this->data['wsb_phone'] = $order_info['telephone'];

		$products = $this->cart->getProducts();


		$this->data['wsb_invoice_item_name'] = "";
		$this->data['wsb_invoice_item_quantity'] = "";
		$this->data['wsb_invoice_item_price'] = "";


		$sub_total = 0;
		$i=0;
		foreach ($products as $product) 
		{ 
			$option_data = array();
	
			$this->data['wsb_invoice_item_name'] = $this->data['wsb_invoice_item_name'] . "<input type='hidden' name='wsb_invoice_item_name[" . $i . "]' value='" . $product['name'] . "'>" . "\r\n";
			$this->data['wsb_invoice_item_quantity'] = $this->data['wsb_invoice_item_quantity'] . "<input type='hidden' name='wsb_invoice_item_quantity[" . $i . "]' value='" . $product['quantity'] . "'>" . "\r\n";


			$byr_price = $this->ConvertToByr($product['price'],$order_info['currency_code'],$this->data['currency_id'],$order_info['currency_value']); 
			$this->data['wsb_invoice_item_price'] = $this->data['wsb_invoice_item_price'] . "<input type='hidden' name='wsb_invoice_item_price[" . $i . "]' value='" . $byr_price . "'>" . "\r\n";


			$sub_total = $sub_total + $product['quantity']*$byr_price;

			$i++;
		} 

		//$sub_total = $this->ConvertToByr($this->cart->getSubTotal(),$order_info['currency_code'],$this->data['currency_id'],$order_info['currency_value']);


		$this->data['wsb_tax'] =  $this->data['summ'] - $this->data['wsb_shipping_price'] - $sub_total;


		$this->data['return'] = HTTP_SERVER . 'index.php?route=checkout/success';


		$this->id = 'payment';

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/webpay.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/webpay.tpl';
		} else {
			$this->template = 'default/template/payment/webpay.tpl';
		}

		$this->render();
	}

	private function CreateAuthorizationKey ($wsb_seed,$wsb_storeid,$wsb_order_num,$wsb_test,$wsb_currency_id,$wsb_total,$SecretKey) { //функция вычисления электронной подписи
		// если версия не указана  
		$wsb_signature = md5($wsb_seed.$wsb_storeid.$wsb_order_num.$wsb_test.$wsb_currency_id.$wsb_total.$SecretKey);

		return $wsb_signature;
	}

	private function ConvertToByr ($price,$currency_code,$currency_id,$currency_value) {
		$_sub_total = $this->currency->convert($price, $currency_code, $currency_id);
		$sub_total = $this->currency->format($_sub_total, $currency_id, $currency_value, FALSE);

		return (int)$sub_total;
	}

	public function confirm() {

		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		if(!$order_info) return;

		$order_id = $this->session->data['order_id'];

		if( $order_info['order_status_id'] == 0) {
			$this->model_checkout_order->confirm($order_id, $this->config->get('webpay_order_status_progress_id'), 'webpay');
			return;
		}

		if( $order_info['order_status_id'] != $this->config->get('webpay_order_status_progress_id')) {
			$this->model_checkout_order->update($order_id, $this->config->get('webpay_order_status_progress_id'),'webpay',TRUE);
		}

   	}

	public function fail() {

		$this->redirect($this->url->link('checkout/checkout', '', 'SSL'));

		return TRUE;
	}

	public function success() {

		$this->redirect($this->url->link('checkout/success', '', 'SSL'));


		return TRUE;
	}

	private function CreateSignature ($batch_timestamp, $currency_id, $amount, $payment_method, $order_id, $site_order_id, $transaction_id, $payment_type, $rrn, $sek_key ) { //функция вычисления электронной подписи
		$_signature = md5($batch_timestamp.$currency_id.$amount.$payment_method.$order_id.$site_order_id.$transaction_id.$payment_type.$rrn.$sek_key);
		return $_signature;
	}

	public function callback() {


 		$batch_timestamp = $this->request->post['batch_timestamp']; //   - время совершения транзакции;  
		$currency_id = $this->request->post['currency_id']; 		//   - валюта транзакции (Примечание: представляет собой буквенный, трехзначный код в соответствии с ISO 4217 );  
		$amount = $this->request->post['amount'];				//   - сумма транзакции;  
		$payment_method = $this->request->post['payment_method'];   //   - метод совершения транзакции (возможные значения: cc банковская карточка, test - совершена без реального процессинга карточки); 
		$order_id = $this->request->post['order_id'];  			//   - номер заказа в системе webpay.by;  
		$site_order_id = $this->request->post['site_order_id'];     //   - номер (имя) заказа, присвоенное магазином;  
		$transaction_id = $this->request->post['transaction_id'];   //   - номер транзакции;  
		$payment_type = $this->request->post['payment_type'];       //   - тип транзакции;  
		$rrn = $this->request->post['rrn'];          			//   - номер транзакции в системе Visa/MasterCard;  
		$wsb_signature = $this->request->post['wsb_signature'];     //   - электронная подпись

		//$this->log->write('webpay ' . $batch_timestamp .' '. $currency_id .' '. $amount .' '. $payment_method .' '. $order_id .' '. $site_order_id .' '. $transaction_id .' '. $payment_type .' '. $rrn);

		if ($this->CreateSignature($batch_timestamp, $currency_id, $amount, $payment_method, $order_id, $site_order_id, $transaction_id, $payment_type, $rrn, $this->config->get('webpay_shop_key')) == $wsb_signature) 
		{
			$this->load->model('checkout/order');
			$order_info = $this->model_checkout_order->getOrder($site_order_id);
			if ( $order_info) {

				// Стутус проведения счета.
				if(($payment_type==1)||($payment_type==4)) {
					// выполнено
					if( $order_info['order_status_id'] == 0) {
						$this->model_checkout_order->confirm($site_order_id, $this->config->get('webpay_order_status_id'), 'webpay');
					}
		
					if( $order_info['order_status_id'] != $this->config->get('webpay_order_status_id')) {
						$this->model_checkout_order->update($site_order_id, $this->config->get('webpay_order_status_id'),'webpay',TRUE);
					}
				} elseif( ($payment_type==5)||($payment_type==7) ) {
					// не выполнено
					if( $order_info['order_status_id'] == 0) {
						$this->model_checkout_order->confirm($site_order_id, $this->config->get('webpay_order_status_cancel_id'), 'webpay');
				
					}
		
					if( $order_info['order_status_id'] != $this->config->get('webpay_order_status_cancel_id')) {
						$this->model_checkout_order->update($site_order_id, $this->config->get('webpay_order_status_cancel_id'),'webpay',TRUE);
					}
				} else {
					// выполняется
					if( $order_info['order_status_id'] == 0) {
						$this->model_checkout_order->confirm($site_order_id, $this->config->get('webpay_order_status_progress_id'), 'webpay');
					}
		
					if( $order_info['order_status_id'] != $this->config->get('webpay_order_status_progress_id')) {
						$this->model_checkout_order->update($site_order_id, $this->config->get('webpay_order_status_progress_id'),'webpay',TRUE);
					}
		
				}

			}
			else
				{
					$this->log->write('webpay ошибка номера заказа ' . ' ' .http_build_query($this->request->post));
					exit;
				}
		}
		else
			{
				$this->log->write('webpay ошибка подписи ' . ' ' .http_build_query($this->request->post));
				exit;
			}
		// ответить 
		$this->response->setOutput(header("HTTP/1.0 200 OK"));

	}


}

?>