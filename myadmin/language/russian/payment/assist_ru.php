<?php
// Heading
$_['heading_title']      = 'ASSIST.ru';

// Text 
$_['text_payment']       = 'Оплата';
$_['text_success']       = 'Выполнено: Вы изменили данные учетной записи ASSIST.ru!';
$_['text_assist_ru']     = '<a onclick="window.open(\'http://www.assist.ru\');"><img src="view/image/payment/assist_ru.png" alt="ASSIST.ru" title="ASSIST.ru" style="border: 1px solid #EEEEEE;" /></a>';
$_['text_lang_en']       = 'English';
$_['text_lang_ru']       = 'Russian / Русский';

// Entry
$_['entry_account']      = 'Assist Shop ID:';
$_['entry_test']         = 'Демо-режим:';
$_['entry_test_result']  = 'Результат транзакции в демо-режиме:<br /><span class="help">Это результат, который платежная система будет возвращать после транзакции(сделки) в демо-режиме</span>';
$_['entry_secret']       = 'Secret word for payment callback service:<br /><span class="help">This value is used to CheckValue hash in payment callback. Note that you should explicitely ask ASSIST.ru to enable payment callback, it is turned off by default.</span>';
$_['entry_order_status_initial'] = 'Начальный статус заказа:<br /><span class="help">Статус заказа перед получением ответа от ASSIST.</span>';
$_['entry_order_status_paid'] = 'Статус заказа после оплаты:<br /><span class="help">Статус заказа после получения ответа SUCCESS(успешно) от ASSIST.</span>';
$_['entry_order_status_error'] = 'Статус заказа при ошибке оплаты:<br /><span class="help">Статус заказа после получения сообщения ERROR(ошибка) от ASSIST или возникновении каких-либо других ошибок.</span>';
$_['entry_geo_zone']     = 'Гео Зона:';
$_['entry_status']       = 'Статус:';
$_['entry_sort_order']   = 'Порядок сортировки:';

// Error
$_['error_permission']   = 'У Вас нет прав для управления модулем ASSIST.ru!';
$_['error_account']      = 'Введите Shop ID!';
$_['error_test_result']  = 'Необходимо ввести результат транзакции для демо-режима!';
?>