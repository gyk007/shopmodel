<?php echo $header; ?>
<div id="dialog-modal" style="dispay:none;"></div>
<style type="text/css">
.loading_info {
    padding: 10px 10px 10px 33px;
	margin-bottom: 15px;
	background: #F7F7F7;
	border: 1px solid #B8B8B8;
	color: #555555;
	-webkit-border-radius: 5px 5px 5px 5px;
	-moz-border-radius: 5px 5px 5px 5px;
	-khtml-border-radius: 5px 5px 5px 5px;
	border-radius: 5px 5px 5px 5px;
}
#progressbar_wrapper {
	font-size:14px;
	padding-left:16px;
}
a.button, .list a.button {
    padding: 5px 10px;
	border-radius:5px;
    background-color: #5BB75B;
    background-image: linear-gradient(to bottom, #62C462, #51A351);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #FFFFFF;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
	border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
}
a.button:hover, .list a.button:hover {
    background-color: #51A351;
	background-image: none;
}
</style>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div id="loading_info" class="loading_info" style="display:none;"><img src="view/image/loading.gif">&nbsp;&nbsp;<span id="action_message"></span>
  <div id="progressbar_wrapper"><br>Экспортировано <span id="progress_value"></span> из <span id="total_export"></span></div>
  <div id="timer"></div>
  </div>
  <?php echo $this->error['warning']; ?>
  <?php if ($warning) { ?>
  <div class="warning"><?php echo $warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box" id="products_table">
    <div class="heading">
      <h1><img src="view/image/product.png" alt="" />Экспорт в ОК</h1>
      <div class="buttons">
          <a id="extra_settings_button" onClick="$('#extra_settings').toggle('slow');">Настройки</a> / <a id="clear">Очистить куки</a>  |
		  <a id="exportuser_action" class="button">Экспорт в альбом юзера</a>
          <a id="export_action" class="button">Экспорт в альбом группы</a>
          <a id="reexport_action" class="button">Удалить из альбома</a>
          <a id="wallpost_action" class="button">Экспорт в тему</a>
          <a id="delete_wall_action" class="button">Удалить из темы</a>
          </div>
    </div>
    <div class="content">
        <div id="extra_settings" style="<?php echo $extra_settings ?>">
    <form name="form" action="" method="post" enctype="multipart/form-data" id="form">
    <table class="form">
        <tr>
          <td><?php echo $entry_user_email ?></td>
          <td>
            <label><input type="text" name="ok_export_user_email" value="<?php echo $ok_export_user_email ?>" /></label>
          </td>
        </tr> 
        <tr>
          <td><?php echo $entry_user_pass ?></td>
          <td>
            <label><input type="text" name="ok_export_user_pass" value="<?php echo $ok_export_user_pass ?>" /></label>
          </td>
        </tr>   
        <tr>
          <td><?php echo $entry_group_id ?></td>
          <td>
            <label><input type="text" name="ok_export_group_id" value="<?php echo $ok_export_group_id ?>" /></label>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_nomeralb_id ?></td>
          <td>
            <label><input type="text" name="ok_export_nomeralb_id" value="<?php echo $ok_export_nomeralb_id ?>" /></label>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_nomeralbuser_id ?></td>
          <td>
            <label><input type="text" name="ok_export_nomeralbuser_id" value="<?php echo $ok_export_nomeralbuser_id ?>" /></label>
          </td>
        </tr>
        <tr>
          <td>Номер телефона (Без кода страны!)</td>
          <td>
          <label><input type="text" name="ok_export_phone" value="<?php echo $ok_export_phone ?>" /></label>
          </td>
        </tr>
        <tr>
          <td>Страна <br />Код по коду Одноклассников:<br /><?php echo $ok_export_contry ?></td>
          <td>
          <select name="ok_export_contry"><option value="10414533690">Россия</option><option value="26334910464">Абхазия</option><option value="10400654407">Австралия</option><option value="10426428818">Австрия</option><option value="10410450732">Азербайджан</option><option value="10410522537">Албания</option><option value="10419531540">Алжир</option><option value="10400909101">Ангола</option><option value="10395022134">Ангуилья</option><option value="10396157513">Андорра</option><option value="10401935333">Антигуа и Барбуда</option><option value="10425952826">Антильские острова</option><option value="10401434079">Аргентина</option><option value="10417232037">Армения</option><option value="10410310303">Афганистан</option><option value="10407551720">Багамские острова</option><option value="10396352095">Бангладеш</option><option value="10411706009">Барбадос</option><option value="10406995556">Бахрейн</option><option value="10423319006">Беларусь</option><option value="10394079228">Белиз</option><option value="10408272261">Бельгия</option><option value="10423428619">Бенин</option><option value="10414686106">Бермуды</option><option value="10393631600">Болгария</option><option value="10409174087">Боливия</option><option value="10396139862">Босния/Герцеговина</option><option value="10401213745">Ботсвана</option><option value="10394346015">Бразилия</option><option value="10409651721">Британские Виргинские о-ва</option><option value="10419484235">Бруней</option><option value="10404060904">Буркина Фасо</option><option value="10404374905">Бурунди</option><option value="10404540364">Бутан</option><option value="10412870819">Вануату</option><option value="10411136417">Ватикан</option><option value="10406170538">Великобритания</option><option value="10409956165">Венгрия</option><option value="10396486463">Венесуэла</option><option value="10415852578">Вьетнам</option><option value="10393450888">Габон</option><option value="10417683703">Гаити</option><option value="10403255122">Гайана</option><option value="10399865285">Гамбия</option><option value="10397676008">Гана</option><option value="10414930207">Гваделупа</option><option value="10419428643">Гватемала</option><option value="10413226540">Гвинея</option><option value="10403555674">Гвинея-Бисау</option><option value="10397571399">Германия</option><option value="10399224101">Гернси остров</option><option value="10406295560">Гибралтар</option><option value="10399351736">Гондурас</option><option value="10412717530">Гонконг</option><option value="10395467357">Гренада</option><option value="10408186696">Гренландия</option><option value="10410192803">Греция</option><option value="10411801535">Грузия</option><option value="10398024550">Дания</option><option value="10392982119">Джерси остров</option><option value="10423910652">Джибути</option><option value="10392890835">Доминиканская Республика</option><option value="10414151425">ДР Конго</option><option value="10402537077">Египет</option><option value="10422229795">Замбия</option><option value="10405794288">Западная Сахара</option><option value="10410213419">Зимбабве</option><option value="10424542073">Израиль</option><option value="10415489530">Индия</option><option value="10394991378">Индонезия</option><option value="10412777633">Иордания</option><option value="10405044887">Ирак</option><option value="10419405993">Иран</option><option value="10421760139">Ирландия</option><option value="10420187771">Исландия</option><option value="10423450359">Испания</option><option value="10414775922">Италия</option><option value="10418754394">Йемен</option><option value="10396069806">Кабо-Верде</option><option value="10415971874">Казахстан</option><option value="10410376034">Камбоджа</option><option value="10417801476">Камерун</option><option value="10393621238">Канада</option><option value="10424568667">Катар</option><option value="10421430373">Кения</option><option value="10401168591">Кипр</option><option value="10397251386">Китай</option><option value="10398961528">Колумбия</option><option value="10415000877">Коста-Рика</option><option value="10397441630">Кот-д'Ивуар</option><option value="10400805253">Куба</option><option value="10425905274">Кувейт</option><option value="10417619125">Кука острова</option><option value="10405644775">Кыргызстан</option><option value="10422182119">Лаос</option><option value="10405172143">Латвия</option><option value="10404932758">Лесото</option><option value="10426378265">Либерия</option><option value="10394492001">Ливан</option><option value="10396193388">Ливия</option><option value="10408982062">Литва</option><option value="10402377389">Лихтенштейн</option><option value="10417321877">Люксембург</option><option value="10421455265">Маврикий</option><option value="10402331337">Мавритания</option><option value="10395008003">Мадагаскар</option><option value="10403452946">Македония</option><option value="10424318428">Малайзия</option><option value="10392808561">Мали</option><option value="10419625380">Мальдивские острова</option><option value="10418580649">Мальта</option><option value="10398888997">Марокко</option><option value="10405114643">Мексика</option><option value="10395900020">Мозамбик</option><option value="10397135919">Молдова</option><option value="10406156316">Монако</option><option value="10400052977">Монголия</option><option value="10397507309">Мьянма (Бирма)</option><option value="10425274320">Мэн о-в</option><option value="10398918582">Намибия</option><option value="10395547483">Непал</option><option value="10403897067">Нигер</option><option value="10403906713">Нигерия</option><option value="10416691196">Нидерланды (Голландия)</option><option value="10415455264">Никарагуа</option><option value="10416927951">Новая Зеландия</option><option value="10417478473">Новая Каледония</option><option value="10403907946">Норвегия</option><option value="10407515868">О.А.Э.</option><option value="10413735381">Оман</option><option value="10407624473">Пакистан</option><option value="32108942709">Палау</option><option value="10417127108">Панама</option><option value="10414119671">Папуа Новая Гвинея</option><option value="10397730315">Парагвай</option><option value="10397453891">Перу</option><option value="10420475109">Питкэрн остров</option><option value="10414896014">Польша</option><option value="10396879941">Португалия</option><option value="10413603686">Пуэрто Рико</option><option value="10410395082">Республика Конго</option><option value="10395017596">Реюньон</option><option value="10421210322">Руанда</option><option value="10416439221">Румыния</option><option value="10401272160">Сальвадор</option><option value="10418117522">Самоа</option><option value="10425587057">Сан-Марино</option><option value="10402425385">Сан-Томе и Принсипи</option><option value="10410580805">Саудовская Аравия</option><option value="10408209383">Свазиленд</option><option value="10411324250">Святая Люсия</option><option value="10394159876">Северная Корея</option><option value="10392716690">Сейшеллы</option><option value="10399264429">Сенегал</option><option value="10415402038">Сен-Пьер и Микелон</option><option value="10413542523">Сент Китс и Невис</option><option value="10397340738">Сент-Винсент и Гренадины</option><option value="10403797723">Сербия</option><option value="10403882021">Сингапур</option><option value="10421914141">Сирия</option><option value="10394488739">Словакия</option><option value="10412478477">Словения</option><option value="10399243721">Соломоновы острова</option><option value="10402270246">Сомали</option><option value="10422456146">Судан</option><option value="10399143993">Суринам</option><option value="10395431810">США</option><option value="10419209718">Сьерра-Леоне</option><option value="10426480621">Таджикистан</option><option value="10420570186">Таиланд</option><option value="10394605145">Тайвань</option><option value="10412575230">Танзания</option><option value="10406981529">Того</option><option value="10394734441">Токелау острова</option><option value="10417023658">Тонга</option><option value="10424065948">Тринидад и Тобаго</option><option value="10400207372">Тувалу</option><option value="10399201022">Тунис</option><option value="10396721959">Туркменистан</option><option value="10396777362">Туркс и Кейкос</option><option value="10406909768">Турция</option><option value="10410627224">Уганда</option><option value="10423529949">Узбекистан</option><option value="10424076448">Украина</option><option value="10395074682">Уоллис и Футуна острова</option><option value="10426234429">Уругвай</option><option value="10395058357">Фарерские острова</option><option value="10423400059">Фиджи</option><option value="10423933302">Филиппины</option><option value="10405620585">Финляндия</option><option value="10394185598">Франция</option><option value="10395243227">Французская Полинезия</option><option value="10421079332">Хорватия</option><option value="10393424473">Чад</option><option value="26287387136">Черногория</option><option value="10395033214">Чехия</option><option value="10397429545">Чили</option><option value="10401982134">Швейцария</option><option value="10393232409">Швеция</option><option value="10400772860">Шри-Ланка</option><option value="10408281200">Эквадор</option><option value="10413994177">Экваториальная Гвинея</option><option value="10422842223">Эритрея</option><option value="10399393757">Эстония</option><option value="10404948045">Эфиопия</option><option value="10396767805">ЮАР</option><option value="10409076784">Южная Корея</option><option value="26334910720">Южная Осетия</option><option value="10415454380">Ямайка</option><option value="10404808625">Япония</option></select>
          </td>
        </tr>
        <tr>
            <td>Размер изображения:</td>
            <td><input required id="ok_export_image_size_x" type="text" size="3" value="<?php echo $this->config->get('ok_export_image_size_x') ?>" name="ok_export_image_size_x">
                x
                <input required id="ok_export_image_size_y" type="text" size="3" value="<?php echo $this->config->get('ok_export_image_size_y') ?>" name="ok_export_image_size_y">
            </td>
        </tr>
        <tr>
          <td>Выгружать основное фото из товара?</td>
          <td>
            <label><input type="checkbox" name="ok_export_photos_hoved" value="1" <?php echo $ok_export_photos_hoved == 1 ? 'checked="checked"' : ''; ?> /></label><br>
          </td>
        </tr>
        <tr>
          <td>Выгружать дополнительные фото из товара?</td>
          <td>
            <label><input type="checkbox" name="ok_export_photos_count" value="1" <?php echo $ok_export_photos_count == 1 ? 'checked="checked"' : ''; ?> /></label><br>
          </td>
        </tr>
        <tr>
          <td valign="top"><?php echo $entry_wallpost_tpl ?></td>
          <td>
            <textarea name="ok_export_wallpost_tpl" style="float:left;width:280px;height:150px;" /><?php echo $this->config->get('ok_export_wallpost_tpl') ?></textarea>
            <div class="help" style="float:left;padding-left:10px;"><?php echo $text_desc_tpl ?></div>
          </td>
        </tr>  
        <tr>
          <td><?php echo $entry_http_catalog ?></td>
          <td>
            <label><input type="text" size="50" name="ok_export_http_catalog" value="<?php echo $ok_export_http_catalog ?>" /></label>
            <div class="help"><?php echo $text_desc_http_catalog ?></div>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_products_per_page ?></td>
          <td>
            <label><input type="text" size="1" name="ok_export_products_per_page" value="<?php echo $ok_export_products_per_page ?>" /></label>
          </td>
        </tr>
        <tr>
          <td><?php echo $entry_colums ?></td>
          <td>
            <label><input type="checkbox" name="ok_export_column_model" value="1" <?php echo $ok_export_column_model == 1 ? 'checked="checked"' : ''; ?> /> <?php echo $text_model; ?></label><br>
            <label><input type="checkbox" name="ok_export_column_price" value="1" <?php echo $ok_export_column_price == 1 ? 'checked="checked"' : ''; ?> /> <?php echo $text_price; ?></label><br>
            <label><input type="checkbox" name="ok_export_column_quantity" value="1" <?php echo $ok_export_column_quantity == 1 ? 'checked="checked"' : ''; ?> /> <?php echo $text_quantity; ?></label><br>
            <label><input type="checkbox" name="ok_export_column_status" value="1" <?php echo $ok_export_column_status == 1 ? 'checked="checked"' : ''; ?> /> <?php echo $text_status; ?></label><br>
            <label><input type="checkbox" name="ok_export_column_date_added" value="1" <?php echo $ok_export_column_date_added == 1 ? 'checked="checked"' : ''; ?> /> <?php echo $text_date_added; ?></label><br>
          </td>
        </tr>
      </table>
      <div class="buttons" style="diplay:inline;"><a id="reepost" onclick="$('#form').submit();" class="button">Сохранить</a></div><br />
    </form>
	<form name="smscheck" action="" method="post" enctype="multipart/form-data" id="smschecks">
	<input name="login" type="hidden" value="<?php echo urlencode($this->config->get('ok_export_user_email')) ?>">
	<input name="password" type="hidden" value="<?php echo urlencode($this->config->get('ok_export_user_pass')) ?>">
	<input name="phone" type="hidden" value="<?php echo urlencode($this->config->get('ok_export_phone')) ?>">
	<input name="contry" type="hidden" value="<?php echo urlencode($this->config->get('ok_export_contry')) ?>">
	<div class="buttons" style="diplay:inline;"><a id="smscheck" class="button">Проверить аккаунт на доступность</a></div>
	</form>
    <br />
	<br />
	</div>
	    <div id="refreshlist">
        <form action="" method="post" enctype="multipart/form-data" id="formpost">
        
        <table class="list">
          <thead>
              
            <tr>
              <td rowspan="2" width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td rowspan="2" class="center"><?php echo $column_image; ?></td>
              <td rowspan="2" class="left"><?php if ($sort == 'pd.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
                
              <?php if ($show_column_model) { ?>  
              <td rowspan="2" class="left"><?php if ($sort == 'p.model') { ?>
                <a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
                <?php } ?></td>
              <?php } ?>
            
              <?php if ($show_column_price) { ?>  
              <td rowspan="2" class="left"><?php if ($sort == 'p.price') { ?>
                <a href="<?php echo $sort_price; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_price; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_price; ?>"><?php echo $column_price; ?></a>
                <?php } ?></td>
              <?php } ?>
              
              <?php if ($show_column_quantity) { ?>  
              <td rowspan="2" class="right"><?php if ($sort == 'p.quantity') { ?>
                <a href="<?php echo $sort_quantity; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_quantity; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_quantity; ?>"><?php echo $column_quantity; ?></a>
                <?php } ?></td>
              <?php } ?>
            
              <?php if ($show_column_status) { ?>  
              <td rowspan="2" class="left"><?php if ($sort == 'p.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <?php } ?>
              
              <?php if ($show_column_date_added) { ?>  
              <td rowspan="2" class="left"><?php if ($sort == 'p.date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?></td>
              <?php } ?>
              
              <td rowspan="2" class="left">
                <?php echo $column_album; ?>
               </td>              <td colspan="2" class="center">Экспорт</td>
            </tr>
            <tr>
              <td class="left"><?php if ($sort == 'export_albums') { ?>
                <a href="<?php echo $sort_export_albums; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_albums; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_export_albums; ?>"><?php echo $column_albums; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'export_wall') { ?>
                <a href="<?php echo $sort_export_wall; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_wall; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_export_wall; ?>"><?php echo $column_wall; ?></a>
                <?php } ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <td align="center"><a onclick="filter();" class="button">Отфильтровать</a></td>
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              
              <?php if ($show_column_model) { ?> 
              <td><input type="text" name="filter_model" value="<?php echo $filter_model; ?>" /></td>
              <?php } ?>
              
              <?php if ($show_column_price) { ?> 
              <td align="left"><input type="text" name="filter_price" value="<?php echo $filter_price; ?>" size="8"/></td>
              <?php } ?>
              
              <?php if ($show_column_quantity) { ?> 
              <td align="right"><input type="text" name="filter_quantity" value="<?php echo $filter_quantity; ?>" style="text-align: right; width:50px;" /></td>
              <?php } ?>
              
              <?php if ($show_column_status) { ?> 
              <td><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <?php } ?>    
              
              <?php if ($show_column_date_added) { ?> 
              <td><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" style="width:70px;" class="date" /></td>
              <?php } ?>
       
              <td><?php echo $category_select; ?></td>              <td><select name="filter_export_albums">
                  <option value="*"></option>
                  <?php if ($filter_export_albums) { ?>
                  <option value="1" selected="selected"><?php echo $text_ok_export_on; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_ok_export_on; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_export_albums) && !$filter_export_albums) { ?>
                  <option value="0" selected="selected"><?php echo $text_ok_export_off; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_ok_export_off; ?></option>
                  <?php } ?>
                </select></td>
              <td><select name="filter_export_wall">
                  <option value="*"></option>
                  <?php if ($filter_export_wall) { ?>
                  <option value="1" selected="selected"><?php echo $text_ok_export_on; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_ok_export_on; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_export_wall) && !$filter_export_wall) { ?>
                  <option value="0" selected="selected"><?php echo $text_ok_export_off; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_ok_export_off; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($product['selected']) { ?>
                <input id="selected" type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input id="selected" type="checkbox" name="selected[]" value="<?php echo $product['product_id']; ?>" />
                <?php } ?></td>
	            <input name="login" type="hidden" value="<?php echo urlencode($this->config->get('ok_export_user_email')) ?>">
		        <input name="password" type="hidden" value="<?php echo urlencode($this->config->get('ok_export_user_pass')) ?>">
		        <input name="number_group" type="hidden" value="<?php echo $this->config->get('ok_export_group_id') ?>">
			    <input name="album_group" type="hidden" value="<?php echo $ok_export_nomeralb_id ?>">
				<input name="albumuser_group" type="hidden" value="<?php echo $ok_export_nomeralbuser_id ?>">
				<input name="album[<?php echo $product['product_id']; ?>]" type="hidden" value="<?php echo $product['category_id']; ?>">
			    <input name="names[<?php echo $product['product_id']; ?>]" type="hidden" value="<?php echo urlencode($product['name']); ?>" />
			    <input name="images[<?php echo $product['product_id']; ?>]" type="hidden" value="<?php echo $product['image']; ?>" />
                <td class="center"><img src="<?php echo $product['smallimg']; ?>" alt="<?php echo $product['names']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
                <td class="left"><a href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['names']; ?></a><br /><br /><a onclick="open_popup('#<?php echo $product['product_id']; ?>modal_window');">Описание по шаблону</a><div style="display:none;" id="<?php echo $product['product_id']; ?>modal_window"><a onclick="close_popup('#<?php echo $product['product_id']; ?>modal_window');">Закрыть</a><p><?php echo $product['name']; ?></p></div><div id="background"></div></td>
              
              <?php if ($show_column_model) { ?>
              <td class="left"><?php echo $product['model']; ?></td>
              <?php } ?>
              
              <?php if ($show_column_price) { ?>
              <td class="left"><?php if ($product['special']) { ?>
                <span style="text-decoration: line-through;"><?php echo $product['price']; ?></span><br/>
                <span style="color: #b00;"><?php echo $product['special']; ?></span>
                <?php } else { ?>
                <?php echo $product['price']; ?>
                <?php } ?></td>
              <?php } ?>
            
              <?php if ($show_column_quantity) { ?>
              <td class="right"><?php if ($product['quantity'] <= 0) { ?>
                <span style="color: #FF0000;"><?php echo $product['quantity']; ?></span>
                <?php } elseif ($product['quantity'] <= 5) { ?>
                <span style="color: #FFA500;"><?php echo $product['quantity']; ?></span>
                <?php } else { ?>
                <span style="color: #008000;"><?php echo $product['quantity']; ?></span>
                <?php } ?></td>
              <?php } ?>
            
              <?php if ($show_column_status) { ?>
              <td class="left"><?php echo $product['status']; ?></td>
              <?php } ?>
            
              <?php if ($show_column_date_added) { ?>
              <td class="left"><?php echo $product['date_added']; ?></td>
              <?php } ?>
              <td class="left"><?php echo $product['category']; ?></td>              <td class="left">
                  <?php if ($product['albums_export']) {
                      $total = count($product['albums_export']);
                      if ($total > 1) {
                          echo '<img src="view/image/success.png" style="margin-bottom:-4px;margin-right:3px;" /><b><a class="export_history" data-type="albums" data-id="' . $product['product_id'] . '" href="javascript:void(0);">Да (' . $total . ')</a></b>';
                      }
                      else {
                          echo '<img src="view/image/success.png" style="margin-bottom:-4px;margin-right:3px;" />Да
                          <div id="albums_export' . $product['product_id'] . '" style="width:100px;">';
                          foreach ($product['albums_export'] as $export) {
                              ?>
                              <div><?php echo $export['date']; ?>
                              <a title="Удалить из альбомов" onclick="if (!confirm('Действительно удалить?')) return false;" href="<?php echo $export['delete_link'] ?>">[x]</a></div>
                              <?php
                          }
                      echo '</div>';
                      }
                      
                  }
                  else echo 'Нет';
                  ?>
                  
              </td>
              <td class="left">
                  <?php if ($product['wall_export']) {
                      $total = count($product['wall_export']);
                      if ($total > 1) {
                          echo '<img src="view/image/success.png" style="margin-bottom:-4px;margin-right:3px;" /><b><a class="export_history" data-type="wall" data-id="' . $product['product_id'] . '" href="javascript:void(0);">Да (' . $total . ')</a></b>
                          <div id="albums_export' . $product['product_id'] . '" style="display:none;width:100px;">';
                      }
                      else {
                          echo '<img src="view/image/success.png" style="margin-bottom:-4px;margin-right:3px;" />Да
                          <div id="albums_export' . $product['product_id'] . '" style="width:100px;">';
                      }
                      foreach ($product['wall_export'] as $export) {
                          
                          ?>
                          <div><?php echo $export['date']; ?> 
                          <a title="Удалить со стены" onclick="if (!confirm('Действительно удалить?')) return false;" href="<?php echo $export['delete_link'] ?>">[x]</a></div>
                          <?php
                      }
                      echo '</div>';
                  }
                  else echo 'Нет';
                      ?>
              </td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
	  </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=extension/ok_export&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}
	
	var filter_model = $('input[name=\'filter_model\']').attr('value');
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
	var filter_price = $('input[name=\'filter_price\']').attr('value');
	
	if (filter_price) {
		url += '&filter_price=' + encodeURIComponent(filter_price);
	}
	
	var filter_quantity = $('input[name=\'filter_quantity\']').attr('value');
	
	if (filter_quantity) {
		url += '&filter_quantity=' + encodeURIComponent(filter_quantity);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if ($('select[name=\'filter_status\']').length && filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	
    
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}	
    
	var filter_category = $('select[name=\'filter_category\']').attr('value');
	
	if (filter_category != '*') {
		url += '&filter_category=' + encodeURIComponent(filter_category);
	}	
    
    var filter_export_albums = $('select[name=\'filter_export_albums\']').attr('value');
	
	if (filter_export_albums != '*') {
		url += '&filter_export_albums=' + encodeURIComponent(filter_export_albums);
	}	
    
    var filter_export_wall = $('select[name=\'filter_export_wall\']').attr('value');
	
	if (filter_export_wall != '*') {
		url += '&filter_export_wall=' + encodeURIComponent(filter_export_wall);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$('#formpost input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'filter_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/ok_export/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_name\']').val(ui.item.label);
						
		return false;
	}
});

$('input[name=\'filter_model\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/ok_export/autocomplete&token=<?php echo $token; ?>&filter_model=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.model,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_model\']').val(ui.item.label);
						
		return false;
	}
});

var refresh_list = function (data) {
    $("#refreshlist").html($("#refreshlist", data).html());
    $('#products_table').show();
    $('.success', data).clone().insertAfter('#loading_info');
    $('.warning', data).clone().insertAfter('#loading_info');
    $('#loading_info').hide();
};

var refresh_sms = function (data) {
    $('#products_table').show();
    $('.success', data).clone().insertAfter('#loading_info');
    $('.warning', data).clone().insertAfter('#loading_info');
    $('#loading_info').hide();
};

function getProgress() {
    $.ajax({
      url: "<?php echo htmlspecialchars_decode($ok_export_progress); ?>",
      dataType: "html",
      success: function (data) {
          $( "#progress_value" ).text(data);
      }
    });
}

$('#export_action').live('click', function () {
	var total_export = $('#selected:checked').length;
    if (total_export < 1) {
        return alert('Вы не выбрали ни одного товара!');
    }
    $('#action_message').text('Идёт процесс экспорта товаров в альбом, пожалуйста подождите.');
    $('#loading_info').show();
    $('#products_table').hide();
    $('.success').remove();
    $('.warning').remove();
    $( "#progressbar_wrapper" ).show();
    $( "#progress_value" ).text(0);
    $( "#total_export" ).text(total_export);
    
    var request = $.ajax({
      url: "<?php echo htmlspecialchars_decode($ok_export); ?>",
      type: "POST",
      data: $("#formpost").serialize(),
      dataType: "html"
    });
    
    var progress_timer = setInterval('getProgress();', 3000);
    
    request.done(function(data) {
        clearInterval(progress_timer);
        refresh_list(data);
    });
});

$('#exportuser_action').live('click', function () {
	var total_export = $('#selected:checked').length;
    if (total_export < 1) {
        return alert('Вы не выбрали ни одного товара!');
    }
    $('#action_message').text('Идёт процесс экспорта товаров в альбом пользователя, пожалуйста подождите.');
    $('#loading_info').show();
    $('#products_table').hide();
    $('.success').remove();
    $('.warning').remove();
    $( "#progressbar_wrapper" ).show();
    $( "#progress_value" ).text(0);
    $( "#total_export" ).text(total_export);
    
    var request = $.ajax({
      url: "<?php echo htmlspecialchars_decode($ok_exportuser); ?>",
      type: "POST",
      data: $("#formpost").serialize(),
      dataType: "html"
    });
    
    var progress_timer = setInterval('getProgress();', 3000);
    
    request.done(function(data) {
        clearInterval(progress_timer);
        refresh_list(data);
    });
});

$('#wallpost_action').live('click', function () {
	var total_export = $('#selected:checked').length;
    if (total_export < 1) {
        return alert('Вы не выбрали ни одного товара!');
    }
    $('#action_message').text('Идёт процесс отправки товаров в группу, пожалуйста подождите.');
    $('#loading_info').show();
    $('#products_table').hide();
    $('.success').remove();
    $('.warning').remove();
    $( "#progressbar_wrapper" ).show();
    $( "#progress_value" ).text(0);
    $( "#total_export" ).text(total_export);
    
    var progress_timer = setInterval('getProgress();', 3000);
    
    var request = $.ajax({
      url: "<?php echo htmlspecialchars_decode($ok_wallpost); ?>",
      type: "POST",
      data: $("#formpost").serialize(),
      dataType: "html"
    });
    
    request.done(function(data) {
		clearInterval(progress_timer);
        refresh_list(data);
    });
});
$('#reepost').live('click', function () {
    $('#action_message').text('Сохранение настроек, перезапуск товаров.');
    $('#loading_info').show();
    $('#products_table').hide();
	$( "#progressbar_wrapper" ).hide();
    $('.success').remove();
    $('.warning').remove();
	
    var progress_timer = setInterval('getProgress();', 5000);
	
    var request = $.ajax({
      type: "POST",
      data: $("#form").serialize(),
      dataType: "html"
    });
    
    request.done(function(data) {
		clearInterval(progress_timer);
        refresh_list(data);
    });
});
$('#reexport_action').live('click', function () {
	if (!confirm('Действительно удалить?')) return false;
    if ($('#selected:checked').length < 1) {
        return alert('Вы не выбрали ни одного товара!');
    }
    $('#action_message').text('Идёт процесс удаления истории товаров из экспорта, пожалуйста подождите.');
    $('#loading_info').show();
    $('#products_table').hide();
    $('.success').remove();
    $('.warning').remove();
    $( "#progressbar_wrapper" ).hide();
    
    var request = $.ajax({
      url: "<?php echo htmlspecialchars_decode($ok_delete); ?>",
      type: "POST",
      data: $("#formpost").serialize(),
      dataType: "html"
    });
    
    request.done(function(data) {
        refresh_list(data);
    });
});
$('#clear').live('click', function () {
    $('#action_message').text('Удаление кук, очистка кэша.');
    $('#loading_info').show();
    $('#products_table').hide();
	$( "#progressbar_wrapper" ).hide();
    $('.success').remove();
    $('.warning').remove();
	
    var progress_timer = setInterval('getProgress();', 1000);
	
    var request = $.ajax({
      url: "<?php echo htmlspecialchars_decode($ok_clear); ?>",
      type: "POST",
      dataType: "html"
    });
    
    request.done(function(data) {
		clearInterval(progress_timer);
        refresh_list(data);
    });
});
$('#smscheck').live('click', function () {
    $('#action_message').text('Отправка кода, ожидайте.');
    $('#loading_info').show();
    $('#products_table').hide();
	$( "#progressbar_wrapper" ).hide();
    $('.success').remove();
    $('.warning').remove();
	
    var progress_timer = setInterval('getProgress();', 1000);
	
    var request = $.ajax({
      url: "<?php echo htmlspecialchars_decode($ok_smscheck); ?>",
      type: "POST",
	  data: $("#smschecks").serialize(),
      dataType: "html"
    });
    
    request.done(function(data) {
		clearInterval(progress_timer);
        refresh_sms(data);
    });
});
$('#delete_wall_action').live('click', function () {
	if (!confirm('Действительно удалить?')) return false;
    if ($('#selected:checked').length < 1) {
        return alert('Вы не выбрали ни одного товара!');
    }
    $('#action_message').text('Идёт процесс удаления истории товаров из группы, пожалуйста подождите.');
    $('#loading_info').show();
    $('#products_table').hide();
    $('.success').remove();
    $('.warning').remove();
    $( "#progressbar_wrapper" ).hide();
    
    var request = $.ajax({
      url: "<?php echo htmlspecialchars_decode($ok_delete_wall); ?>",
      type: "POST",
      data: $("#formpost").serialize(),
      dataType: "html"
    });
    
    request.done(function(data) {
        refresh_list(data);
    });
});

$('.export_history').live('click', function () {
     var type = $(this).attr('data-type');
     var product_id = $(this).attr('data-id');
     var request = $.ajax({
      url: "<?php echo htmlspecialchars_decode($export_history); ?>",
      type: "GET",
      dataType: "html",
      data: {type: type, product_id: product_id}
    });
    if (type == 'albums') {
         var title = "История экспорта товара в альбом";
    }
    else {
        var title = 'История экспорта товара в тему';
    }
    
    request.done(function(data) {
        $( "#dialog-modal" ).html(data);
        $( "#dialog-modal" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                $( this ).dialog( "close" );
                }
            },
            title: title,
            maxHeight: 600
        });
    });
});

$('.date').datepicker({dateFormat: 'dd-mm-yy'});

function open_popup(box) {
    $("#background").show()
    $(box).centered_popup();
    $(box).delay(100).show(1);
}

function close_popup(box) {
    $(box).hide();
    $("#background").delay(100).hide(1);
}
    
$(document).ready(function() {
    $.fn.centered_popup = function() {
        this.css('top', ($(window).height() - this.height()) / 2 + $(window).scrollTop() + 'px');
        this.css('left', ($(window).width() - this.width()) / 2 + $(window).scrollLeft() + 'px');
    }
});

//--></script> 
<?php echo $footer; ?>
