<?php
/*
 * Copyright (C) 2012 by UpCloo Ltd.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */


class UpCloo_SView {

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
