var __extends = this.__extends || function (d, b) {
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
}
var Brewery = (function (_super) {
    __extends(Brewery, _super);
    function Brewery() {
        _super.apply(this, arguments);

    }
    Brewery.prototype.title = function () {
        return this.get('title');
    };
    Brewery.prototype.beer_count = function () {
        return this.get('beer_count');
    };
    return Brewery;
})(Backbone.Model);
//@ sourceMappingURL=Brewery.js.map
