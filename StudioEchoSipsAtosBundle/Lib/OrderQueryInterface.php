<?php

namespace StudioEchoBundles\StudioEchoSipsAtosBundle\Lib;

/**
 * Description of OrderQueryInterface
 *
 * @author Studio Echo / Lionel Bouzonville
 */
interface OrderQueryInterface {
    public function atos_updateProductsAfterOrderCompleted($orderId);
    public function atos_updateOrderStatusAfterPaymentAccepted($orderId);
    public function atos_updateOrderStatusAfterPaymentRejected($orderId);
}
