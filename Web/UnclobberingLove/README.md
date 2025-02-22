# Challenge Card

## Chall name:
Unclobbering Love

## Chall Scenario:
Help Cupid deliver a Valentine's love letter! Craft a message, and the bot will send it. But can you make it reveal its secrets?

## Hint:
None

## Author:
m4dz

## docker compose:
```
services:
  love-letter:
    image: tiangolo/uwsgi-nginx-flask:python3.12
    volumes:
      - ./UnclobberingLove/challenge/app:/app
    environment:
      - BOT_HOST=love-bot
      - BOT_PORT=8080
      - SITE_URL=http://love-letter/
    ports:
      - 8000:80/tcp
    restart: on-failure

  love-bot:
    build:
      context: ./UnclobberingLove/challenge/bot
    environment:
      - PORT=8080
      - REPORT_HOST=love-letter
      - SITE_URL=http://love-letter/
      - FLAG=SecuriNets{Cup1d_St0l3_My_H34rt_4nd_My_C00k13}
    restart: on-failure
```