<?php echo $header; ?>
<div id="content">
      <div class="box">
    <div class="heading">
      <h1><img src="view/image/order.png" alt="" /> Импорт</h1>
        
    </div>
    <div class="content">
    <?php if($success_download){ ?>
     <form action="<?php echo $uploadOptions; ?>" method="post" enctype="multipart/form-data" id="form">
            <p> 1 пункт выполнен</p>
            <p><?php echo $success_download;  ?></p>
           <input type="submit" value="Импортировать опции в базу"/>
           
           </form>
          <?php } ?> 
          
      <?php if($successOptions){ ?>    
          <form action="<?php echo $uploadSize; ?>" method="post" enctype="multipart/form-data" id="form">
            <p> 2 пункт выполнен</p>
            <p><?php echo $successOptions;  ?></p>
           <input type="submit" value="Импортировать размеры в базу"/>
           
           </form>
      
      
         
      <?php }  ?> 
      
       <?php if($successSize){ ?>    
          <form action="<?php echo $uploadColor; ?>" method="post" enctype="multipart/form-data" id="form">
            <p> 3 пункт выполнен</p>
            <p><?php echo $successSize;  ?></p>
           <input type="submit" value="Импортировать цвета в базу"/>
           
           </form>
       <?php }  ?>
       <?php if($successColor){ ?> 
        <form action="<?php echo $uploadDelete; ?>" method="post" enctype="multipart/form-data" id="form">
            <p> 4 пункт выполнен</p>
            <p><?php echo $successColor;  ?></p>
           <input type="submit" value="Удалить таблицу наличия из базы"/>
       
        
        <?php }  ?>
        <?php if($successAvailability){ ?> 
        <form action="<?php echo $uploadPrice; ?>" method="post" enctype="multipart/form-data" id="form">
            <p> 6 пункт выполнен</p>
            <p><?php echo $successAvailability;  ?></p>
           <input type="submit" value="Импортировать цены в базу"/>
       
        
        <?php }  ?>
        <?php if($successDelete){ ?> 
        <form action="<?php echo $uploadAvailability; ?>" method="post" enctype="multipart/form-data" id="form">
            <p> 5 пункт выполнен</p>
            <p><?php echo $successAvailability;  ?></p>
           <input type="submit" value="Импортировать таблицу наличия в базу"/>
       
        
        <?php }  ?>
         <?php if($successPrice){ ?>   
          <form action="<?php echo $uploadSizeAttribute ; ?>" method="post" enctype="multipart/form-data" id="form">
            <p> 7 пункт выполнен</p>
            <p><?php echo $successPrice;  ?></p>
           <input type="submit" value="Импортировать атрибуты в базу"/>
          
          
          <?php }  ?>
           <?php if($successAttribute){ ?>    
          <form action="<?php echo $uploadIsSet; ?>" method="post" enctype="multipart/form-data" id="form">
            <p> 8 пункт выполнен</p>
            <p><?php echo $successSize;  ?></p>
           <input type="submit" value="Проверить базу на соответсвие прайсу"/>
           
           </form>
       <?php }  ?> 
         <?php if($successIsSet){ ?>
         
         <form action="<?php echo $uploadFoto; ?>" method="post" enctype="multipart/form-data" id="form">
         <input type="submit" value="Обновить Фото"/>
         </form>
          <?php echo $success;  
            echo "<br/>";
            echo "Этих моделей нет на сайте";
            foreach ($netNaSaite as $model){?>
                <br/>
                <?php  echo $model ?>
                <br/>
            
         <?php   } ?>
          
         
             <?php }  ?> 
             
              <?php if($successFoto){ ?>    
          
            <p> 9 пункт выполнен</p>
            <p><?php echo $successFoto  ?></p>
             <p>Этих фото нет на сайте:</p>
             <p>Количество фото: <?php echo $countFotoIsNot; ?> </p>
           <?php foreach ($netNaSaiteFoto as $code=>$model){?>
                <br/>
                <b>Модель: <?php  echo $model ?></b>=>Код: <?php  echo $code ?> 
                <br/>          
          <?php }  ?> 
          <?php }  ?>    
          <?php if($heloo){ ?>
          
      <form action="<?php echo $upload; ?>" method="post" enctype="multipart/form-data" id="form">
          <p><?php echo $heloo;  ?></p>
          <input type="file"  name ="myfile"/>
         <input type="submit" value="Отправить файл"/>
           
            </form>
             
           <?php } ?> 
        
           
       
            
    </div>
  </div>
</div>
<?php echo $footer; ?>