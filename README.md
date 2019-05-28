# Slackwolf
Slackwolf is a bot for Slack. After inviting the bot to a channel, you can play the timeless game of [Werewolf (also called Mafia)](https://en.wikipedia.org/wiki/Mafia_(party_game)).

![ProjectImage](http://i.imgur.com/0Kwd8oe.png)

## インストールと起動
PHP 5.5+ と [Composer](https://getcomposer.org/) が必要です。
```
git clone -b master_dmm git@github.com:haru-toneko/slackwolf.git
cd slackwolf
composer install
```

`.env.default`という名前のファイルを`.env`に名前を変え、対象のbotのトークンを`BOT_TOKEN`に記載してください。

`php bot.php`コマンドでアプリケーションを起動できます。

## 遊び方
- Slackで`!help`と打ってください。botからDMでコマンド一覧を教えてもらえます。
- `!new`で部屋を作成し、参加したいユーザーが`!join`した後に`!start`でゲームを始めることができます。
- あらかじめ参加メンバーが決まっているなら、`!start @user1 @user2 @user3`で指定したユーザーでゲームを始めることもできます。
- 占い師などのロールはbotから指示が来た時にbotに対してDMで提示されたコマンドを実行してください。
- `!end`でゲームを終了できます。

## Contributing

We're very accepting of pull requests. This is a fun project to get your feet wet with PHP or open source. If you're making a large change, create an Issue first and lets talk about it.

## License

MIT License.
