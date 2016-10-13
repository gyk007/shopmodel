<?php 
class ControllerModuleMyIport extends Controller {
	
   
    
    public function index() {
		 	 
    	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
        $this->data['heloo'] = "Загрузите файл excel";
		$this->data['upload'] = $this->url->link('module/myiport/upload', 'token=' . $this->session->data['token'] . $url, 'SSL');		
		$this->response->setOutput($this->render());
        
      
        
	 
		 
	}
    public function upload() {
//	echo "</br> <b>Warning:</b> Cannot add header information - error in reading the file, check the download";
    //      exit();	  
    foreach (glob("*.xlsx") as $filename) {
     unlink($filename);
}
 foreach (glob("*.xls") as $filename) {
     unlink($filename);
}
     $uploadfile = $DIR_APPLICATION.$_FILES['myfile']['name'];
      $success_download = move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile);
 	 if($success_download){
 	  
 	  $this->data['success_download'] = "Файл успешно загружен";
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
        	$this->data['uploadOptions'] = $this->url->link('module/myiport/excelimportOptions', 'token=' . $this->session->data['token'] . $url, 'SSL');	
        $this->response->setOutput($this->render());
 	 }
     else{
         $this->data['success_download'] = "Ошибка Файл не загружен";
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
        	$this->data['upload'] = $this->url->link('module/myiport/upload', 'token=' . $this->session->data['token'] . $url, 'SSL');	
        $this->response->setOutput($this->render());
     }
	}
    
    
    
    /*************************/
   
 /**************************************Прогоняем опции*/      

    public function excelimportOptions(){
        /*Парсим файл excel*/
        $count = 0;
        $globalvaluemidel;
        $globalfilename;
         foreach (glob("*.xlsx") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        foreach (glob("*.xls") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        if($count == 1){
            require_once ('ClassesExcel/PHPExcel/IOFactory.php');
            $xls = PHPExcel_IOFactory::load($globalfilename);
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
             
 
   
 
for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {  
     
     
    $nColumn = PHPExcel_Cell::columnIndexFromString(
        $sheet->getHighestColumn());
     //echo "<b>".$nColumn."</b>";
    for ($j = 0; $j < $nColumn; $j++) {
       // $value2 = $sheet->getCellByColumnAndRow($j, $i)->getValue();
        $globalvaluemidel[$i][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
       /* if($j==0){
             $globalvaluemidel[$i][$j] = preg_replace ("/[^0-9-Nk]/","",$globalvaluemidel[$i][$j]);
            } */
    }
      
     
}
 /*Парсим файл excel*/
 
/*Получили массив с данными $globalvaluemidel*/  
  
    
 
  
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
foreach ($globalvaluemidel as $key => $row) {
    $volume[$key]  = $row[0];
    $edition[$key] = $row[10];
}  
array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $globalvaluemidel);   
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
 

/*$numberOfProductsOfTheSameType;
  считаю количство одной модели 
for($i = 2 ; $i <= 8; $i++){
    
       
            if(($globalvaluemidel[$i][0] == $globalvaluemidel[$i - 1][0]) && ($i != 0)){
                
            $numberOfProductsOfTheSameType = $numberOfProductsOfTheSameType + $globalvaluemidel[$i][2];  
            echo $globalvaluemidel[$i][2];
            echo "</br>";
        }
    }
 print_r($numberOfProductsOfTheSameType);*/

/*получаю необходимые данные из масссив $globalvaluemidel */ 
 
$color = array();
$size = array();


foreach ($globalvaluemidel as $value) {
      
       $color[] = $value[5];
       
}  

foreach ($globalvaluemidel as $value) {
      
       $size[] = $value[4];
       
}  

 
  
   
  $color =  array_unique($color);
  $size = array_unique($size); 
  sort($size);
   
$this->load->model('module/myimport'); 
$allModel = $this->model_module_myimport->updateAllProductOptions($color, $size);   
 

 
$this->data['successOptions'] = "Опции успешно обновлены";
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
	$this->data['uploadSize'] = $this->url->link('module/myiport/excelimportSize', 'token=' . $this->session->data['token'] . $url, 'SSL');	
        $this->response->setOutput($this->render());
    
}  
    
} 
  
    
    
    /*Прогоняем размеры*/
    
    
    
    public function excelimportSize(){
        /*Парсим файл excel*/
        $count = 0;
        $globalvaluemidel;
        $globalfilename;
         foreach (glob("*.xlsx") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        foreach (glob("*.xls") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        if($count == 1){
            require_once ('ClassesExcel/PHPExcel/IOFactory.php');
            $xls = PHPExcel_IOFactory::load($globalfilename);
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
             
 
   
 
for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {  
     
     
    $nColumn = PHPExcel_Cell::columnIndexFromString(
        $sheet->getHighestColumn());
     //echo "<b>".$nColumn."</b>";
    for ($j = 0; $j < $nColumn; $j++) {
       // $value2 = $sheet->getCellByColumnAndRow($j, $i)->getValue();
        $globalvaluemidel[$i][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
       /* if($j==0){
             $globalvaluemidel[$i][$j] = preg_replace ("/[^0-9-Nk]/","",$globalvaluemidel[$i][$j]);
            } */
    }
      
     
}
 /*Парсим файл excel*/
 
/*Получили массив с данными $globalvaluemidel*/  
  
    
 
  
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
foreach ($globalvaluemidel as $key => $row) {
    $volume[$key]  = $row[0];
    $edition[$key] = $row[10];
}  
array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $globalvaluemidel);   
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
 

 

/*получаю необходимые данные из масссив $globalvaluemidel */ 
 
$arrayModelSize  = array ();
$arrayModelSizeTEMP  = array ();
 


 
foreach ($globalvaluemidel as $value){
    
  $arrayModelSizeTEMP[]  =  $value[0].";".$value[4];    
        
}
$arrayModelSizeTEMP = array_unique($arrayModelSizeTEMP);
 
    
foreach ($arrayModelSizeTEMP as $value){
  $tempArr = explode(";", $value); 
  $temp  = new modelSize($tempArr[0] ,$tempArr[1]);    
  $arrayModelSize[] = $temp;      
}
 
   
   
$this->load->model('module/myimport'); 
$allModel = $this->model_module_myimport->updateAllProductSize($arrayModelSize);   

$this->data['successSize'] = "Размеры обнавлены";
 
         
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
$this->data['uploadColor'] = $this->url->link('module/myiport/excelimportColor', 'token=' . $this->session->data['token'] . $url, 'SSL');	
$this->response->setOutput($this->render());  
    
}  
    
}

/* ********** Атрибуты ******* */

 public function excelimportSizeAttribute(){
        /*Парсим файл excel*/
        $count = 0;
        $globalvaluemidel;
        $globalfilename;
         foreach (glob("*.xlsx") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        foreach (glob("*.xls") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        if($count == 1){
            require_once ('ClassesExcel/PHPExcel/IOFactory.php');
            $xls = PHPExcel_IOFactory::load($globalfilename);
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
             
 
   
 
for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {  
     
     
    $nColumn = PHPExcel_Cell::columnIndexFromString(
        $sheet->getHighestColumn());
     //echo "<b>".$nColumn."</b>";
    for ($j = 0; $j < $nColumn; $j++) {
       // $value2 = $sheet->getCellByColumnAndRow($j, $i)->getValue();
        $globalvaluemidel[$i][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
       /* if($j==0){
             $globalvaluemidel[$i][$j] = preg_replace ("/[^0-9-Nk]/","",$globalvaluemidel[$i][$j]);
            } */
    }
      
     
}
 /*Парсим файл excel*/
 
/*Получили массив с данными $globalvaluemidel*/  
  
    
 
  
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
foreach ($globalvaluemidel as $key => $row) {
    $volume[$key]  = $row[0];
    $edition[$key] = $row[10];
}  
array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $globalvaluemidel);   
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
 

 

/*получаю необходимые данные из масссив $globalvaluemidel */ 
 
$arrayModelSize  = array ();
$arrayModelSizeTEMP  = array ();
 


 
foreach ($globalvaluemidel as $value){
    
  $arrayModelSizeTEMP[]  =  $value[0].";".$value[4];    
        
}
$arrayModelSizeTEMP = array_unique($arrayModelSizeTEMP);
 
    
foreach ($arrayModelSizeTEMP as $value){
  $tempArr = explode(";", $value); 
  $temp  = new modelSize($tempArr[0] ,$tempArr[1]);    
  $arrayModelSize[] = $temp;      
}
 
   
   
$this->load->model('module/myimport'); 
$allModel = $this->model_module_myimport->updateAllProductSizeAttribute($arrayModelSize);   

$this->data['successAttribute'] = "Атрибуты обнавлены";
 
         
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
$this->data['uploadIsSet'] = $this->url->link('module/myiport/excelimportIsSet', 'token=' . $this->session->data['token'] . $url, 'SSL');	
$this->response->setOutput($this->render());  
    
}  
    
}


/**************************************Прогоняем цвета*/
               
public function excelimportColor(){
        /*Парсим файл excel*/
        $count = 0;
        $globalvaluemidel;
        $globalfilename;
         foreach (glob("*.xlsx") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        foreach (glob("*.xls") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        if($count == 1){
            require_once ('ClassesExcel/PHPExcel/IOFactory.php');
            $xls = PHPExcel_IOFactory::load($globalfilename);
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
             
 
   
 
for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {  
     
     
    $nColumn = PHPExcel_Cell::columnIndexFromString(
        $sheet->getHighestColumn());
     //echo "<b>".$nColumn."</b>";
    for ($j = 0; $j < $nColumn; $j++) {
       // $value2 = $sheet->getCellByColumnAndRow($j, $i)->getValue();
        $globalvaluemidel[$i][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
       /* if($j==0){
             $globalvaluemidel[$i][$j] = preg_replace ("/[^0-9-Nk]/","",$globalvaluemidel[$i][$j]);
            } */
    }
      
     
}
 /*Парсим файл excel*/
 
/*Получили массив с данными $globalvaluemidel*/  
  
    
 
  
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
foreach ($globalvaluemidel as $key => $row) {
    $volume[$key]  = $row[0];
    $edition[$key] = $row[10];
}  
array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $globalvaluemidel);   
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
 

 

/*получаю необходимые данные из масссив $globalvaluemidel */ 
 
$arrayModelColor  = array ();
$arrayModelColorTEMP  = array ();


foreach ($globalvaluemidel as $value){
    
  $arrayModelColorTEMP[]  =  $value[0].";".$value[5];    
        
}

 
 
$arrayModelColorTEMP =  array_unique($arrayModelColorTEMP) ;
 
 
//$arrayModelColorTEMP = arrRepeat($arrayModelColorTEMP);
 
foreach ($arrayModelColorTEMP as $value){
  $tempArr = explode(";", $value); 
  $temp  = new modelColor($tempArr[0] ,$tempArr[1]);    
  $arrayModelColor[] = $temp;      
} 
 
  
 
   
 
    /*foreach($arrayModelColor as $model){
    echo $model->model."=>".$model->color."<br/>";
        
  }  */
  //http://www.goldenvalley.log/admin/index.php?route=module/myiport/excelimportColor&token=172758d12597cff4b28fe3bb5595d729


 $this->load->model('module/myimport');
 $allModel = $this->model_module_myimport->updateAllProductColor($arrayModelColor);       


 
$this->data['successColor'] = "Цвета успешно обновлены";
 
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
$this->data['uploadDelete'] = $this->url->link('module/myiport/deleteColorAndSize', 'token=' . $this->session->data['token'] . $url, 'SSL');	
$this->response->setOutput($this->render());  
 
    
}  
    
} 


/******Таблица цвет - размер ****/ 

public function deleteColorAndSize(){
    $this->load->model('module/myimport');
  $allModel = $this->model_module_myimport->DeleteAllColorAndSize();       
 
 
  
 $this->data['successDelete'] = "Таблица размеров и цветов успешно удалена";
  
  	  	$this->template = 'module/myimport.tpl';
 		$this->children = array(
 			'common/header',
 			'common/footer'
 		);
 $this->data['uploadAvailability'] = $this->url->link('module/myiport/excelimportColorAndSize', 'token=' . $this->session->data['token'] . $url, 'SSL');	
 $this->response->setOutput($this->render());  
    
    
    
    
}
public function excelimportColorAndSize(){
        /*Парсим файл excel*/
        $count = 0;
        $globalvaluemidel;
        $globalfilename;
         foreach (glob("*.xlsx") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        foreach (glob("*.xls") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        if($count == 1){
            require_once ('ClassesExcel/PHPExcel/IOFactory.php');
            $xls = PHPExcel_IOFactory::load($globalfilename);
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
             
 
   
 
for ($i = 0; $i <= $sheet->getHighestRow(); $i++) {  
     
     
    $nColumn = PHPExcel_Cell::columnIndexFromString(
        $sheet->getHighestColumn());
     //echo "<b>".$nColumn."</b>";
    for ($j = 0; $j < $nColumn; $j++) {
       // $value2 = $sheet->getCellByColumnAndRow($j, $i)->getValue();
        $globalvaluemidel[$i][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
       /* if($j==0){
             $globalvaluemidel[$i][$j] = preg_replace ("/[^0-9-Nk]/","",$globalvaluemidel[$i][$j]);
            } */
    }
      
     
}
 /*Парсим файл excel*/
 
/*Получили массив с данными $globalvaluemidel*/  
  
    
 
  
 
 

 

/*получаю необходимые данные из масссив $globalvaluemidel */ 
 
 
$arrayModelSizeColor   = array ();


 

foreach ($globalvaluemidel as $value){
     
     if(isset($arrayModelSizeColor[$value[0].";".$value[5]])){
         $arrayModelSizeColor[$value[0].";".$value[5]] .= ";".$value[4];
     }
     else{
        $arrayModelSizeColor[$value[0].";".$value[5]] = $value[4];
     }
     
     
     }  
  
      
 
  $this->load->model('module/myimport');
  $allModel = $this->model_module_myimport->updateAllColorAndSize($arrayModelSizeColor);       
 
 
  
 $this->data['successAvailability'] = "Таблица размеров и цветов успешно обновлена";
  
  	  	$this->template = 'module/myimport.tpl';
 		$this->children = array(
 			'common/header',
 			'common/footer'
 		);
 $this->data['uploadPrice'] = $this->url->link('module/myiport/excelimportPrice', 'token=' . $this->session->data['token'] . $url, 'SSL');	
 $this->response->setOutput($this->render());  
  
    
}  
    
}             



/******Таблица цвет - размер ****/             
 
 
/**************************************Прогоняем цену*/ 
 
 public function excelimportPrice(){
        /*Парсим файл excel*/
        $count = 0;
        $globalvaluemidel;
        $globalfilename;
         foreach (glob("*.xlsx") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        foreach (glob("*.xls") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        if($count == 1){
            require_once ('ClassesExcel/PHPExcel/IOFactory.php');
            $xls = PHPExcel_IOFactory::load($globalfilename);
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
             
 
   
 
for ($i = 2; $i <= $sheet->getHighestRow(); $i++) {  
     
     
    $nColumn = PHPExcel_Cell::columnIndexFromString(
        $sheet->getHighestColumn());
     //echo "<b>".$nColumn."</b>";
    for ($j = 0; $j < $nColumn; $j++) {
       // $value2 = $sheet->getCellByColumnAndRow($j, $i)->getValue();
        $globalvaluemidel[$i][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
       /* if($j==0){
             $globalvaluemidel[$i][$j] = preg_replace ("/[^0-9-Nk]/","",$globalvaluemidel[$i][$j]);
            } */
    }
      
     
}
 /*Парсим файл excel*/
 
/*Получили массив с данными $globalvaluemidel*/  
  
    
 
  
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
foreach ($globalvaluemidel as $key => $row) {
    $volume[$key]  = $row[0];
    $edition[$key] = $row[10];
}  
array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $globalvaluemidel);   
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
 
 

/*получаю необходимые данные из масссив $globalvaluemidel */ 
$allModel = array();
$artickle = array(); 
$price = array();
$modelAndPrice = array();


 foreach ($globalvaluemidel as $value) {
      
       $price[] = $value[12];
       
}  
    

foreach ($globalvaluemidel as $value) {
     
           $artickle[] = $value[0] ;
                  
    
}
 
$modelAndPrice =  array_combine($artickle , $price);
 

  
   
  
   
$this->load->model('module/myimport'); 
$allModel = $this->model_module_myimport->getAllProductModel();   
$this->model_module_myimport->updateAllProductPrice($modelAndPrice, $allModel);      

$this->data['successPrice'] = "Цены обновлены";
 
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
$this->data['uploadSizeAttribute'] = $this->url->link('module/myiport/excelimportSizeAttribute', 'token=' . $this->session->data['token'] . $url, 'SSL');	
$this->response->setOutput($this->render());  
    
}  
    
}  





 


/**************************************Проверяем модели*/ 
 public function excelimportIsSet(){
        /*Парсим файл excel*/
        $count = 0;
        $globalvaluemidel;
        $globalfilename;
         foreach (glob("*.xlsx") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        foreach (glob("*.xls") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        if($count == 1){
            require_once ('ClassesExcel/PHPExcel/IOFactory.php');
            $xls = PHPExcel_IOFactory::load($globalfilename);
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
             
 
   
 
for ($i = 0; $i <= $sheet->getHighestRow(); $i++) {  
     
     
    $nColumn = PHPExcel_Cell::columnIndexFromString(
        $sheet->getHighestColumn());
     //echo "<b>".$nColumn."</b>";
    for ($j = 0; $j < $nColumn; $j++) {
       // $value2 = $sheet->getCellByColumnAndRow($j, $i)->getValue();
        $globalvaluemidel[$i][$j] = $sheet->getCellByColumnAndRow($j, $i)->getValue();
       /* if($j==0){
             $globalvaluemidel[$i][$j] = preg_replace ("/[^0-9-Nk]/","",$globalvaluemidel[$i][$j]);
            } */
    }
      
     
}
 /*Парсим файл excel*/
 
/*Получили массив с данными $globalvaluemidel*/  
  
    
 
  
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
foreach ($globalvaluemidel as $key => $row) {
    $volume[$key]  = $row[0];
    $edition[$key] = $row[10];
}  
array_multisort($volume, SORT_ASC, $edition, SORT_ASC, $globalvaluemidel);   
/* сортируем масссив $globalvaluemidel по названию модели и по количеству */  
 

 

/*получаю необходимые данные из масссив $globalvaluemidel */ 
$allModel = array();
$artickle = array();
 

  

foreach ($globalvaluemidel as $value) {
     
           $artickle[] = $value[0] ;
                  
    
}
 
 
  
   
  $artickle = array_unique($artickle);
  
   
   
$this->load->model('module/myimport'); 
$allModel = $this->model_module_myimport->getAllProductModel();   
 

$result = array_diff($allModel, $artickle);
$netNaSaite  =  array_diff($artickle, $allModel);
$this->model_module_myimport->updateAllProductStatus($result);      

$this->data['successIsSet'] = "База успешно обновлена";
$this->data['netNaSaite'] = $netNaSaite;
$this->data['uploadFoto'] = $this->url->link('module/myiport/excelimportImage', 'token=' . $this->session->data['token'] . $url, 'SSL');	
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
$this->response->setOutput($this->render());  
    
}  
    
} 


/***Импорт ФОТО***/
  public function excelimportImage(){
        /*Парсим файл excel*/
          $count = 0;
       
        $globalfilename;
        $arrPicture ;
        $ModelKodeColor = array();
        
         foreach (glob("*.xlsx") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        foreach (glob("*.xls") as $filename) {
     $globalfilename = $filename;
     $count++;
        }
        if($count == 1){
            require_once ('ClassesExcel/PHPExcel/IOFactory.php');
            $xls = PHPExcel_IOFactory::load($globalfilename);
            $xls->setActiveSheetIndex(0);
            $sheet = $xls->getActiveSheet();
             
 
   $nColumn = PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn());
   $nRow = $sheet->getHighestRow();
   
for ($i = 0; $i <= $sheet->getHighestRow(); $i++) {      
      
      
    for ($j = 0; $j < 1; $j++) {
        
        $keyCode = $sheet->getCellByColumnAndRow(13, $i)->getValue();
         $coloModel = $sheet->getCellByColumnAndRow(5, $i)->getValue();
        $valueModel =  $sheet->getCellByColumnAndRow(0, $i)->getValue();
        
        $arrCodeModel[(string)$keyCode] = (string)$valueModel.";".$coloModel;
         
           
    }
    
   
} 
  $arrCodeModel = array_unique($arrCodeModel);   

foreach ($arrCodeModel as $code=>$modelColor){
  $tempArr = explode(";", $modelColor); 
      
  $arrCodeModel[$code] = $tempArr[0];      
}
      
        
/*END Парсим файл excel*/
 
/*Считываеи все файлы в папке*/
 
  foreach (glob("../../goldenvaleyShop/image/data/allfoto/*.jpg") as $picture)    {
        $key = basename($picture, ".jpg");
        $picture = str_ireplace("../image/", "", $picture);        
        $arrPicture[(string)$key] = $picture;
        
    } 
  
 $this->load->model('module/myimport'); 
$allModel = $this->model_module_myimport->getAllProductModel();  
 
$arrCodeModel = array_intersect($arrCodeModel, $allModel); //  удаляем из списка те модели которых нет на сайте

$notSetPicturesForThisModel = array_diff_key($arrCodeModel,$arrPicture); // список моделей для которых нет фото

 
 
$arrAllPictures = array_intersect_key($arrCodeModel ,$arrPicture); // массив код=>модель
$arrFirstPictures = array_unique($arrAllPictures); // для первой фотографии массив код=>модель
  
$this->model_module_myimport->updatePicture($arrFirstPictures, $arrAllPictures);      
 
  

$this->data['successFoto'] = "Фото обновлены";
$this->data['countFotoIsNot'] = count($notSetPicturesForThisModel); 
 $this->data['netNaSaiteFoto'] = $notSetPicturesForThisModel;
 	  	$this->template = 'module/myimport.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
 
$this->response->setOutput($this->render());   
   
  }   
    
}  


/***END Импорт ФОТО***/
  }
  
  
class modelPicture {
    public $code;
   // public $isSameObject;
    public $model;
    
    public $picture;
      
    function __construct($code, $picture, $model ) {
    $this->model = $model;
    $this->code = $code;
    $this->picture = $picture;
    
     
   }
}   
  
class modelSize {
    public $model;
   // public $isSameObject;
    public $size;
    
    function __construct($model, $size ) {
    $this->model = $model;
    $this->size = $size;
    
     
   }
} 
class modelColor {
    public $model;
   // public $isSameObject;
    public $color;
    
    function __construct($model, $color ) {
    $this->model = $model;
    $this->color = $color;
    
     
   }
}      
   function arrRepeat($arr){
       
       for ($i = 0 ; $i <= count($arr); $i++){
        for ($j = $i + 1 ; $j <= count($arr); $j++){
        if($arr[$i] == $arr[$j]){
            unset($arr[$j]);
        }
         
       }
        
       }
       
       return $arr;
    }   
 
?>
