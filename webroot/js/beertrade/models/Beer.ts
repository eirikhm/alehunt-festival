///<reference path='../d/backbone.d.ts' />
///<reference path='../d/jquery.d.ts' />
class Beer extends Backbone.Model
{
    title()
    {
        return this.get('title');
    }

    style()
    {
        return this.get('style');
    }

    abv()
    {
        return this.get('abv');
    }
}