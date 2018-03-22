<?php namespace Slackwolf\Game\Command;

use Exception;
use Slack\Channel;
use Slack\ChannelInterface;
use Slackwolf\Game\Formatter\AssignedRoleCountFormatter;
use Slackwolf\Game\Game;

/**
 * Defines the AssignedRoleCommand class.
 */
class AssignedRoleCommand extends Command
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
                   $client->send(":warning: Run this command in the game channel.", $channel);
               });
            return;
        }

        // get assignedRole formatter
        $assignedRoleMsg = AssignedRoleCountFormatter::format($this->game);
        $this->gameManager->sendMessageToChannel($this->game, $assignedRoleMsg);

    }
}
