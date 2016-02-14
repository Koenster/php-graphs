<?php namespace koenster\PHPGraphs\implementation;

use koenster\PHPGraphs\contract\ChartContract;
use koenster\PHPGraphs\exceptions\ChartTypeNotFoundException;
use koenster\PHPGraphs\PHPChart;

class MorrisJSImplementation extends AbstractImplementation implements ChartContract
{

    /**
     * El constructor
     *
     * @author Koen Blokland Visser
     */
    public function __construct()
    {
        $this->setJs(['//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js', '//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js', '//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js']);
        $this->setCss(['//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css']);
        $this->setJsPartial('var GraphPHPMorrisJS=new Array;window.onload=function(){var r=document.querySelectorAll("[data-chart]");for(var a in r)if("length"!==a&&"item"!==a){var t=r[a],e=t.id,o=t.dataset,i=JSON.parse(o.chartData),n=o.chartType;GraphPHPMorrisJS[e]=new Morris[n](i)}};');
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
                $canvas = '<div id="' . $this->id . '" data-chart="MorrisJS" id="' . $this->id . '" data-chart-type="Line" data-chart-data=\'' . str_replace("'", "", json_encode($this->generateLine())) . '\' ' . $this->generateDimensions() . '></div>';
                break;
            case PHPChart::TYPE_AREA:
                $canvas = '<div id="' . $this->id . '" data-chart="MorrisJS" id="' . $this->id . '" data-chart-type="Area" data-chart-data=\'' . str_replace("'", "", json_encode($this->generateLine())) . '\' ' . $this->generateDimensions() . '></div>';
                break;
            case PHPChart::TYPE_BAR:
                $canvas = '<div id="' . $this->id . '" data-chart="MorrisJS" id="' . $this->id . '" data-chart-type="Bar" data-chart-data=\'' . str_replace("'", "", json_encode($this->generateLine())) . '\' ' . $this->generateDimensions() . '></div>';
                break;
            case PHPChart::TYPE_PIE:
                $canvas = '<div id="' . $this->id . '" data-chart="MorrisJS" id="' . $this->id . '" data-chart-type="Donut" data-chart-data=\'' . str_replace("'", "", json_encode($this->generatePie())) . '\' ' . $this->generateDimensions() . '></div>';
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

            $data['element'] = $this->id;
            $data['xkey'] = 'x-axis';

            if ($this->type === PHPChart::TYPE_AREA) {
                $data['fillOpacity'] = '0.3';
                $data['behaveLikeLine'] = true;
            }

            foreach ($this->lines as $count => $line) {
                $data['data'][$count]['x-axis'] = $this->dimensions[$count];
            }

            foreach ($this->lines as $count => $line) {
                $this->prepareLine($line, $count);
                foreach ($line as $key => $attribute) {
                    switch ($key) {
                        case self::ATTRIBUTE_LINE:
                            if (is_array($attribute) === true) {
                                foreach ($attribute as $lineKey => $lineValue) {
                                    if (isset($data['data'][$lineKey]['x-axis']) === false) {
                                        $data['data'][$lineKey]['x-axis'] = $this->dimensions[$lineKey];
                                    }
                                    $data['data'][$lineKey][chr(64 + $count+1)] = $lineValue;
                                }
                            }

                            $data['ykeys'][] = chr(64 + $count+1);

                            break;
                        case self::ATTRIBUTE_LABEL:
                            $data['labels'][] = $attribute;
                            break;
                        case self::ATTRIBUTE_COLOR_FILL:
                            if ($this->type === PHPChart::TYPE_LINE) {
                                $data['lineColors'][] = $attribute;
                            } elseif ($this->type === PHPChart::TYPE_AREA) {
                                $data['lineColors'][] = $attribute;
                            } elseif ($this->type === PHPChart::TYPE_BAR) {
                                $data['barColors'][] = $attribute;
                            }
                            break;
                        case self::ATTRIBUTE_COLOR_FILL_STROKE:
                            if ($this->type === PHPChart::TYPE_LINE) {
                                $data['pointFillColors'][] = $attribute;
                            }
                            break;
                    }
                }
            }


            $data['parseTime'] = false;
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
            $array[self::ATTRIBUTE_COLOR_FILL] = $this->defaults['colors'][$count]['primary'];
        }

        if (isset($array[self::ATTRIBUTE_COLOR_FILL_STROKE]) === false) {
            $array[self::ATTRIBUTE_COLOR_FILL_STROKE] = $this->defaults['colors'][$count]['secondary'];
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
        $data['element'] = $this->id;
        if (isset($this->lines) && empty($this->lines) === false) {

            foreach ($this->lines as $count => $line) {
                $this->preparePie($line, $count);
                foreach ($line as $key => $attribute) {
                    switch ($key) {
                        case self::ATTRIBUTE_LABEL:
                            $data['data'][$count]['label'] = $attribute;
                            break;
                        case self::ATTRIBUTE_LINE:
                            if (is_array($attribute) === true) {
                                $data['data'][$count]['value'] = reset($attribute);
                            }
                            break;
                        case self::ATTRIBUTE_COLOR_FILL:
                            $data['colors'][] = $attribute;
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
    }
}