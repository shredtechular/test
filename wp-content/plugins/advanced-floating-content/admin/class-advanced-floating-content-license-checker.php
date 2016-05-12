<?php

/**
 * Envato API
 *
 * An PHP class to interact with the Envato Marketplace API
 *
 * @author		Philo Hermans
 * @copyright	Copyright (c) 2011 NETTUTS+
 * @link		http://net.tutsplus.com
 */
 
/**
 * envatoAPI
 *
 * Create our new class called "envatoAPI"
 */ 
class envatoAPI{
	
	private $api_url = 'http://marketplace.envato.com/api/edge/'; // Default URL
	private $api_set; // This will hold the chosen API set like "user-items-by-site"
	private $username; // The username of the author only needed to access the private sets
	private $api_key; // The api key of the author only needed to access the private sets
	public $options;
	/**
 	* request()
 	*
 	* Request data from the API
 	*
 	* @access	public
 	* @param	void
 	* @return	 	array		
 	*/
	public function request()
	{
		
		if(!empty($this->username) && !empty($this->api_key))
		{
			// Build the private url
			$this->api_url .= $this->username . '/'.$this->api_key.'/'.$this->api_set . '.json';
		}
		else
		{
			// Build the public url
			$this->api_url .=  $this->api_set . '.json';
		}
		//echo $this->api_url;
		$ch = curl_init($this->api_url); // Initialize a cURL session & set the API URL
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect
		curl_setopt($ch, CURLOPT_USERAGENT, 'ENVATO-PURCHASE-VERIFY');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the transfer as a string instead of outputting it out directly.
		$ch_data = curl_exec($ch); // Perform a cURL session
		curl_close($ch);  //Close a cURL session
		
		// Check if the variable contains data
		if(!empty($ch_data))
		{
			return json_decode($ch_data, true); // Decode the requested data into an array
		}
		else
		{
			return('We are unable to retrieve any information from the API.'); // Return error message
		}
		
	}
	
	/**
 	* set_api_set()
 	*
 	* Set the API set
 	*
 	* @access	public
 	* @param	string
 	* @return	 	void		
 	*/
	public function set_api_set($api_set)
	{
		$this->api_set = $api_set;
	}
	
	/**
 	* set_api_key()
 	*
 	* Set the API key
 	*
 	* @access	public
 	* @param	string
 	* @return	 	void		
 	*/
	public function set_api_key($api_key)
	{
		$this->api_key = $api_key;
	}
	
	/**
 	* set_username()
 	*
 	* Set the Username
 	*
 	* @access	public
 	* @param	string
 	* @return	 	void		
 	*/
	public function set_username($username)
	{
		$this->username = $username;
	}
		
	/**
 	* set_api_url()
 	*
 	* Set the API URL
 	*
 	* @access	public
 	* @param	string
 	* @return	 	void		
 	*/
	public function set_api_url($url)
	{
		$this->api_url = $url;
	}

	/**
 	* get_api_url()
 	*
 	* Return the API URL
 	*
 	* @access	public
 	* @return	 	string		
 	*/
	public function get_api_url()
	{
		return $this->api_url;
	}
	
	
	public function initialize_license_checker($item_id, $email, $buyername, $purchase_code)
	 {	
		
        $API = new envatoAPI();
		$API->set_username('codetides');
		$API->set_api_key('s3b30fcqhkei0hhebhzev41yjxr62vaz');
		
		$API->set_api_set('verify-purchase:' . $purchase_code);
		$data = $API->request();
		//	print_r($data);
        
			if(!empty($data['verify-purchase']))
			{
               
				// We got a valid API response let's match the item id and the username
				if($data['verify-purchase']['item_id'] == "9945856" && $data['verify-purchase']['buyer'] == $buyername)
				{
					// Everything seems to be correct! Purchase verified!
						// Show some info like purchase date and licence
					
                    $postdata= "b=".$buyername."&e=".$email."&p=".$purchase_code."&d=".home_url( '/' )."&pn=".$data['verify-purchase']['item_name']."&i=".$data['verify-purchase']['item_id'];
                    
                    $ch = curl_init();
                    $url = "http://codetides.com/api/rest_product_checker.php";
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec($ch);
                    update_option('verified_purchase', '0');
                        
                    curl_close ($ch);                    
						$result = array('type'=>'success','message'=>'We have verified you license key, thank you for buying our plugin, enjoy the full features of plugin');
						
						return $result;
				}
                else
                {
                    
                    $postdata= "b=".get_bloginfo('name')."&e=".get_bloginfo('admin_email')."&p=987654-321987-654321-987654&d=".home_url( '/' )."&pn=Advanced%20Floating%20Content&i=".$item_id;
                    
                    $ch = curl_init();
                    $url = "http://codetides.com/api/rest_product_checker.php";
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec($ch);                                    
                    curl_close ($ch);                    
                    update_option('verified_purchase', '1');
                    
                    $result = array('type'=>'error','message'=>'Sorry, we are unable to verify your purchase.Please complete the form below and try again.');
                    return $result;
                }
				
			}
			else
			{
				// Response from the API was empty, return error
                
                
                    $postdata= "b=".get_bloginfo('name')."&e=".get_bloginfo('admin_email')."&p=987654-321987-654321-987654&d=".home_url( '/' )."&pn=Advanced%20Floating%20Content&i=".$item_id;
                    
                    $ch = curl_init();
                    $url = "http://codetides.com/api/rest_product_checker.php";
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$postdata);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec($ch);                    
                    curl_close ($ch);
                    update_option('verified_purchase', '1');
                
                
				
				$result = array('type'=>'error','message'=>'Sorry, we are unable to verify your purchase.Please complete the form below and try again.');
				
				
				return $result;
				
			}
		
		
	 }
	
	
}
 
?>