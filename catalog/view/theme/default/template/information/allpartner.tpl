<?php echo $header; ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1>Все партнеры интернет магазина</h1>
  <div style=" padding: 15px; text-align: justify; font-size: 18px; ">На этой странице находятся данные наших партнеров. Если Вы заинтересованы в сотрудничестве с нашим интернет магазином (<span style="color: red;">оптовая продажа, партнерская программа </span> или иной вид деятельности), Вы можете связаться с нашими партнерами. Сортировка партнеров по городу.</div>
  <div class="main-content">
  
  <table class="allpartnertable" style="margin: 0 auto;">
    <tr>     
    <th>E-mail</th>
    <th>Фамилия И.О.</th>
    <th>Телефон</th>
     <th>Skype</th>
    <th>Город</th>    
   </tr>
  
 <?php 
   
     
    foreach ($affiliate_info as $s) {  
       
     if(($s['approved'] == '0') && ($s['status'] == '0')) {continue;}  
     if($s['email'] == 'gyk088@gmail.com' ) {continue;} 
         
     echo "<tr><td class =''>".$s['email']."</td>";
     echo "<td class =''>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td class =''>".$s['telephone']."</td>";
     if($s['company'] == ''){
        echo "<td class =''> не указан </td>";
     }
     else{
        
        echo "<td class =''>".$s['company']."</td>";
     }
        
     echo "<td class =''>".$s['city']."</td></tr>";      
      
       
    } ?>
    </table>
  </div>
  <div class="pagination"><?php echo $pagination; ?></div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>