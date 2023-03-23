<?php

namespace App\Presenters;

use Nette;
use Longman\TelegramBot\Telegram;
use App\Presenters\BasePresenter;
use GuzzleHttp\Client;

class GetMessagesPresenter extends BasePresenter{

public function renderDefault(){
    $discordToken = 'MTA4NDE3NDcxNjU2ODM0MjYwMQ.Gto6Ex.qilHC4g3quan8rcMpCCui4U-2m9L5kE2QEqFTM';
    $discordChannelId = '1084175599276413053';
    $discordClientId = '1084458157734105139';
    $guildId = '1084175599276413050';
    $baseUrl = 'https://discord.com/api/';
    $url = "v9/{$baseUrl}channels/{$discordChannelId}/messages";
    $curli = "v8/applications/{$discordClientId}/guilds/{$guildId}/commands";

    $curl = curl_init($curli);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Authorization: Bot {$discordToken}"
    ));
    // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);

    var_dump($curl);

    $telegramToken = '5615810071:AAGMIW8UA_RT8Dd1o5qV_-NoazcC6LzWzCM';
    $website = 'https://api.telegram.org/bot' . $telegramToken;
    $update = file_get_contents($website . '/getUpdates');
    $updates = json_decode($update, true);
    foreach($updates['result'] as $newUpdate) {
        $text = $newUpdate['message']['text'];
    }
    echo $text;

    $client = new Client();
    $command = '/imagine prompt: ';

    $webhookUrl = 'https://discord.com/api/webhooks/1084462908458668032/htdNJCXWHxxGoq_GBnCoQbND2PUqga6N_ngyJ60jGY3htMs4vBSME5X7RlxT80VPMapy';

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