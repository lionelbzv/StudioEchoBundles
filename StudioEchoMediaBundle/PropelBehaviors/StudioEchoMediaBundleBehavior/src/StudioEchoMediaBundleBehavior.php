<?php

/**
 * Create / Delete SeMediaObject associated with current object
 *
 * @author Studio Echo / Lionel Bouzonville
 */
class StudioEchoBundlesMediaBundleBehavior extends Behavior {
    /**
     * Create a new SeMediaObject instance
     *
     * @return string The code to put at the hook
     */
    public function postInsert()
    {
      return "
        \$seMediaObject = new \StudioEchoBundles\StudioEchoBundlesMediaBundle\Model\SeMediaObject();
        \$seMediaObject->setObjectId(\$this->getId());
        \$seMediaObject->setObjectClassname(get_class(\$this));
        \$seMediaObject->save(\$con);
        ";
    }

    /**
     * Delete the associated SeMediaObject instance
     *
     * @return string The code to put at the hook
     */
    public function postDelete()
    {
      return "
        \$seMediaObject = \StudioEchoBundles\StudioEchoBundlesMediaBundle\Model\SeMediaObjectQuery::create()->filterByObjectClassname(get_class(\$this))->filterByObjectId(\$this->getId())->findOne();
        \$seMediaObject->delete(\$con);
        ";
    }

}

