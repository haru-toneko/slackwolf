<?php namespace Slackwolf\Game\Formatter;

use Slackwolf\Game\Game;

/**
 * Defines the AssignedRoleCountFormatter class.
 */
class AssignedRoleCountFormatter
{
    /**
     * @param Game $game
     *
     * @return string
     */
    public static function format(Game $game)
    {
        $msg = "";

        $assignedroleList = [];

        foreach ($game->getLobbyPlayers() as $player)
        {
            $assignedroleList[] = $player->role->getName();
        }

        $roleCountList = array_count_values($assignedroleList);

        foreach ($roleCountList as $roleName => $count)
        {
            $msg .= $roleName . ": " . $count . "\r\n";
        }

        return $msg;
    }
}