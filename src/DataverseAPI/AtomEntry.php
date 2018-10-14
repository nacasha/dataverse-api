<?php

namespace DataverseAPI;

class AtomEntry
{

    protected $xml = '';

    public function __construct() 
    {
        $this->xml = xmlwriter_open_memory();
        xmlwriter_set_indent($this->xml, 1);
        xmlwriter_set_indent_string($this->xml, ' ');

        xmlwriter_start_document($this->xml, '1.0');

        xmlwriter_start_element($this->xml, "entry");
            xmlwriter_start_attribute($this->xml, 'xmlns');
            xmlwriter_text($this->xml, 'http://www.w3.org/2005/Atom');
            xmlwriter_end_attribute($this->xml);

            xmlwriter_start_attribute($this->xml, 'xmlns:dcterms');
            xmlwriter_text($this->xml, 'http://purl.org/dc/terms/');
            xmlwriter_end_attribute($this->xml);
    }

    public function tag($tag, $value, $attributes = array())
    {
        xmlwriter_start_element($this->xml, "dcterms:${tag}");

        foreach($attributes as $attribute => $attr_value) {
            xmlwriter_start_attribute($this->xml, $attribute);
            xmlwriter_text($this->xml, $attr_value);
            xmlwriter_end_attribute($this->xml);
        }

        xmlwriter_text($this->xml, $value);
        xmlwriter_end_element($this->xml);
    }

    public function build()
    {
        xmlwriter_end_element($this->xml);
        xmlwriter_end_document($this->xml);
        
        return xmlwriter_output_memory($this->xml);
    }

}
