    <!DOCTYPE html> 
    <html>
    <head>
         <meta charset="UTF-8">
    </head>
    <style>
    .clearStyle{
        margin-right:3%;
        border-radius: 5px;
        background-color:white;
        border-bottom: solid #DDDDDD;
        border-right:solid #DDDDDD;
    }
    .submitStyle{
        margin-left:49%;
        border-radius: 5px;
        background-color:white;
        border-bottom: solid #DDDDDD;
        border-right:solid #DDDDDD;
    }
    .inputStyle{
        border-color: #DDDDDD;
        border-top: solid #DDDDDD;
        border-left:solid #DDDDDD;
    }
    .msg {
        border:1px solid #bbb; 
        padding:5px; 
        margin:10px 0px; 
        background:#eee;
        }
        .logo{
            width: 3%;
            height:17px;
        }
    </style>
    <body>  
    <?php
    $response = $symbolValue=$symbol = $symbolError = "";
    if (isset($_POST["clear"])){
        $symbol = "";
    } ?>
    <?php
    if (isset($_POST["submit"])){

      if (empty($_POST["StockName"])) {

       echo "<script> alert('Please enter stock symbol');</script>";

      } else if(isset($_POST["StockName"])){
          
      $symbol = $_POST["StockName"];
      $symbolValue = $_POST["StockName"];
      $APICall = "https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$symbolValue."&outputsize=full&apikey=R3MGTYHWHQ2LXMRS";
          $response = file_get_contents($APICall);}}

      ?>
      <FORM ACTION="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" Name="StockForm" METHOD=POST>
    <table width="400" bgcolor="#F5F5F5" align = "center" style="border-style: solid;border-color: #DDDDDD" >
      <tr >
       <th style="border-bottom: 1px solid;border-color: #DDDDDD" ><b> Stock Search</th>
      </tr>
      <tr> 
    <td> <br>Enter Stock Ticker Symbol:* <INPUT type = "text" Name="StockName" size="20" class ="inputStyle" value="<?php echo $symbol;?>" >

      </tr>
      <tr><td><input type="submit" name="submit" value="Submit" class = "submitStyle"> 
      <input class ="clearStyle" type="submit" name="clear" value="Clear"  > </td></tr>
      <tr><td>*- Mandatory fields.<br><br><br></td></tr>
      </form>
    </table>
    <?php
         if(strcmp($response,"")!=0){
             $json = json_decode($response, true); // decode the JSON into an associative array
             // if(is_object($json)||
            //is_string($json)){//f( is_null($js
             if(array_key_exists('Time Series (Daily)',$json)){
             //echo '<pre>' . print_r($json, true) . '</pre>';
             $array=   array_keys($json['Time Series (Daily)']); //**
           $previousDay = $array[1];  //**  
        $timestamp =  $json['Meta Data']['3. Last Refreshed'];

    //list($y, $m, $d) = explode('-', $timestamp);
        //     $todayTimeDate = $y.'-'.$m.'-'.$d;
           //  list($date, $time) = explode(' ', $todayTimeDate);
       $today = $array[0]; //**
             
        $symbol = $json['Meta Data']['2. Symbol'];
        //$symbol = strtoupper($symbol2);
        $close = $json['Time Series (Daily)'][$today]['4. close'];
        $open = $json['Time Series (Daily)'][$today]['1. open'];
        $previousClose = $json['Time Series (Daily)'][$previousDay]['4. close'];   
        $change = number_format($close - $previousClose,2);
        $changePercent = number_format((100*($close - $previousClose))/$previousClose,2);
        $dayLow = $json['Time Series (Daily)'][$today]['3. low'];
        $dayHigh = $json['Time Series (Daily)'][$today]['2. high'];
        $dayRange = $dayLow . "-".$dayHigh;
        $volume = $json['Time Series (Daily)'][$today]['5. volume'];

        if($change>0){
    $ourFileName = "Green_Arrow_Up.png";}
             else if($change<0){
               $ourFileName = "Red_Arrow_Down.png";  
             }
    

             echo  "<br><table width='90%'  align = 'center' style='border-collapse:collapse' >
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Stock Ticker Symbol</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>". $symbol ."</td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Close</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>".$close." </td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Open</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>".$open." </td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Previous Close</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>".$previousClose."</td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Changee</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>".$change." <img src=".$ourFileName." class = 'logo'>"." </td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Change Percent</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>".$changePercent ."% <img src=".$ourFileName." class = 'logo'>"."</td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Day's Range</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>".$dayRange."</td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Volume</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>".$volume ."</td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Timestamp</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>".$timestamp." </td>
      </tr>
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Indicators </th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center;color:blue'><span onclick='setPriceParameterAndDisplay()' >&nbsp Price</span>  <span onclick='setSMAParameterAndDisplay()' >&nbsp SMA</span>  <span onclick='setEMAParameterAndDisplay()' >&nbsp EMA</span>  <span onclick='setSTOCHParameterAndDisplay()' >&nbsp STOCH</span>  <span onclick='setRSIParameterAndDisplay()' >&nbsp RSI</span>  <span onclick='setADXParameterAndDisplay()' >&nbsp ADX</span>  <span onclick='setCCIParameterAndDisplay()' >&nbsp CCI</span>  <span onclick='setBBANDSParameterAndDisplay()' >&nbsp BBANDS</span>  <span onclick='setMACDParameterAndDisplay()' >&nbsp MACD</span> </td>
      </tr>
      </table> <br> <script src='https://code.highcharts.com/highcharts.js'></script>";
  

         
         
          $jsonPrice = json_encode( $response);
          
          $SMA_APICall = "https://www.alphavantage.co/query?function=SMA&symbol=".$symbolValue."&interval=daily&time_period=10&series_type=close&apikey=R3MGTYHWHQ2LXMRS";
          $SMAresponse = file_get_contents($SMA_APICall);
          $jsonSMA = json_encode( $SMAresponse);
          
          $BBANDS_APICall = "https://www.alphavantage.co/query?function=BBANDS&symbol=".$symbolValue."&interval=daily&time_period=5&series_type=close&nbdevup=3&nbdevdn=3&apikey=1&apikey=R3MGTYHWHQ2LXMRS";
         $BBANDSresponse = file_get_contents($BBANDS_APICall);
          $jsonBBANDS = json_encode( $BBANDSresponse);
          
          $MACD_APICall = "https://www.alphavantage.co/query?function=MACD&symbol=".$symbolValue."&interval=daily&series_type=close&fastperiod=10&apikey=R3MGTYHWHQ2LXMRS";
         $MACDresponse = file_get_contents($MACD_APICall);
          $jsonMACD = json_encode( $MACDresponse);
          
          $STOCH_APICall = "https://www.alphavantage.co/query?function=STOCH&symbol=".$symbolValue."&interval=daily&slowkmatype=1&slowdmatype=1&apikey=R3MGTYHWHQ2LXMRS";
          $STOCHresponse = file_get_contents($STOCH_APICall);
          $jsonSTOCH = json_encode( $STOCHresponse);
          
          $CCI_APICall = "https://www.alphavantage.co/query?function=CCI&symbol=".$symbolValue."&interval=daily&time_period=10&apikey=R3MGTYHWHQ2LXMRS";
          $CCIresponse = file_get_contents($CCI_APICall);
          $jsonCCI = json_encode( $CCIresponse);
          
          $EMA_APICall = "https://www.alphavantage.co/query?function=EMA&symbol=".$symbolValue."&interval=daily&time_period=10&series_type=close&apikey=R3MGTYHWHQ2LXMRS";
          $EMAresponse = file_get_contents($EMA_APICall);
          $jsonEMA = json_encode( $EMAresponse);
          
          $RSI_APICall = "https://www.alphavantage.co/query?function=RSI&symbol=".$symbolValue."&interval=daily&time_period=10&series_type=close&apikey=R3MGTYHWHQ2LXMRS";
          $RSIresponse = file_get_contents($RSI_APICall);
          $jsonRSI = json_encode( $RSIresponse);
          
          $ADX_APICall = "https://www.alphavantage.co/query?function=ADX&symbol=".$symbolValue."&interval=daily&time_period=10&series_type=close&apikey=R3MGTYHWHQ2LXMRS";
          $ADXresponse = file_get_contents($ADX_APICall);
          $jsonADX = json_encode( $ADXresponse);
          
         echo"<script> 
         function json2array(json){
    var result = [];
    var keys = Object.keys(json);
    keys.forEach(function(key){
        result.push(json[key]);
    });
    return result;
}</script>

<script> 
var PriceData = new Array();
var StockVolume = new Array();
var jsonPriceObj1 = ".$response.";
var jsonPriceObj2 = json2array(jsonPriceObj1);
var jsonPriceObj3 = json2array(jsonPriceObj2[1]);
for(i=0;i< jsonPriceObj3.length;i++){
var obj4 = json2array( jsonPriceObj3[i]);
PriceData.push(parseFloat(obj4[3]));
StockVolume.push(parseInt(obj4[4])/1000000);
};
StockVolume = StockVolume.slice(0,126);
PriceData = PriceData.slice(0,126);
var XAxisData = new Array();
var dateArray = Object.keys(jsonPriceObj2[1]);
for( j = 0;j<126;j++){
var res = dateArray[j].split('-');
XAxisData.push(res[1]+'/'+res[2]);
};
var res2 = dateArray[0].split('-');
var StockHeading = 'Stock Price ' + '('+ res2[1]+'/'+ res2[2]+'/'+ res2[0]+')';
XAxisData.reverse();
console.log(XAxisData);
</script>

<script>
var SMAData = new Array();
var jsonSMAObj1 = ".$SMAresponse.";
var jsonSMAObj2 = json2array(jsonSMAObj1);
var jsonSMAObj3 = json2array(jsonSMAObj2[1]);
var lengthSMA = jsonSMAObj3.length;
for(i=0;i<lengthSMA;i++){
SMAData.push(parseFloat(jsonSMAObj3[i].SMA));};
SMAData = SMAData.slice(0,126);
</script>

<script> 
var STOCHK = new Array();
var STOCHD= new Array();
var jsonSTOCHObj1 = ".$STOCHresponse.";
var jsonSTOCHObj2 = json2array(jsonSTOCHObj1);
var jsonSTOCHObj3 = json2array(jsonSTOCHObj2[1]);
for(i=0;i< jsonSTOCHObj3.length;i++){
var obj4 = json2array( jsonSTOCHObj3[i]);
STOCHK.push(parseFloat(obj4[0]));
STOCHD.push(parseFloat(obj4[1]));
};
STOCHK = STOCHK.slice(0,126);
STOCHD = STOCHD.slice(0,126);
</script>

<script> 
var CCIData = new Array();
var jsonCCIObj1 = ".$CCIresponse.";
var jsonCCIObj2 = json2array(jsonCCIObj1);
var jsonCCIObj3 = json2array(jsonCCIObj2[1]);
for(i=0;i< jsonCCIObj3.length;i++){
var obj4 = json2array( jsonCCIObj3[i]);
CCIData.push(parseFloat(obj4[0]));
};
CCIData = CCIData.slice(0,126);
</script>



<script> 
var EMAData = new Array();
var jsonEMAObj1 = ".$EMAresponse.";
var jsonEMAObj2 = json2array(jsonEMAObj1);
var jsonEMAObj3 = json2array(jsonEMAObj2[1]);
var lengthEMA = jsonEMAObj3.length;
for(i=0;i<lengthEMA;i++){
EMAData.push(parseFloat(jsonEMAObj3[i].EMA));};
EMAData = EMAData.slice(0,126);
</script>

<script> 
var MACD = new Array();
var MACDHist= new Array();
var MACDSignal= new Array();
var jsonMACDObj1 = ".$MACDresponse.";
var jsonMACDObj2 = json2array(jsonMACDObj1);
var jsonMACDObj3 = json2array(jsonMACDObj2[1]);
for(i=0;i< jsonMACDObj3.length;i++){
var obj4 = json2array( jsonMACDObj3[i]);
MACD.push(parseFloat(obj4[0]));
MACDHist.push(parseFloat(obj4[1]));
MACDSignal.push(parseFloat(obj4[2]));
};
MACD = MACD.slice(0,126);
MACDHist = MACDHist.slice(0,126);
MACDSignal = MACDSignal.slice(0,126);
</script>

<script> 
var RSIData = new Array();
var jsonRSIObj1 = ".$RSIresponse.";
var jsonRSIObj2 = json2array(jsonRSIObj1);
var jsonRSIObj3 = json2array(jsonRSIObj2[1]);
var lengthRSI = jsonRSIObj3.length;
for(i=0;i<lengthRSI;i++){
RSIData.push(parseFloat(jsonRSIObj3[i].RSI));};
RSIData = RSIData.slice(0,126);
</script>

<script> 
var ADXData = new Array();
var jsonADXObj1 = ".$ADXresponse.";
var jsonADXObj2 = json2array(jsonADXObj1);
var jsonADXObj3 = json2array(jsonADXObj2[1]);
var lengthADX = jsonADXObj3.length;
for(i=0;i<lengthADX;i++){
ADXData.push(parseFloat(jsonADXObj3[i].ADX));};
ADXData = ADXData.slice(0,126);
</script>

<script> 
var BBANDSLower = new Array();
var BBANDSUpper= new Array();
var BBANDSMiddle = new Array();
var jsonBBANDSObj1 = ".$BBANDSresponse.";
var jsonBBANDSObj2 = json2array(jsonBBANDSObj1);
var jsonBBANDSObj3 = json2array(jsonBBANDSObj2[1]);
for(i=0;i< jsonBBANDSObj3.length;i++){
var obj4 = json2array( jsonBBANDSObj3[i]);
BBANDSLower.push(parseFloat(obj4[0]));
BBANDSUpper.push(parseFloat(obj4[1]));
BBANDSMiddle.push(parseFloat(obj4[2]));
};
BBANDSLower = BBANDSLower.slice(0,126);
BBANDSUpper = BBANDSUpper.slice(0,126);
BBANDSMiddle = BBANDSMiddle.slice(0,126);
</script>

<script src='https://code.highcharts.com/highcharts.js'></script>
<script src='https://code.highcharts.com/modules/series-label.js'></script>
<script src='https://code.highcharts.com/modules/exporting.js'></script>

<div id='container' style='border-style: solid;border-color: #DDDDDD;visibility:hidden; width:90%;
	height: 550px;
	margin: 0 auto'></div>
<script>

function setSMAParameterAndDisplay(){
document.getElementById('container').style.visibility='visible';
var titleOfGraph = 'Simple Moving Average (SMA)';
var titleOfYAxis = 'SMA';
var dataForGraph = SMAData;
displayGraph(titleOfGraph,titleOfYAxis,dataForGraph);
};

function setEMAParameterAndDisplay(){
document.getElementById('container').style.visibility='visible';
var titleOfGraph = 'Exponential Moving Average (EMA)';
var titleOfYAxis = 'EMA';
var dataForGraph = EMAData;
displayGraph(titleOfGraph,titleOfYAxis,dataForGraph);
};

function setRSIParameterAndDisplay(){
document.getElementById('container').style.visibility='visible';
var titleOfGraph = 'Relative Strength Index  (RSI)';
var titleOfYAxis = 'RSI';
var dataForGraph = RSIData;
displayGraph(titleOfGraph,titleOfYAxis,dataForGraph);
};

function setADXParameterAndDisplay(){
document.getElementById('container').style.visibility='visible';
var titleOfGraph = 'Average Directional Index  (ADX)';
var titleOfYAxis = 'ADX';
var dataForGraph = ADXData;
displayGraph(titleOfGraph,titleOfYAxis,dataForGraph);
};

function setCCIParameterAndDisplay(){
document.getElementById('container').style.visibility='visible';
var titleOfGraph = 'Commodity Channel Index  (CCI)';
var titleOfYAxis = 'CCI';
var dataForGraph = CCIData;
displayGraph(titleOfGraph,titleOfYAxis,dataForGraph);
}

function setPriceParameterAndDisplay(){
document.getElementById('container').style.visibility='visible';
Highcharts.chart('container', {
    chart: {
        type: 'area'
    },
    title: {
        text: StockHeading ,
    },
    subtitle: {
         text: '<a style=\"color:blue;\" href=\"https://www.alphavantage.co\">Source: Alpha Vantage</a>'
    },
    xAxis: {
        categories: XAxisData,
          minTickInterval: 6,
          
   showLastLabel: true,
          
    },
    yAxis: [{
        title: {
            text: 'Stock Price',
        },
        tickInterval: 5,
        min:null,
       
        
         },{
        title: {
            text: 'Volume '
        },
        labels: {
            format: '{value}m',
        },
        opposite:true,
         tickInterval: 50,
        min:0,
        
    }],
    plotOptions: {
    area:{
    threshold:null,},
    label: {
    enabled: false,
},
        line: {
            
            enableMouseTracking: true
        },
        series: {
        marker: {
                enabled: false
            },}
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    series: [{
        name: '".$symbol."',
        label: {
    enabled: false,
},
        type: 'area',
        color: '#F66464',
        data: PriceData,
        tooltip: {
                valueDecimals: 2
            }
         
    }, {
        name: '".$symbol." Volume' ,
        label: {
    enabled: false,
},
        type: 'column',
        color: '#FFFFFF',
         yAxis: 1,
        data: StockVolume,
        tooltip: {
                valueDecimals: 2
            }
        

    }]
});};

function setMACDParameterAndDisplay(){
document.getElementById('container').style.visibility='visible';
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Moving Average Convergence/Divergence (MACD)  '
    },
    subtitle: {
         text: '<a style=\"color:blue;\" href=\"https://www.alphavantage.co\">Source: Alpha Vantage</a>'
    },
    xAxis: {
       categories: XAxisData,
          minTickInterval: 6,
          
   showLastLabel: true,
    },
    yAxis: [{
    
        title: {
            text: 'MACD'
        },
         }],
    plotOptions: {
        line: {
            
            enableMouseTracking: true
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    series: [{
    marker: {
                enabled: true,
                radius: 3
            },
            name: '".$symbol." MACD',
        
        type: 'line',
        color: '#F66464',
        
        data: MACD,
        label: {
    enabled: false,
},
        tooltip: {
                valueDecimals: 2
            }
         
    }, {
    marker: {
                enabled: true,
                radius: 3
            },
            label: {
    enabled: false,
},
        name: '".$symbol." MACD_Hist',
        type: 'line',
        color: '#FF8C00',
         
        data:MACDHist,
        tooltip: {
                valueDecimals: 2
            }
 
    },{
    marker: {
                enabled: true,
                radius: 2
            },
        name: '".$symbol." MACD_Signal',
        type: 'line',
        color: '#00BFFF',
         
        data:MACDSignal,
        label: {
    enabled: false,
},
        tooltip: {
                valueDecimals: 2
            }
        

    }]
});};

function setSTOCHParameterAndDisplay(){
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Stochastic Oscillator (STOCH)  '
    },
    subtitle: {
         text: '<a style=\"color:blue;\" href=\"https://www.alphavantage.co\">Source: Alpha Vantage</a>'
    },
    xAxis: {
       categories: XAxisData,
          minTickInterval: 6,
          
   showLastLabel: true,
    },
    yAxis: [{
        title: {
            text: 'STOCH'
        },
         }],
    plotOptions: {
        line: {
            
            enableMouseTracking: true
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    series: [{
        name: '".$symbol." SlowK',
        type: 'line',
        color: '#F66464',
        
        data: STOCHK,
        label: {
    enabled: false,
},
        tooltip: {
                valueDecimals: 2
            }
         
    },{
        name: '".$symbol." SlowD',
        type: 'line',
        color: '#00BFFF',
        
        data: STOCHD,
        label: {
    enabled: false,
},
        tooltip: {
                valueDecimals: 2
            }
         
    } ]
});};

function setBBANDSParameterAndDisplay(){
document.getElementById('container').style.visibility='visible';
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Bollinger Bands (BBANDS)  '
    },
    subtitle: {
         text: '<a style=\"color:blue;\" href=\"https://www.alphavantage.co\">Source: Alpha Vantage</a>'
    },
    xAxis: {
       categories: XAxisData,
          minTickInterval: 6,
          
   showLastLabel: true,
    },
    yAxis: [{
        title: {
            text: 'BBANDS'
        },}
         ],
    plotOptions: {
        line: {
            
            enableMouseTracking: true
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },
    series: [{
    marker: {
                enabled: true,
                radius: 3
            },
        name: '".$symbol." Real Middle Band ',
        type: 'line',
        color: '#F66464',
        
        data: BBANDSMiddle,
        label: {
    enabled: false,
},
        tooltip: {
                valueDecimals: 2
            }
         
    }, {
    marker: {
                enabled: true,
                radius: 3
            },
        name: '".$symbol." Real Upper Band',
        type: 'line',
        color: '#000000',
         
        data:BBANDSUpper,
        label: {
    enabled: false,
},
        tooltip: {
                valueDecimals: 2
            }

    },{
    marker: {
                enabled: true,
                radius: 3
            },
        name: '".$symbol." Real Lower Band',
        type: 'line',
        color: '#228B22',
         
        data:BBANDSLower,
        label: {
    enabled: false,
},
        tooltip: {
                valueDecimals: 2
            }

    }]
});};

function displayGraph(titleOfGraph,titleOfYAxis,dataForGraph){
Highcharts.chart('container', {


    title: {
        text: titleOfGraph
    },

    subtitle: {
         text: '<a style=\"color:blue;\" href=\"https://www.alphavantage.co\">Source: Alpha Vantage</a>'
    },
    xAxis: {
        categories: XAxisData,
          minTickInterval: 6,
          
   showLastLabel: true,
          
    },

    yAxis: {
        title: {
            text: titleOfYAxis
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        
    },

    series: [{
         name: '".$symbol."',
        data: dataForGraph,
        label: {
    enabled: false,
},
        color: '#FF0000',
        tooltip: {
                valueDecimals: 2
            }
    }],

    
});}


</script>

";  
echo "<script> setPriceParameterAndDisplay()</script>";
                if(strcmp($symbol,"")!=0){
                  $note = "https://seekingalpha.com/api/sa/combined/".$symbol.".xml";
                  $xml=simplexml_load_file($note) or die("Error: Cannot create object");
                $jsonArray = array();
                for($i =0;$i<5;$i++){
                $newsHeadline = $xml->channel->item[$i]->title->__toString();
                $newsLink = $xml->channel->item[$i]->link->__toString();
                $publishedDate = $xml->channel->item[$i]->pubDate->__toString();
                $temp = array('Title' => $newsHeadline, 'Link' => $newsLink,'Publish'=>$publishedDate);
                array_push($jsonArray,$temp);
                      }
               $jsonNews = json_encode( $jsonArray );
                //echo  $jsonNews;
                echo"<script> 
               var jsonObj = ".$jsonNews.";
               function myFunction(){
var source = document.getElementById('myImage').getAttribute('src');
if(source =='Gray_Arrow_Down.png'){
document.getElementById('myImage').src='Gray_Arrow_Up.png';
document.getElementById('action').innerHTML= 'click to hide stock news';
document.getElementById('NewsTable').style.visibility='visible' ;
 
}
else{
document.getElementById('myImage').src='Gray_Arrow_Down.png'
document.getElementById('action').innerHTML= 'click to show stock news';
document.getElementById('NewsTable').style.visibility='hidden' ;
}
}
               </script>";
                 
           echo" <div style='margin-left:47%'>
<p id ='action'style='text-align:left'>click to show stock news   </p>
<img align='middle'onclick='myFunction()' id='myImage' src='Gray_Arrow_Down.png' style='width:35px;height:25px;margin-left:5%'></img>
</div>". "<br><table id='NewsTable' width='90%'  align = 'center' style='border-collapse:collapse;visibility:hidden' >
  <tr >
   <td bgcolor='#F5F5F5' style='border: 1px solid;border-color: #DDDDDD;text-align:left' class='rows'></td>
  </tr>
  <tr >
   <td bgcolor='#F5F5F5' style='border: 1px solid;border-color: #DDDDDD;text-align:left' class='rows'></td>
  </tr>
  <tr >
   <td bgcolor='#F5F5F5' style='border: 1px solid;border-color: #DDDDDD;text-align:left' class='rows'></td>
  </tr>
  <tr >
   <td bgcolor='#F5F5F5' style='border: 1px solid;border-color: #DDDDDD;text-align:left' class='rows'></td>
  </tr>
  <tr >
   <td bgcolor='#F5F5F5' style='border: 1px solid;border-color: #DDDDDD;text-align:left' class='rows'></td>
  </tr>
  
  </table>
<script>

var myObj = ".$jsonNews."
for(i=0;i<5;i++){

document.getElementsByClassName('rows')[i].innerHTML= '<a  style=\'text-decoration: none;color:blue;\' href=\"'+myObj[i].Link+'\">'+myObj[i].Title+'</a>'+ '&nbsp'+'&nbsp'+'&nbsp'+'&nbsp' + 'Publicated Time'+ myObj[i].Publish.substring(0, 26);}
</script>
<br><br>";
                  };}
         else  if(array_key_exists('Error Message',$json)){
            echo"<br><table width='90%'  align = 'center' style='border-collapse:collapse' >
      <tr >
       <th style='border: 1px solid;border-color: #DDDDDD ;text-align:left ' bgcolor='#F5F5F5'><b> Error</th>
       <td style='border: 1px solid;border-color: #DDDDDD;text-align:center'>Error: No record has been found, please enter a valid symbol</td>
      </tr></table>";
         }};
                  ?>

          
    </body>
    </html>