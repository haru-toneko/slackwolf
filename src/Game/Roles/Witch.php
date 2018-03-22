<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the Witch class.
 *
 * @package Slackwolf\Game\Roles
 */
class Witch extends Role
{

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return Role::WITCH;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription() {
        return "一つの回復薬と毒薬を持ち、夜にターゲットを蘇らせる/殺す村人。ただしそれぞれ1ゲームに一回のみ使える。";
    }
}