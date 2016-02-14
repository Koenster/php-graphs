<?php namespace koenster\PHPGraphs\tests;

use koenster\PHPGraphs\implementation\ChartJSImplementation;
use koenster\PHPGraphs\PHPChart;

class PHPChartJSTest extends \PHPUnit_Framework_TestCase {

    /** @var PHPChart */
    protected $PHPChart;

    /** @var \Mockery */
    protected $mockery;

    /**
     * Start
     *
     * @author Koen Blokland Visser
     */
    public function setUp()
    {
        $this->PHPChart = new PHPChart(PHPChart::IMPLEMENTATION_CHART_JS, []);
        $this->mockery = new \Mockery();
        parent::setUp();
    }

    /**
     * Destroy
     *
     * @author Koen Blokland Visser
     */
    public function tearDown()
    {
        $this->mockery->close();
        parent::tearDown();
    }

    /**
     * Test the creation of an area chart
     *
     * @author Koen Blokland Visser
     */
    public function testGenerateArea()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_AREA, 'area', []);

        $factory->setLine([100,75,50,75,50,75,100], ['label' => 'Costs'])
            ->setLine([90,65,40,65,40,65,150], ['label' => 'Revenue'])
            ->setDimensions(['2006', '2007', '2008', '2009', '2010', '2011', '2012']);

        /** @var ChartJSImplementation $chart */
        $chart = $factory->generate();

        $this->assertInstanceOf(ChartJSImplementation::class, $factory);
        $this->assertSame(
            '<canvas data-chart="ChartJS" id="area" data-chart-type="Line" data-chart-data=\'{"datasets":[{"data":[100,75,50,75,50,75,100],"label":"Costs","fillColor":"rgba(78,155,208,0.2)","strokeColor":"rgba(78,155,208,1)","pointColor":"rgba(78,155,208,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(78,155,208,1)"},{"data":[90,65,40,65,40,65,150],"label":"Revenue","fillColor":"rgba(90,187,64,0.2)","strokeColor":"rgba(90,187,64,1)","pointColor":"rgba(90,187,64,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(90,187,64,1)"}],"labels":["2006","2007","2008","2009","2010","2011","2012"]}\' style="width: 300px;height: 300px;"></canvas>',
            $chart
        );
    }

    /**
     * Test the creation of an line chart
     *
     * @author Koen Blokland Visser
     */
    public function testGenerateLine()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_LINE, 'line', []);

        $factory->setLine([100,75,50,75,50,75,100], ['label' => 'Costs'])
            ->setLine([90,65,40,65,40,65,150], ['label' => 'Revenue'])
            ->setDimensions(['2006', '2007', '2008', '2009', '2010', '2011', '2012']);

        /** @var ChartJSImplementation $chart */
        $chart = $factory->generate();

        $this->assertInstanceOf(ChartJSImplementation::class, $factory);
        $this->assertSame(
            '<canvas data-chart="ChartJS" id="line" data-chart-type="Line" data-chart-data=\'{"datasets":[{"data":[100,75,50,75,50,75,100],"label":"Costs","fillColor":"rgba(0,0,0, 0.0)","strokeColor":"rgba(78,155,208,1)","pointColor":"rgba(78,155,208,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(78,155,208,1)"},{"data":[90,65,40,65,40,65,150],"label":"Revenue","fillColor":"rgba(0,0,0, 0.0)","strokeColor":"rgba(90,187,64,1)","pointColor":"rgba(90,187,64,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(90,187,64,1)"}],"labels":["2006","2007","2008","2009","2010","2011","2012"]}\' style="width: 300px;height: 300px;"></canvas>',
            $chart
        );
    }

    /**
     * Test the creation of an bar chart
     *
     * @author Koen Blokland Visser
     */
    public function testGenerateBar()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_BAR, 'bar', []);

        $factory->setLine([100,75,50,75,50,75,100], ['label' => 'Costs'])
            ->setLine([90,65,40,65,40,65,150], ['label' => 'Revenue'])
            ->setDimensions(['2006', '2007', '2008', '2009', '2010', '2011', '2012']);

        /** @var ChartJSImplementation $chart */
        $chart = $factory->generate();

        $this->assertInstanceOf(ChartJSImplementation::class, $factory);
        $this->assertSame(
            '<canvas data-chart="ChartJS" id="bar" data-chart-type="Bar" data-chart-data=\'{"datasets":[{"data":[100,75,50,75,50,75,100],"label":"Costs","fillColor":"rgba(78,155,208,0.2)","strokeColor":"rgba(78,155,208,1)","pointColor":"rgba(78,155,208,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(78,155,208,1)"},{"data":[90,65,40,65,40,65,150],"label":"Revenue","fillColor":"rgba(90,187,64,0.2)","strokeColor":"rgba(90,187,64,1)","pointColor":"rgba(90,187,64,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(90,187,64,1)"}],"labels":["2006","2007","2008","2009","2010","2011","2012"]}\' style="width: 300px;height: 300px;"></canvas>',
            $chart
        );
    }

    /**
     * Test the creation of an radar chart
     *
     * @author Koen Blokland Visser
     */
    public function testGenerateRadar()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_RADAR, 'radar', []);

        $factory->setLine([100,75,50,75,50,75,100], ['label' => 'Costs'])
            ->setLine([90,65,40,65,40,65,150], ['label' => 'Revenue'])
            ->setDimensions(['2006', '2007', '2008', '2009', '2010', '2011', '2012']);

        /** @var ChartJSImplementation $chart */
        $chart = $factory->generate();

        $this->assertInstanceOf(ChartJSImplementation::class, $factory);
        $this->assertSame(
            '<canvas data-chart="ChartJS" id="radar" data-chart-type="Radar" data-chart-data=\'{"datasets":[{"data":[100,75,50,75,50,75,100],"label":"Costs","fillColor":"rgba(78,155,208,0.2)","strokeColor":"rgba(78,155,208,1)","pointColor":"rgba(78,155,208,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(78,155,208,1)"},{"data":[90,65,40,65,40,65,150],"label":"Revenue","fillColor":"rgba(90,187,64,0.2)","strokeColor":"rgba(90,187,64,1)","pointColor":"rgba(90,187,64,1)","pointStrokeColor":"#fff","pointHighlightFill":"#fff","pointHighlightStroke":"rgba(90,187,64,1)"}],"labels":["2006","2007","2008","2009","2010","2011","2012"]}\' style="width: 300px;height: 300px;"></canvas>',
            $chart
        );
    }

    /**
     * Test the creation of an line chart
     *
     * @author Koen Blokland Visser
     */
    public function testGenerateDoughnut()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_DOUGHNUT, 'doughnut', []);

        $factory->setLine([50], ['label' => 'Costs'])
            ->setLine([70], ['label' => 'Revenue']);

        /** @var ChartJSImplementation $chart */
        $chart = $factory->generate();

        $this->assertInstanceOf(ChartJSImplementation::class, $factory);
        $this->assertSame(
            '<canvas data-chart="ChartJS" id="doughnut" data-chart-type="Doughnut" data-chart-data=\'[{"value":50,"label":"Costs","color":"rgba(78,155,208,1)","highlight":"rgba(78,155,208,0.2)"},{"value":70,"label":"Revenue","color":"rgba(90,187,64,1)","highlight":"rgba(90,187,64,0.2)"}]\' style="width: 300px;height: 300px;"></canvas>',
            $chart
        );
    }

    /**
     * Test the creation of an line chart
     *
     * @author Koen Blokland Visser
     */
    public function testGeneratePie()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_PIE, 'pie', []);

        $factory->setLine([50], ['label' => 'Costs'])
            ->setLine([70], ['label' => 'Revenue']);

        /** @var ChartJSImplementation $chart */
        $chart = $factory->generate();

        $this->assertInstanceOf(ChartJSImplementation::class, $factory);
        $this->assertSame(
            '<canvas data-chart="ChartJS" id="pie" data-chart-type="Pie" data-chart-data=\'[{"value":50,"label":"Costs","color":"rgba(78,155,208,1)","highlight":"rgba(78,155,208,0.2)"},{"value":70,"label":"Revenue","color":"rgba(90,187,64,1)","highlight":"rgba(90,187,64,0.2)"}]\' style="width: 300px;height: 300px;"></canvas>',
            $chart
        );
    }
}