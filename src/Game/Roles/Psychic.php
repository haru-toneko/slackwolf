<?php namespace Slackwolf\Game\Roles;

use Slackwolf\Game\Role;

/**
 * Defines the Psychic class.
 *
 * @package Slackwolf\Game\Roles
 */
class Psychic extends Role
{
    
    /**
     * {@inheritdoc}
     */
    public function getName() {
        return Role::PSYCHIC;
    }
    	
    /**
     * {@inheritdoc}
     */
    public function getDescription() {
        return "毎夜、その日の昼に吊られたプレイヤーが人狼側かどうか知ることができる村人 ボットがあなたにプライベートメッセージで教えてくれます。";
    }
}