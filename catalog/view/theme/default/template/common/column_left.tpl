<?php if ($modules) { ?>
<div id="column-left">
  <?php foreach ($modules as $module) { ?>
  <?php echo $module; ?>
  <?php } ?>
  <!--<a class = "myLeftA"  href="/register"   title="Скидки в интернет магазине">Получите скидку <br />10% - 20%</a>  
  <a class = "myLeftA"  href="/register"   title="Скидки в интернет магазине">Узнать оптовые цены</a>  -->
 <div class = "myLeftA">Все модели представленные на сайте есть в наличии</div>  
 <div class = "myLeftA">Бесплатная доставка по <br />Беларуси</div>  
 <div class = "myLeftA">Бесплатная доставка  по России при покупке <br /> от 2-х единиц  </div>
  
  <div id="mywebpay" style="margin-top: 15px;"><img id="mysaleimg" src = "webpay.png" width="260px" height="75px" alt="Скидки Белорусского трикотажа"/></div>
  <script type="text/javascript" src="//vk.com/js/api/openapi.js?113"></script>

<!-- VK Widget -->
<div style="margin-top: 15px;"> 
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 0, width: "260", height: "300", color1: 'FFFFFF', color2: '#8F7BB4', color3: '#8F7BB4'}, 98865685);
</script>
</div>


<div style="margin-top: 15px;"> 
<div id="ok_group_widget"></div>
<script>
!function (d, id, did, st) {
  var js = d.createElement("script");
  js.src = "http://connect.ok.ru/connect.js";
   
  js.onload = js.onreadystatechange = function () {
  if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
    if (!this.executed) {
      this.executed = true;
      setTimeout(function () {
        OK.CONNECT.insertGroupWidget(id,did,st);
       
      }, 0);
    }
  }}
  d.documentElement.appendChild(js);
}(document,"ok_group_widget","53606201426150","{width:260,height:285, color: '#8F7BB4'}");
</script>
</div> 


</div>




<?php } ?> 
 