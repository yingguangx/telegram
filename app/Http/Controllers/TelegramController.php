<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Longman;

class TelegramController extends Controller
{
	
	public function index()
	{
		$bot_api_key  = '452136030:AAGbmkWqFHEGuvdjXbJ-m7SA3mermdWUe7g';
		$bot_username = '@medisahres_bot';
		$hook_url = '139.224.118.129/telegram/webhooks';
		
		try {
			// Create Telegram API object
			$telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
			
			// Set webhook
			$result = $telegram->setWebhook($hook_url);
			dd($result);die();
			if ($result->isOk()) {
				echo $result->getDescription();
			}
		} catch (Longman\TelegramBot\Exception\TelegramException $e) {
			// log telegram errors
			// echo $e->getMessage();
		}
		return view('telegram.index');
	}
	
}
