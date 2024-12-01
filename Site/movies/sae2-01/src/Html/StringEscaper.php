<?php

declare(strict_types=1);

namespace Html;

trait StringEscaper
{
    /**
     * Permet de sécuriser des caractères
     * @param String $chaine
     * @return String
     */
    public function escapeString(?String $chaine): ?String
    {
        if ($chaine==null) {
            return '';
        }
        return htmlspecialchars($chaine, ENT_QUOTES|ENT_HTML5);
    }

    public function stripTagsAndTrim(?String $text): String
    {

        if ($text==null) {
            return '';
        }

        return strip_tags(trim($text));
    }
}
