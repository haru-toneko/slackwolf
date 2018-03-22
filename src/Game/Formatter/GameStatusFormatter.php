<?php namespace Slackwolf\Game\Formatter;

use Slackwolf\Game\Game;
use Slackwolf\Game\GameState;
use Slackwolf\Game\OptionName;
use Slackwolf\Game\Role;
use Slackwolf\Game\Formatter\VoteSummaryFormatter;

/**
 * Defines the GameStatusFormatter class.
 */
class GameStatusFormatter
{

    /**
     * @param Game $game
     *
     * @return string
     */
    public static function format(Game $game)
    {
        $msg = ":memo: ゲームの状態\r\n- - - - - - - - - - - - - - - - - - - - - - - -\r\n";

        if ($game->hunterNeedsToShoot) {
            $msg .= ":bow_and_arrow: Hunter を待っています";
            $msg .= "\r\n- - - - - - - - - - - - - - - - - - - - - - - -\r\n";
            return $msg;
        }

        switch($game->state) {

            case GameState::DAY:
                $voteMsg = VoteSummaryFormatter::format($game);

                $msg .= ":sun_small_cloud:  日中です。誰をリンチするか投票しましょう！\r\n";
                $msg .= $voteMsg . "\r\n";
                break;

            case GameState::FIRST_NIGHT:
            case GameState::NIGHT:
                $msg .= ":moon:  The night lingers on ... \r\n \r\n";

                $numSeer = $game->getNumRole(Role::SEER);
                $numBodyguard = $game->getNumRole(Role::BODYGUARD);
                $numWitch = $game->getNumRole(Role::WITCH);
                $numFool = $game->getNumRole(Role::FOOL);

                if ($game->isGameMode(OptionName::GAME_MODE_CLASSIC)) {
                    if (($numSeer > 0 && !$game->seerSeen) || ($numFool > 0 && !$game->foolSeen)) {
                        $msg .= "_...waiting on the_ :crystal_ball: *Seer*\r\n";
                    }
                }

                if ($game->state == GameState::NIGHT) {
                    if (!$game->wolvesVoted) {
                        $msg .= "_...waiting on the_ :wolf:  *Wolves*\r\n";
                    }

                    if ($game->isGameMode(OptionName::GAME_MODE_CLASSIC)) {
                        if ($numWitch > 0 && (!$game->witchPoisoned || !$game->witchHealed)) {
                            $msg .= "_...waiting on the_ :older_woman::skin-tone-3: *Witch*\r\n";
                        }

                        if ($numBodyguard > 0 && !$game->getGuardedUserId()) {
                            $msg .= "_...waiting on the_ :shield: *Bodyguard*\r\n";
                        }
                    }
                }
                break;

            default:
                $msg .= "No Game Running\n";
        }

        return $msg;
    }
}
