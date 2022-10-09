# Схема БД.

открывать на сайте https://dbdiagram.io

```
Table games as G {
  id int [pk, increment]
  creator_id int [ref: > U.id]
  invited_id int [ref: > U.id]
  status_id int [ref: > GSTAT.id]
  player_turn_id int [ref: > U.id]
  
  // флаги для фазы расстановки кораблей
  creator_ready tinyint
  invited_ready tinyint
}

Table game_statuses as GSTAT {
  id int [pk, increment]
  code varchar
  name varchar
}

Table game_ships as GS {
  id int [pk, increment]
  game_id int [ref: > G.id]
  ship_id int [ref: > S.id]
  user_id int [ref: > U.id]
  x int
  y int
  
  // 0 - horizontal
  // 1 - vertical
  orientation tinyint 
}

Table game_shots as GSHOT {
  id int [pk, increment]
  game_id int [ref: > G.id]
  user_id int [ref: > U.id]
  x int
  y int
}

Table ships as S {
  id int [pk, increment]
  length int
  max_count int
}

Table users as U {
  id int [pk, increment]
  code varchar
}

Table game_messages as GM {
  id int [pk, increment]
  game_id int [ref: > G.id]
  user_id int [ref: > U.id]
  message longtext
}

```
