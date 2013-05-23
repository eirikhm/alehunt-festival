///<reference path='d/backbone.d.ts' />
///<reference path='d/jquery.d.ts' />
///<reference path='d/dustjs-linkedin.d.ts' />
///<reference path='Router.ts' />
///<reference path='models/Beer.ts' />
///<reference path='models/Brewery.ts' />
///<reference path='collections/BeerCollection.ts' />
///<reference path='collections/BreweryCollection.ts' />
///<reference path='components/DataManager.ts' />


class App
{
    views: {};
    models: {};
    router: Router;

    constructor()
    {
        var self = this;
        rivets.configure({
            adapter: {
                subscribe: function(obj, keypath, callback) {
                    obj.on('change:' + keypath, callback)
                },
                unsubscribe: function(obj, keypath, callback) {
                    obj.off('change:' + keypath, callback)
                },
                read: function(obj, keypath) {
                    return obj.get(keypath)

                },
                publish: function(obj, keypath, value) {
                    obj.set(keypath, value)
                }
            }
        });

        rivets.formatters.moneyNok = {
            read: function(value) {
                return value/100 + " NOK";
            },
            publish: function(value) {
                return value*100;
            }
        }

        var dm = new DataManager();
        dm.loadData(function(){
            self.loadTemplates('tpl.php',function(){
                self.router = new Router(self);
                Backbone.history.start({pushState: false});
            });
        });
    }
    loadTemplates (url, callback)
    {
        var templateId = null,
            templateMarkup = null;
        $.get(url, function (data)
        {

            data =  $.parseHTML(data);
            $(data).each(function (index, element)
            {
                if (element.nodeName == 'SCRIPT')
                {
                    templateId = element.id;
                    templateMarkup = $(element).html();

                    var t = dust.compile(templateMarkup, templateId);
                    dust.loadSource(t);
                }
            });

            if (typeof callback === 'function')
            {
                callback();
            }
        });
    }
}