var __extends = this.__extends || function (d, b) {
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
}
var BreweryView = (function (_super) {
    __extends(BreweryView, _super);
    function BreweryView() {
        _super.apply(this, arguments);

        this.events = {
            'click .button-prev': 'clickBack',
            'click .button.more': 'clickMore',
            'click .beer': 'clickBeer'
        };
    }
    BreweryView.prototype.clickBack = function () {
        Backbone.history.navigate('main', {
            trigger: true
        });
        return false;
    };
    BreweryView.prototype.clickMore = function () {
        if(this.$('.content.beer-list').is(':visible')) {
            this.$('.content.beer-list').hide();
            this.$('.content.info').show();
            this.$('.button.more').html('Liste');
        } else {
            this.$('.content.beer-list').show();
            this.$('.content.info').hide();
            this.$('.button.more').html('Info');
        }
    };
    BreweryView.prototype.clickBeer = function (e) {
        var id = $(e.currentTarget).attr('data-id');
        Backbone.history.navigate('beer/' + id, {
            trigger: true
        });
    };
    BreweryView.prototype.render = function (id) {
        var self = this;
        var beer = new Beer({
            title: "Initial value",
            abv: 150000
        });
        var beers = new BeerCollection();
        beers.localStorage = new Backbone.LocalStorage("beers");
        beers.fetch();
        var b2 = beers.where({
            brewer_id: id + ""
        });
        var data = {
            beers: b2,
            brewery: this.getBrewery(id).attributes
        };
        dust.render("page-brewery", data, function (err, res) {
            self.$el.html(res);
        });
        return this;
    };
    BreweryView.prototype.getBrewery = function (id) {
        var breweries = new BreweryCollection();
        breweries.localStorage = new Backbone.LocalStorage("breweries");
        breweries.fetch();
        var x = breweries.get(id);
        return x;
    };
    return BreweryView;
})(Backbone.View);
//@ sourceMappingURL=BreweryView.js.map
