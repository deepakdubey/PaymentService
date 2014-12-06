<?php

class PaymentService {

	private $bank_ifsc_code;
	private $bank_account_number;
	private $amount;
	private $merchant_transaction_ref;
	private $transaction_date;
	private $payment_gateway_merchant_reference;

	public function __construct($bank_ifsc_code,$bank_account_number,$amount,$merchant_transaction_ref,$transaction_date,$yment_gateway_merchant_reference)
    {
        $this->bank_ifsc_code                     =bank_ifsc_code;
        $this->bank_account_number                =bank_account_number;
        $this->amount                             =amount;
        $this->merchant_transaction_ref           =merchant_transaction_ref;
        $this->transaction_date                   =transaction_date;
        $this->payment_gateway_merchant_reference =bank_ifsc_code;

    }



	public function myPaymentRequest()
	{

		$bankdata="bank_ifsc_code=ICIC0000001|bank_account_number=11111111|amount=10000.00|merchant_transaction_ref=txn001|transaction_date=2014-11-14|payment_gateway_merchant_reference=merc001";
		$bankhash=sha1($bankdata);
		$bankdata=$bankdata.'|hash='.$bankhash;
		$method = 'aes128';
		$password='Q9fbkBF8au24C9wshGRW9ut8ecYpyXye5vhFLtHFdGjRg3a4HxPYRfQaKutZx5N4';
		$payment_data=array($bankdata,$method,$password);
        $payment_encrypted_data=paymentDataEncryption($payment_data);
        $payment_basecode_encode_data=paymentBaseCodeDataEncode($payment_encrypted_data);

		
		

		
	}

	public function myPaymentResponse($paymentResponse)
	{
        $decoded_bank_data=paymentBaseCodeDataDecode($paymentResponse);
		$method = 'aes128';
		$password='Q9fbkBF8au24C9wshGRW9ut8ecYpyXye5vhFLtHFdGjRg3a4HxPYRfQaKutZx5N4';
		$payment_data=array($bankdata,$method,$password);
		$decrypt_bank_data=paymentDataDecryption($payment_data);
		$bank_hash_response=sha1($decrypt_bank_data);
		
	}

	public function paymentDataEncryption($payment_data)
	{
       return $encrpt_bank_data=openssl_encrypt($payment_data[0] ,$payment_data[1] ,$payment_data[2]);
       
    }
    
    public function paymentDataDecryption($payment_data)
	{
       return $decrypt_bank_data=openssl_decrypt($payment_data[0] ,$payment_data[1] ,$payment_data[2]);
       
    }
    public function paymentBaseCodeDataEncode($payment_data)
	{
       return $encoded_bank_data=base64_encode($payment_data);
       
    }
    public function paymentBaseCodeDataDecode($payment_encrypted_data)
	{
       return $decoded_bank_data=base64_decode($payment_encrypted_data);
       
    }
}
