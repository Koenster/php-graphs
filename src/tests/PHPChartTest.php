<?php namespace koenster\PHPGraphs\tests;

use koenster\PHPGraphs\exceptions\GraphImplementationNotFoundException;
use koenster\PHPGraphs\implementation\ChartJSImplementation;
use koenster\PHPGraphs\PHPChart;

class PHPChartTest extends \PHPUnit_Framework_TestCase {

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
     * Test the creation of a Chart
     *
     * @author Koen Blokland Visser
     */
    public function testAddNewGraph()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_AREA, 'area', []);
        $this->assertInstanceOf(ChartJSImplementation::class, $factory);

        $factory = $chart->add(PHPChart::TYPE_LINE, 'line', []);
        $this->assertInstanceOf(ChartJSImplementation::class, $factory);

        $factory = $chart->add(PHPChart::TYPE_PIE, 'pie', []);
        $this->assertInstanceOf(ChartJSImplementation::class, $factory);

        $factory = $chart->add(PHPChart::TYPE_DOUGHNUT, 'doughnut', []);
        $this->assertInstanceOf(ChartJSImplementation::class, $factory);

        $factory = $chart->add(PHPChart::TYPE_RADAR, 'radar', []);
        $this->assertInstanceOf(ChartJSImplementation::class, $factory);
    }

    /**
     * Test the creation of a Chart
     *
     * @author Koen Blokland Visser
     */
    public function testFactory()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_AREA, 'area', []);
        $this->assertInstanceOf(ChartJSImplementation::class, $factory);
        $this->assertArrayHasKey('area', $chart->getGraphs());
    }

    /**
     * Test the creation of a Chart
     *
     * @author Koen Blokland Visser
     */
    public function testInvalidImplementation()
    {
        try {
            new PHPChart('Invalid', []);
            $this->assertTrue(false);
        } catch (GraphImplementationNotFoundException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

    /**
     * Test the existence of JS / CSS
     *
     * @author Koen Blokland Visser
     */
    public function testJsAndCss()
    {
        $this->assertTrue(is_array($this->PHPChart->getFactory()->getJs()));
        $this->assertTrue(is_array($this->PHPChart->getFactory()->getCss()));
    }

    /**
     * Test defaults
     *
     * @author Koen Blokland Visser
     */
    public function testDefaults()
    {
        $chart = clone $this->PHPChart;
        $factory = $chart->add(PHPChart::TYPE_AREA, 'area', ['width' => '100%', 'height' => 200, 'colors' => [['primary' => '#000']]]);

        $this->assertSame('100%', $factory->getDefaults()['width']);
        $this->assertSame(200, $factory->getDefaults()['height']);
        $this->assertSame('#000', $factory->getDefaults()['colors'][0]['primary']);
    }

    /**
     * Test width and height generation
     *
     * @author Koen Blokland Visser
     */
    public function testWidthAndHeight()
    {
        $chart = clone $this->PHPChart;

        $factory = $chart->add(PHPChart::TYPE_AREA, 'area', []);
        $this->assertSame('style="width: 300px;height: 300px;"', $factory->generateDimensions());

        $factory = $chart->add(PHPChart::TYPE_AREA, 'area', ['width' => '100%', 'height' => '50%']);
        $this->assertSame('style="width: 100%;height: 50%;"', $factory->generateDimensions());

        $factory = $chart->add(PHPChart::TYPE_AREA, 'area', ['width' => 100, 'height' => 50]);
        $this->assertSame('style="width: 100px;height: 50px;"', $factory->generateDimensions());

    }
}