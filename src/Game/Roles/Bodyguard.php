<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the  Bodyguard class.
 *
 * @package Slackwolf\Game\Roles
 */
class Bodyguard extends Role
{

    /**
     * {@inheritdoc}
     */
	public function getName() {
		return Role::BODYGUARD;
	}

    /**
     * {@inheritdoc}
     */
	public function getDescription() {
		return "毎夜排除されようとしているプレイヤーを一人守ることができる村人 ただし二日続けて同じ人間を守ることはできない。";
	}
}