<?php namespace Slackwolf\Game\Command;

use Slack\Channel;
use Slack\ChannelInterface;
use Slack\DirectMessageChannel;
use Slackwolf\Game\Role;

/**
 * Defines the HelpCommand class.
 */
class HelpCommand extends Command
{

    /**
     * {@inheritdoc}
     */
    public function fire()
    {
        $client = $this->client;

        $help_msg =  "\r\n*#人狼 の遊び方*\r\n------------------------\r\n";
        $help_msg .= "人狼は社会推論のパーティーゲームです。プレイヤーたちはゲームが始まるとプライベートメッセージで自分の役割が通知されます。 \r\n\r\n";
        $help_msg .= "もしあなたが村人なら−−あなたは自分の社会推論の技術と投票に基づいて誰が人狼なのかを見つけ出さなければなりません。\r\n ";
        $help_msg .= "もしあなたが人狼なら−−あなたはできる限りの嘘をついて自分が人狼でないように装わなければなりません。\r\n\r\n";
        $help_msg .= "ゲームは昼と夜の数日間にわたって行われます。毎日全員の投票によって誰か一人が排除されます。得票数の最も多いプレーヤーが削除されます。もし得票が同じ場合はだれも吊るされません。\r\n";
        $help_msg .= "毎夜−−人狼達は非公開で投票し、誰か一人プレイヤー排除することが許されます。決定は満場一致でなければなりません。もし意見が割れた場合は、再度投票を行います。ボットがあなたにメッセージを送るでしょう。\r\n";
        $help_msg .= "村人達は、すべての人狼が排除されると勝利します。人狼達は、人狼の数が残っているプレイヤーの過半数を占めると勝利します。\r\n\r\n";
        $help_msg .= "*特別な役割*\r\n------------------------\r\n";

        foreach(Role::getSpecialRoles() as $specialRole) {
            $help_msg .= '_'.$specialRole->getName() . "_ - " . $specialRole->getDescription() . "\r\n";
        }
        $help_msg .= "\r\n";

        $help_msg .= "*ゲームモード*\r\n------------------------\r\n";
        $help_msg .= "クラシックモード：人数毎の役割がある程度決められたモード\r\n";
        $help_msg .= "カオスモード：役割がランダムなモード\r\n\r\n";
        $help_msg .= "*ゲームコマンド*\r\n------------------------\r\n";
        $help_msg .= "`!new` - プレイヤーが次のゲームに!joinするための新しいロビーを作る\r\n";
        $help_msg .= "`!join` - 次のゲームのためのロビーに参加する\r\n";
        $help_msg .= "`!leave` - 次のゲームのためのロビーから離脱する\r\n";
        $help_msg .= "`!start` - ゲームをスタートする。引数なしで読んだ場合はロビーにいるプレイヤーで開始する\r\n";
        $help_msg .= "`!start all` - チャンネルに参加している全員で新しいゲームを開始する\r\n";
        $help_msg .= "`!start @user1 @user2 @user3` - 指定した参加者で新しいゲームを開始する\r\n";
        $help_msg .= "`!end` - 途中でゲームを終了する\r\n";
        $help_msg .= "`!option` - オプション設定を確認と変更。引数なしで使うとヘルプと現在の値を表示する。\r\n";
        $help_msg .= "`!remindme` - 現在のゲームでの自分の役割を再確認する\r\n";
        $help_msg .= "`!dead` - 死んだプレイヤーを表示する\r\n";
        $help_msg .= "`!alive` - 生きているプレイヤーを表示する\r\n";
        $help_msg .= "`!status` - ゲームの状態を表示する\r\n";
        $help_msg .= "`!role` - ゲーム開始時の役割毎の数を表示する\r\n";

        $help_msg .= "\r\n*村人のコマンド*\r\n----------------------\r\n";
        $help_msg .= "`!vote @user1|noone|clear` - 昼の間、@playerかnoone(誰も吊るさない)かclearで投票を取り消す(投票変更のオプションが有効な場合)\r\n";

        $help_msg .= "\r\n*人狼のコマンド*\r\n----------------------\r\n";
        $help_msg .= "`!kill #channel @user1` - 人狼として、ボットとのプライベートメッセージで毎夜殺す人間に投票できる。すべての人狼の間で満場一致する必要があります。\r\n";

        $help_msg .= "\r\n*占い師のコマンド*\r\n--------------------------\r\n";
        $help_msg .= "`!see #channel @user1` -  占い師のみ。占い師としてプレイヤーが人狼なのか村人なのか判別する。\r\n";

        $help_msg .= "\r\n*魔術師のコマンド*\r\n-------------------------\r\n";
        $help_msg .= "`!poison #channel @user1` - 魔術師のみ。夜の間、魔術師は一度のゲーム中で一回毒薬で殺すターゲットを選ぶことができる。\r\n";
        $help_msg .= "`!heal #channel @user1` - 魔術師のみ。夜の間、魔術師は一度のゲーム中で一回回復薬で復活させるターゲットを選ぶことができる。\r\n";

        $help_msg .= "\r\n*ボディーガードのコマンド*\r\n---------------------\r\n";
        $help_msg .= "`!guard #channel @user1` - ボディーガードのみ。ボディーガードは毎夜一度排除されようとしているプレイヤーを守ることができる。二夜続けて同じ人間を選ぶことはできない。\r\n";

        $help_msg .= "\r\n*ハンターのコマンド*\r\n----------------------\r\n";
        $help_msg .= "`!shoot @user1` - ハンターのみ。ハンターは昼か夜の間殺される場合、他の誰か一人を撃ち殺すことができる。\r\n";

        $this->client->getDMByUserId($this->userId)->then(function(DirectMessageChannel $dm) use ($client, $help_msg) {
            $client->send($help_msg, $dm);
        });

        if ($this->channel[0] != 'D') {
            $client->getChannelGroupOrDMByID($this->channel)
               ->then(function (ChannelInterface $channel) use ($client) {
                   $client->send(":book: DMにヘルプの内容を送りました。", $channel);
               });
        }
    }
}
