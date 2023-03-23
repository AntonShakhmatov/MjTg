<?php 

namespace App\Presenters;

use Nette;
use Nette\Http\Request;
use  Nette\Http\Response;
use Discord\X;
use Discord\Discord;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use TelegramBot\Api\Client;
use App\Presenters\BasePresenter;
use TelegramBot\Api\Types\SendMessage;

class TelegramPresenter extends BasePresenter{
    
    public function renderDefault() {
        $discordToken = 'MTA4NDE3NDcxNjU2ODM0MjYwMQ.Gto6Ex.qilHC4g3quan8rcMpCCui4U-2m9L5kE2QEqFTM';
        $channelId = '1084175599276413053';
        $baseUrl = 'https://discord.com/api/v9/';

        $url = "{$baseUrl}channels/{$channelId}/messages";

        $headers = [
            "Authorization: $discordToken",
            "Accept: application/json",
            'Content-Type: application/json',
        ];

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);
        
        curl_close($ch);

        $results = json_decode($response, true);

        $images = [];

        foreach ($results as $message) {
        if (isset($message['attachments']) && count($message['attachments']) > 0) {
            foreach ($message['attachments'] as $attachment) {
                if ($attachment['content_type'] === "image/jpeg" || $attachment['content_type'] === "image/png") {
                    $images[] = $attachment['proxy_url'];
                }
            }
        }

        }

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }

        curl_close($ch);

        $this->template->images = $images;

    }

    function actionDefault() 
    {
    $this->renderDefault();
    $images = $this->template->images;
    $chat_id = '793314390';
    $foo = 'Privet';
    $TOKEN = "5824228201:AAEBCYaNaQEGnqfdrazTDjG4PNiW8dAsXI8";
    $TELEGRAM = "https://api.telegram.org/bot$TOKEN"; 
    foreach($images as $image){
    $url = $image;
    }
    // $url = "https://media.discordapp.net/attachments/1084175599276413053/1084522887341420554/Antoha_popcorn_and_coca_cola_walking_down_the_street_and_holdin_31eece34-9717-403f-afdf-3715bfcca6c0.png";
    $query = http_build_query(array(
        'chat_id'=> $chat_id,
        'text'=> $url,
        'parse_mode'=> "HTML", // Optional: Markdown | HTML
    ));
    $response = file_get_contents("$TELEGRAM/sendMessage?$query");
    return $response;

    }

}