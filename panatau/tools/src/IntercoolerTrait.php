<?php
namespace Panatau\Tools;

/**
 * Utility terkait dengan intercooler JQuery Library, tool yang dibuat agar bisa digunakan oleh controller
 * User: toni
 * Date: 17/10/15
 * Time: 22:29
 */
trait IntercoolerTrait
{
    private $intercoolerParams = ['ic-request', '_method', 'ic-last-refresh', 'ic-element-id', 'ic-element-name',
        'ic-target-id', 'ic-trigger-id', 'ic-element-name', 'ic-current-url', 'ic-prompt-value', 'ic-id'];
    /**
     * Bila intercooler request?
     * @return bool
     */
    protected function isIntercoolerRequest()
    {
        return true === (bool)\Request::header('X-IC-Request', false);
    }

    /**
     * Dapatkan intercooler parameters
     * @return array
     */
    protected function getIntercoolerParams()
    {
        return $this->intercoolerParams;
    }

    /**
     * Dapatkan parameter intercooler
     * @param $param
     * @param null $default
     * @return array|string
     */
    protected function getIntercoolerValue($param, $default=null)
    {
        return \Request::input($param, $default);
    }


}