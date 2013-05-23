var __extends = this.__extends || function (d, b) {
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
}
var Beer = (function (_super) {
    __extends(Beer, _super);
    function Beer() {
        _super.apply(this, arguments);

    }
    Beer.prototype.title = function () {
        return this.get('title');
    };
    Beer.prototype.style = function () {
        return this.get('style');
    };
    Beer.prototype.abv = function () {
        return this.get('abv');
    };
    return Beer;
})(Backbone.Model);
//@ sourceMappingURL=Beer.js.map
