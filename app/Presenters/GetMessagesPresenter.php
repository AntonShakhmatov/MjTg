<?php

namespace App\Presenters;

use Nette;
use Longman\TelegramBot\Telegram;
use App\Presenters\BasePresenter;
// use TelegramBot\Api\Client;
use GuzzleHttp\Client;

class GetMessagesPresenter extends BasePresenter{

public function renderDefault(){
    $discordToken = 'MTA4NDE3NDcxNjU2ODM0MjYwMQ.GmIb36.v0nc0z61RF4bfM9RjDqaYiX208p3cXBOkEi3BU';
    $discordChannelId = '1084175599276413053';
    $discordClientId = '1084458157734105139';
    $guildId = '1084175599276413050';
    $baseUrl = 'https://discord.com/api/v9/';
    $url = "{$baseUrl}channels/{$discordChannelId}/messages";
    $telegramToken = '5615810071:AAGMIW8UA_RT8Dd1o5qV_-NoazcC6LzWzCM';
    $website = 'https://api.telegram.org/bot' . $telegramToken;
    $update = file_get_contents($website . '/getUpdates');
    $update = json_decode($update, true);
    foreach($update['result'] as $newUpdate) {
        $text = $newUpdate['message']['text'];
    }
    echo $text;

    $discordApiUrl = 'https://discord.com/api/v8';
    $client = new Client();

    // $response = $client->post("$discordApiUrl/applications/$clientId/guilds/$guildId/commands", [
    //     'headers' => [
    //       'Authorization' => "Bot $botToken",
    //       'Content-Type' => 'application/json'
    //     ],
    
    //     'json' => $data
    //   ]);
    
    //   if ($response->getStatusCode() === 200) {
    //     return "The command 'imagine' has been created!";
    //   } else {
    //     return "Error creating command: ".$response->getBody();
    //   }

    $webhookUrl = 'https://discord.com/api/webhooks/1085890462147162112/U1UakXp4-NWrjcMnnBOWB8TAMahuqiV0OA4_S5-HUkgaJNGFIOVqz6Rakc_ED5fOj-PC';

    $messageData = array(
        'username' => 'Antoha',
        'content' => $text
      );

      $response = $client->request('POST', $webhookUrl, array(
        'json' => $messageData
      ));

      if ($response->getStatusCode() == 204) {
        echo 'Сообщение успешно отправлено на Discord!';
      } else {
        echo 'Произошла ошибка при отправке сообщения на Discord';
      }
}
}