$(document).ready(function(){
    function canNestBlocks ($node) {
        return $node.is('p, table, thead, tbody, tfooter, tr, td, ul, li, b, strong, i');
    }

    function ignoreNestedText ($node) {
        return $node.is('div, table, thead, tbody, tfooter, tr, ul');
    }

    function decorateText (node) {
        var $collection = $(),
            sections = node.data.match(/([\s\r\n\t]+|[^\s\r\n\t]+)/g);

        for (var n in sections) {
            $collection = $collection.add($('<span class="plain-text-helper"></span>').text(sections[n]));
        }

        $(node).replaceWith($collection);
    }

    function decorate ($root) {
        var contents = $root.contents();

        contents.each(function(){
            var $this = $(this);

            if (this.nodeType === 3 && !ignoreNestedText($root)) {
                decorateText(this);
            } else if (canNestBlocks($this)) {
                decorate($this);
            }
        });
    }

    function nodeHeight ($node) {
        if ($node.is('br, p:empty')) {
            return parseFloat($node.css('line-height'));
        }

        return $node.innerHeight();
    }

    function nodeOffset ($node, offset) {
        return $node.offset().top + parseFloat($node.css('margin-top')) - offset;
    }

    function deepWalk ($root, doOnDeepest) {
        var children = $root.children(),
            promises = [];

        children.each(function(){
            var $this = $(this);

            if (canNestBlocks($this) && $this.children().length) {
                deepWalk($this, doOnDeepest);
            } else {
                doOnDeepest($this);
            }
        });

        $.when.apply($, promises);
    }

    function doSomething ($target) {
        var promises = [];

        function deferCall (callback) {
            return $.Deferred(function(deferred){
                callback();

                setTimeout(deferred.resolve, 1000);
            });
        }

        function doSingleDecorate (index, node) {
            promises.push(deferCall(function(){
                decorate($(node));
            }));
        }

        function doDecorate() {
            $target.each(doSingleDecorate);
        }

        function realSingleDeepWalk (node) {
            var $height = $(node),
                $margin = $height.find('.preview-wrapper'),
                $each = $height.find('.preview-inner-wrapper');

            var offset = $each.offset().top,
                marginTop = parseFloat($margin.css('margin-top')),
                marginBottom = parseFloat($margin.css('margin-bottom')),
                pageHeight = parseFloat($height.css('min-height'))
                    - marginTop - marginBottom,
                referencePoint = pageHeight;

            var page = 1;

            var doOnDeepest = function ($node) {
                var position = nodeOffset($node, offset),
                    fullPosition = position + nodeHeight($node);

                $node.addClass('pagination-reference');

                if (fullPosition >= referencePoint) {
                    $height.find(['.preview-page-break.break', page].join('-'))
                        .css('top', position + marginTop)
                        .attr('title', [position.toFixed(5), marginTop.toFixed(5)].join(' - '));

                    referencePoint = position + pageHeight;
                    page++;
                }

                if (fullPosition < referencePoint) {
                    $node.addClass(['page', 'number', page].join('-'));
                    $node.addClass(['page', 'odd', page % 2].join('-'));
                    $node.attr('title', [position.toFixed(5), fullPosition.toFixed(5)].join(' - '));
                }
            };

            decorate($each);
            deepWalk($each, doOnDeepest);
        }

        function doSingleDeepWalk (index, node) {
            promises.push(deferCall(function(){
                realSingleDeepWalk($(node));
            }));
        }

        function doDeepWalk () {
            $target.each(doSingleDeepWalk);
        }

        doDecorate();
        doDeepWalk();

        $.when.apply($, promises);
    }

    // Don't so something until we know pagination is reliable
    // doSomething($('.preview-letter'));
});
