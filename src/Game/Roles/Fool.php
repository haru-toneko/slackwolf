<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the Fool class.
 *
 * @package Slackwolf\Game\Roles
 */
class Fool extends Role
{

    /**
     * {@inheritdoc}
     */
	public function getName() {
		return Role::FOOL;
	}

    /**
     * {@inheritdoc}
     */
	public function getDescription() {
		return "占い師と同じような役割だが、与えられる情報は30％しか正しくない。愚者もまた誰が（本当の）占い師なのか知らない。監視者だけが本当の占い師が誰なのか知っている。";
	}
}
