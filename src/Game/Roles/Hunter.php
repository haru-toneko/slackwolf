<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the Hunter class.
 *
 * @package Slackwolf\Game\Roles
 */
class Hunter extends Role
{

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return Role::HUNTER;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription() {
        return "昼か夜に自分が殺される場合、誰か一人他の人を殺すことができる村人";
    }
}