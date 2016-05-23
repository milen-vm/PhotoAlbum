<?php
namespace MyMVC\Library\Utility\ViewHelpers;

class Alert
{

    private $output = '';

    private $type = '';

    private $text = '';

    private $hasClouseBtn = false;

    private function __construct()
    {
        $this->output = "<div class=\"alert alert-";
    }

    public static function create()
    {
        return new self();
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    public function addClouseBtn()
    {
        $this->hasClouseBtn = true;

        return $this;
    }

    public function render()
    {
        $this->output .= $this->type . "\">\n";
        if ($this->hasClouseBtn) {
            $this->output .= "<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n";
        }

        $this->output .= "<strong>" . ucfirst($this->type);
        $this->output .= ": </strong> " . $this->text;
        $this->output .= "\n</div>";

        echo $this->output;
    }
}