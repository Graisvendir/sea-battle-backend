# Морской бой

Онлайн морской бой, на 2 человек, с чатом. Одновременно может идти сколько угодно игр (не только на одну пару людей).

Swagger UI: http://<host>/swagger

## Описание задачи

Первый игрок заходит на сайт. Жмёт кнопку для создания новой партии. Его редиректит на страницу партии, в ссылке - код доступа к игре. Так же ему высвечивается ссылка для приглашения соперника, с другим кодом.
Попадает на экран расстановки своего поля. Расставляет корабли, жмёт кнопку подтверждения готовности.
В это время его соперник, перейдя по присланной ему ссылке так же расставляет корабли и жмёт кнопку подтверждения готовности. Когда оба игрока подтвердили готовности - партия переключается в фазу игры. 
У игроков показывается экран поля боя, своё со своей расстановкой кораблей, и чужое с известными чужими кораблями и прошлыми выстрелами (пока пустое). На этом экране есть чат, игроки могут переписываться между собой.
Случайным образом выбирается игрок, который будет ходить первым. 
Этот игрок делает выстрел. Если попал - продолжает стрелять, если промазал - ход переходит к другому игроку. После каждого выстрела проверяется, если убиты все корабли противника - игрокам показывается сообщение об их проигрыше/выигрыше.
