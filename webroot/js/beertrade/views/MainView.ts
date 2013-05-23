///<reference path='../d/backbone.d.ts' />
///<reference path='../d/jquery.d.ts' />
///<reference path='../d/dustjs-linkedin.d.ts' />
///<reference path='../d/humane.d.ts' />
///<reference path='../models/Beer.ts' />
///<reference path='../collections/BreweryCollection.ts' />
///<reference path='../components/DataManager.ts' />
class MainView extends Backbone.View {

    events = {
        'click .brewery' : 'clickBrewery',
        'click .button.refresh' : 'clickRefresh'
    };

    render()
    {
        var self = this;
        var breweries = new BreweryCollection();
        breweries.localStorage = new Backbone.LocalStorage("breweries");
        breweries.fetch();

        var data = {breweries: breweries.models}
        dust.render("page-main", data, function (err, res)
        {
            self.$el.html(res);
        });

        return this;
    }

    clickBrewery(e:MouseEvent)
    {
        var id = $(e.currentTarget).attr('data-id');
        Backbone.history.navigate('brewery/'+id, {trigger: true});
    }

    clickRefresh(e:MouseEvent)
    {
        var self = this;
        var dm = new DataManager();
        alert('Dette kan ta litt tid, vent på bekreftelse.');

        dm.loadData(function(){
            self.render();
            alert('Oppdatering fullført!');
        },true);
    }
}