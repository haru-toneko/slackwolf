<?php namespace Slackwolf\Game\Command;

use Exception;
use Slack\Channel;
use Slack\ChannelInterface;
use Slack\DirectMessageChannel;
use Slackwolf\Game\Game;

/**
 * Defines the RemindCommand class.
 */
class RemindCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    public function fire()
    {
        $client = $this->client;

        if ($this->channel[0] == 'D') {
            $client->getDMByUserId($this->userId)
                ->then(function(DirectMessageChannel $dm) use ($client) {
                    $client->send(":warning: このコマンドはゲームが進行しているチャンネルでのみ利用できます。", $dm);
                });
            return;
        }

        if ( ! $this->gameManager->hasGame($this->channel)) {
            $client->getChannelGroupOrDMByID($this->channel)
               ->then(function (ChannelInterface $channel) use ($client) {
                   $client->send(":warning: 現在ゲーム中ではありません。", $channel);
               });
            return;
        }

        // Look for current game and player
        $game = $this->gameManager->getGame($this->channel);
        $player = $game->getPlayerById($this->userId);

        $roleName = $player->role->getName();
        $roleDescription = $player->role->getDescription();

        // DM the player his current role and description
        $reminder_msg = "あなたのロールは\r\n" . '_' . $roleName . '_ - ' . $roleDescription . '\nです。';

        $client->getDMByUserID($player->getId())
            ->then(function(DirectMessageChannel $dm) use ($client, $reminder_msg) {
                $client->send($reminder_msg,$dm);
            });
    }
}
