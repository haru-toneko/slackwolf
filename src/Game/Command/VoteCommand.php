<?php namespace Slackwolf\Game\Command;

use Exception;
use Slack\RealTimeClient;
use Slackwolf\Game\Formatter\UserIdFormatter;
use Slackwolf\Game\GameManager;
use Slackwolf\Game\GameState;
use Slackwolf\Message\Message;
use Zend\Loader\Exception\InvalidArgumentException;

/**
 * Defines the VoteCommand class.
 */
class VoteCommand extends Command
{

    /**
     * {@inheritdoc}
     *
     * Constructs a new Vote command.
     */
    public function __construct(RealTimeClient $client, GameManager $gameManager, Message $message, array $args = null)
    {
        parent::__construct($client, $gameManager, $message, $args);

        if ($this->channel[0] == 'D') {
            throw new Exception("このコマンドはダイレクトメッセージからは利用できません。");
        }

        if (count($this->args) < 1) {
            throw new InvalidArgumentException("Must specify a player");
        }

        if ( ! $this->game) {
            throw new Exception("現在ゲーム中ではありません。");
        }

        if ($this->game->getState() != GameState::DAY) {
            throw new Exception("Voting occurs only during the day.");
        }

        // Voter should be alive
        if ( ! $this->game->isPlayerAlive($this->userId)) {
            throw new Exception("死んでいるプレーヤーは投票できません。");
        }

        $this->args[0] = UserIdFormatter::format($this->args[0], $this->game->getOriginalPlayers());

        // Person player is voting for should also be alive
        if ( ! $this->game->isPlayerAlive($this->args[0])
                && $this->args[0] != 'noone'
                && $this->args[0] != 'clear') {
            echo 'not found';
            throw new Exception("Voted player not found in game.");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fire()
    {
        $this->gameManager->vote($this->game, $this->userId, $this->args[0]);
    }
}