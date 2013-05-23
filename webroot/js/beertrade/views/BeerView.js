var __extends = this.__extends || function (d, b) {
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
}
var BeerView = (function (_super) {
    __extends(BeerView, _super);
    function BeerView() {
        _super.apply(this, arguments);

        this.events = {
            'click .button-prev': 'clickBack'
        };
    }
    BeerView.prototype.clickBack = function () {
        Backbone.history.navigate('brewery/' + this.beer.get('brewer_id'), {
            trigger: true
        });
        return false;
    };
    BeerView.prototype.render = function (id) {
        var self = this;
        var beers = new BeerCollection();
        beers.localStorage = new Backbone.LocalStorage("beers");
        beers.fetch();
        this.beer = this.getBeer(id);
        var data = {
            beer: this.beer.attributes
        };
        dust.render("page-beer", data, function (err, res) {
            self.$el.html(res);
        });
        return this;
    };
    BeerView.prototype.getBeer = function (id) {
        var beers = new BeerCollection();
        beers.localStorage = new Backbone.LocalStorage("beers");
        beers.fetch();
        return beers.get(id);
    };
    return BeerView;
})(Backbone.View);
//@ sourceMappingURL=BeerView.js.map
