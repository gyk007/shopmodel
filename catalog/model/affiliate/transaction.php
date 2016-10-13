<?php
class ModelAffiliateTransaction extends Model {	
	public function getTransactions($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "affiliate_transaction` WHERE affiliate_id = '" . (int)$this->affiliate->getId() . "'";
		   
		$sort_data = array(
			'amount',
			'description',
			'date_added'
		);
	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY date_added";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);
	
		return $query->rows;
	}	
		
	public function getTotalTransactions() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "affiliate_transaction` WHERE affiliate_id = '" . (int)$this->affiliate->getId() . "'");
			
		return $query->row['total'];
	}	
			
	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM `" . DB_PREFIX . "affiliate_transaction` WHERE affiliate_id = '" . (int)$this->affiliate->getId() . "' GROUP BY affiliate_id");
		
		if ($query->num_rows) {
			return $query->row['total'];
		} else {
			return 0;	
		}
	}
    
   public function getMailAffiliateById($affiliate_id) {
		$query = $this->db->query("SELECT email FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "'");
         return $query->row;
	}
    public function getIdAffiliateByEmail($mail) {
		$query = $this->db->query("SELECT affiliate_id FROM " . DB_PREFIX . "affiliate WHERE email = '" . $mail. "'");
         return $query->row;
	}
    public function getIdCustomerByEmail($email) {
		$query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row;
	}
     public function getEmailCustomerById($id) {
		$query = $this->db->query("SELECT email FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$id . "'");
		
		return $query->row;
	}
    
    public function deleteTransaction($id, $summ) {
          
          if($summ >= 0){
                $mail = $this->getMailAffiliateById($id);
            $id_cost = $this->getIdCustomerByEmail($mail['email']);
        
			$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_transaction SET affiliate_id = '" . (int)$id . "', order_id = '0', description = '" . "перевод в кредиты для пользования" . "', amount = '" . -(float)$summ . "', date_added = NOW()");
            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$id_cost['customer_id'] . "', order_id = '0', description = 'перевод из кредитов для выплат', amount = '" . (float)$summ . "', date_added = NOW()");

            }
            
	}

public function deleteAccountTransaction($id, $summ) {
          
           
            if($summ >= 0){
               $mail = $this->getEmailCustomerById($id);
            $id_aff = $this->getIdAffiliateByEmail($mail['email']);
        
			$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate_transaction SET affiliate_id = '" . (int)$id_aff['affiliate_id'] . "', order_id = '0', description = '" . "перевод из кредитов для пользования" . "', amount = '" . (float)$summ . "', date_added = NOW()");
            $this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$id . "', order_id = '0', description = 'перевод в кредиты для выплат', amount = '" . -(float)$summ . "', date_added = NOW()");
            }
            
             ;
}
}
?>