<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Longman;

class WebhooksController extends Controller
{
	
	public function index()
	{
		$bot_api_key  = '452136030:AAGbmkWqFHEGuvdjXbJ-m7SA3mermdWUe7g';
		$bot_username = '@medisahres_bot';
		
		try {
			// Create Telegram API object
			$telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
			
			// Handle telegram webhook request
			$telegram->handle();
		} catch (Longman\TelegramBot\Exception\TelegramException $e) {
			// Silence is golden!
			// log telegram errors
			// echo $e->getMessage();
		}
	}
	
}
