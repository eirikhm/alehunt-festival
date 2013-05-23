var __extends = this.__extends || function (d, b) {
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
}
var BeerCollection = (function (_super) {
    __extends(BeerCollection, _super);
    function BeerCollection() {
        _super.call(this);
        this.model = Beer;
    }
    return BeerCollection;
})(Backbone.Collection);
//@ sourceMappingURL=BeerCollection.js.map
