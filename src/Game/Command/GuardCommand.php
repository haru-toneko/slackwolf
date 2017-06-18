<?php namespace Slackwolf\Game\Command;

use Exception;
use InvalidArgumentException;
use Slack\Channel;
use Slack\ChannelInterface;
use Slack\DirectMessageChannel;
use Slack\RealTimeClient;
use Slackwolf\Game\Formatter\ChannelIdFormatter;
use Slackwolf\Game\Formatter\UserIdFormatter;
use Slackwolf\Game\Game;
use Slackwolf\Game\GameManager;
use Slackwolf\Game\GameState;
use Slackwolf\Game\Role;
use Slackwolf\Message\Message;

/**
 * Defines the GuardCommand class.
 */
class GuardCommand extends Command
{

    /**
     * {@inheritdoc}
     *
     * Constructs a new Guard command.
     */
    public function __construct(RealTimeClient $client, GameManager $gameManager, Message $message, array $args = null)
    {
        parent::__construct($client, $gameManager, $message, $args);

        $client = $this->client;

        if ($this->channel[0] != 'D') {
            throw new Exception("!guardはダイレクトメッセージでのみ利用できます。");
        }

        if (count($this->args) < 2) {
            $client->getChannelGroupOrDMByID($this->channel)
                   ->then(function (ChannelInterface $channel) use ($client) {
                       $client->send(":warning: コマンドの使い方が間違っています。正しい使い方: !guard #ゲームが進行しているチャンネル @守る対象のプレーヤー名", $channel);
                   });
            throw new InvalidArgumentException("引数が おかしい");
        }

        $client = $this->client;

        $channelId   = null;
        $channelName = "";

        if (strpos($this->args[0], '#C') !== false) {
            $channelId = ChannelIdFormatter::format($this->args[0]);
        } else {
            if (strpos($this->args[0], '#') !== false) {
                $channelName = substr($this->args[0], 1);
            } else {
                $channelName = $this->args[0];
            }
        }

        if ($channelId != null) {
            $this->client->getChannelById($channelId)
                         ->then(
                             function (ChannelInterface $channel) use (&$channelId) {
                                 $channelId = $channel->getId();
                             },
                             function (Exception $e) {
                                 // Do nothing
                             }
                         );
        }

        if ($channelId == null) {
            $this->client->getGroupByName($channelName)
                         ->then(
                             function (ChannelInterface $channel) use (&$channelId) {
                                 $channelId = $channel->getId();
                             },
                             function (Exception $e) {
                                 // Do nothing
                             }
                         );
        }

        if ($channelId == null) {
            $this->client->getDMById($this->channel)
                         ->then(
                             function (DirectMessageChannel $dmc) use ($client) {
                                 $this->client->send(":warning: 無効なチャンネルが選択されました。 正しい使い方: !guard #ゲームが進行しているチャンネル @守る対象のプレーヤー名", $dmc);
                             }
                         );
            throw new InvalidArgumentException();
        }

        $this->game = $this->gameManager->getGame($channelId);

        if ( ! $this->game) {
            $client->getChannelGroupOrDMByID($this->channel)
                   ->then(function (ChannelInterface $channel) use ($client) {
                       $client->send(":warning: 現在ゲーム中ではありません。", $channel);
                   });
            throw new Exception("現在ゲーム中ではありません。");
        }

        $this->args[1] = UserIdFormatter::format($this->args[1], $this->game->getOriginalPlayers());
    }

    /**
     * {@inheritdoc}
     */
    public function fire()
    {
        $client = $this->client;

        if ($this->game->getState() != GameState::NIGHT) {
            $client->getChannelGroupOrDMByID($this->channel)
                   ->then(function (ChannelInterface $channel) use ($client) {
                       $client->send(":warning: 夜の間にしかガードできません。", $channel);
                   });
            throw new Exception("夜の間のみ守護者は行動できます。");
        }

        // Voter should be alive
        if ( ! $this->game->isPlayerAlive($this->userId)) {
            $client->getChannelGroupOrDMByID($this->channel)
                   ->then(function (ChannelInterface $channel) use ($client) {
                       $client->send(":warning: あなたは指定されたチャンネル内での生存者でありません。", $channel);
                   });
            throw new Exception("死んでいる場合はガードできません。");
        }

        // Person player is voting for should also be alive
        if ( ! $this->game->isPlayerAlive($this->args[1])) {
            $client->getChannelGroupOrDMByID($this->channel)
                   ->then(function (ChannelInterface $channel) use ($client) {
                       $client->send(":warning: そのプレイヤーが見つかりませんでした。", $channel);
                   });
            throw new Exception("投票されたプレイヤーが見つかりませんでした。");
        }

        // Person should be bodyguard
        $player = $this->game->getPlayerById($this->userId);

        if (!$player->role->isRole(Role::BODYGUARD)) {
            $client->getChannelGroupOrDMByID($this->channel)
                   ->then(function (ChannelInterface $channel) use ($client) {
                       $client->send(":warning: あなたはガードをするための守護者である必要があります。", $channel);
                   });
            throw new Exception("守護者のみガードができます。");
        }

        if ($this->game->getGuardedUserId() !== null) {
            $client->getChannelGroupOrDMByID($this->channel)
                   ->then(function (ChannelInterface $channel) use ($client) {
                       $client->send(":warning: あなたはすでにガードされています。", $channel);
                   });
            throw new Exception("あなたはすでにガードされています。");
        }

        if ($this->game->getLastGuardedUserId() == $this->args[1]) {
            $client->getChannelGroupOrDMByID($this->channel)
                   ->then(function (ChannelInterface $channel) use ($client) {
                       $client->send(":warning: 昨夜と同じプレイヤーをガードすることはできません。", $channel);
                   });
            throw new Exception("昨夜と同じプレイヤーをガードすることはできません。");
        }

        $this->game->setGuardedUserId($this->args[1]);

        $client->getChannelGroupOrDMByID($this->channel)
               ->then(function (ChannelInterface $channel) use ($client) {
                   $client->send("ガード成功", $channel);
               });

        $this->gameManager->changeGameState($this->game->getId(), GameState::DAY);
    }
}
