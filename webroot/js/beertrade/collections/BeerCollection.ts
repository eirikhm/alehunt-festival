///<reference path='../d/backbone.d.ts' />
///<reference path='../d/jquery.d.ts' />
///<reference path='../models/Beer.ts' />
class BeerCollection extends Backbone.Collection
{

    constructor()
    {
        super();
        this.model = Beer;
    }
}