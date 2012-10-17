<?php
class SView {

    private $_path;

    private $_data = array();

    private $_dataView = array();

    public function __set($key, $value)
    {
        $this->_data[$key] = $value;
    }

    public function __get($key)
    {
        if(isset($this->_dataView[$key])) {
            return $this->_dataView[$key];
        }
        else if(isset($this->_data[$key])) {
            return $this->_data[$key];
        }
        else {
            return false;
        }
    }

    public function setViewPath($path)
    {
        if (!is_dir($path)) {
            throw new Exception("View path {$path} must be a directory");
        }
        $this->_path = $path;
    }

    public function render($filename, $data = false)
    {
        if($data) {
            $this->_dataView = $data;
        }

        if(!$this->_path) {
            $this->setViewPath(dirname(__FILE__));
        }

        $filename = $this->_path . "/" . $filename ;
        if (!file_exists($filename)) {
            throw new Exception("Unable to get view at path: {$filename}");
        }

        $rendered = "";

        ob_start();
        require($filename);
        $rendered = ob_get_contents();
        ob_end_clean();

        return $rendered;
    }
}
