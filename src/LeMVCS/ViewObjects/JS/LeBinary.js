/**
 * Created by robert on 9/4/2019.
 */
var LeBinary = {
    /**
     * @param number integer
     * @returns {Array}
     *
     * @Note: when using Math.max() with an array, the array variable must be preceded by an ellipses.
     * @example https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/max
     */
    getBinaries: function (number) {
        var output = [];
        var getBinary = function (number) {
            var bits = [];
            for (var $i = 1; $i <= number; $i *= 2) {
                bits.push($i);
            }
            var max = Math.max(...bits);
            output.push(max);
            var remainder = number - max;
            if (1 < remainder) {
                getBinary(remainder);
            } else if (1 === remainder) {
                output.push(1);
            }
            return output;
        };
        return getBinary(number);
    }
};
