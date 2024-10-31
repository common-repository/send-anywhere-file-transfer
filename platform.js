(function () {
    var scriptName = "widget.js"; //name of this script, used to get reference to own tag
    var scriptTag; //reference to the html script tag
 
    /******** Get reference to self (scriptTag) *********/
    var allScripts = document.getElementsByTagName('script');
    var targetScripts = [];
    for (var i in allScripts) {
        var name = allScripts[i].src
        if(name && name.indexOf(scriptName) > 0)
            targetScripts.push(allScripts[i]);
    }
 
    scriptTag = targetScripts[targetScripts.length - 1];
 
    /******** helper function to load external scripts *********/
    function loadScript(src, onLoad) {
        var script_tag = document.createElement('script');
        script_tag.setAttribute("type", "text/javascript");
        script_tag.setAttribute("src", src);
 
        if (script_tag.readyState) {
            script_tag.onreadystatechange = function () {
                if (this.readyState == 'complete' || this.readyState == 'loaded') {
                    onLoad();
                }
            };
        } else {
            script_tag.onload = onLoad;
        }
        (document.getElementsByTagName("head")[0] || document.documentElement).appendChild(script_tag);
    }
 
    initjQuery();
    
    function initjQuery() {
        main();
    }

    /******** starting point for your widget ********/
    function main() {
        //your widget code goes here

        jQuery(document).ready(function($) {
            //or you could wait until the page is ready
            var $plugins = $('.sa-plugin');
            $plugins.each(function(index, plugin) {
                if (plugin) {
                    $(plugin).css({
                        'text-indect': '0px',
                        'margin': '0px',
                        'padding': '0px',
                        'border-style': 'none',
                        'line-height': 'normal',
                        'display': 'inline-block',
                        'background': 'transparent',
                    });

                    var $ifrm = $('<iframe>');
                    $ifrm.attr('frameborder', 0);
                    $ifrm.css({
                        'border-radius': '5px',
                        'box-shadow': '0px 2px 2px 0px rgba(0,0,0,0.3)',
                        'overflow': 'hidden'
                    });
                    $ifrm.attr('hspace', 0);
                    $ifrm.attr('vspace', 0);
                    $ifrm.attr('marginheight', 0);
                    $ifrm.attr('marginwidth', 0);
                    $ifrm.attr('scrolling', 'no');
                    $ifrm.attr('tabindex', 0);
                    var src = "https://send-anywhere.com/web/v1/widgets/";

                    switch ($(plugin).data('type')) {
                        case "send":
                            src += "plugin_s";
                            break;
                        case "receive":
                            src += "plugin_r";
                            break;
                        case "send-receive":
                            src += "plugin_sr";
                            break;
                    }
                    if ($(plugin).data('locale')) {
                        src += "/?lang=" + $plugin.data('locale');
                    }
                    $ifrm.attr('src', src);

                    $(plugin).append($ifrm);

                    var width = $(plugin).data('width');
                    if (width) {
                        $(plugin).css('width', width);
                        $ifrm.css('width', width);
                    }
                    var height = $(plugin).data('height');
                    if (height) {
                        $(plugin).css('height', height);
                        $ifrm.css('height', height);
                    }
                }
            });
        });
    }
 
})();
