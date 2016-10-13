<?php
class ModelModuleMyimport extends Model {
	 
	public function getAllProductModel() {
	   $allModel = array();
		$query = $this->db->query("SELECT  model  FROM " . DB_PREFIX . "product");
        foreach ($query as $valuemidel) {
      foreach ($valuemidel as $value ) {
      
        $allModel[] = $value['model'];
     }
   } 
		return $allModel;
	}
    public function updateAllProductStatus($arrayProduct) {
        $this->db->query("UPDATE " . DB_PREFIX . "product SET status = 1");
         foreach($arrayProduct as $model){
			$this->db->query("UPDATE " . DB_PREFIX . "product SET status = 0  WHERE model = '" . $model . "'");
            } 
		 
	}
         public function updateAllProductPrice($arrayPrice , $allModel) {
         $count = 1;
         $this->db->query("DELETE FROM " . DB_PREFIX . "product_discount");
           $this->db->query("DELETE FROM " . DB_PREFIX . "product_special");
         foreach ($arrayPrice as $model => $price) {
         
        if (in_array($model , $allModel)) {
              
     //$this->db->query("UPDATE " . DB_PREFIX . "product_discount SET price = ".(float)$price."  WHERE product_id = (SELECT  product_id FROM  oc_product WHERE  model = '". $model ."')" )  ;
            
          $queryModelId = $this->db->query("SELECT  product_id  FROM " . DB_PREFIX . "product WHERE model = '".$model."'");
            $priceRozn = $price * 1.5;
            $priceRozn = ceil($priceRozn);
            //print_r($queryModelId);
            if($queryModelId->row['product_id'] != null){
          $this->db->query(" INSERT INTO " . DB_PREFIX . "product_discount (product_id, customer_group_id, quantity, priority, price, date_start, date_end) VALUES (". $queryModelId->row['product_id'].", 2, 100, 1,".(float)$price.", 0, 0)" );
          $this->db->query(" INSERT INTO " . DB_PREFIX . "product_special (product_id, customer_group_id, priority, price, date_start, date_end) VALUES (". $queryModelId->row['product_id'].", 2, 1,".(float)$price.", 0, 0)" );      
         $count++;
         }
            
        $this->db->query("UPDATE " . DB_PREFIX . "product SET price = $priceRozn  WHERE model = '" . $model . "'");    
          
         //$count = $this->db->query("SELECT  COUNT(*) AS total  FROM " . DB_PREFIX . "product_attribute WHERE product_id = (SELECT  product_id FROM  oc_product WHERE  model = '". $model ."')" )  ;
         //$qveryRazmerniRadId = $this->db->query("SELECT  option_value_id  FROM " . DB_PREFIX . "option_value_description WHERE name = 'модельный ряд'");         
        // $count = $count->row['total'] / 2;  
        // $modelradprice = $count *  $price;
        // $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET price = ".$modelradprice." WHERE option_value_id = ".$qveryRazmerniRadId->row['option_value_id']." AND product_id = (SELECT  product_id FROM  oc_product WHERE  model = '". $model ."')" )  ;  
           
           
           
            }   
           
       
        } 

} 
public function DeleteAllColorAndSize($arrayModelSizeColor){
             
        $this->db->query("UPDATE " . DB_PREFIX . "product SET sizeAndColor = ''");
    } 
     

public function updateAllColorAndSize($arrayModelSizeColor){
        foreach($arrayModelSizeColor as $key => $value ){
            
        $modelColor = explode(";", $key);
        $sizes = explode(";", $value);
         sort($sizes);
        $tableColorAndSize = "<table><tr><td>".$modelColor[1].": </td>";
         foreach($sizes as $size){            
           $tableColorAndSize .= "<td>".$size."</td>";  
         }
             $tableColorAndSize .= "</tr></table>";
             //echo $modelColor[0]." :</br>".$tableColorAndSize;
       // $this->db->query("UPDATE " . DB_PREFIX . "product SET ColorAndSize = ''");     
        $this->db->query("UPDATE " . DB_PREFIX . "product SET sizeAndColor = concat(sizeAndColor,'".$tableColorAndSize."')  WHERE model = '".$modelColor[0]."'");
    }
  }  
    
    
public function updateAllProductOptions($arrayColor, $arraySize){
    // $arraySize[] = "модельный ряд";
      $this->db->query("DELETE FROM " . DB_PREFIX . "attribute");
       $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_description");
        $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_group");
         $this->db->query("DELETE FROM " . DB_PREFIX . "attribute_group_description");
          $this->db->query("DELETE FROM " . DB_PREFIX . "product_attribute");
     $this->db->query("DELETE FROM " . DB_PREFIX . "option");
     $this->db->query("DELETE FROM " . DB_PREFIX . "option_description");
     $this->db->query("DELETE FROM " . DB_PREFIX . "option_value");
     $this->db->query("DELETE FROM " . DB_PREFIX . "option_value_description");
     $this->db->query("DELETE FROM " . DB_PREFIX . "product_option");
     $this->db->query("DELETE FROM " . DB_PREFIX . "product_option_value");
    //  INSERT INTO  attribute_group
   $this->db->query(" INSERT INTO " . DB_PREFIX . "attribute_group_description (attribute_group_id, language_id, name) VALUES (1, 1, 'Размеры')" );
      $this->db->query(" INSERT INTO " . DB_PREFIX . "attribute_group_description (attribute_group_id, language_id, name) VALUES (1, 2, 'Размеры')" );
  
   $this->db->query(" INSERT INTO " . DB_PREFIX . "attribute_group (attribute_group_id, sort_order) VALUES (1, 1)" );
       
    //  INSERT INTO  attribute 
  $countAttribute = 1;
    foreach ($arraySize as $size){
         
        $this->db->query(" INSERT INTO " . DB_PREFIX . "attribute_description (attribute_id, language_id, name) VALUES (".$countAttribute.", 1, '".$size."')" );
        
        $this->db->query(" INSERT INTO " . DB_PREFIX . "attribute (attribute_id, attribute_group_id, sort_order) VALUES (".$countAttribute.", 1, 1)" );
         
        
         $countAttribute++;
    } 
  
   //  INSERT INTO  option
     $this->db->query(" INSERT INTO " . DB_PREFIX . "option (option_id, type, sort_order) VALUES (1, 'radio', 1)" );
      $this->db->query(" INSERT INTO " . DB_PREFIX . "option (option_id, type, sort_order) VALUES (2, 'select', 2)" );
  //  INSERT INTO  option_description
     $this->db->query(" INSERT INTO " . DB_PREFIX . "option_description (option_id, language_id, name) VALUES (1, 1, 'Размер')" );
     $this->db->query(" INSERT INTO " . DB_PREFIX . "option_description (option_id, language_id, name) VALUES (2, 1, 'Цвет')" );
    //  INSERT INTO  option_value and option_value_description
    $countOption = 1;
    foreach ($arraySize as $size){
         
        $this->db->query(" INSERT INTO " . DB_PREFIX . "option_value (option_value_id, option_id, image, sort_order) VALUES (".$countOption.", 1, 'no_image.jpg', ".$countOption.")" );
        
        $this->db->query(" INSERT INTO " . DB_PREFIX . "option_value_description (option_value_id, language_id, option_id, name) VALUES (".$countOption.", 1, 1, '".$size."')" );
         
        
         $countOption++;
    } 
     
    foreach ($arrayColor as $color){
        
        $this->db->query(" INSERT INTO " . DB_PREFIX . "option_value (option_value_id, option_id, image, sort_order) VALUES (". $countOption .", 2, 'no_image.jpg', ". $countOption .")" );
        
        $this->db->query(" INSERT INTO " . DB_PREFIX . "option_value_description (option_value_id, language_id, option_id, name) VALUES (". $countOption .", 1, 2, '". $color ."')" );
        
        
        $countOption++;
    
    }
    
}
public function updateAllProductSizeAttribute($arrayModelSize){
      foreach($arrayModelSize as $model){ 
      
       $queryProductAttributeId = $this->db->query("SELECT  attribute_id  FROM " . DB_PREFIX . "attribute_description WHERE name = '".$model->size."'");   
       $queryModelId = $this->db->query("SELECT  product_id  FROM " . DB_PREFIX . "product WHERE model = '".$model->model."'");
         
        if($queryModelId->row['product_id'] != null){
          
          $this->db->query(" INSERT INTO " . DB_PREFIX . "product_attribute (product_id, attribute_id, language_id, text) 
         VALUES (".$queryModelId->row['product_id'].", ".$queryProductAttributeId->row['attribute_id'].", 1 , ' ')" );    
          
        }  
      
    }    
}
public function updateAllProductSize($arrayModelSize){    
    
    //  INSERT INTO  product_option and product_option_value
    
     $allModelId = array();
		$query = $this->db->query("SELECT  product_id  FROM " . DB_PREFIX . "product");
        foreach ($query->rows as $valuemidel) {
      $allModelId[] = $valuemidel['product_id'] ;
     }
     
    $queryCountProductOptionId = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option");
    $countProductOptionId = $queryCountProductOptionId->row['total'] + 1;
     		 
   foreach( $allModelId as $id) {    
    //  echo $id."=>".$countProductOptionId."<br/>";
     $this->db->query(" INSERT INTO " . DB_PREFIX . "product_option (product_option_id, product_id, option_id, option_value, required) VALUES (".$countProductOptionId.", ".$id.", 1 ,'', 1 )" );
     //echo " INSERT INTO " . DB_PREFIX . "product_option (product_option_id, product_id, option_id, option_value, required) VALUES (".$countProductOptionId.", ".$id.", 1 ,'', 1 )" ;
     $countProductOptionId++;
      
   }
     $queryCountProductOptionValueId = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option_value");
    $countProductOptionValueId = $queryCountProductOptionValueId->row['total'];
    foreach($arrayModelSize as $model){ 
      
       
       $queryModelId = $this->db->query("SELECT  product_id  FROM " . DB_PREFIX . "product WHERE model = '".$model->model."'");
        $queryModelId->row['product_id'];
        if($queryModelId->row['product_id'] != null){
         $queryProductOptionId = $this->db->query("SELECT  product_option_id  FROM " . DB_PREFIX . "product_option WHERE product_id = ".$queryModelId->row['product_id']." AND option_id = 1"); 
         $queryOptionValueId = $this->db->query("SELECT  option_value_id  FROM " . DB_PREFIX . "option_value_description WHERE name = '".$model->size."'"); 
        // echo "SELECT  option_value_id  FROM " . DB_PREFIX . "option_value_description WHERE name = '".$model->size."'" 
         $this->db->query(" INSERT INTO " . DB_PREFIX . "product_option_value (product_option_value_id, product_option_id, product_id, option_id, option_value_id, quantity, subtract, price, price_prefix, points, points_prefix, weight, weight_prefix, customer_group_id) 
         VALUES (".$countProductOptionValueId.", ".$queryProductOptionId->row['product_option_id'].", ".$queryModelId->row['product_id'].", 1,".$queryOptionValueId->row['option_value_id'].", 1000, 1, 0, '+', 0, '+', 0, '+', 1 )" );    
           
                
         $countProductOptionValueId++;
        }  
      
    }  
   // $qveryRazmerniRadId = $this->db->query("SELECT  option_value_id  FROM " . DB_PREFIX . "option_value_description WHERE name = 'модельный ряд'");
    
 /*   foreach( $allModelId as $id) {    
    //  echo $id."=>".$countProductOptionId."<br/>";
     $queryProductOptionId = $this->db->query("SELECT  product_option_id  FROM " . DB_PREFIX . "product_option WHERE product_id = ".$id." AND option_id = 1"); 
      $this->db->query(" INSERT INTO " . DB_PREFIX . "product_option_value (product_option_value_id, product_option_id, product_id, option_id, option_value_id, quantity, subtract, price, price_prefix, points, points_prefix, weight, weight_prefix, customer_group_id) 
         VALUES (".$countProductOptionValueId.", ".$queryProductOptionId->row['product_option_id'].", ".$id.", 1,".$qveryRazmerniRadId->row['option_value_id'].", 1000, 1, 0, '+', 0, '+', 0, '+', 1 )" );    
     //echo " INSERT INTO " . DB_PREFIX . "product_option (product_option_id, product_id, option_id, option_value, required) VALUES (".$countProductOptionId.", ".$id.", 1 ,'', 1 )" ;
    $countProductOptionValueId++;
      
   } */
    
        
  }
  public function updateAllProductColor($arrayModelColor){
    
    //  INSERT INTO  product_option and product_option_value
    
     $allModelId = array();
		$query = $this->db->query("SELECT  product_id  FROM " . DB_PREFIX . "product");
        foreach ($query->rows as $valuemidel) {
      $allModelId[] = $valuemidel['product_id'] ;
     }
   $queryProductOptionId = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option");
    $countProductOptionId = $queryProductOptionId->row['total'] + 1;
    	 
    foreach( $allModelId as $id) {    
     
    
     $this->db->query(" INSERT INTO " . DB_PREFIX . "product_option (product_option_id, product_id, option_id, option_value, required) VALUES (".$countProductOptionId.", ".$id.", 2 ,'', 1 )" );
     $countProductOptionId++;
   }
   
     $queryProductOptionValueId = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product_option_value");
    $countProductOptionValueId = $queryProductOptionValueId->row['total'];
    // echo $countProductOptionValueId;
      foreach($arrayModelColor as $model){          
        $queryModelId = $this->db->query("SELECT  product_id  FROM " . DB_PREFIX . "product WHERE model = '".$model->model."'");
       // $queryModelId->row['product_id'];
        if($queryModelId->row['product_id'] != null){
         $queryProductOptionId = $this->db->query("SELECT  product_option_id  FROM " . DB_PREFIX . "product_option WHERE product_id = ".$queryModelId->row['product_id']." AND option_id = 2"); 
         $queryOptionValueId = $this->db->query("SELECT  option_value_id  FROM " . DB_PREFIX . "option_value_description WHERE name = '".$model->color."'"); 
        // echo $queryModelId->row['product_id']."=>".$queryProductOptionId->row['product_option_id']."=>".$queryOptionValueId->row['option_value_id']."<br/>"; 
         $this->db->query(" INSERT INTO " . DB_PREFIX . "product_option_value (product_option_value_id, product_option_id, product_id, option_id, option_value_id, quantity, subtract, price, price_prefix, points, points_prefix, weight, weight_prefix, customer_group_id) 
         VALUES (".$countProductOptionValueId.", ".$queryProductOptionId->row['product_option_id'].", ".$queryModelId->row['product_id'].", 2,".$queryOptionValueId->row['option_value_id'].", 1000, 1, 0, '+', 0, '+', 0, '+', 1 )" );    
         $countProductOptionValueId++;
        }  
      
    }
   
  }
 public function updatePicture($arrFirstPictures, $arrAllPictures){
   /* foreach($arrFirstPictures as $code=>$model){
         
        $this->db->query("UPDATE " . DB_PREFIX . "product SET image = 'data/test/".$code.".jpg'  WHERE model = '" . $model . "'");  
        
    } */  // 
    
    $this->db->query("DELETE FROM " . DB_PREFIX . "product_image");
      
       
     foreach($arrAllPictures as $code=>$model){
         
        $queryModelId = $this->db->query("SELECT  product_id  FROM " . DB_PREFIX . "product WHERE model = '".$model."'"); 
        echo  $queryModelId;
       $this->db->query(" INSERT INTO " . DB_PREFIX . "product_image (product_id, image, sort_order) VALUES (".$queryModelId->row['product_id'].", 'data/allfoto/".$code.".jpg', 0)" );
        
    }
     
     
     
 }
}
?>
