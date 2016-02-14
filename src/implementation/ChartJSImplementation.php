<?php namespace koenster\PHPGraphs\implementation;

use koenster\PHPGraphs\contract\ChartContract;
use koenster\PHPGraphs\exceptions\ChartTypeNotFoundException;
use koenster\PHPGraphs\PHPChart;

class ChartJSImplementation extends AbstractImplementation implements ChartContract
{

    /**
     * El constructor
     *
     * @author Koen Blokland Visser
     */
    public function __construct()
    {
        $this->setJs(['//cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js']);
        $this->setJsPartial('var GraphPHPChartJS=new Array;window.onload=function(){var a=document.querySelectorAll("canvas");for(var r in a)if("length"!==r&&"item"!==r){var t=a[r],e=t.id,n=t.getContext("2d"),h=t.dataset,o=JSON.parse(h.chartData),c=h.chartType;GraphPHPChartJS[e]=new Chart(n)[c](o)}};');
    }

    /**
     * Generate graph
     *
     * @author Koen Blokland Visser
     *
     * @return string
     *
     * @throws ChartTypeNotFoundException
     */
    public function generate()
    {
        switch ($this->type) {
            case PHPChart::TYPE_LINE:
                $canvas = '<canvas data-chart="ChartJS" id="' . $this->id . '" data-chart-type="Line" data-chart-data=\'' . str_replace("'", "", json_encode($this->generateLine())) . '\' ' . $this->generateDimensions() . '></canvas>';
                break;
            case PHPChart::TYPE_AREA:
                $canvas = '<canvas data-chart="ChartJS" id="' . $this->id . '" data-chart-type="Line" data-chart-data=\'' . str_replace("'", "", json_encode($this->generateLine())) . '\' ' . $this->generateDimensions() . '></canvas>';
                break;
            case PHPChart::TYPE_BAR:
                $canvas = '<canvas data-chart="ChartJS" id="' . $this->id . '" data-chart-type="Bar" data-chart-data=\'' . str_replace("'", "", json_encode($this->generateLine())) . '\' ' . $this->generateDimensions() . '></canvas>';
                break;
            case PHPChart::TYPE_RADAR:
                $canvas = '<canvas data-chart="ChartJS" id="' . $this->id . '" data-chart-type="Radar" data-chart-data=\'' . str_replace("'", "", json_encode($this->generateLine())) . '\' ' . $this->generateDimensions() . '></canvas>';
                break;
            case PHPChart::TYPE_PIE:
                $canvas = '<canvas data-chart="ChartJS" id="' . $this->id . '" data-chart-type="Pie" data-chart-data=\'' . str_replace("'", "", json_encode($this->generatePie())) . '\' ' . $this->generateDimensions() . '></canvas>';
                break;
            case PHPChart::TYPE_DOUGHNUT:
                $canvas = '<canvas data-chart="ChartJS" id="' . $this->id . '" data-chart-type="Doughnut" data-chart-data=\'' . str_replace("'", "", json_encode($this->generatePie())) . '\' ' . $this->generateDimensions() . '></canvas>';
                break;
            default:
                throw new ChartTypeNotFoundException;
                break;
        }

        return $canvas;
    }

    /**
     * Generate data
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    protected function generateLine()
    {
        $data = [];

        if (isset($this->lines) && empty($this->lines) === false) {

            foreach ($this->lines as $count => $line) {

                $this->prepareLine($line, $count);

                foreach ($line as $key => $attribute) {
                    switch ($key) {
                        case self::ATTRIBUTE_LINE:
                            if (is_array($attribute) === true) {
                                $data['datasets'][$count]['data'] = $attribute;
                            }
                            break;
                        case self::ATTRIBUTE_LABEL:
                            $data['datasets'][$count]['label'] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_FILL:
                            $data['datasets'][$count]['fillColor'] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_FILL_STROKE:
                            $data['datasets'][$count]['strokeColor'] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_POINT:
                            $data['datasets'][$count]['pointColor'] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_POINT_STROKE:
                            $data['datasets'][$count]['pointStrokeColor'] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_HIGHLIGHT_FILL:
                            $data['datasets'][$count]['pointHighlightFill'] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_HIGHLIGHT_STROKE:
                            $data['datasets'][$count]['pointHighlightStroke'] = $attribute;
                            break;
                    }
                }
            }
        }

        if (isset($this->dimensions) && empty($this->dimensions) === false) {
            $data['labels'] = $this->dimensions;
        }

        return $data;
    }

    /**
     * Prepare the line
     *
     * @author Koen Blokland Visser
     *
     * @param array $array
     * @param $count
     */
    protected function prepareLine(array &$array, $count)
    {
        $count = ($count % count($this->defaults['colors']));

        if (isset($array[self::ATTRIBUTE_COLOR_FILL]) === false) {
            $array[self::ATTRIBUTE_COLOR_FILL] = $this->defaults['colors'][$count]['secondary'];
        }

        if (isset($array[self::ATTRIBUTE_COLOR_FILL_STROKE]) === false) {
            $array[self::ATTRIBUTE_COLOR_FILL_STROKE] = $this->defaults['colors'][$count]['primary'];
        }

        if (isset($array[self::ATTRIBUTE_COLOR_POINT]) === false) {
            $array[self::ATTRIBUTE_COLOR_POINT] = $this->defaults['colors'][$count]['primary'];
        }

        if (isset($array[self::ATTRIBUTE_COLOR_POINT_STROKE]) === false) {
            $array[self::ATTRIBUTE_COLOR_POINT_STROKE] = $this->defaults['colors'][$count]['color'];
        }

        if (isset($array[self::ATTRIBUTE_COLOR_HIGHLIGHT_FILL]) === false) {
            $array[self::ATTRIBUTE_COLOR_HIGHLIGHT_FILL] = $this->defaults['colors'][$count]['color'];
        }

        if (isset($array[self::ATTRIBUTE_COLOR_HIGHLIGHT_STROKE]) === false) {
            $array[self::ATTRIBUTE_COLOR_HIGHLIGHT_STROKE] = $this->defaults['colors'][$count]['primary'];
        }

        if ($this->type === PHPChart::TYPE_LINE) {
            $array[self::ATTRIBUTE_COLOR_FILL] = 'rgba(0,0,0, 0.0)';
        }
    }

    /**
     * Generate data
     *
     * @author Koen Blokland Visser
     *
     * @return array
     */
    protected function generatePie()
    {
        $data = [];
        if (isset($this->lines) && empty($this->lines) === false) {

            foreach ($this->lines as $count => $line) {

                $this->preparePie($line, $count);

                foreach ($line as $key => $attribute) {
                    switch ($key) {
                        case self::ATTRIBUTE_LINE:
                            if (is_array($attribute) === true) {
                                $data[$count]['value'] = reset($attribute);
                            }
                            break;
                        case self::ATTRIBUTE_LABEL:
                            $data[$count]['label'] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_FILL:
                            $data[$count]['color'] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_FILL_STROKE:
                            $data[$count]['highlight'] = $attribute;
                            break;
                    }
                }
            }
        }

        if (isset($this->dimensions) && empty($this->dimensions) === false) {
            $data['labels'] = $this->dimensions;
        }

        return $data;
    }


    /**
     * Prepare the pie
     *
     * @author Koen Blokland Visser
     *
     * @param array $array
     * @param $count
     */
    protected function preparePie(array &$array, $count)
    {
        $count = ($count % count($this->defaults['colors']));

        if (isset($array[self::ATTRIBUTE_COLOR_FILL]) === false) {
            $array[self::ATTRIBUTE_COLOR_FILL] = $this->defaults['colors'][$count]['primary'];
        }

        if (isset($array[self::ATTRIBUTE_COLOR_FILL_STROKE]) === false) {
            $array[self::ATTRIBUTE_COLOR_FILL_STROKE] = $this->defaults['colors'][$count]['secondary'];
        }
    }
}