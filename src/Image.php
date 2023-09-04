<?php

namespace InfiniteEye\Theme;

class Image
{
    public $_id;
    public $_url;
    public $_path;
    public $_alt;
    public $_lazy;
    public $_width;
    public $_height;
    public $_classnames = [];
    public $_attrs = [];
    public $_inline = false;
    public $_type;

    public function __construct($path)
    {

        if (is_array($path) && isset($path['ID'])) {

            // acf image?
            $this->_id = intval($path['ID']);
            $this->_path = get_attached_file($this->_id);
            $this->_url = $path['url'];
        } elseif (intval($path) > 0) {

            // WP Image
            $this->_id = intval($path);
            $this->_path = get_attached_file($this->_id);
            $this->_url = wp_get_attachment_url($this->_id);
        } else {

            // Image
            $this->_path = trailingslashit(get_stylesheet_directory()) . (!empty(Media::$image_path) ? trailingslashit(Media::$image_path) : '') . $path;
            $this->_url = trailingslashit(get_stylesheet_directory_uri()) . (!empty(Media::$image_path) ? trailingslashit(Media::$image_path) : '') . $path;
        }

        if (!file_exists($this->_path)) {
            return;
        }

        if (preg_match('/\.svg$/', $this->_path) === 1) {

            $this->_type = 'svg';
            $xml = file_get_contents($this->_path);
            $xmlget = simplexml_load_string($xml);
            $xmlattributes = $xmlget->attributes();
            $width = (string) $xmlattributes->width;
            $height = (string) $xmlattributes->height;
        } else {
            $this->_type = 'img';
            list($width, $height) = wp_getimagesize($this->_path);
        }

        $this->_width = $width;
        $this->_height = $height;
    }

    /**
     * Set image alt tag
     * 
     * @param string $alt 
     * @return $this 
     */
    public function alt($alt)
    {
        $this->_alt = $alt;
        return $this;
    }

    /**
     * Add image class names
     * 
     * @param string $class 
     * @return $this 
     */
    public function class($class)
    {
        $this->_classnames = array_values(array_unique(array_merge($this->_classnames, explode(' ', $class))));
        return $this;
    }

    /**
     * Add custom attributes
     * 
     * @param string $name 
     * @param string $value 
     * @return $this 
     */
    public function attr($name, $value)
    {
        $this->_attrs[$name] = $value;
        return $this;
    }

    /**
     * Enable or disable lazy loading
     * 
     * @param bool $lazy 
     * @return $this 
     */
    public function lazy($lazy = true)
    {
        $this->_lazy = $lazy;
        return $this;
    }

    /**
     * Get image url
     * 
     * @return string 
     */
    public function url()
    {
        return $this->_url;
    }

    public function path()
    {
        return $this->_path;
    }

    public function width()
    {
        return $this->_width;
    }

    public function height()
    {
        return $this->_height;
    }

    public function render()
    {
        echo $this->__toString();
    }

    public function inline($inline = true)
    {
        $this->_inline = $inline;
        return $this;
    }

    public function __toString()
    {
        if ($this->_inline && $this->_type === 'svg') {
            $tag = '<div class="svg ' . implode(' ', $this->_classnames) . '">' . file_get_contents($this->_path) . '</div>';
        } elseif ($this->_lazy || (is_null($this->_lazy) && Media::$lazy)) {
            $this->class(Media::$lazy_class);
            $tag = sprintf('<img data-src="%s" alt="%s" class="%s"', $this->_url, $this->_alt, implode(' ', $this->_classnames));
        } else {
            $tag = sprintf('<img src="%s" alt="%s" class="%s"', $this->_url, $this->_alt, implode(' ', $this->_classnames));
        }

        // remove any empty attributes
        $tag = preg_replace('/\S+=""/', '', $tag);

        // add attributes after so that they are not cleared if empty
        if (!empty($this->_attrs)) {
            foreach ($this->_attrs as $attr_name => $attr_val) {
                $tag .= " {$attr_name}=\"{$attr_val}\"";
            }
        }

        if (!$this->_inline) {
            $tag .= ' />';
        }

        return $tag;
    }
}
