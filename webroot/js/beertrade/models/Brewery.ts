///<reference path='../d/backbone.d.ts' />
///<reference path='../d/jquery.d.ts' />
class Brewery extends Backbone.Model
{
    title()
    {
        return this.get('title');
    }

    beer_count()
    {
        return this.get('beer_count');
    }
}
