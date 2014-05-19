<?php
class AES
{
	protected $iv;
	protected $key;
	
	/* constructs the AES data structure
	 * @param  key       private key
	 * @param  iv        initialization vector
	 * @throws Exception whenever invalid arguments are provided */
	public function __construct(/*...*/)
	{
		$iv  = "";
		$key = "";
		
		switch(func_num_args())
		{
			/* key with a default initialization vector */
			case 1:
			{
				$key = func_get_arg(0);
				$iv  = "0123456789abcdefedcba98765432101";
				break;
			}
			/* key with an initialization vector provided */
			case 2:
			{
				$key = func_get_arg(0);
				$iv  = func_get_arg(1);
				break;
			}
			/* operator error */
			default:
			{
				throw(new Exception("Invalid number of arguments to the AES constructor"));
				break;
			}
		}
		
		try
		{
			$this->setKey($key);
			$this->setIV($iv);
		}
		catch(Exception $e)
		{
			throw(new Exception("Invalid initialization vector", 0, $e));
		}
	}	
	
	/* accessor method for the initialization vector
	 * @return initialization vector */
	public function getIV()
	{
		return($iv);
	}
	
	/* mutator method for the initialization vector
	 * @param iv new initialization vector */
	public function setIV($iv)
	{
		/* enforce the initialization vector to be 32 hexadecimal bytes */
		if(strlen($iv) !== 32 || (preg_match("/^[0-9a-f]{32}$/i", $iv) !== 1))
		{
			throw(new Exception("Invalid initialization vector"));
		}
		
		$this->iv = $iv;
	}
	
	/* accessor method for the key
	   @return key */
	public function getKey()
	{
		return($this->key);
	}
	
	/* mutator method for the key
	 * @param new key */
	public function setKey($key)
	{
		/* hash the inputted key to ensure it's a 256 bit key */
		$this->key = hash("sha256", $this->key, true);
	}
	
	/* encrypts the clear text
	 * @param  cleartext clear text
	 * @return           cipher text */
	public function encrypt($cleartext)
	{
		$module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, "", MCRYPT_MODE_CBC, "");
		mcrypt_generic_init($module, $this->key, $this->hexToString($this->iv));
		$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$pad = $block - (strlen($cleartext) % $block);
		$cleartext = $cleartext . str_repeat(chr($pad), $pad);
		$ciphertext = mcrypt_generic($module, $cleartext);
		mcrypt_generic_deinit($module);
		mcrypt_module_close($module);
		return(base64_encode($ciphertext));
	}
	
	/* decrypts the cipher text
	 * @param  ciphertext cipher text
	 * @return            clear text
	 * @throws            if the clear text is invalid */
	public function decrypt($ciphertext)
	{
		$module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, "", MCRYPT_MODE_CBC, "");
		mcrypt_generic_init($module, $this->key, $this->hexToString($this->iv));
		$block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		$cleartext = mdecrypt_generic($module, base64_decode($ciphertext));
		mcrypt_generic_deinit($module);
		mcrypt_module_close($module);
		
		try
		{
			return($this->stripPadding($cleartext));
		}
		catch(Exception $e)
		{
			throw(new Exception("Unable to decrypt: malformed string padding", 0, $e));
		}
	}
	
	/* strips PKCS7 padding characters from the string
	 * @param  string padded string
	 * @return unpadded string 
	 * @throws if the string is invalid */
	protected function stripPadding($string)
	{
		$slast  = ord(substr($string, -1));
		$slastc = chr($slast);
		if(preg_match("/$slastc{" . $slast . "}/", $string))
		{
			$string = substr($string, 0, strlen($string) - $slast);
			return($string);
		}
		else
		{
			throw(new Exception("Unable to strip padding from string"));
		}
	}
	
	/* converts hexadecimal data to string
	 * @param  hex data to convert
	 * @return     converted string */
	protected function hexToString($hex)
	{
		$string = "";
		for ($i = 0; $i < strlen($hex) - 1; $i += 2)
		{
			$string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
		}
		return $string;
	}
}
?>