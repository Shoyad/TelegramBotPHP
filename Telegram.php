<?php
/**
 * Telegram Bot Class.
 * @author Gabriele Grillo <gabry.grillo@alice.it>
 */
class Telegram {
	private $bot_id = "";
	
	public function __construct($bot_id) {
            //inizializzazione della proprietà $name    
            $this->bot_id = $bot_id;
	}
	public function sendMessage(array $content) {
		$url = 'https://api.telegram.org/bot' . $this->bot_id . '/sendMessage';
		$this->sendAPIRequest($url, $content);

	}
	public function getData() {
		$rawData = file_get_contents("php://input");
		return json_decode($rawData,true);
	}
	
	public function messageFromGroup($data) {
		if ($data["message"]["chat"]["title"] == "") {
			return false;
		}
		return true;
	}
        
	public function buildKeyBoard(array $options, $onetime=true, $resize=true, $selective=true) {
		$replyMarkup = array(
			'keyboard' => $options,
			'one_time_keyboard' => $onetime,
			'resize_keyboard' => $resize,
			'selective'		=> $selective
		);
		$encodedMarkup = json_encode($replyMarkup,true);
		return $encodedMarkup;
	}
	private function sendAPIRequest($url, array $content) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($content));
		$result = curl_exec($ch);
		curl_close($ch);
	}
        
}

?>
