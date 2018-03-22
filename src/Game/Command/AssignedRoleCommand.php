<?php namespace Slackwolf\Game\Command;

use Exception;
use Slack\Channel;
use Slack\ChannelInterface;
use Slackwolf\Game\Formatter\AssignedRoleCountFormatter;
use Slackwolf\Game\Game;

/**
 * Defines the AssignedRoleCommand class.
 * 
 * @package Slackwolf\Game\Command
 */
class AssignedRoleCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    public function fire()
    {
        if ( ! $this->gameManager->hasGame($this->channel)) {
            $this->client->getChannelGroupOrDMByID($this->channel)
               ->then(function (ChannelInterface $channel) use ($client) {
                   $this->client->send(":warning: Run this command in the game channel.", $channel);
               });
            return;
        }

        // get assignedRole formatter
        $assignedRoleMsg = AssignedRoleCountFormatter::format($this->game);
        $this->gameManager->sendMessageToChannel($this->game, $assignedRoleMsg);

    }
}
