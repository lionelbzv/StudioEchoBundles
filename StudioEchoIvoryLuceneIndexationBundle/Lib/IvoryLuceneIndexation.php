<?php
namespace StudioEchoBundles\StudioEchoIvoryLuceneIndexationBundle\Lib;

use ZendSearch\Lucene\Document;
use ZendSearch\Lucene\Document\Field;
use ZendSearch\Lucene\Search\QueryParser;

/**
 * Friendly zend lucene wrapper
 *
 * SF2 adaptation of sf1.4 rsLucenePlugin
 *  TODO:
 *    - optimisation / boost / config
 *
 * @author     Lionel Bouzonville / Studio Echo
 */
class IvoryLuceneIndexation
{
    // Logger
    private $logger;
  
    // Ivory Lucene Search service
    private $lucene;
  
    // Config
    private $config;
  
    /**
     *
     */
    public function __construct(\Ivory\LuceneSearchBundle\Model\LuceneManager $lucene, \Symfony\Component\HttpKernel\Log\LoggerInterface $logger = null)
    {
        $this->lucene = $lucene;
        $this->logger = $logger;
    }

    /**
     * Set the lucene indexes.
     *
     * Example:
     *   ContentProducer:
     *     pk:       id
     *     title:
     *       boost:  1.5
     *       method: getTitle
     *     description:
     *       boost:  1
     *       methods: [ getDescription ]
     *     route:    MyRoute
     *     category: content
     *
     * @param array $indexes The lucene indexes.
     *
     * @throws \InvalidArgumentException If a lucene index path is not provided.
     */
    public function setConfig(array $indexes)
    {
        foreach ($indexes as $identifier => $index) {
            if (!isset($index['ivory_index'])) {
                throw new \InvalidArgumentException('IvoryLuceneSearchBundle index must be set.');
            }

            if (!isset($index['pk'])) {
                $index['pk'] = 'id';
            }

            if (!isset($index['title']['boost'])) {
                $index['title']['boost'] = 1;
            }

            if (!isset($index['title']['method'])) {
                $index['title']['method'] = 'getTitle';
            }

            if (!isset($index['description']['boost'])) {
                $index['description']['boost'] = 1;
            }

            if (!isset($index['description']['methods'])) {
                $index['description']['methods'] = array('getDescription');
            }

            if (!isset($index['category'])) {
                $index['category'] = 'content';
            }

            $this->config[$identifier] = $index;
        }
    }

    /**
     * updates a document
     * @param sfBaseObject
     */
    public function updateDocument($object, $className)
    {
        if ($this->logger) {
            $this->logger->info('updateDocument');
            // $this->logger->info('object = '.print_r($object, true));
            $this->logger->info('className = '.print_r($className, true));
            // $this->logger->info('str_replace = '.print_r(str_replace('\\', '_', $className), true));
        }

        $configClass = $this->config[$className];

        if ($this->logger) {
            $this->logger->info('configClass = '.print_r($configClass, true));
        }

        // Request an index
        $index = $this->lucene->getIndex($configClass['ivory_index']);

        // Suppression doc si existant
        $this->deleteDocument($object, $className);

        // Check Status actif
        if ($object->isActiv()) {
            // Create a new document
            $document = new Document();
    
            // Construction dynamique des méthodes pour récupérer: id, title, description
            $getId = 'get'.ucfirst($configClass['pk']);
            $getTitle = $configClass['title']['method'];
            $getDescriptionMethods = $configClass['description']['methods'];
    
            $document->addField(Field::keyword(str_replace('\\', '_', $className).'_id', $object->$getId()));
            $document->addField(Field::text('title', $object->$getTitle()), 'utf-8');
    
            $description = '';
            foreach ($getDescriptionMethods as $getDescription) {
                $description .= $object->$getDescription() . ' ';
            }
            $document->addField(Field::text('description', $description, 'utf-8'));
    
            $document->addField(Field::unIndexed('class', $className));
            $document->addField(Field::unIndexed('object_id', $object->$getId()));
    
            // Add your document to the index
            $index->addDocument($document);
            if ($this->logger) {
                $this->logger->info('add document ok');
            }
    
            // Commit your change
            $index->commit();
            if ($this->logger) {
                $this->logger->info('commit ok');
            }
    
            // If you want you can optimize your index
            $index->optimize();
            if ($this->logger) {
                $this->logger->info('optimize ok');
            }
        }
    }

    /**
     * deletes a document
     * @param sfBaseObject $object
     */
    public function deleteDocument($object, $className)
    {
        if ($this->logger) {
            $this->logger->info('deleteDocument');
            // $this->logger->info('object = '.print_r($object, true));
            $this->logger->info('className = '.print_r($className, true));
        }

        $configClass = $this->config[$className];
        if ($this->logger) {
            $this->logger->info('configClass = '.print_r($configClass, true));
        }

        // Request an index
        $index = $this->lucene->getIndex($configClass['ivory_index']);
        if ($this->logger) {
            $this->logger->info('get index ok');
        }

        foreach ($index->find(str_replace('\\', '_', $className).'_id:' . $object->getId()) as $hit) {
            if ($this->logger) {
                $this->logger->info('hit - id = '.$hit->id);
            }

            $index->delete($hit->id);
        }

        $index->commit();
    }

    // ********************************************************************************************** //
    /**
     *  Transformation de la chaine en objet Zend_Search_Lucene_QueryParser
     *
     * @return Zend_Search_Lucene_QueryParser
     */
    public function getQueryParser($queryStr)
    {
        $query = QueryParser::parse($queryStr);

        return $query;
    }

    /**
     * searches the index for a given query
     *
     * @param $index      Nom de l'index
     * @param $queryStr   Chaine recherchée
     * @param $category   Catégorie de recherche
     * @param $fuzzy      Indice de recherche fuzzy (entre 0 et 1), false sinon
     * @return array      Zend_Search_Lucene_Search_QueryHit
     */
    public function search($index, $queryStr, $category = 'content', $fuzzy = false, $operator = 'and')
    {
        if ($this->logger) {
            $this->logger->info('search');
            $this->logger->info('$index = '.print_r($index, true));
            $this->logger->info('$queryStr = '.print_r($queryStr, true));
            $this->logger->info('$category = '.print_r($category, true));
            $this->logger->info('$fuzzy = '.print_r($fuzzy, true));
        }

        if ($fuzzy && is_float($fuzzy) && $fuzzy <= 1 && $fuzzy > 0 && false === strpos($queryStr, ' ')) {
            $queryStr = $queryStr . '~' . $fuzzy;
        }

        if ($operator == 'and') {
            $queryStr = str_replace(' ', ' +', $queryStr);
        }

        $this->logger->info('$queryStr = '.print_r($queryStr, true));

        $query = $this->getQueryParser($queryStr);
        $documents = $this->lucene->getIndex($index)->find($query);
        return $documents;
    }
}
