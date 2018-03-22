<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the Seer class.
 *
 * @package Slackwolf\Game\Roles
 */
class Seer extends Role
{

    /**
     * {@inheritdoc}
     */
	public function getName() {
		return Role::SEER;
	}

    /**
     * {@inheritdoc}
     */
	public function getDescription() {
		return "毎夜一人の他のプレイヤーの役割を知ることができる村人 ボットがあなたにプライベートメッセージで教えてくれます。";
	}
}