<?php namespace Slackwolf\Game\Command;

use Exception;
use Slack\Channel;
use Slack\ChannelInterface;
use Slackwolf\Game\Formatter\PlayerListFormatter;
use Slackwolf\Game\Game;

/**
 * Defines the DeadCommand class.
 */
class DeadCommand extends Command
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
                   $client->send(":warning: 現在ゲーム中ではありません。", $channel);
               });
            return;
        }

        // build list of players
        $playersList = PlayerListFormatter::format($this->game->getDeadPlayers());
        if (empty($playersList))
        {
            $this->gameManager->sendMessageToChannel($this->game, "まだ誰も死んでいません。");
        }
        else
        {
            $this->gameManager->sendMessageToChannel($this->game, ":angel: 死んだプレイヤー: ".$playersList);
        }
    }
}