var __extends = this.__extends || function (d, b) {
    function __() { this.constructor = d; }
    __.prototype = b.prototype;
    d.prototype = new __();
}
var Router = (function (_super) {
    __extends(Router, _super);
    function Router(appInstance, options) {
        this.routes = {
            "": "main",
            "main": "main",
            "brewery/:id": "brewery",
            "beer/:id": "beer"
        };
        _super.call(this, options);
        this.app = appInstance;
        this.content = $("body");
    }
    Router.prototype.main = function () {
        if(!this.mainView) {
            this.mainView = new MainView();
            this.mainView.render();
        }
        this.content.html(this.mainView.el);
        this.mainView.delegateEvents();
    };
    Router.prototype.brewery = function (id) {
        if(!this.breweryView) {
            this.breweryView = new BreweryView();
        }
        this.breweryView.render(id);
        this.content.html(this.breweryView.el);
        this.breweryView.delegateEvents();
    };
    Router.prototype.beer = function (id) {
        if(!this.beerView) {
            this.beerView = new BeerView();
        }
        this.beerView.render(id);
        this.content.html(this.beerView.el);
        this.beerView.delegateEvents();
    };
    return Router;
})(Backbone.Router);
//@ sourceMappingURL=Router.js.map
