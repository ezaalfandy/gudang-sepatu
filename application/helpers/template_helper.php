<?php
    function url_to_breadcrumb($url){
        $url = str_replace('view', '', $url);
        $url = str_replace('-', ' ', $url);
        $url = ucwords($url);
        return $url;
    }
?>