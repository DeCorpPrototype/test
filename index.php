<?php
session_start(); 

class authentication {
    private $_login = 'admin1';
    private $_pass  = 'pass';
    
    public function isAuth() {
        if (isset($_SESSION['is_auth'])) {
            return $_SESSION['is_auth'];
        }
        else { 
            return false;
        }
    }
    
    public function auth($login, $pass) {
        if ($login == $this->_login && $pass == $this->_pass) {
            $_SESSION['is_auth'] = true;
            $_SESSION['login']   = $login;
            return true;
        }
        else {
            $_SESSION['is_auth'] = false;
            return false;
        }
    }
    
    public function getLogin() {
        if ($this->isAuth()) {
            return $_SESSION['login'];
        }
    }
    
    public function out() {
        $_SESSION = array();
        session_destroy();
    }
}

$auth = new authentication();

if (isset($_POST["login"]) && isset($_POST["password"])) { //Если логин и пароль были отправлены
    if (!$auth->auth($_POST["login"], $_POST["password"])) { //Если логин и пароль введен не правильно
        echo '<h2 style="color:red;">Логин и пароль введен не правильно!</h2>';
    }
}
 
if (isset($_GET["is_exit"])) { //Если нажата кнопка выхода
    if ($_GET["is_exit"] == 1) {
        $auth->out(); //Выходим
        header("Location: /"); //Редирект после выхода
    }
}

if ($auth->isAuth()) { // Если пользователь авторизован, приветствуем:  
    echo "Здравствуйте, " . $auth->getLogin() ;
    echo "<br/><br/><a href='?is_exit=1'>Выйти</a>"; //Показываем кнопку выхода
} 
else { //Если не авторизован, показываем форму ввода логина и пароля
?>
<form method="post" action="">
    Логин: <input type="text" name="login"
    value="<?php echo (isset($_POST["login"])) ? $_POST["login"] : null; // Заполняем поле по умолчанию ?>" />
    <br/>
    Пароль: <input type="password" name="password" value="" /><br/>
    <input type="submit" value="Войти" />
</form>

<?php 
} 