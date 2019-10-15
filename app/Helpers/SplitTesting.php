<?php

namespace App\Helpers;

use DeviceDetector\Parser\Device\DeviceParserAbstract;
use DeviceDetector\DeviceDetector;

class SplitTesting
{
    protected static $instance;

    protected $city;

    protected $device;

    protected $deviceDetector;

    private $_attributes = [];

    /**
     * Constructor initialize device detector and initalize base class parameters, as city, device and deviceDetector
     * $this->deviceDetector makes device detectors methods available to outside
     * $this->device store currently detected device code
     * $this->city store city, parsed from URL
     */
    public function __construct()
    {
        DeviceParserAbstract::setVersionTruncation(DeviceParserAbstract::VERSION_TRUNCATION_NONE);
        $deviceDetector = new DeviceDetector(request()->server('HTTP_USER_AGENT'));
        $deviceDetector->parse();
        $this->deviceDetector = $deviceDetector;
        $this->device = $deviceDetector->getDevice();
        $this->city = getUrlPathFirstPart();
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function __call($name, $attributes)
    {
        return false;
    }

    public function isMobile(): bool
    {
        return !empty($this->device) && in_array($this->device, array(
            DeviceParserAbstract::DEVICE_TYPE_FEATURE_PHONE,
            DeviceParserAbstract::DEVICE_TYPE_SMARTPHONE,
            DeviceParserAbstract::DEVICE_TYPE_CAMERA,
            DeviceParserAbstract::DEVICE_TYPE_PORTABLE_MEDIA_PAYER,
        ));
    }

    public function isTablet(): bool
    {
        return !empty($this->device) && in_array($this->device, array(
            DeviceParserAbstract::DEVICE_TYPE_TABLET,
            DeviceParserAbstract::DEVICE_TYPE_PHABLET,
        ));
    }

    public function isDesktop(): bool
    {
        return !$this->isMobile() && !$this->isTablet();
    }

    /**
     * Function check if split testing has selected result
     * @param string $value - searchable result of split testing
     * @return boolean
     */
    public function has(string $value): bool
    {
        if (empty($this->_attributes)) {
            return false;
        }

        foreach ($this->_attributes as $attribute) {
            if ($value === $attribute['key']) {
                return true;
            }
        }
        return false;
    }

    /**
     * Function return test result (alias / string) by test(function) name;
     * @param string $index - function name; if null or not defined, function return last test result
     * @return mixed alias / string or array with test data
     */
    public function get(?string $index = null)
    {
        if (is_null($index)) {
            return end($this->_attributes);
        }
        $this->{$index}();

        return $this->_attributes[$index];
    }

    /**
     * Function check via session if test was already completed and get previous test result / generate new split test result
     * @param string $sessionName - name of session to check, if test was already completed
     * @param array $options - bunch of variants for split testing
     * @return void
     */
    private function _run(string $sessionName, array $options)
    {
        $session = session($sessionName);
        if (empty($session) || empty($options[$session])) {
            $session = array_rand($options);
            session([$sessionName => $session]);
        }
        $this->_attributes[debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['function']] = ['key' => $session, 'value' => $options[$session]];
    }

    public function residentialComplexShowPopup(): self
    {
        /*switch ($this->city):
            case 'sankt-peterburg':
            case 'novosibirsk':
            case 'krasnoyarsk':
                $popupNames = [//'v2-popup-actual-price-req','v2-popup-actual-price-excursion','v2-popup-actual-price-request-phone',
                    'v2-popup-actual-deadline-request-phone'];
                    //, 'v2-popup-actual-deadline-request-phone2','v2-popup-actual-deadline-request']; //'popup-actual-price-green''popup-hidden-number-price-from''popup-actual-price-white''popup-discount-price-range' 'popup-discount' 'popup-lite-hybrid''popup-hidden-number''popup-hidden-number-price-from'
                break; //'v2-popup-actual-price-req','v2-popup-actual-price-excursion','v2-popup-actual-price-request-phone','v2-popup-actual-deadline-request-phone','v2-popup-actual-deadline-request'
            default:
                $popupNames = ['popup-lite-hybrid'];
                break;
        endswitch;*/
        $popupNames = ['v2-popup-actual-deadline-request-phone'];
        $popupTypes = array_filter(POPUP_TYPES,
            function ($key) use ($popupNames) {
                return in_array($key, $popupNames);
            }, ARRAY_FILTER_USE_KEY
        );

        $this->_run($this->city . '-popup-type', $popupTypes);
        return $this;
    }

    public function residentialComplexShowView(): self
    {
        switch ($this->city):
            case 'sankt-peterburg':
            case 'moskva':
            case 'novosibirsk':
                $viewNames = ['view2' => 'v2.residentials.show'];
                break;
            default:
                $viewNames = ['view1' => 'residentials.show'];
                break;
        endswitch;
        
        $this->_run($this->city . '-view-type', $viewNames);
        return $this;
    }

    public function residentialComplexShowMobileView(): self
    {
        $mobileApartmentsViews = ['two-white' => 'two-white-layouts'/*, 'one-black' => 'one-black-layout'*/];

        $this->_run($this->city . '-mobile-apartments-view', $mobileApartmentsViews);
        return $this;
    }

    public function developersShowPopup(): self
    {
        switch ($this->city):
            case 'sankt-peterburg':
                $popupNames = ['popup-hidden-number', 'popup-hidden-number-price-from', 'popup-discount', 'popup-discount-price-range', 'popup-actual-price-green', 'popup-actual-price-white'];
                break;
            case 'novosibirsk':
                $popupNames = [ 'popup-actual-price-green'/*,  'popup-actual-price-white''popup-discount-price-range''popup-discount''popup-hidden-number-price-from''popup-lite-hybrid' 'popup-hidden-number'*/];
                break;
            default:
                $popupNames = ['popup-lite-hybrid'];
                break;
        endswitch;
        $popupTypes = array_filter(POPUP_TYPES,
            function ($key) use ($popupNames) {
                return in_array($key, $popupNames);
            }, ARRAY_FILTER_USE_KEY
        );

        $this->_run($this->city . '-developer-popup-type', $popupTypes);
        return $this;
    }

    public function developersShowView(): self
    {
        switch ($this->city):
            case 'sankt-peterburg':
            case 'novosibirsk':
                $viewNames = ['view2' => 'v2.developers.show'];
                break;
            default:
                $viewNames = ['view1' => 'developers.show'];
                break;
        endswitch;

        $this->_run($this->city . '-developer-view-type', $viewNames);
        return $this;
    }

    /**
     * Private clone method to prevent cloning of the instance of the singleton instance.
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the singleton instance.
     */
    private function __wakeup()
    {
    }
}