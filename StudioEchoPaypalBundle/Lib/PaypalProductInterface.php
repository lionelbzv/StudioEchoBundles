<?php

namespace StudioEchoBundles\StudioEchoPaypalBundle\Lib;

/**
 * Description of PaypalBasketInterface
 *
 * @author Studio Echo / Lionel Bouzonville
 */
interface PaypalProductInterface {
    /**
     * Get shipping item charge
     */
    public function pp_getShippingCharge();
    
    /**
     * Get price for 1 item
     */
    public function pp_getAmount($with_shipping_price = false);
    
    /**
     * Get price for 1 item
     */
    public function pp_getItemName($with_shipping_price = false);
    
    
}
