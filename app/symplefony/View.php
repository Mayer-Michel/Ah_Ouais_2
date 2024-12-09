<?php
namespace Symplefony;
class View
{
    public const VIEW_PATH = APP_PATH .'views'. DS;
    public const COMMON_PATH = self::VIEW_PATH .'_common'. DS;
    public function __construct()
    {
        
    }
    public function render(): void
    {
        require_once self::COMMON_PATH .'top.phtml';
        require_once self::VIEW_PATH .'page'. DS .'home.phtml';
        require_once self::COMMON_PATH .'bottom.phtml';
    }
}