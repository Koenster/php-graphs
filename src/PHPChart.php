<?php namespace koenster\PHPGraphs;

use koenster\PHPGraphs\contract\ChartContract;
use koenster\PHPGraphs\exceptions\GraphImplementationNotFoundException;
use koenster\PHPGraphs\implementation\ChartJSImplementation;
use koenster\PHPGraphs\implementation\MorrisJSImplementation;

class PHPChart {

    const IMPLEMENTATION_CHART_JS = 'ChartJS';
    const IMPLEMENTATION_MORRIS = 'Morris';

    const TYPE_LINE = 'Line';
    const TYPE_BAR = 'Bar';
    const TYPE_RADAR = 'Radar';
    const TYPE_AREA = 'Area';
    const TYPE_PIE = 'Pie';
    const TYPE_DOUGHNUT = 'Doughnut';

    /**
     * @var ChartContract
     */
    protected $factory;

    /**
     * @var array
     */
    protected $graphs = [];

    /**
     * El constructor
     *
     * Will construct the factory
     *
     * @param $implementation
     *
     * @param array $attributes
     *
     * @throws GraphImplementationNotFoundException
     */
    public function __construct($implementation, array $attributes = [])
    {
        switch ($implementation) {
            case "ChartJS" :
                $this->factory = new ChartJSImplementation();
                break;
            case "MorrisJS" :
                $this->factory = new MorrisJSImplementation();
                break;
            default :
                throw new GraphImplementationNotFoundException();
        }

        return $this;
    }

    /**
     * Will get the JS
     *
     * @author Koen Blokland Visser
     *
     * @param $id
     * @param $type
     * @param array $params
     *
     * @return ChartContract
     */
    public function add($type, $id, array $params = [])
    {
        $factory = clone $this->factory;
        $factory->setType($id, $type, $params);
        $this->graphs[$id] = $factory;
        return $factory;
    }

    /**
     * Will get the JS
     *
     * @author Koen Blokland Visser
     *
     * @return ChartContract
     */
    public function getFactory()
    {
        if ($this->factory) {
            return $this->factory;
        }
    }

    /**
     * Will get the Graphs
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    public function getGraphs()
    {
        return $this->graphs;
    }
}