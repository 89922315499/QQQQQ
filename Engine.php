<?php

class Engine {
    private $_page_file = null;
    private $_error = null;

    public function __construct() {
        if (isset($_GET["page"])) {
            $this->_page_file = $_GET["page"];
            $this->_page_file = str_replace(".", null, $_GET["page"]);
            $this->_page_file = str_replace("/", null, $_GET["page"]);
            $this->_page_file = str_replace("", null, $_GET["page"]);
            
            if (!file_exists($this->_page_file . ".php")) {
                $this->_setError("Ошибка - запрашиваемая страница не найдена");
                $this->_page_file = "";
            }
        }   
        else { $this->_page_file = ""; }
    }

    // Запись ошибки в переменную
    private function _setError($error) {
        $this->_error = $error;
    }

    // Возврат ошибки
    public function getError() {
        return $this->_error;
    }

    // Возврат текста страницы
    public function getContentPage() {
        return file_get_contents($this->_page_file . ".php");
    }

    public function getTest() {
        return "Присутствует подключение к Engine.php";
    }
}

?>