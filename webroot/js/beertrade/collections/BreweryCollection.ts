///<reference path='../d/backbone.d.ts' />
///<reference path='../d/jquery.d.ts' />
///<reference path='../models/Brewery.ts' />

class BreweryCollection extends Backbone.Collection
{
    constructor()
    {
        super();
        this.model = Brewery;
    }
}