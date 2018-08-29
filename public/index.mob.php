<?php
require_once 'index.php.inc'
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" Content="text/html; Charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="style.mob.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="letter.js"></script>
</head>
	 <body>
     <div class="container">
         <div class="logo-mobile logo"><img src="logo.png"></div>
         <div class="main">
             <div class="greeting">
                 <p><strong>Приветствую тебя, первокурсник Южного федерального университета!</strong></p>
                 <p>В твоей жизни начинается новый этап, мы знаем, что он станет самым ярким и интересным в твоей жизни. Ты закладываешь фундамент своего будущего, а это значит, что по окончании обучения, ты точно будешь знать, каким будет твой дальнейший путь.</p>
                 <p>Наверняка, ты захочешь узнать, что ты думал о своем будущем 4 года назад. Поэтому мы предлагаем написать письмо себе в будущее.</p>
             </div>
             <?php if ($authorized): ?>
             <div class="message">
                 <div class="message__inner">
                     <textarea id="letter-input" maxlength="3900" name="message"><?php echo $letter;?></textarea>
                 </div>
             </div>
             <?php else: ?>
                <div class="message message-login"><a href="<?php echo $loginLink; ?>" class="login">Пожалуйста, авторизуйтесь с логином и паролем личного кабинета</a></div>
             <?php endif; ?>
         </div>
         <div class="sidebar">
             <div class="logo"><img src="logo.png"></div>
             <?php if ($authorized): ?>
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