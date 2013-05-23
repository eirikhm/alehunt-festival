var __extends = this.__extends || function (d, b) {
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
}
var MainView = (function (_super) {
    __extends(MainView, _super);
    function MainView() {
        _super.apply(this, arguments);

        this.events = {
            'click .brewery': 'clickBrewery',
            'click .button.refresh': 'clickRefresh'
        };
    }
    MainView.prototype.render = function () {
        var self = this;
        var breweries = new BreweryCollection();
        breweries.localStorage = new Backbone.LocalStorage("breweries");
        breweries.fetch();
        var data = {
            breweries: breweries.models
        };
        dust.render("page-main", data, function (err, res) {
            self.$el.html(res);
        });
        return this;
    };
    MainView.prototype.clickBrewery = function (e) {
        var id = $(e.currentTarget).attr('data-id');
        Backbone.history.navigate('brewery/' + id, {
            trigger: true
        });
    };
    MainView.prototype.clickRefresh = function (e) {
        var self = this;
        var dm = new DataManager();
        alert('Dette kan ta litt tid, vent på bekreftelse.');
        dm.loadData(function () {
            self.render();
            alert('Oppdatering fullført!');
        }, true);
    };
    return MainView;
})(Backbone.View);
//@ sourceMappingURL=MainView.js.map
