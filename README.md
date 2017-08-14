# How do I get authentication in a telegram bot?

This repository attempts to illustrate [this answer to this question](https://stackoverflow.com/questions/31042219/how-do-i-get-authentication-in-a-telegram-bot/31212577#31212577)
in actual, runnable code.

What this repository *is*:
    
- A very simple web app to exemplify authentication in Telegram Bots

What this repository *is not*:

- Secure
- Production-ready
- Thread-safe
- A source of best-practices

*Please* do not use this code in production environments. *Do* use it to gain understanding on how
authentication works.

# How do I run the example?
This web application requires PHP 5.6+.

Clone the repo:
```bash
git clone https://github.com/pevdh/telegram-auth-example.git
cd telegram-auth-example
```

Open `config.php` and change the constants `BOT_NAME` and `BOT_TOKEN` to your bot's 
name and token.

Launch the built-in PHP webserver:
```bash
php -S 127.0.0.1:8000 -t web
```

Then launch the long-polling bot:
```bash
php bin/bot.php
```

Open your browser and visit [http://127.0.0.1:8000/](http://127.0.0.1:/). Now fill in the form
and follow the link that is displayed; the Telegram desktop application should launch. Press the
"START" button at the bottom of the conversation to receive a warm, personalized welcome from your bot!