<?php
require_once '../include/index.php.inc'
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" Content="text/html; Charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="letter.js"></script>
</head>
<body>
<div class="container">
    <div class="logo"><a href="/"><img src="logo.png"></a></div>
    <div class="main">
        <div class="greeting">
            <p><strong>ПРИВЕТСТВУЕМ ТЕБЯ, ПЕРВОКУРСНИК ЮЖНОГО ФЕДЕРАЛЬНОГО УНИВЕРСИТЕТА!</strong></p>
            <p>В ТВОЕЙ ЖИЗНИ НАЧИНАЕТСЯ НОВЫЙ ЭТАП.</p>
            <p>МЫ УВЕРЕНЫ, ЧТО ОН СТАНЕТ САМЫМ ЯРКИМ И ИНТЕРЕСНЫМ В ТВОЕЙ ЖИЗНИ.</p>
            <p>СЕГОДНЯ ТЫ ЗАКЛАДЫВАЕШЬ ФУНДАМЕНТ СВОЕГО БУДУЩЕГО, А ЭТО ЗНАЧИТ, ПО ОКОНЧАНИИ ОБУЧЕНИЯ, ТЫ ТОЧНО БУДЕШЬ ЗНАТЬ, КАКИМ БУДЕТ ТВОЙ ДАЛЬНЕЙШИЙ ПУТЬ.</p>
            <p>НАВЕРНЯКА, ТЫ ЗАХОЧЕШЬ УЗНАТЬ, ЧТО ТЫ ДУМАЛ О СВОЕМ БУДУЩЕМ ЧЕТЫРЕ ГОДА НАЗАД!</p>
            <p>ПОЭТОМУ МЫ ПРЕДЛАГАЕМ НАПИСАТЬ ПИСЬМО СЕБЕ В БУДУЩЕЕ!</p>
            <p class="postscriptum">Р.S. Если ты успеешь написать письмо до 10 сентября, то получишь возможность выиграть уникальный комплект с символикой университета и с автографом ректора! Победитель получит свой приз на Фестивале науки Юга России 5 октября на стадионе Ростов-Арена!</p>
        </div>
        <?php if ($authorized): ?>
            <?php if ($isAllowed): ?>
                <div class="login-info">Ваш аккаунт &mdash; <?php echo $email; ?> (<a href="/logout.php" class="login-link">Выйти</a>)</div>
                <div class="message">
                    <div class="message__inner">
                        <textarea id="letter-input" maxlength="3900" name="message"><?php echo $letter;?></textarea>
                    </div>
                </div>
            <?php else: ?>
                <div class="login-info">Ваш аккаунт &mdash; <?php echo $email; ?>, сайт доступен только для первокурсников (<a href="/logout.php" class="login-link">Выйти</a>)</div>
            <?php endif; ?>
        <?php else: ?>
            <div class="login-info"><a href="<?php echo $loginLink; ?>" class="login-link">Пожалуйста, авторизуйтесь с логином и паролем личного кабинета</a></div>
        <?php endif; ?>
    </div>
    <div class="sidebar">
        <?php if ($authorized && $isAllowed): ?>
            <div class="submit-message"></div>
            <form id="letter-form" method="POST" action="save_letter.php">
                <input type="submit" name="submit" value="Отправить">
                <input id="letter-user" type="hidden" name="user" value="<?php echo $encryptedUser; ?>">
                <input id="letter-text" type="hidden" name="letter" value="">
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>