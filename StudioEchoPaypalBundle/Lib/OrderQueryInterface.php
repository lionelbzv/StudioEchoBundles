<?php

namespace StudioEcho\StudioEchoPaypalBundle\Lib;

/**
 * Description of OrderQueryInterface
 *
 * @author Studio Echo / Lionel Bouzonville
 */
interface OrderQueryInterface {
    public function pp_updateProductsAfterOrderCompleted($orderId);
    public function pp_updateOrderStatusAfterPaymentAccepted($orderId);
    public function pp_updateOrderStatusAfterPaymentRejected($orderId);
}
