<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link href="/favicon.ico" type="image/x-icon" rel="icon" />
        <link href="/favicon.ico" type="image/x-icon" rel="shortcut icon" />
        <link rel="stylesheet" type="text/css" href="/ccs/default.css?1281568283" />

        <script type="text/javascript" src="/js/jquery/main.js?1271789235"></script>
        <script type="text/javascript" src="/js/jquery/ui.js?1271789235"></script>
    </head>
    <body>
        <meta charset="UTF-8" />

        <?
            
            $IP=$_SERVER['REMOTE_ADDR'];
            $SSID=htmlentities(SID);
            
            // If IP address exists Get country (and City) via  api.hostip.info

            if (!empty($IP)) {

                $country=file_get_contents('http://api.hostip.info/get_html.php?ip=' . $IP);

                // Reformat the data returned (Keep only country and country abbr.

                list ($_country)=explode("\n", $country);
                $_country=str_replace("Country: ", "", $_country);
            }

            echo $_country ;
        ?>

        <style type="text/css">
            body { padding : 40px;}
            .ui-autocomplete-loading { background: white url('http://jqueryui.com/demos/autocomplete/images/ui-anim_basic_16x16.gif') right center no-repeat; }
        </style>
        <script type="text/javascript">
            $(function() {
                function log(message) {
                    $("<div/>").text(message).prependTo("#log");
                    $("#log").attr("scrollTop", 0);
                }
                //http://sn.gv/cities/query.php
                $("#city").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "http://groofi.gv/services/cities/query.php" , //"http://ws.geonames.org/searchJSON",
                            dataType: "jsonp",
                            data: {
                                maxRows: 12,
                                q: request.term
                            },
                            success: function(data) {
                                response($.map(data, function(item) { //.geonames
                                    return {
                                        label : item.label ,
                                        value : item.label ,
                                        id : item.id
                                    }
                                }))
                            }
                        })
                    },
                    minLength: 2,
                    select: function(event, ui) {
                        log( ui.item ? ( "Selected: " + ui.item.label + " " + ui.item.id) : "Nothing selected, input was " + this.value);
                    },
                    open: function() {
                        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                    },
                    close: function() {
                        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                    }
                });
            });
        </script>
        <style>
            .ui-autocomplete-loading { background:#ffffff url(indicator.gif) no-repeat right; }
            ul { background:#f0f0f0 ; padding : 5px ; }
            ul li { background:#fafafa ; padding : 5px ; margin : 5px 0px ;}
            #city { width: 25em; }
        </style>



        <div class="demo">

            <div class="ui-widget">
                <label for="city">Your city: </label>
                <input id="city" />

            </div>

            <div class="ui-widget" style="margin-top:2em; font-family:Arial">
	Result:
                <div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
            </div>

        </div><!-- End demo -->








    </body>
</html>


