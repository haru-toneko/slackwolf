<?php namespace Slackwolf\Game\Command;
/*
use Exception;
use Slack\Channel;
use Slack\ChannelInterface;
use Slackwolf\Game\Formatter\GameStatusFormatter;
use Slackwolf\Game\Game;
*/
/**
 * Defines the WeatherCommand class.
 */
class WeatherCommand extends Command
{

    /**
     * {@inheritdoc}
    */
    public function fire()
    {
        $client = $this->client;

        if ( ! $this->gameManager->hasGame($this->channel)) {
            $client->getChannelGroupOrDMByID($this->channel)
               ->then(function (ChannelInterface $channel) use ($client) {
                   $client->send(":warning: このコマンドはゲームが進行しているチャンネルでのみ利用できます。", $channel);
               });
            return;
        }
        if ($weather != null){

          if($weather == 1){
            $this->gameManager->sendMessageToChannel($this->game, ":rain_cloud: It is raining. It is a cold rain, and the freezing drops chill you to the bone." );          
          }

          // Cloudy
          else if($weather == 2){
            $this->gameManager->sendMessageToChannel($this->game, ":cloud: 雲が空を覆い、星々の光すら遮っていた");   
          }

          // Sunny
          else{
            $this->gameManager->sendMessageToChannel($this->game, ":sunny: 暖かな太陽。その目が眩むほどの光に包まれた私は自分がまだ生きているということに心から感謝した。"); 
          }

        }

        else{
          $this->gameManager->sendMessageToChannel($this->game,"ゲーム中ではありません"); 
        }
    }
}
