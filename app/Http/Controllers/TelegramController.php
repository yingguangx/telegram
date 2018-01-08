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
		$mysql_credentials = [
				'host'     => 'localhost',
				'user'     => 'root',
				'password' => 'root',
				'database' => 'telegrambot',
		];
		$commands_paths = [
				__DIR__ . '/../../../vendor/longman/telegram-bot/src/Commands',
		];
		$admin_users= [];
		
		try {
			// Create Telegram API object
			$telegram = new Longman\TelegramBot\Telegram($bot_api_key, $bot_username);
			// Add commands paths containing your custom commands
			$telegram->addCommandsPaths($commands_paths);
			// Enable admin users
			$telegram->enableAdmins($admin_users);
			// Enable MySQL
			$telegram->enableMySql($mysql_credentials);
			// Logging (Error, Debug and Raw Updates)
			//Longman\TelegramBot\TelegramLog::initErrorLog(__DIR__ . "/{$bot_username}_error.log");
			//Longman\TelegramBot\TelegramLog::initDebugLog(__DIR__ . "/{$bot_username}_debug.log");
			//Longman\TelegramBot\TelegramLog::initUpdateLog(__DIR__ . "/{$bot_username}_update.log");
			// If you are using a custom Monolog instance for logging, use this instead of the above
			//Longman\TelegramBot\TelegramLog::initialize($your_external_monolog_instance);
			// Set custom Upload and Download paths
			//$telegram->setDownloadPath(__DIR__ . '/Download');
			//$telegram->setUploadPath(__DIR__ . '/Upload');
			// Here you can set some command specific parameters
			// e.g. Google geocode/timezone api key for /date command
			//$telegram->setCommandConfig('date', ['google_api_key' => 'your_google_api_key_here']);
			// Botan.io integration
			//$telegram->enableBotan('your_botan_token');
			// Requests Limiter (tries to prevent reaching Telegram API limits)
			$telegram->enableLimiter();
			// Handle telegram getUpdates request
			$server_response = $telegram->handleGetUpdates();
			dd($server_response);die();
			if ($server_response->isOk()) {
				$update_count = count($server_response->getResult());
				echo date('Y-m-d H:i:s', time()) . ' - Processed ' . $update_count . ' updates';
			} else {
				echo date('Y-m-d H:i:s', time()) . ' - Failed to fetch updates' . PHP_EOL;
				echo $server_response->printError();
			}
			
		} catch (Longman\TelegramBot\Exception\TelegramException $e) {
			echo $e->getMessage();
			// Log telegram errors
			Longman\TelegramBot\TelegramLog::error($e);
		}catch (Longman\TelegramBot\Exception\TelegramLogException $e) {
			// Catch log initialisation errors
			echo $e->getMessage();
		}
		return view('telegram.index');
	}
	
}
