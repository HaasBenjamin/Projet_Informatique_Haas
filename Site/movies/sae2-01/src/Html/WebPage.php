<?php

declare(strict_types=1);

namespace Html ;

use Html\StringEscaper;

class WebPage
{
    use StringEscaper;
    protected String $head = "";
    protected String $title = "";
    protected String $body = "";

    /**
     * Constructeur de la classe WebPage permet d'initialiser le titre
     * @param string $title
     */
    public function __construct(string $title="")
    {
        $this->title = $title;
    }

    /**
     * Accesseur sur l'attribut head
     * @return String
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Accesseur sur l'attribut title
     * @return String
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Accesseur sur l'attribut body
     * @return String
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Modificateur de l'attribut title
     * @param String $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Permet d'ajouter du contenu dans l'attribut head
     * @param String $contenu
     * @return void
     */
    public function appendToHead(String $contenu): void
    {
        $this->head.=$contenu;
    }

    /**
     * Ajoute un contenu css à head
     * @param String $css
     * @return void
     */
    public function appendCss(String $css): void
    {
        $this->head.="<style>$css</style>";
    }

    /**
     * Permet d'ajouter le lien vers un fichier css
     * @param String $url
     * @return void
     */
    public function appendCssUrl(String $url): void
    {
        $this->head.="<link  href=$url rel='stylesheet'/>";
    }

    /**
     * Ajoute un contenu js à head
     * @param String $css
     * @return void
     */
    public function appendJs(String $js): void
    {
        $this->head.="<script>$js</script>";
    }

    /**
     * Permet d'ajouter le lien vers un fichier css
     * @param String $url
     * @return void
     */
    public function appendJsUrl(String $url): void
    {
        $this->head.="<script src=$url></script>";
    }

    /**
     * Permet d'ajouter du contenu à body
     * @param string $content
     * @return void
     */
    public function appendContent(string $content): void
    {
        $this->body.=$content;
    }

    /**
     * Permet de produire le contenu html final
     * @return String
     */
    public function toHTML(): String
    {
        $html=<<<HTML
        <!doctype html>
        <html lang="fr">
        <head>
        <meta name="viewport">
        <meta charset="utf-8">

        HTML;
        $html.=$this->head;
        $html.="<title>{$this->title}</title></head>";
        $html.="<body>{$this->body}</body></html>";
        return $html;
    }



    public static function getLastModification(): string
    {
        return date("d/m/y H:m", getlastmod());
    }


}
