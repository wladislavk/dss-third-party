var ClaimFormDataMapperHelper = {
    /**
     * "Expand" counters in values. Expand = parse a string and populate fields based on conventions over that string.
     *
     * There are only two types of counters:
     *
     * - Service lines:   "{%sl}" => 0..5
     * - Diagnosis codes: "{%dp}" => 0..11
     *
     * Service lines always comes first. "{%dp}" will never be parsed if "{%sl}" is NOT present
     *
     * @param array $map
     * @return array
     */
    expandMap: function ($map) {
        var $expandedMap = {};

        for (var $destinationPath in $map) {
            var $sourcePaths = $map[$destinationPath];

            if (!$.isArray($sourcePaths)) {
                $sourcePaths = [$sourcePaths];
            }

            /**
             * Detect if the current $path includes "service lines" indicators:
             *
             * %sl: service line number      (0-5 lines)
             * %dp: diagnosis pointer number (0-11 pointers)
             */
            var $extendedPaths = this.expandCounter($destinationPath, $sourcePaths, '%sl', 0, 5);

            // Temporary save the "$extendedPaths" variable, as we are going to rewrite it
            $expandedPaths = $extendedPaths;
            $extendedPaths = {};

            var $self = this;

            for (var $destination in $expandedPaths) {
                var $sources = $expandedPaths[$destination];

                // This method will return an array with (maybe) new keys and new elements
                var $newExtended = $self.expandCounter($destination, $sources, '%dp', 0, 11);

                // Merge the new keys/elements with the already processed elements
                $extendedPaths = $.extend($extendedPaths, $newExtended);
            }

            /**
             * If the $extendedPaths array changed then we have expanded changes
             *
             * Merge the new array to include the new keys.
             * Otherwise, just re-set the original values.
             */
            if (
                this.count($extendedPaths) > 1 ||
                    this.count(this.head($extendedPaths)) > this.count($sourcePaths)
                ) {
                $expandedMap = $.extend($expandedMap, $extendedPaths);
            } else {
                $expandedMap[$destinationPath] = $sourcePaths;
            }
        }

        // Flatten single item source arrays
        for (var $key in $expandedMap) {
            var $each = $expandedMap[$key];

            if ($.isArray($each) && this.count($each) === 1) {
                $expandedMap[$key] = this.head($each);
            }
        }

        return $expandedMap;
    },

    /**
     * Auxiliary function that expands a destination path (array key) and a collection of source paths (values from
     * the array item).
     *
     * ASSUME: lowercase marker means "0 based counter", uppercase marker means "1 based counter"
     *
     * Hydration will generate either new item elements (expands a string with a counter placeholder into the lines with
     * each corresponding number), or new elements AND new array keys (in case the destination path also needs to be
     * expanded).
     *
     * Because of this, this function always returns an array. This function works like we were passing an array with a
     * single element:
     *
     * [$destinationPath => [<$sourcePaths>]]
     *
     * @param string $destinationPath
     * @param array $sourcePaths
     * @param string $marker
     * @param int $start
     * @param int $end
     * @return array
     */
    expandCounter: function ($destinationPath, $sourcePaths, $marker, $start, $end) {
        var $expanded = {};
        var $pregMarker = new RegExp(
            "\\{" +
                $marker +
                "(?:" +
                "([+-])" +
                "(\\d+|\\\"[a-z]\\\")" +
                ")?" +
                "\\}"
        );

        if (!$.isArray($sourcePaths)) {
            $sourcePaths = [$sourcePaths];
        }

        /**
         * If the array key (destination path) does not have a placeholder, maybe some of the
         * array items (source paths) will have it.
         *
         * We must verify all of them. This revision will expand this:
         *
         * $map['all_service_lines'] = 'claim.service_lines.{%sl}';
         *      to:
         * $map['all_service_lines'] = ['claim.service_lines.0',
         *                              'claim.service_lines.1',
         *                              ...
         *                             ];
         */
        var $destinationMatch = $pregMarker.exec($destinationPath);

        if (!$destinationMatch) {
            $expanded[$destinationPath] = [];

            for (var $key in $sourcePaths) {
                var $source = $sourcePaths[$key];

                /**
                 * If the current source path does not have the counter placeholder, don't expand anything, skip
                 */
                var $sourceMatch = $pregMarker.exec($source);

                if (!$sourceMatch) {
                    $expanded[$destinationPath].push($source);
                    continue;
                }

                /**
                 * Turn a single source path into several lines
                 */
                for (var $n=$start;$n<=$end;$n++) {
                    $expanded[$destinationPath].push(this.replaceCounter($marker, [$n, $sourceMatch], $source));
                }
            }

            /**
             * Flatten the array if we only have a single element
             */
            if (this.count($expanded[$destinationPath]) === 1) {
                $expanded[$destinationPath] = $expanded[$destinationPath][0];
            }
        } else {
            /**
             * If the destination path contains a placeholder, the array will have new keys:
             *
             * $map['service_line_{%sl}'] = 'claim.service_lines.{%sl}';
             *      to:
             * $map['service_line_0'] = ['claim.service_lines.0'];
             * $map['service_line_1'] = ['claim.service_lines.1'];
             *      ...
             */
            for (var $n=$start;$n<=$end;$n++) {
                var $destination = this.replaceCounter($marker, [$n, $destinationMatch], $destinationPath);

                if (!$expanded.hasOwnProperty($destination)) {
                    $expanded[$destination] = [];
                }

                for (var $key in $sourcePaths) {
                    $source = $sourcePaths[$key];

                    $sourceMatch = $pregMarker.exec($source);
                    $expanded[$destination].push(this.replaceCounter($marker, [$n, $sourceMatch], $source));
                }
            }
        }

        return $expanded;
    },

    /**
     * Auxiliary function to replace markers, based on matches in regexp.
     *
     * Matches can be:
     * - solo marker      {%sl}
     * - marker with sum  {%sl+1}
     * - marker with text {%sl+a}
     *
     * The last type of marker, {%sl+"a"}, generates a sequence of letters, "a-f"
     *
     * @param string $marker
     * @param array $replaceConditions [$index, $regexpMatch]
     * @param string $target
     * @return string
     */
    replaceCounter: function ($marker, $replaceConditions, $target) {
        var $index = $replaceConditions[0];
        var $match = $replaceConditions[1];

        if (!$match) {
            return $target;
        }

        var $search = [ ['{', $marker, '}'].join('') ];
        var $replacement = [$index];

        if ($match[1]) {
            var $sign = $match[1];
            var $step = $sign === '+' ? 1 : -1;

            if ($match[2].match(/^"[a-z]"$/)) {
                var $symbol = $match[2];
                $index = String.fromCharCode($symbol.charCodeAt(1) + $step*$index);
            } else {
                var $symbol = parseInt($match[2]);
                $index += $step*$symbol;
            }

            $search.push(['{', $marker, $sign, $symbol, '}'].join(''));
            $replacement.push($index);
        }

        // This will replace only the first match
        for (var $n in $search) {
            $target = $target.replace($search[$n], $replacement[$n]);
        }

        return $target;
    },

    /**
     * Returns length of array, or object
     *
     * @param array|object $mixed
     * @returns integer
     */
    count: function ($mixed) {
        var $n = 0, $key;

        if ($.isArray($mixed)) {
            return $mixed.length;
        }

        if ($.isPlainObject($mixed)) {
            return Object.keys($mixed).length;
        }

        return 0;
    },

    /**
     * Returns first element of array or object, or null
     *
     * @param array|object $mixed
     * @returns mixed
     */
    head: function ($mixed) {
        if ($.isArray($mixed)) {
            return $mixed[0] || null;
        }

        if ($.isPlainObject($mixed) && !$.isEmptyObject($mixed)) {
            $mixed[Object.keys($mixed)[0]]
        }

        return null;
    },

    /**
     * Returns first element of array or object, or null
     *
     * @param array|object $mixed
     * @returns mixed
     */
    last: function ($mixed) {
        var keys;

        if ($.isArray($mixed)) {
            return $mixed.length ? $mixed[$mixed.length - 1] : null;
        }

        if ($.isPlainObject($mixed) && !$.isEmptyObject($mixed)) {
            keys = Object.keys($mixed);
            return keys.length ? $mixed[keys[keys.length - 1]] : null;
        }

        return null;
    },

    /**
     *
     * @param string dots
     * @returns string
     */
    dotNotationToBrackets: function (dots) {
        var segments = (dots || '').split('.'),
            concatenated = segments.shift();

        if (segments.length) {
            concatenated += ['[', segments.join(']['), ']'].join('');
        }

        return concatenated;
    }
}
