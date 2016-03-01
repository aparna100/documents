<?php /* version 2 / 31.12.2015 / theigi / resize */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title></title>
        <meta name="viewport" id="myViewPort" content = "width=<?php echo $aData['resolution']['width']; ?>" initial-scale="1.0" >
        <meta name="author" content="PocketTrips"/>
        <meta name="copyright" content="LDR Technology Pte Ltd"/>
        <!-- css -->
        <?php
        foreach ($aData['widgets'] as $k => $v) {
            switch ($v['type']) {
                case 'Slider': {
        ?><link rel="stylesheet" type="text/css" media="screen" href="../../../css/idangerous.swiper.css" />
        <?php
                    }break;
                case 'Quiznew': {
        ?><link rel="stylesheet" type="text/css" media="screen" href="../../../css/messi.css" />
        <?php
                    }break;                    
            }
        }
        ?>
           
        <link rel="stylesheet" type="text/css" media="screen" href="../../../css/required.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="../../../css/jquery.mobile-1.3.0.min.css" />  

        <script type="text/javascript" src="../../../js/jquery-1.8.2.min.js"></script>  
        <script type="text/javascript" src="../../../js/resizing.js"></script> 
        <script type="text/javascript" src="../../../js/scripts.js"></script>
        <?php
        foreach ($aData['widgets'] as $k => $v) {
            switch ($v['type']) {
                case 'Quiz': {
                        ?><script type="text/javascript" src="../../../js/quiz.js"></script>
        <?php
                    }break;
                case 'Quiznew': {
                        ?><script type="text/javascript" src="../../../js/messi.js"></script>
        <?php
                    }break;                    
                case 'Slider': {
                        ?><script type="text/javascript" src="../../../js/idangerous.swiper-1.8.min.js"></script>
        <?php
                    }break;
            }
        }
        ?>
        <script type="text/javascript" src="../../../js/jquery.mobile-1.3.0.min.js"></script>
        <script type="text/javascript">
        <?php
            foreach ($aData['widgets'] as $k => $v) {
            switch ($v['type']) {
                case 'Quiz': {
                ?>$(document).bind('pageinit', function () {
            var x = screen.width;
            var y = <?php echo $aData['resolution']['height']; ?>;

            if (!PScripts.inIframe()) {
                if (navigator.userAgent.toLowerCase().indexOf('chrome') > -1) {
                    str = "width=<?php echo $aData['resolution']['width']; ?>";
                    $("#myViewPort").attr("content", str);
                }
                var s = document.createElement('style');
                s.appendChild(document.createTextNode('@-ms-viewport{width:' + y + 'px' + ';}'));
                document.head.appendChild(s);
            }

            PScripts.initQuiz();
        });       
        <?php
                    }break;
                case 'Quiznew': {
                ?>
        
        <?php
                    }break;  
                case 'Slider': {
                ?>window.onload = function() {
                    PScripts.initSlider(); }      
        <?php
                    }break;                    

            }
        }
        ?>

        // Resize Widget & responsive font
        $(document).ready(function () {
            var pageWidth = <?php echo $aData['resolution']['width']; ?>;
            var pageHeight = <?php echo $aData['resolution']['height']; ?>;
            PageResize.resizeFeature(pageWidth, pageHeight);
            //quiz advanced
        <?php
        foreach ($aData['widgets'] as $k => $v) {
            switch ($v['type']) {
                
                case 'Quiznew': {
                        ?>

    var userAgent = navigator.userAgent || navigator.vendor || window.opera;
    if (userAgent.match(/iPad/i) || userAgent.match(/iPhone/i) || userAgent.match(/iPod/i)) {
        var JsBridge = JsBridge || {};
        var iframeSrc = "<?php echo $v['quiznewlink']; ?>"; 
        var params = iframeSrc.split('?');
        var hyperLink =  "<?php echo $v['href']; ?>";
        var sliceLink = hyperLink.slice(0,-5);

        function initJsBridge(callback) {
            if (window.WebViewJavascriptBridge) {
                callback(WebViewJavascriptBridge);
            } else {
                document.addEventListener('WebViewJavascriptBridgeReady', function() {
                    callback(WebViewJavascriptBridge);
                }, false);
            }
        }
        initJsBridge(function(bridge) {
            bridge.init(function(message, responseCallback) {
                responseCallback({
                    data: "init"
                });
            });
            bridge.registerHandler('testJavascriptHandler', function(data, responseCallback) {
                responseCallback({
                    'init': 'registerHandler'
                });
            });
            bridge.send('getDeviceId', function(responseData) {
                try {
                    var data = $.parseJSON(responseData);
                    JsBridge.data = {
                        deviceId: data.deviceId,
                        bookingId: data.bknid,
                        nid: data.nid,
                        hsid: data.hsid
                    };
                   
                    bridge.send('setNextPage:' + sliceLink, function(responseData) {});
                    window.location.href = params[0] +"/"+ data.deviceId + "?bkid=" + data.bknid + "&hsid=" + data.hsid + "&nid=" + data.nid;
                } catch (err) {
                    alert(err.message);
                }
            });
        });
        JsBridge.bridge = bridge;
    } else if (userAgent.match(/Android/i)) {
        var iframeSrc = "<?php echo $v['quiznewlink']; ?>";
        var params = iframeSrc.split('?');
        var deviceId = "";
        try {
            deviceId = NativeApi.getDeviceId();
        } catch (e) {
            deviceId = 'ANDROID_ID';
        }
        var iframePath = '<iframe  class="preview-iframe" style="width:99%; height:100%" src="' + params[0] + '/' + deviceId + '?' + params[1] + '"></iframe>';
        console.log(iframePath);
        $('#iframe0').html(iframePath);
    } else {
        
        var iframeSrc = "<?php echo $v['quiznewlink']; ?>";
        var params = iframeSrc.split('?');
        var deviceId = "";
        try {
            deviceId = NativeApi.getDeviceId();
        } catch (e) {
            deviceId = 'WEB_ID';
        }
        var iframePath = '<iframe  class="preview-iframe" style="width:99%; height:100%" src="' + params[0] + '/' + deviceId + '?' + params[1] + '"></iframe>';
        console.log(iframePath);
        $('#iframe0').html(iframePath);
    }


        <?php
                    }break;



            }
        }

        ?>
        });
        </script>         
    </head>
    <body>
        <!-- Home -->
        <?php static $Version = "3.0"; ?>
        <div  class="page-wrapper" id="page<?php echo $aData['index']; ?>" style="width: <?php echo $aData['resolution']['width']; ?>px; max-height:<?php echo $aData['resolution']['height']; ?>px; height:<?php echo $aData['resolution']['height']; ?>px;">
             <div id="stage-content" data-role="content" class="width<?php echo $aData['resolution']['width']; ?>" style="width: <?php echo $aData['resolution']['width']; ?>px; max-height:<?php echo $aData['resolution']['height']; ?>px; height:<?php echo $aData['resolution']['height']; ?>px;   overflow: hidden; position: relative;float:none;">
                <?php
                $aVideoFiles = array();
                $aSliders = array();
                $aQuizes = array();
                $aIframes = array();
                $aQuiznew = array();
                $aAudioFiles = array();
                $pageWidth = $aData['resolution']['width'];
                $pageHeight = $aData['resolution']['height'];

                foreach ($aData['widgets'] as $k => $v) {
                    ?>
                    <div id="vidget<?php echo $k; ?>" class="widget-wrapper-alt <?php echo strtolower($v['name']) ?>-wrap widget-<?php echo strtolower($v['type']); ?>-instance <?php echo strtolower($v['type']); ?> <?php echo $v['shadow']; ?>" style="
                         border: <?php
                         if (strtolower($v['type']) == 'button') {
                             echo '1px';
                         } else {
                             echo '0 none';
                         }
                         ?>;
                        width: <?php echo $v['size']['width']; ?>px;
                        height:<?php echo $v['size']['height']; ?>px;                        
                         position:absolute;
                        top:<?php echo $v['position']['top']; ?>px;
                        left:<?php echo $v['position']['left']; ?>px;                                                                        
                         <?php if (strtolower($v['type']) == 'button') {
                             if ($v['background'] == 'None') {
                                 ?>background-color: 'transparent'; background-image: 'none'; <?php } elseif ($v['background'] == 'Color') { ?>background-color: <?php echo $v['bgColor']; ?>; background-image: 'none'; <?php } elseif ($v['background'] == 'Linear-Gradient') { ?>background-color: 'transparent'; background-image: <?php echo $v['bgGradient']; ?>; <?php } else { ?>background-color: 'transparent'; background-image: url(<?php echo '../../../resource/' . basename($v['bgImage']); ?>); <?php }
             } else {
                             ?>background: <?php echo $v['bgColor']; ?>; <?php } ?>                                                                        
                         <?php if (strtolower($v['type']) == 'button') {
                             if ($v['stretch'] == 'stretch_to_fit') {
                                 ?>background-size: 100% 100%; <?php } elseif ($v['stretch'] == 'clipping') { ?><?php } else { ?>background-size: 100%; background-repeat: no-repeat;<?php }
             }
                         ?>                                                                        
                         z-index:<?php echo $v['weight']; ?>;
                        <?php if ($v['opacity']) { ?>opacity:<?php echo ($v['opacity'] / 100) . ';';
                }
                        ?>
                        <?php if ($v['rotateAngle']) { ?>-webkit-transform: rotate(<?php echo $v['rotateAngle']; ?>deg);-moz-transform: rotate(<?php echo $v['rotateAngle']; ?>deg);transform: rotate(<?php echo $v['rotateAngle']; ?>deg);<?php } ?>">
                        <?php
                        switch ($v['type']) {
                            case 'Button': {
                                    ?><a href="<?php echo $v['href'] ? 'javascript:location.href=\'' . $v['href'] . '\';' : 'javascript:void(0);'; ?>"><?php echo $v['body']; ?></a><?php
                                }break;
                            case 'Text': {
                                    echo $v['body'];
                                    ?><a class="scrollToTop" href="#" title="Click to go to top" style="display: none; position: fixed; right: 11%; bottom: 35px; color: #000; color: #fcb034; font-size: 11px; font-weight: 700; width: 80px; text-transform: uppercase;">Back to top</a>
                                    <?php
                                }break;

                            case 'Video': {
                                    if ($preview) {
                                        echo '<div class="videovidget"></div>';
                                    } else {
                                        if ($v['videolink']) {
                                            echo preg_replace("/width=\"\d+\"/", "width=\"" . $v['size']['width'] . "\"", preg_replace("/height=\"\d+\"/", "height=\"" . $v['size']['height'] . "\"", $v['videolink']));
                                        } else if ($v['videoPath']) {
                                            // echo '<div id="video' . count($aVideoFiles) . '"></div>';
                                            $arr = explode('/', $v['videoPath']);
                                            $videourl = end($arr);
                                            $videourl = '../../../resource/' . $videourl;

                                            $aVideoFiles[] = array(
                                                'file' => $videourl,
                                                'width' => '100%',
                                                'height' => '100%');

                                            echo '<video poster="../../../resource/bg_html5_video.png" id="video" width="100%" height="100%" controls>
                                                        <source src="' . $videourl . '" type="video/mp4">
                                                    </video>';

                                        }
                                    }
                                }break;

                            case 'Iframe': {
                                    if ($v['iframelink']) {
                                        echo preg_replace("/width=\"\d+\"/", "width=\"" . '100%' . "\"", preg_replace("/height=\"\d+\"/", "height=\"" . '100%' . "\"", $v['iframelink']));
                                    }

                                    global $base_url;
                                    if ($v['iframePath']) {
                                        $iframeurl = $base_url . $v['iframePath'];
                                        echo '<iframe  onload="PScripts.checkConnection()" class="preview-iframe" src="' . $iframeurl . '"></iframe>';
                                        $aIframes[] = array(
                                            'file' => $iframeurl,
                                            'width' => $v['size']['width'],
                                            'height' => $v['size']['height']);
                                    }
                                } break;

                            case 'Audio': {

                                    if ($preview) {
                                        echo '<div class="audiovidget"></div>';
                                    }

                                    if ($v['audioPath']) {

                                        $arr = explode('/', $v['audioPath']);
                                        $audiourl = end($arr);
                                        $audiourl = '../../../resource/' . $audiourl;

                                        $aAudioFiles[] = array(
                                            'file' => $audiourl,
                                            'width' => '100%',
                                            'height' => '100%');
                                        
                                        echo '<div id="audio' . count($aAudioFiles) . '">
                                        <audio controls>
                                        <source src="' . $audiourl . '" type="audio/mpeg">
                                        </audio>
                                    </div>';
                                    }
                                }break;

                            case 'Quiznew': {

                                    if ($v['quiznewlink']) {

                                        $arr = $v['quiznewlink'];
                                        $hrefPath = $v['href'];
                                        echo '<a id="advance-quiz-close-btn" href = "javascript:quizAdvLink(\''.$hrefPath.'\');">close</a><div id="iframe' . count($aQuiznew) . '" style="height:100%;"></div>';
                                        
                                        $aQuiznew[] = array(
                                            'file' => $arr,
                                            'width' => '100%',
                                            'height' => '100%');                                        
                                    }
                                } break;

                            case 'Image': {
                                    $v['imageHref'] = str_replace('(', '\(', $v['imageHref']);
                                    $v['imageHref'] = str_replace(')', '\)', $v['imageHref']);
                                    $v['imageHref'] = str_replace(' ', '%20', $v['imageHref']);
                                    $arr = explode('/', $v['imageHref']);
                                    $imageurl = end($arr);

                                    $sSize = '';
                                    switch ($v['stretch']) {
                                        case 'no_stretching': {
                                                $sSize = $v['size']['width'] . 'px';
                                            }break;
                                        case 'clipping': {
                                                $sSize = 'auto';
                                            }break;
                                        case 'stretch_to_fit': {
                                                $sSize = $v['size']['width'] . 'px ' . $v['size']['height'] . 'px';
                                            }break;
                                    }
                                    
                                    $__data = $__omidPath . $imageurl; //__getBase64Image($__omidPath . $imageurl, $v['cropCoords']);
                                    ?>

                                    <a href="<?php echo $v['href'] ? 'javascript:location.href=\'' . $v['href'] . '\';' : 'javascript:void(0);'; ?>"><div class="imagecroods <?php echo strtolower($v['name']); ?>" data-coords="<?php echo json_encode($v['cropCoords']); ?>" style="width: <?php echo $v['size']['width']; ?>px; height: <?php echo $v['size']['height']; ?>px; background:url(<?php echo '../../../resource/' . $imageurl; ?>) no-repeat; background-size: contain; background-position: center center; display:block;" /></div></a>
                                <?php
                            }break;

                        case 'Quiz': {
                                $questioncount = 0;
                                foreach ($v['questions'] as $key => $value) {
                                    $value['image']['imageHref'] = str_replace('(', '\(', $value['image']['imageHref']);
                                    $value['image']['imageHref'] = str_replace(')', '\)', $value['image']['imageHref']);
                                    $value['image']['imageHref'] = str_replace(' ', '%20', $value['image']['imageHref']);
                                    $arr = explode('/', $value['image']['imageHref']);
                                    $imageurl = end($arr);
                                    $v['questions'][$key]['image']['imageHref'] = '../../../resource/' . $imageurl;
                                    $v['questions'][$key]['image']['base64Url'] = '../../../resource/' . $imageurl;

                                    $questioncount++;

                                    foreach ($v["questions"][$key]["images"] as $key1 => $value2) {
                                        $v["questions"][$key]["images"][$key1]["base64Url"] = $v["questions"][$key]["images"][$key1]["imageHref"];
                                    }
                                }
                                $aQuizes[] = array(
                                    'selector' => '#quiz' . $k,
                                    'questions' => $v['questions'],
                                    'timeout' => $v['timeout']
                                );
                                ?>
                                <div id="quiz<?php echo $k; ?>" class="quizview" style="overflow: hidden; width: 100%; height: 100%;"></div>
                <?php
            }break;
        case 'Slider': {
                $aSliders[] = $k;
                ?>
                                <div style="overflow: hidden;width: 100%; height: 100%;">
                                    <div class="swiper-container" id="sliderarea<?php echo $k; ?>" style="display: block; width: 100%; height: 100%;">
                                        <div class="swiper-wrapper" style="width: 100%; height: 100%;">

                                            <?php
                                            foreach ($v['images'] as $key => $image) {
                                                $image['imageHref'] = str_replace('(', '\(', $image['imageHref']);
                                                $image['imageHref'] = str_replace(')', '\)', $image['imageHref']);
                                                $image['imageHref'] = str_replace(' ', '%20', $image['imageHref']);
                                                $imgarr = explode('/', $image['imageHref']);
                                                $imageurl = end($imgarr);
                                                $sSize = '';

                                                switch ($image['stretch']) {
                                                    case 'no_stretching': {
                                                            $sSize = $v['size']['width'] . 'px';
                                                        }break;
                                                    case 'clipping': {
                                                            $sSize = 'auto';
                                                        }break;
                                                    case 'stretch_to_fit': {
                                                            $sSize = $v['size']['width'] . 'px ' . $v['size']['height'] . 'px';
                                                        }break;
                                                }

                                                $__data = $__omidPath . $imageurl; //__getBase64Image($__omidPath . $imageurl, $image['cropCoords']);
                                                ?>    <div class="swiper-slide" style="width: 100%; height: 100%;">
                                                    <div class="content-slide<?php echo $key ? ' cs-' . $key : ''; ?>" style="width: 100%; height: 100%;">
                                                        <a href="<?php echo $image['href'] ? 'javascript:location.href=\'' . $image['href'] . '\';' : 'javascript:void(0);' ?>" target="_BLANK"><p class="imagecroods" data-coords="<?php echo json_encode($v['cropCoords']); ?>" style="width: 100%; height: 100%; background-size: cover; background-position: center center; background:url(<?php echo '../../../resource/' . $imageurl; ?>) no-repeat; background-size: <?php echo $sSize; ?>;"></p></a>           
                                                    </div></div>
                    <?php
                }
                ?>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slider-navigation">
                                    <span class="prev" id="sliderprev<?php echo $k; ?>"></span>
                                    <span class="next" id="slidernext<?php echo $k; ?>"></span>
                                </div>
                            <?php
                        }break;
                }
                ?>
                </div>
    <?php
}
?>
        </div> 
    </div>
    <span id="version"><?php echo $Version; ?></span>
    <?php if ($aData['widgets'] ){ ?>
        <script type="text/javascript">
            <?php if (isset($questioncount)) { 
                ?>var questioncount =<?php echo $questioncount; ?>;
            <?php 
                } 
            foreach ($aData['widgets'] as $k => $v) {
                switch ($v['type']) {
                    case 'Video': {
                        ?>var videofiles = [];
            videofiles = <?php echo json_encode($aVideoFiles); ?>;
                        <?php
                    }break;
                    case 'Slider': {
                        ?>var sliders = [];
            var swipers = [];
            sliders = <?php echo json_encode($aSliders); ?>;
                        <?php
                    }break;
                    case 'Quiz': {
                        ?>var quizes = [];
            quizes = <?php echo json_encode($aQuizes); ?>;
            $(window).bind("anwserclick", function () {
                $("input[type='radio']").data("mini", "true");
                $("input[type='radio']").checkboxradio();
            });                        
                        <?php
                    }break;
                }
            }
            ?>  
        </script>            
    <?php } ?>
</body>
</html>