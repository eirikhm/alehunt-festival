///<reference path='../d/backbone.d.ts' />
///<reference path='../d/jquery.d.ts' />
///<reference path='../d/dustjs-linkedin.d.ts' />
///<reference path='../models/Beer.ts' />
///<reference path='../collections/BreweryCollection.ts' />
///<reference path='../collections/BeerCollection.ts' />
class BreweryView extends Backbone.View {

    events = {
        'click .button-prev' : 'clickBack',
        'click .button.more' : 'clickMore',
        'click .beer' : 'clickBeer'
    };


    clickBack()
    {
        Backbone.history.navigate('main', {trigger: true});
        return false;
    }

    clickMore()
    {
        if (this.$('.content.beer-list').is(':visible'))
        {
            this.$('.content.beer-list').hide();
            this.$('.content.info').show();
            this.$('.button.more').html('Liste');
        }
        else
        {
            this.$('.content.beer-list').show();
            this.$('.content.info').hide();
            this.$('.button.more').html('Info');
        }

    }
    clickBeer(e:MouseEvent)
    {
        var id = $(e.currentTarget).attr('data-id');
        Backbone.history.navigate('beer/'+id, {trigger: true});
    }

    render(id:number)
    {
        var self = this;
        var beer = new Beer({title:"Initial value",abv:150000});

        var beers = new BeerCollection();
        beers.localStorage = new Backbone.LocalStorage("beers");
        beers.fetch();

        var b2 = beers.where({brewer_id:id+""});
        var data = {beers: b2,brewery:this.getBrewery(id).attributes};

        dust.render("page-brewery", data, function (err, res)
        {
            self.$el.html(res);
        });

        return this;
    }

    getBrewery(id:number)
    {
        var breweries = new BreweryCollection();
        breweries.localStorage = new Backbone.LocalStorage("breweries");
        breweries.fetch();

        var x = breweries.get(id);
        return x;
    }
}