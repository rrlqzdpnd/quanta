$(document).ready(function(){
    $('.tooltips').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    $('a.scroll').click(function() {
        $('html, body').animate({
                scrollTop: $($(this).attr('href')).offset().top
            }, 600
        );
        return false;
    });

    jQuery.expr[':'].regex = function(elem, index, match) {
        var matchParams = match[3].split(','),
            validLabels = /^(data|css):/,
            attr = {
                method: matchParams[0].match(validLabels) ?
                        matchParams[0].split(':')[0] : 'attr',
                property: matchParams.shift().replace(validLabels,'')
            },
            regexFlags = 'ig',
            regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
        return regex.test(jQuery(elem)[attr.method](attr.property));
    };
});

