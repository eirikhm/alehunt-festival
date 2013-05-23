///<reference path='d/backbone.d.ts' />
///<reference path='d/jquery.d.ts' />
///<reference path='App.ts' />

///<reference path='views/BreweryView.ts' />
///<reference path='views/MainView.ts' />
///<reference path='views/BeerView.ts' />

class Router extends Backbone.Router {
    routes:any;

    app:App;

    breweryView:BreweryView;
    beerView:BeerView;
    mainView:MainView;

    content:JQuery;

    constructor(appInstance:App, options?:Backbone.RouterOptions)
    {
        this.routes = {
            "": "main",
            "main": "main",
            "brewery/:id": "brewery",
            "beer/:id": "beer"
        };
        super(options);
        this.app = appInstance;
        this.content = $("body");
    }

    main()
    {
        if (!this.mainView)
        {
            this.mainView = new MainView();
            this.mainView.render();
        }
        this.content.html(this.mainView.el);
        this.mainView.delegateEvents();
    }

    brewery(id:number)
    {
        if (!this.breweryView)
        {
            this.breweryView = new BreweryView();

        }
        this.breweryView.render(id);
        this.content.html(this.breweryView.el);
        this.breweryView.delegateEvents();
    }


    beer(id:number)
    {
        if (!this.beerView)
        {
            this.beerView = new BeerView();

        }
        this.beerView.render(id);
        this.content.html(this.beerView.el);
        this.beerView.delegateEvents();
    }
}

