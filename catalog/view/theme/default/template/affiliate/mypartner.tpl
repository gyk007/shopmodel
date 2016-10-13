<?php echo $header; ?>
<div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <h1><?php echo $heading_title; ?></h1>
  <div class="main-content">
   
    <h2>Партнеры 1 уровня</h2>
    <div class="content1">
    <table style="margin: 0 auto;">
    <tr>
    
    <th>E-mail <br /> Подключено <br />Продано <br /> Дата регистрации </th>
    <th>Фамилия И.О.</th>
    <th>Телефон</th>
    <th>Skype</th>
    <th>Город</th>
    <th>E-mail </br> главного партнера</th>
   </tr>
    <?php 
   
     
    foreach ($mypartner1 as $s) { ?>
     <?php 
     if(($s['tupe'] == '1') && $s['status'] == '1'  )
     {
        $countPartner = $this->model_affiliate_affiliate->getCountAffiliate($s['email']);
        $countTransaction = $this->model_affiliate_affiliate->getCountAffiliateTransaction($s['affiliate_id']);
        echo"<tr>";
        echo "<td>".$s['email']."</br>";
         echo "<b>".$countPartner."</b></br>";
          echo "<b>". (($countTransaction - $countPartner) > 0 ?  $countTransaction - $countPartner :   0)."</b></br>";
        echo date('d.m.Y', strtotime($s['date_added']))."</td>";
     echo "<td>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td>".$s['telephone']."</td>";
       if($s['company'] == ''){
        echo "<td class =''> не указан </td>";
     }
     else{
        
        echo "<td class =''>".$s['company']."</td>";
     }
     
      
     echo "<td>".$s['city']."</td>";
     echo "<td>".$s['fax']."</td></tr>";  
     }
     else{
        $countPartner = $this->model_affiliate_affiliate->getCountAffiliate($s['email']);
        $countTransaction = $this->model_affiliate_affiliate->getCountAffiliateTransaction($s['affiliate_id']);
        echo"<tr>";
        echo "<td class ='tbred'>".$s['email']."</br>";
         echo "<b>".$countPartner."</b></br>";
          echo "<b>". (($countTransaction - $countPartner) > 0 ?  $countTransaction - $countPartner :   0)."</b></br>";
        echo date('d.m.Y', strtotime($s['date_added']))."</td>";
     echo "<td class ='tbred'>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td class ='tbred'>".$s['telephone']."</td>"; 
      if($s['company'] == ''){
        echo "<td class ='tbred'> не указан </td>";
     }
     else{
        
        echo "<td class ='tbred'>".$s['company']."</td>";
     }
     echo "<td class ='tbred'>".$s['city']."</td>";
     echo "<td class ='tbred'>".$s['fax']."</td></tr>";
     }
      ?> 
  <?php } ?>
  </table>
  </div>
  
    <h2>Партнеры 2 уровня</h2>
    <div class="content1">
    <table style="margin: 0 auto;">
    <tr>
    
  <th>E-mail <br /> Подключено <br />Продано <br /> Дата регистрации </th>
    <th>Фамилия И.О.</th>
    <th>Телефон</th>
    <th>Skype</th>
    <th>Город</th>
    <th>E-mail </br> главного партнера</th>
   </tr>
    <?php 
   
    
    foreach ($mypartner2 as $s) { ?>
     <?php 
     if($s['tupe'] == '1' && $s['status'] == '1')
     {
        $countPartner = $this->model_affiliate_affiliate->getCountAffiliate($s['email']);
        $countTransaction = $this->model_affiliate_affiliate->getCountAffiliateTransaction($s['affiliate_id']);
        echo"<tr>";
     echo "<td>".$s['email']."</br>";
         echo "<b>".$countPartner."</b></br>";
          echo "<b>". (($countTransaction - $countPartner) > 0 ?  $countTransaction - $countPartner :   0)."</b></br>";
        echo date('d.m.Y', strtotime($s['date_added']))."</td>";
     echo "<td>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td>".$s['telephone']."</td>"; 
      if($s['company'] == ''){
        echo "<td class =''> не указан </td>";
     }
     else{
        
        echo "<td class =''>".$s['company']."</td>";
     }
     echo "<td>".$s['city']."</td>";
     echo "<td>".$s['fax']."</td></tr>";  
     }
     else{
        $countPartner = $this->model_affiliate_affiliate->getCountAffiliate($s['email']);
        $countTransaction = $this->model_affiliate_affiliate->getCountAffiliateTransaction($s['affiliate_id']);
         echo "<td class ='tbred'>".$s['email']."</br>";
         echo "<b>".$countPartner."</b></br>";
          echo "<b>". (($countTransaction - $countPartner) > 0 ?  $countTransaction - $countPartner :   0)."</b></br>";
        echo date('d.m.Y', strtotime($s['date_added']))."</td>";
     echo "<td class ='tbred'>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td class ='tbred'>".$s['telephone']."</td>"; 
      if($s['company'] == ''){
        echo "<td class ='tbred'> не указан </td>";
     }
     else{
        
        echo "<td class ='tbred'>".$s['company']."</td>";
     }
     echo "<td class ='tbred'>".$s['city']."</td>";
     echo "<td class ='tbred'>".$s['fax']."</td></tr>";
     }
      ?> 
  <?php } ?>
  </table>
  </div>
    
    <h2>Партнеры 3 уровня</h2>
    <div class="content1">
    <table style="margin: 0 auto;">
    <tr>
    
  <th>E-mail <br /> Подключено <br />Продано <br /> Дата регистрации </th>
    <th>Фамилия И.О.</th>
    <th>Телефон</th>
    <th>Skype</th>
    <th>Город</th>
    <th>E-mail </br> главного партнера</th>
   </tr>
    <?php 
   
    
    foreach ($mypartner3 as $s) { ?>
     <?php 
     if($s['tupe'] == '1' && $s['status'] == '1')
     {
        $countPartner = $this->model_affiliate_affiliate->getCountAffiliate($s['email']);
        $countTransaction = $this->model_affiliate_affiliate->getCountAffiliateTransaction($s['affiliate_id']);
        echo"<tr>";
     echo "<td class ='tbred'>".$s['email']."</br>";
         echo "<b>".$countPartner."</b></br>";
          echo "<b>". (($countTransaction - $countPartner) > 0 ?  $countTransaction - $countPartner :   0)."</b></br>";
        echo date('d.m.Y', strtotime($s['date_added']))."</td>";
     echo "<td>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td>".$s['telephone']."</td>";
      if($s['company'] == ''){
        echo "<td class =''> не указан </td>";
     }
     else{
        
        echo "<td class =''>".$s['company']."</td>";
     } 
     echo "<td>".$s['city']."</td>";
     echo "<td>".$s['fax']."</td></tr>";  
     }
     else{
        $countPartner = $this->model_affiliate_affiliate->getCountAffiliate($s['email']);
        $countTransaction = $this->model_affiliate_affiliate->getCountAffiliateTransaction($s['affiliate_id']);
        echo"<tr>";
         echo "<td class ='tbred'>".$s['email']."</br>";
         echo "<b>".$countPartner."</b></br>";
          echo "<b>". (($countTransaction - $countPartner) > 0 ?  $countTransaction - $countPartner :   0)."</b></br>";
        echo date('d.m.Y', strtotime($s['date_added']))."</td>";
     echo "<td class ='tbred'>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td class ='tbred'>".$s['telephone']."</td>";
      if($s['company'] == ''){
        echo "<td class ='tbred'> не указан </td>";
     }
     else{
        
        echo "<td class =''class ='tbred'>".$s['company']."</td>";
     } 
     echo "<td class ='tbred'>".$s['city']."</td>";
     echo "<td class ='tbred'>".$s['fax']."</td></tr>";
     }
      ?> 
  <?php } ?>
  </table>
  </div>
   
   
   <h2>Партнеры 4 уровня</h2>
    <div class="content1">
    <table style="margin: 0 auto;">
    <tr>
    
   <th>E-mail <br /> Подключено <br />Продано <br /> Дата регистрации </th>
    <th>Фамилия И.О.</th>
    <th>Телефон</th>
    <th>Skype</th>
    <th>Город</th>
    <th>E-mail </br> главного партнера</th>
   </tr>
    <?php 
     
    foreach ($mypartner4 as $s) { ?>
     <?php 
     if($s['tupe'] == '1' && $s['status'] == '1')
     {
         $countPartner = $this->model_affiliate_affiliate->getCountAffiliate($s['email']);
        $countTransaction = $this->model_affiliate_affiliate->getCountAffiliateTransaction($s['affiliate_id']);
       echo "<td>".$s['email']."</br>";
         echo "<b>".$countPartner."</b></br>";
          echo "<b>". (($countTransaction - $countPartner) > 0 ?  $countTransaction - $countPartner :   0)."</b></br>";
        echo date('d.m.Y', strtotime($s['date_added']))."</td>";
     echo "<td>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td>".$s['telephone']."</td>"; 
      if($s['company'] == ''){
        echo "<td class =''> не указан </td>";
     }
     else{
        
        echo "<td class =''>".$s['company']."</td>";
     }
     echo "<td>".$s['city']."</td>";
     echo "<td>".$s['fax']."</td></tr>";  
     }
     else{
         $countPartner = $this->model_affiliate_affiliate->getCountAffiliate($s['email']);
        $countTransaction = $this->model_affiliate_affiliate->getCountAffiliateTransaction($s['affiliate_id']);
        echo "<td class ='tbred'>".$s['email']."</br>";
         echo "<b>".$countPartner."</b></br>";
          echo "<b>". (($countTransaction - $countPartner) > 0 ?  $countTransaction - $countPartner :   0)."</b></br>";
        echo date('d.m.Y', strtotime($s['date_added']))."</td>";
     echo "<td class ='tbred'>".$s['lastname']."</br>";
     echo  $s['firstname']."</td>"; 
     echo "<td class ='tbred'>".$s['telephone']."</td>";
      if($s['company'] == ''){
        echo "<td class ='tbred'> не указан </td>";
     }
     else{
        
        echo "<td class ='tbred'>".$s['company']."</td>";
     } 
     echo "<td class ='tbred'>".$s['city']."</td>";
     echo "<td class ='tbred'>".$s['fax']."</td></tr>";
     }
      ?> 
  <?php } ?>
  </table>
  </div>
   
  </div>
  <div class="bottom"></div>
  <?php echo $content_bottom; ?></div>
  
<?php echo $footer; ?> 