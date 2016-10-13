<?php
class ModelAffiliateAffiliate extends Model {
	public function addAffiliate($data) {
	   $myPartner2 = $this->getAffiliateByEmail($this->db->escape($data['fax']));
              
         $partner2 = $myPartner2['fax']; 
        
        $myPartner3 = $this->getAffiliateByEmail($partner2);
        
        $partner3 = $myPartner3['fax'];
        
        $myPartner4 = $this->getAffiliateByEmail($partner3);
        
        $partner4 = $myPartner4['fax'];
       
       	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE  LOWER(email)  = '" . $data['email'] . "'");
        
        $costumer = $query->row;
        
      	$this->db->query("INSERT INTO " . DB_PREFIX . "affiliate SET firstname = '" . $costumer['firstname']  . "', lastname = '" . $costumer['lastname'] . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $costumer['telephone'] . "', fax = '" . $this->db->escape($data['fax']) . "', partner2 = '" . $partner2 ."', partner3 = '" . $partner3. "', partner4 = '" . $partner4. "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', company = '" . $this->db->escape($data['company']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "', code = '" . $this->db->escape(uniqid()) . "', commission = '" . (float)$this->config->get('config_commission') . "', tax = '" . $this->db->escape($data['tax']) . "', payment = '" . $this->db->escape($data['payment']) . "', cheque = '" . $this->db->escape($data['cheque']) . "', paypal = '" . $this->db->escape($data['paypal']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_number = '" . $this->db->escape($data['bank_branch_number']) . "', bank_swift_code = '" . $this->db->escape($data['bank_swift_code']) . "', bank_account_name = '" . $this->db->escape($data['bank_account_name']) . "', bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "', status = '1', approved = '1', tupe = '0' ,date_added = NOW()");
	
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET fax = '". $data['fax'] ."' WHERE LOWER(email) = '" . $data['email'] . "'");
		
        
        $this->language->load('mail/affiliate');
		
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		
		$message  = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";
		$message .= $this->language->get('text_approval') . "\n";
		$message .= $this->url->link('affiliate/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo($this->request->post['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
	}
	
	public function editAffiliate($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET   fax = '" . $this->db->escape($data['fax']) . "' WHERE email = '" . $this->db->escape($data['email']). "'");
	 
		$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET  fax = '" . $this->db->escape($data['fax']) . "', company = '" . $this->db->escape($data['company']) . "', city = '" . $this->db->escape($data['city']) . "'  WHERE email = '" . $this->db->escape($data['email']). "'");
	}
		 

	public function editPayment($data) {
      	$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET tax = '" . $this->db->escape($data['tax']) . "', payment = '" . $this->db->escape($data['payment']) . "', cheque = '" . $this->db->escape($data['cheque']) . "', paypal = '" . $this->db->escape($data['paypal']) . "', bank_name = '" . $this->db->escape($data['bank_name']) . "', bank_branch_number = '" . $this->db->escape($data['bank_branch_number']) . "', bank_swift_code = '" . $this->db->escape($data['bank_swift_code']) . "', bank_account_name = '" . $this->db->escape($data['bank_account_name']) . "', bank_account_number = '" . $this->db->escape($data['bank_account_number']) . "' WHERE affiliate_id = '" . (int)$this->affiliate->getId() . "'");
        
        $this->language->load('mail/zajvka.php');
		
		$subject = sprintf("Заявка на вывод денег", $this->config->get('config_name'));
		
		 
		$message .= "e-mail: ".$data['email']."\n\n";
		$message .= "Номер Яндекс кошелька: ".$data['cheque']."\n\n";
		$message .= "Номер карточки Visa или MasterCard: ".$data['paypal']."\n\n";
		$message .= "Сумма: ".$data['summ']."\n\n";
		$message .= "Примечание: ".$data['prim']."\n";
		
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo('shopmodel@mail.ru');
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
        
        $mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');				
		$mail->setTo('gyk088@gmail.com');
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();
        
        
	}
	
	public function editPassword($email, $password) {
      	$this->db->query("UPDATE " . DB_PREFIX . "affiliate SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}
    
    public function getTupeAffiliate($affiliate_id) {
		$query = $this->db->query("SELECT tupe FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "'");
		
		return $query->row;
	}
				
	public function getAffiliate($affiliate_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$affiliate_id . "'");
		
		return $query->row;
	}
    
    public function getAllAffiliate($data) {
        
        if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
            
            	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate ORDER BY city LIMIT " . (int)$data['start'] . "," . (int)$data['limit']);
		}
        else{ 
        
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate");
        
        }
		
		return $query->rows;
	}
    
  
    
    public function getAllAffiliateCount() {
        
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate");
		
		return $query->row['total'];
	}
		public function getCodeAffiliateByEmail($email) {
		$query = $this->db->query("SELECT code FROM " . DB_PREFIX . "affiliate WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	
		return $query->row;
	}
	public function getAffiliateByEmail($email) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row;
	}
    	public function getAffiliateByTracking($tracking) {
		$query = $this->db->query("SELECT email FROM " . DB_PREFIX . "affiliate WHERE code = '" . $tracking . "'");
		
		return $query->row;
	}
    
    	public function getAffiliateMypartner1($mail) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE LOWER(fax) = '" . $this->db->escape(utf8_strtolower($mail)) . "'");
	 
		return $query->rows;
	}
      public function getCountAffiliate($email) {
       
           
       
             
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate WHERE fax = '" . $email . "'");
		   
		 
 	 
      return $query->row['total'];
	}
    
    public function getCountAffiliateTransaction($affiliate_id) {
       
           
       
             
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate_transaction WHERE affiliate_id = '" . $affiliate_id . "'");
		   
		 
 	 
      return $query->row['total'];
	}
    
    public function getAffiliateMypartner2($mail) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE LOWER(partner2) = '" . $this->db->escape(utf8_strtolower($mail)) . "'");
		
		return $query->rows;
	}
    public function getAffiliateMypartner3($mail) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE LOWER(partner3) = '" . $this->db->escape(utf8_strtolower($mail)) . "'");
		
		return $query->rows;
	}
    public function getAffiliateMypartner4($mail) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE LOWER(partner4) = '" . $this->db->escape(utf8_strtolower($mail)) . "'");
		
		return $query->rows;
	}
    public function getAffiliateByFax($fax) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE LOWER(fax) = '" . $this->db->escape(utf8_strtolower($fax)) . "'");
		
		return $query->row;
	}
		
	public function getAffiliateByCode($code) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "affiliate WHERE code = '" . $this->db->escape($code) . "'");
		
		return $query->row;
	}
	public function getCodeAffiliateById() {
		$query = $this->db->query("SELECT code FROM " . DB_PREFIX . "affiliate WHERE affiliate_id = '" . (int)$this->affiliate->getId() . "'");
		
		return $query->row['code'];
	}		
	public function getTotalAffiliatesByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
		
		return $query->row['total'];
	}
    	public function getTotalAffiliatesByFax($fax) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "affiliate WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($fax)) . "'");
		
		return $query->row['total'];
	}
    
    public function getTotalTransactions($affiliate_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total  FROM " . DB_PREFIX . "affiliate_transaction WHERE affiliate_id = '" . (int)$affiliate_id . "'");
	
		return $query->row['total'];
	}
}
?>