<?php

namespace Fakeronline\Chinapnr\Utils;
use InvalidArgumentException;

class Form{

    const METHOD_POST = 'post';
    const METHOD_GET = 'get';

    protected $htmlTpl;
    protected $data;
    protected $htmlStr;

    public function __construct($url, $title = '', $method = 'post'){

        if($method === self::METHOD_GET || $method === self::METHOD_POST){

            $this->htmlTpl = <<<eod
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>{$title}</title>
        </head>
        <body>
        <form id="form" action="{$url}" method="{$method}">%s<form>
        </body>
        </html>
eod;
        }else{

            throw new InvalidArgumentException('不支持此提交方式');

        }
    }

    public function setData($data){
        $form_html = "";
        foreach($data as $key => $value){
            $form_html .= '<input type="hidden" name="'. $key .'" value="'. $value .'" >';
        }

        $form_html .= '<script type="text/javascript">document.getElementById("form").submit();</script>';

        $this->htmlStr = sprintf($this->htmlTpl, $form_html);
        return $this;
    }

    public function get(){
        return $this->htmlStr;
    }

    public function submit(){
        echo $this->htmlStr;
    }

}