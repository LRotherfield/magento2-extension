<?php
namespace Ometria\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Ometria\Core\Helper\MageConfig;
use Psr\Log\LoggerInterface as PsrLoggerInterface;

class Config extends AbstractHelper
{
    /** @var MageConfig */
    private $coreHelperMageConfig;

    /** @var PsrLoggerInterface */
    private $logger;

    public function __construct(
        Context $context,
        MageConfig $coreHelperMageConfig,
        PsrLoggerInterface $logger
    ) {
        parent::__construct($context);

        $this->coreHelperMageConfig = $coreHelperMageConfig;
        $this->logger = $logger;
    }

    public function isEnabled()
    {
        return $this->coreHelperMageConfig->get('ometria/general/enabled');
    }

    public function isDebugMode()
    {
        return $this->coreHelperMageConfig->get('ometria/advanced/debug');
    }

    // Is data layer configured?
    public function isUnivarEnabled()
    {
        return $this->coreHelperMageConfig->get('ometria/advanced/univar');
    }

    public function isPingEnabled()
    {
        return $this->coreHelperMageConfig->get('ometria/advanced/ping');
    }

    public function isScriptDeferred()
    {
        return $this->coreHelperMageConfig->get('ometria/advanced/scriptload');
    }

    public function getAPIKey($store_id = null)
    {
        if ($store_id) {
            return $this->coreHelperMageConfig->get('ometria/general/apikey', $store_id);
        } else {
            return $this->coreHelperMageConfig->get('ometria/general/apikey');
        }
    }

    public function isConfigured()
    {
        return $this->isEnabled() && $this->getAPIKey() != "";
    }

    public function log($message)
    {
        $this->logger->error($message);
    }

    public function isSkuMode(){
        return $this->coreHelperMageConfig->get('ometria/advanced/productmode')=='sku';
    }

    /**
     * @return bool
     */
    public function canUseConfigurableImage()
    {
        return (bool) $this->coreHelperMageConfig->get('ometria/advanced/use_configurable_image');
    }

    /**
     * @return string
     */
    public function getPreferredProductAttribute()
    {
        return (string) $this->coreHelperMageConfig->get('ometria/advanced/preferred_product_attribute');
    }
}
