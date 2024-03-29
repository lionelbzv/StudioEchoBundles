<?php

/**
 * Propel behavior for making models indexable und searchable with IvoryLuceneSearchBundle.
 *
 * SF2 adaptation of sf1.4 rsLucenePlugin
 * requirement: https://github.com/glorpen/GlorpenPropelBundle
 *
 * @author     Lionel Bouzonville / Studio Echo
 */
class IvoryLuceneIndexationBundleBehavior extends Behavior
{
    protected $parameters = array(
        'check_active' => false,
        'index_on_save' => true,
    );

    public function objectMethods($builder)
    {
        return $this->addIsActivColumn();
    }

    protected function addIsActivColumn()
    {
        if (false === $this->getParameter('check_active')) {
            return "
              /**
               * Check if object is activ for a Lucene Search
               */
              public function isActiv()
              {
                return true;
              }
              ";
        } else {
            $column = $this->getParameter('check_active');
            return "
              /**
               * Check if object is activ for a Lucene Search
               */
              public function isActiv()
              {
                return \$this->{$column};
              }
              ";
        }
  
    }

    public function postSave()
    {
        if (true === $this->getParameter('index_on_save')) {
            if (false === $this->getParameter('check_active')) {
                return "
// Appel du service indexation Lucene
\$this->seiliService->updateDocument(\$this, get_class(\$this));
";
            } else {
                if ($column = $this->getParameter('check_active')) {
                    return "
if (\$this->{$column}) {
    // Appel du service indexation Lucene
    \$this->seiliService->updateDocument(\$this, get_class(\$this));
} else {
    // Appel du service indexation Lucene
    \$this->seiliService->deleteDocument(\$this, get_class(\$this));
}
";
                }
            }
        }
    }

    public function postDelete()
    {
        return "
// Appel du service indexation Lucene
\$this->seiliService->deleteDocument(\$this, get_class(\$this));
";
    }
}
