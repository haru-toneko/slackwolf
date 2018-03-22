<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines thee Tanner class.
 *
 * @package Slackwolf\Game\Roles
 */
class Tanner extends Role
{

    /**
     * {@inheritdoc}
     */
	public function getName() {
		return Role::TANNER;
	}

    /**
     * {@inheritdoc}
     */
	public function getDescription() {
		return "村人側でも人狼側でもないプレイヤー。村人に吊るされた場合に勝利できる。";
	}
}
