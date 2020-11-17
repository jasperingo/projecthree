<?php

namespace ApexPHP;


class Cryptograph {
	
	
	const METHOD = "aes-256-ctr";
	
    
    public static function encrypt(array $message, string $key) : string {
        
        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = openssl_random_pseudo_bytes($nonceSize);
        
        $ciphertext = openssl_encrypt(
        	json_encode($message),
        	self::METHOD,
        	$key, 
       		OPENSSL_RAW_DATA,
        	$nonce
        );
        
        return base64_encode($nonce.$ciphertext);
    }
	
    
    public static function decrypt (string $ciphertext, string $key) : array {
        
        $ciphertext = base64_decode($ciphertext, true);
        if ($ciphertext === false) {
            return array();
        }
        
        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = mb_substr($ciphertext, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($ciphertext, $nonceSize, null, '8bit');
        
        $plaintext = openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key, 
            OPENSSL_RAW_DATA,
            $nonce
        );
        
        if ($plaintext === false) {
        	return array();
        }
        
        $message = json_decode($plaintext, true);
        
        if ($message === null) {
        	return array();
        }
        
        
        return $message;
	}
	
	
	
}



