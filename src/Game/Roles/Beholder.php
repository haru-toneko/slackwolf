<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the Beholder class.
 *
 * @package Slackwolf\Game\Roles
 */
class Beholder extends Role
{

    /**
     * {@inheritdoc}
     */
	public function getName() {
		return Role::BEHOLDER;
	}

    /**
     * {@inheritdoc}
     */
	public function getDescription() {
		return "最初の夜に誰が占い師なのか知ることができる村人";
	}
}