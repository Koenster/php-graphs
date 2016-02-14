<?php namespace koenster\PHPGraphs\implementation;

abstract class AbstractImplementation
{

    const ATTRIBUTE_LINE = 'line';
    const ATTRIBUTE_LABEL = 'label';
    const ATTRIBUTE_COLOR_FILL = 'color-fill';
    const ATTRIBUTE_COLOR_FILL_STROKE = 'color-fill-stroke';
    const ATTRIBUTE_COLOR_POINT = 'color-point';
    const ATTRIBUTE_COLOR_POINT_STROKE = 'color-point-stroke';
    const ATTRIBUTE_COLOR_HIGHLIGHT_FILL = 'color-highlight-fill';
    const ATTRIBUTE_COLOR_HIGHLIGHT_STROKE = 'color-highlight-stroke';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    protected $dimensions = [];

    /**
     * @var array
     */
    protected $lines = [];

    /**
     * @var array
     */
    protected $css = [];

    /**
     * @var array
     */
    protected $js = [];

    /**
     * @var array
     */
    protected $defaults = [
        'colors' => [
            ['primary' => 'rgba(78,155,208,1)', 'secondary' => 'rgba(78,155,208,0.2)', 'color' => '#fff'],
            ['primary' => 'rgba(90,187,64,1)', 'secondary' => 'rgba(90,187,64,0.2)', 'color' => '#fff'],
            ['primary' => 'rgba(195,30,81,1)', 'secondary' => 'rgba(95,30,8,0.2)', 'color' => '#fff'],
            ['primary' => 'rgba(246,218,12,1)', 'secondary' => 'rgba(246,218,12,0.2)', 'color' => '#fff'],
            ['primary' => 'rgba(214,152,193,1)', 'secondary' => 'rgba(214,152,193,0.2)', 'color' => '#fff'],
            ['primary' => 'rgba(164,166,169,1)', 'secondary' => 'rgba(164,166,169,0.2)', 'color' => '#fff'],
            ['primary' => 'rgba(51,51,51,1)', 'secondary' => 'rgba(51,51,51,0.2)', 'color' => '#fff']
        ],
        'width' => 300,
        'height' => 300
    ];

    /**
     * @var string
     */
    protected $jsPartial;

    /**
     * Set the type of the graph
     *
     * @param $id
     * @param $type
     * @param array $params
     *
     * @return $this
     */
    public function setType($id, $type, array $params)
    {
        $this->id = $id;
        $this->type = $type;
        $this->defaults = $this->prepareDefault($params);
        return $this;
    }

    /**
     * Set line
     *
     * @author Koen Blokland Visser
     *
     * @param array $line
     * @param array $params
     *
     * @return $this
     */
    public function setLine(array $line, array $params = [])
    {
        if (isset($params['key']) === true) {
            $this->lines[$params['key']] = array_merge(['line' => $line], $params);
        } else {
            $this->lines[] = array_merge(['line' => $line], $params);
        }

        return $this;
    }

    /**
     * Set Dimensions
     *
     * @author Koen Blokland Visser
     *
     * @param array $dimensions
     *
     * @return $this
     */
    public function setDimensions(array $dimensions)
    {
        $this->dimensions = array_values($dimensions);
    }

    /**
     * Set JS
     *
     * @author Koen Blokland Visser
     *
     * @param array $js
     *
     * @return $this
     */
    public function setJs(array $js)
    {
        $this->js = array_values($js);
        return $this;
    }

    /**
     * Set CSS
     *
     * @author Koen Blokland Visser
     *
     * @param array $css
     *
     * @return $this
     */
    public function setCss(array $css)
    {
        $this->css = array_values($css);
        return $this;
    }

    /**
     * Set Defaults
     *
     * @author Koen Blokland Visser
     *
     * @param array $defaults
     *
     * @return $this
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = $defaults;
        return $this;
    }

    /**
     * Set JS Partial
     *
     * @author Koen Blokland Visser
     *
     * @param string $partial
     *
     * @return $this
     */
    public function setJsPartial($partial)
    {
        $this->jsPartial = $partial;
        return $this;
    }

    /**
     * Return CSS
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Return JS
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * Return Defaults
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Return JS partial
     *
     * @author Koen Blokland Visser
     *
     * @return string
     */
    public function getJsPartial()
    {
        return $this->jsPartial;
    }

    /**
     * Generate
     *
     * @author Koen Blokland Visser
     *
     * @return string
     */
    public function generateDimensions()
    {
        $return = 'style="';
        if ($this->defaults['width']) {
            if (is_int($this->defaults['width'])) {
                $return .= 'width: ' . $this->defaults['width'] . 'px;';
            } else {
                $return .= 'width: ' . $this->defaults['width'] . ';';
            }
        } else {
            $return .= 'width: 300px;';
        }

        if ($this->defaults['height']) {
            if (is_int($this->defaults['height'])) {
                $return .= 'height: ' . $this->defaults['height'] . 'px;';
            } else {
                $return .= 'height: ' . $this->defaults['height'] . ';';
            }
        } else {
            $return .= 'height: 300px;';
        }

        $return .= '"';

        return $return;
    }

    /**
     * Prepare the defaults
     *
     * @author Koen Blokland Visser
     *
     * @param array $defaults
     *
     * @return array
     */
    protected function prepareDefault(array $defaults)
    {
        if (empty($defaults) === false) {
            return array_replace_recursive($this->defaults, $defaults);
        }

        return $this->defaults;
    }
}