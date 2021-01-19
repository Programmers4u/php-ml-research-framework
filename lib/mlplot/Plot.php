<?php

namespace P4u\ML\Graphics\Plot;

include __DIR__ . '/phplot.php';

use PHPlot\PHPlot;

class Plot {

    public static $height;        
    public static $width;
    public static $title;

    public static function stackedArea(array $data, $fileName) {

        $data = $data ?? array(
            array('1960', 30, 10,  6, 38, 14,  2),
            array('1970', 20, 17,  9, 32,  2, 20),
            array('1980', 20, 14, 12, 27,  2, 25),
            array('1990',  5, 26, 15, 26, 18, 10),
            array('2000', 28,  0, 18, 16, 33,  5),
          );
          
          $plot = new PHPlot (self::$width, self::$height);
          $plot->SetImageBorderType('plain');          
          $plot->SetPlotType('stackedarea');
          $plot->SetDataType('text-data');
          $plot->SetDataValues($data);
          
          # Main plot title:
          $plot->SetTitle('Title');
          
          # Set Y data limits, tick increment, and titles:
          $plot->SetPlotAreaWorld(NULL, 0, NULL, 2);
          $plot->SetYTickIncrement(10);
        //   $plot->SetYTitle('% of Total');
        //   $plot->SetXTitle('Year');
          
          # Colors are significant to this data:
          $plot->SetDataColors(array('red', 'green', 'blue', 'yellow', 'cyan', 'magenta'));
          $plot->SetLegend(array('Cherry', 'Lime', 'Lemon', 'Banana', 'Apple', 'Berry'));
          # Make legend lines go bottom to top, like the area segments (PHPlot > 5.4.0)
        //   $plot->SetLegendReverse(True);
          
          # Turn off X tick labels and ticks because they don't apply here:
          $plot->SetXTickLabelPos('none');
          $plot->SetXTickPos('none');

          $plot->SetIsInline(true);
          $plot->SetOutputFile($fileName);               
          $plot->DrawGraph();        
    }

    public static function Line(array $data, $fileName) {

        $plot = new PHPlot (self::$width, self::$height);
        $plot->SetImageBorderType('plain');
        $plot->SetPlotType('lines');
        $plot->SetDataType('text-data');

        $plot->SetDataValues($data);

        # Main plot title:
        $plot->SetTitle(self::$title);

        # Set Y data limits, tick increment, and titles:
        $plot->SetPlotAreaWorld(NULL, 0, NULL, 1);
        // $plot->SetYTickIncrement(10);
        // $plot->SetYTitle('% of Total');
        // $plot->SetXTitle('Year');
    
        # Colors are significant to this data:
        // $plot->SetDataColors(array('red', 'green', 'blue', 'yellow', 'cyan', 'magenta'));
        // $plot->SetLegend(array('Cherry', 'Lime', 'Lemon', 'Banana', 'Apple', 'Berry'));
    
        # Turn off X tick labels and ticks because they don't apply here:
        $plot->SetXTickLabelPos('none');
        $plot->SetXTickPos('none');
    
        $plot->SetIsInline(true);
        $plot->SetOutputFile($fileName);   
        $plot->DrawGraph(); 
   }

   public static function Bar(array $data, $fileName) {

    $plot = new PHPlot (self::$width, self::$height);
    $plot->SetImageBorderType('plain');
    $plot->SetPlotType('bars');
    $plot->SetDataType('text-data');

    $plot->SetDataValues($data);
    
    # Main plot title:
    $plot->SetTitle(self::$title);

    # Set Y data limits, tick increment, and titles:
    $plot->SetPlotAreaWorld(NULL, NULL, NULL, NULL);
    // $plot->SetYTickIncrement(10);
    // $plot->SetYTitle('% of Total');
    // $plot->SetXTitle('Year');

    # Colors are significant to this data:
    // $plot->SetDataColors(array('red', 'green', 'blue', 'yellow', 'cyan', 'magenta'));
    // $plot->SetLegend(array('Cherry', 'Lime', 'Lemon', 'Banana', 'Apple', 'Berry'));

    # Turn off X tick labels and ticks because they don't apply here:
    $plot->SetXTickLabelPos('none');
    $plot->SetXTickPos('none');

    $plot->SetIsInline(true);
    $plot->SetOutputFile($fileName);   
    $plot->DrawGraph(); 
  }   
}