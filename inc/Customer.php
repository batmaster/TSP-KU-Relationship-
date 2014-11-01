<?php
    class Customer {
    	
    	public $id;
    	public $firstName;
    	public $lastName;
    	public $username;
	
	public function addToCart( $product, $amount ){
	    $dao = InventoryDao::GetInstance();
	    $dao->addToCart( $this->id, $product->id, $amount );
	}
	
	public function removeFromCart( $product, $amount ) {
	    $dao = InventoryDao::GetInstance();
	    $dao->removeFromCart( $this->id, $product->id, $amount );
	}
	
	public function getCartProducts() {
	    $dao = InventoryDao::GetInstance();
	    $data = $dao->getCartProducts( $dao->getCurrentCartId( $this->id ) );
	    $result = array();
	    foreach( $data as &$val ) {
		$detail = array();
		$detail['Product'] = Product::GetProduct( $val['ProductId'] );
		$detail['Quantity'] = $val['Quantity'];
		array_push( $result, $detail );
	    }
	    return $result;
	}
    	
	public static function Authenticate( $username, $password ) {
	    $dao = CustomerDao::GetInstance();
	    $data = $dao->getCustomer( $dao->authCustomer( $username, $password ) );
	    
	    $result = new self();
	    $result->id = $data['CustomerId'];
	    $result->firstName = $data['FirstName'];
	    $result->lastName = $data['LastName'];
	    $result->username = $data['UserName'];
	    return $result;
	}
	
	public static function CreateCustomer( $firstName, $lastName, $username, $password ) {
	    $dao = CustomerDao::GetInstance();
	    $cusId = $dao->addCustomer( $firstName, $lastName, $username, $password );
	    
	    $result = new self();
	    $result->id = $cusId;
	    $result->firstName = $firstName;
	    $result->lastName = $lastName;
	    $result->username = $username;
	    return $result;
	}
    }
?>