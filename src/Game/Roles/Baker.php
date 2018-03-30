<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the Baker class.
 *
 * @package Slackwolf\Game\Roles
 */
class Baker extends Role
{
    
    /**
     * {@inheritdoc}
     */
    public function getName() {
        return Role::BAKER;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getDescription() {
        return "毎朝パンを焼きます。";
    }
}