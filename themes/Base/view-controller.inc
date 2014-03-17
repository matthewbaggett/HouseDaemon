<?php

class ViewController extends \Slim\View
{
    private $_js = array();
    private $_css = array();
    private $_site_title = 'Untitled site';
    private $_page_title;

    public function render($template, $data = NULL)
    {
        $template = dirname(__FILE__) . '/templates/' . $template;
        //$overriden_template =

        if(!is_array($this->data)){
            $data = (array) $this->data;
            $data = end($data);
        }else{
            $data = $this->data;
        }

        extract($data);

        // Decide what to do with the site title.
        $site_title = 'Unnamed Site';
        if(isset($page_title)){
            $site_title = "{$site_title} | {$page_title}";
        }else{
            $site_title = "{$site_title}";
        }
        if(function_exists('get_git_version_short')){
            $version = get_git_version_short();
            if(strtotime(get_git_version_time()) < strtotime('10 years ago')){
                // Not a GIT build.
            }else{
                $ago = get_git_version_time_ago();
                $site_title = "{$site_title} | Build {$version} ($ago)";
            }
        }

        if(!file_exists($template)){
            throw new exception("Cannot find template $template");
        }
        ob_start();
        $wrapper_template = dirname(__FILE__) . "/templates/wrapper/main.phtml";
        require($wrapper_template);
        $return = ob_get_contents();
        ob_clean();
        return $return;
    }

    public function getCSS(){
        return $this->_css;
    }

    public function addCSS($css){
        $this->_css[] = $css;
        return $this;
    }

    public function getJS(){
        return $this->_js;
    }

    public function addJS($js){
        $this->_js[] = $js;
        return $this;
    }

    public function url($url){
        // Do not process absolute URLs.
        if(strpos($url, '://') !== false){
            return $url;
        }

        // Remove excess slashes to the left of URL.
        $url = ltrim($url,"/");

        $url = ltrim($url);
        return (WEB_IS_SSL?'https://':'http://') . WEB_HOST . WEB_ROOT . "/" . $url;
    }

    public function link($url, $text){
        $url = $this->url($url);
        return "<a href=\"{$url}\">{$text}</a>";
    }

    public function l($url, $text){
        return $this->link($url, $text);
    }

    public function getSiteTitle($decorate = true){
        if($this->_page_title && $decorate){
            return "{$this->_site_title} - {$this->_page_title}";
        }else{
            return "{$this->_site_title}";
        }
    }

    public function setSiteTitle($title){
        $this->_site_title = $title;
        return $this;
    }

    public function setPageTitle($title){
        $this->_page_title = $title;
        return $this;
    }

    public function translate($string, $replacements = array()){
        return \FourOneOne\Translation\Translation::getInstance()->translate($string, $replacements);
    }

    public function t($string, $replacements = array()){
        return $this->translate($string, $replacements);
    }


}