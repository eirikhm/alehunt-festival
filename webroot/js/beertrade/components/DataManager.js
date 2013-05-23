var DataManager = (function () {
    function DataManager() { }
    DataManager.prototype.loadData = function (callback, force) {
        if (typeof force === "undefined") { force = false; }
        var beerCollection = new BeerCollection();
        beerCollection.localStorage = new Backbone.LocalStorage("beers");
        beerCollection.fetch();
        var breweryCollection = new BreweryCollection();
        breweryCollection.localStorage = new Backbone.LocalStorage("breweries");
        breweryCollection.fetch();
        if(beerCollection.length && breweryCollection.length) {
            if(!force) {
                callback();
                return;
            }
        }
        $.getJSON('http://alehunt-web-src/haand/api.php?r=site/data', function (data) {
            var beers = data.beers;
            for(var i in beers) {
                beerCollection.add(new Beer(beers[i]));
            }
            var breweries = data.breweries;
            for(var i in breweries) {
                breweryCollection.add(new Brewery(breweries[i]));
            }
            beerCollection.each(function (model) {
                model.save();
            });
            breweryCollection.each(function (model) {
                model.save();
            });
            callback();
        });
    };
    return DataManager;
})();
//@ sourceMappingURL=DataManager.js.map
