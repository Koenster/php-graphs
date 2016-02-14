<?php namespace koenster\PHPGraphs\contract;

interface ChartContract {

    /**
     * Set the type of the graph
     *
     * @param $id
     * @param $type
     * @param array $params
     *
     * @return $this
     */
    public function setType($id, $type, array $params);

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
    public function setLine(array $line, array $params = []);

    /**
     * Set Dimensions
     *
     * @author Koen Blokland Visser
     *
     * @param array $dimensions
     *
     * @return $this
     */
    public function setDimensions(array $dimensions);

    /**
     * Set JS
     *
     * @author Koen Blokland Visser
     *
     * @param array $js
     *
     * @return $this
     */
    public function setJs(array $js);

    /**
     * Set CSS
     *
     * @author Koen Blokland Visser
     *
     * @param array $css
     *
     * @return $this
     */
    public function setCss(array $css);

    /**
     * Set Defaults
     *
     * @author Koen Blokland Visser
     *
     * @param array $defaults
     *
     * @return $this
     */
    public function setDefaults(array $defaults);

    /**
     * Set JS Partial
     *
     * @author Koen Blokland Visser
     *
     * @param string $partial
     *
     * @return $this
     */
    public function setJsPartial($partial);

    /**
     * Return CSS
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    public function getCss();

    /**
     * Return JS
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    public function getJs();

    /**
     * Return Defaults
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    public function getDefaults();

    /**
     * Return JS partial
     *
     * @author Koen Blokland Visser
     *
     * @return string
     */
    public function getJsPartial();

    /**
     * Generate
     *
     * @author Koen Blokland Visser
     *
     * @return string
     */
    public function generateDimensions();

    /**
     * Generate graph
     *
     * @author Koen Blokland Visser
     *
     * @return string
     */
    public function generate();
}