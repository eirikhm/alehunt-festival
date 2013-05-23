///<reference path='../d/backbone.d.ts' />
///<reference path='../d/jquery.d.ts' />
///<reference path='../d/dustjs-linkedin.d.ts' />
///<reference path='../models/Beer.ts' />
///<reference path='../collections/BeerCollection.ts' />
class BeerView extends Backbone.View {

    events = {
        'click .button-prev' : 'clickBack'
    };

    beer:Beer;

    clickBack()
    {
        Backbone.history.navigate('brewery/'+this.beer.get('brewer_id'), {trigger: true});
        return false;
    }

    render(id:number)
    {
        var self = this;
        var beers = new BeerCollection();
        beers.localStorage = new Backbone.LocalStorage("beers");
        beers.fetch();

        this.beer = this.getBeer(id);

        var data = {beer:this.beer.attributes};

        dust.render("page-beer", data, function (err, res)
        {
            self.$el.html(res);
        });

        return this;
    }

    getBeer(id:number)
    {
        var beers = new BeerCollection();
        beers.localStorage = new Backbone.LocalStorage("beers");
        beers.fetch();
        return beers.get(id);
    }
}