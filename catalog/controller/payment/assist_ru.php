<?php
// FirstCode
define ("RESULT_SUCCESS", 0);              // Успех
define ("RESULT_GENERIC_ERROR", 1);        // Ошибка
define ("RESULT_PARAMETER_ERROR", 5);      // Неверное значение параметра
define ("RESULT_ENCRYPTION_ERROR", 9);     // Ошибка шифрования

// SecondCode
define ("ERRCODE_NONE", 0);                // Дополнительной информации нет
define ("ERRCODE_WRONG_PGP_KEY", 6);       // Ошибка расшифровки ключом
define ("ERRCODE_WRONG_SHOP_IDP", 100);    // Параметр SHOP_IDP
define ("ERRCODE_WRONG_DATE", 104);        // Параметр DATE
define ("ERRCODE_WRONG_CURRENCY", 105);    // Параметр CURRENCY
define ("ERRCODE_WRONG_CARDNUMBER", 106);  // Параметр CARDNUMBER
define ("ERRCODE_WRONG_ORDERNUMBER", 107); // Параметр ORDERNUMBER
define ("ERRCODE_WRONG_TOTAL", 108);       // Параметр TOTAL
define ("ERRCODE_WRONG_COMMENT", 110);     // Параметр COMMENT
define ("ERRCODE_WRONG_CARDTYPE", 111);    // Параметр CARDTYPE
define ("ERRCODE_WRONG_CARDHOLDER", 114);  // Параметр CARDHOLDER
define ("ERRCODE_WRONG_CVC2", 115);        // Параметр CVC2
define ("ERRCODE_WRONG_CLIENTIP", 116);    // Параметр CLIENTIP
define ("ERRCODE_WRONG_LASTNAME", 117);    // Параметр LASTNAME
define ("ERRCODE_WRONG_FIRSTNAME", 118);   // Параметр FIRSTNAME
define ("ERRCODE_WRONG_MIDDLENAME", 119);  // Параметр MIDDLENAME
define ("ERRCODE_WRONG_EMAIL", 120);       // Параметр EMAIL
define ("ERRCODE_WRONG_COUNTRY", 128);     // Параметр COUNTRY
define ("ERRCODE_WRONG_BILLNUMBER", 143);  // Параметр BILLNUMBER
define ("ERRCODE_WRONG_CHECKVALUE", 158);  // Параметр CHECKVALUE
define ("ERRCODE_WRONG_SIGN", 159);        // Параметр SIGN

class ControllerPaymentAssistRu extends Controller {
	protected function index() {
		$this->data['button_confirm'] = $this->language->get('button_confirm');
		$this->data['button_back'] = $this->language->get('button_back');
		
		$this->load->model('checkout/order');
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		// This is an URL for the Mode 2 payments.  
		$this->data['action'] = 'https://test.paysec.by/pay/order.cfm';
		
		$this->data['shop_idp'] = $this->config->get('assist_ru_account');
		$this->data['order_idp'] = $this->session->data['order_id'];
		$this->data['total'] = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], FALSE);
		$this->data['currency'] = $order_info['currency_code'];
		$this->data['first_name'] = $order_info['payment_firstname'];
		$this->data['last_name'] = $order_info['payment_lastname'];
		$this->data['email'] = $order_info['email'];
		
		$this->data['comment'] = urlencode ($order_info['comment']);
		
		if ($this->config->get('assist_ru_test')) {
			$this->data['test_result'] = $this->config->get('assist_ru_test_result');
		}
		
		$this->data['street_address'] = $order_info['payment_address_1'];
		
		$this->data['city'] = $order_info['payment_city'];
		
		if ($order_info['payment_country'] == "United States" || $order_info['payment_country'] == "Canada") {
			$this->data['state'] = $order_info['payment_zone'];
		}
		
		$this->data['zip'] = $order_info['payment_postcode'];
		$this->data['country'] = $order_info['payment_country'];
		$this->data['phone'] = $order_info['telephone'];
		
		// Language of payment pages
		$this->data['language'] = ($this->session->data['language'] == 'ru') ? 0 : 1;
		
		$this->data['return_url_ok'] = HTTPS_SERVER . 'index.php?route=payment/assist_ru/order_ok';
		$this->data['return_url_no'] = HTTPS_SERVER . 'index.php?route=payment/assist_ru/order_no';
		
		$this->id = 'payment';
		
		if (file_exists (DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/assist_ru.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/assist_ru.tpl';
		} else {
			$this->template = 'default/template/payment/assist_ru.tpl';
		}
		
		$this->render();
	}
	
	public function order_ok() {
		$this->load->model('checkout/order');
		
		$log = $this->registry->get('log');
		
		if (!isset ($this->session->data['order_id'])) {
			$this->redirect($this->url->link('common/home'));
		}
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		if (!$order_info) {
			$this->redirect($this->url->link('common/home'));
		}
		
		// Confirm the order if it's not confirmed yet.
		if ($order_info['order_status_id'] == '0') {
			$log->write("ASSIST.ru order_ok(" . $this->session->data['order_id'] . "): order_status_id is " . $order_info['order_status_id'] . ", confirming.");
			
			$this->model_checkout_order->confirm($this->session->data['order_id'], $this->config->get('assist_ru_order_status_initial'));
		} else {
			$log->write("ASSIST.ru order_ok(" . $this->session->data['order_id'] . "): order_status_id is already set to " . $order_info['order_status_id']);
		}
		
		$this->redirect($this->url->link('checkout/success'));
	}
	
	public function order_no() {
		$this->load->model('checkout/order');
		
		$log = $this->registry->get('log');
		
		if (!isset ($this->session->data['order_id'])) {
			$this->redirect($this->url->link('common/home'));
		}
		
		$order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
		
		if (!$order_info) {
			$this->redirect($this->url->link('common/home'));
		}
		
		$log->write("ASSIST.ru order_ok(" . $this->session->data['order_id'] . "): Payment failed.");
		
		// Let user to retry payment
		$this->session->data['error'] = 'Payment failed! You may try again.';//$this->language->get('payment_error');
		
		$this->redirect($this->url->link('checkout/payment'));
	}
	
	private function callbackError($order_number, $firstcode, $secondcode) {
		$log = new Log($this->config->get('config_error_filename') . '.assist');
		
		$log->write("ASSIS callbackError(" . $order_number . "/" . $this->request->post['BillNumber'] . "): order_number=$order_number, firstcode=$firstcode, secondcode=$secondcode");
		
		if (isset ($order_number) && $order_number != '') {
			$this->model_checkout_order->confirm($order_number, 8 /*Denied*/);
		}
		
		$res  = '<?xml version=\"1.0\" encoding=\"windows-1251\"?>';
		$res .= '<pushpaymentresult firstcode="' . $firstcode . '" secondcode="' . $secondcode . '"/>';
		
		return $res;
	}
	
	public function callback() {
		/*
		Shop_IDP - Идентификатор предприятия в ASSIST
		OrderNumber - Номер заказа
		Response_Code - Код возврата
		Recommendation - Расшифровка кода возврата
		Message - Сообщение об ошибке
		Comment - Комментарий
		Date - Дата и время оплаты
		Total - Сумма операции
		Currency - Код валюты
		CardType - Тип платежного средства
		CardNumber - Номер платежного средства (последние 4 цифры номера карты, остальные скрыты символом *)
		LastName - Фамилия
		FirstName - Имя
		MiddleName - Отчество
		Address - Адрес
		Email - Адрес электронной почты
		Country - Код страны банка-эмитента
		ApprovalCode - Код авторизации
		CardSubType - Подтип карты
		CVC2 - Наличие CVC2/CVV2/4DBC (0 – авторизация без CVC2, 1 – авторизация с СVC2)
		CardHolder - Держатель карты
		IPAddress - IP-адрес покупателя
		ProtocolTypeName - Тип протокола (SET/NET/POS)
		BillNumber - Номер платежа в системе ASSIST
		BankName - Название банка-эмитента
		Status - Состояние заказа
		Error_Code - Код ответа процессингового центра
		Error_Comment - Расшифровка кода ответа процессингового центра
		ProcessingName - Наименование процессингового центра
		PacketDate - Дата и время запроса
		PaymentTransactionType_id - Тип транзакции
		CheckValue - 1) В стандартном случае: Контрольный код сообщения - текстовое представление MD5-хэша строковой склейки
					 параметров Shop_IDP, OrderNumber, Total, Currency, к которым добавлено секретное слово. То есть:
					 md5(string(Shop_IDP) +…+ string(Currency) + string(salt)).
					 2) В индивидуальном: Контрольное сообщение «Shop_IDP;OrderNumber;Total;Currency», зашифрованное открытым
					 PGP ключом магазина**
		Sign - 1) В стандартном случае - пусто
			   2) В индивидуальном - Сервис отправки результатов платежа магазину стр 4 из 5 поле CheckValue, подписанное
			   закрытым PGP ключом ASSIST
		*/
		
		$this->load->model('checkout/order');
		
		// Log
		$log = new Log($this->config->get('config_error_filename') . '.assist');
		
		// Check if secret word is configured properly
		if ($this->config->get('assist_ru_secret') == '') {
			exit ($this->callbackError('', RESULT_GENERIC_ERROR, ERRCODE_NONE));
		}
		
		// Check that all required POST data is present
		if (!isset ($this->request->post['OrderNumber']) || !isset ($this->request->post['Shop_IDP']) || !isset ($this->request->post['Total']) || !isset ($this->request->post['Currency']) || !isset ($this->request->post['CheckValue'])) {
			exit ($this->callbackError('', RESULT_PARAMETER_ERROR, ERRCODE_NONE));
		}
		
		$order_number = $this->request->post['OrderNumber'];
		
		$order_info = $this->model_checkout_order->getOrder($order_number);
		
		if (!$order_info) {
			exit ($this->callbackError('', RESULT_PARAMETER_ERROR, ERRCODE_WRONG_ORDERNUMBER));
		}
		
		$shop_idp = $this->config->get('assist_ru_account');
		
		if ($this->request->post['Shop_IDP'] != $shop_idp) {
			exit ($this->callbackError($order_number, RESULT_PARAMETER_ERROR, ERRCODE_WRONG_SHOP_IDP));
		}
		
		$total = $this->currency->format($order_info['total'], $order_info['currency'], $order_info['value'], FALSE);
		
		if ($this->request->post['Total'] != $total) {
			exit ($this->callbackError($order_number, RESULT_PARAMETER_ERROR, ERRCODE_WRONG_TOTAL));
		}
		$currency = $order_info['currency'];
		
		if ($this->request->post['Currency'] != $currency) {
			exit ($this->callbackError($order_number, RESULT_PARAMETER_ERROR, ERRCODE_WRONG_CURRENCY));
		}
		
		$hash = md5 ($shop_idp . $order_number . $total . $currency . $this->config->get('assist_ru_secret'));
		
		$hash = strtoupper ($hash);
		
		if (strtoupper ($hash) != strtoupper ($this->request->post['CheckValue'])) {
			exit ($this->callbackError($order_number, RESULT_PARAMETER_ERROR, ERRCODE_WRONG_CHECKVALUE));
		}
		
		// Everything is ok up to now. Check that we've received SUCCESS result from the payment gateway and
		// confirm or update the order. If server return some other code we don't do anything with the order,
		// as we assume user will retry payment.
		
		if ($this->request->post['Response_Code'] == 'AS000') {
			$status_id = $this->config->get('assist_ru_order_status_paid');
			
			if ($order_info['order_status_id'] == '0') {
				$log->write("ASSIST.ru callback(" . $order_number . "/" . $this->request->post['BillNumber'] . "): order_status_id is " . $order_info['order_status_id'] . ", confirming to " . $status_id . ".");
				
				$this->model_checkout_order->confirm($order_number, $status_id);
			} else {
				$log->write("ASSIST.ru callback(" . $order_number . "/" . $this->request->post['BillNumber'] . "): order_status_id is " . $order_info['order_status_id'] . ", updating to " . $status_id . ".");
				
				$this->model_checkout_order->update($order_number, $status_id);
			}
		}
		
		// Send confirmation to server too.
		$reply  = '<?xml version="1.0" encoding="windows-1251"?>';
		$reply .= '<pushpaymentresult firstcode="' . RESULT_SUCCESS . '" secondcode="' . ERRCODE_NONE . '">';
		$reply .= '<order>';
		$reply .= '<billnumber>' . $this->request->post['BillNumber'] . '</billnumber>';
		$reply .= '<packetdate>' . $this->request->post['PacketDate'] . '</packetdate>';
		$reply .= '</order>';
		$reply .= '</pushpaymentresult>';
		
		$log->write("ASSIST.ru callback(" . $order_number . "/" . $this->request->post['BillNumber'] . ") reply: $reply");
		
		echo $reply;
		
		exit ();
	}
}
?>