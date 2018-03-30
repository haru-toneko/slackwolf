<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the Maniac class.
 *
 * @package Slackwolf\Game\Roles
 */
class Maniac extends Role
{
    /**
     * {@inheritdoc}
     */
    public function getName() {
        return Role::MANIAC;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDescription() {
        return "人であるにもかかわらず、人狼の味方をする役職";
    }
}