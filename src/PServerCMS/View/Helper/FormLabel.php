<?php


namespace PServerCMS\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormLabel as OriginalFormLabel;

class FormLabel extends OriginalFormLabel
{
    /** @var  ElementInterface */
    protected $element;

    /**
     * @param ElementInterface|null $element
     * @param null $labelContent
     * @param null $position
     * @return string|OriginalFormLabel
     */
    public function __invoke(ElementInterface $element = null, $labelContent = null, $position = null)
    {
        $this->element = $element;

        return parent::__invoke($element, $labelContent, $position);
    }

    /**
     * Return a closing label tag
     *
     * @return string
     */
    public function closeTag()
    {
        $result = '</label>';
        if ($this->element->hasAttribute('required') && $this->element->getAttribute('required')) {
            $result = sprintf('<span class="required-mark">*</span> %s', $result);
        }

        return $result;
    }
}