<?php
namespace StudioEcho\StudioEchoMediaBundle\Twig\Extension;

class CheckMimeTypeExtension extends \Twig_Extension
{
    private $logger;

    public function __construct($service_container) {
        $this->logger = $service_container->get('logger');
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('mimeType', array($this, 'mimeTypeFilter')),
            new \Twig_SimpleFilter('mimeTypeIcon', array($this, 'mimeTypeIconFilter')),
        );
    }

    public function mimeTypeIconFilter($mimeType)
    {
        $this->logger->info('*** mimeTypeIconFilter');

        $fileType = $this->mimeTypeFilter($mimeType);

        if ($fileType == 'audio') {
            return 'audio.png';
        } elseif ($fileType == 'archive') {
            return 'archive.png';
        } elseif ($fileType == 'html') {
            return 'html.png';
        } elseif ($fileType == 'image') {
            return 'image.png';
        } elseif ($fileType == 'pdf-document') {
            return 'pdf-document.png';
        } elseif ($fileType == 'plain-text') {
            return 'plain-text.png';
        } elseif ($fileType == 'presentation') {
            return 'presentation.png';
        } elseif ($fileType == 'spreadsheet') {
            return 'spreadsheet.png';
        } elseif ($fileType == 'text-document') {
            return 'text-document.png';
        } elseif ($fileType == 'video') {
            return 'video.png';
        }

        return 'unknown.png';

    }

    public function mimeTypeFilter($mimeType)
    {
        $this->logger->info('*** mimeTypeFilter');

        if ($this->isAudio($mimeType)) {
            return 'audio';
        } elseif ($this->isArchive($mimeType)) {
            return 'archive';
        } elseif ($this->isHTML($mimeType)) {
            return 'html';
        }  elseif ($this->isImage($mimeType)) {
            return 'image';
        } elseif ($this->isPDFDocument($mimeType)) {
            return 'pdf-document';
        } elseif ($this->isPlainText($mimeType)) {
            return 'plain-text';
        } elseif ($this->isPresentation($mimeType)) {
            return 'presentation';  
        } elseif ($this->isSpreadsheet($mimeType)) {
            return 'spreadsheet'; 
        } elseif ($this->isTextDocument($mimeType)) {
            return 'text-document';
        } elseif ($this->isVideo($mimeType)) {
            return 'video';
        }

        return 'unknown';
    }

    private function isAudio($mimeType) {
        return $this->isFileType($mimeType, '|\baudio\b|i');
    }
    
    private function isArchive($mimeType) {
        return (
            $this->isFileType($mimeType, '|\bapplication\b(.)+compress(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+archive(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+zip(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+tar(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication/x\-ace\b|i') || 
            $this->isFileType($mimeType, '|\bapplication/x\-bz2\b|i') || 
            $this->isFileType($mimeType, '|\bgzip/document\b|i')
        );
    }
    
    private function isHTML($mimeType) {
        return $this->isFileType($mimeType, '|\btext/html\b|i');
    } 
    
    private function isImage($mimeType) {
        return $this->isFileType($mimeType, '|\bimage\b(.)+|i');
    }
    
    private function isPDFDocument($mimeType) {
        return (
            $this->isFileType($mimeType, '|\bapplication\b(.)+acrobat(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+pdf(.)+|i') || 
            $this->isFileType($mimeType, '|\btext\b(.)+pdf(.)+|i')
        );
    } 
    
    private function isPlainText($mimeType) {
        return $this->isFileType($mimeType, '|\btext/plain\b|i');
    }
    
    private function isPresentation($mimeType) {
        return (
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bms\-powerpoint\b(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bofficedocument\.presentationml\b(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bopendocument\.presentation\b(.)+|i')
        );
    }
    
    private function isSpreadsheet($mimeType) {
        return (
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bms\-excel\b(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bofficedocument\.spreadsheetml\b(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bopendocument\.spreadsheet\b(.)+|i')
        );
    }
    
    private function isTextDocument($mimeType) {
        return (
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bms\-?word\b(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bofficedocument\.wordprocessingml\b(.)+|i') || 
            $this->isFileType($mimeType, '|\bapplication\b(.)+\bopendocument\.text\b(.)+|i')
        );
    }
    
    private function isVideo($mimeType) {
        return $this->isFileType($mimeType, '|\bvideo\b(.)+|i');
    }

    private function isFileType($mimeType, $type) {
        $this->logger->info('*** isFileType');
        $this->logger->info('$mimeType = '.print_r($mimeType, true));
        $this->logger->info('$type = '.print_r($type, true));

        // $preg = preg_match($type, $mimeType);
        // $this->logger->info('$preg = '.print_r($preg, true));
        // 
        // return false;

        return $mimeType && preg_match($type, $mimeType);
    }


    public function getName()
    {
        return 'mime_type';
    }
}
